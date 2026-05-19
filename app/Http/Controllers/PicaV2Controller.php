<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\PicaKategori;
use App\Models\PicaPertanyaanMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller PICA v2.
 *
 * Wizard 6-step → insert ke Tr_PICA_Emp_h (legacy) + tr_pica_participants
 * + tr_pica_kategori_d + tr_pica_pertanyaan_d
 */
class PicaV2Controller extends Controller
{
    public function create(Request $request)
    {
        $businessUnits = BusinessUnit::where('active', true)->orderBy('id')->get();
        $kategoriList  = PicaKategori::where('active', true)->orderBy('nama')->get();
        $wajibList     = PicaPertanyaanMaster::where('active', true)
                            ->where('scope', PicaPertanyaanMaster::SCOPE_WAJIB)
                            ->orderBy('urutan')->get();
        $bantuanList   = PicaPertanyaanMaster::where('active', true)
                            ->where('scope', PicaPertanyaanMaster::SCOPE_BANTUAN)
                            ->orderBy('urutan')->get();
        $company = DB::table('ms_company')->select('company_code', 'description')->orderBy('description')->get();
        $lokasi  = DB::table('ms_lokasi')->select('lokasi_code', 'lokasi_desc')->orderBy('lokasi_desc')->get();

        // Optional pre-fill BA link
        $baCodePrefill = $request->query('ba_code');

        return view('pica_v2.wizard', compact(
            'businessUnits', 'kategoriList', 'wajibList', 'bantuanList',
            'company', 'lokasi', 'baCodePrefill'
        ));
    }

    /**
     * AJAX: search BA by code (untuk step 2 BA link).
     */
    public function searchBa(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 3) return response()->json(['results' => []]);

        $rows = DB::table('Tr_Ba_Main_New')
                    ->where('Tr_BA_Main_Code', 'like', "%{$q}%")
                    ->orderByDesc('rec_datecreated')
                    ->limit(20)
                    ->get(['Tr_BA_Main_Code', 'BA_Desc']);

