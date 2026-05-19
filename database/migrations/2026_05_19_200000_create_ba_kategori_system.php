<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Sistem Kategori Berita Acara (tag-based, multi-kategori).
 *
 * Membuat 5 tabel:
 *   1. ms_business_unit         — master Business Unit
 *   2. ms_ba_kategori           — master kategori (universal, dengan parent_id self-ref)
 *   3. ms_bu_kategori_mapping   — pivot N:M antara BU dan Kategori, dengan kolom level
 *   4. ms_ba_kategori_opsi      — opsi/kasus per kategori (unified)
 *   5. tr_ba_kategori_d         — pivot BA × Kategori (kosong, diisi runtime)
 *
 * Tidak menyentuh tabel existing (Tr_Ba_Main_New, Cek* flags, dll).
 *
 * Spec lengkap: docs/categories.md, docs/database.md, docs/ui-design.md
 */
return new class extends Migration
{
    public function up()
    {
        // 1. ms_business_unit
        Schema::create('ms_business_unit', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('nama', 100);
            $table->string('deskripsi', 255)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // 2. ms_ba_kategori
        Schema::create('ms_ba_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('nama', 100);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('ms_ba_kategori')->nullOnDelete();
        });

        // 3. ms_bu_kategori_mapping
        Schema::create('ms_bu_kategori_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bu_id');
            $table->unsignedBigInteger('kategori_id');
            $table->enum('level', ['wajib', 'disarankan', 'opsional'])->default('opsional');
            $table->timestamps();

            $table->foreign('bu_id')->references('id')->on('ms_business_unit')->cascadeOnDelete();
            $table->foreign('kategori_id')->references('id')->on('ms_ba_kategori')->cascadeOnDelete();
            $table->unique(['bu_id', 'kategori_id']);
        });

        // 4. ms_ba_kategori_opsi
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

        // 5. tr_ba_kategori_d (pivot BA × kategori dengan opsi yang dipilih)
        Schema::create('tr_ba_kategori_d', function (Blueprint $table) {
            $table->id();
            $table->string('tr_ba_main_code', 100)->index();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('opsi_id')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('ms_ba_kategori')->restrictOnDelete();
            $table->foreign('opsi_id')->references('id')->on('ms_ba_kategori_opsi')->nullOnDelete();
            $table->index(['tr_ba_main_code', 'kategori_id']);
        });

        // ============================================================
        // SEED DATA
        // ============================================================
        $now = now();

        // --- Seed ms_business_unit (3 BU) ---
        DB::table('ms_business_unit')->insert([
            ['id' => 1, 'kode' => 'LAKA',  'nama' => 'LAKA Truck',      'deskripsi' => 'Kecelakaan kendaraan operasional — driver & truck', 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'kode' => 'FNB',   'nama' => 'FnB',             'deskripsi' => 'Food & Beverage — gerai/restoran',                  'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'kode' => 'OP_HR', 'nama' => 'Operation / HR',  'deskripsi' => 'HR pusat & operasi kantor',                         'active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // --- Seed ms_ba_kategori (14 kategori) ---
        DB::table('ms_ba_kategori')->insert([
            ['id' =>  1, 'kode' => 'LAKA_PENYEBAB',        'nama' => 'Laka Penyebab',         'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  2, 'kode' => 'PELANGGARAN_SOP',      'nama' => 'Pelanggaran SOP',       'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  3, 'kode' => 'FRAUD',                'nama' => 'Fraud',                 'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  4, 'kode' => 'TEMUAN_KASUS',         'nama' => 'Temuan Kasus',          'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  5, 'kode' => 'INDISIPLINER_ETIKA',   'nama' => 'Indisipliner / Etika',  'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  6, 'kode' => 'MENOLAK_TUGAS',        'nama' => 'Menolak Tugas',         'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  7, 'kode' => 'KERUSAKAN_KEHILANGAN', 'nama' => 'Kerusakan / Kehilangan','parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  8, 'kode' => 'KRIMINAL',             'nama' => 'Kriminal',              'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' =>  9, 'kode' => 'KOMPLAIN_CUSTOMER',    'nama' => 'Komplain Customer',     'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'kode' => 'KESALAHAN_ADMIN',      'nama' => 'Kesalahan Admin',       'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 11, 'kode' => 'LOGISTIK',             'nama' => 'Logistik',              'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 12, 'kode' => 'KUALITAS_MAKANAN',     'nama' => 'Kualitas Makanan',      'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 13, 'kode' => 'PELAYANAN',            'nama' => 'Pelayanan',             'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 14, 'kode' => 'DISIPLIN_OPERASIONAL', 'nama' => 'Disiplin Operasional',  'parent_id' => null, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // --- Seed ms_bu_kategori_mapping (draft level — user bisa edit via master nanti) ---
        $mappings = [
            // BU LAKA
            [1,  1, 'wajib'],       // LAKA → Laka Penyebab
            [1,  2, 'disarankan'],  // LAKA → Pelanggaran SOP
            [1,  3, 'opsional'],    // LAKA → Fraud
            [1,  4, 'opsional'],    // LAKA → Temuan Kasus
            [1,  5, 'opsional'],    // LAKA → Indisipliner
            [1,  6, 'opsional'],    // LAKA → Menolak Tugas
            [1,  7, 'disarankan'],  // LAKA → Kerusakan/Kehilangan
            [1,  8, 'opsional'],    // LAKA → Kriminal
            [1,  9, 'opsional'],    // LAKA → Komplain Customer
            [1, 10, 'opsional'],    // LAKA → Kesalahan Admin
            [1, 14, 'disarankan'],  // LAKA → Disiplin Operasional

            // BU FNB
            [2,  2, 'disarankan'],  // FNB → Pelanggaran SOP
            [2,  3, 'opsional'],    // FNB → Fraud
            [2,  4, 'opsional'],    // FNB → Temuan Kasus
            [2,  5, 'opsional'],    // FNB → Indisipliner
            [2,  6, 'opsional'],    // FNB → Menolak Tugas
            [2,  7, 'disarankan'],  // FNB → Kerusakan/Kehilangan
            [2,  8, 'opsional'],    // FNB → Kriminal
            [2,  9, 'disarankan'],  // FNB → Komplain Customer
            [2, 10, 'opsional'],    // FNB → Kesalahan Admin
            [2, 11, 'wajib'],       // FNB → Logistik
            [2, 12, 'wajib'],       // FNB → Kualitas Makanan
            [2, 13, 'wajib'],       // FNB → Pelayanan
            [2, 14, 'wajib'],       // FNB → Disiplin Operasional

            // BU OP_HR
            [3,  1, 'opsional'],    // OP_HR → Laka Penyebab
            [3,  2, 'disarankan'],  // OP_HR → Pelanggaran SOP
            [3,  3, 'disarankan'],  // OP_HR → Fraud
            [3,  4, 'disarankan'],  // OP_HR → Temuan Kasus
            [3,  5, 'disarankan'],  // OP_HR → Indisipliner
            [3,  6, 'disarankan'],  // OP_HR → Menolak Tugas
            [3,  7, 'disarankan'],  // OP_HR → Kerusakan/Kehilangan
            [3,  8, 'opsional'],    // OP_HR → Kriminal
            [3,  9, 'opsional'],    // OP_HR → Komplain Customer
            [3, 10, 'disarankan'],  // OP_HR → Kesalahan Admin
            [3, 14, 'opsional'],    // OP_HR → Disiplin Operasional
        ];

        $mappingRows = [];
        foreach ($mappings as [$buId, $katId, $level]) {
            $mappingRows[] = [
                'bu_id' => $buId,
                'kategori_id' => $katId,
                'level' => $level,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('ms_bu_kategori_mapping')->insert($mappingRows);

        // --- Seed ms_ba_kategori_opsi (43 opsi untuk 7 kategori yang sudah punya data) ---
        $opsiData = [
            // kategori_id => [ [kode, deskripsi], ... ]
            1 => [ // LAKA_PENYEBAB
                ['0', 'None'],
                ['1', 'Mengakibatkan laka (driver kita yang salah)'],
                ['2', 'Diakibatkan pihak lain (third party fault)'],
                ['3', 'Tabrak lari (pelaku kabur / tidak diketahui)'],
                ['4', 'Single vehicle / self-accident (terguling, masuk parit, tergelincir)'],
                ['5', 'Kontribusi bersama (joint fault — kedua pihak punya andil)'],
                ['6', 'Force majeure (bencana alam, kondisi luar kendali)'],
            ],
            2 => [ // PELANGGARAN_SOP
                ['0', 'None'],
                ['1', 'SOP dilanggar'],
                ['2', 'SOP tidak dikerjakan'],
                ['3', 'Tidak mengerti SOP'],
                ['4', 'SOP terpaksa dilanggar'],
            ],
            7 => [ // KERUSAKAN_KEHILANGAN
                ['0', 'None'],
                ['1', 'Alat rusak'],
                ['2', 'Alat hilang'],
            ],
            11 => [ // LOGISTIK
                ['0', 'None'],
                ['1', 'Barang tidak datang'],
                ['2', 'Barang datang rusak'],
                ['3', 'Terima barang kurang'],
                ['4', 'Lupa order'],
                ['5', 'Kurang order'],
                ['6', 'Salah order'],
            ],
            12 => [ // KUALITAS_MAKANAN
                ['0', 'None'],
                ['1', 'Makanan basi'],
                ['2', 'Ada serangga'],
                ['3', 'Tidak enak'],
                ['4', 'Salah kirim'],
            ],
            13 => [ // PELAYANAN
                ['0', 'None'],
                ['1', 'Makanan terlambat'],
                ['2', 'Salah order'],
                ['3', 'Salah buat'],
                ['4', 'Salah kirim'],
                ['5', 'Tumpah'],
                ['6', 'Tidak ramah'],
                ['7', 'Lama tidak datang ke meja'],
                ['8', 'Utensil tidak bersih'],
                ['9', 'Meja tidak bersih'],
            ],
            14 => [ // DISIPLIN_OPERASIONAL
                ['0', 'None'],
                ['1', 'Terlambat lebih dari 15 menit'],
                ['2', 'Tidak ada di station'],
                ['3', 'Tidak masuk tanpa kabar'],
                ['4', 'Lebih dari 3 kali absen 1 bulan'],
                ['5', 'Terlambat lebih dari 5 kali 1 bulan'],
            ],
        ];

        $opsiRows = [];
        foreach ($opsiData as $katId => $opsiList) {
            foreach ($opsiList as $sort => [$kode, $deskripsi]) {
                $opsiRows[] = [
                    'kategori_id' => $katId,
                    'kode' => $kode,
                    'deskripsi' => $deskripsi,
                    'sort_order' => $sort,
                    'active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('ms_ba_kategori_opsi')->insert($opsiRows);

        // Catatan: 7 kategori sisanya (Fraud, Temuan Kasus, Indisipliner, Menolak Tugas,
        // Kriminal, Komplain Customer, Kesalahan Admin) sengaja dibiarkan tanpa opsi —
        // diisi oleh admin via halaman master kategori di UI.
    }

    public function down()
    {
        // Drop dalam urutan terbalik (anak dulu, induk belakangan)
        Schema::dropIfExists('tr_ba_kategori_d');
        Schema::dropIfExists('ms_ba_kategori_opsi');
        Schema::dropIfExists('ms_bu_kategori_mapping');
        Schema::dropIfExists('ms_ba_kategori');
        Schema::dropIfExists('ms_business_unit');
    }
};
