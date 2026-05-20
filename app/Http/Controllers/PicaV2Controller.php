<?php

namespace App\Http\Controllers;

use App\Models\Konteks;
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
        $konteksList = Konteks::where('active', true)->orderBy('id')->get();
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
            'konteksList', 'kategoriList', 'wajibList', 'bantuanList',
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
            'konteks_kode'             => ['required', 'string', 'exists:ms_konteks,kode'],
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
            // 1. Insert Tr_PICA_Emp_h (legacy + konteks_kode kolom baru)
            DB::table('Tr_PICA_Emp_h')->insert([
                'Tr_Pica_Emp_h_Code'           => $picaCode,
                'Emp_Code'                     => $request->pelaku_emp_code,
                'NoBA'                         => $request->ba_link_code,
                'konteks_kode'                      => $request->konteks_kode,
                'Date_PICA'                    => $now,
                'Problem_Note'                 => $request->problem_note,
                'Kapan_Terjadi'                => $request->kapan_terjadi,
                'Ms_Company'                   => $request->company_code,
                'Ms_Location'                  => $request->lokasi_code,
                'Apakah_Sudah_Pernah_Kejadian' => $request->pernah_kejadian,
                'Status_PICA'                  => 'PREPARING',
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
            return redirect()->route('pica-v2.discussion', ['kode' => $picaCode])
                ->with('success', "PICA berhasil dibuat dengan kode <strong>{$picaCode}</strong>. Status: <strong>PREPARING</strong> — Dewan & Pelaku boleh tambah pertanyaan/komentar sebelum pelaku mulai menjawab.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['submit' => 'Gagal simpan: ' . $e->getMessage()])->withInput();
        }
    }

    // =========================================================
    // FASE 3 — DISCUSSION (forum Q&A multi-participant)
    // =========================================================

    /**
     * Load discussion page untuk 1 PICA.
     * Dual-mode: PREPARING (siapkan pertanyaan) atau WAITING_PELAKU (pelaku jawab final).
     */
    public function discussion(Request $request)
    {
        $kode = trim($request->query('kode', ''));
        abort_unless($kode, 404, 'Kode PICA tidak diberikan');

        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404, 'PICA tidak ditemukan');

        $user = auth()->user();

        // Resolve roles current user di PICA ini
        $myRoles = DB::table('tr_pica_participants')
            ->where('tr_pica_main_code', $kode)
            ->where('user_id', $user->id)
            ->pluck('role')->all();

        // Pelaku lookup by emp_code → users.username (best-effort)
        $pelakuUser = DB::table('users')
            ->whereRaw('LOWER(username) = ?', [mb_strtolower($pica->Emp_Code ?? '')])
            ->first(['id', 'username', 'name']);
        $pelakuEmp = DB::table('master_employees')
            ->where('emp_id', $pica->Emp_Code)
            ->first(['emp_id', 'emp_name']);

        $isPic    = in_array('pic',    $myRoles, true);
        $isDewan  = in_array('dewan',  $myRoles, true);
        $isPelaku = in_array('pelaku', $myRoles, true)
            || ($pelakuUser && $pelakuUser->id == $user->id);
        $isParticipant = $isPic || $isDewan || $isPelaku;

        // Allow read-only access untuk non-participant (TBD per kebijakan)
        // Untuk sekarang: hanya participant yang boleh akses.
        abort_unless($isParticipant, 403, 'Anda bukan participant PICA ini');

        // Header data
        $participants = DB::table('tr_pica_participants as p')
            ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
            ->where('p.tr_pica_main_code', $kode)
            ->orderBy('p.role')
            ->get(['p.role', 'p.user_id', 'u.username', 'u.name']);

        $kategoriPica = DB::table('tr_pica_kategori_d as kd')
            ->join('ms_pica_kategori as k', 'k.id', '=', 'kd.kategori_id')
            ->where('kd.tr_pica_main_code', $kode)
            ->pluck('k.nama')->all();

        // Pertanyaan + jawabans
        $pertanyaanList = DB::table('tr_pica_pertanyaan_d as q')
            ->leftJoin('users as cu', 'cu.id', '=', 'q.created_by')
            ->where('q.tr_pica_main_code', $kode)
            ->orderBy('q.urutan')->orderBy('q.id')
            ->get(['q.*', 'cu.username as creator_username', 'cu.name as creator_name']);

        $pertanyaanIds = $pertanyaanList->pluck('id')->all();

        $jawabanByQ = collect();
        if (!empty($pertanyaanIds)) {
            $jawabanRows = DB::table('tr_pica_jawaban as j')
                ->leftJoin('users as u', 'u.id', '=', 'j.user_id')
                ->whereIn('j.pertanyaan_id', $pertanyaanIds)
                ->orderBy('j.is_final', 'desc')   // final di atas
                ->orderBy('j.created_at')
                ->get(['j.*', 'u.username', 'u.name']);

            $jawabanByQ = $jawabanRows->groupBy('pertanyaan_id');
        }

        // Wajib jawab progress (untuk gate WAITING_PELAKU → ACTION_PLANNING)
        $totalWajib   = $pertanyaanList->where('wajib_jawab', 1)->count();
        $terisiWajib  = $pertanyaanList
            ->where('wajib_jawab', 1)
            ->filter(fn($q) => isset($jawabanByQ[$q->id]) && $jawabanByQ[$q->id]->where('is_final', 1)->count() > 0)
            ->count();

        // BA induk info (kalau ada)
        $baInduk = null;
        if (!empty($pica->NoBA)) {
            $baInduk = DB::table('Tr_Ba_Main_New')
                ->where('Tr_BA_Main_Code', $pica->NoBA)
                ->first(['Tr_BA_Main_Code', 'BA_Desc']);
        }

        return view('pica_v2.discussion', compact(
            'pica', 'participants', 'pelakuEmp', 'pelakuUser', 'kategoriPica',
            'pertanyaanList', 'jawabanByQ', 'totalWajib', 'terisiWajib',
            'baInduk', 'isPic', 'isDewan', 'isPelaku'
        ));
    }

    /**
     * Add pertanyaan baru ke PICA (dari Dewan atau PIC, fase PREPARING/WAITING_PELAKU).
     */
    public function addPertanyaan(Request $request, string $kode)
    {
        $request->validate([
            'pertanyaan'  => ['required', 'string', 'max:1000'],
            'tipe'        => ['required', 'in:pertanyaan,pernyataan'],
            'wajib_jawab' => ['nullable', 'boolean'],
        ]);

        $user = auth()->user();
        $roles = $this->myRoles($kode, $user->id);
        $isPic    = in_array('pic',    $roles, true);
        $isDewan  = in_array('dewan',  $roles, true);
        $isPelaku = in_array('pelaku', $roles, true);

        // Pelaku tidak boleh tambah pertanyaan (hanya komentar)
        abort_unless($isPic || $isDewan, 403, 'Hanya PIC atau Dewan yang boleh tambah pertanyaan');

        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404);

        // Status check — tidak boleh tambah pertanyaan kalau sudah ACTION_PLANNING/CLOSED
        if (!in_array($pica->Status_PICA, ['PREPARING', 'WAITING_PELAKU'])) {
            return back()->withErrors(['add_q' => 'Tidak bisa tambah pertanyaan saat status ' . $pica->Status_PICA]);
        }

        // Wajib_jawab: PIC bebas toggle; Dewan default false (tapi boleh true bila request set)
        $wajib = $request->boolean('wajib_jawab');

        $maxUrutan = DB::table('tr_pica_pertanyaan_d')
            ->where('tr_pica_main_code', $kode)
            ->max('urutan');

        DB::table('tr_pica_pertanyaan_d')->insert([
            'tr_pica_main_code'    => $kode,
            'pertanyaan_master_id' => null,
            'pertanyaan'           => $request->pertanyaan,
            'tipe'                 => $request->tipe,
            'wajib_jawab'          => $wajib,
            'urutan'               => ($maxUrutan ?? 0) + 1,
            'created_by'           => $user->id,
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ]);

        return back()->with('success', 'Pertanyaan ditambahkan.');
    }

    /**
     * Add komentar/jawaban (non-final) ke pertanyaan tertentu.
     * Semua participant boleh kasih.
     */
    public function addJawaban(Request $request, string $kode, int $pertanyaanId)
    {
        $request->validate([
            'jawaban'    => ['nullable', 'string', 'max:2000'],
            'ack_status' => ['nullable', 'in:setuju,tidak_setuju'],
        ]);

        if (empty(trim($request->jawaban ?? '')) && empty($request->ack_status)) {
            return back()->withErrors(['jawaban' => 'Isi jawaban atau pilih ack_status.']);
        }

        $user = auth()->user();
        $roles = $this->myRoles($kode, $user->id);
        abort_unless(!empty($roles), 403, 'Anda bukan participant');

        // Pastikan pertanyaan milik kode ini
        $q = DB::table('tr_pica_pertanyaan_d')
            ->where('id', $pertanyaanId)
            ->where('tr_pica_main_code', $kode)
            ->first();
        abort_unless($q, 404, 'Pertanyaan tidak ditemukan di PICA ini');

        DB::table('tr_pica_jawaban')->insert([
            'pertanyaan_id' => $pertanyaanId,
            'user_id'       => $user->id,
            'jawaban'       => $request->jawaban,
            'ack_status'    => $request->ack_status,
            'is_final'      => false,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        return back()->with('success', 'Komentar ditambahkan.');
    }

    /**
     * Tandai jawaban sebagai final (hanya pelaku, status WAITING_PELAKU).
     * Idempotent: bila sudah ada is_final lain di pertanyaan yg sama, un-final yg lama.
     */
    public function setFinal(Request $request, string $kode, int $jawabanId)
    {
        $user = auth()->user();
        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404);

        // Cek pelaku
        $pelakuEmp = strtolower($pica->Emp_Code ?? '');
        $isPelaku  = strtolower($user->username ?? '') === $pelakuEmp;
        abort_unless($isPelaku, 403, 'Hanya pelaku yang boleh set is_final.');

        // Cek status
        abort_unless($pica->Status_PICA === 'WAITING_PELAKU', 403,
            'PICA harus pada status WAITING_PELAKU untuk set is_final.');

        $jawaban = DB::table('tr_pica_jawaban as j')
            ->join('tr_pica_pertanyaan_d as q', 'q.id', '=', 'j.pertanyaan_id')
            ->where('j.id', $jawabanId)
            ->where('q.tr_pica_main_code', $kode)
            ->first(['j.id', 'j.pertanyaan_id', 'j.user_id']);
        abort_unless($jawaban, 404, 'Jawaban tidak ditemukan');

        // Authorship: pelaku hanya boleh set final pada jawabannya sendiri
        abort_unless($jawaban->user_id == $user->id, 403, 'Anda hanya bisa set is_final pada jawaban Anda sendiri.');

        DB::transaction(function () use ($jawaban) {
            // Un-final jawaban lain di pertanyaan yg sama
            DB::table('tr_pica_jawaban')
                ->where('pertanyaan_id', $jawaban->pertanyaan_id)
                ->update(['is_final' => false, 'updated_at' => Carbon::now()]);
            DB::table('tr_pica_jawaban')
                ->where('id', $jawaban->id)
                ->update(['is_final' => true, 'updated_at' => Carbon::now()]);
        });

        return back()->with('success', 'Jawaban ditandai sebagai final.');
    }

    /**
     * Transisi status PICA. Aturan:
     *   - PREPARING → WAITING_PELAKU : PIC atau Pelaku
     *   - WAITING_PELAKU → ACTION_PLANNING : PIC, dengan semua wajib_jawab harus is_final
     *   - ACTION_PLANNING → CLOSED : PIC (Fase 4)
     */
    public function togglePhase(Request $request, string $kode)
    {
        $target = $request->input('target'); // 'WAITING_PELAKU' | 'ACTION_PLANNING' | 'CLOSED'

        $user = auth()->user();
        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404);

        $roles    = $this->myRoles($kode, $user->id);
        $isPic    = in_array('pic', $roles, true);
        $isPelaku = strtolower($user->username ?? '') === strtolower($pica->Emp_Code ?? '');

        $now = Carbon::now();

        switch ($target) {
            case 'WAITING_PELAKU':
                abort_unless($pica->Status_PICA === 'PREPARING', 422, 'Hanya dari PREPARING.');
                abort_unless($isPic || $isPelaku, 403, 'Hanya PIC atau Pelaku yang boleh trigger.');
                DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)
                    ->update(['Status_PICA' => 'WAITING_PELAKU', 'updated_at' => $now]);
                return back()->with('success', 'Status berubah ke WAITING_PELAKU. Pelaku sekarang bisa kasih jawaban final.');

            case 'ACTION_PLANNING':
                abort_unless($pica->Status_PICA === 'WAITING_PELAKU', 422, 'Hanya dari WAITING_PELAKU.');
                abort_unless($isPic, 403, 'Hanya PIC yang boleh lanjut ke ACTION_PLANNING.');

                // Validasi: semua wajib_jawab harus punya is_final
                $unanswered = DB::table('tr_pica_pertanyaan_d as q')
                    ->leftJoin('tr_pica_jawaban as j', function ($join) {
                        $join->on('j.pertanyaan_id', '=', 'q.id')
                             ->where('j.is_final', 1);
                    })
                    ->where('q.tr_pica_main_code', $kode)
                    ->where('q.wajib_jawab', 1)
                    ->whereNull('j.id')
                    ->count();
                if ($unanswered > 0) {
                    return back()->withErrors(['phase' => "Masih ada {$unanswered} pertanyaan wajib_jawab yang belum dijawab final oleh pelaku."]);
                }

                DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)
                    ->update(['Status_PICA' => 'ACTION_PLANNING', 'updated_at' => $now]);
                // Redirect ke report editor (Fase 4)
                return redirect()->route('pica-v2.report', ['kode' => $kode])
                    ->with('success', 'Status berubah ke ACTION_PLANNING. Silakan susun corrective & preventive action.');

            case 'BACK_TO_PREPARING':
                abort_unless($pica->Status_PICA === 'WAITING_PELAKU', 422, 'Hanya dari WAITING_PELAKU.');
                abort_unless($isPic, 403, 'Hanya PIC yang boleh balik ke PREPARING.');
                DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)
                    ->update(['Status_PICA' => 'PREPARING', 'updated_at' => $now]);
                return back()->with('success', 'Status balik ke PREPARING. Anda bisa edit pertanyaan dulu.');

            default:
                abort(422, 'Target status tidak dikenal.');
        }
    }

    /**
     * Hapus pertanyaan (PIC only). Cascade jawaban via FK.
     */
    public function deletePertanyaan(Request $request, string $kode, int $pertanyaanId)
    {
        $user = auth()->user();
        $roles = $this->myRoles($kode, $user->id);
        abort_unless(in_array('pic', $roles, true), 403, 'Hanya PIC yang boleh hapus pertanyaan.');

        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404);
        abort_unless(in_array($pica->Status_PICA, ['PREPARING', 'WAITING_PELAKU']), 422,
            'Tidak bisa hapus saat status ' . $pica->Status_PICA);

        $deleted = DB::table('tr_pica_pertanyaan_d')
            ->where('id', $pertanyaanId)
            ->where('tr_pica_main_code', $kode)
            ->delete();

        return $deleted
            ? back()->with('success', 'Pertanyaan dihapus.')
            : back()->withErrors(['del_q' => 'Pertanyaan tidak ditemukan.']);
    }

    /**
     * Helper: list role current user di PICA tertentu.
     */
    protected function myRoles(string $kode, int $userId): array
    {
        return DB::table('tr_pica_participants')
            ->where('tr_pica_main_code', $kode)
            ->where('user_id', $userId)
            ->pluck('role')->all();
    }

    // =========================================================
    // FASE 4 — COMPILE STRUCTURED REPORT (Sections A-G)
    // =========================================================

    /**
     * Load report editor. Auto-create draft row + auto-populate dari jawaban final
     * pelaku bila report belum ada.
     */
    public function report(Request $request)
    {
        $kode = trim($request->query('kode', ''));
        abort_unless($kode, 404);

        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404);

        $user = auth()->user();
        $roles = $this->myRoles($kode, $user->id);
        $isPic    = in_array('pic',    $roles, true);
        $isDewan  = in_array('dewan',  $roles, true);
        $isPelaku = strtolower($user->username ?? '') === strtolower($pica->Emp_Code ?? '');
        $isParticipant = $isPic || $isDewan || $isPelaku;
        abort_unless($isParticipant, 403);

        // Report hanya boleh diakses sejak ACTION_PLANNING
        abort_unless(in_array($pica->Status_PICA, ['ACTION_PLANNING', 'CLOSED']), 403,
            'Report hanya tersedia setelah PICA mencapai status ACTION_PLANNING. Status saat ini: ' . $pica->Status_PICA);

        // Auto-create + auto-populate dari Q&A bila belum ada
        $report = DB::table('tr_pica_reports')->where('tr_pica_main_code', $kode)->first();
        if (!$report) {
            $autoFill = $this->autoPopulateFromQA($kode);
            $insertData = array_merge([
                'tr_pica_main_code' => $kode,
                'compiled_by'       => $user->id,
                'compiled_at'       => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ], $autoFill);
            $reportId = DB::table('tr_pica_reports')->insertGetId($insertData);

            // Auto-create 5-Why rows bila ada jawaban final untuk WHY_1..WHY_5
            $whyRows = $this->autoPopulateWhyRows($kode);
            foreach ($whyRows as $i => $w) {
                DB::table('tr_pica_report_why')->insert([
                    'report_id'  => $reportId,
                    'urutan'     => $i + 1,
                    'pertanyaan' => $w['pertanyaan'],
                    'jawaban'    => $w['jawaban'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            $report = DB::table('tr_pica_reports')->where('id', $reportId)->first();
        }

        $whys = DB::table('tr_pica_report_why')
            ->where('report_id', $report->id)
            ->orderBy('urutan')->orderBy('id')
            ->get();
        $correctives = DB::table('tr_pica_report_action as a')
            ->leftJoin('users as u', 'u.id', '=', 'a.pic_user_id')
            ->where('a.report_id', $report->id)
            ->where('a.tipe', 'corrective')
            ->orderBy('a.urutan')->orderBy('a.id')
            ->get(['a.*', 'u.username as pic_username', 'u.name as pic_name']);
        $preventives = DB::table('tr_pica_report_action as a')
            ->leftJoin('users as u', 'u.id', '=', 'a.pic_user_id')
            ->where('a.report_id', $report->id)
            ->where('a.tipe', 'preventive')
            ->orderBy('a.urutan')->orderBy('a.id')
            ->get(['a.*', 'u.username as pic_username', 'u.name as pic_name']);

        $approver = $report->section_g_approver_id
            ? DB::table('users')->where('id', $report->section_g_approver_id)->first(['id', 'username', 'name'])
            : null;

        $isLocked = $pica->Status_PICA === 'CLOSED' || !$isPic && !$isDewan; // pelaku read-only

        return view('pica_v2.report', compact(
            'pica', 'report', 'whys', 'correctives', 'preventives',
            'approver', 'isPic', 'isDewan', 'isPelaku', 'isLocked'
        ));
    }

    /**
     * Map jawaban final pelaku → section A/B/F/G berdasarkan prefix kode master.
     */
    protected function autoPopulateFromQA(string $kode): array
    {
        // Ambil semua jawaban final beserta master kode-nya
        $rows = DB::table('tr_pica_pertanyaan_d as q')
            ->join('tr_pica_jawaban as j', function ($join) {
                $join->on('j.pertanyaan_id', '=', 'q.id')->where('j.is_final', 1);
            })
            ->leftJoin('ms_pica_pertanyaan_master as m', 'm.id', '=', 'q.pertanyaan_master_id')
            ->where('q.tr_pica_main_code', $kode)
            ->get(['m.kode as mkode', 'q.pertanyaan', 'j.jawaban', 'j.ack_status']);

        $sections = [
            'section_a_what'      => [],
            'section_a_when'      => [],
            'section_a_where'     => [],
            'section_a_who'       => [],
            'section_a_why_awal'  => [],
            'section_a_how'       => [],
            'section_a_howmuch'   => [],
            'section_b_man'       => [],
            'section_b_machine'   => [],
            'section_b_material'  => [],
            'section_b_method'    => [],
            'section_b_environment' => [],
        ];

        foreach ($rows as $r) {
            $kodeM = $r->mkode ?? '';
            $line  = '• ' . trim(($r->jawaban ?? '') . ($r->ack_status ? " [{$r->ack_status}]" : ''));
            if ($line === '• ') continue;

            if (str_starts_with($kodeM, 'WHAT_')) $sections['section_a_what'][] = $line;
            elseif (str_starts_with($kodeM, 'WHEN_'))    $sections['section_a_when'][] = $line;
            elseif (str_starts_with($kodeM, 'WHERE_'))   $sections['section_a_where'][] = $line;
            elseif (str_starts_with($kodeM, 'WHO_'))     $sections['section_a_who'][] = $line;
            elseif (str_starts_with($kodeM, 'WHY_KATEGORI') || $kodeM === 'WHY_DAMPAK')
                $sections['section_a_why_awal'][] = $line;
            elseif (str_starts_with($kodeM, 'HOWMUCH_')) $sections['section_a_howmuch'][] = $line;
            elseif (str_starts_with($kodeM, 'HOW_'))     $sections['section_a_how'][] = $line;
            elseif (str_starts_with($kodeM, 'MAN_'))     $sections['section_b_man'][] = $line;
            elseif (str_starts_with($kodeM, 'MACHINE_')) $sections['section_b_machine'][] = $line;
            elseif (str_starts_with($kodeM, 'MATERIAL_'))$sections['section_b_material'][] = $line;
            elseif (str_starts_with($kodeM, 'METHOD_'))  $sections['section_b_method'][] = $line;
            elseif (str_starts_with($kodeM, 'ENV_'))     $sections['section_b_environment'][] = $line;
        }

        // Build kolom hasil
        $out = [];
        foreach ($sections as $col => $items) {
            $out[$col] = empty($items) ? null : implode("\n", $items);
        }
        return $out;
    }

    protected function autoPopulateWhyRows(string $kode): array
    {
        $whys = DB::table('tr_pica_pertanyaan_d as q')
            ->join('tr_pica_jawaban as j', function ($join) {
                $join->on('j.pertanyaan_id', '=', 'q.id')->where('j.is_final', 1);
            })
            ->join('ms_pica_pertanyaan_master as m', 'm.id', '=', 'q.pertanyaan_master_id')
            ->whereIn('m.kode', ['WHY_1', 'WHY_2', 'WHY_3', 'WHY_4', 'WHY_5_ROOT_CAUSE'])
            ->where('q.tr_pica_main_code', $kode)
            ->orderBy('m.urutan')
            ->get(['m.kode', 'q.pertanyaan', 'j.jawaban']);

        return $whys->map(fn($r) => [
            'pertanyaan' => $r->pertanyaan,
            'jawaban'    => $r->jawaban,
        ])->all();
    }

    /**
     * Save section A/B/F/G narrative fields.
     */
    public function saveReport(Request $request, string $kode)
    {
        $request->validate([
            'section_a_what'           => ['nullable', 'string'],
            'section_a_when'           => ['nullable', 'string'],
            'section_a_where'          => ['nullable', 'string'],
            'section_a_who'            => ['nullable', 'string'],
            'section_a_why_awal'       => ['nullable', 'string'],
            'section_a_how'            => ['nullable', 'string'],
            'section_a_howmuch'        => ['nullable', 'string'],
            'section_b_man'            => ['nullable', 'string'],
            'section_b_machine'        => ['nullable', 'string'],
            'section_b_material'       => ['nullable', 'string'],
            'section_b_method'         => ['nullable', 'string'],
            'section_b_environment'    => ['nullable', 'string'],
            'section_f_kpi'            => ['nullable', 'string'],
            'section_f_review_schedule'=> ['nullable', 'string', 'max:255'],
            'section_f_audit_result'   => ['nullable', 'string'],
            'section_g_approver_id'    => ['nullable', 'integer'],
            'section_g_closure_date'   => ['nullable', 'date'],
            'section_g_pelajaran'      => ['nullable', 'string'],
            'section_g_dokumentasi_path' => ['nullable', 'string', 'max:500'],
        ]);

        $this->assertWritable($kode, ['pic', 'dewan']);

        $data = $request->only([
            'section_a_what', 'section_a_when', 'section_a_where', 'section_a_who',
            'section_a_why_awal', 'section_a_how', 'section_a_howmuch',
            'section_b_man', 'section_b_machine', 'section_b_material', 'section_b_method', 'section_b_environment',
            'section_f_kpi', 'section_f_review_schedule', 'section_f_audit_result',
        ]);

        // Section G hanya boleh diisi PIC
        $roles = $this->myRoles($kode, auth()->id());
        $isPic = in_array('pic', $roles, true);
        if ($isPic) {
            $data = array_merge($data, $request->only([
                'section_g_approver_id', 'section_g_closure_date',
                'section_g_pelajaran', 'section_g_dokumentasi_path',
            ]));
        }
        $data['updated_at'] = Carbon::now();

        DB::table('tr_pica_reports')->where('tr_pica_main_code', $kode)->update($data);

        return back()->with('success', 'Report (narrative) tersimpan.');
    }

    /**
     * Sync section C — 5 Why rows. Replace-all strategy.
     */
    public function saveWhys(Request $request, string $kode)
    {
        $request->validate([
            'whys'              => ['nullable', 'array'],
            'whys.*.pertanyaan' => ['nullable', 'string', 'max:500'],
            'whys.*.jawaban'    => ['nullable', 'string', 'max:1000'],
        ]);

        $this->assertWritable($kode, ['pic', 'dewan']);

        $report = DB::table('tr_pica_reports')->where('tr_pica_main_code', $kode)->first();
        abort_unless($report, 404);

        DB::transaction(function () use ($request, $report) {
            DB::table('tr_pica_report_why')->where('report_id', $report->id)->delete();
            foreach ($request->input('whys', []) as $i => $w) {
                $p = trim($w['pertanyaan'] ?? '');
                $j = trim($w['jawaban'] ?? '');
                if ($p === '' && $j === '') continue;
                DB::table('tr_pica_report_why')->insert([
                    'report_id'  => $report->id,
                    'urutan'     => $i + 1,
                    'pertanyaan' => $p ?: null,
                    'jawaban'    => $j ?: null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        });

        return back()->with('success', 'Section C (5 Why) tersimpan.');
    }

    /**
     * Sync section D/E — corrective + preventive actions. Replace-all strategy.
     */
    public function saveActions(Request $request, string $kode)
    {
        $request->validate([
            'tipe'                => ['required', 'in:corrective,preventive'],
            'actions'             => ['nullable', 'array'],
            'actions.*.deskripsi' => ['nullable', 'string', 'max:1000'],
            'actions.*.pic_user_id' => ['nullable', 'integer'],
            'actions.*.deadline'  => ['nullable', 'date'],
            'actions.*.status'    => ['nullable', 'in:pending,in_progress,done,cancelled'],
            'actions.*.notes'     => ['nullable', 'string', 'max:1000'],
            'actions.*.completed_at' => ['nullable', 'date'],
        ]);

        $this->assertWritable($kode, ['pic', 'dewan']);

        $report = DB::table('tr_pica_reports')->where('tr_pica_main_code', $kode)->first();
        abort_unless($report, 404);

        $tipe = $request->input('tipe');

        DB::transaction(function () use ($request, $report, $tipe) {
            DB::table('tr_pica_report_action')
                ->where('report_id', $report->id)
                ->where('tipe', $tipe)
                ->delete();
            foreach ($request->input('actions', []) as $i => $a) {
                $desc = trim($a['deskripsi'] ?? '');
                if ($desc === '') continue;
                DB::table('tr_pica_report_action')->insert([
                    'report_id'    => $report->id,
                    'tipe'         => $tipe,
                    'deskripsi'    => $desc,
                    'pic_user_id'  => $a['pic_user_id'] ?? null,
                    'deadline'     => $a['deadline'] ?? null,
                    'status'       => $a['status'] ?? 'pending',
                    'completed_at' => $a['completed_at'] ?? null,
                    'notes'        => $a['notes'] ?? null,
                    'urutan'       => $i + 1,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
                ]);
            }
        });

        return back()->with('success', ucfirst($tipe) . ' actions tersimpan.');
    }

    /**
     * Tutup PICA → status CLOSED.
     * Gate: ≥1 corrective + ≥1 preventive + section_g_closure_date filled.
     */
    public function closePica(Request $request, string $kode)
    {
        $user = auth()->user();
        $roles = $this->myRoles($kode, $user->id);
        abort_unless(in_array('pic', $roles, true), 403, 'Hanya PIC yang boleh close PICA.');

        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404);
        abort_unless($pica->Status_PICA === 'ACTION_PLANNING', 422,
            'Hanya bisa CLOSED dari ACTION_PLANNING. Status saat ini: ' . $pica->Status_PICA);

        $report = DB::table('tr_pica_reports')->where('tr_pica_main_code', $kode)->first();
        abort_unless($report, 422, 'Report belum dibuat.');

        $corrCount = DB::table('tr_pica_report_action')
            ->where('report_id', $report->id)->where('tipe', 'corrective')->count();
        $prevCount = DB::table('tr_pica_report_action')
            ->where('report_id', $report->id)->where('tipe', 'preventive')->count();

        $errors = [];
        if ($corrCount < 1)  $errors[] = 'Minimal 1 corrective action.';
        if ($prevCount < 1)  $errors[] = 'Minimal 1 preventive action.';
        if (!$report->section_g_closure_date) $errors[] = 'Section G closure_date harus diisi.';
        if (!empty($errors)) {
            return back()->withErrors(['close' => 'Gagal close: ' . implode(' ', $errors)]);
        }

        DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)
            ->update(['Status_PICA' => 'CLOSED', 'updated_at' => Carbon::now()]);

        return back()->with('success', 'PICA berhasil di-CLOSE. Terima kasih!');
    }

    /**
     * Helper: throw 403 bila user bukan role yang diizinkan, atau status PICA bukan ACTION_PLANNING.
     */
    protected function assertWritable(string $kode, array $allowedRoles): void
    {
        $pica = DB::table('Tr_PICA_Emp_h')->where('Tr_Pica_Emp_h_Code', $kode)->first();
        abort_unless($pica, 404);
        abort_unless($pica->Status_PICA === 'ACTION_PLANNING', 403,
            'Report tidak bisa di-edit pada status ' . $pica->Status_PICA);

        $roles = $this->myRoles($kode, auth()->id());
        abort_unless(!empty(array_intersect($roles, $allowedRoles)), 403,
            'Anda tidak punya hak edit report.');
    }

    // =========================================================
    // FASE 5 — DASHBOARD + LIST PICA V2
    // =========================================================

    /**
     * Dashboard PICA v2 — cards + charts + recent table.
     * Default date range: awal bulan ini → hari ini.
     */
    public function dashboard(Request $request)
    {
        [$tglAwal, $tglAkhir, $konteksKode] = $this->parseFilters($request);

        $konteksList = Konteks::where('active', true)->orderBy('id')->get();
        $kategoriList  = PicaKategori::where('active', true)->orderBy('nama')->get();

        $stats = $this->computeStats($tglAwal, $tglAkhir, $konteksKode);

        // Recent 10 PICA
        $recent = $this->baseQuery($tglAwal, $tglAkhir, $konteksKode)
            ->orderByDesc('h.Date_PICA')
            ->limit(10)
            ->get($this->baseColumns());

        // Enrich pelaku name + kategori
        $this->enrichRecent($recent);

        return view('pica_v2.dashboard', compact(
            'tglAwal', 'tglAkhir', 'buKode',
            'konteksList', 'kategoriList', 'stats', 'recent'
        ));
    }

    /**
     * AJAX JSON untuk re-render chart (dipakai bila user ubah filter tanpa reload).
     */
    public function dashboardData(Request $request)
    {
        [$tglAwal, $tglAkhir, $konteksKode] = $this->parseFilters($request);
        return response()->json($this->computeStats($tglAwal, $tglAkhir, $konteksKode));
    }

    /**
     * List PICA v2 — paginated dengan filter date/status/BU/kategori/pelaku.
     */
    public function list(Request $request)
    {
        [$tglAwal, $tglAkhir, $konteksKode] = $this->parseFilters($request);
        $status      = (array) $request->input('status', []);
        $kategoriIds = (array) $request->input('kategori_ids', []);
        $pelakuQ     = trim($request->input('pelaku', ''));
        $perPage     = in_array((int) $request->input('per_page'), [10, 25, 50, 100]) ? (int) $request->input('per_page') : 25;

        $q = $this->baseQuery($tglAwal, $tglAkhir, $konteksKode);

        if (!empty($status)) {
            $q->whereIn('h.Status_PICA', $status);
        }
        if (!empty($kategoriIds)) {
            $q->whereExists(function ($sub) use ($kategoriIds) {
                $sub->select(DB::raw(1))
                    ->from('tr_pica_kategori_d as kd')
                    ->whereColumn('kd.tr_pica_main_code', 'h.Tr_Pica_Emp_h_Code')
                    ->whereIn('kd.kategori_id', $kategoriIds);
            });
        }
        if ($pelakuQ !== '') {
            $q->where(function ($w) use ($pelakuQ) {
                $w->where('h.Emp_Code', 'like', "%{$pelakuQ}%")
                  ->orWhereExists(function ($sub) use ($pelakuQ) {
                      $sub->select(DB::raw(1))
                          ->from('master_employees as me')
                          ->whereColumn('me.emp_id', 'h.Emp_Code')
                          ->where('me.emp_name', 'like', "%{$pelakuQ}%");
                  });
            });
        }

        $rows = $q->orderByDesc('h.Date_PICA')
            ->paginate($perPage, $this->baseColumns())
            ->withQueryString();

        $this->enrichRecent($rows);

        $konteksList = Konteks::where('active', true)->orderBy('id')->get();
        $kategoriList  = PicaKategori::where('active', true)->orderBy('nama')->get();

        return view('pica_v2.list', compact(
            'rows', 'tglAwal', 'tglAkhir', 'buKode',
            'status', 'kategoriIds', 'pelakuQ', 'perPage',
            'konteksList', 'kategoriList'
        ));
    }

    /**
     * Helper: parse filter umum (tgl_awal, tgl_akhir, konteks_kode).
     */
    protected function parseFilters(Request $request): array
    {
        $tglAwal  = $request->input('tgl_awal',  Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tglAkhir = $request->input('tgl_akhir', Carbon::now()->format('Y-m-d'));
        $konteksKode   = $request->input('konteks_kode');
        return [$tglAwal, $tglAkhir, $konteksKode];
    }

    /**
     * Base query PICA list dengan filter date+BU diterapkan.
     */
    protected function baseQuery(string $tglAwal, string $tglAkhir, ?string $konteksKode)
    {
        $q = DB::table('Tr_PICA_Emp_h as h')
            ->whereBetween('h.Date_PICA', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);
        if (!empty($konteksKode)) {
            $q->where('h.konteks_kode', $konteksKode);
        }
        return $q;
    }

    protected function baseColumns(): array
    {
        return [
            'h.Tr_Pica_Emp_h_Code', 'h.Date_PICA', 'h.Status_PICA',
            'h.konteks_kode', 'h.NoBA', 'h.Emp_Code', 'h.Problem_Note',
            'h.User_Created', 'h.Ms_Company', 'h.Ms_Location',
        ];
    }

    /**
     * Tambah field pelaku_name + kategori list + counts ke rows recent/list.
     */
    protected function enrichRecent($rows): void
    {
        $codes  = collect($rows)->pluck('Tr_Pica_Emp_h_Code')->all();
        $empIds = collect($rows)->pluck('Emp_Code')->filter()->unique()->all();

        $empMap = [];
        if (!empty($empIds)) {
            $empMap = DB::table('master_employees')
                ->whereIn('emp_id', $empIds)
                ->pluck('emp_name', 'emp_id')->all();
        }

        $katMap = [];
        if (!empty($codes)) {
            $katRows = DB::table('tr_pica_kategori_d as kd')
                ->join('ms_pica_kategori as k', 'k.id', '=', 'kd.kategori_id')
                ->whereIn('kd.tr_pica_main_code', $codes)
                ->get(['kd.tr_pica_main_code', 'k.nama']);
            foreach ($katRows as $kr) {
                $katMap[$kr->tr_pica_main_code][] = $kr->nama;
            }
        }

        $progressMap = [];
        if (!empty($codes)) {
            $progRows = DB::table('tr_pica_pertanyaan_d as q')
                ->leftJoin('tr_pica_jawaban as j', function ($join) {
                    $join->on('j.pertanyaan_id', '=', 'q.id')->where('j.is_final', 1);
                })
                ->whereIn('q.tr_pica_main_code', $codes)
                ->where('q.wajib_jawab', 1)
                ->select('q.tr_pica_main_code',
                    DB::raw('COUNT(DISTINCT q.id) as total_wajib'),
                    DB::raw('COUNT(DISTINCT j.id) as terisi'))
                ->groupBy('q.tr_pica_main_code')
                ->get();
            foreach ($progRows as $pr) {
                $progressMap[$pr->tr_pica_main_code] = [
                    'total'  => (int) $pr->total_wajib,
                    'terisi' => (int) $pr->terisi,
                ];
            }
        }

        foreach ($rows as $r) {
            $r->pelaku_name = $empMap[$r->Emp_Code] ?? $r->Emp_Code;
            $r->kategori    = $katMap[$r->Tr_Pica_Emp_h_Code] ?? [];
            $r->progress    = $progressMap[$r->Tr_Pica_Emp_h_Code] ?? ['total' => 0, 'terisi' => 0];
        }
    }

    /**
     * Compute semua stats dashboard: status count, per BU, per kategori, trend daily.
     */
    protected function computeStats(string $tglAwal, string $tglAkhir, ?string $konteksKode): array
    {
        $base = fn() => $this->baseQuery($tglAwal, $tglAkhir, $konteksKode);

        // Per status — include legacy status "Belum Closing" untuk compat
        $statusRows = $base()
            ->select('h.Status_PICA', DB::raw('COUNT(*) as cnt'))
            ->groupBy('h.Status_PICA')
            ->get()->pluck('cnt', 'Status_PICA')->all();

        $statuses = ['DRAFT', 'PREPARING', 'WAITING_PELAKU', 'ACTION_PLANNING', 'CLOSED', 'Belum Closing'];
        $perStatus = [];
        foreach ($statuses as $s) {
            $perStatus[$s] = (int) ($statusRows[$s] ?? 0);
        }
        // Total = ALL rows (termasuk status legacy lain yang tidak tercantum)
        $total = $base()->count();

        // Per Konteks (kalau filter konteks aktif → hanya 1 konteks)
        $perKonteks = $base()
            ->select(DB::raw("COALESCE(NULLIF(h.konteks_kode, ''), 'UNKNOWN') as konteks"), DB::raw('COUNT(*) as cnt'))
            ->groupBy('konteks')
            ->orderByDesc('cnt')
            ->get()->map(fn($r) => ['konteks' => $r->konteks, 'cnt' => (int) $r->cnt])->all();

        // Per kategori (top 10)
        $perKategoriRaw = DB::table('tr_pica_kategori_d as kd')
            ->join('ms_pica_kategori as k', 'k.id', '=', 'kd.kategori_id')
            ->join('Tr_PICA_Emp_h as h', 'h.Tr_Pica_Emp_h_Code', '=', 'kd.tr_pica_main_code')
            ->whereBetween('h.Date_PICA', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);
        if (!empty($konteksKode)) {
            $perKategoriRaw->where('h.konteks_kode', $konteksKode);
        }
        $perKategori = $perKategoriRaw
            ->select('k.nama', DB::raw('COUNT(DISTINCT h.Tr_Pica_Emp_h_Code) as cnt'))
            ->groupBy('k.nama')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get()->map(fn($r) => ['nama' => $r->nama, 'cnt' => (int) $r->cnt])->all();

        // Trend daily
        $trendRaw = $base()
            ->select(DB::raw('DATE(h.Date_PICA) as tgl'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();
        // Fill zero untuk tanggal kosong
        $trend = [];
        $cur = Carbon::parse($tglAwal);
        $end = Carbon::parse($tglAkhir);
        $byDate = $trendRaw->pluck('cnt', 'tgl')->all();
        while ($cur->lte($end)) {
            $d = $cur->format('Y-m-d');
            $trend[] = ['tgl' => $d, 'cnt' => (int) ($byDate[$d] ?? 0)];
            $cur->addDay();
        }

        return [
            'total'       => $total,
            'per_status'  => $perStatus,
            'per_konteks' => $perKonteks,
            'per_kategori'=> $perKategori,
            'trend'       => $trend,
            'tgl_awal'    => $tglAwal,
            'tgl_akhir'   => $tglAkhir,
            'konteks_kode'     => $konteksKode,
        ];
    }
}
