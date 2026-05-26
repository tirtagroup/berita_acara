<?php

namespace App\Http\Controllers;

use App\Models\Konteks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Unified home / landing page V2 — gabung KPI BA + PICA.
 *
 * URL: /home-v2 (nama route: 'home-v2.index')
 * Dipakai sebagai redirect target setelah login (lihat LoginController).
 *
 * Per docs/conventions.md §1: default date range awal-bulan → hari ini.
 */
class HomeV2Controller extends Controller
{
    public function index(Request $request)
    {
        $tglAwal     = $request->input('tgl_awal',  Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tglAkhir    = $request->input('tgl_akhir', Carbon::now()->format('Y-m-d'));
        $konteksKode = $request->input('konteks_kode');

        $konteksList = Konteks::where('active', true)->orderBy('id')->get();

        // =========== BA STATS ===========
        $baQuery = DB::table('Tr_Ba_Main_New')
            ->whereBetween('Date_BA', [$tglAwal, $tglAkhir]);
        if ($konteksKode) {
            $baQuery->where('Ms_BA_type_Code', $konteksKode);
        }

        $baTotal = (clone $baQuery)->count();

        $baPerKonteks = (clone $baQuery)
            ->select('Ms_BA_type_Code as kode', DB::raw('COUNT(*) as cnt'))
            ->groupBy('Ms_BA_type_Code')
            ->orderByDesc('cnt')
            ->get();

        $baTopKategori = DB::table('tr_ba_kategori_d as d')
            ->join('ms_ba_kategori as k', 'd.kategori_id', '=', 'k.id')
            ->join('Tr_Ba_Main_New as ba', 'd.tr_ba_main_code', '=', 'ba.Tr_BA_Main_Code')
            ->whereBetween('ba.Date_BA', [$tglAwal, $tglAkhir])
            ->when($konteksKode, fn($q) => $q->where('ba.Ms_BA_type_Code', $konteksKode))
            ->select('k.nama', DB::raw('COUNT(DISTINCT d.tr_ba_main_code) as cnt'))
            ->groupBy('k.nama')
            ->orderByDesc('cnt')
            ->limit(8)
            ->get();

        $baRecent = (clone $baQuery)
            ->select('Tr_BA_Main_Code as kode', 'Date_BA', 'Ms_BA_type_Code as konteks',
                     'BA_Desc as deskripsi', 'Ms_Emp_Code as emp_code')
            ->orderByDesc('rec_datecreated')
            ->limit(8)
            ->get();

        // =========== PICA STATS ===========
        $picaQuery = DB::table('Tr_PICA_Emp_h')
            ->whereBetween('Date_PICA', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);
        if ($konteksKode) {
            $picaQuery->where('konteks_kode', $konteksKode);
        }

        $picaTotal = (clone $picaQuery)->count();

        // Per status — define ordered list for consistent display
        $picaStatusList = ['DRAFT', 'PREPARING', 'MEETING', 'FINALIZED', 'DONE'];
        $picaStatusRows = (clone $picaQuery)
            ->select('Status_PICA', DB::raw('COUNT(*) as cnt'))
            ->groupBy('Status_PICA')
            ->get()
            ->pluck('cnt', 'Status_PICA')
            ->all();
        $picaPerStatus = [];
        foreach ($picaStatusList as $s) {
            $picaPerStatus[$s] = (int) ($picaStatusRows[$s] ?? 0);
        }
        $picaDoneCount = $picaPerStatus['DONE'];
        $picaActiveCount = $picaTotal - $picaDoneCount; // semua kecuali DONE

        $picaRecent = (clone $picaQuery)
            ->select('Tr_Pica_Emp_h_Code as kode', 'Date_PICA',
                     'konteks_kode as konteks', 'Emp_Code as emp_code',
                     'Status_PICA as status', 'NoBA as ba_kode')
            ->orderByDesc('Date_PICA')
            ->limit(8)
            ->get();

        // =========== COMPUTED KPI ===========
        $closureRate = $picaTotal > 0 ? round(($picaDoneCount / $picaTotal) * 100, 1) : 0;
        $baToPicaRate = $baTotal > 0
            ? round((DB::table('Tr_PICA_Emp_h')
                ->whereBetween('Date_PICA', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59'])
                ->whereNotNull('NoBA')
                ->where('NoBA', '!=', '')
                ->count() / $baTotal) * 100, 1)
            : 0;

        return view('home-v2.index', compact(
            'tglAwal', 'tglAkhir', 'konteksKode', 'konteksList',
            // BA
            'baTotal', 'baPerKonteks', 'baTopKategori', 'baRecent',
            // PICA
            'picaTotal', 'picaPerStatus', 'picaActiveCount', 'picaDoneCount', 'picaRecent',
            // Computed
            'closureRate', 'baToPicaRate'
        ));
    }
}
