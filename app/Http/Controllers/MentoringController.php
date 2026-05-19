<?php

namespace App\Http\Controllers;
use App\Models\Ms_Company;
use App\Models\Ms_type_sp;
use App\Models\MsBranch;
use App\Models\MasterEmployee;
use App\Models\Tr_SP_Main;
use App\Models\Tr_SP_H;
use App\Models\Tr_SP_D;
use App\Models\MsLocation;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class MentoringController extends Controller
{
  public function mentor (Request $request, $id)
  {
    // dd($id);die;
    $user = auth()->user();
    $pegawai = $id;
    $pt = Ms_Company::all();
    $lokasi = MsLocation::all();
    $tipe = Ms_type_sp::all();
    $employee = MasterEmployee::all();


    //code main
    $last_id = DB::connection('mysql')->select("
    SELECT
    id
    FROM tr_acc_sp_main
    order by created_at desc
    LIMIT 1
    ");
    foreach($last_id as $ids)
  { $kode = $ids->id;}

  $sp_main_code='Mentor'. '-'. date('d').'-'.date('m').'-'.date('Y').'-'."000".$kode+1;
   //code header
  $last_code = DB::connection('mysql')->select("
  SELECT
  id
  FROM tr_acc_sp_h
  order by created_at desc
  LIMIT 1
  ");

  foreach($last_code as $idss)
  { $kodes = $idss->id;}

        $tr_acc_sp_h_code='Mentor'. '-'. date('Ydm').'-'."000".$kodes+1;

        $pegawai = DB::connection('mysql')->select("
        SELECT
        *
        FROM master_employees where emp_id ='$id'
        ");

        foreach($pegawai as $staff)
        { $pegawainya = $staff;}

    return view ('berita_acara.mentor', compact('user', 'pt', 'lokasi', 'tipe', 'employee', 'sp_main_code', 'tr_acc_sp_h_code', 'pegawainya'));
  }

  public function store_mentoring(Request $request)
  {

    $main = new Tr_SP_Main();
    $main->rec_usercreated        = $request->rec_usercreated;
    $main->rec_datecreated        = Carbon::now()->toDateTimeString();;
    $main->rec_status             = 1;
    $main->sp_main_code           = $request->sp_main_code;
    $main->ms_company             = $request->ms_company;
    $main->ms_lokasi              = $request->ms_lokasi;
    $main->sp_type                = 'Panggil Mentoring';
    $main->sp_jenis               = 'Panggil Mentoring';
    $main->ms_employee            = $request->sp_employee;
    $main->ms_divisi              = $request->sp_divisi;
    $main->masa_berlaku           = $request->masa_berlaku;
    $main->sp_desc                = 'Panggil Mentoring';
    // dd($main);die;
    $main->save();

    $header = new Tr_SP_H();
    $header->rec_usercreated        = $request->rec_usercreated;
    $header->rec_datecreated        = Carbon::now()->toDateTimeString();;
    $header->rec_status             = 1;
    $header->tr_acc_sp_h_code       = $request->tr_acc_sp_h_code;
    $header->tr_acc_sp_main_code    = $request->sp_main_code;
    $header->rec_comcode            = $main->ms_company;
    $header->rec_areacode           = $main->ms_lokasi;
    $header->sp_employee            = $request->sp_employee;
    $header->sp_divisi              = $request->sp_divisi;
    $header->save();
        foreach($request['sp_note'] as $key => $item_id)
          {
              $sp_d = new Tr_SP_D();
              $sp_d->tr_acc_sp_d_code   = '';
              $sp_d->tr_acc_sp_h_code   = $request->tr_acc_sp_h_code;
              $sp_d->sp_note            = $request['sp_note'][$key];
              $sp_d->save();
          }

   $code_main = DB::connection('mysql')->select("
    SELECT distinct
        main.sp_main_code,
        main.rec_usercreated,
        main.rec_datecreated,
        main.ms_company,
        main.ms_lokasi,
        main.sp_type,
        header.sp_employee,
        header.sp_divisi

        from tr_acc_sp_main main
        left JOIN tr_acc_sp_h header on main.sp_main_code = header.tr_acc_sp_main_code

        where main.sp_main_code = '$request->sp_main_code';
    ");

    $detail = DB::connection('mysql')->select("
    SELECT
        main.sp_main_code,
        main.rec_usercreated,
        main.rec_datecreated,
        main.ms_company,
        main.ms_lokasi,
        header.sp_employee,
        header.sp_divisi,
        detail.sp_note

        from tr_acc_sp_main main
        left JOIN tr_acc_sp_h header on main.sp_main_code = header.tr_acc_sp_main_code
        LEFT JOIN tr_acc_sp_d detail on header.tr_acc_sp_h_code = detail.tr_acc_sp_h_code

        where main.sp_main_code =  '$request->sp_main_code'
        ;

    ");

          return view('sp.detail_sp', compact('code_main', 'detail'));
          // return view('home');
  }
}
