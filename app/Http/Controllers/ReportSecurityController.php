<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report_Memo;
use App\Models\Main_reportSecurity;
use App\Models\Report_TemuanSecurity;
use Illuminate\Support\Str;
use DB;

class ReportSecurityController extends Controller
{
    public function create_memo()
    {
        return view('security.report_memo');
    }
    public function create_temuan()
    {
        return view('security.temuan');
    }

    public  function store(Request $request)
    {      
            $last_code = DB::connection('mysql')->select("
            SELECT
            id
            FROM tr_report_security_main
            order by id desc
            LIMIT 1 
            ");
            $last_date = DB::connection('mysql')->select("
            SELECT
            created_at
            FROM tr_report_security_main
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
            $ambilkode=Main_reportSecurity::where($request->Tr_report_security_main_code)->get();
            $nambah=count($ambilkode)+1;
            if ($nambah <10000)
            {
                $Tr_report_security_main_code='MAINSCR'. '-'. date('Ydm').'-'."00".$nambah;
            }

            $main_report_security = new Main_reportSecurity();
            $main_report_security->Tr_report_security_main_code  = $Tr_report_security_main_code;
            $main_report_security->Ms_ReportType_Code            = $request->Ms_ReportType_Code;
            $main_report_security->Ms_User_Code                  = $request->Ms_User_Code;
            $main_report_security->ms_divisi                     = $request->ms_divisi;
            $main_report_security->ms_lokasi                     = $request->ms_lokasi;
            $main_report_security->save();  

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
                $memo->Tr_report_main_code     = $main_report_security->Tr_report_security_main_code; 
                $memo->Ms_User_Code            = $request->Ms_User_Code;
                $memo->rec_comcode             = $request->rec_comcode;
                $memo->rec_areacode            = $request->rec_areacode;
                $memo->ms_divisi               = $request->ms_divisi;
                $memo->Ms_ReportType_Code      = 'Memo';
                $memo->Memo                    = $request->Memo;
                $memo->save();  
                }  
             
            else if ($request->Ms_ReportType_Code =='Temuan')
            {
    
              foreach($request['nama_temuan'] as $key => $item_id)
                {
        
                    $report_temuan = new Report_TemuanSecurity();
                    $report_temuan->Ms_User_Code                 = $request->Ms_User_Code;
                    $report_temuan->ms_divisi                    = $request->ms_divisi;
                    $report_temuan->Tr_Report_temuan_code        = '';
                    $report_temuan->Tr_report_security_main_code = $main_report_hrd->Tr_report_security_main_code; 
                    $report_temuan->nama_temuan                  = $request['nama_temuan'][$key];
                    $report_temuan->Ms_ReportType_Code           = 'Temuan';
                    $report_temuan->nama_penemu                  = $request['nama_penemu'][$key];
                    $report_temuan->tanggal_ditemukan            = $request['tanggal_ditemukan'][$key];
                    $report_temuan->save();
                }
            }
        }         
}
