<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report_Memo;
use App\Models\Report_OpeningHRD;
use App\Models\CallHRD;
use App\Models\InterviewHRD;
use App\Models\Main_reportHRD;
use App\Models\OpeningLowongan_H;
use App\Models\Tr_Call_H;
use App\Models\Report_Opening_Last_Week;
use App\Models\AllHostoryPerDay;
use App\Models\AllHistoryPerWeek;
use App\Models\AllHistoryPerMonth;
use App\Models\AllHistoryPerDayNew;
use App\Models\AllHistoryPerWeeknew;
use App\Models\AllHistoryPerMonthnew;
use Illuminate\Support\Str;

use App\Models\allhistoryjanuari;
use App\Models\allhistoryfebruari;
use App\Models\allhistorymaret;
use App\Models\allhistoryapril;
use App\Models\allhistorymei;
use App\Models\allhistoryjuni;
use App\Models\allhistoryjuli;
use App\Models\allhistoryagustus;
use App\Models\allhistoryseptember;
use App\Models\allhistoryoktober;
use App\Models\allhistorynovember;
use App\Models\allhistorydesember;
use App\Models\allhistoryperweek1;
use App\Models\allhistoryperweek2;
use App\Models\allhistoryperweek3;
use App\Models\allhistoryperweek4;
use App\Models\allhistoryperweek5;
use App\Models\allhistoryperweek6;
use App\Models\allhistoryperweek7;
use App\Models\allhistoryperweek8;
use App\Models\allhistoryperweek9;
use App\Models\allhistoryperweek10;
use App\Models\allhistoryperweek11;
use App\Models\allhistoryperweek12;
use App\Models\allhistoryperweek13;
use App\Models\allhistoryperweek14;
use App\Models\allhistoryperweek15;
use App\Models\allhistoryperweek16;
use App\Models\allhistoryperweek17;
use App\Models\allhistoryperweek18;
use App\Models\allhistoryperweek19;
use App\Models\allhistoryperweek20;
use App\Models\allhistoryperweek21;
use App\Models\allhistoryperweek22;
use App\Models\allhistoryperweek23;
use App\Models\allhistoryperweek24;
use App\Models\allhistoryperweek25;
use App\Models\allhistoryperweek26;
use App\Models\allhistoryperweek27;
use App\Models\allhistoryperweek28;
use App\Models\allhistoryperweek29;
use App\Models\allhistoryperweek30;
use App\Models\allhistoryperweek31;
use App\Models\allhistoryperweek32;
use App\Models\allhistoryperweek33;
use App\Models\allhistoryperweek34;
use App\Models\allhistoryperweek35;
use App\Models\allhistoryperweek36;
use App\Models\allhistoryperweek37;
use App\Models\allhistoryperweek38;
use App\Models\allhistoryperweek39;
use App\Models\allhistoryperweek40;
use App\Models\allhistoryperweek41;
use App\Models\allhistoryperweek42;
use App\Models\allhistoryperweek43;
use App\Models\allhistoryperweek44;
use App\Models\allhistoryperweek45;
use App\Models\allhistoryperweek46;
use App\Models\allhistoryperweek47;
use App\Models\allhistoryperweek48;
use App\Models\allhistoryperweek49;
use App\Models\allhistoryperweek50;
use App\Models\allhistoryperweek51;
use App\Models\allhistoryperweek52;
use App\Models\reportclosing;
use DB;
use Session;


class Report_HRD_Controller extends Controller
{
    public function ReportHRD()
    {
      $user = auth()->user();
      $report_opening = Report_OpeningHRD::all();
    //   return view('report.report', compact('report_opening'));
      return view('report.report', compact('report_opening', 'user'));
    }

    public function ReportCall()
    {
      $user = auth()->user();
      $report_opening = Report_OpeningHRD::all();
      return view('report.report_call', compact('report_opening', 'user'));
    }

    public function ReportInterview()
    {
      $user = auth()->user();
    //   dd($user);die;
      $report_opening = Report_OpeningHRD::all();
      return view('report.report_interview', compact('report_opening', 'user'));
    }

    public function index_register()
    {
      return view('report.CandidateRegister');
    }