        return response()->json([
            'results' => $rows->map(fn($r) => [
                'id'   => $r->Tr_BA_Main_Code,
                'text' => "{$r->Tr_BA_Main_Code} — " . \Illuminate\Support\Str::limit($r->BA_Desc, 60),
            ]),
        ]);
    }

    /**
     * AJAX: search users (untuk Dewan picker step 4).
     */
    public function searchUsers(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) return response()->json(['results' => []]);

        $rows = DB::table('users')
                    ->where(function ($w) use ($q) {
                        $w->where('username', 'like', "%{$q}%")
                          ->orWhere('name', 'like', "%{$q}%");
                    })
                    ->orderBy('name')
                    ->limit(30)
                    ->get(['id', 'username', 'name', 'ms_divisi', 'ms_company']);

        return response()->json([
            'results' => $rows->map(fn($r) => [
                'id'   => $r->id,
                'text' => trim("{$r->username} — " . ($r->name ?: '(no name)')
                    . ($r->ms_divisi ? " · {$r->ms_divisi}" : '')
                    . ($r->ms_company ? " · {$r->ms_company}" : '')),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bu_kode'             => ['required', 'string', 'exists:ms_business_unit,kode'],
            'ba_link_code'        => ['nullable', 'string', 'max:100'],
            'pelaku_emp_code'     => ['required', 'string', 'max:100'],
            'tanggal'             => ['required', 'date'],
            'kapan_terjadi'       => ['nullable', 'date'],
            'company_code'        => ['nullable', 'string', 'max:50'],
            'lokasi_code'         => ['nullable', 'string', 'max:50'],
            'pernah_kejadian'     => ['nullable', 'in:pertama,berulang'],
            'problem_note'        => ['required', 'string', 'max:500'],
            'kategori_ids'        => ['nullable', 'array'],
            'kategori_ids.*'      => ['integer', 'exists:ms_pica_kategori,id'],
            'dewan_user_ids'      => ['required', 'array', 'min:1'],
            'dewan_user_ids.*'    => ['integer'], // FK ke users not enforced strictly
            'bantuan_ids'         => ['nullable', 'array'],
            'bantuan_ids.*'       => ['integer', 'exists:ms_pica_pertanyaan_master,id'],
            'bantuan_wajib_ids'   => ['nullable', 'array'],
            'bantuan_wajib_ids.*' => ['integer'],
            'bebas'               => ['nullable', 'array'],
            'bebas.*.pertanyaan'  => ['nullable', 'string', 'max:1000'],
            'bebas.*.tipe'        => ['nullable', 'in:pertanyaan,pernyataan'],
            'bebas.*.wajib_jawab' => ['nullable', 'boolean'],
        ]);

        $user = auth()->user();
        $now  = Carbon::now();

        // Generate PICA code (max 50 chars per legacy schema)
        $picaCode = 'PICA-' . $now->format('YmdHis') . '-' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        DB::beginTransaction();
        try {
            // 1. Insert Tr_PICA_Emp_h (legacy)
            DB::table('Tr_PICA_Emp_h')->insert([
                'Tr_Pica_Emp_h_Code'           => $picaCode,
                'Emp_Code'                     => $request->pelaku_emp_code,
                'NoBA'                         => $request->ba_link_code,
                'Date_PICA'                    => $now,
                'Problem_Note'                 => $request->problem_note,
                'Kapan_Terjadi'                => $request->kapan_terjadi,
                'Ms_Company'                   => $request->company_code,
                'Ms_Location'                  => $request->lokasi_code,
                'Apakah_Sudah_Pernah_Kejadian' => $request->pernah_kejadian,
                'Status_PICA'                  => 'WAITING_PELAKU',
                'User_Created'                 => $user->username ?? 'system',
                'created_at'                   => $now,
                'updated_at'                   => $now,
            ]);

            // 2. Insert participants
            // 2a. PIC = current user
            DB::table('tr_pica_participants')->insert([
                'tr_pica_main_code' => $picaCode,
                'user_id'           => $user->id,
                'role'              => 'pic',
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            // 2b. Pelaku (lookup user by emp_code; insert as participant if user account exists)
            $pelakuUserId = DB::table('users')
                ->whereRaw('LOWER(username) = ?', [mb_strtolower($request->pelaku_emp_code)])
                ->value('id');
            if ($pelakuUserId && $pelakuUserId !== $user->id) {
                DB::table('tr_pica_participants')->insert([
                    'tr_pica_main_code' => $picaCode,
                    'user_id'           => $pelakuUserId,
                    'role'              => 'pelaku',
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]);
            }

            // 2c. Dewan members
            foreach ($request->dewan_user_ids as $duId) {
                if ($duId == $user->id) continue; // avoid duplicate (PIC tidak juga dewan)
                DB::table('tr_pica_participants')->insertOrIgnore([
                    'tr_pica_main_code' => $picaCode,
                    'user_id'           => (int) $duId,
                    'role'              => 'dewan',
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]);
            }

            // 3. Insert kategori pivot
            foreach (($request->kategori_ids ?? []) as $katId) {
                DB::table('tr_pica_kategori_d')->insertOrIgnore([
                    'tr_pica_main_code' => $picaCode,
                    'kategori_id'       => (int) $katId,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]);
            }

            // 4. Insert pertanyaan
            $urutan = 0;
            $bantuanWajib = collect($request->bantuan_wajib_ids ?? [])->map(fn($id) => (int) $id)->all();

            // 4a. Wajib universal (auto include all active)
            $wajibUniversal = PicaPertanyaanMaster::where('active', true)
                                ->where('scope', PicaPertanyaanMaster::SCOPE_WAJIB)
                                ->orderBy('urutan')->get();
            foreach ($wajibUniversal as $m) {
                DB::table('tr_pica_pertanyaan_d')->insert([
                    'tr_pica_main_code'     => $picaCode,
                    'pertanyaan_master_id'  => $m->id,
                    'pertanyaan'            => $m->pertanyaan,
                    'tipe'                  => $m->tipe,
                    'wajib_jawab'           => true, // wajib universal always wajib
                    'urutan'                => $urutan++,
                    'created_by'            => $user->id,
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ]);
            }

            // 4b. Bantuan yang dipilih
            foreach (($request->bantuan_ids ?? []) as $bId) {
                $m = PicaPertanyaanMaster::find($bId);
                if (!$m) continue;
                DB::table('tr_pica_pertanyaan_d')->insert([
                    'tr_pica_main_code'     => $picaCode,
                    'pertanyaan_master_id'  => $m->id,
                    'pertanyaan'            => $m->pertanyaan,
                    'tipe'                  => $m->tipe,
                    'wajib_jawab'           => in_array($m->id, $bantuanWajib),
                    'urutan'                => $urutan++,
                    'created_by'            => $user->id,
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ]);
            }

            // 4c. Bebas (ad-hoc)
            foreach (($request->bebas ?? []) as $b) {
                if (empty(trim($b['pertanyaan'] ?? ''))) continue;
                DB::table('tr_pica_pertanyaan_d')->insert([
                    'tr_pica_main_code'     => $picaCode,
                    'pertanyaan_master_id'  => null,
                    'pertanyaan'            => $b['pertanyaan'],
                    'tipe'                  => $b['tipe'] ?? 'pertanyaan',
                    'wajib_jawab'           => !empty($b['wajib_jawab']),
                    'urutan'                => $urutan++,
                    'created_by'            => $user->id,
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ]);
            }

            DB::commit();
            return redirect()->route('pica-v2.create')
                ->with('success', "PICA berhasil dibuat dengan kode <strong>{$picaCode}</strong>. Status: WAITING_PELAKU.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['submit' => 'Gagal simpan: ' . $e->getMessage()])->withInput();
        }
    }
}
