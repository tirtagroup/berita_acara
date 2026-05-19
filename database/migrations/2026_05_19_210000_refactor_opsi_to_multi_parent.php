<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Refactor: ms_ba_kategori_opsi dari 1:N (1 opsi punya 1 kategori) jadi N:M
 * (1 opsi bisa attach ke banyak kategori).
 *
 * Sebelum:
 *   ms_ba_kategori_opsi (id, kategori_id FK, kode, deskripsi, sort_order, active)
 *
 * Sesudah:
 *   ms_ba_kategori_opsi      (id, deskripsi UNIQUE, active)
 *   ms_kategori_opsi_mapping (id, kategori_id FK, opsi_id FK, kode, sort_order, active)
 *                            UNIQUE(kategori_id, opsi_id)
 *
 * Data existing di-dedupe: opsi dengan deskripsi sama (case-insensitive) jadi 1 row,
 * mapping ke kategori asalnya disimpan di pivot baru.
 *
 * Down: reverse, tapi LOSSY — opsi yang sebelumnya dipakai banyak kategori
 * akan diduplikasi kembali per kategori dari pivot.
 */
return new class extends Migration
{
    public function up()
    {
        // 1. Backup data opsi lama ke memory
        $oldOpsi = DB::table('ms_ba_kategori_opsi')->get();

        // 2. Drop FK constraint pada tr_ba_kategori_d.opsi_id (sementara)
        Schema::table('tr_ba_kategori_d', function (Blueprint $table) {
            $table->dropForeign(['opsi_id']);
        });

        // 3. Drop tabel opsi lama
        Schema::dropIfExists('ms_ba_kategori_opsi');

        // 4. Buat ulang ms_ba_kategori_opsi dengan schema baru (tanpa kategori_id)
        Schema::create('ms_ba_kategori_opsi', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi', 500)->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // 5. Buat pivot ms_kategori_opsi_mapping
        Schema::create('ms_kategori_opsi_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('opsi_id');
            $table->string('kode', 10);
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('ms_ba_kategori')->cascadeOnDelete();
            $table->foreign('opsi_id')->references('id')->on('ms_ba_kategori_opsi')->cascadeOnDelete();
            $table->unique(['kategori_id', 'opsi_id'], 'uq_kategori_opsi');
        });

        // 6. Re-add FK pada tr_ba_kategori_d.opsi_id
        Schema::table('tr_ba_kategori_d', function (Blueprint $table) {
            $table->foreign('opsi_id')->references('id')->on('ms_ba_kategori_opsi')->nullOnDelete();
        });

        // 7. Migrasi data: dedupe by deskripsi, insert ke opsi baru + mapping
        $now = now();
        $dedupedMap = []; // [normalized_deskripsi => new_opsi_id]

        foreach ($oldOpsi as $row) {
            $key = mb_strtolower(trim($row->deskripsi));

            if (!isset($dedupedMap[$key])) {
                $newId = DB::table('ms_ba_kategori_opsi')->insertGetId([
                    'deskripsi'  => $row->deskripsi,
                    'active'     => $row->active,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $dedupedMap[$key] = $newId;
            }

            DB::table('ms_kategori_opsi_mapping')->insert([
                'kategori_id' => $row->kategori_id,
                'opsi_id'     => $dedupedMap[$key],
                'kode'        => $row->kode,
                'sort_order'  => $row->sort_order ?? 0,
                'active'      => $row->active,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }

    public function down()
    {
        // Backup data mapping & opsi baru
        $mappings = DB::table('ms_kategori_opsi_mapping')
                      ->join('ms_ba_kategori_opsi', 'ms_kategori_opsi_mapping.opsi_id', '=', 'ms_ba_kategori_opsi.id')
                      ->select(
                          'ms_kategori_opsi_mapping.kategori_id',
                          'ms_kategori_opsi_mapping.kode',
                          'ms_kategori_opsi_mapping.sort_order',
                          'ms_kategori_opsi_mapping.active',
                          'ms_ba_kategori_opsi.deskripsi'
                      )
                      ->get();

        // Drop FK pada tr_ba_kategori_d.opsi_id (sementara)
        Schema::table('tr_ba_kategori_d', function (Blueprint $table) {
            $table->dropForeign(['opsi_id']);
        });

        // Drop tabel baru
        Schema::dropIfExists('ms_kategori_opsi_mapping');
        Schema::dropIfExists('ms_ba_kategori_opsi');

        // Recreate schema lama
        Schema::create('ms_ba_kategori_opsi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->string('kode', 10);
            $table->string('deskripsi', 500);
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('ms_ba_kategori')->cascadeOnDelete();
            $table->unique(['kategori_id', 'kode']);
        });

        // Re-add FK pada tr_ba_kategori_d.opsi_id
        Schema::table('tr_ba_kategori_d', function (Blueprint $table) {
            $table->foreign('opsi_id')->references('id')->on('ms_ba_kategori_opsi')->nullOnDelete();
        });

        // Restore data (lossy: setiap mapping row jadi 1 opsi row terpisah)
        $now = now();
        foreach ($mappings as $m) {
            DB::table('ms_ba_kategori_opsi')->insert([
                'kategori_id' => $m->kategori_id,
                'kode'        => $m->kode,
                'deskripsi'   => $m->deskripsi,
                'sort_order'  => $m->sort_order,
                'active'      => $m->active,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
};
