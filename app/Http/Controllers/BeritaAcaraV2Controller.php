<?php

namespace App\Http\Controllers;

use App\Models\Konteks;
use App\Services\WaQontakService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Controller wizard Berita Acara (Create mode).
 * URL: /beritaacara/v2/* (parallel dengan endpoint lama yang dipertahankan)
 *
 * Path:
 *   GET  /beritaacara/v2/create  → wizard 5-step
 *   POST /beritaacara/v2/store   → simpan BA + kategori pivot + kronologi
 *
 * AJAX:
 *   GET /api/bu/{kode}/kategori          → daftar kategori dengan level untuk BU
 *   GET /api/kategori/{id}/opsi          → daftar opsi untuk kategori
 */
class BeritaAcaraV2Controller extends Controller
{
    /**
     * Dashboard BA v2 — overview + per-konteks tabs.
     */
    public function dashboard(Request $request)
    {
        $tglAwal     = $request->input('tgl_awal',  Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tglAkhir    = $request->input('tgl_akhir', Carbon::now()->format('Y-m-d'));
        $kategoriId  = $request->input('kategori_id');
        $perPage     = in_array((int) $request->input('per_page'), [10, 25, 50, 100]) ? (int) $request->input('per_page') : 50;

        $konteksList = Konteks::where('active', true)->orderBy('id')->get();
        $kategoriList  = \App\Models\BaKategori::where('active', true)->orderBy('nama')->get();

        // Pre-compute data per slice (Overview = all, plus per konteks)
        $slices = [];
        $slices['ALL'] = $this->dashboardSlice($tglAwal, $tglAkhir, null, $kategoriId, $perPage);
        foreach ($konteksList as $k) {
            $slices[$k->kode] = $this->dashboardSlice($tglAwal, $tglAkhir, $k->kode, $kategoriId, $perPage);
        }

        // Payload chart per tab (di-iterate di JS)
        $chartTabsData = [];
        $chartTabsData[] = [
            'tabId'       => 'overview',
            'showAll'     => true,
            'daily'       => $slices['ALL']['daily'],
            'perKonteks'  => $slices['ALL']['perKonteks'],
            'topKategori' => $slices['ALL']['topKategori'],
            'topOpsi'     => $slices['ALL']['topOpsi'],
            'perCabang'   => $slices['ALL']['perCabang'],
        ];
        foreach ($konteksList as $k) {
            $s = $slices[$k->kode];
            $chartTabsData[] = [
                'tabId'       => strtolower($k->kode),
                'showAll'     => false,
                'daily'       => $s['daily'],
                'perKonteks'  => $s['perKonteks'],
                'topKategori' => $s['topKategori'],
                'topOpsi'     => $s['topOpsi'],
                'perCabang'   => $s['perCabang'],
            ];
        }

        return view('berita_acara_v2.dashboard', compact(
            'tglAwal', 'tglAkhir', 'kategoriId', 'perPage',
            'konteksList', 'kategoriList', 'slices', 'chartTabsData'
        ));
    }

    /**
     * Hitung statistik 1 slice (semua / per konteks).
     */
    private function dashboardSlice(string $from, string $to, ?string $konteksKode, $kategoriId = null, int $perPage = 50): array
    {
        $base = DB::table('Tr_Ba_Main_New as ba')
                  ->whereBetween('ba.Date_BA', [$from, $to]);
        if ($konteksKode) {
            $base->where('ba.Ms_BA_type_Code', $konteksKode);
        }
        // Filter kategori (JOIN pivot bila diberikan)
        if ($kategoriId) {
            $base->whereExists(function ($q) use ($kategoriId) {
                $q->select(DB::raw(1))
                  ->from('tr_ba_kategori_d as d')
                  ->whereColumn('d.tr_ba_main_code', 'ba.Tr_BA_Main_Code')
                  ->where('d.kategori_id', $kategoriId);
            });
        }

        // Total
        $total = (clone $base)->count();

        // Daily trend
        $daily = (clone $base)
            ->select(DB::raw('DATE(Date_BA) as tgl'), DB::raw('COUNT(*) as cnt'))
            ->groupBy(DB::raw('DATE(Date_BA)'))
            ->orderBy('tgl')
            ->pluck('cnt', 'tgl');

        // Per Konteks (only for ALL slice)
        $perKonteks = collect();
        if (!$konteksKode) {
            $perKonteks = (clone $base)
                ->select('ba.Ms_BA_type_Code as kode', DB::raw('COUNT(*) as cnt'))
                ->groupBy('ba.Ms_BA_type_Code')
                ->pluck('cnt', 'kode');
        }

        // Top kategori (via pivot baru) — COUNT DISTINCT BA biar 1 BA multi-opsi tidak over-count
        $topKategori = DB::table('tr_ba_kategori_d as d')
            ->join('ms_ba_kategori as k', 'd.kategori_id', '=', 'k.id')
            ->join('Tr_Ba_Main_New as ba', 'd.tr_ba_main_code', '=', 'ba.Tr_BA_Main_Code')
            ->whereBetween('ba.Date_BA', [$from, $to])
            ->when($konteksKode, fn($q) => $q->where('ba.Ms_BA_type_Code', $konteksKode))
            ->select('k.nama', DB::raw('COUNT(DISTINCT d.tr_ba_main_code) as cnt'))
            ->groupBy('k.nama')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get();

        // Top opsi (deskripsi → COUNT BA)
        $topOpsi = DB::table('tr_ba_kategori_d as d')
            ->join('ms_ba_kategori_opsi as o', 'd.opsi_id', '=', 'o.id')
            ->join('Tr_Ba_Main_New as ba', 'd.tr_ba_main_code', '=', 'ba.Tr_BA_Main_Code')
            ->whereNotNull('d.opsi_id')
            ->whereBetween('ba.Date_BA', [$from, $to])
            ->when($konteksKode, fn($q) => $q->where('ba.Ms_BA_type_Code', $konteksKode))
            ->select('o.deskripsi', DB::raw('COUNT(DISTINCT d.tr_ba_main_code) as cnt'))
            ->groupBy('o.deskripsi')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get();

        // Per Cabang (rec_comcode → ms_company)
        $perCabang = (clone $base)
            ->leftJoin('ms_company as c', 'ba.rec_comcode', '=', 'c.company_code')
            ->select(DB::raw('COALESCE(c.description, ba.rec_comcode) as cabang'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('cabang')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get();

        // Recent BA — JOIN dengan subquery (Ms_User_Emp punya composite PK
        // (Ms_Emp_Code, Ms_Company_Code) sehingga ada duplicate per code lintas company).

        // Subquery 1: 1 Emp_Name per Ms_Emp_Code
        // Ms_User_Emp ada di mysql_new (tirt3038_ERP). Pakai cross-DB qualifier
        // supaya bisa di-leftJoinSub dari koneksi `mysql` (HR_Worksheet).
        $erpDb = config('database.connections.mysql_new.database');
        $empSub = DB::table("{$erpDb}.Ms_User_Emp")
            ->select('Ms_Emp_Code as emp_id', DB::raw('MAX(Emp_Name) as emp_name'))
            ->groupBy('Ms_Emp_Code');

        // Subquery 2: PICA terbaru per BA + ambil 1 code via MAX(id)
        $picaSub = DB::table('Tr_PICA_Emp_h')
            ->select('NoBA', DB::raw('MAX(Date_PICA) as pica_date'), DB::raw('MAX(Tr_Pica_Emp_h_Code) as pica_kode'))
            ->whereNotNull('NoBA')
            ->where('NoBA', '!=', '')
            ->groupBy('NoBA');

        $recent = (clone $base)
            ->leftJoinSub($empSub, 'me', 'me.emp_id', '=', 'ba.Ms_Emp_Code')
            ->leftJoinSub($picaSub, 'pica', 'pica.NoBA', '=', 'ba.Tr_BA_Main_Code')
            ->select(
                'ba.Tr_BA_Main_Code as kode',
                'ba.Ms_BA_type_Code as konteks',
                'ba.Date_BA',
                'ba.created_at as ba_created_at',
                'ba.Ms_Emp_Code as emp_code',
                'me.emp_name as emp_name',
                'ba.Ms_Pelapor_Code as pelapor',
                'ba.BA_Desc as deskripsi',
                'pica.pica_kode',
                'pica.pica_date'
            )
            ->orderByDesc('ba.created_at')
            ->orderByDesc('ba.rec_datecreated')
            ->limit($perPage)
            ->get();

        return [
            'total'       => $total,
            'daily'       => $daily,
            'perKonteks'  => $perKonteks,
            'topKategori' => $topKategori,
            'topOpsi'     => $topOpsi,
            'perCabang'   => $perCabang,
            'recent'      => $recent,
        ];
    }

    /**
     * Detail BA — read-only view.
     * URL: /beritaacara/v2/show?kode=BA-XXX
     */
    public function show(Request $request)
    {
        $kode = $request->query('kode');
        if (!$kode) abort(404, 'Kode BA tidak diberikan');

        $erpDb = config('database.connections.mysql_new.database');
        $empSubShow = DB::table("{$erpDb}.Ms_User_Emp")
            ->select('Ms_Emp_Code as emp_id', DB::raw('MAX(Emp_Name) as emp_name'))
            ->groupBy('Ms_Emp_Code');

        $ba = DB::table('Tr_Ba_Main_New as ba')
            ->leftJoinSub($empSubShow, 'me', 'me.emp_id', '=', 'ba.Ms_Emp_Code')
            ->leftJoin('ms_company as c', 'ba.rec_comcode', '=', 'c.company_code')
            ->leftJoin('ms_lokasi as l', 'ba.rec_areacode', '=', 'l.lokasi_code')
            ->where('ba.Tr_BA_Main_Code', $kode)
            ->select(
                'ba.*',
                'me.emp_name',
                'c.description as company_name',
                'l.lokasi_desc as lokasi_name'
            )
            ->first();

        if (!$ba) abort(404, "BA dengan kode {$kode} tidak ditemukan");

        // Kategori yang attached
        $kategoris = DB::table('tr_ba_kategori_d as d')
            ->leftJoin('ms_ba_kategori as k', 'd.kategori_id', '=', 'k.id')
            ->leftJoin('ms_ba_kategori_opsi as o', 'd.opsi_id', '=', 'o.id')
            ->where('d.tr_ba_main_code', $kode)
            ->select('k.kode as kategori_kode', 'k.nama as kategori_nama', 'o.deskripsi as opsi_deskripsi', 'd.created_at')
            ->orderBy('k.nama')
            ->get();

        // Kronologi
        $kronologi = DB::table('tr_ba_kronologi')
            ->where('tr_ba_main_code', $kode)
            ->orderBy('id')
            ->get();

        // Revisi (jika ada — konteks REVISI)
        $requestRevisi = DB::table('tr_ba_request_revisi')
            ->where('tr_ba_main_code', $kode)
            ->first();

        $revisiDetail = collect();
        $revisiApproval = null;
        if ($requestRevisi) {
            $revisiDetail = DB::table('tr_ba_salah_isi_detail')
                ->where('tr_ba_code_request', $requestRevisi->tr_ba_request_revisi_code)
                ->orderBy('id')
                ->get();
            $revisiApproval = DB::table('Tr_BA_Revisi')
                ->where('Tr_BA_Main_Code', $kode)
                ->first();
        }

        // PICA v2 yang link ke BA ini (Fase 6 — BA↔PICA integration)
        // Subquery Ms_User_Emp untuk emp name (composite PK → dedupe via MAX, cross-DB)
        $erpDb = config('database.connections.mysql_new.database');
        $empSubPica = DB::table("{$erpDb}.Ms_User_Emp")
            ->select('Ms_Emp_Code as emp_id', DB::raw('MAX(Emp_Name) as emp_name'))
            ->groupBy('Ms_Emp_Code');
        $picaListRaw = DB::table('Tr_PICA_Emp_h as h')
            ->leftJoinSub($empSubPica, 'me', 'me.emp_id', '=', 'h.Emp_Code')
            ->where('h.NoBA', $kode)
            ->orderByDesc('h.Date_PICA')
            ->get([
                'h.Tr_Pica_Emp_h_Code', 'h.Date_PICA', 'h.Status_PICA',
                'h.Emp_Code', 'h.Problem_Note', 'me.emp_name'
            ]);

        // Progress wajib_jawab per PICA
        $picaCodes = $picaListRaw->pluck('Tr_Pica_Emp_h_Code')->all();
        $picaProgress = [];
        if (!empty($picaCodes)) {
            $progRows = DB::table('tr_pica_pertanyaan_d as q')
                ->leftJoin('tr_pica_jawaban as j', function ($join) {
                    $join->on('j.pertanyaan_id', '=', 'q.id')->where('j.is_final', 1);
                })
                ->whereIn('q.tr_pica_main_code', $picaCodes)
                ->where('q.wajib_jawab', 1)
                ->select('q.tr_pica_main_code',
                    DB::raw('COUNT(DISTINCT q.id) as total'),
                    DB::raw('COUNT(DISTINCT j.id) as terisi'))
                ->groupBy('q.tr_pica_main_code')
                ->get();
            foreach ($progRows as $p) {
                $picaProgress[$p->tr_pica_main_code] = [
                    'total' => (int) $p->total, 'terisi' => (int) $p->terisi,
                ];
            }
        }
        foreach ($picaListRaw as $p) {
            $p->progress = $picaProgress[$p->Tr_Pica_Emp_h_Code] ?? ['total' => 0, 'terisi' => 0];
        }
        $picaList = $picaListRaw;

        $canEdit = $this->canEditBa($ba);
        $isAdmin = $this->isAdmin();

        return view('berita_acara_v2.show', compact(
            'ba', 'kategoris', 'kronologi', 'requestRevisi', 'revisiDetail', 'revisiApproval',
            'picaList', 'canEdit', 'isAdmin'
        ));
    }

    /**
     * Helper: cek role admin/super_admin/administrator.
     * DB pakai "Administrator" — match case-insensitive.
     */
    protected function isAdmin(): bool
    {
        $role = strtolower(auth()->user()->role ?? '');
        return in_array($role, ['admin', 'super_admin', 'superadmin', 'administrator'], true);
    }

    /**
     * Helper: bisa edit BA bila admin, ATAU creator dgn edit_allowed=true.
     */
    protected function canEditBa($ba): bool
    {
        if ($this->isAdmin()) return true;
        $username = auth()->user()->username ?? '';
        return ((bool) ($ba->edit_allowed ?? false))
            && strcasecmp($username, $ba->Rec_UserCreated ?? '') === 0;
    }

    /**
     * Toggle edit_allowed flag (admin only).
     */
    public function toggleEditAllowed(Request $request, $kode)
    {
        abort_unless($this->isAdmin(), 403, 'Hanya admin yang boleh toggle edit_allowed.');

        $ba = DB::table('Tr_Ba_Main_New')->where('Tr_BA_Main_Code', $kode)->first();
        abort_unless($ba, 404);

        $new = !((bool) $ba->edit_allowed);
        DB::table('Tr_Ba_Main_New')->where('Tr_BA_Main_Code', $kode)
            ->update(['edit_allowed' => $new, 'updated_at' => now()]);

        return back()->with('success',
            $new ? 'Edit BA diizinkan untuk creator.' : 'Edit BA dikunci kembali.');
    }

    /**
     * Edit form BA. Permission: admin OR creator+edit_allowed.
     */
    public function edit(Request $request)
    {
        $kode = $request->query('kode');
        abort_unless($kode, 404);

        $ba = DB::table('Tr_Ba_Main_New')->where('Tr_BA_Main_Code', $kode)->first();
        abort_unless($ba, 404);
        abort_unless($this->canEditBa($ba), 403, 'Anda tidak diizinkan edit BA ini.');

        $kategoriAttached = DB::table('tr_ba_kategori_d')
            ->where('tr_ba_main_code', $kode)
            ->pluck('kategori_id')->all();

        $kronologi = DB::table('tr_ba_kronologi')
            ->where('tr_ba_main_code', $kode)
            ->orderBy('id')
            ->get();

        $kategoriList = \App\Models\BaKategori::where('active', true)->orderBy('nama')->get();
        $lokasi  = DB::table('ms_lokasi')->select('lokasi_code', 'lokasi_desc')->orderBy('lokasi_desc')->get();
        $company = DB::table('ms_company')->select('company_code', 'description')->orderBy('description')->get();
        $divisi  = DB::table('ms_subbdivision')->select('subbdiv_code', 'subbdiv_desc')->orderBy('subbdiv_desc')->get();

        return view('berita_acara_v2.edit', compact(
            'ba', 'kategoriAttached', 'kronologi', 'kategoriList',
            'lokasi', 'company', 'divisi'
        ));
    }

    /**
     * Update BA dari edit form. Permission: admin OR creator+edit_allowed.
     */
    public function update(Request $request, $kode)
    {
        $ba = DB::table('Tr_Ba_Main_New')->where('Tr_BA_Main_Code', $kode)->first();
        abort_unless($ba, 404);
        abort_unless($this->canEditBa($ba), 403);

        $request->validate([
            'Date_BA'       => ['required', 'date'],
            'Ms_Emp_Code'   => ['required', 'string', 'max:50'],
            'Ms_Emp_Div'    => ['nullable', 'string', 'max:50'],
            'rec_comcode'   => ['nullable', 'string', 'max:50'],
            'rec_areacode'  => ['nullable', 'string', 'max:50'],
            'BA_Desc'       => ['required', 'string', 'max:1000'],
            'kategori_ids'  => ['nullable', 'array'],
            'kategori_ids.*'=> ['integer', 'exists:ms_ba_kategori,id'],
            'kronologi'     => ['nullable', 'array'],
            'kronologi.*'   => ['nullable', 'string', 'max:2000'],
        ]);

        DB::beginTransaction();
        try {
            DB::table('Tr_Ba_Main_New')->where('Tr_BA_Main_Code', $kode)->update([
                'Date_BA'      => $request->Date_BA,
                'Ms_Emp_Code'  => $request->Ms_Emp_Code,
                'Ms_Emp_Div'   => $request->Ms_Emp_Div,
                'rec_comcode'  => $request->rec_comcode,
                'rec_areacode' => $request->rec_areacode,
                'BA_Desc'      => $request->BA_Desc,
                'updated_at'   => now(),
            ]);

            // Sync kategori (replace-all strategy)
            DB::table('tr_ba_kategori_d')->where('tr_ba_main_code', $kode)->delete();
            foreach (($request->kategori_ids ?? []) as $katId) {
                DB::table('tr_ba_kategori_d')->insert([
                    'tr_ba_main_code' => $kode,
                    'kategori_id'     => (int) $katId,
                    'opsi_id'         => null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }

            // Sync kronologi (replace-all). Legacy table pakai column 'kronlogi' (typo) + 'tr_ba_kronologi_code'.
            DB::table('tr_ba_kronologi')->where('tr_ba_main_code', $kode)->delete();
            foreach (($request->kronologi ?? []) as $i => $k) {
                $k = trim($k ?? '');
                if ($k === '') continue;
                DB::table('tr_ba_kronologi')->insert([
                    'tr_ba_kronologi_code' => 'KRO-' . $kode . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'tr_ba_main_code'      => $kode,
                    'kronlogi'             => $k,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('berita-acara-v2.show', ['kode' => $kode])
                ->with('success', "BA <strong>{$kode}</strong> berhasil diupdate.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['update' => 'Gagal update: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Print BA form dengan signature blocks untuk approval.
     * Render via mPDF → langsung download PDF (tanpa wrapper layout web).
     */
    public function print(string $kode)
    {
        $erpDb = config('database.connections.mysql_new.database');
        $empSub = DB::table("{$erpDb}.Ms_User_Emp")
            ->select('Ms_Emp_Code as emp_id', DB::raw('MAX(Emp_Name) as emp_name'))
            ->groupBy('Ms_Emp_Code');

        $ba = DB::table('Tr_Ba_Main_New as ba')
            ->leftJoinSub($empSub, 'me', 'me.emp_id', '=', 'ba.Ms_Emp_Code')
            ->leftJoinSub($empSub, 'mp', 'mp.emp_id', '=', 'ba.Ms_Pelapor_Code')
            ->leftJoin('ms_division as dv_pelaku',  'ba.Ms_Emp_Div',     '=', 'dv_pelaku.div_id')
            ->leftJoin('ms_division as dv_pelapor', 'ba.Ms_Pelapor_Div', '=', 'dv_pelapor.div_id')
            ->leftJoin('ms_company as c', 'ba.rec_comcode', '=', 'c.company_code')
            ->leftJoin('ms_lokasi as l', 'ba.rec_areacode', '=', 'l.lokasi_code')
            ->where('ba.Tr_BA_Main_Code', $kode)
            ->select(
                'ba.*',
                'me.emp_name',
                'mp.emp_name as pelapor_name',
                DB::raw('COALESCE(dv_pelaku.div_desc,  ba.Ms_Emp_Div)     as pelaku_divisi'),
                DB::raw('COALESCE(dv_pelapor.div_desc, ba.Ms_Pelapor_Div) as pelapor_divisi'),
                'c.description as company_name',
                'l.lokasi_desc as lokasi_name'
            )
            ->first();

        abort_unless($ba, 404, "BA dengan kode {$kode} tidak ditemukan");

        $kronologi = DB::table('tr_ba_kronologi')
            ->where('tr_ba_main_code', $ba->Tr_BA_Main_Code)
            ->orderBy('id')->get();

        $categories = DB::table('tr_ba_kategori_d as d')
            ->join('ms_ba_kategori as k', 'd.kategori_id', '=', 'k.id')
            ->leftJoin('ms_ba_kategori_opsi as o', 'd.opsi_id', '=', 'o.id')
            ->where('d.tr_ba_main_code', $ba->Tr_BA_Main_Code)
            ->select('k.nama', 'o.deskripsi')
            ->get();

        $html = view('berita_acara_v2.print', compact('ba', 'kronologi', 'categories'))->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_left'   => 10,
            'margin_right'  => 10,
            'margin_top'    => 10,
            'margin_bottom' => 10,
            'margin_header' => 0,
            'margin_footer' => 0,
        ]);
        $mpdf->WriteHTML($html);

        $filename = 'BA_' . $ba->Tr_BA_Main_Code . '.pdf';
        return response($mpdf->Output($filename, \Mpdf\Output\Destination::STRING_RETURN), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * List BA dengan filter (emp_code, pelapor, konteks, date).
     * URL: /beritaacara/v2/list?emp_code=X | ?pelapor=Y | ?konteks=Z
     */
    public function list(Request $request)
    {
        $perPage = in_array((int) $request->input('per_page'), [10, 25, 50, 100]) ? (int) $request->input('per_page') : 20;

        // Ms_User_Emp composite PK (Ms_Emp_Code, Ms_Company_Code) — dedupe via MAX, cross-DB
        $erpDb = config('database.connections.mysql_new.database');
        $empSub = DB::table("{$erpDb}.Ms_User_Emp")
            ->select('Ms_Emp_Code as emp_id', DB::raw('MAX(Emp_Name) as emp_name'))
            ->groupBy('Ms_Emp_Code');

        $query = DB::table('Tr_Ba_Main_New as ba')
            ->leftJoinSub($empSub, 'me', 'me.emp_id', '=', 'ba.Ms_Emp_Code');

        if ($request->filled('emp_code'))    $query->where('ba.Ms_Emp_Code', $request->emp_code);
        if ($request->filled('pelapor'))     $query->where('ba.Ms_Pelapor_Code', $request->pelapor);
        if ($request->filled('konteks'))     $query->where('ba.Ms_BA_type_Code', $request->konteks);
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('ba.Date_BA', [$request->tgl_awal, $request->tgl_akhir]);
        }
        if ($request->filled('kategori_id')) {
            $query->whereExists(function ($q) use ($request) {
                $q->select(DB::raw(1))
                  ->from('tr_ba_kategori_d as d')
                  ->whereColumn('d.tr_ba_main_code', 'ba.Tr_BA_Main_Code')
                  ->where('d.kategori_id', $request->kategori_id);
            });
        }
        if ($request->filled('opsi_id')) {
            $query->whereExists(function ($q) use ($request) {
                $q->select(DB::raw(1))
                  ->from('tr_ba_kategori_d as d')
                  ->whereColumn('d.tr_ba_main_code', 'ba.Tr_BA_Main_Code')
                  ->where('d.opsi_id', $request->opsi_id);
            });
        }

        $bas = $query
            ->select(
                'ba.Tr_BA_Main_Code as kode',
                'ba.Ms_BA_type_Code as konteks',
                'ba.Date_BA',
                'ba.Ms_Emp_Code as emp_code',
                'me.emp_name',
                'ba.Ms_Pelapor_Code as pelapor',
                'ba.BA_Desc as deskripsi',
                'ba.rec_datecreated'
            )
            ->orderByDesc('ba.rec_datecreated')
            ->paginate($perPage)
            ->withQueryString();

        $kategoriList = \App\Models\BaKategori::where('active', true)->orderBy('nama')->get();

        // Display kategori/opsi nama yang dipilih
        $selectedKategori = null;
        $selectedOpsi     = null;
        if ($request->filled('kategori_id')) {
            $selectedKategori = $kategoriList->firstWhere('id', $request->kategori_id);
        }
        if ($request->filled('opsi_id')) {
            $selectedOpsi = \App\Models\BaKategoriOpsi::find($request->opsi_id);
        }

        // Header info filter aktif
        $filterInfo = [];
        if ($request->filled('emp_code'))    $filterInfo[] = "Pelaku: {$request->emp_code}";
        if ($request->filled('pelapor'))     $filterInfo[] = "Pelapor: {$request->pelapor}";
        if ($request->filled('konteks'))     $filterInfo[] = "Konteks: {$request->konteks}";
        if ($selectedKategori)               $filterInfo[] = "Kategori: {$selectedKategori->nama}";
        if ($selectedOpsi)                   $filterInfo[] = "Opsi: {$selectedOpsi->deskripsi}";

        return view('berita_acara_v2.list', compact(
            'bas', 'filterInfo', 'request', 'kategoriList', 'selectedOpsi', 'perPage'
        ));
    }

    /**
     * AJAX: search ms_kasus by code atau description (Select2 di wizard step 2).
     */
    public function searchKasus(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) return response()->json(['results' => []]);

        $rows = DB::table('ms_kasus')
                    ->where(function ($w) use ($q) {
                        $w->where('ms_kasus_code', 'like', "%{$q}%")
                          ->orWhere('description', 'like', "%{$q}%");
                    })
                    ->where('rec_status', 1)
                    ->select('ms_kasus_code', 'description')
                    ->orderBy('description')
                    ->limit(50)
                    ->get();

        return response()->json([
            'results' => $rows->map(fn($r) => [
                'id'   => $r->ms_kasus_code,
                'text' => "{$r->ms_kasus_code} — {$r->description}",
            ]),
        ]);
    }

    /**
     * AJAX: search opsi by deskripsi (untuk Select2 di list page).
     */
    public function searchOpsi(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) return response()->json(['results' => []]);

        $rows = \App\Models\BaKategoriOpsi::where('deskripsi', 'like', "%{$q}%")
                    ->orderBy('deskripsi')
                    ->limit(50)
                    ->get(['id', 'deskripsi']);

        return response()->json([
            'results' => $rows->map(fn($o) => ['id' => $o->id, 'text' => $o->deskripsi]),
        ]);
    }

    public function create()
    {
        $konteksList = Konteks::where('active', true)->orderBy('id')->get();

        // Lokasi & company dari master existing
        $lokasi  = DB::table('ms_lokasi')->select('lokasi_code', 'lokasi_desc')->orderBy('lokasi_desc')->get();
        $company = DB::table('ms_company')->select('company_code', 'description')->orderBy('description')->get();
        $divisi  = DB::table('ms_divisi')->select('subbdiv_code', 'subbdiv_desc')->orderBy('subbdiv_desc')->get();

        return view('berita_acara_v2.wizard', compact('konteksList', 'lokasi', 'company', 'divisi'));
    }

    /**
     * AJAX: search karyawan dari Ms_User_Emp (database tirt3038_ERP).
     * Return: [{id: Ms_Emp_Code, text: "CODE — Nama", divisi: emp_division}]
     */
    public function searchEmployees(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $erpDb = config('database.connections.mysql_new.database');
        $rows = DB::table("{$erpDb}.Ms_User_Emp")
                    ->where(function ($w) use ($q) {
                        $w->where('Ms_Emp_Code', 'like', "%{$q}%")
                          ->orWhere('Emp_Name', 'like', "%{$q}%");
                    })
                    ->where(function ($w) {
                        $w->where('Status_Active', 1)
                          ->orWhereNull('Status_Active');
                    })
                    ->select(
                        DB::raw('MIN(Ms_Emp_Code) as emp_id'),
                        DB::raw('MAX(Emp_Name) as emp_name'),
                        DB::raw('MAX(emp_division) as emp_iddivision')
                    )
                    ->groupBy('Ms_Emp_Code')
                    ->orderBy(DB::raw('MAX(Emp_Name)'))
                    ->limit(50)
                    ->get();

        $results = $rows->map(fn($r) => [
            'id'     => $r->emp_id,
            'text'   => "{$r->emp_id} — {$r->emp_name}",
            'divisi' => $r->emp_iddivision,
        ]);

        return response()->json(['results' => $results]);
    }

    /**
     * AJAX: list kategori untuk Konteks tertentu.
     *
     * Post-ADR-008: kolom `level` (wajib/disarankan/opsional) sudah di-drop dari
     * `ms_konteks_kategori_mapping`. Semua kategori yang muncul = opsional.
     *
     * `domain` per kategori sekarang dihitung dari MAPPING PRESENCE:
     *   - Kategori yang mapped ke HANYA 1 dari (FNB/LAKA/REVISI) → bucket itu
     *   - Selain itu (multi-konteks atau cuma OP_HR) → bucket UMUM
     * Konsekuensi: kategori yang dulu "wajib di FNB" multi-konteks (mis. Disiplin
     * Operasional) sekarang masuk UMUM bukan FNB.
     */
    public function kategoriByBu($konteksKode)
    {
        $konteks = Konteks::where('kode', $konteksKode)->first();
        if (!$konteks) return response()->json([], 404);

        // Ambil HANYA kategori yang mapped ke konteks yang dipilih (inner join).
        $rows = DB::table('ms_ba_kategori as k')
                    ->join('ms_konteks_kategori_mapping as m', function ($j) use ($konteks) {
                        $j->on('m.kategori_id', '=', 'k.id')
                          ->where('m.konteks_id', '=', $konteks->id);
                    })
                    ->where('k.active', true)
                    ->select('k.id', 'k.kode', 'k.nama')
                    ->orderBy('k.nama')
                    ->get();

        // Compute domain via mapping presence ke konteks domain-specific (FNB/LAKA/REVISI).
        $domainKonteksList = ['FNB', 'LAKA', 'REVISI'];
        $mappedKonteks = DB::table('ms_konteks_kategori_mapping as m')
            ->join('ms_konteks as k', 'm.konteks_id', '=', 'k.id')
            ->whereIn('k.kode', $domainKonteksList)
            ->select('m.kategori_id', 'k.kode')
            ->get()
            ->groupBy('kategori_id');

        foreach ($rows as $r) {
            $mappedKodes = $mappedKonteks->get($r->id, collect())->pluck('kode')->unique()->all();
            $r->domain = (count($mappedKodes) === 1) ? $mappedKodes[0] : 'UMUM';
        }

        return response()->json([
            'selected_konteks' => $konteksKode,
            'kategori'         => $rows,
        ]);
    }

    /**
     * AJAX: list opsi untuk kategori tertentu (dengan kode dari pivot).
     * Filter tambahan: hanya opsi yang tagged ke BU yang dipilih (bila ?bu=KODE diberikan).
     */
    public function opsiByKategori($kategoriId, Request $request)
    {
        $query = DB::table('ms_kategori_opsi_mapping as m')
                    ->join('ms_ba_kategori_opsi as o', 'm.opsi_id', '=', 'o.id')
                    ->where('m.kategori_id', $kategoriId)
                    ->where('m.active', true)
                    ->where('o.active', true)
                    ->select('o.id as opsi_id', 'm.kode', 'o.deskripsi', 'm.sort_order');

        // Filter by Konteks bila parameter diberikan
        if ($konteksKode = $request->query('konteks') ?? $request->query('bu')) {
            $query->whereExists(function ($q) use ($konteksKode) {
                $q->select(DB::raw(1))
                  ->from('ms_opsi_konteks_mapping as ob')
                  ->join('ms_konteks as k', 'ob.konteks_id', '=', 'k.id')
                  ->whereColumn('ob.opsi_id', 'o.id')
                  ->where('k.kode', $konteksKode);
            });
        }

        $rows = $query->orderBy('m.sort_order')->orderBy('m.kode')->get();
        return response()->json($rows);
    }

    /**
     * Submit wizard: insert ke Tr_Ba_Main_New + tr_ba_kategori_d + tr_ba_kronologi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'konteks_kode'       => ['required', 'string', 'exists:ms_konteks,kode'],
            'tanggal'            => ['required', 'date'],
            'lokasi_code'        => ['nullable', 'string', 'max:50'],
            'company_code'       => ['nullable', 'string', 'max:50'],
            'emp_code'           => ['required', 'string', 'max:100'],
            'emp_div'            => ['nullable', 'string', 'max:100'],
            'ms_kasus'           => ['nullable', 'string', 'max:100'],
            'deskripsi'          => ['required', 'string', 'max:500'],
            'ba_temuan'          => ['nullable', 'string', 'max:2000'],
            'ba_rekomendasi'     => ['nullable', 'string', 'max:2000'],
            'kategori'           => ['required', 'array', 'min:1'],
            'kategori.*.id'      => ['required', 'integer', 'exists:ms_ba_kategori,id'],
            'kategori.*.opsi'    => ['nullable', 'array'],
            'kategori.*.opsi.*'  => ['integer', 'exists:ms_ba_kategori_opsi,id'],
            'kronologi'          => ['nullable', 'array'],
            'kronologi.*'        => ['nullable', 'string', 'max:2000'],
            // Revisi fields (only when konteks_kode = REVISI)
            'code_dokumen'                  => ['nullable', 'string', 'max:100'],
            'alasan_revisi'                 => ['nullable', 'string', 'max:1000'],
            'revisi_detail'                 => ['nullable', 'array'],
            'revisi_detail.*.field_salah'   => ['nullable', 'string', 'max:50'],
            'revisi_detail.*.value_salah'   => ['nullable', 'string', 'max:50'],
            'revisi_detail.*.field_benar'   => ['nullable', 'string', 'max:50'],
            'revisi_detail.*.value_benar'   => ['nullable', 'string', 'max:50'],
        ]);

        // Conditional require untuk REVISI BU
        if ($request->konteks_kode === 'REVISI') {
            $request->validate([
                'code_dokumen' => ['required', 'string', 'max:100'],
            ], [
                'code_dokumen.required' => 'Code Transaction / Dokumen wajib diisi untuk BU Revisi.',
            ]);
        }

        $user = auth()->user();
        $now  = Carbon::now();

        // Generate unique BA code
        $baCode = 'BA-' . $now->format('YmdHis') . '-' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        DB::beginTransaction();
        try {
            // 1. Insert header BA
            DB::table('Tr_Ba_Main_New')->insert([
                'Tr_BA_Main_Code'   => $baCode,
                'Ms_BA_type_Code'   => $request->konteks_kode,
                'Ms_Emp_Code'       => $request->emp_code,
                'Ms_Emp_Div'        => $request->emp_div ?? '',
                'Ms_Pelapor_Code'   => $user->username ?? 'system',
                'Ms_Pelapor_Div'    => '',
                'Date_BA'           => $request->tanggal,
                'BA_Desc'           => $request->deskripsi,
                'ba_temuan'         => $request->ba_temuan ?? null,
                'ba_rekomendasi'    => $request->ba_rekomendasi ?? null,
                'CekPelanggaran'    => 0, 'CekKerusakan' => 0, 'CekFraud'     => 0,
                'CekRevisi'         => 0, 'CekDisiplin'  => 0, 'CekSalahIsi'  => 0,
                'CekNoClosing'      => 0, 'CekLaka'      => 0, 'CekPembelian' => 0,
                'CekKehilangan'     => 0, 'CekPerubahanSOP' => 0,
                'Ms_Kasus'          => $request->ms_kasus ?? '',
                'MS_Detail_Kasus'   => '',
                'Tr_EmpPeriod_Code' => '',
                'rec_usercreated'   => $user->username ?? 'system',
                'rec_datecreated'   => $now,
                'rec_comcode'       => $request->company_code ?? '',
                'rec_areacode'      => $request->lokasi_code ?? '',
                'rec_status'        => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            // 2. Insert pivot kategori — 1 row per (kategori, opsi).
            // Kalau kategori tidak punya opsi terpilih, tetap insert 1 row dengan opsi_id=NULL.
            foreach ($request->kategori as $kat) {
                if (empty($kat['id'])) continue;
                $opsiList = $kat['opsi'] ?? [];
                if (empty($opsiList)) {
                    // 1 row tanpa opsi
                    DB::table('tr_ba_kategori_d')->insert([
                        'tr_ba_main_code' => $baCode,
                        'kategori_id'     => $kat['id'],
                        'opsi_id'         => null,
                        'created_by'      => $user->username ?? 'system',
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ]);
                } else {
                    foreach ($opsiList as $opsiId) {
                        DB::table('tr_ba_kategori_d')->insert([
                            'tr_ba_main_code' => $baCode,
                            'kategori_id'     => $kat['id'],
                            'opsi_id'         => (int) $opsiId,
                            'created_by'      => $user->username ?? 'system',
                            'created_at'      => $now,
                            'updated_at'      => $now,
                        ]);
                    }
                }
            }

            // 3a. Insert ke 3 tabel legacy bila BU = REVISI
            if ($request->konteks_kode === 'REVISI') {
                $reqCode = 'REQ-' . $now->format('YmdHis') . '-' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

                // Header request revisi
                DB::table('tr_ba_request_revisi')->insert([
                    'tr_ba_request_revisi_code' => $reqCode,
                    'tr_ba_main_code'           => $baCode,
                    'note'                      => $request->alasan_revisi ?? '',
                    'user_created'              => $user->username ?? 'system',
                    'user_updated'              => $user->username ?? 'system',
                    'rec_status'                => 1,
                    'rec_datecreated'           => $now,
                    'created_at'                => $now,
                    'updated_at'                => $now,
                ]);

                // Detail per field salah → benar
                $details = collect($request->revisi_detail ?? [])
                            ->filter(fn($r) => !empty(trim($r['field_salah'] ?? '')) || !empty(trim($r['field_benar'] ?? '')))
                            ->values();

                foreach ($details as $row) {
                    DB::table('tr_ba_salah_isi_detail')->insert([
                        'tr_ba_code_main'    => $baCode,
                        'tr_ba_code_request' => $reqCode,
                        'code_doc'           => $request->code_dokumen ?? '',
                        'field_salah'        => $row['field_salah'] ?? '',
                        'value_salah'        => $row['value_salah'] ?? '',
                        'field_benar'        => $row['field_benar'] ?? '',
                        'value_benar'        => $row['value_benar'] ?? '',
                        'created_at'         => $now,
                        'updated_at'         => $now,
                    ]);
                }

                // Entry workflow approval (Tr_BA_Revisi) — pakai detail pertama sebagai ringkasan
                $first = $details->first() ?? [];
                $revisiCode = 'REV-' . $now->format('YmdHis') . '-' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

                DB::table('Tr_BA_Revisi')->insert([
                    'Tr_BA_Revisi_Code'      => $revisiCode,
                    'Tr_BA_Main_Code'        => $baCode,
                    'Code_Transaction'       => $request->code_dokumen ?? '',
                    'FieldSalah'             => $first['field_salah'] ?? '',
                    'ValueFieldSalah'        => $first['value_salah'] ?? '',
                    'FieldSeharusnya'        => $first['field_benar'] ?? '',
                    'ValueFieldSeharusnya'   => $first['value_benar'] ?? '',
                    // Approval flags awal — menunggu (null/0)
                    'Mgt_Code'               => '',
                    'Gm_Code'                => '',
                    'It_Code'                => '',
                    'It_Note'                => '',
                    'CeK_It_Approval'        => 0,
                    'CeK_Gm_Approval'        => 0,
                    'created_at'             => $now,
                    'updated_at'             => $now,
                ]);
            }

            // 3b. Insert kronologi (bila ada)
            if ($request->kronologi) {
                foreach ($request->kronologi as $i => $teks) {
                    if (empty(trim($teks ?? ''))) continue;
                    DB::table('tr_ba_kronologi')->insert([
                        'tr_ba_kronologi_code' => 'KRO-' . $baCode . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                        'tr_ba_main_code'      => $baCode,
                        'kronlogi'             => $teks,
                        'created_at'           => $now,
                        'updated_at'           => $now,
                    ]);
                }
            }

            DB::commit();

            // ── Notifikasi WhatsApp ──────────────────────────────────────────
            // Kumpulkan data tambahan (lookup nama, cabang, lokasi, kategori)
            // Gagal tidak membatalkan penyimpanan BA
            try {
                // Nama karyawan (subject) — cross-DB ke mysql_new
                $erpDbName = config('database.connections.mysql_new.database');
                $empName = DB::table("{$erpDbName}.Ms_User_Emp")
                    ->where('Ms_Emp_Code', $request->emp_code)
                    ->value('Emp_Name') ?? $request->emp_code;

                // Deskripsi lokasi & cabang
                $lokasiDesc = $request->lokasi_code
                    ? (DB::table('ms_lokasi')->where('lokasi_code', $request->lokasi_code)->value('lokasi_desc') ?? '-')
                    : '-';
                $cabangDesc = $request->company_code
                    ? (DB::table('ms_company')->where('company_code', $request->company_code)->value('description') ?? '-')
                    : '-';

                // Format kategori: "Temuan Kasus → opsi1, opsi2" atau "(tidak pilih opsi)"
                $kategoriIds = collect($request->kategori)->pluck('id')->filter()->unique()->all();
                $kategoriMap = DB::table('ms_ba_kategori')->whereIn('id', $kategoriIds)->pluck('nama', 'id');
                $allOpsiIds  = collect($request->kategori)->flatMap(fn($k) => $k['opsi'] ?? [])->filter()->unique()->all();
                $opsiMap     = $allOpsiIds
                    ? DB::table('ms_ba_kategori_opsi')->whereIn('id', $allOpsiIds)->pluck('deskripsi', 'id')
                    : collect();

                $kategoriLines = [];
                foreach ($request->kategori as $kat) {
                    if (empty($kat['id'])) continue;
                    $nama     = $kategoriMap->get($kat['id'], "ID:{$kat['id']}");
                    $opsiTeks = collect($kat['opsi'] ?? [])
                        ->map(fn($id) => $opsiMap->get($id))
                        ->filter()
                        ->implode(', ');
                    $kategoriLines[] = $nama . ($opsiTeks ? " → {$opsiTeks}" : ' → (tidak pilih opsi)');
                }

                // Format kronologi
                $kronoLines = collect($request->kronologi ?? [])
                    ->map(fn($t) => trim($t))
                    ->filter()
                    ->values()
                    ->map(fn($t, $i) => ($i + 1) . ". {$t}")
                    ->implode("\n");

                // Info pelapor
                $pelaporInfo = trim(($user->name ?? $user->username ?? 'system')
                    . ($user->ms_company ? ' (' . $user->ms_company . ($user->ms_divisi ? ' · ' . $user->ms_divisi : '') . ')' : ''));

                (new WaQontakService())->sendBaNotification([
                    'ba_code'   => $baCode,
                    'bu_kode'   => $request->konteks_kode,
                    'tanggal'   => $request->tanggal,
                    'pelapor'   => $pelaporInfo,
                    'emp_name'  => $empName,
                    'emp_div'   => $request->emp_div ?? '-',
                    'cabang'    => $cabangDesc,
                    'lokasi'    => $lokasiDesc,
                    'deskripsi' => $request->deskripsi,
                    'kategori'  => implode("\n", $kategoriLines) ?: '-',
                    'kronologi' => $kronoLines ?: '-',
                ]);
            } catch (\Throwable $e) {
                Log::warning("WA notification gagal untuk BA {$baCode}: " . $e->getMessage());
            }
            // ────────────────────────────────────────────────────────────────

            return redirect()->route('berita-acara-v2.print', ['kode' => $baCode])
                             ->with('success', "BA berhasil dibuat dengan kode <strong>{$baCode}</strong>. Silakan print dan dapatkan signature dari supervisor, HOD, manager, dan BOD.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['submit' => 'Gagal simpan: ' . $e->getMessage()])->withInput();
        }
    }
}