    public function store (Request $request)
    {
      $last_code = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_report_hrd_main
      order by id desc
      LIMIT 1
      ");
      $last_date = DB::connection('mysql')->select("
      SELECT
      created_at
      FROM tr_report_hrd_main
      order by id desc
      LIMIT 1
      ");
      $todayDate = date('Y-m-d');
      foreach($last_code as $codes)
      { $kode = $codes->id;}
      foreach($last_date as $datess)
      { $tanggal = $datess->created_at;}
      if( $tanggal == $todayDate)
          {
              $code = $kode + 1;
          }
      else
          {
              $code = 1;
          }
      $ambilkode=Main_reportHRD::where($request->Tr_report_hrd_main_code)->get();
      $nambah=count($ambilkode)+1;
      if ($nambah <10000)
      {
          $Tr_report_hrd_main_code='MAINHRD'. '-'. date('Ydm').'-'."00".$nambah;
      }

      $main_report_hrd = new Main_reportHRD();
      $main_report_hrd->Tr_report_hrd_main_code = $Tr_report_hrd_main_code;
      $main_report_hrd->Ms_ReportType_Code      = $request->Ms_ReportType_Code;
      $main_report_hrd->Ms_User_Code            = $request->Ms_User_Code;
      $main_report_hrd->ms_divisi               = $request->ms_divisi;
      $main_report_hrd->ms_lokasi               = $request->ms_lokasi;
      $main_report_hrd->Ms_Perusahaan_Code_main = $request->Ms_Perusahaan_Code_main;
      // dd($main_report_hrd);die;
      $main_report_hrd->save();

      if ($request->Ms_ReportType_Code =='Memo')
      {
            $last_code = DB::connection('mysql')->select("
            SELECT
            id
            FROM tr_reportmemos
            order by id desc
            LIMIT 1
            ");
            $last_date = DB::connection('mysql')->select("
            SELECT
            created_at
            FROM tr_reportmemos
            order by id desc
            LIMIT 1
            ");
            $todayDate = date('Y-m-d');
            foreach($last_code as $codes)
            { $kode = $codes->id;}
            foreach($last_date as $datess)
            { $tanggal = $datess->created_at;}
            if( $tanggal == $todayDate)
                {
                    $code = $kode + 1;
                }
            else
                {
                    $code = 1;
                }
            $ambilkode=Report_Memo::where($request->Tr_ReportMemo)->get();
            $nambah=count($ambilkode)+1;
            if ($nambah <10000)
            {
                $Tr_ReportMemo='MEMO'. '-'. date('Ydm').'-'."00".$nambah;
            }

            $memo = new Report_Memo();
            $memo->Tr_ReportMemo           = $Tr_ReportMemo;
            $memo->Tr_report_main_code     = $main_report_hrd->Tr_report_hrd_main_code;
            $memo->Ms_User_Code            = $request->Ms_User_Code;
            $memo->rec_comcode             = $request->rec_comcode;
            $memo->rec_areacode            = $request->rec_areacode;
            $memo->ms_divisi               = $request->ms_divisi;
            $memo->Ms_ReportType_Code      = 'Memo';
            $memo->Memo                    = $request->Memo;
            $memo->save();
          }

      else if ($request->Ms_ReportType_Code =='Opening Lowongan')
        {

          $last_code = DB::connection('mysql')->select("
          SELECT
          id
          FROM tr_report_lowongan_h
          order by id desc
          LIMIT 1
          ");
          $last_date = DB::connection('mysql')->select("
          SELECT
          created_at
          FROM tr_report_lowongan_h
          order by id desc
          LIMIT 1
          ");
          $todayDate = date('Y-m-d');
          foreach($last_code as $codes)
          { $kode = $codes->id;}
          foreach($last_date as $datess)
          { $tanggal = $datess->created_at;}
          if( $tanggal == $todayDate)
              {
                  $code = $kode + 1;
              }
          else
              {
                  $code = 1;
              }
          $ambilkode=OpeningLowongan_H::where($request->Tr_report_lowongan_code_h)->get();
          $nambah=count($ambilkode)+1;
          if ($nambah <10000)
          {
              $Tr_report_lowongan_code_h='OPEN'. '-'. date('Ydm').'-'."00".$nambah;
          }

            $opening_H = new OpeningLowongan_H();
            $opening_H->Tr_report_lowongan_code_h     = $Tr_report_lowongan_code_h;
            $opening_H->Ms_operator                   = $request->Ms_User_Code;
            $opening_H->Date_lowongan                 = $request->Date_lowongan;
            $opening_H->Total_opening                 = $request->Total_opening_HGS + $request->Total_opening_TGF + $request->Total_opening_TGU ;
            $opening_H->Total_opening_HGS             = $request->Total_opening_HGS;
            $opening_H->Total_opening_TGF             = $request->Total_opening_TGF;
            $opening_H->Total_opening_TGU             = $request->Total_opening_TGU;
            // dd($opening_H);die;
            $opening_H->save();

          foreach($request['Ms_Media_Code'] as $key => $item_id)
            {

                $report_opening_lowongan = new Report_OpeningHRD();
                $report_opening_lowongan->Ms_User_Code            = $request->Ms_User_Code;
                $report_opening_lowongan->ms_divisi               = $request->ms_divisi;
                $report_opening_lowongan->Tr_ReportLowongan_Code  = $opening_H->Tr_report_lowongan_code_h ;
                $report_opening_lowongan->Tr_report_hrd_main_code = $main_report_hrd->Tr_report_hrd_main_code;
                $report_opening_lowongan->Ms_Media_Code           = $request['Ms_Media_Code'][$key];
                $report_opening_lowongan->Ms_ReportType_Code      = 'Opening Lowongan';
                $report_opening_lowongan->Ms_Perusahaan_Code      = $request['Ms_Perusahaan_Code'][$key];
                $report_opening_lowongan->MS_Jabatan_Code         = $request['MS_Jabatan_Code'][$key];
                $report_opening_lowongan->Qty                     = $request['Qty'][$key];
                $report_opening_lowongan->tr_Lowongan_Code_H      = $opening_H->Tr_report_lowongan_code_h ;
                $report_opening_lowongan->save();
            }
        }
      else if ($request->Ms_ReportType_Code =='Call')
        {

          $last_code = DB::connection('mysql')->select("
          SELECT
          id
          FROM tr_report_lowongan_h
          order by id desc
          LIMIT 1
          ");
          $last_date = DB::connection('mysql')->select("
          SELECT
          created_at
          FROM tr_report_lowongan_h
          order by id desc
          LIMIT 1
          ");
          $todayDate = date('Y-m-d');
          foreach($last_code as $codes)
          { $kode = $codes->id;}
          foreach($last_date as $datess)
          { $tanggal = $datess->created_at;}
          if( $tanggal == $todayDate)
              {
                  $code = $kode + 1;
              }
          else
              {
                  $code = 1;
              }
          $ambilkode=Tr_Call_H::where($request->tr_candidate_call_code_h)->get();
          $nambah=count($ambilkode)+1;
          if ($nambah <10000)
          {
              $tr_candidate_call_code_h='CALL'. '-'. date('Ydm').'-'."00".$nambah;
          }

            $call_H = new Tr_Call_H();
            $call_H->tr_candidate_call_code_h       = $tr_candidate_call_code_h;
            $call_H->Ms_Caller_code                 = $request->Ms_User_Code;
            $call_H->Date_Call                      = $request->Date_Call;
            $call_H->Total_Call_HGS                 = $request->Total_Call_HGS;
            $call_H->Total_Call_TGU                 = $request->Total_Call_TGU;
            $call_H->Total_Call_TGF                 = $request->Total_Call_TGF;
            $call_H->Total_Call                     = $request->Total_Call_HGS + $request->Total_Call_TGF + $request->Total_Call_TGU ;
            // dd($opening_H);die;
            $call_H->save();

          foreach($request['Nama_kandidat'] as $key => $item_id)
            {

                $report_call = new CallHRD();
                $report_call->Ms_User_Code            = $request->Ms_User_Code;
                $report_call->ms_divisi               = $request->ms_divisi;
                $report_call->Tr_Report_Lowongan_Call = $call_H->tr_candidate_call_code_h ;
                $report_call->Tr_report_hrd_main_code = $main_report_hrd->Tr_report_hrd_main_code;
                $report_call->Ms_ReportType_Code      = 'Call';
                $report_call->Nama_kandidat           = $request['Nama_kandidat'][$key];
                $report_call->Ms_Media_Code           = $request['Ms_Media_Code'][$key];
                $report_call->NamaLowongan            = $request['NamaLowongan'][$key];
                $report_call->Telepon                 = $request['Telepon'][$key];
                $report_call->Ms_Status               = $request['Ms_Status'][$key];
                $report_call->Ms_Perusahaan_Code      = $request['Ms_Perusahaan_Code'][$key];
                $report_call->Tr_Candidate_Sort_Code  = 1;
                $report_call->Tr_status_interview     = 0;
                $report_call->save();
            }
        }
      else if ($request->Ms_ReportType_Code =='Interview')
        {

          foreach($request['Ms_Media_Code'] as $key => $item_id)
          {

              $report_interview = new InterviewHRD();
              $report_interview->Ms_User_Code            = $request->Ms_User_Code;
              $report_interview->ms_divisi               = $request->ms_divisi;
              $report_interview->tr_lowongan_Interview   = '';
              $report_interview->Tr_report_hrd_main_code = $main_report_hrd->Tr_report_hrd_main_code;
              $report_interview->Ms_ReportType_Code      = 'Interview';
              $report_interview->Ms_Media_Code           = $request['Ms_Media_Code'][$key];
              $report_interview->NamaLowongan            = $request['NamaLowongan'][$key];
              $report_interview->Ms_Perusahaan_Code      = $request['Ms_Perusahaan_Code'][$key];
              $report_interview->userinterview            = $request['userinterview'][$key];
              $report_interview->NamaCandidate           = $request['NamaCandidate'][$key];
              $report_interview->Telepon                 = $request['Telepon'][$key];
              $report_interview->hasil_interview         = $request['hasil_interview'][$key];
              $report_interview->note                    = $request['note'][$key];
              $report_interview->Tr_status_interview     = 1;
              $report_interview->save();

              // $updateees = CallHRD::where('Tr_report_hrd_main_code', '=', $Tr_report_hrd_main_code);

              // $updateees = CallHRD::find($Tr_report_hrd_main_code);
              // $updateees->Tr_status_interview = '1';
              // $update_status_call = new CallHRD();
              // $update_status_call->Tr_status_interview     = 1;
              // $update_status_call->save();

              // dd($Tr_report_hrd_main_code);die;
              // $last_codes = DB::connection('mysql')->select("
              // SELECT
              // Tr_report_hrd_main_code
              // FROM `tr_candidate_call`
              // WHERE Tr_status_interview is null
              // LIMIT 1
              // ");

              // dd($last_codes);die;

              // $updateees = CallHRD::find($last_code);
              // $updateees->Tr_status_interview = '1';
              // dd($updateees->Tr_status_interview);die;
              // $updateees->save();

          }
        }

        else if ($request->Ms_ReportType_Code =='Temuan')
        {

          foreach($request['nama_temuan'] as $key => $item_id)
            {

                $report_temuan = new Report_Temuan();
                $report_temuan->Ms_User_Code                  = $request->Ms_User_Code;
                $report_temuan->ms_divisi                     = $request->ms_divisi;
                $report_temuan->Tr_Report_temuan_code         = '';
                $report_temuan->Tr_report_temuan_main_code  = $main_report_hrd->Tr_report_hrd_main_code;
                $report_temuan->nama_temuan                   = $request['nama_temuan'][$key];
                $report_temuan->Ms_ReportType_Code            = 'Temuan';
                $report_temuan->nama_penemu                   = $request['nama_penemu'][$key];
                $report_temuan->tanggal_ditemukan             = $request['tanggal_ditemukan'][$key];
                // dd($report_temuan);die;
                $report_temuan->save();
            }
        }
        //   return view('/report/report');
        session()->flash('success', 'Data berhasil disimpan!');
        return redirect('report');
    }

    public function index_report(Request $request)
    {
        $reportmain_hrd = DB::connection('mysql')->select("
        select DISTINCT
        created_at,
        Ms_Perusahaan_Code_main,
        Ms_ReportType_Code,
        Tr_report_hrd_main_code

        FROM tr_report_hrd_main main
        where Ms_ReportType_Code != 'CV Candidate'
        order by created_at desc
        ");
    //   $reportmain_hrd = Main_reportHRD::orderBy('created_at', 'DESC')->get();
        return view('report.list_report', compact('reportmain_hrd'));
    }

    public function view_detail(Request $request, $id)
    {
      $main = Main_reportHRD::where('Tr_report_hrd_main_code', '=', $id)->first();

      if ($main->Ms_ReportType_Code =='Opening Lowongan')
        {
          $detail = Report_OpeningHRD::where('Tr_report_hrd_main_code', '=', $id)->get();
          return view ('report.show_detail', compact('main', 'detail') );
        }
      else if ($main->Ms_ReportType_Code =='Call')
        {
          $detail = CallHRD::where('Tr_report_hrd_main_code', '=', $id)->get();
          return view ('report.show_detail', compact('main', 'detail') );
        }
      else if ($main->Ms_ReportType_Code =='Interview')
        {
          $detail = InterviewHRD::where('Tr_report_hrd_main_code', '=', $id)->get();
          return view ('report.show_detail', compact('main', 'detail') );
        }
    }
    public function view_detail_closing (Request $request, $id)
    {
// dd($id);die;
      $detail = reportclosing::where('Ms_User_Code', '=', $id)->first();
      // dd($detail);die;
      return view ('report.detail_closing', compact('detail') );

    }

    public function index_report_daily(Request $request)
    {

        $reportmain_hrd = DB::connection('mysql')->select("
        select DISTINCT
        created_at,
        Ms_Perusahaan_Code_main,
        Ms_ReportType_Code,
        Tr_report_hrd_main_code

        FROM tr_report_hrd_main main
        WHERE DATE(`created_at`) = CURDATE();
        ");
        return view('report.list_report_daily', compact('reportmain_hrd'));
    }
    public function index_report_weekly(Request $request)
    {

        $reportmain_hrd = DB::connection('mysql')->select("
        select DISTINCT
        created_at,
        Ms_Perusahaan_Code_main,
        Ms_ReportType_Code,
        Tr_report_hrd_main_code

        FROM tr_report_hrd_main
        WHERE created_at BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW();
        ");
        return view('report.list_report_weekly', compact('reportmain_hrd'));
    }

    public function index_report_monthly(Request $request)
    {
      $reportmain_hrd = DB::connection('mysql')->select("
      select Distinct
      created_at,
      Ms_Perusahaan_Code_main,
      Ms_ReportType_Code,
      Tr_report_hrd_main_code

      FROM tr_report_hrd_main
      WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE());
      ");
      return view('report.list_report_monthly', compact('reportmain_hrd'));
    }

    public function index_report_opening(Request $request)
    {
      $reportmain_hrd = DB::connection('mysql')->select("

      SELECT
      created_at,
      Tr_report_hrd_main_code,
      ms_lokasi,
      Ms_User_Code

      FROM tr_report_hrd_main
      where Ms_ReportType_Code ='Opening Lowongan'
      order by created_at desc;
      ");

      // $reportmain_hrd = Main_reportHRD::orderBy('created_at', 'DESC')->get();
      // dd($reportmain_hrd);die;
      return view('report.list_report_opening', compact('reportmain_hrd'));
    }

    public function index_report_all_history(Request $request)
    {
      // $reportmain_hrd = Report_Opening_Last_Week::all();
      $reportmain_hrd = AllHostoryPerDay::all();

      // dd($reportmain_hrd);die;
      // $reportmain_hrd = DB::connection('mysql')->select("

      // select
      // year(opening_h.created_at)as year,
      // week(opening_h.created_at)as week,
      // opening_d.MS_Jabatan_Code as lowongan,
      // sum(opening_d.qty) AS total_opening,
      // sum(opening_h.Total_opening_HGS) AS total_open_hgs,
      // sum(opening_h.Total_opening_TGF) AS total_open_tgf,
      // sum(opening_h.Total_opening_TGU) AS total_open_tgu,
      // sum(opening_h.Total_opening) AS subtotal_open

      //  FROM tr_report_lowongan_h opening_h left join
      //  tr_report_lowongan_d opening_d on opening_h.Tr_report_lowongan_code_h = opening_d.tr_Lowongan_Code_H

      //  where year(opening_h.created_at) >= YEAR(DATE_SUB(CURDATE(), INTERVAL 2 YEAR))
      //  GROUP by opening_d.MS_Jabatan_Code;
      //  "
      //   );

      // dd($reportmain_hrd);die;
      return view('report.list_report_all_history', compact('reportmain_hrd'));
    }

    public function index_list_report_all_history_new_perday(Request $request)
    {
         // $reportmain_hrd = AllHistoryPerDayNew::orderBy('tanggal_main', 'desc')->get();
         
         $reportmain_hrd = DB::connection('mysql')->select("

         with cte as
         (
         SELECT
         table_candidate.Position_aplly1 as MS_Jabatan_Code,
         count(table_candidate.Tr_report_hrd_main_code) AS total_shortlist,
         CONVERT(table_main.created_at, date) as tanggal_main

         from tr_report_hrd_main table_main
         left join tr_candidate table_candidate on table_main.Tr_report_hrd_main_code = table_candidate.Tr_report_hrd_main_code

         GROUP by table_candidate.Position_aplly1,CONVERT(table_main.created_at, date)),

         cte2
         as
         (
         SELECT
         table_interview.NamaLowongan,
         COUNT(table_interview.NamaLowongan) AS total_interview,
         CONVERT(table_main.created_at, date) as tanggal_1

         FROM tr_report_hrd_main table_main
         left JOIN tr_report_lowongan_interview table_interview  on table_main.Tr_report_hrd_main_code = table_interview.Tr_report_hrd_main_code

         where  table_interview.hasil_interview !='Tidak Hadir'
         GROUP by table_interview.NamaLowongan,CONVERT(table_main.created_at, date)),

         cte3
         as
         (
         SELECT
         table_call.NamaLowongan,
        COUNT(table_call.Tr_report_hrd_main_code) AS total_panggil,
        CONVERT(opening.Date_int, date) as tanggal_call
        
        FROM tr_report_hrd_main table_main 
        LEFT JOIN tr_candidate_call table_call  on table_main.Tr_report_hrd_main_code=table_call.Tr_report_hrd_main_code
        LEFT JOIN tr_int_sched opening on  table_call.Nama_kandidat = opening.Ms_Candidate_code
        where table_call.NamaLowongan !='driver' and table_call.NamaLowongan !='helper'
        
        GROUP by CONVERT(opening.Date_int, date),NamaLowongan   ),

         cte4 as (
         SELECT
         table_call.NamaLowongan,
         COUNT(table_call.Tr_report_hrd_main_code) AS total_ok_calls,
         CONVERT(opening.Date_int, date) as tanggal_calls

         FROM tr_report_hrd_main table_main
         LEFT JOIN tr_candidate_call table_call on table_main.Tr_report_hrd_main_code=table_call.Tr_report_hrd_main_code
         LEFT JOIN tr_int_sched opening on  table_call.Nama_kandidat = opening.Ms_Candidate_code
         WHERE table_call.Ms_Status ='Terhubung' and table_call.NamaLowongan !='driver' and table_call.NamaLowongan !='helper'
         GROUP by CONVERT(opening.Date_int, date),NamaLowongan),

         cte41 as (
         SELECT
         table_call.NamaLowongan,
         COUNT(table_call.Tr_report_hrd_main_code) AS total_failed_calls,
         CONVERT(opening.Date_int, date) as tanggal_calls

         FROM tr_report_hrd_main table_main
         LEFT JOIN tr_candidate_call table_call on table_main.Tr_report_hrd_main_code=table_call.Tr_report_hrd_main_code
         LEFT JOIN tr_int_sched opening on  table_call.Nama_kandidat = opening.Ms_Candidate_code
         WHERE table_call.Ms_Status ='Tidak Terhubung' and table_call.NamaLowongan !='driver' and table_call.NamaLowongan !='helper'
         GROUP by CONVERT(opening.Date_int, date),NamaLowongan),

         cte5 as (
         SELECT
         table_interview.NamaLowongan,
         COUNT(table_interview.Tr_report_hrd_main_code) AS total_interview_diterima,
         CONVERT(table_main.created_at, date) as tanggal_interview

         FROM tr_report_hrd_main table_main
         left JOIN tr_report_lowongan_interview table_interview  on table_main.Tr_report_hrd_main_code = table_interview.Tr_report_hrd_main_code

         WHERE table_interview.hasil_interview ='lulus'
         GROUP by table_interview.NamaLowongan,CONVERT(table_main.created_at, date) ),

         cte51 as (
         SELECT
         table_interview.NamaLowongan,
         COUNT(table_interview.Tr_report_hrd_main_code) AS total_interview_ditolak,
         CONVERT(table_main.created_at, date) as tanggal_interview

         FROM tr_report_hrd_main table_main
         left JOIN tr_report_lowongan_interview table_interview  on table_main.Tr_report_hrd_main_code = table_interview.Tr_report_hrd_main_code

         WHERE table_interview.hasil_interview ='tidak lulus'
         GROUP by table_interview.NamaLowongan,CONVERT(table_main.created_at, date))

         select
         c1.MS_Jabatan_Code as lowongan,
         c1.tanggal_main,
         ifnull(total_shortlist,0) as total_shortlist,
         ifnull(total_panggil,0) as total_panggil,
         ifnull(total_interview,0) as total_interview,
         ifnull(total_ok_calls,0) as total_ok_calls,
         ifnull(total_failed_calls,0) as total_failed_calls,
         ifnull(total_interview_diterima,0) as total_ok_interview,
         ifnull(total_interview_ditolak,0) as total_interview_ditolak
         from cte c1
         left join cte2 c2 on c1.MS_Jabatan_Code =  c2.NamaLowongan and c1.tanggal_main=c2.tanggal_1
         left join cte3 c3 on c1.MS_Jabatan_Code = c3.NamaLowongan and c1.tanggal_main = c3.tanggal_call
         left join cte4 c4 on c1.MS_Jabatan_Code = c4.NamaLowongan and c1.tanggal_main = c4.tanggal_calls
         left join cte41 c41 on c1.MS_Jabatan_Code = c41.NamaLowongan and c1.tanggal_main = c41.tanggal_calls
         left join cte5 c5 on c1.MS_Jabatan_Code = c5.NamaLowongan and c1.tanggal_main = c5.tanggal_interview
         left join cte51 c51 on c1.MS_Jabatan_Code = c51.NamaLowongan and c1.tanggal_main = c51.tanggal_interview

         WHERE c1.MS_Jabatan_Code != 'driver' and c1.MS_Jabatan_Code != 'helper'

         union

         SELECT
         table_interview.NamaLowongan,
         CONVERT(table_main.created_at, date) as tanggal_1,
         0,
         0,
         COUNT(table_interview.NamaLowongan) AS total_interview,
         0,
         0,
         sum(case when table_interview.hasil_interview ='lulus' then 1 end) lulus,
         0

         FROM tr_report_hrd_main table_main
         left JOIN tr_report_lowongan_interview table_interview  on table_main.Tr_report_hrd_main_code = table_interview.Tr_report_hrd_main_code left join tr_report_lowongan_d opening on table_interview.NamaLowongan = opening.MS_Jabatan_Code and CONVERT(table_interview.created_at, date) = CONVERT(opening.created_at, date)
         where table_main.ms_lokasi ='Pusat' and table_interview.NamaLowongan is not null and opening.MS_Jabatan_Code is null


         GROUP by table_interview.NamaLowongan,opening.MS_Jabatan_Code,CONVERT(table_main.created_at, date)
         order by tanggal_main desc;;
      ");

      return view('report.list_report_all_history_new_perday', compact('reportmain_hrd'));
    }
    public function index_list_report_all_history_new_weekly(Request $request)
    {
       $week1 = allhistoryperweek1 ::orderBy('week', 'desc')->get();
      $week2 = allhistoryperweek2 ::orderBy('week', 'desc')->get();
      $week3 = allhistoryperweek3 ::orderBy('week', 'desc')->get();
      $week4 = allhistoryperweek4 ::orderBy('week', 'desc')->get();
      $week5 = allhistoryperweek5 ::orderBy('week', 'desc')->get();
      $week6 = allhistoryperweek6 ::orderBy('week', 'desc')->get();
      $week7 = allhistoryperweek7 ::orderBy('week', 'desc')->get();
      $week8 = allhistoryperweek8 ::orderBy('week', 'desc')->get();
      $week9 = allhistoryperweek9 ::orderBy('week', 'desc')->get();
      $week10 = allhistoryperweek10 ::orderBy('week', 'desc')->get();
      $week11 = allhistoryperweek11 ::orderBy('week', 'desc')->get();
      $week12 = allhistoryperweek12 ::orderBy('week', 'desc')->get();
      $week13 = allhistoryperweek13 ::orderBy('week', 'desc')->get();
      $week14 = allhistoryperweek14 ::orderBy('week', 'desc')->get();
      $week15 = allhistoryperweek15 ::orderBy('week', 'desc')->get();
      $week16 = allhistoryperweek16 ::orderBy('week', 'desc')->get();
      $week17 = allhistoryperweek17 ::orderBy('week', 'desc')->get();
      $week18 = allhistoryperweek18 ::orderBy('week', 'desc')->get();
      $week19 = allhistoryperweek19 ::orderBy('week', 'desc')->get();
      $week20 = allhistoryperweek20 ::orderBy('week', 'desc')->get();
      $week21 = allhistoryperweek21 ::orderBy('week', 'desc')->get();
      $week22 = allhistoryperweek22 ::orderBy('week', 'desc')->get();
      $week23 = allhistoryperweek23 ::orderBy('week', 'desc')->get();
      $week24 = allhistoryperweek24 ::orderBy('week', 'desc')->get();
      $week25 = allhistoryperweek25 ::orderBy('week', 'desc')->get();
      $week26 = allhistoryperweek26 ::orderBy('week', 'desc')->get();
      $week27 = allhistoryperweek27 ::orderBy('week', 'desc')->get();
      $week28 = allhistoryperweek28 ::orderBy('week', 'desc')->get();
      $week29 = allhistoryperweek29 ::orderBy('week', 'desc')->get();
      $week30 = allhistoryperweek30 ::orderBy('week', 'desc')->get();
      $week31 = allhistoryperweek31 ::orderBy('week', 'desc')->get();
      $week32 = allhistoryperweek32 ::orderBy('week', 'desc')->get();
      $week33 = allhistoryperweek33 ::orderBy('week', 'desc')->get();
      $week34 = allhistoryperweek34 ::orderBy('week', 'desc')->get();
      $week35 = allhistoryperweek35 ::orderBy('week', 'desc')->get();
      $week36 = allhistoryperweek36 ::orderBy('week', 'desc')->get();
      $week37 = allhistoryperweek37 ::orderBy('week', 'desc')->get();
      $week38 = allhistoryperweek38 ::orderBy('week', 'desc')->get();
      $week39 = allhistoryperweek39 ::orderBy('week', 'desc')->get();
      $week40 = allhistoryperweek40 ::orderBy('week', 'desc')->get();
      $week41 = allhistoryperweek41 ::orderBy('week', 'desc')->get();
      $week42 = allhistoryperweek42 ::orderBy('week', 'desc')->get();
      $week43 = allhistoryperweek43 ::orderBy('week', 'desc')->get();
      $week44 = allhistoryperweek44 ::orderBy('week', 'desc')->get();
      $week45 = allhistoryperweek45 ::orderBy('week', 'desc')->get();
      $week46 = allhistoryperweek46 ::orderBy('week', 'desc')->get();
      $week47 = allhistoryperweek47 ::orderBy('week', 'desc')->get();
      $week48 = allhistoryperweek48 ::orderBy('week', 'desc')->get();
      $week49 = allhistoryperweek49 ::orderBy('week', 'desc')->get();
      $week50 = allhistoryperweek50 ::orderBy('week', 'desc')->get();
      $week51 = allhistoryperweek51 ::orderBy('week', 'desc')->get();
      $week52 = allhistoryperweek52 ::orderBy('week', 'desc')->get();

      // return view('report.list_report_all_history_new_perweek', compact('reportmain_hrd'));
      return view('report.list_report_all_history_new_perweek', compact('week1', 'week2', 'week3', 'week4', 'week5', 'week6','week7','week8','week9','week10', 'week11', 'week12', 'week13', 'week14', 'week15', 'week16', 'week17', 'week18', 'week19', 'week20','week21','week22','week23','week24','week25','week26','week27','week28','week29', 'week30', 'week31', 'week32', 'week33', 'week34', 'week35', 'week36', 'week37', 'week38', 'week39', 'week40', 'week41', 'week42', 'week43', 'week44', 'week45', 'week46', 'week47', 'week48', 'week49', 'week50', 'week51', 'week52'));
    }
    public function index_list_report_all_history_new_monthly(Request $request)
    {
      // $reportmain_hrd = AllHistoryPerDayNew::all()
        //  $reportmain_hrd = AllHistoryPerMonthnew::orderBy('tanggal_main', 'desc')->get();
        // return view('report.list_report_all_history_new_permonth', compact('reportmain_hrd'));

        $januari = allhistoryjanuari::orderBy('month', 'desc')->get();
        $februari = allhistoryfebruari::orderBy('month', 'desc')->get();
        $maret = allhistorymaret::orderBy('month', 'desc')->get();
        $april = allhistoryapril::orderBy('month', 'desc')->get();
        $mei = allhistorymei::orderBy('month', 'desc')->get();
        $juni = allhistoryjuni::orderBy('month', 'desc')->get();
        $juli = allhistoryjuli::orderBy('month', 'desc')->get();
        $agustus = allhistoryagustus::orderBy('month', 'desc')->get();
        $september = allhistoryseptember::orderBy('month', 'desc')->get();
        $oktober = allhistoryoktober::orderBy('month', 'desc')->get();
        $november = allhistorynovember::orderBy('month', 'desc')->get();
        $desember = allhistorydesember::orderBy('month', 'desc')->get();
        return view('report.list_report_all_history_new_permonth', compact('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'));


    }

    public function index_report_all_history_weekly(Request $request)
    {
    //   $reportmain_hrd = AllHistoryPerWeek::all();
    
     $reportmain_hrd = DB::connection('mysql')->select("
          SELECT
          *
          FROM report_hrd_weekly
          ");
        //   dd($reportmain_hrd);die;
   
      return view('report.list_report_all_history_weekly', compact('reportmain_hrd'));
    }

    public function index_report_all_history_monthly(Request $request)
    {
      $reportmain_hrd = AllHistoryPerMonth::all();
      return view('report.list_report_all_history_monthly', compact('reportmain_hrd'));
    }
    public function index_report_call(Request $request)
    {
      $reportmain_hrd = DB::connection('mysql')->select("
      select Distinct
      table_main.created_at,
      table_call.NamaLowongan,
      table_call.Ms_Media_Code,
      table_main.Ms_Perusahaan_Code_main,
      table_main.Tr_report_hrd_main_code

      FROM tr_report_hrd_main table_main left JOIN
      tr_candidate_call table_call on table_main.Tr_report_hrd_main_code = table_call.Tr_report_hrd_main_code
      WHERE table_main.Ms_ReportType_Code ='Call'
      ");
      // dd($reportmain_hrd);die;
      return view('report.list_report_call', compact('reportmain_hrd'));
    }

    public function index_report_interview(Request $request)
    {
      $reportmain_hrd = DB::connection('mysql')->select("
      SELECT
      created_at,
      Tr_report_hrd_main_code,
      ms_lokasi,
      Ms_User_Code

      FROM tr_report_hrd_main
      where Ms_ReportType_Code ='Interview'
      order by created_at desc;
      ");
    //   dd($reportmain_hrd);die;
      return view('report.list_report_interview', compact('reportmain_hrd'));
    }

   public function index_report_dashboard(Request $request)
    {
      $reportmain_hrd = DB::connection('mysql')->select("
      WITH
      cte  AS (
          SELECT
          COUNT(table_opening.Tr_report_hrd_main_code) AS total_lamar,
          COUNT(table_call.Tr_report_hrd_main_code) AS total_panggil,
          COUNT(table_interview.Tr_report_hrd_main_code) AS total_interview,
          CONVERT(table_main.created_at, date) as tanggal_main

          FROM tr_report_hrd_main table_main left join tr_report_lowongan_d table_opening on table_main.Tr_report_hrd_main_code =table_opening.Tr_report_hrd_main_code 	LEFT JOIN
          tr_candidate_call table_call on table_main.Tr_report_hrd_main_code 			=table_call.Tr_report_hrd_main_code left JOIN tr_report_lowongan_interview table_interview on table_main.Tr_report_hrd_main_code = table_interview.Tr_report_hrd_main_code
          GROUP by CONVERT(table_main.created_at, date)) ,

      cte2 as ( SELECT
          COUNT(table_calls.Tr_report_hrd_main_code) AS total_ok_calls,
          CONVERT(table_calls.created_at, date) as tanggal_call
          FROM tr_report_hrd_main table_main left join tr_candidate_call table_calls on table_main.Tr_report_hrd_main_code =table_calls.Tr_report_hrd_main_code WHERE table_calls.Ms_Status ='Terhubung'
          group by CONVERT(table_calls.created_at, date) ),

      cte3 as ( SELECT
          count(table_interviews.Tr_report_hrd_main_code)as total_ok_interview,
          CONVERT(table_interviews.created_at, date) as tanggal_interview


          FROM tr_report_hrd_main table_main left join tr_report_lowongan_interview table_interviews on table_main.Tr_report_hrd_main_code =table_interviews.Tr_report_hrd_main_code WHERE table_interviews.hasil_interview !='Tidak Hadir'
          group by CONVERT(table_interviews.created_at, date) )

          SELECT tanggal_main, total_lamar, total_panggil, total_interview, total_ok_calls, total_ok_interview from cte c1 left join cte2 c2 on c1.tanggal_main = c2.tanggal_call left join cte3 c3 on c1.tanggal_main = c3.tanggal_interview
          order by tanggal_main desc;
      ");

      // dd($reportmain_hrd);die;
      return view('report.list_report_dashboard', compact('reportmain_hrd'));
    }

  }
