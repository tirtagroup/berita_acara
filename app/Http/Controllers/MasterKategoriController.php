<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\StoreOpsiRequest;
use App\Models\BaKategori;
use App\Models\BaKategoriOpsi;
use App\Models\Konteks;
use App\Models\KonteksKategoriMapping;
use App\Models\KategoriOpsiMapping;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterKategoriController extends Controller
{
    // ============================================================
    // KATEGORI CRUD
    // ============================================================

    public function index()
    {
        $kategori = BaKategori::with(['parent', 'konteksList'])->orderBy('nama')->get();
        return view('master.kategori.index', compact('kategori'));
    }

    public function create()
    {
        $kategori = BaKategori::orderBy('nama')->get();
        return view('master.kategori.form', [
            'mode' => 'create',
            'kategori' => null,
            'parentOptions' => $kategori,
        ]);
    }

    public function store(StoreKategoriRequest $request)
    {
        BaKategori::create($request->validated() + ['active' => $request->boolean('active', true)]);
        return redirect()->route('master.kategori.index')
                         ->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit($id)
    {
        $kategori = BaKategori::with('konteksList')->findOrFail($id);
        $parentOptions = BaKategori::where('id', '!=', $id)->orderBy('nama')->get();
        $attachedKonteksIds = $kategori->konteksList->pluck('id')->all();
        $availableKonteks   = Konteks::whereNotIn('id', $attachedKonteksIds)->orderBy('id')->get();

        return view('master.kategori.form', [
            'mode'          => 'edit',
            'kategori'      => $kategori,
            'parentOptions' => $parentOptions,
            'availableKonteks'   => $availableKonteks,
            'allLevels'     => KonteksKategoriMapping::LEVELS,
        ]);
    }

    public function update(StoreKategoriRequest $request, $id)
    {
        $kategori = BaKategori::findOrFail($id);
        $kategori->update($request->validated() + ['active' => $request->boolean('active', true)]);
        return redirect()->route('master.kategori.index')
                         ->with('success', 'Kategori berhasil diupdate.');
    }

    public function toggle($id)
    {
        $kategori = BaKategori::findOrFail($id);
        $kategori->update(['active' => !$kategori->active]);
        return back()->with('success', "Kategori '{$kategori->nama}' status diubah jadi " . ($kategori->active ? 'aktif' : 'nonaktif') . '.');
    }

    /**
     * Attach BU ke kategori (atau ubah level bila sudah ada).
     */
    public function kategoriBuUpsert(Request $request, $id)
    {
        $request->validate([
            'konteks_id' => ['required', 'integer', 'exists:ms_konteks,id'],
            'level' => ['required', 'string', 'in:wajib,disarankan,opsional'],
        ]);

        KonteksKategoriMapping::updateOrCreate(
            ['konteks_id' => $request->konteks_id, 'kategori_id' => $id],
            ['level' => $request->level]
        );

        return back()->with('success', 'BU mapping diupdate.');
    }

    /**
     * Detach 1 BU dari kategori.
     */
    public function kategoriBuDetach($id, $konteksId)
    {
        KonteksKategoriMapping::where('kategori_id', $id)
                         ->where('konteks_id', $konteksId)
                         ->delete();
        return back()->with('success', 'Konteks di-detach dari kategori.');
    }

    // ============================================================
    // OPSI CRUD per kategori (mapping-aware)
    // ============================================================

    public function opsiIndex($kategoriId)
    {
        $kategori = BaKategori::with(['opsi'])->findOrFail($kategoriId);
        // Akses pivot lewat: $opsi->pivot->kode, $opsi->pivot->sort_order, $opsi->pivot->active
        return view('master.kategori_opsi.index', compact('kategori'));
    }

    /**
     * Tambah opsi ke kategori ini.
     * - Bila deskripsi sudah ada di ms_ba_kategori_opsi (global), reuse opsi id.
     * - Buat mapping baru kategori ↔ opsi dengan kode & sort_order.
     */
    public function opsiStore(StoreOpsiRequest $request, $kategoriId)
    {
        $kategori = BaKategori::findOrFail($kategoriId);

        // Cek apakah opsi dengan deskripsi sama sudah ada globally
        $opsi = BaKategoriOpsi::whereRaw('LOWER(TRIM(deskripsi)) = ?', [
                    mb_strtolower(trim($request->deskripsi))
               ])->first();

        if (!$opsi) {
            $opsi = BaKategoriOpsi::create([
                'deskripsi' => $request->deskripsi,
                'active'    => true,
            ]);
        }

        // Check duplicate mapping kategori-opsi
        $existingMapping = KategoriOpsiMapping::where('kategori_id', $kategoriId)
                                              ->where('opsi_id', $opsi->id)
                                              ->first();
        if ($existingMapping) {
            return back()->withErrors([
                'deskripsi' => "Opsi '{$opsi->deskripsi}' sudah ada di kategori ini (kode: {$existingMapping->kode})."
            ])->withInput();
        }

        // Check duplicate kode dalam kategori ini
        $kodeExists = KategoriOpsiMapping::where('kategori_id', $kategoriId)
                                         ->where('kode', $request->kode)
                                         ->exists();
        if ($kodeExists) {
            return back()->withErrors([
                'kode' => "Kode '{$request->kode}' sudah dipakai di kategori ini."
            ])->withInput();
        }

        KategoriOpsiMapping::create([
            'kategori_id' => $kategoriId,
            'opsi_id'     => $opsi->id,
            'kode'        => $request->kode,
            'sort_order'  => $request->input('sort_order', 0),
            'active'      => $request->boolean('active', true),
        ]);

        return back()->with('success', 'Opsi berhasil ditambahkan ke kategori.');
    }

    /**
     * Update mapping opsi-kategori (kode, sort_order, active).
     * Note: ini update PIVOT row, bukan deskripsi opsi global.
     * Untuk edit deskripsi opsi, lihat halaman opsi global.
     */
    public function opsiUpdate(StoreOpsiRequest $request, $kategoriId, $opsiId)
    {
        $mapping = KategoriOpsiMapping::where('kategori_id', $kategoriId)
                                      ->where('opsi_id', $opsiId)
                                      ->firstOrFail();

        // Check kode unique (exclude row itu sendiri)
        $kodeConflict = KategoriOpsiMapping::where('kategori_id', $kategoriId)
                                           ->where('kode', $request->kode)
                                           ->where('id', '!=', $mapping->id)
                                           ->exists();
        if ($kodeConflict) {
            return back()->withErrors([
                'kode' => "Kode '{$request->kode}' sudah dipakai di kategori ini."
            ])->withInput();
        }

        $mapping->update([
            'kode'       => $request->kode,
            'sort_order' => $request->input('sort_order', 0),
            'active'     => $request->boolean('active', true),
        ]);

        // Update deskripsi global bila ada perubahan
        if ($request->filled('deskripsi') && $mapping->opsi) {
            $mapping->opsi->update(['deskripsi' => $request->deskripsi]);
        }

        return back()->with('success', 'Opsi berhasil diupdate.');
    }

    public function opsiToggle($kategoriId, $opsiId)
    {
        $mapping = KategoriOpsiMapping::where('kategori_id', $kategoriId)
                                      ->where('opsi_id', $opsiId)
                                      ->firstOrFail();
        $mapping->update(['active' => !$mapping->active]);
        return back()->with('success', "Status opsi di kategori ini diubah.");
    }

    // ============================================================
    // BU x KATEGORI MAPPING
    // ============================================================

    public function mappingMatrix()
    {
        $konteksList = Konteks::orderBy('id')->get();
        $kategori      = BaKategori::orderBy('nama')->get();
        $mappings      = KonteksKategoriMapping::all()
                            ->keyBy(fn($m) => "{$m->konteks_id}_{$m->kategori_id}");

        return view('master.konteks_kategori_mapping.index', compact('konteksList', 'kategori', 'mappings'));
    }

    public function mappingUpdate(Request $request)
    {
        $request->validate([
            'konteks_id'        => ['required', 'integer', 'exists:ms_konteks,id'],
            'kategori_id'  => ['required', 'integer', 'exists:ms_ba_kategori,id'],
            'level'        => ['required', 'string', 'in:wajib,disarankan,opsional,none'],
        ]);

        if ($request->level === 'none') {
            KonteksKategoriMapping::where('konteks_id', $request->konteks_id)
                ->where('kategori_id', $request->kategori_id)
                ->delete();
            return response()->json(['ok' => true, 'action' => 'deleted']);
        }

        KonteksKategoriMapping::updateOrCreate(
            ['konteks_id' => $request->konteks_id, 'kategori_id' => $request->kategori_id],
            ['level' => $request->level]
        );

        return response()->json(['ok' => true, 'action' => 'updated']);
    }

    // ============================================================
    // OPSI × KONTEKS MAPPING — matrix admin (ms_opsi_konteks_mapping)
    // Beda dengan kategori_konteks: tidak ada level, cuma on/off (checkbox).
    // ============================================================

    public function opsiKonteksMatrix()
    {
        $konteksList = Konteks::orderBy('id')->get();
        // Load opsi + show kategori parent untuk konteks (debugging help)
        $opsi = BaKategoriOpsi::with(['kategoris' => fn($q) => $q->orderBy('nama')])
            ->where('active', true)
            ->orderBy('deskripsi')
            ->get();

        // Existing mapping: opsi_id + konteks_id (boolean — kalau exist = active)
        $mappings = DB::table('ms_opsi_konteks_mapping')
            ->select('opsi_id', 'konteks_id')
            ->get()
            ->groupBy('opsi_id')
            ->map(fn($rows) => $rows->pluck('konteks_id')->all());

        return view('master.opsi_konteks_mapping.index', compact('konteksList', 'opsi', 'mappings'));
    }

    public function opsiKonteksUpdate(Request $request)
    {
        $request->validate([
            'opsi_id'    => ['required', 'integer', 'exists:ms_ba_kategori_opsi,id'],
            'konteks_id' => ['required', 'integer', 'exists:ms_konteks,id'],
            'active'     => ['required', 'boolean'],
        ]);

        $opsiId    = (int) $request->opsi_id;
        $konteksId = (int) $request->konteks_id;
        $active    = $request->boolean('active');

        if ($active) {
            // Insert (upsert pattern via insertOrIgnore)
            $exists = DB::table('ms_opsi_konteks_mapping')
                ->where('opsi_id', $opsiId)
                ->where('konteks_id', $konteksId)
                ->exists();
            if (!$exists) {
                DB::table('ms_opsi_konteks_mapping')->insert([
                    'opsi_id'    => $opsiId,
                    'konteks_id' => $konteksId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return response()->json(['ok' => true, 'action' => 'attached']);
        }

        DB::table('ms_opsi_konteks_mapping')
            ->where('opsi_id', $opsiId)
            ->where('konteks_id', $konteksId)
            ->delete();
        return response()->json(['ok' => true, 'action' => 'detached']);
    }

    // ============================================================
    // OPSI GLOBAL (lintas kategori — multi-parent picker)
    // ============================================================

    public function opsiGlobalIndex(Request $request)
    {
        $kategoriList = BaKategori::orderBy('nama')->get();

        // Eager load kategori parents + BU mapping untuk display badge
        $query = BaKategoriOpsi::with(['kategoris.konteksList'])->orderBy('deskripsi');

        if ($request->filled('kategori_id')) {
            $query->whereHas('kategoris', fn($q) => $q->where('ms_ba_kategori.id', $request->kategori_id));
        }
        if ($request->filled('q')) {
            $query->where('deskripsi', 'like', '%' . $request->q . '%');
        }
        $opsi = $query->get();

        return view('master.opsi_global.index', [
            'kategoriList'    => $kategoriList,
            'opsi'            => $opsi,
            'filterKategori'  => $request->kategori_id,
            'filterQ'         => $request->q,
        ]);
    }

    /**
     * Halaman detail/edit opsi global — kelola deskripsi + attachment ke kategori.
     */
    public function opsiEdit($id)
    {
        $opsi = BaKategoriOpsi::with([
                    'kategoris' => fn($q) => $q->orderBy('nama'),
                    'konteksList',
                ])->findOrFail($id);
        $attachedIds   = $opsi->kategoris->pluck('id')->all();
        $availableKat  = BaKategori::whereNotIn('id', $attachedIds)->orderBy('nama')->get();
        $attachedKonteksIds = $opsi->konteksList->pluck('id')->all();
        $availableKonteks   = Konteks::whereNotIn('id', $attachedKonteksIds)->orderBy('id')->get();

        return view('master.opsi_global.edit', compact('opsi', 'availableKat', 'availableKonteks'));
    }

    /**
     * Attach BU ke opsi (tag direct).
     */
    public function opsiAttachBu(Request $request, $id)
    {
        $request->validate([
            'konteks_ids'   => ['required', 'array', 'min:1'],
            'konteks_ids.*' => ['integer', 'exists:ms_konteks,id'],
        ]);

        $opsi = BaKategoriOpsi::findOrFail($id);
        $existing = $opsi->konteksList()->pluck('ms_konteks.id')->all();
        $toAttach = array_diff($request->konteks_ids, $existing);
        $opsi->konteksList()->attach($toAttach);

        return back()->with('success', count($toAttach) . ' Konteks di-attach ke opsi ini.');
    }

    /**
     * Detach 1 Konteks dari opsi.
     */
    public function opsiDetachBu($opsiId, $konteksId)
    {
        $opsi = BaKategoriOpsi::findOrFail($opsiId);
        $opsi->konteksList()->detach($konteksId);
        return back()->with('success', 'Konteks di-detach dari opsi ini.');
    }

    /**
     * Update deskripsi opsi global (apply ke semua kategori).
     */
    public function opsiGlobalUpdate(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => ['required', 'string', 'max:500',
                            \Illuminate\Validation\Rule::unique('ms_ba_kategori_opsi', 'deskripsi')->ignore($id)],
            'active'    => ['sometimes', 'boolean'],
        ]);

        $opsi = BaKategoriOpsi::findOrFail($id);
        $opsi->update([
            'deskripsi' => $request->deskripsi,
            'active'    => $request->boolean('active', true),
        ]);

        return back()->with('success', 'Deskripsi opsi diupdate (apply ke semua kategori yang attached).');
    }

    /**
     * Attach opsi ke kategori baru (dengan kode & sort_order untuk kategori itu).
     */
    public function opsiAttach(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => ['required', 'integer', 'exists:ms_ba_kategori,id'],
            'kode'        => ['required', 'string', 'max:10'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        // Cek apakah sudah ada mapping
        $exists = KategoriOpsiMapping::where('opsi_id', $id)
                                     ->where('kategori_id', $request->kategori_id)
                                     ->exists();
        if ($exists) {
            return back()->withErrors(['kategori_id' => 'Opsi ini sudah attached ke kategori tersebut.']);
        }

        // Cek konflik kode di kategori target
        $kodeConflict = KategoriOpsiMapping::where('kategori_id', $request->kategori_id)
                                           ->where('kode', $request->kode)
                                           ->exists();
        if ($kodeConflict) {
            return back()->withErrors(['kode' => "Kode '{$request->kode}' sudah dipakai di kategori target."]);
        }

        KategoriOpsiMapping::create([
            'opsi_id'     => $id,
            'kategori_id' => $request->kategori_id,
            'kode'        => $request->kode,
            'sort_order'  => $request->input('sort_order', 0),
            'active'      => true,
        ]);

        return back()->with('success', 'Opsi berhasil di-attach ke kategori baru.');
    }

    /**
     * Detach opsi dari kategori tertentu (hapus 1 pivot row).
     * Opsi tetap ada di kategori lain.
     */
    public function opsiDetach($opsiId, $kategoriId)
    {
        $opsi = BaKategoriOpsi::findOrFail($opsiId);

        // Enforce min 1 kategori per opsi
        if ($opsi->kategoris()->count() <= 1) {
            return back()->withErrors([
                'detach' => 'Tidak bisa detach: opsi harus punya minimal 1 kategori. Attach kategori lain dulu sebelum detach yang ini.'
            ]);
        }

        $mapping = KategoriOpsiMapping::where('opsi_id', $opsiId)
                                      ->where('kategori_id', $kategoriId)
                                      ->firstOrFail();
        $mapping->delete();
        return back()->with('success', 'Opsi berhasil di-detach dari kategori ini.');
    }

    /**
     * Update pivot field (kode, sort_order, active) untuk attachment opsi-kategori tertentu.
     */
    public function opsiMappingUpdate(Request $request, $opsiId, $kategoriId)
    {
        $request->validate([
            'kode'       => ['required', 'string', 'max:10'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'active'     => ['sometimes', 'boolean'],
        ]);

        $mapping = KategoriOpsiMapping::where('opsi_id', $opsiId)
                                      ->where('kategori_id', $kategoriId)
                                      ->firstOrFail();

        // Check kode unique dalam kategori (exclude row itu sendiri)
        $kodeConflict = KategoriOpsiMapping::where('kategori_id', $kategoriId)
                                           ->where('kode', $request->kode)
                                           ->where('id', '!=', $mapping->id)
                                           ->exists();
        if ($kodeConflict) {
            return back()->withErrors(['kode' => "Kode '{$request->kode}' sudah dipakai di kategori ini."]);
        }

        $mapping->update([
            'kode'       => $request->kode,
            'sort_order' => $request->input('sort_order', 0),
            'active'     => $request->boolean('active', true),
        ]);

        return back()->with('success', 'Mapping opsi-kategori diupdate.');
    }

    /**
     * Buat opsi baru + attach ke multiple kategori sekaligus.
     */
    public function opsiGlobalStore(Request $request)
    {
        $request->validate([
            'kategori_ids'   => ['required', 'array', 'min:1'],
            'kategori_ids.*' => ['integer', 'exists:ms_ba_kategori,id'],
            'deskripsi'      => ['required', 'string', 'max:500'],
            'kode'           => ['required', 'string', 'max:10'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],
        ]);

        // Cari atau buat opsi global
        $opsi = BaKategoriOpsi::whereRaw('LOWER(TRIM(deskripsi)) = ?', [
                    mb_strtolower(trim($request->deskripsi))
               ])->first();

        if (!$opsi) {
            $opsi = BaKategoriOpsi::create([
                'deskripsi' => $request->deskripsi,
                'active'    => true,
            ]);
        }

        $attached = [];
        $skipped  = [];

        foreach ($request->kategori_ids as $katId) {
            // Skip jika mapping sudah ada
            $exists = KategoriOpsiMapping::where('kategori_id', $katId)
                                         ->where('opsi_id', $opsi->id)
                                         ->exists();
            if ($exists) {
                $skipped[] = $katId;
                continue;
            }

            // Skip jika kode sudah dipakai di kategori ini
            $kodeUsed = KategoriOpsiMapping::where('kategori_id', $katId)
                                           ->where('kode', $request->kode)
                                           ->exists();
            if ($kodeUsed) {
                $skipped[] = $katId;
                continue;
            }

            KategoriOpsiMapping::create([
                'kategori_id' => $katId,
                'opsi_id'     => $opsi->id,
                'kode'        => $request->kode,
                'sort_order'  => $request->input('sort_order', 0),
                'active'      => $request->boolean('active', true),
            ]);
            $attached[] = $katId;
        }

        $msg = count($attached) . ' kategori berhasil di-attach.';
        if ($skipped) {
            $msg .= ' ' . count($skipped) . ' kategori di-skip (sudah ada / kode konflik).';
        }
        return back()->with('success', $msg);
    }
}
