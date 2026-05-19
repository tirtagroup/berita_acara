<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function create()
    {
        $businessUnits = BusinessUnit::where('active', true)->orderBy('id')->get();

        // Lokasi & company dari master existing
        $lokasi  = DB::table('ms_lokasi')->select('lokasi_code', 'lokasi_desc')->orderBy('lokasi_desc')->get();
        $company = DB::table('ms_company')->select('company_code', 'description')->orderBy('description')->get();
        $divisi  = DB::table('ms_divisi')->select('subbdiv_code', 'subbdiv_desc')->orderBy('subbdiv_desc')->get();

        return view('berita_acara_v2.wizard', compact('businessUnits', 'lokasi', 'company', 'divisi'));
    }

    /**
     * AJAX: search karyawan dari master_employees.
     * Return: [{id: emp_id, text: "EMP_ID — Nama", divisi: emp_iddivision}]
     */
    public function searchEmployees(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $rows = DB::table('master_employees')
                    ->where(function ($w) use ($q) {
                        $w->where('emp_id', 'like', "%{$q}%")
                          ->orWhere('emp_name', 'like', "%{$q}%");
                    })
                    ->where(function ($w) {
                        $w->whereNull('emp_inactive')
                          ->orWhere('emp_inactive', '!=', 'Y')
                          ->orWhere('emp_inactive', '');
                    })
                    ->select('emp_id', 'emp_name', 'emp_iddivision')
                    ->orderBy('emp_name')
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
     * AJAX: list kategori untuk BU tertentu, urutkan wajib → disarankan → opsional.
     */
    public function kategoriByBu($buKode)
    {
        $bu = BusinessUnit::where('kode', $buKode)->first();
        if (!$bu) return response()->json([], 404);

        // Ambil HANYA kategori yang mapped ke BU yang dipilih (inner join via whereNotNull).
        $rows = DB::table('ms_ba_kategori as k')
                    ->join('ms_bu_kategori_mapping as m', function ($j) use ($bu) {
                        $j->on('m.kategori_id', '=', 'k.id')
                          ->where('m.bu_id', '=', $bu->id);
                    })
                    ->where('k.active', true)
                    ->select('k.id', 'k.kode', 'k.nama', 'm.level')
                    ->orderByRaw("FIELD(m.level, 'wajib', 'disarankan', 'opsional')")
                    ->orderBy('k.nama')
                    ->get();

        // Compute domain per kategori berdasarkan BU mana yang punya level WAJIB.
        // - Wajib hanya di FNB        → FNB
        // - Wajib hanya di LAKA       → LAKA
        // - Lainnya (no wajib / wajib di multiple BU / wajib di OP_HR saja) → UMUM
        $wajibByKategori = DB::table('ms_bu_kategori_mapping as m')
            ->join('ms_business_unit as bu', 'm.bu_id', '=', 'bu.id')
            ->where('m.level', 'wajib')
            ->select('m.kategori_id', 'bu.kode')
            ->get()
            ->groupBy('kategori_id');

        foreach ($rows as $r) {
            $wajibKodes = $wajibByKategori->get($r->id, collect())->pluck('kode')->all();
            if (count($wajibKodes) === 1) {
                $r->domain = in_array($wajibKodes[0], ['FNB', 'LAKA', 'REVISI']) ? $wajibKodes[0] : 'UMUM';
            } else {
                $r->domain = 'UMUM';
            }
            // Bila kategori tidak ada di mapping untuk BU saat ini, default level = 'opsional'
            $r->level = $r->level ?? 'opsional';
        }

        return response()->json([
            'selected_bu' => $buKode,
            'kategori'    => $rows,
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

        // Filter by BU bila parameter diberikan
        if ($buKode = $request->query('bu')) {
            $query->whereExists(function ($q) use ($buKode) {
                $q->select(DB::raw(1))
                  ->from('ms_opsi_bu_mapping as ob')
                  ->join('ms_business_unit as bu', 'ob.bu_id', '=', 'bu.id')
                  ->whereColumn('ob.opsi_id', 'o.id')
                  ->where('bu.kode', $buKode);
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
            'bu_kode'            => ['required', 'string', 'exists:ms_business_unit,kode'],
            'tanggal'            => ['required', 'date'],
            'lokasi_code'        => ['nullable', 'string', 'max:50'],
            'company_code'       => ['nullable', 'string', 'max:50'],
            'emp_code'           => ['required', 'string', 'max:100'],
            'emp_div'            => ['nullable', 'string', 'max:100'],
            'deskripsi'          => ['required', 'string', 'max:500'],
            'kategori'           => ['required', 'array', 'min:1'],
            'kategori.*.id'      => ['required', 'integer', 'exists:ms_ba_kategori,id'],
            'kategori.*.opsi'    => ['nullable', 'array'],
            'kategori.*.opsi.*'  => ['integer', 'exists:ms_ba_kategori_opsi,id'],
            'kronologi'          => ['nullable', 'array'],
            'kronologi.*'        => ['nullable', 'string', 'max:2000'],
            // Revisi fields (only when bu_kode = REVISI)
            'code_dokumen'                  => ['nullable', 'string', 'max:100'],
            'alasan_revisi'                 => ['nullable', 'string', 'max:1000'],
            'revisi_detail'                 => ['nullable', 'array'],
            'revisi_detail.*.field_salah'   => ['nullable', 'string', 'max:50'],
            'revisi_detail.*.value_salah'   => ['nullable', 'string', 'max:50'],
            'revisi_detail.*.field_benar'   => ['nullable', 'string', 'max:50'],
            'revisi_detail.*.value_benar'   => ['nullable', 'string', 'max:50'],
        ]);

        // Conditional require untuk REVISI BU
        if ($request->bu_kode === 'REVISI') {
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
                'Ms_BA_type_Code'   => $request->bu_kode,
                'Ms_Emp_Code'       => $request->emp_code,
                'Ms_Emp_Div'        => $request->emp_div ?? '',
                'Ms_Pelapor_Code'   => $user->username ?? 'system',
                'Ms_Pelapor_Div'    => '',
                'Date_BA'           => $request->tanggal,
                'BA_Desc'           => $request->deskripsi,
                'CekPelanggaran'    => 0, 'CekKerusakan' => 0, 'CekFraud'     => 0,
                'CekRevisi'         => 0, 'CekDisiplin'  => 0, 'CekSalahIsi'  => 0,
                'CekNoClosing'      => 0, 'CekLaka'      => 0, 'CekPembelian' => 0,
                'CekKehilangan'     => 0, 'CekPerubahanSOP' => 0,
                'Ms_Kasus'          => '',
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
            if ($request->bu_kode === 'REVISI') {
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

            return redirect()->route('berita-acara-v2.create')
                             ->with('success', "BA berhasil dibuat dengan kode <strong>{$baCode}</strong>.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['submit' => 'Gagal simpan: ' . $e->getMessage()])->withInput();
        }
    }
}
