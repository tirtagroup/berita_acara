<?php

namespace App\Http\Controllers;

use App\Models\babydivisi;
use App\Models\BA_Main;
use Illuminate\Http\Request;
use App\Models\Ms_Case_Category;
use App\Models\BA_Salah_Isi_d;
use App\Models\Tr_BA_Kronologi;
use App\Models\BA_laka_header;
use App\Models\BA_laka_detail;
use App\Models\BA_docs;
use App\Models\BA_docs2;
use App\Models\ms_divisi;
use App\Models\MsBranch;
use App\Models\MsLocation;
use App\Models\MasterEmployee;
use App\Models\Ms_Jenis_BA;
use App\Models\Ms_Company;
use App\Models\total_ba_by_jenis;
use App\Models\babydivisi_permonth;
use Illuminate\Support\Facades\Auth;

use DB;

class DashboardController extends Controller
{
  public function getData(Request $request)
  {
      $filter = $request->input('filter'); // Filter berupa 'daily', 'weekly', 'monthly'

      // Lakukan query berdasarkan filter
      //$chartData = babydivisi::select('Ms_Emp_Div', 'total_ba')->get();
      $data = BA_Main::whereDate('created_at', '>', now()->subMonth())
          ->get();

      return response()->json($data);
  }

  public function ambilData($id)
    {
      dd($id);die;
        // $data = DataModel::find($id);

        return response()->json(['data' => $data]);
    }

    public function get_weekly(Request $request)
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
      $jenis = Ms_Jenis_BA::all();
      $company = Ms_Company::all();


           $report = DB::connection('mysql')->select("
        select
          created_at,
          rec_comcode,
          rec_areacode,
          Ms_Emp_Code,
          Ms_Emp_Div,
          Ms_BA_type_Code,
          Ms_Kasus,
          MS_Detail_Kasus
          from
          Tr_Ba_Main_New
        where rec_status ='1' and CekPelanggaran is not null and CekPelanggaran !='Berita Acara'
        order by created_at DESC
        ");

        $hasil = DB::connection('mysql')->select("
          SELECT
          COUNT(Tr_BA_Main_Code) AS total_ba
          FROM Tr_Ba_Main_New
          where rec_status ='1'
          and CekPelanggaran ='Request'
          GROUP BY CekPelanggaran
        ");
        foreach($hasil as $totals)
        { $hasilnya = $totals->total_ba;}

         $itung_ba = DB::connection('mysql')->select("
         with
cte0 as (
select convert(CURDATE(),date) as hariini
),
        cte
        as
        (
                SELECT
                   CURDATE(),
                   CONVERT(created_at, date) as tanggal_ba1,
                   COUNT(Tr_BA_Main_Code) AS total_ba_pelanggaran_sop
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CekRevisi = '0'
                   and CONVERT(created_at, date) = CURDATE()
                   and CekPelanggaran ='1'
       ),
       cte2 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba2,
                   COUNT(Tr_BA_Main_Code) AS total_ba_kelalaian
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and Ms_BA_type_Code ='Kelalaian'
                   GROUP BY Ms_BA_type_Code,CONVERT(created_at, date)
       ),
       cte3 as
       (
                  SELECT
                   CONVERT(created_at, date) as tanggal_ba3,
                   COUNT(Tr_BA_Main_Code) AS total_ba_perubahan_sop
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and CekPerubahanSOP ='1'

       ),
       cte4 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba4,
                   COUNT(Tr_BA_Main_Code) AS total_ba_laka
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and CekLaka ='1'
       ),
       cte5 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba5,
                   COUNT(Tr_BA_Main_Code) AS total_ba_kehilangan_aset
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and CekKehilangan ='1'
       ),
       cte6 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba6,
                   COUNT(Tr_BA_Main_Code) AS total_ba_pembelian
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and CekPembelian ='1'
       ),
       cte7 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba7,
                   COUNT(Tr_BA_Main_Code) AS total_ba_kesalahan_revisi
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CekRevisi = '1'
                   and CONVERT(created_at, date) = CURDATE()
       ),
       cte8 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba8,
                   COUNT(Tr_BA_Main_Code) AS total_ba_kesalahan_sistem
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CekRevisi is not null
                   and CONVERT(created_at, date) = CURDATE()
                   and Ms_BA_type_Code ='Kesalahan Sistem'
                   GROUP BY Ms_BA_type_Code,CONVERT(created_at, date)
       ),
       cte9 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba9,
                   COUNT(Tr_BA_Main_Code) AS total_ba_kehilangan_kerusakan_aset
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and (CekKehilangan ='1' or CekKerusakan ='1')
       ),
       cte10 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba10,
                   COUNT(Tr_BA_Main_Code) AS total_ba_kejadian
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and Ms_BA_type_Code ='Kejadian'
                   GROUP BY Ms_BA_type_Code,CONVERT(created_at, date)
       ),
       cte11 as
       (
                   SELECT
                   CONVERT(created_at, date) as tanggal_ba11,
                   COUNT(Tr_BA_Main_Code) AS total_ba_temuan
                   FROM Tr_Ba_Main_New
                   where rec_status ='1'
                   and CONVERT(created_at, date) = CURDATE()
                   and Ms_BA_type_Code ='Temuan'
                   GROUP BY Ms_BA_type_Code,CONVERT(created_at, date)
       )


           select
           ifnull(total_ba_pelanggaran_sop,0) as total_ba_pelanggaran_sop,
           ifnull(total_ba_kelalaian,0) as total_ba_kelalaian,
           ifnull(total_ba_perubahan_sop,0) as total_ba_perubahan_sop,
           ifnull(total_ba_laka,0) as total_ba_laka,
           ifnull(total_ba_kehilangan_aset,0) as total_ba_kehilangan_aset,
           ifnull(total_ba_pembelian,0) as total_ba_pembelian,
           ifnull(total_ba_kesalahan_revisi,0) as total_ba_kesalahan_revisi,
           ifnull(total_ba_kesalahan_sistem,0) as total_ba_kesalahan_sistem,
           ifnull(total_ba_kehilangan_kerusakan_aset,0) as total_ba_kehilangan_kerusakan_aset,
           ifnull(total_ba_kejadian,0) as total_ba_kejadian,
           ifnull(total_ba_temuan,0) as total_ba_temuan


           from cte0 c0
     left join cte  c1 on c0.hariini = c1.tanggal_ba1
           left join cte2 c2 on c0.hariini = c2.tanggal_ba2
           left join cte3 c3 on c0.hariini = c3.tanggal_ba3
           left join cte4 c4 on c0.hariini = c4.tanggal_ba4
           left join cte5 c5 on c0.hariini = c5.tanggal_ba5
           left join cte6 c6 on c0.hariini = c6.tanggal_ba6
           left join cte7 c7 on c0.hariini = c7.tanggal_ba7
           left join cte8 c8 on c0.hariini = c8.tanggal_ba8
           left join cte9 c9 on c0.hariini = c9.tanggal_ba9
           left join cte10 c10 on c0.hariini = c10.tanggal_ba10
           left join cte11 c11 on c0.hariini = c11.tanggal_ba11
           ");


          $total_ba = DB::connection('mysql')->select("
          SELECT
          COUNT(Tr_BA_Main_Code) AS total_ba
          FROM Tr_Ba_Main_New
          where rec_status ='1'
          and (CekPelanggaran = '1' or CekKerusakan = '1' or CekDisiplin = '1' or CekSalahIsi = '1' or CekNoClosing = '1' or CekLaka = '1' or CekPembelian = '1' or CekKehilangan = '1' or CekPerubahanSOP = '1' or CekRevisi = '1' )
          and CONVERT(created_at, date) = CURDATE()
          ");
          foreach($total_ba as $total_semua)
          { $total_semua_ba = $total_semua->total_ba;}

          $total_ba_weekly = DB::connection('mysql')->select("
          SELECT
          Ms_BA_type_Code,
          COUNT(Tr_BA_Main_Code) AS total_ba
          FROM Tr_Ba_Main_New
          where rec_status ='1'
          and (CekPelanggaran = '1' or CekKerusakan = '1' or CekDisiplin = '1' or CekSalahIsi = '1' or CekNoClosing = '1' or CekLaka = '1' or CekPembelian = '1' or CekKehilangan = '1' or CekPerubahanSOP = '1' or CekRevisi = '1' )
          and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
          ");
          foreach($total_ba_weekly as $total_semua_week)
          { $total_ba_weeks = $total_semua_week->total_ba;}

          $total_ba_bypic = DB::connection('mysql')->select("
          SELECT
    Ms_Emp_Code,
    Ms_Emp_Div,
          COUNT(Tr_BA_Main_Code) AS total_ba
          FROM Tr_Ba_Main_New
          where rec_status ='1'
    and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
          and Ms_BA_type_Code !=''
          and Ms_Emp_Code !='-'
          GROUP BY Ms_Emp_Code
    order by total_ba desc

    limit 10  
          ");

          $total_ba_weekly = DB::connection('mysql')->select("
            with
            cte0 as (
            select DATE_SUB(CURDATE(), INTERVAL 7 DAY) as mingguini
            ),

            cte
          as
          (
                    SELECT
                      CURDATE(),
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week1,
                      -- CONVERT(created_at, date) as tanggal_ba1,
                      COUNT(Tr_BA_Main_Code) AS total_ba_pelanggaran_sop
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and CekRevisi = '0'
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and CekPelanggaran ='1'
          ),
          cte2 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week2,
                      -- CONVERT(created_at, date) as tanggal_ba2,
                      COUNT(Tr_BA_Main_Code) AS total_ba_kelalaian
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and CekPelanggaran is not null
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and Ms_BA_type_Code ='Kelalaian'
                      GROUP BY Ms_BA_type_Code
          ),
          cte3 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week3,
                      -- CONVERT(created_at, date) as tanggal_ba3,
                      COUNT(Tr_BA_Main_Code) AS total_ba_perubahan_sop
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and CekPerubahanSOP ='1'

          ),
          cte4 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week4,
                      -- CONVERT(created_at, date) as tanggal_ba4,
                      COUNT(Tr_BA_Main_Code) AS total_ba_laka
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and CekLaka ='1'
                      
          ),
          cte5 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week5,
                      -- CONVERT(created_at, date) as tanggal_ba5,
                      COUNT(Tr_BA_Main_Code) AS total_ba_kehilangan_aset
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and CekKehilangan ='1'
          ),
          cte6 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week6,
                      -- CONVERT(created_at, date) as tanggal_ba6,
                      COUNT(Tr_BA_Main_Code) AS total_ba_pembelian
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and CekPembelian ='1'
          ),
          cte7 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week7,
                      -- CONVERT(created_at, date) as tanggal_ba7,
                      COUNT(Tr_BA_Main_Code) AS total_ba_kesalahan_revisi
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and CekRevisi = '1'
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
          ),
          cte8 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week8,
                      -- CONVERT(created_at, date) as tanggal_ba8,
                      COUNT(Tr_BA_Main_Code) AS total_ba_kesalahan_sistem
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and CekRevisi is not null
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and Ms_BA_type_Code ='Kesalahan Sistem'
                      GROUP BY Ms_BA_type_Code
          ),
          cte9 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week9,
                      -- CONVERT(created_at, date) as tanggal_ba9,
                      COUNT(Tr_BA_Main_Code) AS total_ba_kehilangan_kerusakan_aset
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'                      
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and (CekKehilangan ='1' or CekKerusakan ='1')
                      
          ),

          cte11 as
          (
                      SELECT
                      DATE_SUB(CURDATE(), INTERVAL 7 DAY) as week11,
                      -- CONVERT(created_at, date) as tanggal_ba11,
                      COUNT(Tr_BA_Main_Code) AS total_ba_temuan
                      FROM Tr_Ba_Main_New
                      where rec_status ='1'
                      and CekPelanggaran is not null
                      and created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      and Ms_BA_type_Code ='Temuan'
                      GROUP BY Ms_BA_type_Code
          )


              select
              ifnull(total_ba_pelanggaran_sop,0) as total_ba_pelanggaran_sop,
              ifnull(total_ba_kelalaian,0) as total_ba_kelalaian,
              ifnull(total_ba_perubahan_sop,0) as total_ba_perubahan_sop,
              ifnull(total_ba_laka,0) as total_ba_laka,
              ifnull(total_ba_kehilangan_aset,0) as total_ba_kehilangan_aset,
              ifnull(total_ba_pembelian,0) as total_ba_pembelian,
              ifnull(total_ba_kesalahan_revisi,0) as total_ba_kesalahan_revisi,
              ifnull(total_ba_kesalahan_sistem,0) as total_ba_kesalahan_sistem,
              ifnull(total_ba_kehilangan_kerusakan_aset,0) as total_ba_kehilangan_kerusakan_aset,
              ifnull(total_ba_temuan,0) as total_ba_temuan


              from cte0 c0
              left join cte c1 on c0.mingguini = c1.week1
              left join cte2 c2 on c0.mingguini = c2.week2
              left join cte3 c3 on c0.mingguini = c3.week3
              left join cte4 c4 on c0.mingguini = c4.week4
              left join cte5 c5 on c0.mingguini = c5.week5
              left join cte6 c6 on c0.mingguini = c6.week6
              left join cte7 c7 on c0.mingguini = c7.week7
              left join cte8 c8 on c0.mingguini = c8.week8
              left join cte9 c9 on c0.mingguini = c9.week9
              left join cte11 c11 on c0.mingguini = c11.week11

          ");

             $total_ba_weekly_by_div = DB::connection('mysql')->select("
                      SELECT
                      CURDATE(),
                      CONVERT(mains.created_at, date) as tanggal_ba1,
                      rec_areacode,
                      Ms_Emp_Div,
                      count(Tr_BA_Main_Code) AS total_ba
                      from Tr_Ba_Main_New  mains
                      where mains.rec_status = '1'
                      and rec_areacode != '' and rec_areacode != '-' 
                      and rec_areacode is not null
                      and mains.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      group by Ms_Emp_Div
                      order by Ms_Emp_Div asc
              ");
              
             $total_ba_weekly_by_location = DB::connection('mysql')->select("
                      SELECT
                      CURDATE(),
                      CONVERT(mains.created_at, date) as tanggal_ba1,
                      rec_areacode,
                      Ms_Emp_Div,
                      count(Tr_BA_Main_Code) AS total_ba
                      from Tr_Ba_Main_New  mains
                      where mains.rec_status = '1'
                      and rec_areacode != '' and rec_areacode != '-' 
                      and rec_areacode is not null
                      and mains.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      group by rec_areacode
                      order by rec_areacode asc
              ");
          $chartData = babydivisi::select('Division_Code', 'total_ba')->get();
          

            return view('dashboard_weekly', compact('report', 'hasilnya', 'itung_ba', 'total_semua_ba', 'total_ba_bypic','total_ba_weekly', 'total_ba_weeks',  'chartData', 'total_ba_weekly_by_location', 'total_ba_weekly_by_div'));
      }
      
  public function get_monthly(Request $request)
  {
    $total_ba_weekly = DB::connection('mysql')->select("
    SELECT
    Ms_BA_type_Code,
    COUNT(Tr_BA_Main_Code) AS total_ba
    FROM Tr_Ba_Main_New
    where rec_status ='1'
    and (CekPelanggaran = '1' or CekKerusakan = '1' or CekDisiplin = '1' or CekSalahIsi = '1' or CekNoClosing = '1' or CekLaka = '1' or CekPembelian = '1' or CekKehilangan = '1' or CekPerubahanSOP = '1' or CekRevisi = '1' )    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
    foreach($total_ba_weekly as $total_semua_week)
    { $total_ba_weeks = $total_semua_week->total_ba;}

    $total_ba_bypic = DB::connection('mysql')->select("
        SELECT
        Ms_Emp_Code,
        Ms_Emp_Div,
        COUNT(Tr_BA_Main_Code) AS total_ba
        FROM Tr_Ba_Main_New
        where rec_status ='1'
        and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        and Ms_BA_type_Code !=''
        and Ms_Emp_Code !='-'
        GROUP BY Ms_Emp_Code
        order by total_ba desc

        limit 10
        ");

        $total_ba_weekly = DB::connection('mysql')->select("
          with
cte0 as (
select DATE_SUB(CURDATE(), INTERVAL 30 DAY) as mingguini
),

    cte
        as
        (
                  SELECT
                    CURDATE(),
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week1,
                    -- CONVERT(created_at, date) as tanggal_ba1,
                    COUNT(Tr_BA_Main_Code) AS total_ba_pelanggaran_sop
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and CekRevisi = '0'
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and CekPelanggaran ='1'

        ),
        cte2 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week2,
                    -- CONVERT(created_at, date) as tanggal_ba2,
                    COUNT(Tr_BA_Main_Code) AS total_ba_kelalaian
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and CekPelanggaran is not null
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and Ms_BA_type_Code ='Kelalaian'
                    GROUP BY Ms_BA_type_Code
        ),
        cte3 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week3,
                    -- CONVERT(created_at, date) as tanggal_ba3,
                    COUNT(Tr_BA_Main_Code) AS total_ba_perubahan_sop
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and CekPerubahanSOP ='1'

        ),
        cte4 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week4,
                    -- CONVERT(created_at, date) as tanggal_ba4,
                    COUNT(Tr_BA_Main_Code) AS total_ba_laka
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and CekLaka ='1'
        ),
        cte5 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week5,
                    -- CONVERT(created_at, date) as tanggal_ba5,
                    COUNT(Tr_BA_Main_Code) AS total_ba_kehilangan_aset
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and CekPelanggaran is not null
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and CekKehilangan ='1'
        ),
        cte6 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week6,
                    -- CONVERT(created_at, date) as tanggal_ba6,
                    COUNT(Tr_BA_Main_Code) AS total_ba_pembelian
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and CekPembelian ='1'
        ),
        cte7 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week7,
                    -- CONVERT(created_at, date) as tanggal_ba7,
                    COUNT(Tr_BA_Main_Code) AS total_ba_kesalahan_revisi
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and CekRevisi = '1'
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        ),
        cte8 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week8,
                    -- CONVERT(created_at, date) as tanggal_ba8,
                    COUNT(Tr_BA_Main_Code) AS total_ba_kesalahan_sistem
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and CekRevisi is not null
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and Ms_BA_type_Code ='Kesalahan Sistem'
                    GROUP BY Ms_BA_type_Code
        ),
        cte9 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week9,
                    -- CONVERT(created_at, date) as tanggal_ba9,
                    COUNT(Tr_BA_Main_Code) AS total_ba_kehilangan_kerusakan_aset
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and (CekKehilangan ='1' or CekKerusakan ='1')

        ),

        cte11 as
        (
                    SELECT
                    DATE_SUB(CURDATE(), INTERVAL 30 DAY) as week11,
                    -- CONVERT(created_at, date) as tanggal_ba11,
                    COUNT(Tr_BA_Main_Code) AS total_ba_temuan
                    FROM Tr_Ba_Main_New
                    where rec_status ='1'
                    and CekPelanggaran is not null
                    and created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    and Ms_BA_type_Code ='Temuan'
                    GROUP BY Ms_BA_type_Code
        )


            select
            ifnull(total_ba_pelanggaran_sop,0) as total_ba_pelanggaran_sop,
            ifnull(total_ba_kelalaian,0) as total_ba_kelalaian,
            ifnull(total_ba_perubahan_sop,0) as total_ba_perubahan_sop,
            ifnull(total_ba_laka,0) as total_ba_laka,
            ifnull(total_ba_kehilangan_aset,0) as total_ba_kehilangan_aset,
            ifnull(total_ba_pembelian,0) as total_ba_pembelian,
            ifnull(total_ba_kesalahan_revisi,0) as total_ba_kesalahan_revisi,
            ifnull(total_ba_kesalahan_sistem,0) as total_ba_kesalahan_sistem,
            ifnull(total_ba_kehilangan_kerusakan_aset,0) as total_ba_kehilangan_kerusakan_aset,
            ifnull(total_ba_temuan,0) as total_ba_temuan


            from cte0 c0
            left join cte c1 on c0.mingguini = c1.week1
            left join cte2 c2 on c0.mingguini = c2.week2
            left join cte3 c3 on c0.mingguini = c3.week3
            left join cte4 c4 on c0.mingguini = c4.week4
            left join cte5 c5 on c0.mingguini = c5.week5
            left join cte6 c6 on c0.mingguini = c6.week6
            left join cte7 c7 on c0.mingguini = c7.week7
            left join cte8 c8 on c0.mingguini = c8.week8
            left join cte9 c9 on c0.mingguini = c9.week9
            left join cte11 c11 on c0.mingguini = c11.week11

        ");


        $total_ba_monthly_by_div = DB::connection('mysql')->select("
        SELECT
        CURDATE(),
        CONVERT(mains.created_at, date) as tanggal_ba1,
        rec_areacode,
        Ms_Emp_Div,
        count(Tr_BA_Main_Code) AS total_ba
        from Tr_Ba_Main_New  mains
        where mains.rec_status = '1'
        and rec_areacode != '' and rec_areacode != '-' and rec_areacode is not null
        and mains.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        group by Ms_Emp_Div
        order by Ms_Emp_Div asc
        ");

        $total_ba_monthly_by_location = DB::connection('mysql')->select("
        SELECT
        CURDATE(),
        CONVERT(mains.created_at, date) as tanggal_ba1,
        rec_areacode,
        Ms_Emp_Div,
        count(Tr_BA_Main_Code) AS total_ba
        from Tr_Ba_Main_New  mains
        where mains.rec_status = '1'
        and rec_areacode != '' and rec_areacode != '-' and rec_areacode is not null
        and mains.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        group by rec_areacode
        order by rec_areacode asc
        ");






      $chartData = babydivisi_permonth::select('Division_Code', 'total_ba')->get();
      

      return view('dashboard_monthly', compact( 'total_ba_bypic','total_ba_weekly', 'total_ba_weeks',  'chartData', 'total_ba_monthly_by_location', 'total_ba_monthly_by_div'));
    }
}
