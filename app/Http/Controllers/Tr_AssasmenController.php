<?php

namespace App\Http\Controllers;
use App\Models\tr_job_assesment_all_Main;
use App\Models\MasterEmployee;
use App\Models\MsDivisi;
use App\Models\tr_emp_assesment;
use App\Models\tr_emp_assesor;
use App\Models\tr_emp_asses_basic_result;
use App\Models\tr_emp_asses_note;
use App\Models\ms_rating_asasmen_basic;
use App\Models\tr_emp_asses_advance_result;
use App\Models\tr_emp_asses_discipline_result;
use App\Models\tr_q1_user_assesor_h;
use App\Models\tr_Period_emp_assesor_main;
use App\Models\tr_period_emp;
use App\Models\tr_period_emp_task;
use App\Models\tr_task_result;
use App\Models\tr_period_asssement;
use App\Models\Tr_Review_EmpPeriod_h;
use App\Models\Tr_Review_EmpPeriod_Basic_Reviewer;
use App\Models\Tr_Review_EmpPeriod_Task_Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;
use DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Ui\Presets\React;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use \Mpdf\Mpdf as MPDF;

class Tr_AssasmenController extends Controller
{
    public function create(Request $request)
    {
        $user = auth()->user();

        $employee = MasterEmployee::all();
        $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();


                $Tr_Job_Assesment_all_code= 'TES';

                 $tr_assessment_code_h='TES2';
      //     }
      return view('asasmen.create_asasmen_basic_1', compact('user', 'operators', 'Tr_Job_Assesment_all_code', 'tr_assessment_code_h'));
    }
    public function view_history(Request $request)
    {

      $code_main = tr_job_assesment_all_Main::all();
      // dd($code_main);die;
      return view('asasmen.history_main', compact('code_main'));
    }
    public function detail_view_history(Request $request, $id)
    {
      $user = auth()->user();
      $employee = MasterEmployee::all();
      $ms_divisi = MsDivisi::all();
      $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

      $code_main = DB::connection('mysql')->select("
      SELECT DISTINCT
           CONVERT(tabel_main.created_at, date) as tanggal_1,
           tabel_main.Tr_Job_Assesment_all_code,
           table_h.Ass_periode,
           tabel_main.Atasan_Code,
           tabel_main.ms_divisi

           from  tr_job_assesment_all tabel_main
           left join tr_ass_h_leadership4 table_h on tabel_main.Tr_Job_Assesment_all_code = table_h.tr_assessment_code_main
           left join tr_ass_d_leadership4 table_d on table_h.tr_assessment_code_h = table_d.tr_assestment_code_h
           where Tr_Job_Assesment_all_code = '$id'
      ");

      foreach($code_main as $codes)
          { $code = $codes->Tr_Job_Assesment_all_code;}
      foreach($code_main as $codes)
          { $nama_divisi = $codes->ms_divisi;}
      foreach($code_main as $codes)
          { $periode = $codes->Ass_periode;}
          $basic1 = DB::connection('mysql')->select("
          with cte as
          (
                    SELECT
                        CONVERT(table_h.created_at, date) as tanggal_1,
                        table_h.Ass_div as divisi1,
                        table_d.ass_employeecode as employee1,
                        table_d.ass_mengarahkan as ass_mengarahkan1,
                        table_d.ass_problem_solving as ass_problem_solving1,
                        table_d.ass_planning as ass_planning1,
                        table_d.ass_analisa as ass_analisa1,
                        table_d.ass_kualitas_komunikasi as ass_kualitas_komunikasi1,
                        table_d.ass_note as ass_note1
                        from  tr_ass_h_leadership1 table_h
                        left join tr_ass_d_leadership1 table_d on table_h.tr_assessment_code_h = table_d.tr_assestment_code_h
                        where Ass_div = '$nama_divisi' and rec_status !='0'),
          cte2
          as (
                SELECT
                      CONVERT(table_h.created_at, date) as tanggal_2,
                      table_h.Ass_div as divisi2,
                      table_d.ass_employeecode as employee2,
                      table_d.ass_mengarahkan as ass_mengarahkan2,
                      table_d.ass_problem_solving as ass_problem_solving2,
                      table_d.ass_planning as ass_planning2,
                      table_d.ass_analisa as ass_analisa2,
                      table_d.ass_kualitas_komunikasi as ass_kualitas_komunikasi2,
                      table_d.ass_note as ass_note2
                      from  tr_ass_h_leadership2 table_h
                      left join tr_ass_d_leadership2 table_d on table_h.tr_assessment_code_h = table_d.tr_assestment_code_h
                      where Ass_div = '$nama_divisi'),

          cte3
          as (
              SELECT
                      CONVERT(table_h.created_at, date) as tanggal_3,
                      table_h.Ass_div as divisi3,
                      table_d.ass_employeecode as employee3,
                      table_d.ass_mengarahkan as ass_mengarahkan3,
                      table_d.ass_problem_solving as ass_problem_solving3,
                      table_d.ass_planning as ass_planning3,
                      table_d.ass_analisa as ass_analisa3,
                      table_d.ass_kualitas_komunikasi as ass_kualitas_komunikasi3,
                      table_d.ass_note as ass_note3
                      from  tr_ass_h_leadership3 table_h
                      left join tr_ass_d_leadership3 table_d on table_h.tr_assessment_code_h = table_d.tr_assestment_code_h
                      where Ass_div = '$nama_divisi'),

          cte4
          as (
              SELECT
                      CONVERT(table_h.created_at, date) as tanggal_4,
                      table_h.Ass_div as divisi4,
                      table_d.ass_employeecode as employee4,
                      table_d.ass_mengarahkan as ass_mengarahkan4,
                      table_d.ass_problem_solving as ass_problem_solving4,
                      table_d.ass_planning as ass_planning4,
                      table_d.ass_analisa as ass_analisa4,
                      table_d.ass_kualitas_komunikasi as ass_kualitas_komunikasi4,
                      table_d.ass_note as ass_note4
                      from  tr_ass_h_leadership4 table_h
                      left join tr_ass_d_leadership4 table_d on table_h.tr_assessment_code_h = table_d.tr_assestment_code_h
                      where Ass_div = '$nama_divisi')


                      SELECT DISTINCT
                      c1.tanggal_1,
                      c1.divisi1,
                      c1.employee1,
                      c1.ass_mengarahkan1,
                      c1.ass_problem_solving1,
                      c1.ass_planning1,
                      c1.ass_analisa1,
                      c1.ass_kualitas_komunikasi1,
                      c1.ass_note1,
                      c2.tanggal_2,
                      c2.divisi2,
                      c2.employee2,
                      c2.ass_mengarahkan2,
                      c2.ass_problem_solving2,
                      c2.ass_planning2,
                      c2.ass_analisa2,
                      c2.ass_kualitas_komunikasi2,
                      c2.ass_note2,
                      c3.tanggal_3,
                      c3.divisi3,
                      c3.employee3,
                      c3.ass_mengarahkan3,
                      c3.ass_problem_solving3,
                      c3.ass_planning3,
                      c3.ass_analisa3,
                      c3.ass_kualitas_komunikasi3,
                      c3.ass_note3,
                      c4.tanggal_4,
                      c4.divisi4,
                      c4.employee4,
                      c4.ass_mengarahkan4,
                      c4.ass_problem_solving4,
                      c4.ass_planning4,
                      c4.ass_analisa4,
                      c4.ass_kualitas_komunikasi4,
                      c4.ass_note4

              from cte c1
                    left join cte2 c2 on c1.divisi1 = c2.divisi2
                    and c1.employee1 = c2.employee2
                    left join cte3 c3 on c1.divisi1 = c3.divisi3
                    and c1.employee1 = c3.employee3
                    left join cte4 c4 on c1.divisi1 = c4.divisi4
                    and c1.employee1 = c4.employee4
          ");
          return view('asasmen.detail_asmaster_employeesasmen_history', compact('user', 'operators', 'basic1', 'nama_divisi', 'code', 'periode'));
    }

//     public function all_staff(Request $request)
//     {
//       $user = auth()->user();
//       $periode= DB::connection('mysql')->select("
//       select * from ms_periode_assessment where rec_status ='1'
//       ");

//       if ($user && in_array($user->sub_divisi, ['Manager Finance', 'Manager Operasional', 'General Manager', 'BOD', 'HR']))
//       {

//         $employee= DB::connection('mysql')->select("
//         select DISTINCT
// 		CASE
// 		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
//         ms.emp_id as id,
//         ms.emp_name,
// 	    ms.emp_iddivision,
//         ms.emp_subdivision,
//         ms.emp_kotalahir,
//         ms.emp_datejoin,
//         CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
//         main.Tr_Review_EmpPeriod_Code_h

//         from master_employees ms
//         left join users usr on ms.emp_name = usr.name
//         left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

//         where ms.rec_status ='1'
//         and ms.emp_inactive ='1'
//         and ms.emp_subdivision != 'driver'
//         and ms.emp_subdivision != 'helper'
// 		and ms.emp_subdivision != 'Motorist'
//         order by ms.emp_name asc
//          ");

//           $users= DB::connection('mysql')->select("

//           	select * from master_employees
//           	where rec_status ='1'
//             and emp_inactive ='1'
//             and emp_subdivision != 'driver'
//             and emp_subdivision != 'helper'
//             and emp_subdivision != 'Motorist'
//             and emp_name != '--'
//             order by emp_name asc
//           ");

//         return view('asasmen.ms_employee', compact('employee', 'users', 'periode'));

//       }

//       else if ($user->sub_divisi == 'Supervisor' && ($user->name == 'Umar Abdul Aziz' || $user->name == 'Erwin Noor Stanza'))
//       {
//         $employee= DB::connection('mysql')->select("
//         select DISTINCT
// 		CASE
// 		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
//         ms.emp_id as id,
//         ms.emp_name,
// 	    ms.emp_iddivision,
//         ms.emp_subdivision,
//         ms.emp_kotalahir,
//         ms.emp_datejoin,
//         CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
//         main.Tr_Review_EmpPeriod_Code_h

//         from master_employees ms
//         left join users usr on ms.emp_name = usr.name
//         left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

//         where ms.rec_status ='1'
//         and ms.emp_inactive ='1'
//         and ms.emp_subdivision != 'driver'
//         and ms.emp_subdivision != 'helper'
// 		and ms.emp_subdivision != 'Motorist'
//         and ( ms.emp_subdivision ='Staff Finance'	or ms.emp_subdivision ='Cashier')
//         order by ms.emp_name asc
//          ");


//           $users= DB::connection('mysql')->select("
//           select * from master_employees
//           where rec_status ='1'
//           and emp_inactive ='1'
//           and emp_subdivision != 'driver'
//           and emp_subdivision != 'helper'
//           order by emp_name asc
//           ");

//         return view('asasmen.ms_employee', compact('employee', 'users', 'periode'));
//       }


//       else if ($user->sub_divisi == 'Supervisor' && ( $user->name == 'ifanuella Reinaldo' || $user->name == 'Fernando' || $user->name == 'Haryadih'))
//       {
//         $employee= DB::connection('mysql')->select("
//         select DISTINCT
// 		CASE
// 		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
//         ms.emp_id as id,
//         ms.emp_name,
// 	    ms.emp_iddivision,
//         ms.emp_subdivision,
//         ms.emp_kotalahir,
//         ms.emp_datejoin,
//         CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
//         main.Tr_Review_EmpPeriod_Code_h

//         from master_employees ms
//         left join users usr on ms.emp_name = usr.name
//         left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

//         where ms.rec_status ='1'
//         and ms.emp_inactive ='1'
//         and ms.emp_subdivision != 'driver'
//         and ms.emp_subdivision != 'helper'
// 		and ms.emp_subdivision != 'Motorist'
//         and ( ms.emp_subdivision ='Dispatcher'	or ms.emp_subdivision ='Petrolman' or ms.emp_subdivision ='Checker Plant'	or ms.emp_subdivision ='Operasional' or ms.emp_subdivision ='Service Officer' or ms.emp_subdivision ='Senior Mekanik' or ms.emp_subdivision ='Staff Senior Petrolman' or ms.emp_subdivision ='Junior Mekanik'	 or ms.emp_subdivision ='Mechanic' or ms.emp_subdivision ='Data Entry' or ms.emp_subdivision ='Service Officer' or ms.emp_subdivision ='Spv Transport' or ms.emp_subdivision ='Operasional' or ms.emp_subdivision ='PIC Project')
//         order by ms.emp_name asc"
//         );

//           $users= DB::connection('mysql')->select("
//           select * from master_employees
//           where rec_status ='1'
//           and emp_inactive ='1'
//           and emp_subdivision != 'driver'
//           and emp_subdivision != 'helper'
//           order by emp_name asc
//           ");

//         return view('asasmen.ms_employee', compact('employee', 'users', 'periode'));
//       }

//       else if ($user->sub_divisi == 'Supervisor' && $user->name == 'Dwi Purwanto' || $user->name == 'Dwi Purwanto Ops')
//       {
//         $employee= DB::connection('mysql')->select("
//         select DISTINCT
// 		CASE
// 		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
//         ms.emp_id as id,
//         ms.emp_name,
// 	    ms.emp_iddivision,
//         ms.emp_subdivision,
//         ms.emp_kotalahir,
//         ms.emp_datejoin,
//         CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
//         main.Tr_Review_EmpPeriod_Code_h

//         from master_employees ms
//         left join users usr on ms.emp_name = usr.name
//         left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

//         where ms.rec_status ='1'
//         and ms.emp_inactive ='1'
//         and ms.emp_subdivision != 'driver'
//         and ms.emp_subdivision != 'helper'
// 		and ms.emp_subdivision != 'Motorist'
//         and ( ms.emp_subdivision ='Gudang' or ms.emp_subdivision ='Kepala Gudang' or ms.emp_subdivision ='Dispatcher'	or ms.emp_subdivision ='Petrolman' or ms.emp_subdivision ='Checker Plant'	or ms.emp_subdivision ='Operasional' or ms.emp_subdivision ='Service Officer' or ms.emp_subdivision ='Senior Mekanik' or ms.emp_subdivision ='Staff Senior Petrolman' or ms.emp_subdivision ='Junior Mekanik'	 or ms.emp_subdivision ='Mechanic' or ms.emp_subdivision ='Data Entry')
//         order by ms.emp_name asc
//          ");

//           $users= DB::connection('mysql')->select("
//           select * from master_employees
//           where rec_status ='1'
//           and emp_inactive ='1'
//           and emp_subdivision != 'driver'
//           and emp_subdivision != 'helper'
//           order by emp_name asc
//           ");

//         return view('asasmen.ms_employee', compact('employee', 'users', 'periode'));
//       }

//       else if ($user->sub_divisi == 'Supervisor')
//       {

//       $employee= DB::connection('mysql')->select("

//         select
//         ms.rec_datecreated as rec_userupdate,
//         ms.emp_id as id,
//         ms.emp_name,
// 		ms.emp_iddivision,
//         ms.emp_subdivision,
//         ms.emp_kotalahir,
//         ms.emp_datejoin,
// 		'' as ms_periode,
// 	    '' as Ms_record_asses,
// 		'' as id_period_emp_assesor

//         from master_employees ms

//         where ms.rec_status ='1'
//         and ms.emp_inactive ='1'
//         and ms.emp_subdivision != 'driver'
//         and ms.emp_subdivision != 'helper'
// 		and ms.emp_subdivision != 'Motorist'
//         and ms.emp_subdivision ='$user->ms_divisi'
//         order by ms.emp_name asc
//          ");

//           $users= DB::connection('mysql')->select("
//           select * from master_employees
//           where rec_status ='1'
//           and emp_inactive ='1'
//           and emp_subdivision != 'driver'
//           and emp_subdivision != 'helper'
//           order by emp_name asc
//           ");

//         return view('asasmen.ms_employee', compact('employee', 'users', 'periode'));
//       }

//       else
//       {
//         $employee= DB::connection('mysql')->select("
//         select DISTINCT
// 		CASE
// 		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
//         ms.emp_id as id,
//         ms.emp_name,
// 	    ms.emp_iddivision,
//         ms.emp_subdivision,
//         ms.emp_kotalahir,
//         ms.emp_datejoin,
//         CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
//         main.Tr_Review_EmpPeriod_Code_h

//         from master_employees ms
//         left join users usr on ms.emp_name = usr.name
//         left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

//         where ms.rec_status ='1'
//         and ms.emp_inactive ='1'
//         and ms.emp_subdivision != 'driver'
//         and ms.emp_subdivision != 'helper'
// 		and ms.emp_subdivision != 'Motorist'
//         and usr.name ='$user->name'
//         order by ms.emp_name asc
//          ");


//           $users= DB::connection('mysql')->select("
//           select * from master_employees
//           where rec_status ='1'
//           and emp_inactive ='1'
//           and emp_subdivision != 'driver'
//           and emp_subdivision != 'helper'
//           order by emp_name asc
//           ");

//         return view('asasmen.ms_employee', compact('employee', 'users', 'periode'));
//       }

//     }

 public function all_staff(Request $request)
    {
      $user = auth()->user();
      $periode= DB::connection('mysql')->select("
      select * from ms_periode_assessment where rec_status ='1'
      ");

      $tanggalSekarang = Carbon::now();
      $tahunSaatIni = $tanggalSekarang->year;
      // Tentukan rentang periode
      $q1Start = Carbon::create(null, 1, 1);
      $q1End = Carbon::create(null, 3, 31);
      $q2Start = Carbon::create(null, 4, 1);
      $q2End = Carbon::create(null, 6, 30);
      $q3Start = Carbon::create(null, 7, 1);
      $q3End = Carbon::create(null, 9, 30);
      $q4Start = Carbon::create(null, 10, 1);
      $q4End = Carbon::create(null, 12, 31);

      // Tentukan periode
      if ($tanggalSekarang->between($q1Start, $q1End)) {
          $periodeQ = 'Q1';
      } elseif ($tanggalSekarang->between($q2Start, $q2End)) {
          $periodeQ = 'Q2';
      } elseif ($tanggalSekarang->between($q3Start, $q3End)) {
          $periodeQ = 'Q3';
      } elseif ($tanggalSekarang->between($q4Start, $q4End)) {
          $periodeQ = 'Q4';
      } else {
          $periodeQ = 'Tidak dalam periode yang ditentukan';
      }
      // dd($periodeQ);
      if ($user && in_array($user->sub_divisi, ['Manager Finance', 'Manager Operasional', 'General Manager', 'BOD', 'HR']))
      {

        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
		order by ms.emp_name asc
         ");

          $users= DB::connection('mysql')->select("

          	select * from master_employees
          	where rec_status ='1'
            and emp_inactive ='1'
            and emp_subdivision != 'driver'
            and emp_subdivision != 'helper'
            and emp_subdivision != 'Motorist'
            and emp_name != '--'
            order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));

      }

      else if ($user->sub_divisi == 'Supervisor' && ($user->name == 'Umar Abdul Aziz' || $user->name == 'Erwin Noor Stanza'))
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Staff Finance'	or ms.emp_subdivision ='Cashier')
        order by ms.emp_name asc
         ");


          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }
      
      //purchasing
      else if ($user->sub_divisi == 'Supervisor' && ($user->name == 'Fajar Purnama'))
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Purchasing')
        order by ms.emp_name asc
         ");


          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }
      //Audit
      else if ($user->sub_divisi == 'Supervisor' && ($user->name == 'Tri Valentino'))
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Audit')
        order by ms.emp_name asc
         ");


          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }
      
      //Dispatcher
      else if ($user->sub_divisi == 'Supervisor' && ($user->name == 'Haryadih'))
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Dispatcher')
        order by ms.emp_name asc
         ");


          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }
      
       //Programmer
      else if ($user->sub_divisi == 'Supervisor' && ($user->name == 'Imam Herdiyanto'))
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Programmer' or ms.emp_subdivision ='IT Support' )
        order by ms.emp_name asc
         ");


          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }
 //Sales
      else if ($user->sub_divisi == 'Supervisor' && ($user->name == 'Dedi Septendi' || $user->name == 'Priyono'))
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Sales Taking Order')
        order by ms.emp_name asc
         ");


          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }

    // Operasional
      else if ($user->sub_divisi == 'Supervisor' && ( $user->name == 'ifanuella Reinaldo' || $user->name == 'Fernando' || $user->name == 'Haryadih'))
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Dispatcher'	or ms.emp_subdivision ='Petrolman' or ms.emp_subdivision ='Checker Plant'	or ms.emp_subdivision ='Operasional' or ms.emp_subdivision ='Service Officer' or ms.emp_subdivision ='Senior Mekanik' or ms.emp_subdivision ='Staff Senior Petrolman' or ms.emp_subdivision ='Junior Mekanik'	 or ms.emp_subdivision ='Mechanic' or ms.emp_subdivision ='Data Entry' or ms.emp_subdivision ='Service Officer' or ms.emp_subdivision ='Spv Transport' or ms.emp_subdivision ='Operasional' or ms.emp_subdivision ='PIC Project' or ms.emp_subdivision ='Fleet' or ms.emp_subdivision ='Security' or ms.emp_subdivision ='Staff Ga' or ms.emp_subdivision ='GA' or ms.emp_subdivision ='Operasional First Mile')
        order by ms.emp_name asc"
        );

          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode' , 'periodeQ', 'tahunSaatIni'));
      }

      else if ($user->sub_divisi == 'Supervisor' && $user->name == 'Dwi Purwanto' || $user->name == 'Dwi Purwanto Ops')
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ( ms.emp_subdivision ='Gudang' or ms.emp_subdivision ='Kepala Gudang' or ms.emp_subdivision ='Dispatcher'	or ms.emp_subdivision ='Petrolman' or ms.emp_subdivision ='Checker Plant'	or ms.emp_subdivision ='Operasional' or ms.emp_subdivision ='Service Officer' or ms.emp_subdivision ='Senior Mekanik' or ms.emp_subdivision ='Staff Senior Petrolman' or ms.emp_subdivision ='Junior Mekanik'	 or ms.emp_subdivision ='Mechanic' or ms.emp_subdivision ='Data Entry')
        order by ms.emp_name asc
         ");

          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }

      else if ($user->sub_divisi == 'Supervisor')
      {

        $employee= DB::connection('mysql')->select("

        select
        ms.rec_datecreated as rec_userupdate,
        ms.emp_id as id,
        ms.emp_name,
		ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
		'' as ms_periode,
		'' as Ms_record_asses,
		'' as id_period_emp_assesor

        from master_employees ms
        
        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and ms.emp_subdivision ='$user->ms_divisi'
        order by ms.emp_name asc
         ");

          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }

      else
      {
        $employee= DB::connection('mysql')->select("
        select DISTINCT
		CASE
		WHEN main.rec_userupdate is null OR main.rec_userupdate = '' THEN main.rec_usercreated ELSE main.rec_userupdate END AS user_update,
        ms.emp_id as id,
        ms.emp_name,
	    ms.emp_iddivision,
        ms.emp_subdivision,
        ms.emp_kotalahir,
        ms.emp_datejoin,
        CONCAT(main.ms_periode, ' (', DATE_FORMAT(main.created_at, '%d-%m-%Y'), ')') as ms_periode,
        main.Tr_Review_EmpPeriod_Code_h

        from master_employees ms
        left join users usr on ms.emp_name = usr.name
        left join Tr_Review_EmpPeriod_h  main on ms.emp_name = main.Ms_Emp_Code

        where ms.rec_status ='1'
        and ms.emp_inactive ='1'
        and ms.emp_subdivision != 'driver'
        and ms.emp_subdivision != 'helper'
		and ms.emp_subdivision != 'Motorist'
        and usr.name ='$user->name'
        order by ms.emp_name asc
         ");
          $users= DB::connection('mysql')->select("
          select * from master_employees
          where rec_status ='1'
          and emp_inactive ='1'
          and emp_subdivision != 'driver'
          and emp_subdivision != 'helper'
          order by emp_name asc
           ");

        return view('asasmen.ms_employee', compact('employee', 'users', 'periode', 'periodeQ', 'tahunSaatIni'));
      }

    }

    public function create_basic(Request $request, $id)
    {

      $user = auth()->user();

      $ms_divisi = MsDivisi::all();
      $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();
      // $periode= DB::connection('mysql')->select("
      //  select * from ms_periode_assessment where rec_status ='1'
      //  ");
      // dd($periode);
       $ms_rating_basic= DB::connection('mysql')->select("
       select * from ms_rating_asasmen_basic where rec_status ='1'
       ");

       $code_asas='ASSMN'.'-'.date('Ydm').'-0001';
       $max_emp_code = DB::connection('mysql')->select("
       SELECT
       Tr_Emp_Asses_Code
       FROM tr_emp_assesment
       order by id desc
       LIMIT 1
       ");

       foreach($max_emp_code as $row)
       {
         $kalimat = $row->Tr_Emp_Asses_Code;
         $sort_num = (int) substr($kalimat,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;
       }
      // dd($ms_rating_basic);die;
      //  return view('asasmen.assasmen_basic');
       return view('asasmen.assasmen_basic', compact('user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));
    }

    public function create_spv(Request $request, $id)
    {
      $periode= DB::connection('mysql')->select("
      select * from ms_periode_assessment where rec_status ='1'
      ");
      $user = auth()->user();
      $employee = MasterEmployee::all();
      $operators = MasterEmployee::where('emp_name', '=', $id)->first();
      $ms_divisi = MsDivisi::all();

        return view('asasmen.assasmen_basic', compact('periode','user', 'operators', 'employee', 'ms_divisi'));
    }

    public function simpan_basic (Request $request)
    {
      $main_ases = new tr_emp_assesment();
      $main_ases->rec_usercreated    = $request->Ms_Emp_Assessor_Code;
      $main_ases->rec_userupdate     = '';
      $main_ases->rec_datecreated    = Carbon::now()->toDateTimeString();
      $main_ases->rec_status         = '1';
      $main_ases->Date_Asses         = Carbon::now()->toDateTimeString();
      $main_ases->Tr_Emp_Asses_Code  = $request->Tr_Emp_Asses_Code;
      $main_ases->Ms_Emp_Code        = $request->Ms_Emp_Code;
      $main_ases->Ms_Emp_Div         = $request->Ms_Emp_Div;
      $main_ases->Ms_type_asses      = $request->Ms_type_asses;
      $main_ases->Ms_record_asses    = $request->Ms_record_asses;
      $main_ases->save();

      $asessor = new tr_emp_assesor();
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = Carbon::now()->toDateTimeString();
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $request->Tr_Emp_Asses_Code;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = Carbon::now()->toDateTimeString();
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      $rating = new tr_emp_asses_basic_result();
      $rating->Tr_Emp_Asses_Code       = $request->Tr_Emp_Asses_Code;
      $rating->Ms_Emp_Assessor_Code    = $request->Ms_Emp_Assessor_Code;
      $rating->Trust_value             = $request->Trust_value;
      $rating->trust_comment           = $request->trust_comment;
      $rating->drive_value             = $request->drive_value;
      $rating->drive_comment           = $request->drive_comment;
      $rating->inisiative_value        = $request->inisiative_value;
      $rating->inisiatif_comment       = $request->inisiatif_comment;
      $rating->Reliable_value          = $request->Reliable_value;
      $rating->reliable_comment        = $request->reliable_comment;
      $rating->reslut                  = $request->reslut;
      $rating->result_comment          = $request->result_comment;
      $rating->save();

      $noteS = new tr_emp_asses_note();
      $noteS->Tr_Emp_Asses_Code       = $request->Tr_Emp_Asses_Code;
      $noteS->Ms_Emp_Assessor_Code    = $request->Ms_Emp_Assessor_Code;
      $noteS->note                    = $request->note_asses;
      $noteS->save();

      session()->flash('success', 'Assasmen berhasil disimpan!');
      return redirect ('asasmen/create_asasmen_basic');

      // return redirect ('/asasmen_basic');
    }
     public function history_basic(Request $request)
    {
        $user = auth()->user();
        if ($user && in_array($user->sub_divisi, ['Manager Finance', 'Manager Operasional', 'General Manager', 'BOD', 'HR']))
        {
           $employee= DB::connection('mysql')->select("
              select DISTINCT
              main.created_at,
              main.Tr_Review_EmpPeriod_Code_h,
              main.Ms_emp_code,
              main.Ms_Emp_Div,
              main.ms_periode,
              hasil.Ms_Reviewer_Code
              from Tr_Review_EmpPeriod_h main
              left join users user on main.rec_usercreated = user.name
              left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
              left join Tr_Review_EmpPeriod_Basic_Reviewer hasil on main.Tr_Review_EmpPeriod_Code_h = hasil.Tr_Review_EmpPeriod_Code_h
              where main.rec_status  ='1'
              order by main.created_at desc
            ");
            return view('asasmen.history_asasmen', compact('employee'));
        }
       else if ($user->sub_divisi == 'Supervisor' && ( $user->name == 'ifanuella Reinaldo' || $user->name == 'Fernando' || $user->name == 'Haryadih'))
       {
            $employee= DB::connection('mysql')->select("
            select DISTINCT
            main.created_at,
            main.Tr_Review_EmpPeriod_Code_h,
            main.Ms_emp_code,
            main.Ms_Emp_Div,
            main.ms_periode,
            hasil.Ms_Reviewer_Code
            from Tr_Review_EmpPeriod_h main
            left join users user on main.rec_usercreated = user.name
            left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
            left join Tr_Review_EmpPeriod_Basic_Reviewer hasil on main.Tr_Review_EmpPeriod_Code_h = hasil.Tr_Review_EmpPeriod_Code_h
            where main.rec_status  ='1'
            and ( main.Ms_Emp_Div ='Dispatcher'	or main.Ms_Emp_Div ='Petrolman' or main.Ms_Emp_Div ='Checker Plant'	or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Senior Mekanik' or main.Ms_Emp_Div ='Staff Senior Petrolman' or main.Ms_Emp_Div ='Junior Mekanik'	 or main.Ms_Emp_Div ='Mechanic' or main.Ms_Emp_Div ='Data Entry' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Spv Transport' or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='PIC Project')
            order by main.created_at desc
            ");
            return view('asasmen.history_asasmen', compact('employee'));
       }
       else if ($user->sub_divisi == 'Supervisor' && $user->name == 'Dwi Purwanto' || $user->name == 'Dwi Purwanto Ops' )
       {
           $employee= DB::connection('mysql')->select("
           select DISTINCT
           main.created_at,
           main.Tr_Review_EmpPeriod_Code_h,
           main.Ms_emp_code,
           main.Ms_Emp_Div,
           main.ms_periode,
           hasil.Ms_Reviewer_Code
           from Tr_Review_EmpPeriod_h main
           left join users user on main.rec_usercreated = user.name
           left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
           left join Tr_Review_EmpPeriod_Basic_Reviewer hasil on main.Tr_Review_EmpPeriod_Code_h = hasil.Tr_Review_EmpPeriod_Code_h
           where main.rec_status  ='1'
            and ( main.Ms_Emp_Div ='Gudang' or main.Ms_Emp_Div ='Dispatcher'	or main.Ms_Emp_Div ='Petrolman' or main.Ms_Emp_Div ='Checker Plant'	or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Senior Mekanik' or main.Ms_Emp_Div ='Staff Senior Petrolman' or main.Ms_Emp_Div ='Junior Mekanik'	 or main.Ms_Emp_Div ='Mechanic' or main.Ms_Emp_Div ='Data Entry' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Spv Transport' or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='PIC Project')
            order by main.created_at desc
            ");
            return view('asasmen.history_asasmen', compact('employee'));
       }
       
       else if ($user->sub_divisi == 'Supervisor' && $user->name == 'Erwin Noor Stanza' || $user->name == 'Umar Abdul Aziz')
       {
           $employee= DB::connection('mysql')->select("
           select DISTINCT
           main.created_at,
           main.Tr_Review_EmpPeriod_Code_h,
           main.Ms_emp_code,
           main.Ms_Emp_Div,
           main.ms_periode,
           hasil.Ms_Reviewer_Code
           from Tr_Review_EmpPeriod_h main
           left join users user on main.rec_usercreated = user.name
           left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
           left join Tr_Review_EmpPeriod_Basic_Reviewer hasil on main.Tr_Review_EmpPeriod_Code_h = hasil.Tr_Review_EmpPeriod_Code_h
           where main.rec_status  ='1'
            and ( main.Ms_Emp_Div ='Staff Finance' or main.Ms_Emp_Div ='Finance'	or main.Ms_Emp_Div ='Cashier')
            order by main.created_at desc
            ");
            return view('asasmen.history_asasmen', compact('employee'));
       }
       else if ($user->sub_divisi == 'Supervisor')
       {
           $employee= DB::connection('mysql')->select("
           select DISTINCT
              main.created_at,
              main.Tr_Review_EmpPeriod_Code_h,
              main.Ms_emp_code,
              main.Ms_Emp_Div,
              main.ms_periode,
              hasil.Ms_Reviewer_Code
              from Tr_Review_EmpPeriod_h main
              left join users user on main.rec_usercreated = user.name
              left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
              left join Tr_Review_EmpPeriod_Basic_Reviewer hasil on main.Tr_Review_EmpPeriod_Code_h = hasil.Tr_Review_EmpPeriod_Code_h
              where main.rec_status  ='1'
            and main.Ms_Emp_Div ='$user->ms_divisi'
            order by main.created_at desc
            ");
            return view('asasmen.history_asasmen', compact('employee'));
       }

    }

    // public function history_basic(Request $request)
    // {
    //     $user = auth()->user();
    //     if ($user && in_array($user->sub_divisi, ['Manager Finance', 'Manager Operasional', 'General Manager', 'BOD', 'HR']))
    //     {
    //       $employee= DB::connection('mysql')->select("
    //         select
    //         main.created_at,
    //         main.id_period_emp_assesor as Tr_Emp_Asses_Code,
    //         main.Ms_emp_code,
    //         main.Ms_Emp_Div,
    //         asesor.Ms_Emp_Assessor_Code,
    //         asesor.Ms_type_asses,
    //         asesor.Ms_record_asses,
    //         asesor.id_emp_accessor
    //         from tr_period_emp_assesor_main main
    //         left join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
    //         where main.rec_status  ='1'
    //         order by main.created_at desc
    //         ");
    //         return view('asasmen.history_asasmen', compact('employee'));
    //     }
    //   else if ($user->sub_divisi == 'Supervisor' && ( $user->name == 'ifanuella Reinaldo' || $user->name == 'Fernando' || $user->name == 'Haryadih'))
    //   {
    //         $employee= DB::connection('mysql')->select("
    //         select
    //         main.created_at,
    //         main.id_period_emp_assesor as Tr_Emp_Asses_Code,
    //         main.Ms_emp_code,
    //         main.Ms_Emp_Div,
    //         asesor.Ms_Emp_Assessor_Code,
    //         asesor.Ms_type_asses,
    //         asesor.Ms_record_asses,
    //         asesor.id_emp_accessor
    //         from tr_period_emp_assesor_main main
    //         left join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
    //         where main.rec_status  ='1'
    //         and ( main.Ms_Emp_Div ='Dispatcher'	or main.Ms_Emp_Div ='Petrolman' or main.Ms_Emp_Div ='Checker Plant'	or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Senior Mekanik' or main.Ms_Emp_Div ='Staff Senior Petrolman' or main.Ms_Emp_Div ='Junior Mekanik'	 or main.Ms_Emp_Div ='Mechanic' or main.Ms_Emp_Div ='Data Entry' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Spv Transport' or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='PIC Project')
    //         order by main.created_at desc
    //         ");
    //         return view('asasmen.history_asasmen', compact('employee'));
    //   }
    //   else if ($user->sub_divisi == 'Supervisor' && $user->name == 'Dwi Purwanto' )
    //   {
    //       $employee= DB::connection('mysql')->select("
    //         select
    //         main.created_at,
    //         main.id_period_emp_assesor as Tr_Emp_Asses_Code,
    //         main.Ms_emp_code,
    //         main.Ms_Emp_Div,
    //         asesor.Ms_Emp_Assessor_Code,
    //         asesor.Ms_type_asses,
    //         asesor.Ms_record_asses,
    //         asesor.id_emp_accessor
    //         from tr_period_emp_assesor_main main
    //         left join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
    //         where main.rec_status  ='1'
    //         and ( main.Ms_Emp_Div ='Gudang' or main.Ms_Emp_Div ='Dispatcher'	or main.Ms_Emp_Div ='Petrolman' or main.Ms_Emp_Div ='Checker Plant'	or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Senior Mekanik' or main.Ms_Emp_Div ='Staff Senior Petrolman' or main.Ms_Emp_Div ='Junior Mekanik'	 or main.Ms_Emp_Div ='Mechanic' or main.Ms_Emp_Div ='Data Entry' or main.Ms_Emp_Div ='Service Officer' or main.Ms_Emp_Div ='Spv Transport' or main.Ms_Emp_Div ='Operasional' or main.Ms_Emp_Div ='PIC Project')
    //         order by main.created_at desc
    //         ");
    //         return view('asasmen.history_asasmen', compact('employee'));
    //   }
    //   else if ($user->sub_divisi == 'Supervisor')
    //   {
    //       $employee= DB::connection('mysql')->select("
    //         select
    //         main.created_at,
    //         main.id_period_emp_assesor as Tr_Emp_Asses_Code,
    //         main.Ms_emp_code,
    //         main.Ms_Emp_Div,
    //         asesor.Ms_Emp_Assessor_Code,
    //         asesor.Ms_type_asses,
    //         asesor.Ms_record_asses,
    //         asesor.id_emp_accessor
    //         from tr_period_emp_assesor_main main
    //         left join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
    //         where main.rec_status  ='1'
    //         and main.Ms_Emp_Div ='$user->ms_divisi'
    //         order by main.created_at desc
    //         ");
    //         return view('asasmen.history_asasmen', compact('employee'));
    //   }

    // }

    public function print_basic(Request $request, $id)
    {
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      emp_assesor.id_emp_accessor,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.Trust_value,
      hasil.trust_comment,
      hasil.drive_value,
      hasil.drive_comment,
      hasil.inisiative_value,
      hasil.inisiatif_comment,
      hasil.Reliable_value,
      hasil.reliable_comment,
      hasil.reslut,
      hasil.result_comment
      from tr_emp_assesment main
      left join users user on main.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_basic_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id'
       ");
    //   dd($details);
      $id_emp_asses = "";
      foreach($details as $row){
        $id_emp_asses = (string)$row->id_emp_accessor;
      }

       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");

      foreach($details as $row2)
          {
            $pelaku = $row2->emp_name;
          }
          $baResult = DB::connection('mysql')->select("
                SELECT
                User_Code,
                COUNT(Tr_BA_Code) AS total_ba
                FROM tr_ba_main
                WHERE rec_status = '1'
                AND User_Code = ?
                GROUP BY User_Code
            ", [$pelaku]);

            // Memeriksa apakah ada hasil dari query
            if (count($baResult) > 0) {
                $totalBa = $baResult[0]->total_ba;
            } else {
                // Jika tidak ada hasil, atur total_ba menjadi 0
                $totalBa = 0;
            }
        return view ('asasmen.print_asasmen', compact('details', 'notes', 'totalBa'));
    }

// public function savedata_basic (Request $request)
// {

//     $user = auth()->user();
//     $newdatetime = Carbon::now();
//     $tahunSaatIni = $newdatetime->year;

//     $main_ases = new Tr_Review_EmpPeriod_h();
//     $main_ases->Tr_Review_EmpPeriod_Code_h    = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode;
//     $main_ases->rec_usercreated               = $request->Ms_Emp_Assessor_Code;
//     $main_ases->rec_userupdate                = '';
//     $main_ases->rec_datecreated               = $newdatetime;
//     $main_ases->rec_status                    = '1';
//     $main_ases->Date_Asses                    = $newdatetime;
//     $main_ases->Ms_Periode                    = $request->ms_periode;
//     $main_ases->Year_Desc                     = $tahunSaatIni;
//     $main_ases->Period                        = $tahunSaatIni.$request->ms_periode;
//     $main_ases->Ms_Emp_Code                   = $request->Ms_Emp_Code;
//     $main_ases->Ms_Emp_Div                    = $request->Ms_Emp_Div;
//     // dd($main_ases);
//     $main_ases->save();


//     $rating = new tr_review_empperiod_basic_reviewer();
//     $rating->Tr_Review_EmpPeriod_Basic_Reviewer_Code = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode. '-'.'BASIC'.'-'. Auth::User()->name;
//     $rating->DateReviewBasic                         = $newdatetime;
//     $rating->Tr_Review_EmpPeriod_Code_h              = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode;
//     $rating->Ms_Reviewer_Code        = Auth::User()->name;
//     $rating->Trust_value             = $request->trust_value;
//     $rating->trust_comment           = $request->trust_comment;
//     $rating->trust_suggestion        = $request->trust_suggestion;
//     $rating->TrustHigh               = $request->TrustHigh;
//     $rating->TrustLow                = $request->TrustLow;
//     $rating->drive_value             = $request->drive_value;
//     $rating->drive_comment           = $request->drive_comment;
//     $rating->drive_suggestion        = $request->drive_suggestion;
//     $rating->DriveHigh               = $request->DriveHigh;
//     $rating->DriveLow                = $request->DriveLow;
//     $rating->inisiative_value        = $request->initiative_value;
//     $rating->inisiatif_comment       = $request->inisiatif_comment;
//     $rating->inisiative_suggestion   = $request->inisiative_suggestion;
//     $rating->InisiativeHigh          = $request->InisiativeHigh;
//     $rating->InisitativeLow          = $request->InisitativeLow;
//     $rating->Reliable_value          = $request->reliable_value;
//     $rating->reliable_comment        = $request->reliable_comment;
//     $rating->Reliable_suggestion     = $request->Reliable_suggestion;
//     $rating->ReliableHigh            = $request->ReliableHigh;
//     $rating->ReliableLow             = $request->ReliableLow;
//     $rating->result                  = $request->result;
//     $rating->result_comment          = $request->result_comment;
//     $rating->result_suggestion       = $request->result_suggestion;
//     $rating->ResultHigh              = $request->ResultHighs;
//     $rating->ResultLow               = $request->ResultLows;
//     // dd($rating);
//     $rating->save();

//      $timestamp = Carbon::now()->timestamp;

//     foreach ($request['TaskDesc'] as $key => $item_id) {
//       // Menggunakan loop untuk memastikan keunikan setiap entri
//       do {
//           // Menambahkan nilai acak
//           $randomValue = mt_rand(100, 999);
//           // Menggabungkan timestamp, nilai acak, dan nama pengguna
//           $autoNumber = 'TASK' . '-' . Auth::user()->name . $timestamp . $randomValue;
//           // Memastikan bahwa nomor otomatis tersebut belum ada dalam database
//           $isUnique = !DB::table('Tr_Review_EmpPeriod_Task_Reviewer')
//               ->where('Tr_Review_EmpPeriod_Task_Reviewer_Code', $autoNumber)
//               ->exists();
//       }
//       while (!$isUnique);
//               $tugasnya = new tr_review_empperiod_task_reviewer();
//               $tugasnya->Tr_Review_EmpPeriod_Task_Reviewer_Code  = $autoNumber;
//               $tugasnya->Tr_Review_EmpPeriod_Code_h              = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode;
//               $tugasnya->TaskDesc                                = $request['TaskDesc'][$key];
//               $tugasnya->DateTask                                = $request['DateTask'][$key];
//               $tugasnya->Ms_Reviewer_Code                        = Auth::User()->name;
//               $tugasnya->Ms_Task_Status                          = $request['Ms_Task_Status'][$key];
//               $tugasnya->ResultDesc                              = $request['ResultDesc'][$key];
//               $tugasnya->ResultHigh                              = $request['ResultHigh'][$key];
//               $tugasnya->ResultLow                               = $request['ResultLow'][$key];
//               $tugasnya->Quality                                 = $request['Quality'][$key];
//               $tugasnya->Solutif                                 = $request['Solutif'][$key];
//               $tugasnya->Inisiatif                               = $request['Inisiatif'][$key];
//               $tugasnya->Tuntas                                  = $request['Tuntas'][$key];
//               $tugasnya->Kualitas                                = 0;
//               $tugasnya->Kecepatan                               = $request['Kecepatan'][$key];
//               $tugasnya->Update                                  = $request['Update'][$key];
//               $tugasnya->Hasil                                   = $request['Hasil'][$key];
//               $tugasnya->Konsisten                               = $request['Konsisten'][$key];
//               $tugasnya->Tanggap                                 = $request['Tanggap'][$key];
//               if( Auth::User()->ms_divisi ='BOD')
//               {
//                 $tugasnya->Suggest_BOD                             = $request['SugestReviewer'][$key];
//               }
//               else if ( Auth::User()->ms_divisi ='General Manager' || Auth::User()->ms_divisi ='Manager Operasional' || Auth::User()->ms_divisi ='Manager Finance')
//               {
//                 $tugasnya->SuggestMgt                             = $request['SugestReviewer'][$key];
//               }
//               else
//               {
//                 $tugasnya->SugestReviewer                          = $request['SugestReviewer'][$key];
//               }
//               // dd($tugasnya);
//               $tugasnya->save();
//           }


//     Session::flash('warning', 'Assessment Success!.');
//       return view('asasmen.sukses');

//     }

public function savedata_basic (Request $request)
{

    $user = auth()->user();
    $newdatetime = Carbon::now();
    $tahunSaatIni = $newdatetime->year;

    $main_ases = new Tr_Review_EmpPeriod_h();
    $main_ases->Tr_Review_EmpPeriod_Code_h    = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode;
    $main_ases->rec_usercreated               = $request->Ms_Emp_Assessor_Code;
    $main_ases->rec_userupdate                = '';
    $main_ases->rec_datecreated               = $newdatetime;
    $main_ases->rec_status                    = '1';
    $main_ases->Date_Asses                    = $newdatetime;
    $main_ases->Ms_Periode                    = $request->ms_periode;
    $main_ases->Year_Desc                     = $tahunSaatIni;
    $main_ases->Period                        = $tahunSaatIni.$request->ms_periode;
    $main_ases->Ms_Emp_Code                   = $request->Ms_Emp_Code;
    $main_ases->Ms_Emp_Div                    = $request->Ms_Emp_Div;
    $main_ases->save();


    $rating = new tr_review_empperiod_basic_reviewer();
    $rating->Tr_Review_EmpPeriod_Basic_Reviewer_Code = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode. '-'.'BASIC'.'-'. Auth::User()->name;
    $rating->DateReviewBasic                         = $newdatetime;
    $rating->Tr_Review_EmpPeriod_Code_h              = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode;
    $rating->Ms_Reviewer_Code        = Auth::User()->name;
    $rating->Trust_value             = $request->trust_value;
    $rating->trust_comment           = $request->trust_comment;
    $rating->trust_suggestion        = $request->trust_suggestion;
    $rating->TrustHigh               = $request->TrustHigh;
    $rating->TrustLow                = $request->TrustLow;
    $rating->drive_value             = $request->drive_value;
    $rating->drive_comment           = $request->drive_comment;
    $rating->drive_suggestion        = $request->drive_suggestion;
    $rating->DriveHigh               = $request->DriveHigh;
    $rating->DriveLow                = $request->DriveLow;
    $rating->inisiative_value        = $request->initiative_value;
    $rating->inisiatif_comment       = $request->inisiatif_comment;
    $rating->inisiative_suggestion   = $request->inisiative_suggestion;
    $rating->InisiativeHigh          = $request->InisiativeHigh;
    $rating->InisitativeLow          = $request->InisitativeLow;
    $rating->Reliable_value          = $request->reliable_value;
    $rating->reliable_comment        = $request->reliable_comment;
    $rating->Reliable_suggestion     = $request->Reliable_suggestion;
    $rating->ReliableHigh            = $request->ReliableHigh;
    $rating->ReliableLow             = $request->ReliableLow;
    $rating->result                  = $request->result;
    $rating->result_comment          = $request->result_comment;
    $rating->result_suggestion       = $request->result_suggestion;
    $rating->ResultHigh              = $request->ResultHighs;
    $rating->ResultLow               = $request->ResultLows;
    $rating->save();
    $timestamp = Carbon::now()->timestamp;

    //jika $request['TaskDesc'] tidak di isi
    if (empty($request['TaskDesc']))
    {
      // Tidak ada proses jika TaskDesc kosong
    }
    //jika $request['TaskDesc'] di isi
    else
    {
      foreach ($request['TaskDesc'] as $key => $item_id) {
        do {
            $randomValue = mt_rand(100, 999);
            $autoNumber = 'TASK' . '-' . Auth::user()->name . $timestamp . $randomValue;
            $isUnique = !DB::table('Tr_Review_EmpPeriod_Task_Reviewer')
                ->where('Tr_Review_EmpPeriod_Task_Reviewer_Code', $autoNumber)
                ->exists();
        }
        while (!$isUnique);
                $tugasnya = new tr_review_empperiod_task_reviewer();
                $tugasnya->Tr_Review_EmpPeriod_Task_Reviewer_Code  = $autoNumber;
                $tugasnya->Tr_Review_EmpPeriod_Code_h              = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode;
                $tugasnya->TaskDesc                                = $request['TaskDesc'][$key];
                $tugasnya->DateTask                                = $request['DateTask'][$key];
                $tugasnya->Ms_Reviewer_Code                        = Auth::User()->name;
                $tugasnya->Ms_Task_Status                          = $request['Ms_Task_Status'][$key];
                $tugasnya->ResultDesc                              = $request['ResultDesc'][$key];
                $tugasnya->ResultHigh                              = $request['ResultHigh'][$key];
                $tugasnya->ResultLow                               = $request['ResultLow'][$key];
                $tugasnya->Quality                                 = $request['Quality'][$key];
                $tugasnya->Solutif                                 = $request['Solutif'][$key];
                $tugasnya->Inisiatif                               = $request['Inisiatif'][$key];
                $tugasnya->Tuntas                                  = $request['Tuntas'][$key];
                $tugasnya->Kualitas                                = 0;
                $tugasnya->Kecepatan                               = $request['Kecepatan'][$key];
                $tugasnya->Update                                  = $request['Update'][$key];
                $tugasnya->Hasil                                   = $request['Hasil'][$key];
                $tugasnya->Konsisten                               = $request['Konsisten'][$key];
                $tugasnya->Tanggap                                 = $request['Tanggap'][$key];
                if( Auth::User()->ms_divisi ='BOD')
                {
                  $tugasnya->Suggest_BOD                             = $request['SugestReviewer'][$key];
                }
                else if ( Auth::User()->ms_divisi ='General Manager' || Auth::User()->ms_divisi ='Manager Operasional' || Auth::User()->ms_divisi ='Manager Finance')
                {
                  $tugasnya->SuggestMgt                             = $request['SugestReviewer'][$key];
                }
                else
                {
                  $tugasnya->SugestReviewer                          = $request['SugestReviewer'][$key];
                }
                // dd($tugasnya);
                $tugasnya->save();
            }
    }

          $code_h = Tr_Review_EmpPeriod_h::where('Tr_Review_EmpPeriod_Code_h', '=', $request->Ms_Emp_Code . '-' . $tahunSaatIni . $request->ms_periode)->first();
          $code_d = tr_review_empperiod_basic_reviewer::where('Tr_Review_EmpPeriod_Code_h', '=', $request->Ms_Emp_Code . '-' . $tahunSaatIni . $request->ms_periode)->get();
          $trust_value = $code_d->first() ? $code_d->first()->Trust_value : 'N/A';
          $drive_v = $code_d->first() ? $code_d->first()->drive_value : 'N/A';
          $insisiative_v = $code_d->first() ? $code_d->first()->inisiative_value : 'N/A';
          $reliable_v = $code_d->first() ? $code_d->first()->Reliable_value : 'N/A';
          $result_v = $code_d->first() ? $code_d->first()->result : 'N/A';
          $tugas = tr_review_empperiod_task_reviewer::where('Tr_Review_EmpPeriod_Code_h', '=', $request->Ms_Emp_Code . '-' . $tahunSaatIni . $request->ms_periode)->get();
          $datetime = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s');
          $documentFileName = $tahunSaatIni . $request->ms_periode . ".pdf";
          // dd($tugas);
          // Create the mPDF document
          $document = new MPDF([
              'mode' => 'utf-8',
              'format' => 'A4',
              'margin_header' => '2',
              'margin_top' => '20',
              'margin_bottom' => '20',
              'margin_footer' => '2',
          ]);

         // Menyusun tabel tugas

          // Prepare HTML content with data
          $htmlContent = '
          <style>
          <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
              .special-table {
                  width: 100%;
                  border-collapse: collapse;
              }
              .special-table th, .special-table td {
                  border: 1px solid black;
                  padding: 8px;
                  text-align: center;
              }
              body {
                font-size: 10px; /* Ukuran default */
            }
            h3 {
                font-size: 14px; /* Ukuran heading */
            }
            h5 {
                font-size: 12px; /* Ukuran sub-heading */
            }
            table {
                font-size: 9px; /* Ukuran tabel */
            }
            .small-text {
                font-size: 8px;
            }
          </style>

          <div class="logo-container">
              <img width="90" height="50" src="' . url('/upload/logohgs.jpg') . '" alt="Logo">
          </div>
          <h3 style="text-align: center;">Asessment</h3>
          <hr/>
          <br>
          <table style="width: 100%;">
              <thead></thead>
              <tbody>
                  <tr>
                      <td>Code</td><td>: ' . $code_h->Tr_Review_EmpPeriod_Code_h . '</td>
                      <td>Employee</td><td>: ' . $code_h->Ms_Emp_Code . '</td>
                  </tr>
                  <tr>
                      <td>Date Input</td><td>: ' . date_format(date_create($code_h->DateOrder), "d/m/Y") . '</td>
                      <td>Employee Div.</td><td>: ' . $code_h->Ms_Emp_Div . '</td>
                  </tr>
                  <tr>
                      <td>Asessment Period</td><td>: ' . $code_h->Ms_Periode . '</td>
                      <td>Assessor / Reviewer</td><td>: ' . $code_h->rec_usercreated . '</td>
                  </tr>
              </tbody>
          </table>
          <br>

          <h5> /Trust Value : '.$trust_value.'</h5>
          <table border="1" style="width:100%; border-collapse: collapse;">
              <thead>
                  <tr>
                      <th>Trust</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>';
      $htmlContent .= '
          <tr>
              <td style="text-align: left;">Komentar</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'trust_comment')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Saran</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'trust_suggestion')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Plus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'TrustHigh')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Minus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'TrustLow')) . '</td>
          </tr>';

      $htmlContent .= '
          </tbody>
        </table>
        <h5> /Drive Value : '.$drive_v.'</h5>
          <table border="1" style="width:100%; border-collapse: collapse;">
              <thead>
                  <tr>
                      <th>Drive</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>';

      $htmlContent .= '
          <tr>
              <td style="text-align: left;">Komentar</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'drive_comment')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Saran</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'drive_suggestion')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Plus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'DriveHigh')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Minus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'DriveLow')) . '</td>
          </tr>';

      $htmlContent .= '
          </tbody>
        </table>
        <h5> /Inisiatif Value : '.$insisiative_v.'</h5>
        <table border="1" style="width:100%; border-collapse: collapse;">
              <thead>
                  <tr>
                      <th>Inisiatif</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>';

      $htmlContent .= '
          <tr>
              <td style="text-align: left;">Komentar</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'inisiatif_comment')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Saran</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'inisiative_suggestion')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Plus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'InisiativeHigh')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Minus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'InisitativeLow')) . '</td>
          </tr>';

      $htmlContent .= '
          </tbody>
        </table>
        <h5> /Reliable Value : '.$reliable_v.'</h5>
        <table border="1" style="width:100%; border-collapse: collapse;">
              <thead>
                  <tr>
                      <th>Reliable</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>';

      $htmlContent .= '
          <tr>
              <td style="text-align: left;">Komentar</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'reliable_comment')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Saran</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'Reliable_suggestion')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Plus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'ReliableHigh')) . '</td>
          </tr>
          <tr>
              <td style="text-align: left;">Penilaian Minus</td>
              <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'ReliableLow')) . '</td>
          </tr>';

      $htmlContent .= '
          </tbody>
        </table>
        <h5> /Result Value : '.$result_v.'</h5>
        <table border="1" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Result</th>
                <th></th>
            </tr>
        </thead>
        <tbody>';

        $htmlContent .= '
            <tr>
                <td style="text-align: left;">Komentar</td>
                <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'result_comment')) . '</td>
            </tr>
            <tr>
                <td style="text-align: left;">Saran</td>
                <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'result_suggestion')) . '</td>
            </tr>
            <tr>
                <td style="text-align: left;">Penilaian Plus</td>
                <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'ResultHigh')) . '</td>
            </tr>
            <tr>
                <td style="text-align: left;">Penilaian Minus</td>
                <td style="text-align: center;">' . implode('</td></tr><tr><td></td><td style="text-align: center;">', array_column($code_d->toArray(), 'ResultLow')) . '</td>
            </tr>';

        $htmlContent .= '
            </tbody>
          </table>
          <h5> /Tugas :</h5>
          <table border="1" style="width:100%; border-collapse: collapse;">
              <thead>
                  <tr>
                      <th>No.</th>
                      <th>Tugas</th>
                      <th>Status</th>
                      <th>Quality</th>
                      <th>Solutif</th>
                      <th>Inisiatif</th>
                      <th>Tuntas</th>
                      <th>Kecepatan</th>
                      <th>Update</th>
                      <th>Hasil</th>
                      <th>Konsisten</th>
                      <th>Tanggap</th>
                  </tr>
              </thead>
              <tbody>';

          $no = 1; // Inisialisasi nomor urut
          foreach ($tugas as $row) {
              $htmlContent .= '
              <tr>
                  <td>' . $no++ . '</td>
                  <td>' . $row->TaskDesc . '</td>
                  <td>' . $row->Ms_Task_Status . '</td>
                  <td>' . $row->Quality . '</td>
                  <td>' . $row->Solutif . '</td>
                  <td>' . $row->Inisiatif . '</td>
                  <td>' . $row->Tuntas . '</td>
                  <td>' . $row->Kecepatan . '</td>
                  <td>' . $row->Update . '</td>
                  <td>' . $row->Hasil . '</td>
                  <td>' . $row->Konsisten . '</td>
                  <td>' . $row->Tanggap . '</td>
              </tr>';
          }

          $htmlContent .= '
              </tbody>
          </table>';

        '<div class="card-body">
              <br><br>
              <table>
                  <tr>
                      <td><p><b>Print Date : <span>' . $datetime . '</span></b></p></td>
                  </tr>
              </table>
          </div>';

          // Write HTML content to the PDF
          $document->WriteHTML($htmlContent);
          // Save the generated PDF to disk
          Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
          // Return the generated PDF for download
          $header = [
              'Content-Type' => 'application/pdf',
              'Content-Disposition' => 'inline; filename="' . $documentFileName . '"',
          ];
          return Storage::disk('public')->download($documentFileName, 'Request', $header);

    }

public function savedata_basic_hrd (Request $request)
{

  $code_asas= $request->Tr_Emp_Asses_Code;
  $newdatetime = Carbon::now()->toDateTimeString();
  $emp_accessor = DB::connection('mysql')->select("
  SELECT
  id_emp_accessor
  FROM tr_emp_assesor
  order by id_emp_accessor desc
  LIMIT 1
  ");
  $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
  foreach($emp_accessor as $row)
  {
    $maxid = $row->id_emp_accessor;
    $sort_num = (int) substr($maxid,-4,4);
    $sort_num++;
    $new_code = sprintf("%04s", $sort_num);
    $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
  }

  $asessor = new tr_emp_assesor();
  $asessor->id_emp_accessor       = $id_emp_accessor;
  $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
  $asessor->rec_userupdate        = '';
  $asessor->rec_datecreated       = $newdatetime;
  $asessor->rec_status            = '1';
  $asessor->Tr_Emp_Asses_Code     = $code_asas;
  $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
  $asessor->Ms_record_asses       = $request->Ms_record_asses;
  $asessor->Ms_type_asses         = $request->Ms_type_asses;
  $asessor->Date_Asses            = $newdatetime;
  $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
  $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
  $asessor->save();

  tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
  ->update([
      'Ms_type_asses'   => $request->Ms_type_asses,
      'Ms_record_asses' => $request->Ms_record_asses,
      'rec_dateupdate'  => $newdatetime,
      'rec_userupdate'  => $request->Ms_Emp_Assessor_Code
  ]);

  $emp_assesor= DB::connection('mysql')->select("
  select
  id_emp_accessor
  from tr_emp_assesor
  where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
   ");

   $id_assesor = "";
   foreach($emp_assesor as $row)
   {
     $id_assesor = $row->id_emp_accessor;
   }
   $basic_result = DB::connection('mysql')->select("
   SELECT
   id_bsc_rst
   FROM tr_emp_asses_basic_result
   order by id_bsc_rst desc
   LIMIT 1
   ");
   $id_bsc_rst =  'BSCRST'.'-'. date('Ydm').'-0001';
   foreach($basic_result as $row)
   {
     $maxid = $row->id_bsc_rst;
     $sort_num = (int) substr($maxid,-4,4);
     $sort_num++;
     $new_code = sprintf("%04s", $sort_num);
     $id_bsc_rst='BSCRST'.'-'. date('Ydm').'-'. $new_code;
   }
  $rating = new tr_emp_asses_basic_result();
  $rating->id_bsc_rst              = $id_bsc_rst;
  $rating->Tr_Emp_Asses_Code       = $code_asas;
  $rating->Ms_Emp_Assessor_Code    = $id_assesor;
  $rating->Trust_value             = $request->trust_value;
  $rating->trust_comment           = $request->trust_comment;
  $rating->drive_value             = $request->drive_value;
  $rating->drive_comment           = $request->drive_comment;
  $rating->inisiative_value        = $request->inisiative_value;
  $rating->inisiatif_comment       = $request->inisiatif_comment;
  $rating->Reliable_value          = $request->Reliable_value;
  $rating->reliable_comment        = $request->reliable_comment;
  $rating->reslut                  = $request->result;
  $rating->result_comment          = $request->result_comment;
  $rating->save();

  if(isset($request->note)) {
    for($i=0 ; $i < count($request->note); $i++){
      $advance_result = DB::connection('mysql')->select("
      SELECT
      id_accessor_nt
      FROM tr_emp_asses_note
      order by id_accessor_nt desc
      LIMIT 1
      ");
      $id_accessor_nt = 'ADVRST'.'-'. date('Ydm').'-0001';
      foreach($advance_result as $row)
      {
        $maxid = $row->id_accessor_nt;
        $sort_num = (int) substr($maxid,-4,4);
        $sort_num++;
        $new_code = sprintf("%04s", $sort_num);
        $id_accessor_nt='ADVRST'.'-'. date('Ydm').'-'. $new_code;
      }
      $noteS = new tr_emp_asses_note();
      $noteS->id_accessor_nt          = $id_accessor_nt;
      $noteS->Tr_Emp_Asses_Code       = $code_asas;
      //$noteS->id_emp_asses            = $id_emp_asses;
      $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
      $noteS->note                    = $request->note[$i];
      $noteS->status                  = $request->status[$i];
      $noteS->save();
    }
  }

  return Redirect::to('print_asasmen_hrd/'.$code_asas.'/'.$request->Tr_Emp_Asses_Code_spv);

}

public function savedata_basic_spv (Request $request)
{

  $code_asas= $request->Tr_Emp_Asses_Code;
  $newdatetime = Carbon::now()->toDateTimeString();
  /*$main_ases = new tr_emp_assesment();
  $main_ases->rec_usercreated    = $request->Ms_Emp_Assessor_Code;
  $main_ases->rec_userupdate     = '';
  $main_ases->rec_datecreated    = $newdatetime;
  $main_ases->rec_status         = '1';
  $main_ases->Date_Asses         = $newdatetime;
  $main_ases->Tr_Emp_Asses_Code  = $code_asas;
  $main_ases->Ms_Emp_Code        = $request->Ms_Emp_Code;
  $main_ases->Ms_Emp_Div         = $request->Ms_Emp_Div;
  $main_ases->Ms_type_asses      = $request->Ms_type_asses;
  $main_ases->Ms_record_asses    = $request->Ms_record_asses;
  $main_ases->save();*/
  $emp_accessor = DB::connection('mysql')->select("
  SELECT
  id_emp_accessor
  FROM tr_emp_assesor
  order by id_emp_accessor desc
  LIMIT 1
  ");
  $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
  foreach($emp_accessor as $row)
  {
    $maxid = $row->id_emp_accessor;
    $sort_num = (int) substr($maxid,-4,4);
    $sort_num++;
    $new_code = sprintf("%04s", $sort_num);
    $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
  }

  $asessor = new tr_emp_assesor();
  $asessor->id_emp_accessor       = $id_emp_accessor;
  $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
  $asessor->rec_userupdate        = '';
  $asessor->rec_datecreated       = $newdatetime;
  $asessor->rec_status            = '1';
  $asessor->Tr_Emp_Asses_Code     = $code_asas;
  $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
  $asessor->Ms_record_asses       = $request->Ms_record_asses;
  $asessor->Ms_type_asses         = $request->Ms_type_asses;
  $asessor->Date_Asses            = $newdatetime;
  $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
  $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
  $asessor->save();

  tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
  ->update([
      'Ms_type_asses'   => $request->Ms_type_asses,
      'Ms_record_asses' => $request->Ms_record_asses,
      'rec_dateupdate'  => $newdatetime,
      'rec_userupdate'  => $request->Ms_Emp_Assessor_Code
  ]);

  $emp_assesor= DB::connection('mysql')->select("
  select
  id_emp_accessor
  from tr_emp_assesor
  where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
   ");

   $id_assesor = "";
   foreach($emp_assesor as $row)
   {
     $id_assesor = $row->id_emp_accessor;
   }
   $basic_result = DB::connection('mysql')->select("
   SELECT
   id_bsc_rst
   FROM tr_emp_asses_basic_result
   order by id_bsc_rst desc
   LIMIT 1
   ");
   $id_bsc_rst =  'BSCRST'.'-'. date('Ydm').'-0001';
   foreach($basic_result as $row)
   {
     $maxid = $row->id_bsc_rst;
     $sort_num = (int) substr($maxid,-4,4);
     $sort_num++;
     $new_code = sprintf("%04s", $sort_num);
     $id_bsc_rst='BSCRST'.'-'. date('Ydm').'-'. $new_code;
   }
  $rating = new tr_emp_asses_basic_result();
  $rating->id_bsc_rst              = $id_bsc_rst;
  $rating->Tr_Emp_Asses_Code       = $code_asas;
  $rating->Ms_Emp_Assessor_Code    = $id_assesor;
  $rating->Trust_value             = $request->trust_value;
  $rating->trust_comment           = $request->trust_comment;
  $rating->drive_value             = $request->drive_value;
  $rating->drive_comment           = $request->drive_comment;
  $rating->inisiative_value        = $request->inisiative_value;
  $rating->inisiatif_comment       = $request->inisiatif_comment;
  $rating->Reliable_value          = $request->Reliable_value;
  $rating->reliable_comment        = $request->reliable_comment;
  $rating->reslut                  = $request->result;
  $rating->result_comment          = $request->result_comment;
  $rating->save();

  if(isset($request->note)) {
    for($i=0 ; $i < count($request->note); $i++){
      $advance_result = DB::connection('mysql')->select("
      SELECT
      id_accessor_nt
      FROM tr_emp_asses_note
      order by id_accessor_nt desc
      LIMIT 1
      ");
      $id_accessor_nt = 'ADVRST'.'-'. date('Ydm').'-0001';
      foreach($advance_result as $row)
      {
        $maxid = $row->id_accessor_nt;
        $sort_num = (int) substr($maxid,-4,4);
        $sort_num++;
        $new_code = sprintf("%04s", $sort_num);
        $id_accessor_nt='ADVRST'.'-'. date('Ydm').'-'. $new_code;
      }
      $noteS = new tr_emp_asses_note();
      $noteS->id_accessor_nt          = $id_accessor_nt;
      $noteS->Tr_Emp_Asses_Code       = $code_asas;
      //$noteS->id_emp_asses            = $id_emp_asses;
      $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
      $noteS->note                    = $request->note[$i];
      $noteS->status                  = $request->status[$i];
      $noteS->save();
    }
  }

  return Redirect::to('print_asasmen_spv/'.$request->Tr_Emp_Asses_Code_spv.'/'.$code_asas);

}


public function print_basic_hrd(Request $request, $id ,$idspv)
{

  $details= DB::connection('mysql')->select("
  select
  main.id,
  main.rec_usercreated,
  main.created_at,
  main.Tr_Emp_Asses_Code,
  main.Ms_emp_code,
  main.Ms_Emp_Div,
  main.Ms_type_asses,
  main.Ms_record_asses,
  asesor.id_emp_accessor,
  asesor.Ms_Emp_Assessor_Code,
  emp.emp_name,
  user.name,
  user.ms_divisi,
  hasil.Trust_value,
  hasil.trust_comment,
  hasil.drive_value,
  hasil.drive_comment,
  hasil.inisiative_value,
  hasil.inisiatif_comment,
  hasil.Reliable_value,
  hasil.reliable_comment,
  hasil.reslut,
  hasil.result_comment
  from tr_emp_assesment main
  left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
  left join users user on main.rec_usercreated = user.name
  left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
  left join tr_emp_asses_basic_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
  where main.Tr_Emp_Asses_Code ='$id' and
  asesor.Ms_record_asses ='HRD'
   ");
   $id_emp_asses = "";
   foreach($details as $row){
     $id_emp_asses = (string)$row->id_emp_accessor;
   }
   $notes= DB::connection('mysql')->select("
   select
    note
   from tr_emp_asses_note
   where Ms_Emp_Assessor_Code ='$id_emp_asses'
    ");
  // dd($id);die;
  $details_spv= DB::connection('mysql')->select("
  select
  main.id,
  main.created_at,
  main.Tr_Emp_Asses_Code,
  main.Ms_emp_code,
  main.Ms_Emp_Div,
  main.Ms_type_asses,
  main.Ms_record_asses,
  asesor.id_emp_accessor as id_emp_accessor,
  asesor.Ms_Emp_Assessor_Code,
  emp.emp_name,
  user.name,
  user.ms_divisi,
  hasil.Trust_value,
  hasil.trust_comment,
  hasil.drive_value,
  hasil.drive_comment,
  hasil.inisiative_value,
  hasil.inisiatif_comment,
  hasil.Reliable_value,
  hasil.reliable_comment,
  hasil.reslut,
  hasil.result_comment
  from tr_emp_assesment main
  left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
  left join users user on main.rec_usercreated = user.name
  left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
  left join tr_emp_asses_basic_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
  where main.Tr_Emp_Asses_Code ='$idspv' and
  asesor.Ms_record_asses ='Supervisor'
   ");
   $id_emp_asses = "";
   foreach($details_spv as $row){
     $id_emp_asses = (string)$row->id_emp_accessor;
   }
   $notes_spv= DB::connection('mysql')->select("
   select
    note
   from tr_emp_asses_note
   where Ms_Emp_Assessor_Code ='$id_emp_asses'
    ");
  return view ('asasmen.print_asasmen_hrd', compact('details', 'notes', 'details_spv', 'notes_spv' ));
}

public function print_basic_spv(Request $request, $id ,$idspv)
{


  // dd($id);die;
  $details= DB::connection('mysql')->select("
  select
  main.id,
  main.rec_usercreated,
  main.created_at,
  main.Tr_Emp_Asses_Code,
  main.Ms_emp_code,
  main.Ms_Emp_Div,
  main.Ms_type_asses,
  main.Ms_record_asses,
  asesor.id_emp_accessor as id_emp_accessor,
  asesor.Ms_Emp_Assessor_Code,
  emp.emp_name,
  user.name,
  user.ms_divisi,
  hasil.Trust_value,
  hasil.trust_comment,
  hasil.drive_value,
  hasil.drive_comment,
  hasil.inisiative_value,
  hasil.inisiatif_comment,
  hasil.Reliable_value,
  hasil.reliable_comment,
  hasil.reslut,
  hasil.result_comment
  from tr_emp_assesment main
  left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
  left join users user on main.rec_usercreated = user.name
  left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
  left join tr_emp_asses_basic_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
  where main.Tr_Emp_Asses_Code ='$id' and
  asesor.Ms_record_asses ='HRD'
   ");
   $id_emp_asses = "";
   foreach($details as $row){
     $id_emp_asses = (string)$row->id_emp_accessor;
   }
   $notes= DB::connection('mysql')->select("
   select
    note
   from tr_emp_asses_note
   where 	Ms_Emp_Assessor_Code ='$id_emp_asses'
    ");
  // dd($id);die;
  $details_spv= DB::connection('mysql')->select("
  select
  main.id,
  main.rec_usercreated,
  main.created_at,
  main.Tr_Emp_Asses_Code,
  main.Ms_emp_code,
  main.Ms_Emp_Div,
  main.Ms_type_asses,
  main.Ms_record_asses,
  asesor.id_emp_accessor as id_emp_accessor,
  asesor.Ms_Emp_Assessor_Code,
  emp.emp_name,
  user.name,
  user.ms_divisi,
  hasil.Trust_value,
  hasil.trust_comment,
  hasil.drive_value,
  hasil.drive_comment,
  hasil.inisiative_value,
  hasil.inisiatif_comment,
  hasil.Reliable_value,
  hasil.reliable_comment,
  hasil.reslut,
  hasil.result_comment
  from tr_emp_assesment main
  left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
  left join users user on main.rec_usercreated = user.name
  left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
  left join tr_emp_asses_basic_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
  where main.Tr_Emp_Asses_Code ='$idspv' and
  asesor.Ms_record_asses ='Supervisor'
   ");
   $id_emp_asses = "";
   foreach($details_spv as $row){
     $id_emp_asses = (string)$row->id_emp_accessor;
   }
   $notes_spv= DB::connection('mysql')->select("
   select
   note
   from tr_emp_asses_note
   where 	Ms_Emp_Assessor_Code ='$id_emp_asses'
    ");
  return view ('asasmen.print_asasmen_spv', compact('details', 'notes', 'details_spv', 'notes_spv' ));
}


public function asasmen_leaderships (Request $request) {
  $user = auth()->user();

  // $employee = MasterEmployee::all();
  $ms_divisi = MsDivisi::all();
  $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

   $ms_rating_basic= DB::connection('mysql')->select("
   select * from ms_rating_asasmen_basic where rec_status ='1'
   ");

  $last_id2 = DB::connection('mysql')->select("
  SELECT
  id
  FROM tr_emp_assesment
  order by created_at desc
  LIMIT 1
  ");

  $twoChars = substr($user->username, 0, 3);

  foreach($last_id2 as $asas2)
  { $idnya2 = $asas2->id+1;}
  $ambilkode2=tr_emp_assesment::where($request->Tr_Emp_Asses_Code )->get();
  $nambah2=count($ambilkode2)+1;
  if ($nambah2 <10000)
  {
    $code_asas='ASSMN'.'-'. date('Ydm').'-'."00".$idnya2;
  }

  return view ('asasmen.asasmen_leaderships', compact('user', 'operators', 'ms_divisi','ms_rating_basic', 'code_asas'));

}

public function asasmen_leaderships_seve (Request $request) {

  $asses_advance = new tr_emp_asses_advance_result();

  $asses_advance->Ms_Emp_Assessor_Code       = $request->Tr_Emp_Asses_Code;
  $asses_advance->mengarahkan_value          = $request->mengarahkan_value;
  $asses_advance->mengarahkan_comment        = $request->mengarahkan_comment;
  $asses_advance->problem_solving_value      = $request->problem_solving_value;
  $asses_advance->problem_solving_comment    = $request->problem_solving_comment;
  $asses_advance->planning_value             = $request->planning_value;
  $asses_advance->planning_comment           = $request->planning_comment;
  $asses_advance->analisa_value              = $request->analisa_value;
  $asses_advance->analisa_comment            = $request->analisa_comment;
  $asses_advance->kualitas_komunikasi_value  = $request->kualitas_komunikasi_value;
  $asses_advance->kualitas_komunikasi_comment= $request->kualitas_komunikasi_comment;
  $asses_advance->save();

  if(isset($request->dynamic_input)) {
    for($i=0 ; $i < count($request->dynamic_input); $i++){
      $advance_result = DB::connection('mysql')->select("
      SELECT
      id_accessor_nt
      FROM tr_emp_asses_note
      order by id_accessor_nt desc
      LIMIT 1
      ");
      $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
      foreach($advance_result as $row)
      {
        $maxid = $row->id_accessor_nt;
        $sort_num = (int) substr($maxid,-4,4);
        $sort_num++;
        $new_code = sprintf("%04s", $sort_num);
        $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
      }
      $noteS = new tr_emp_asses_note();
      $noteS->id_accessor_nt          = $id_accessor_nt;
      $noteS->Tr_Emp_Asses_Code       = $request->Tr_Emp_Asses_Code;
      $noteS->Ms_Emp_Assessor_Code    = $request->Ms_Emp_Assessor_Code;
      $noteS->note                    = $request->dynamic_input[$i];
      $noteS->save();
    }
  }

  return Redirect::to('asasmen_leaderships_print/'.$request->Tr_Emp_Asses_Code);

}

public function asasmen_leaderships_print (Request $request, $id) {

  $details= DB::connection('mysql')->select("
  select
  created_at,
  Ms_Emp_Assessor_Code,
  mengarahkan_value,
  mengarahkan_comment,
  problem_solving_value,
  problem_solving_comment,
  planning_value,
  planning_comment,
  analisa_value,
  analisa_comment,
  kualitas_komunikasi_value,
  kualitas_komunikasi_comment
  from tr_emp_asses_advance_result
  where Ms_Emp_Assessor_Code ='$id'
  order by emp_assesor.created_at desc
  LIMIT 1
   ");

   $notes= DB::connection('mysql')->select("
   select
   note
   from tr_emp_asses_note
   where Tr_Emp_Asses_Code ='$id'
    ");

  return view ('asasmen.asasmen_leaderships_print', compact('details', 'notes'));

}
/*
public function asasmen_basics_edit($id)
{

  $tr_emp_assesment= DB::connection('mysql')->select("
  select
  emp_assesment.rec_usercreated,
  emp_assesment.rec_datecreated,
  emp_assesment.rec_status,
  emp_assesment.Date_Asses,
  emp_assesment.Tr_Emp_Asses_Code,
  emp_assesment.Ms_Emp_Code,
  emp_assesment.Ms_Emp_Div,
  emp_assesment.Ms_type_asses,
  emp_assesment.Ms_record_asses,
  asses_basic_result.Ms_Emp_Assessor_Code,
  asses_basic_result.Trust_value,
  asses_basic_result.trust_comment,
  asses_basic_result.drive_value,
  asses_basic_result.drive_comment,
  asses_basic_result.inisiative_value,
  asses_basic_result.inisiatif_comment,
  asses_basic_result.Reliable_value,
  asses_basic_result.reliable_comment,
  asses_basic_result.reslut,
  asses_basic_result.result_comment
  from tr_emp_assesment emp_assesment
  left join tr_emp_asses_basic_result asses_basic_result on emp_assesment.Tr_Emp_Asses_Code = asses_basic_result.Tr_Emp_Asses_Code
  where emp_assesment.Ms_Emp_Code ='$id'
  ");

   $tr_emp_assesor= DB::connection('mysql')->select("
   select
   rec_usercreated,
   rec_userupdate,
   rec_datecreated,
   rec_status,
   Tr_Emp_Asses_Code,
   Ms_Emp_Assessor_Code,
   Date_Asses,
   Ms_emp_code,
   Ms_Emp_Div
   from tr_emp_assesor

   where Ms_emp_code ='$id'
    ");

    $data_Tr_Emp_Asses_Code = "";
    $data_Tr_Emp_Asses_Code_hrd = "";
     foreach($tr_emp_assesor as $row){
      $data_Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
     }

      $data_Ms_record_asses = "";
      $data_Tr_Emp_Asses_Code = "";
      foreach($tr_emp_assesment as $row){
        if($row->Ms_record_asses == "HRD"){
          $data_Ms_record_asses = "HRD";
          $data_Tr_Emp_Asses_Code_hrd = $row->Tr_Emp_Asses_Code;
        }else{
          $data_Tr_Emp_Asses_Code  = $row->Tr_Emp_Asses_Code;
        };

       $data_Tr_Emp_Asses_Code =  $row->Tr_Emp_Asses_Code;

      }

      $tr_emp_asses_note= DB::connection('mysql')->select("
      select
      Tr_Emp_Asses_Code,
      Ms_Emp_Assessor_Code,
      note

      from tr_emp_asses_note

      where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code'
      ");

      $tr_emp_asses_note_hrd= DB::connection('mysql')->select("
      select
      Tr_Emp_Asses_Code,
      Ms_Emp_Assessor_Code,
      note

      from tr_emp_asses_note

      where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code_hrd'
      ");

      $max_emp_code = DB::connection('mysql')->select("
      SELECT
      Tr_Emp_Asses_Code
      FROM tr_emp_assesment
      order by id desc
      LIMIT 1
      ");

      foreach($max_emp_code as $row)
      {
        $kalimat = $row->Tr_Emp_Asses_Code;
        $sort_num = (int) substr($kalimat,-4,4);
        $sort_num++;
        $new_code = sprintf("%04s", $sort_num);
        $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;

      }

      $user = auth()->user();
      $ms_divisi = MsDivisi::all();
      $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

      return view ('asasmen.assasmen_besic_edit', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd'));

    }*/



    public function asasmen_basics_edit_spv($id)
    {

      $tr_emp_assesment= DB::connection('mysql')->select("
      select
      emp_assesment.id,
      emp_assesment.rec_usercreated,
      emp_assesment.rec_datecreated,
      emp_assesment.rec_status,
      emp_assesment.Date_Asses,
      emp_assesment.Tr_Emp_Asses_Code,
      emp_assesment.Ms_Emp_Code,
      emp_assesment.Ms_Emp_Div,
      emp_assesment.Ms_type_asses,
      emp_assesment.Ms_record_asses,
      emp.emp_name,
      emp_assesor.id_emp_accessor,
      user.name,
      user.ms_divisi,
      asses_basic_result.Ms_Emp_Assessor_Code,
      asses_basic_result.Trust_value,
      asses_basic_result.trust_comment,
      asses_basic_result.drive_value,
      asses_basic_result.drive_comment,
      asses_basic_result.inisiative_value,
      asses_basic_result.inisiatif_comment,
      asses_basic_result.Reliable_value,
      asses_basic_result.reliable_comment,
      asses_basic_result.reslut,
      asses_basic_result.result_comment
      from tr_emp_assesment emp_assesment
      left join users user on emp_assesment.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on emp_assesment.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on emp_assesment.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_basic_result asses_basic_result on emp_assesor.id_emp_accessor = asses_basic_result.Ms_Emp_Assessor_Code
      where emp_assesment.Ms_Emp_Code ='$id'
      ");

       $tr_emp_assesor= DB::connection('mysql')->select("
       select
       rec_usercreated,
       rec_userupdate,
       rec_datecreated,
       rec_status,
       Tr_Emp_Asses_Code,
       Ms_Emp_Assessor_Code,
       Date_Asses,
       Ms_emp_code,
       Ms_Emp_Div
       from tr_emp_assesor

       where Ms_emp_code ='$id'
        ");

        $data_Tr_Emp_Asses_Code = "";
        $data_Tr_Emp_Asses_Code_hrd = "";
         foreach($tr_emp_assesor as $row){
          $data_Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
         }

          $data_Ms_record_asses = "";
          $data_Tr_Emp_Asses_Code = "";
          foreach($tr_emp_assesment as $row){
            if($row->Ms_record_asses == "HRD"){
              $data_Ms_record_asses = "HRD";
              $data_Tr_Emp_Asses_Code_hrd = $row->Tr_Emp_Asses_Code;
            }else{
              $data_Tr_Emp_Asses_Code  = $row->Tr_Emp_Asses_Code;
            };

           $data_Tr_Emp_Asses_Code =  $row->Tr_Emp_Asses_Code;

          }
          $id_emp_asses = "";
          foreach($tr_emp_assesment as $row)
          {
            $id_emp_asses = $row->id_emp_accessor;
          }
          $tr_emp_asses_note= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note

          from tr_emp_asses_note

          where Ms_Emp_Assessor_Code = '$id_emp_asses'
          ");

          $tr_emp_asses_note_hrd= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note

          from tr_emp_asses_note

          where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code_hrd'
          ");

          $max_emp_code = DB::connection('mysql')->select("
          SELECT
          Tr_Emp_Asses_Code
          FROM tr_emp_assesment
          order by id desc
          LIMIT 1
          ");

          foreach($max_emp_code as $row)
          {
            $kalimat = $row->Tr_Emp_Asses_Code;
            $sort_num = (int) substr($kalimat,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;

          }

          $user = auth()->user();
          $ms_divisi = MsDivisi::all();
          $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

          if( $data_Ms_record_asses == "HRD"){
            return view ('asasmen.assasmen_besic_edit_spv', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }
          else{
            return view ('asasmen.assasmen_besic_edit_spv', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }

        }


    public function asasmen_basics_edit_hrd($id)
    {

      $tr_emp_assesment= DB::connection('mysql')->select("
      select
      emp_assesment.id,
      emp_assesment.rec_usercreated,
      emp_assesment.rec_datecreated,
      emp_assesment.rec_status,
      emp_assesment.Date_Asses,
      emp_assesment.Tr_Emp_Asses_Code,
      emp_assesment.Ms_Emp_Code,
      emp_assesment.Ms_Emp_Div,
      emp_assesment.Ms_type_asses,
      emp_assesment.Ms_record_asses,
      emp_assesment.rec_userupdate,
      emp.emp_name,
      emp_assesor.id_emp_accessor,
      user.name,
      user.ms_divisi,
      asses_basic_result.Ms_Emp_Assessor_Code,
      asses_basic_result.Trust_value,
      asses_basic_result.trust_comment,
      asses_basic_result.drive_value,
      asses_basic_result.drive_comment,
      asses_basic_result.inisiative_value,
      asses_basic_result.inisiatif_comment,
      asses_basic_result.Reliable_value,
      asses_basic_result.reliable_comment,
      asses_basic_result.reslut,
      asses_basic_result.result_comment
      from tr_emp_assesment emp_assesment
      left join users user on emp_assesment.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on emp_assesment.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on emp_assesment.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_basic_result asses_basic_result on emp_assesor.id_emp_accessor = asses_basic_result.Ms_Emp_Assessor_Code
      where emp_assesment.Ms_Emp_Code ='$id'
      ");

       $tr_emp_assesor= DB::connection('mysql')->select("
       select
       rec_usercreated,
       rec_userupdate,
       rec_datecreated,
       rec_status,
       Tr_Emp_Asses_Code,
       Ms_Emp_Assessor_Code,
       Date_Asses,
       Ms_emp_code,
       Ms_Emp_Div
       from tr_emp_assesor

       where Ms_emp_code ='$id'
        ");

        $data_Tr_Emp_Asses_Code = "";
        $data_Tr_Emp_Asses_Code_hrd = "";
         foreach($tr_emp_assesor as $row){
          $data_Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
         }

          $data_Ms_record_asses = "";
          $data_Tr_Emp_Asses_Code = "";
          foreach($tr_emp_assesment as $row){
            if($row->Ms_record_asses == "HRD"){
              $data_Ms_record_asses = "HRD";
              $data_Tr_Emp_Asses_Code_hrd = $row->Tr_Emp_Asses_Code;
            }else{
              $data_Tr_Emp_Asses_Code  = $row->Tr_Emp_Asses_Code;
            };

           $data_Tr_Emp_Asses_Code =  $row->Tr_Emp_Asses_Code;

          }


          $id_emp_asses = "";
          foreach($tr_emp_assesment as $row)
          {
            $id_emp_asses = $row->id_emp_accessor;
          }
          $tr_emp_asses_note= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note

          from tr_emp_asses_note

          where Ms_Emp_Assessor_Code = '$id_emp_asses'
          ");

          $tr_emp_asses_note_hrd= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note

          from tr_emp_asses_note

          where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code_hrd'
          ");

          $max_emp_code = DB::connection('mysql')->select("
          SELECT
          Tr_Emp_Asses_Code
          FROM tr_emp_assesment
          order by id desc
          LIMIT 1
          ");

          foreach($max_emp_code as $row)
          {
            $kalimat = $row->Tr_Emp_Asses_Code;
            $sort_num = (int) substr($kalimat,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;

          }

          $user = auth()->user();
          $ms_divisi = MsDivisi::all();
          $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

          foreach($tr_emp_assesment as $row2)
          {
            $pelaku = $row2->emp_name;
          }
          $baResult = DB::connection('mysql')->select("
                SELECT
                User_Code,
                COUNT(Tr_BA_Code) AS total_ba
                FROM tr_ba_main
                WHERE rec_status = '1'
                AND User_Code = ?
                GROUP BY User_Code
            ", [$pelaku]);

            // Memeriksa apakah ada hasil dari query
            if (count($baResult) > 0) {
                $totalBa = $baResult[0]->total_ba;
            } else {
                // Jika tidak ada hasil, atur total_ba menjadi 0
                $totalBa = 0;
            }
          if( $data_Ms_record_asses == "HRD"){
            return view ('asasmen.assasmen_besic_edit_hrd', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators', 'totalBa'));
          }
          else{
            return view ('asasmen.assasmen_besic_edit_hrd', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators', 'totalBa'));
          }

    }

public function asasmen_basics_update(Request $request)
{

  tr_emp_assesment::where('Tr_Emp_Asses_Code', $request->Tr_Emp_Asses_Code)
      ->update([
          'rec_usercreated' => $request->Ms_Emp_Assessor_Code,
          'Ms_Emp_Code'        => $request->Ms_Emp_Code,
          'Ms_Emp_Div'         => $request->Ms_Emp_Div,
          'Ms_type_asses'      => $request->Ms_type_asses,
          'Ms_record_asses'    => $request->Ms_record_asses,

      ]);

  tr_emp_asses_basic_result::where('Tr_Emp_Asses_Code', $request->Tr_Emp_Asses_Code)
      ->update([
          'Tr_Emp_Asses_Code'       => $request->Tr_Emp_Asses_Code,
          'Ms_Emp_Assessor_Code'    => $request->Ms_Emp_Assessor_Code,
          'Trust_value'             => $request->trust_value,
          'trust_comment'           => $request->trust_comment,
          'drive_value'             => $request->drive_value,
          'drive_comment'           => $request->drive_comment,
          'inisiative_value'        => $request->inisiative_value,
          'inisiatif_comment'       => $request->inisiatif_comment,
          'Reliable_value'          => $request->Reliable_value,
          'reliable_comment'        => $request->reliable_comment,
          'reslut'                  => $request->result,
          'result_comment'          => $request->result_comment,
          'updated_at'              => Carbon::now()->toDateTimeString(),
      ]);

  if(isset($request->dynamic_input)) {


    $emp_asses = DB::connection('mysql')->select("
    select
    id
    from tr_emp_asses_note
    where Tr_Emp_Asses_Code ='".$request->Tr_Emp_Asses_Code."'
     ");
    $i = 0;
    foreach($emp_asses as $row){
      tr_emp_asses_note::where('id', $row->id)
      ->update([
          'note'       => $request->dynamic_input[$i],
      ]);
      $i++;
    }

  }

  return Redirect::to('asasmen/all_staff');

}



















//Leadership
public function leaderships_staf(Request $request)
    {
      // $employee = MasterEmployee::all();

      $employee= DB::connection('mysql')->select("
      select
      id_emp as id,
      emp_name,
      emp_subdivision,
      emp_kotalahir,
      emp_datejoin
      from master_employees
       ");
       $checked= DB::connection('mysql')->select("
       select
       id,
       Ms_Emp_Code,
       Ms_type_asses,
       Ms_record_asses
       from tr_emp_assesment
        where Ms_type_asses = 'Leadership 1' OR Ms_type_asses = 'Leadership 2'
        ");
      return view('leadership.all_staff', compact('employee', 'checked'));
    }

    public function create_ld_asasmen(Request $request, $id)
    {

      $user = auth()->user();
      $employee = MasterEmployee::all();
      $operators = MasterEmployee::where('emp_id', '=', $id)->first();
      $ms_divisi = MsDivisi::all();

       $ms_rating_basic= DB::connection('mysql')->select("
       select * from ms_rating_asasmen_basic where rec_status ='1'
       ");

      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      order by created_at desc
      LIMIT 1
      ");
      $code_asas='ASSMN'.'-'. date('Ydm').'-0001';
      $max_emp_code = DB::connection('mysql')->select("
      SELECT
      Tr_Emp_Asses_Code
      FROM tr_emp_assesment
      order by id desc
      LIMIT 1
      ");

      foreach($max_emp_code as $row)
      {
        $kalimat = $row->Tr_Emp_Asses_Code;
        $sort_num = (int) substr($kalimat,-4,4);
        $sort_num++;
        $new_code = sprintf("%04s", $sort_num);
        $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;
      }

      $last_id4 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      where Ms_Emp_Code  ='".$id."'
      ");

      if(count($last_id4 ) == 1 ){
        return view('leadership.asasmen_create_leadership', compact('user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));

      }
      else{
        return view('leadership.asasmen_create_leadership', compact('user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));
      };

    }

    public function save_leadership (Request $request)
    {
      $code_asas='ASSMN'.'-'. date('Ydm').'-0001';
      $max_emp_code = DB::connection('mysql')->select("
      SELECT
      Tr_Emp_Asses_Code
      FROM tr_emp_assesment
      order by id desc
      LIMIT 1
      ");

      foreach($max_emp_code as $row)
      {
        $kalimat = $row->Tr_Emp_Asses_Code;
        $sort_num = (int) substr($kalimat,-4,4);
        $sort_num++;
        $new_code = sprintf("%04s", $sort_num);
        $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;
      }

      $newdatetime = Carbon::now()->toDateTimeString();

      $main_ases = new tr_emp_assesment();
      $main_ases->rec_usercreated    = $request->Ms_Emp_Assessor_Code;
      $main_ases->rec_userupdate     = '';
      $main_ases->rec_datecreated    = $newdatetime;
      $main_ases->rec_status         = '1';
      $main_ases->Date_Asses         = $newdatetime;
      $main_ases->Tr_Emp_Asses_Code  = $code_asas;
      $main_ases->Ms_Emp_Code        = $request->Ms_Emp_Code;
      $main_ases->Ms_Emp_Div         = $request->Ms_Emp_Div;
      $main_ases->Ms_type_asses      = $request->Ms_type_asses;
      $main_ases->Ms_record_asses    = $request->Ms_record_asses;
      $main_ases->save();


      $emp_asses = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      WHERE Tr_Emp_Asses_Code = '$code_asas' and Date_Asses = '$newdatetime'
      LIMIT 1
      ");

      $id_emp_asses = "";
      foreach($emp_asses as $row)
      {
        $id_emp_asses = $row->id;
      }
      $emp_accessor = DB::connection('mysql')->select("
        SELECT
        id_emp_accessor
        FROM tr_emp_assesor
        order by id_emp_accessor desc
        LIMIT 1
      ");
        $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
      foreach($emp_accessor as $row)
      {
          $maxid = $row->id_emp_accessor;
          $sort_num = (int) substr($maxid,-4,4);
          $sort_num++;
          $new_code = sprintf("%04s", $sort_num);
          $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
      }
      $asessor = new tr_emp_assesor();
      $asessor->id_emp_accessor       = $id_emp_accessor;
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = $newdatetime;
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $code_asas;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_record_asses       = $request->Ms_record_asses;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = $newdatetime;
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      $emp_assesor= DB::connection('mysql')->select("
      select
      id_emp_accessor
      from tr_emp_assesor
      where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
       ");

       $id_assesor = "";
       foreach($emp_assesor as $row)
       {
         $id_assesor = $row->id_emp_accessor;
       }
       $advance_result = DB::connection('mysql')->select("
       SELECT
       id_adv_rst
       FROM tr_emp_asses_advance_result
       order by id_adv_rst desc
       LIMIT 1
       ");
       $id_adv_rst =  'ADVRST'.'-'. date('Ydm').'-0001';
       foreach($advance_result as $row)
       {
         $maxid = $row->id_adv_rst;
         $sort_num = (int) substr($maxid,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $id_adv_rst='ADVRST'.'-'. date('Ydm').'-'. $new_code;
       }
      $rating = new tr_emp_asses_advance_result();
      $rating->id_adv_rst                 = $id_adv_rst;
      $rating->Tr_Emp_Asses_Code          = $code_asas;
      $rating->Ms_Emp_Assessor_Code       = $id_assesor;
      $rating->mengarahkan_value          = $request->mengarahkan_value;
      $rating->mengarahkan_comment        = $request->mengarahkan_comment;
      $rating->problem_solving_value      = $request->problem_solving_value;
      $rating->problem_solving_comment    = $request->problem_solving_comment;
      $rating->planning_value             = $request->planning_value;
      $rating->planning_comment           = $request->planning_comment;
      $rating->analisa_value              = $request->analisa_value;
      $rating->analisa_comment            = $request->analisa_comment;
      $rating->kualitas_komunikasi_value  = $request->kualitas_komunikasi_value;
      $rating->kualitas_komunikasi_comment= $request->kualitas_komunikasi_comment;
      $rating->save();

      if(isset($request->dynamic_input)) {
        for($i=0 ; $i < count($request->dynamic_input); $i++){
          $advance_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($advance_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          $noteS = new tr_emp_asses_note();
          $noteS->id_accessor_nt          = $id_accessor_nt;
          $noteS->Tr_Emp_Asses_Code       = $code_asas;
         // $noteS->id_emp_asses            = $id_emp_asses;
          $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
          $noteS->note                    = $request->dynamic_input[$i];
          $noteS->save();
        }
      }

      return Redirect::to('print_leadership/'.$code_asas);

    }

    public function print_leadership(Request $request, $id)
    {
      // dd($id);die;
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      emp_assesor.id_emp_accessor,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment main
      left join users user on main.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
       ");
      $id_emp_asses = "";
      foreach($details as $row){
        $id_emp_asses = (string)$row->id_emp_accessor;
      }

       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");

      return view ('leadership.print_leadership', compact('details', 'notes'));
    }

    public function asasmen_leadership_edit_hrd($id)
    {

      $tr_emp_assesment= DB::connection('mysql')->select("
      select
      emp_assesment.id,
      emp_assesment.rec_usercreated,
      emp_assesment.rec_datecreated,
      emp_assesment.rec_status,
      emp_assesment.Date_Asses,
      emp_assesment.Tr_Emp_Asses_Code,
      emp_assesment.Ms_Emp_Code,
      emp_assesment.Ms_Emp_Div,
      emp_assesment.Ms_type_asses,
      emp_assesment.Ms_record_asses,
      emp_assesment.rec_userupdate,
      emp.emp_name,
      emp_assesor.id_emp_accessor,
      user.name,
      user.ms_divisi,
      hasil.Ms_Emp_Assessor_Code,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment emp_assesment
      left join users user on emp_assesment.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on emp_assesment.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on emp_assesment.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where emp_assesment.Ms_Emp_Code ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
      ");

       $tr_emp_assesor= DB::connection('mysql')->select("
       select
       rec_usercreated,
       rec_userupdate,
       rec_datecreated,
       rec_status,
       Tr_Emp_Asses_Code,
       Ms_Emp_Assessor_Code,
       Date_Asses,
       Ms_emp_code,
       Ms_Emp_Div
       from tr_emp_assesor
       where Ms_emp_code ='$id'
        ");

        $data_Tr_Emp_Asses_Code = "";
        $data_Tr_Emp_Asses_Code_hrd = "";
         foreach($tr_emp_assesor as $row){
          $data_Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
         }

          $data_Ms_record_asses = "";
          $data_Tr_Emp_Asses_Code = "";
          foreach($tr_emp_assesment as $row){
            if($row->Ms_record_asses == "HRD"){
              $data_Ms_record_asses = "HRD";
              $data_Tr_Emp_Asses_Code_hrd = $row->Tr_Emp_Asses_Code;
            }else{
              $data_Tr_Emp_Asses_Code  = $row->Tr_Emp_Asses_Code;
            };

           $data_Tr_Emp_Asses_Code =  $row->Tr_Emp_Asses_Code;

          }


          $id_emp_asses = "";
          foreach($tr_emp_assesment as $row)
          {
            $id_emp_asses = $row->id_emp_accessor;
          }
          $tr_emp_asses_note= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note
          from tr_emp_asses_note
          where Ms_Emp_Assessor_Code = '$id_emp_asses'
          ");

          $tr_emp_asses_note_hrd= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note
          from tr_emp_asses_note
          where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code_hrd'
          ");

          $max_emp_code = DB::connection('mysql')->select("
          SELECT
          Tr_Emp_Asses_Code
          FROM tr_emp_assesment
          order by id desc
          LIMIT 1
          ");

          foreach($max_emp_code as $row)
          {
            $kalimat = $row->Tr_Emp_Asses_Code;
            $sort_num = (int) substr($kalimat,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;

          }

          $user = auth()->user();
          $ms_divisi = MsDivisi::all();
          $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

          if( $data_Ms_record_asses == "HRD"){
            return view ('leadership.asasmen_leadership_edit_hrd', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }
          else{
            return view ('leadership.asasmen_leadership_edit_hrd', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }

    }

    public function save_leadership_hrd  (Request $request)
    {

      $code_asas= $request->Tr_Emp_Asses_Code;
      $newdatetime = Carbon::now()->toDateTimeString();
      /*$main_ases = new tr_emp_assesment();
      $main_ases->rec_usercreated    = $request->Ms_Emp_Assessor_Code;
      $main_ases->rec_userupdate     = '';
      $main_ases->rec_datecreated    = $newdatetime;
      $main_ases->rec_status         = '1';
      $main_ases->Date_Asses         = $newdatetime;
      $main_ases->Tr_Emp_Asses_Code  = $code_asas;
      $main_ases->Ms_Emp_Code        = $request->Ms_Emp_Code;
      $main_ases->Ms_Emp_Div         = $request->Ms_Emp_Div;
      $main_ases->Ms_type_asses      = $request->Ms_type_asses;
      $main_ases->Ms_record_asses    = $request->Ms_record_asses;
      $main_ases->save();*/
      $emp_accessor = DB::connection('mysql')->select("
        SELECT
        id_emp_accessor
        FROM tr_emp_assesor
        order by id_emp_accessor desc
        LIMIT 1
      ");
        $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
      foreach($emp_accessor as $row)
      {
          $maxid = $row->id_emp_accessor;
          $sort_num = (int) substr($maxid,-4,4);
          $sort_num++;
          $new_code = sprintf("%04s", $sort_num);
          $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
      }
      $asessor = new tr_emp_assesor();
      $asessor->id_emp_accessor       = $id_emp_accessor;
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = $newdatetime;
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $code_asas;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_record_asses       = $request->Ms_record_asses;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = $newdatetime;
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
      ->update([
          'Ms_type_asses'   => $request->Ms_type_asses,
          'Ms_record_asses' => $request->Ms_record_asses,
          'rec_dateupdate'  => $newdatetime,
          'rec_userupdate'  => $request->Ms_Emp_Assessor_Code,
      ]);

      $emp_assesor= DB::connection('mysql')->select("
      select
      id_emp_accessor
      from tr_emp_assesor
      where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
       ");

       $id_assesor = "";
       foreach($emp_assesor as $row)
       {
         $id_assesor = $row->id_emp_accessor;
       }
       $advance_result = DB::connection('mysql')->select("
       SELECT
       id_adv_rst
       FROM tr_emp_asses_advance_result
       order by id_adv_rst desc
       LIMIT 1
       ");
       $id_adv_rst =  'ADVRST'.'-'. date('Ydm').'-0001';
       foreach($advance_result as $row)
       {
         $maxid = $row->id_adv_rst;
         $sort_num = (int) substr($maxid,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $id_adv_rst='ADVRST'.'-'. date('Ydm').'-'. $new_code;
       }
      $rating = new tr_emp_asses_advance_result();
      $rating->id_adv_rst                 = $id_adv_rst;
      $rating->Tr_Emp_Asses_Code          = $code_asas;
      $rating->Ms_Emp_Assessor_Code       = $id_assesor;
      $rating->mengarahkan_value          = $request->mengarahkan_value;
      $rating->mengarahkan_comment        = $request->mengarahkan_comment;
      $rating->problem_solving_value      = $request->problem_solving_value;
      $rating->problem_solving_comment    = $request->problem_solving_comment;
      $rating->planning_value             = $request->planning_value;
      $rating->planning_comment           = $request->planning_comment;
      $rating->analisa_value              = $request->analisa_value;
      $rating->analisa_comment            = $request->analisa_comment;
      $rating->kualitas_komunikasi_value  = $request->kualitas_komunikasi_value;
      $rating->kualitas_komunikasi_comment= $request->kualitas_komunikasi_comment;
      $rating->save();

      if(isset($request->dynamic_input)) {
        for($i=0 ; $i < count($request->dynamic_input); $i++){
          $advance_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($advance_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          $noteS = new tr_emp_asses_note();
          $noteS->id_accessor_nt          = $id_accessor_nt;
          $noteS->Tr_Emp_Asses_Code       = $code_asas;
          //$noteS->id_emp_asses            = $id_emp_asses;
          $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
          $noteS->note                    = $request->dynamic_input[$i];
          $noteS->save();
        }
      }

      return Redirect::to('print_ld_asasmen_hrd/'.$code_asas.'/'.$request->Tr_Emp_Asses_Code_spv);

    }

    public function print_leadership_hrd(Request $request, $id ,$idspv)
    {

      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id' and
      asesor.Ms_record_asses ='HRD'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      // dd($id);die;
      $details_spv= DB::connection('mysql')->select("
      select
      main.id,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$idspv' and
      asesor.Ms_record_asses ='Supervisor'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details_spv as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes_spv= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      return view ('leadership.print_ld_asasmen_hrd', compact('details', 'notes', 'details_spv', 'notes_spv' ));
    }


    public function asasmen_leadership_edit_spv($id)
    {

      $tr_emp_assesment= DB::connection('mysql')->select("
      select
      emp_assesment.id,
      emp_assesment.rec_usercreated,
      emp_assesment.rec_datecreated,
      emp_assesment.rec_status,
      emp_assesment.Date_Asses,
      emp_assesment.Tr_Emp_Asses_Code,
      emp_assesment.Ms_Emp_Code,
      emp_assesment.Ms_Emp_Div,
      emp_assesment.Ms_type_asses,
      emp_assesment.Ms_record_asses,
      emp.emp_name,
      emp_assesor.id_emp_accessor,
      user.name,
      user.ms_divisi,
      hasil.Ms_Emp_Assessor_Code,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment emp_assesment
      left join users user on emp_assesment.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on emp_assesment.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on emp_assesment.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where emp_assesment.Ms_Emp_Code ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
      ");

       $tr_emp_assesor= DB::connection('mysql')->select("
       select
       rec_usercreated,
       rec_userupdate,
       rec_datecreated,
       rec_status,
       Tr_Emp_Asses_Code,
       Ms_Emp_Assessor_Code,
       Date_Asses,
       Ms_emp_code,
       Ms_Emp_Div
       from tr_emp_assesor
       where Ms_emp_code ='$id'
        ");

        $data_Tr_Emp_Asses_Code = "";
        $data_Tr_Emp_Asses_Code_hrd = "";
         foreach($tr_emp_assesor as $row){
          $data_Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
         }

          $data_Ms_record_asses = "";
          $data_Tr_Emp_Asses_Code = "";
          foreach($tr_emp_assesment as $row){
            if($row->Ms_record_asses == "HRD"){
              $data_Ms_record_asses = "HRD";
              $data_Tr_Emp_Asses_Code_hrd = $row->Tr_Emp_Asses_Code;
            }else{
              $data_Tr_Emp_Asses_Code  = $row->Tr_Emp_Asses_Code;
            };

           $data_Tr_Emp_Asses_Code =  $row->Tr_Emp_Asses_Code;

          }
          $id_emp_asses = "";
          foreach($tr_emp_assesment as $row)
          {
            $id_emp_asses = $row->id_emp_accessor;
          }
          $tr_emp_asses_note= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note
          from tr_emp_asses_note
          where Ms_Emp_Assessor_Code = '$id_emp_asses'
          ");

          $tr_emp_asses_note_hrd= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note
          from tr_emp_asses_note
          where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code_hrd'
          ");

          $max_emp_code = DB::connection('mysql')->select("
          SELECT
          Tr_Emp_Asses_Code
          FROM tr_emp_assesment
          order by id desc
          LIMIT 1
          ");

          foreach($max_emp_code as $row)
          {
            $kalimat = $row->Tr_Emp_Asses_Code;
            $sort_num = (int) substr($kalimat,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;

          }

          $user = auth()->user();
          $ms_divisi = MsDivisi::all();
          $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

          if( $data_Ms_record_asses == "HRD"){
            return view ('leadership.asasmen_leadership_edit_spv', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }
          else{
            return view ('leadership.asasmen_leadership_edit_spv', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }
    }
    public function save_leadership_spv (Request $request)
    {

      $code_asas= $request->Tr_Emp_Asses_Code;
      $newdatetime = Carbon::now()->toDateTimeString();
      /*$main_ases = new tr_emp_assesment();
      $main_ases->rec_usercreated    = $request->Ms_Emp_Assessor_Code;
      $main_ases->rec_userupdate     = '';
      $main_ases->rec_datecreated    = $newdatetime;
      $main_ases->rec_status         = '1';
      $main_ases->Date_Asses         = $newdatetime;
      $main_ases->Tr_Emp_Asses_Code  = $code_asas;
      $main_ases->Ms_Emp_Code        = $request->Ms_Emp_Code;
      $main_ases->Ms_Emp_Div         = $request->Ms_Emp_Div;
      $main_ases->Ms_type_asses      = $request->Ms_type_asses;
      $main_ases->Ms_record_asses    = $request->Ms_record_asses;
      $main_ases->save();*/
      $emp_accessor = DB::connection('mysql')->select("
        SELECT
        id_emp_accessor
        FROM tr_emp_assesor
        order by id_emp_accessor desc
        LIMIT 1
      ");
        $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
      foreach($emp_accessor as $row)
      {
          $maxid = $row->id_emp_accessor;
          $sort_num = (int) substr($maxid,-4,4);
          $sort_num++;
          $new_code = sprintf("%04s", $sort_num);
          $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
      }
      $asessor = new tr_emp_assesor();
      $asessor->id_emp_accessor       = $id_emp_accessor;
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = $newdatetime;
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $code_asas;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_record_asses       = $request->Ms_record_asses;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = $newdatetime;
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
      ->update([
          'Ms_type_asses'   => $request->Ms_type_asses,
          'Ms_record_asses' => $request->Ms_record_asses,
          'rec_dateupdate'  => $newdatetime,
          'rec_userupdate'  => $request->Ms_Emp_Assessor_Code,
      ]);

      $emp_assesor= DB::connection('mysql')->select("
      select
      id_emp_accessor
      from tr_emp_assesor
      where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
       ");

       $id_assesor = "";
       foreach($emp_assesor as $row)
       {
         $id_assesor = $row->id_emp_accessor;
       }
       $advance_result = DB::connection('mysql')->select("
       SELECT
       id_adv_rst
       FROM tr_emp_asses_advance_result
       order by id_adv_rst desc
       LIMIT 1
       ");
       $id_adv_rst =  'ADVRST'.'-'. date('Ydm').'-0001';
       foreach($advance_result as $row)
       {
         $maxid = $row->id_adv_rst;
         $sort_num = (int) substr($maxid,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $id_adv_rst='ADVRST'.'-'. date('Ydm').'-'. $new_code;
       }
      $rating = new tr_emp_asses_advance_result();
      $rating->id_adv_rst                 = $id_adv_rst;
      $rating->Tr_Emp_Asses_Code          = $code_asas;
      $rating->Ms_Emp_Assessor_Code       = $id_assesor;
      $rating->mengarahkan_value          = $request->mengarahkan_value;
      $rating->mengarahkan_comment        = $request->mengarahkan_comment;
      $rating->problem_solving_value      = $request->problem_solving_value;
      $rating->problem_solving_comment    = $request->problem_solving_comment;
      $rating->planning_value             = $request->planning_value;
      $rating->planning_comment           = $request->planning_comment;
      $rating->analisa_value              = $request->analisa_value;
      $rating->analisa_comment            = $request->analisa_comment;
      $rating->kualitas_komunikasi_value  = $request->kualitas_komunikasi_value;
      $rating->kualitas_komunikasi_comment= $request->kualitas_komunikasi_comment;
      $rating->save();

      if(isset($request->dynamic_input)) {
        for($i=0 ; $i < count($request->dynamic_input); $i++){
          $advance_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($advance_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          $noteS = new tr_emp_asses_note();
          $noteS->id_accessor_nt          = $id_accessor_nt;
          $noteS->Tr_Emp_Asses_Code       = $code_asas;
          //$noteS->id_emp_asses            = $id_emp_asses;
          $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
          $noteS->note                    = $request->dynamic_input[$i];
          $noteS->save();
        }
      }

      return Redirect::to('print_ld_asasmen_spv/'.$request->Tr_Emp_Asses_Code_spv.'/'.$code_asas);

    }

    public function print_leadership_spv(Request $request, $id ,$idspv)
    {


      // dd($id);die;
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id' and
      asesor.Ms_record_asses ='HRD'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes= DB::connection('mysql')->select("
       select
       note
       from tr_emp_asses_note
       where 	Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      // dd($id);die;
      $details_spv= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$idspv' and
      asesor.Ms_record_asses ='Supervisor'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details_spv as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes_spv= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where 	Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      return view ('leadership.print_ld_asasmen_spv', compact('details', 'notes', 'details_spv', 'notes_spv' ));
    }


    public function create_leadership_asas(Request $request, $id)
    {
      $user = auth()->user();
      $employee = MasterEmployee::all();
      $operators = MasterEmployee::where('emp_id', '=', $id)->first();
      $ms_divisi = MsDivisi::all();

       $ms_rating_basic= DB::connection('mysql')->select("
       select * from ms_rating_asasmen_basic where rec_status ='1'
       ");

      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      order by created_at desc
      LIMIT 1
      ");

      $data_asas_code = DB::connection('mysql')->select("
      SELECT
      Ms_Emp_Code,
      Tr_Emp_Asses_Code
      FROM tr_emp_assesment
      where Ms_Emp_Code  ='".$id."'
      order by id desc
      LIMIT 1
      ");

      $code_asas="";

      foreach($data_asas_code as $row)
      {
        $code_asas=$row->Tr_Emp_Asses_Code;
      }

      $last_id4 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      where Ms_Emp_Code  ='".$id."'
      ");

      if(count($last_id4 ) == 1 ){
        return view('leadership.asasmen_create_leadership', compact('user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));
      }
      else{
        return view('leadership.asasmen_create_leadership', compact('user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));
      };

    }

    public function save_leadership_asas (Request $request)
    {
      $code_asas=$request->Tr_Emp_Asses_Code;
      $newdatetime = Carbon::now()->toDateTimeString();
      $emp_accessor = DB::connection('mysql')->select("
        SELECT
        id_emp_accessor
        FROM tr_emp_assesor
        order by id_emp_accessor desc
        LIMIT 1
      ");
        $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
      foreach($emp_accessor as $row)
      {
          $maxid = $row->id_emp_accessor;
          $sort_num = (int) substr($maxid,-4,4);
          $sort_num++;
          $new_code = sprintf("%04s", $sort_num);
          $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
      }
      $asessor = new tr_emp_assesor();
      $asessor->id_emp_accessor       = $id_emp_accessor;
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = $newdatetime;
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $code_asas;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_record_asses       = $request->Ms_record_asses;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = $newdatetime;
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
      ->update([
          'Ms_type_asses'   => $request->Ms_type_asses,
          'Ms_record_asses' => $request->Ms_record_asses,
          'rec_dateupdate'  => $newdatetime,
          'rec_userupdate'  => $request->Ms_Emp_Assessor_Code,

      ]);

      $emp_assesor= DB::connection('mysql')->select("
      select
      id_emp_accessor
      from tr_emp_assesor
      where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
       ");

       $id_assesor = "";
       foreach($emp_assesor as $row)
       {
         $id_assesor = $row->id_emp_accessor;
       }
       $advance_result = DB::connection('mysql')->select("
       SELECT
       id_adv_rst
       FROM tr_emp_asses_advance_result
       order by id_adv_rst desc
       LIMIT 1
       ");
       $id_adv_rst = 'ADVRST'.'-'. date('Ydm').'-0001';
       foreach($advance_result as $row)
       {
         $maxid = $row->id_adv_rst;
         $sort_num = (int) substr($maxid,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $id_adv_rst='ADVRST'.'-'. date('Ydm').'-'. $new_code;
       }
      $rating = new tr_emp_asses_advance_result();
      $rating->id_adv_rst                 = $id_adv_rst;
      $rating->Tr_Emp_Asses_Code          = $code_asas;
      $rating->Ms_Emp_Assessor_Code       = $id_assesor;
      $rating->mengarahkan_value          = $request->mengarahkan_value;
      $rating->mengarahkan_comment        = $request->mengarahkan_comment;
      $rating->problem_solving_value      = $request->problem_solving_value;
      $rating->problem_solving_comment    = $request->problem_solving_comment;
      $rating->planning_value             = $request->planning_value;
      $rating->planning_comment           = $request->planning_comment;
      $rating->analisa_value              = $request->analisa_value;
      $rating->analisa_comment            = $request->analisa_comment;
      $rating->kualitas_komunikasi_value  = $request->kualitas_komunikasi_value;
      $rating->kualitas_komunikasi_comment= $request->kualitas_komunikasi_comment;
      $rating->save();

      if(isset($request->dynamic_input)) {
        for($i=0 ; $i < count($request->dynamic_input); $i++){
          $advance_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($advance_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          $noteS = new tr_emp_asses_note();
          $noteS->id_accessor_nt          = $id_accessor_nt;
          $noteS->Tr_Emp_Asses_Code       = $code_asas;
          //$noteS->id_emp_asses            = $id_emp_asses;
          $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
          $noteS->note                    = $request->dynamic_input[$i];
          $noteS->save();
        }
      }

      return Redirect::to('print_leadership_asas/'.$code_asas);

    }

    public function print_leadership_asas(Request $request, $id)
    {
      // dd($id);die;
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      emp.emp_name,
      emp_assesor.id_emp_accessor,
      user.name,
      user.ms_divisi,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment main
      left join users user on main.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
       ");
      $id_emp_asses = "";
      foreach($details as $row){
        $id_emp_asses = (string)$row->id_emp_accessor;
      }

       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      return view ('leadership.print_leadership_asas', compact('details', 'notes'));

    }

//discipline
    public function create_discipline_asas(Request $request, $id)
    {

      $user = auth()->user();
      $employee = MasterEmployee::all();
      $operators = MasterEmployee::where('emp_id', '=', $id)->first();
      $ms_divisi = MsDivisi::all();


       $ms_rating_basic= DB::connection('mysql')->select("
       select * from ms_rating_asasmen_basic where rec_status ='1'
       ");

      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      order by created_at desc
      LIMIT 1
      ");

      $data_asas_code = DB::connection('mysql')->select("
      SELECT
      Ms_Emp_Code,
      Tr_Emp_Asses_Code
      FROM tr_emp_assesment
      where Ms_Emp_Code  ='".$id."'
      order by id desc
      LIMIT 1
      ");

      $code_asas="";

      foreach($data_asas_code as $row)
      {
        $code_asas=$row->Tr_Emp_Asses_Code;
      }

      $last_id4 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      where Ms_Emp_Code  ='".$id."'
      ");

      if(count($last_id4 ) == 1 ){
        return view('discipline.asasmen_create_discipline', compact('user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));

      }
      else{
        return view('discipline.asasmen_create_discipline', compact('user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));
      };

    }

    public function save_discipline_asas (Request $request)
    {
      $code_asas=$request->Tr_Emp_Asses_Code;
      $newdatetime = Carbon::now()->toDateTimeString();
      $emp_accessor = DB::connection('mysql')->select("
        SELECT
        id_emp_accessor
        FROM tr_emp_assesor
        order by id_emp_accessor desc
        LIMIT 1
      ");
      $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
      foreach($emp_accessor as $row)
      {
          $maxid = $row->id_emp_accessor;
          $sort_num = (int) substr($maxid,-4,4);
          $sort_num++;
          $new_code = sprintf("%04s", $sort_num);
          $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
      }
      $asessor = new tr_emp_assesor();
      $asessor->id_emp_accessor       = $id_emp_accessor;
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = $newdatetime;
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $code_asas;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_record_asses       = $request->Ms_record_asses;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = $newdatetime;
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
      ->update([
          'Ms_type_asses'   => $request->Ms_type_asses,
          'Ms_record_asses' => $request->Ms_record_asses,
          'rec_dateupdate'  => $newdatetime,
          'rec_userupdate'  => $request->Ms_Emp_Assessor_Code,
      ]);

      $emp_assesor= DB::connection('mysql')->select("
      select
      id_emp_accessor
      from tr_emp_assesor
      where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
       ");

       $id_assesor = "";
       foreach($emp_assesor as $row)
       {
         $id_assesor = $row->id_emp_accessor;
       }
       $id_dcpn_rst='BSCRST'.'-'. date('Ydm').'-'.'0001';
       $disc_result = DB::connection('mysql')->select("
       SELECT
       id_dcpn_rst
       FROM tr_emp_asses_discipline_result
       order by id_dcpn_rst desc
       LIMIT 1
       ");
       $id_dcpn_rst = 'BSCRST'.'-'. date('Ydm').'-0001';
       foreach($disc_result as $row)
       {
         $maxid = $row->id_dcpn_rst;
         $sort_num = (int) substr($maxid,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $id_dcpn_rst='BSCRST'.'-'. date('Ydm').'-'. $new_code;
       }
      $rating = new tr_emp_asses_discipline_result();
      $rating->Tr_Emp_Asses_Code       = $code_asas;
      $rating->id_dcpn_rst             = $id_dcpn_rst;
      $rating->Ms_Emp_Assessor_Code    = $id_assesor;
      $rating->absensi_value           = $request->absensi_value;
      $rating->absensi_comment         = $request->absensi_comment;
      $rating->report_value            = $request->report_value;
      $rating->report_comment          = $request->report_comment;
      $rating->kerajinan_value         = $request->kerajinan_value;
      $rating->kerajinan_comment       = $request->kerajinan_comment;
      $rating->save();

      if(isset($request->dynamic_input)) {
        for($i=0 ; $i < count($request->dynamic_input); $i++){
          $advance_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($advance_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          $noteS = new tr_emp_asses_note();
          $noteS->id_accessor_nt          = $id_accessor_nt;
          $noteS->Tr_Emp_Asses_Code       = $code_asas;
          //$noteS->id_emp_asses            = $id_emp_asses;
          $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
          $noteS->note                    = $request->dynamic_input[$i];
          $noteS->save();
        }
      }

      return Redirect::to('print_discipline_asas/'.$code_asas);

    }

    public function print_discipline_asas(Request $request, $id)
    {
      // dd($id);die;
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      emp_assesor.id_emp_accessor,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment main
      left join users user on main.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
       ");
      $id_emp_asses = "";
      foreach($details as $row){
        $id_emp_asses = (string)$row->id_emp_accessor;
      }

       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      return view ('discipline.print_discipline_asas', compact('details', 'notes'));

    }

    public function asasmen_discipline_edit_hrd($id)
    {

      $tr_emp_assesment= DB::connection('mysql')->select("
      select
      emp_assesment.id,
      emp_assesment.rec_usercreated,
      emp_assesment.rec_datecreated,
      emp_assesment.rec_status,
      emp_assesment.Date_Asses,
      emp_assesment.Tr_Emp_Asses_Code,
      emp_assesment.Ms_Emp_Code,
      emp_assesment.Ms_Emp_Div,
      emp_assesment.Ms_type_asses,
      emp_assesment.Ms_record_asses,
      emp_assesment.rec_userupdate,
      emp.emp_name,
      emp_assesor.id_emp_accessor,
      user.name,
      user.ms_divisi,
      hasil.Ms_Emp_Assessor_Code,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment emp_assesment
      left join users user on emp_assesment.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on emp_assesment.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on emp_assesment.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where emp_assesment.Ms_Emp_Code ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
      ");

       $tr_emp_assesor= DB::connection('mysql')->select("
       select
       rec_usercreated,
       rec_userupdate,
       rec_datecreated,
       rec_status,
       Tr_Emp_Asses_Code,
       Ms_Emp_Assessor_Code,
       Date_Asses,
       Ms_emp_code,
       Ms_Emp_Div
       from tr_emp_assesor

       where Ms_emp_code ='$id'
        ");

        $data_Tr_Emp_Asses_Code = "";
        $data_Tr_Emp_Asses_Code_hrd = "";
         foreach($tr_emp_assesor as $row){
          $data_Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
         }

          $data_Ms_record_asses = "";
          $data_Tr_Emp_Asses_Code = "";
          foreach($tr_emp_assesment as $row){
            if($row->Ms_record_asses == "HRD"){
              $data_Ms_record_asses = "HRD";
              $data_Tr_Emp_Asses_Code_hrd = $row->Tr_Emp_Asses_Code;
            }else{
              $data_Tr_Emp_Asses_Code  = $row->Tr_Emp_Asses_Code;
            };

           $data_Tr_Emp_Asses_Code =  $row->Tr_Emp_Asses_Code;

          }


          $id_emp_asses = "";
          foreach($tr_emp_assesment as $row)
          {
            $id_emp_asses = $row->id_emp_accessor;
          }
          $tr_emp_asses_note= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note

          from tr_emp_asses_note

          where Ms_Emp_Assessor_Code = '$id_emp_asses'
          ");

          $tr_emp_asses_note_hrd= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note

          from tr_emp_asses_note

          where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code_hrd'
          ");

          $max_emp_code = DB::connection('mysql')->select("
          SELECT
          Tr_Emp_Asses_Code
          FROM tr_emp_assesment
          order by id desc
          LIMIT 1
          ");

          foreach($max_emp_code as $row)
          {
            $kalimat = $row->Tr_Emp_Asses_Code;
            $sort_num = (int) substr($kalimat,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;

          }

          $user = auth()->user();
          $ms_divisi = MsDivisi::all();
          $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

          if( $data_Ms_record_asses == "HRD"){
            return view ('discipline.asasmen_discipline_edit_hrd', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }
          else{
            return view ('discipline.asasmen_discipline_edit_hrd', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }

    }

    public function save_discipline_hrd  (Request $request)
    {

      $code_asas= $request->Tr_Emp_Asses_Code;
      $newdatetime = Carbon::now()->toDateTimeString();
      $emp_accessor = DB::connection('mysql')->select("
        SELECT
        id_emp_accessor
        FROM tr_emp_assesor
        order by id_emp_accessor desc
        LIMIT 1
      ");
        $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
      foreach($emp_accessor as $row)
      {
          $maxid = $row->id_emp_accessor;
          $sort_num = (int) substr($maxid,-4,4);
          $sort_num++;
          $new_code = sprintf("%04s", $sort_num);
          $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
      }
      $asessor = new tr_emp_assesor();
      $asessor->id_emp_accessor       = $id_emp_accessor;
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = $newdatetime;
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $code_asas;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_record_asses       = $request->Ms_record_asses;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = $newdatetime;
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
      ->update([
          'Ms_type_asses'   => $request->Ms_type_asses,
          'Ms_record_asses' => $request->Ms_record_asses,
          'rec_dateupdate'  => $newdatetime,
          'rec_userupdate'  => $request->Ms_Emp_Assessor_Code,
      ]);

      $emp_assesor= DB::connection('mysql')->select("
      select
      id_emp_accessor
      from tr_emp_assesor
      where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
       ");

       $id_assesor = "";
       foreach($emp_assesor as $row)
       {
         $id_assesor = $row->id_emp_accessor;
       }
       $disc_result = DB::connection('mysql')->select("
       SELECT
       id_dcpn_rst
       FROM tr_emp_asses_discipline_result
       order by id_dcpn_rst desc
       LIMIT 1
       ");
       $id_dcpn_rst = 'DISRST'.'-'. date('Ydm').'-0001';
       foreach($disc_result as $row)
       {
         $maxid = $row->id_dcpn_rst;
         $sort_num = (int) substr($maxid,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $id_dcpn_rst='DISRST'.'-'. date('Ydm').'-'. $new_code;
       }
      $rating = new tr_emp_asses_discipline_result();
      $rating->Tr_Emp_Asses_Code       = $code_asas;
      $rating->id_dcpn_rst             = $id_dcpn_rst;
      $rating->Ms_Emp_Assessor_Code    = $id_assesor;
      $rating->absensi_value           = $request->absensi_value;
      $rating->absensi_comment         = $request->absensi_comment;
      $rating->report_value            = $request->report_value;
      $rating->report_comment          = $request->report_comment;
      $rating->kerajinan_value         = $request->kerajinan_value;
      $rating->kerajinan_comment       = $request->kerajinan_comment;
      $rating->save();

      if(isset($request->dynamic_input)) {
        for($i=0 ; $i < count($request->dynamic_input); $i++){
          $advance_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($advance_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          $noteS = new tr_emp_asses_note();
          $noteS->id_accessor_nt          = $id_accessor_nt;
          $noteS->Tr_Emp_Asses_Code       = $code_asas;
          //$noteS->id_emp_asses            = $id_emp_asses;
          $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
          $noteS->note                    = $request->dynamic_input[$i];
          $noteS->save();
        }
      }

      return Redirect::to('print_discipline_asasmen_hrd/'.$code_asas.'/'.$request->Tr_Emp_Asses_Code_spv);

    }

    public function print_discipline_hrd(Request $request, $id ,$idspv)
    {

      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id' and
      asesor.Ms_record_asses ='HRD'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      // dd($id);die;
      $details_spv= DB::connection('mysql')->select("
      select
      main.id,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$idspv' and
      asesor.Ms_record_asses ='Supervisor'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details_spv as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes_spv= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      return view ('discipline.print_discipline_asasmen_hrd', compact('details', 'notes', 'details_spv', 'notes_spv' ));
    }


    public function asasmen_discipline_edit_spv($id)
    {

      $tr_emp_assesment= DB::connection('mysql')->select("
      select
      emp_assesment.id,
      emp_assesment.rec_usercreated,
      emp_assesment.rec_datecreated,
      emp_assesment.rec_status,
      emp_assesment.Date_Asses,
      emp_assesment.Tr_Emp_Asses_Code,
      emp_assesment.Ms_Emp_Code,
      emp_assesment.Ms_Emp_Div,
      emp_assesment.Ms_type_asses,
      emp_assesment.Ms_record_asses,
      emp.emp_name,
      emp_assesor.Ms_Emp_Assessor_Code,
      emp_assesor.id_emp_accessor,
      user.name,
      user.ms_divisi,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment emp_assesment
      left join users user on emp_assesment.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on emp_assesment.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on emp_assesment.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where emp_assesment.Ms_Emp_Code ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
      ");

       $tr_emp_assesor= DB::connection('mysql')->select("
       select
       rec_usercreated,
       rec_userupdate,
       rec_datecreated,
       rec_status,
       Tr_Emp_Asses_Code,
       Ms_Emp_Assessor_Code,
       Date_Asses,
       Ms_emp_code,
       Ms_Emp_Div
       from tr_emp_assesor
       where Ms_emp_code ='$id'
        ");

        $data_Tr_Emp_Asses_Code = "";
        $data_Tr_Emp_Asses_Code_hrd = "";
         foreach($tr_emp_assesor as $row){
          $data_Tr_Emp_Asses_Code = $row->Tr_Emp_Asses_Code;
         }

          $data_Ms_record_asses = "";
          $data_Tr_Emp_Asses_Code = "";
          foreach($tr_emp_assesment as $row){
            if($row->Ms_record_asses == "HRD"){
              $data_Ms_record_asses = "HRD";
              $data_Tr_Emp_Asses_Code_hrd = $row->Tr_Emp_Asses_Code;
            }else{
              $data_Tr_Emp_Asses_Code  = $row->Tr_Emp_Asses_Code;
            };

           $data_Tr_Emp_Asses_Code =  $row->Tr_Emp_Asses_Code;

          }
          $id_emp_asses = "";
          foreach($tr_emp_assesment as $row)
          {
            $id_emp_asses = $row->id_emp_accessor;
          }
          $tr_emp_asses_note= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note
          from tr_emp_asses_note
          where Ms_Emp_Assessor_Code = '$id_emp_asses'
          ");

          $tr_emp_asses_note_hrd= DB::connection('mysql')->select("
          select
          Tr_Emp_Asses_Code,
          Ms_Emp_Assessor_Code,
          note
          from tr_emp_asses_note
          where Tr_Emp_Asses_Code = '$data_Tr_Emp_Asses_Code_hrd'
          ");

          $max_emp_code = DB::connection('mysql')->select("
          SELECT
          Tr_Emp_Asses_Code
          FROM tr_emp_assesment
          order by id desc
          LIMIT 1
          ");

          foreach($max_emp_code as $row)
          {
            $kalimat = $row->Tr_Emp_Asses_Code;
            $sort_num = (int) substr($kalimat,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;

          }

          $user = auth()->user();
          $ms_divisi = MsDivisi::all();
          $operators = MasterEmployee::where('emp_email', '=', $user->email)->first();

          if( $data_Ms_record_asses == "HRD"){
            return view ('discipline.asasmen_discipline_edit_spv', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }
          else{
            return view ('discipline.asasmen_discipline_edit_spv', compact('tr_emp_assesment', 'tr_emp_assesor', 'tr_emp_asses_note', 'tr_emp_asses_note_hrd', 'code_asas', 'user', 'operators'));
          }


    }


    public function save_discipline_spv (Request $request)
    {

      $code_asas= $request->Tr_Emp_Asses_Code;
      $newdatetime = Carbon::now()->toDateTimeString();
      $emp_accessor = DB::connection('mysql')->select("
        SELECT
        id_emp_accessor
        FROM tr_emp_assesor
        order by id_emp_accessor desc
        LIMIT 1
      ");
        $id_emp_accessor = 'EMPACR'.'-'. date('Ydm').'-0001';
      foreach($emp_accessor as $row)
      {
          $maxid = $row->id_emp_accessor;
          $sort_num = (int) substr($maxid,-4,4);
          $sort_num++;
          $new_code = sprintf("%04s", $sort_num);
          $id_emp_accessor='EMPACR'.'-'. date('Ydm').'-'. $new_code;
      }
      $asessor = new tr_emp_assesor();
      $asessor->id_emp_accessor       = $id_emp_accessor;
      $asessor->rec_usercreated       = $request->Ms_Emp_Assessor_Code;
      $asessor->rec_userupdate        = '';
      $asessor->rec_datecreated       = $newdatetime;
      $asessor->rec_status            = '1';
      $asessor->Tr_Emp_Asses_Code     = $code_asas;
      $asessor->Ms_Emp_Assessor_Code  = $request->Ms_Emp_Assessor_Code;
      $asessor->Ms_record_asses       = $request->Ms_record_asses;
      $asessor->Ms_type_asses         = $request->Ms_type_asses;
      $asessor->Date_Asses            = $newdatetime;
      $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
      $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
      $asessor->save();

      tr_emp_assesment::where('Tr_Emp_Asses_Code', $code_asas)
      ->update([
          'Ms_type_asses'   => $request->Ms_type_asses,
          'Ms_record_asses' => $request->Ms_record_asses,
          'rec_dateupdate'  => $newdatetime,
          'rec_userupdate'  => $request->Ms_Emp_Assessor_Code,
      ]);

      $emp_assesor= DB::connection('mysql')->select("
      select
      id_emp_accessor
      from tr_emp_assesor
      where Tr_Emp_Asses_Code ='$code_asas' and rec_datecreated ='$newdatetime'
       ");

       $id_assesor = "";
       foreach($emp_assesor as $row)
       {
         $id_assesor = $row->id_emp_accessor;
       }
       $disc_result = DB::connection('mysql')->select("
       SELECT
       id_dcpn_rst
       FROM tr_emp_asses_discipline_result
       order by id_dcpn_rst desc
       LIMIT 1
       ");
       $id_dcpn_rst = 'DISRST'.'-'. date('Ydm').'-0001';
       foreach($disc_result as $row)
       {
         $maxid = $row->id_dcpn_rst;
         $sort_num = (int) substr($maxid,-4,4);
         $sort_num++;
         $new_code = sprintf("%04s", $sort_num);
         $id_dcpn_rst='DISRST'.'-'. date('Ydm').'-'. $new_code;
       }
      $rating = new tr_emp_asses_discipline_result();
      $rating->Tr_Emp_Asses_Code       = $code_asas;
      $rating->id_dcpn_rst             = $id_dcpn_rst;
      $rating->Ms_Emp_Assessor_Code    = $id_assesor;
      $rating->absensi_value           = $request->absensi_value;
      $rating->absensi_comment         = $request->absensi_comment;
      $rating->report_value            = $request->report_value;
      $rating->report_comment          = $request->report_comment;
      $rating->kerajinan_value         = $request->kerajinan_value;
      $rating->kerajinan_comment       = $request->kerajinan_comment;
      $rating->save();

      if(isset($request->dynamic_input)) {
        for($i=0 ; $i < count($request->dynamic_input); $i++){
          $advance_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($advance_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          $noteS = new tr_emp_asses_note();
          $noteS->id_accessor_nt          = $id_accessor_nt;
          $noteS->Tr_Emp_Asses_Code       = $code_asas;
          $noteS->Ms_Emp_Assessor_Code    = $id_assesor;
          $noteS->note                    = $request->dynamic_input[$i];
          $noteS->save();
        }
      }

      return Redirect::to('print_discipline_asasmen_spv/'.$request->Tr_Emp_Asses_Code_spv.'/'.$code_asas);

    }

    public function print_discipline_spv(Request $request, $id ,$idspv)
    {
      // dd($id);die;
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id' and
      asesor.Ms_record_asses ='HRD'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where 	Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      // dd($id);die;
      $details_spv= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.Ms_type_asses,
      main.Ms_record_asses,
      asesor.id_emp_accessor as id_emp_accessor,
      asesor.Ms_Emp_Assessor_Code,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment main
      left join tr_emp_assesor asesor on main.Tr_Emp_Asses_Code = asesor.Tr_Emp_Asses_Code
      left join users user on main.rec_usercreated = user.name
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$idspv' and
      asesor.Ms_record_asses ='Supervisor'
      order by asesor.created_at desc
      LIMIT 1
       ");
       $id_emp_asses = "";
       foreach($details_spv as $row){
         $id_emp_asses = (string)$row->id_emp_accessor;
       }
       $notes_spv= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where 	Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      return view ('discipline.print_discipline_asasmen_spv', compact('details', 'notes', 'details_spv', 'notes_spv' ));
    }

    public function print_history(Request $request, $id, $id2)
    {
        // dd($id);
      if($id2 == "Basic 1" || $id2 == "Basic 2"){
        $details= DB::connection('mysql')->select("
        select
        main.id_period_emp_assesor as id,
        main.rec_usercreated,
        main.created_at,
        main.Tr_Emp_Asses_Code,
        main.Ms_emp_code,
        main.Ms_Emp_Div,
        main.ms_periode,
        emp_assesor.Ms_type_asses,
        emp_assesor.Ms_record_asses,
        emp_assesor.id_emp_accessor,
        emp.emp_name,
        user.name,
        user.ms_divisi,
        hasil.Trust_value,
        hasil.trust_comment,
        hasil.trust_suggestion,
        hasil.drive_value,
        hasil.drive_comment,
        hasil.drive_suggestion,
        hasil.inisiative_value,
        hasil.inisiatif_comment,
        hasil.inisiative_suggestion,
        hasil.Reliable_value,
        hasil.reliable_comment,
        hasil.Reliable_suggestion,
        hasil.reslut,
        hasil.result_comment,
        hasil.result_suggestion
        from tr_period_emp_assesor_main main
        left join users user on main.rec_usercreated = user.name
        left join tr_emp_assesor emp_assesor on main.id_period_emp_assesor = emp_assesor.Tr_Emp_Asses_Code
        left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
        left join tr_emp_asses_basic_result hasil on main.id_period_emp_assesor = hasil.Tr_Emp_Asses_Code
        where emp_assesor.id_emp_accessor ='$id'
        ");
        // dd($details);
        $id_emp_asses = "";
        foreach($details as $row){
          $id_emp_asses = (string)$row->Ms_emp_code;
        }
        // dd($id_emp_asses);
        $notes= DB::connection('mysql')->select("
        select
        main.id_period_emp_assesor as id,
        main.rec_usercreated,
        main.created_at,
        main.Tr_Emp_Asses_Code,
        main.Ms_emp_code,
        main.Ms_Emp_Div,
        main.ms_periode,
        emp_assesor.Ms_type_asses,
        emp_assesor.Ms_record_asses,
        emp_assesor.id_emp_accessor,
        emp.emp_name,
        user.name,
        user.ms_divisi,
        hasil.Trust_value,
        hasil.trust_comment,
        hasil.drive_value,
        hasil.drive_comment,
        hasil.inisiative_value,
        hasil.inisiatif_comment,
        hasil.Reliable_value,
        hasil.reliable_comment,
        hasil.reslut,
        hasil.result_comment,
		periode.tugas,
		task_result.ResultNote,
		periode.start_date,
		periode.EndDate,
		tugasnya.Task,
        tugasnya.Ms_Order_giver,
        tugasnya.ms_type,
        tugasnya.Date,
        tugasnya.status,
        tugasnya.konsisten,
        tugasnya.akurasi,
        tugasnya.tepatwaktu,
        tugasnya.quality,
		task_result.ScoreResult

        from tr_period_emp_assesor_main main
        left join users user on main.rec_usercreated = user.name
        left join tr_emp_assesor emp_assesor on main.id_period_emp_assesor = emp_assesor.Tr_Emp_Asses_Code
        left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
        left join tr_emp_asses_basic_result hasil on main.id_period_emp_assesor = hasil.Tr_Emp_Asses_Code
		left join tr_period_asssement periode on main.id_period_emp_assesor = periode.tr_code_main_assessment
		left join tr_task_result task_result on periode.Tr_period_assement = task_result.Tr_period_emp_task
		left join tr_period_emp_task tugasnya on periode.Tr_period_assement = tugasnya.Tr_period_emp_task_code
		where main.Ms_emp_code ='$id_emp_asses'
          ");
// dd($notes);
        foreach($details as $row2)
          {
            $pelaku = $row2->emp_name;
          }
          $baResult = DB::connection('mysql')->select("
                SELECT
                User_Code,
                COUNT(Tr_BA_Code) AS total_ba
                FROM tr_ba_main
                WHERE rec_status = '1'
                AND User_Code = ?
                GROUP BY User_Code
            ", [$pelaku]);

            if (count($baResult) > 0) {
                $totalBa = $baResult[0]->total_ba;
            } else {
                $totalBa = 0;
            }
        return view ('asasmen.print_asasmen', compact('details', 'notes', 'totalBa'));
      }

      if($id2 == "Leadership 1" || $id2 == "Leadership 2"){
        $details= DB::connection('mysql')->select("
        select
        main.id,
        main.rec_usercreated,
        main.created_at,
        main.Tr_Emp_Asses_Code,
        main.Ms_emp_code,
        main.Ms_Emp_Div,
        emp_assesor.Ms_type_asses,
        emp_assesor.Ms_record_asses,
        emp_assesor.id_emp_accessor,
        emp.emp_name,
        user.name,
        user.ms_divisi,
        hasil.mengarahkan_value,
        hasil.mengarahkan_comment,
        hasil.problem_solving_value,
        hasil.problem_solving_comment,
        hasil.planning_value,
        hasil.planning_comment,
        hasil.analisa_value,
        hasil.analisa_comment,
        hasil.kualitas_komunikasi_value,
        hasil.kualitas_komunikasi_comment
        from tr_emp_assesment main
        left join users user on main.rec_usercreated = user.name
        left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
        left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
        left join tr_emp_asses_advance_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
        where emp_assesor.id_emp_accessor ='$id'
        order by emp_assesor.created_at desc
        LIMIT 1
         ");
        $id_emp_asses = "";
        foreach($details as $row){
          $id_emp_asses = (string)$row->id_emp_accessor;
        }

         $notes= DB::connection('mysql')->select("
         select
          note
         from tr_emp_asses_note
         where Ms_Emp_Assessor_Code ='$id_emp_asses'
          ");

        return view ('leadership.print_leadership', compact('details', 'notes'));
      }


      if($id2 == "Discipline 1" || $id2 == "Discipline 2"){
        $details= DB::connection('mysql')->select("
        select
        main.id,
        main.rec_usercreated,
        main.created_at,
        main.Tr_Emp_Asses_Code,
        main.Ms_emp_code,
        main.Ms_Emp_Div,
        emp_assesor.Ms_type_asses,
        emp_assesor.Ms_record_asses,
        emp_assesor.id_emp_accessor,
        emp.emp_name,
        user.name,
        user.ms_divisi,
        hasil.absensi_value,
        hasil.absensi_comment,
        hasil.report_value,
        hasil.report_comment,
        hasil.kerajinan_value,
        hasil.kerajinan_comment
        from tr_emp_assesment main
        left join users user on main.rec_usercreated = user.name
        left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
        left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
        left join tr_emp_asses_discipline_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
        where emp_assesor.id_emp_accessor ='$id'
        order by emp_assesor.created_at desc
        LIMIT 1
         ");
        $id_emp_asses = "";
        foreach($details as $row){
          $id_emp_asses = (string)$row->id_emp_accessor;
        }

         $notes= DB::connection('mysql')->select("
         select
          note
         from tr_emp_asses_note
         where Ms_Emp_Assessor_Code ='$id_emp_asses'
          ");
        return view ('discipline.print_discipline_asas', compact('details', 'notes'));
      }

    }

    public function report_asesmen_data()
    {
        $datas['data'] = DB::connection('mysql')->select("select

        mains.created_at as created_at,
        mains.Date_BA as Date_BA,
        mains.Company_Code as Company_Code,
        mains.Location_Code as Location_Code,
        mains.BA_Admin as BA_Admin,
        mains.User_Code as User_Code,
        mains.Division_Code as Division_Code,
        mains.jenis as jenis,
        mains.ms_kasus as ms_kasus,
        krono.kronlogi as kronlogi
        from
        tr_ba_main mains
       left join tr_ba_kronologi krono on mains.Tr_BA_Code = krono.tr_ba_main_code
       where rec_status ='1' and ba_status is not null
       order by mains.created_at DESC");

       $employee = DB::connection('mysql')->select("
      select
         main.created_at,
         main.Tr_Emp_Asses_Code,
         main.Ms_emp_code,
         main.Ms_Emp_Div,
         main.rec_usercreated,
         emp.emp_name,
         (select sum(basic.Trust_value + basic.drive_value + basic.inisiative_value + basic.Reliable_value + basic.reslut)
             from tr_emp_asses_basic_result basic
             left join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
             where basic.Ms_Emp_Assessor_Code = asesor.id_emp_accessor
         ) as sumbesic,
         (select sum(advance.mengarahkan_value + advance.problem_solving_value + advance.planning_value + advance.analisa_value + advance.kualitas_komunikasi_value)
             from tr_emp_asses_advance_result advance
             left join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
             where advance.Ms_Emp_Assessor_Code = asesor.id_emp_accessor
         ) as sumadvance,
         (select sum(discipline.absensi_value + discipline.report_value + discipline.kerajinan_value)
             from tr_emp_asses_discipline_result discipline
             left join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
             where discipline.Ms_Emp_Assessor_Code = asesor.id_emp_accessor
         ) as sumdiscipline
         from tr_period_emp_assesor_main main
         left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
         where main.rec_status ='1'
       ");
          // Penggabungan 2 tabel
        return view('asasmen.report_asesmen_data', compact('datas','employee'))->with('dataemp', $datas);
    }

    public function report_asesmen_pot (Request $request, $id) {
      $employee = DB::connection('mysql')->select("
      select
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      main.rec_usercreated,
      emp.emp_name,
      asesor.Ms_type_asses,
      hasil.Trust_value,
      hasil.drive_value,
      hasil.inisiative_value,
      hasil.Reliable_value,
      hasil.reslut,
      advance.mengarahkan_value,
      advance.problem_solving_value,
      advance.planning_value,
      advance.analisa_value,
      advance.kualitas_komunikasi_value,
      discipline.absensi_value,
      discipline.report_value,
      discipline.kerajinan_value

      from tr_period_emp_assesor_main main
      right join tr_emp_assesor asesor on main.id_period_emp_assesor = asesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
      left join tr_emp_asses_basic_result hasil on asesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      left join tr_emp_asses_advance_result advance on asesor.id_emp_accessor = advance.Ms_Emp_Assessor_Code
      left join tr_emp_asses_discipline_result discipline on asesor.id_emp_accessor = discipline.Ms_Emp_Assessor_Code
      where main.Tr_Emp_Asses_Code ='$id'
      ");
      return view('asasmen.report_asesmen_nilai', compact('employee'))->with('');
  }

  public function tambah_target(Request $request, $id, $id2)
  {

    if($id2 == "Basic 1" || $id2 == "Basic 2"){
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      emp_assesor.Ms_type_asses,
      emp_assesor.Ms_record_asses,
      emp_assesor.id_emp_accessor,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.Trust_value,
      hasil.trust_comment,
      hasil.drive_value,
      hasil.drive_comment,
      hasil.inisiative_value,
      hasil.inisiatif_comment,
      hasil.Reliable_value,
      hasil.reliable_comment,
      hasil.reslut,
      hasil.result_comment
      from tr_emp_assesment main
      left join users user on main.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_basic_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where emp_assesor.id_emp_accessor ='$id'
      ");
      $id_emp_asses = "";
      foreach($details as $row){
        $id_emp_asses = (string)$row->id_emp_accessor;
      }


      $notes= DB::connection('mysql')->select("
      select
      note,
      status
      from tr_emp_asses_note
      where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
// dd($id_emp_asses);
      foreach($details as $row2)
        {
          $pelaku = $row2->emp_name;
        }
        $baResult = DB::connection('mysql')->select("
              SELECT
              User_Code,
              COUNT(Tr_BA_Code) AS total_ba
              FROM tr_ba_main
              WHERE rec_status = '1'
              AND User_Code = ?
              GROUP BY User_Code
          ", [$pelaku]);

          // Memeriksa apakah ada hasil dari query
          if (count($baResult) > 0) {
              $totalBa = $baResult[0]->total_ba;
          } else {
              // Jika tidak ada hasil, atur total_ba menjadi 0
              $totalBa = 0;
          }
      return view ('asasmen.add_target', compact('details', 'notes', 'totalBa', 'id_emp_asses'));
    }

    if($id2 == "Leadership 1" || $id2 == "Leadership 2"){
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      emp_assesor.Ms_type_asses,
      emp_assesor.Ms_record_asses,
      emp_assesor.id_emp_accessor,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.mengarahkan_value,
      hasil.mengarahkan_comment,
      hasil.problem_solving_value,
      hasil.problem_solving_comment,
      hasil.planning_value,
      hasil.planning_comment,
      hasil.analisa_value,
      hasil.analisa_comment,
      hasil.kualitas_komunikasi_value,
      hasil.kualitas_komunikasi_comment
      from tr_emp_assesment main
      left join users user on main.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_advance_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where emp_assesor.id_emp_accessor ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
       ");
      $id_emp_asses = "";
      foreach($details as $row){
        $id_emp_asses = (string)$row->id_emp_accessor;
      }

       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");

      return view ('leadership.print_leadership', compact('details', 'notes'));
    }


    if($id2 == "Discipline 1" || $id2 == "Discipline 2"){
      $details= DB::connection('mysql')->select("
      select
      main.id,
      main.rec_usercreated,
      main.created_at,
      main.Tr_Emp_Asses_Code,
      main.Ms_emp_code,
      main.Ms_Emp_Div,
      emp_assesor.Ms_type_asses,
      emp_assesor.Ms_record_asses,
      emp_assesor.id_emp_accessor,
      emp.emp_name,
      user.name,
      user.ms_divisi,
      hasil.absensi_value,
      hasil.absensi_comment,
      hasil.report_value,
      hasil.report_comment,
      hasil.kerajinan_value,
      hasil.kerajinan_comment
      from tr_emp_assesment main
      left join users user on main.rec_usercreated = user.name
      left join tr_emp_assesor emp_assesor on main.Tr_Emp_Asses_Code = emp_assesor.Tr_Emp_Asses_Code
      left join master_employees emp on main.Ms_Emp_Code = emp.emp_id
      left join tr_emp_asses_discipline_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
      where emp_assesor.id_emp_accessor ='$id'
      order by emp_assesor.created_at desc
      LIMIT 1
       ");
      $id_emp_asses = "";
      foreach($details as $row){
        $id_emp_asses = (string)$row->id_emp_accessor;
      }

       $notes= DB::connection('mysql')->select("
       select
        note
       from tr_emp_asses_note
       where Ms_Emp_Assessor_Code ='$id_emp_asses'
        ");
      return view ('discipline.print_discipline_asas', compact('details', 'notes'));
    }

  }

  public function update_basic(Request $request)
  {

    $main = tr_emp_assesment::where('Tr_Emp_Asses_Code', '=', $request->Tr_Emp_Asses_Code)->first();


    $rating = tr_emp_asses_basic_result::where('Tr_Emp_Asses_Code', $request->Tr_Emp_Asses_Code)
        ->update([
            'Trust_value' => $request->trust,
            'drive_value' => $request->drive,
            'inisiative_value' => $request->inisiatif,
            'Reliable_value' => $request->reliable,
            'reslut' => $request->result

        ]);

         $basic_result = DB::connection('mysql')->select("
          SELECT
          id_accessor_nt
          FROM tr_emp_asses_note
          order by id_accessor_nt desc
          LIMIT 1
          ");
          $id_accessor_nt = 'ACCNOT'.'-'. date('Ydm').'-0001';
          foreach($basic_result as $row)
          {
            $maxid = $row->id_accessor_nt;
            $sort_num = (int) substr($maxid,-4,4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            $id_accessor_nt='ACCNOT'.'-'. date('Ydm').'-'. $new_code;
          }
          foreach ($request['note'] as $key => $item_id) {
            // Pemeriksaan apakah data sudah ada sebelumnya
            $existingNote = tr_emp_asses_note::where('Tr_Emp_Asses_Code', $request->Tr_Emp_Asses_Code)
                ->where('note', $request['note'][$key])
                ->first();

            if (!$existingNote) {
                $noteS = new tr_emp_asses_note();
                $noteS->id_accessor_nt = $id_accessor_nt;
                $noteS->Tr_Emp_Asses_Code = $request->Tr_Emp_Asses_Code;
                $noteS->Ms_Emp_Assessor_Code = $request->Tr_Emp_Assesor_Code;
                $noteS->note = $request['note'][$key];
                $noteS->status = $request['status'][$key]; // Pastikan status diambil dari form
                $noteS->save();
            } else {
                // Jika data sudah ada, update status
                $existingNote->status = $request['status'][$key];
                $existingNote->save();
            }
        }

          session()->flash('success', 'Target berhasil diupdate!');
          return redirect('history_asasmen');
  }

//   public function edit_assassment(Request $request, $id)
//   {
//     $mains= DB::connection('mysql')->select("
//     select  * from tr_period_emp_assesor_main
//     where id_period_emp_assesor ='$id'
//     order by created_at desc ");

//     $tugas= DB::connection('mysql')->select("
//     select DISTINCT
//     tugasnya.Tr_period_emp_task_code,
//     tugasnya.Task,
//     tugasnya.Ms_Order_giver,
//     tugasnya.initiative,
//     tugasnya.mentoring,
//     tugasnya.konsisten,
//     tugasnya.akurasi,
//     tugasnya.tepatwaktu,
//     tugasnya.quality,
//     tugasnya.start_date,
//     tugasnya.end_date

//     from tr_period_emp_assesor_main main
//     left join tr_period_emp_task tugasnya on tugasnya.tr_code_main_assessment = main.id_period_emp_assesor
//     where main.Tr_Emp_Asses_Code ='$id'
//     order by main.created_at desc");

//     $heading= DB::connection('mysql')->select("
//     select DISTINCT
//         main.id_period_emp_assesor as id,
//         main.rec_usercreated,
//         main.created_at,
//         main.Tr_Emp_Asses_Code,
//         main.Ms_emp_code,
//         main.Ms_Emp_Div,
//         emp_assesor.Ms_type_asses,
//         emp_assesor.Ms_record_asses,
//         emp_assesor.id_emp_accessor,
//         emp.emp_name,
//         emp_assesor.rec_usercreated as name,
//         emp_assesor.Ms_record_asses as ms_divisi,
//         hasil.Trust_value,
//         hasil.trust_comment,
// 				hasil.trust_suggestion,
//         hasil.drive_value,
//         hasil.drive_comment,
// 				hasil.drive_suggestion,
//         hasil.inisiative_value,
//         hasil.inisiatif_comment,
// 				hasil.inisiative_suggestion,
//         hasil.Reliable_value,
//         hasil.reliable_comment,
// 				hasil.Reliable_suggestion,
//         hasil.reslut,
//         hasil.result_comment,
// 				hasil.result_suggestion

//         from tr_period_emp_assesor_main main
//         left join users user on main.rec_usercreated = user.name
//         left join tr_emp_assesor emp_assesor on main.id_period_emp_assesor = emp_assesor.Tr_Emp_Asses_Code
//         left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
//         left join tr_emp_asses_basic_result hasil on emp_assesor.id_emp_accessor = hasil.Ms_Emp_Assessor_Code
//         where main.id_period_emp_assesor  ='$id'
//         order by emp_assesor.created_at asc

//         ");

//         // dd($heading);
//         $targets= DB::connection('mysql')->select("
//         select
//           note,
//           ms_type,
//           rating,
//           deadline,
//           status
//         from tr_emp_asses_note
//         where Ms_Emp_Assessor_Code ='$id'
//           ");


//           $id_emp_asses = "";
//           foreach($heading as $row){
//             $id_emp_asses = (string)$row->id_emp_accessor;
//           }

//           foreach($heading as $row2)
//           {
//             $pelaku = $row2->emp_name;
//           }
//           $baResult = DB::connection('mysql')->select("
//                 SELECT
//                 User_Code,
//                 COUNT(Tr_BA_Code) AS total_ba
//                 FROM tr_ba_main
//                 WHERE rec_status = '1'
//                 AND User_Code = ?
//                 GROUP BY User_Code
//             ", [$pelaku]);

//             // Memeriksa apakah ada hasil dari query
//             if (count($baResult) > 0) {
//                 $totalBa = $baResult[0]->total_ba;
//             } else {
//                 // Jika tidak ada hasil, atur total_ba menjadi 0
//                 $totalBa = 0;
//             }


//     return view('asasmen.edit_assessment', compact('mains','heading', 'targets', 'totalBa', 'tugas'));
//   }


//   public function update_assassment_basic(Request $request, $id)
//   {
//       $user = auth()->user();
//     // dd($request->code_main);
//       $main_ba = tr_Period_emp_assesor_main::where('id_period_emp_assesor', $id)
//       ->update([
//           'rec_userupdate' => Auth::User()->name,
//           'rec_dateupdate' => Carbon::now()->toDateTimeString()
//       ]);

//       $emp_accessor = DB::connection('mysql')->select("
//       SELECT
//       id_emp_accessor
//       FROM tr_emp_assesor
//       order by created_at desc
//       LIMIT 1
//       ");

//         $twoChars = substr($user->username, 0, 3);

//         foreach($emp_accessor as $asas2)
//         { $idnya2 = $asas2;}
//         $ambilkode2=tr_emp_assesor::where($request->id_emp_accessor)->get();
//         $nambah2=count($ambilkode2)+1;
//         if ($nambah2 <10000)
//         {
//           $id_emp_accessor='ASSESSOR'. '-'. $user->username.'-'. date('Ydm').'-'."00".$nambah2;
//         }
//         {
//           $asessor = new tr_emp_assesor();
//           $asessor->id_emp_accessor       = $id_emp_accessor;
//           $asessor->rec_usercreated       = Auth::User()->name;
//           $asessor->rec_userupdate        = '';
//           $asessor->rec_datecreated       = Carbon::now()->toDateTimeString();;
//           $asessor->rec_status            = '1';
//           $asessor->Tr_Emp_Asses_Code     = $request->code_main;
//           $asessor->Ms_Emp_Assessor_Code  = Auth::User()->name;
//           $asessor->Ms_record_asses       = Auth::User()->sub_divisi;
//           $asessor->Ms_type_asses         = 'Basic 1';
//           $asessor->Date_Asses            = Carbon::now()->toDateTimeString();
//           $asessor->Ms_emp_code           = $request->Ms_Emp_Code;
//           $asessor->Ms_Emp_Div            = $request->Ms_Emp_Div;
//           // dd($asessor);
//           $asessor->save();
//         }

//         $basic_result = DB::connection('mysql')->select("
//         SELECT
//         id_bsc_rst
//         FROM tr_emp_asses_basic_result
//         order by created_at desc
//         LIMIT 1
//         ");

//       $twoChars = substr($user->username, 0, 3);

//       foreach($basic_result as $asas23)
//       { $idnya231 = $asas23;}
//       $ambilkode21=tr_emp_assesor::where($request->id_emp_accessor)->get();
//       $nambah21=count($ambilkode21)+1;
//       if ($nambah2 <10000)
//       {
//         $id_bsc_rst='RESULT'. '-'. $user->username.'-'. date('Ydm').'-'."00".$nambah21;
//       }
//       {
//         $rating = new tr_emp_asses_basic_result();
//         $rating->Tr_Emp_Asses_Code       = $id;
//         $rating->id_bsc_rst              = $id_bsc_rst;
//         $rating->Ms_Emp_Assessor_Code    = $id_emp_accessor;
//         $rating->Trust_value             = $request->trust_value;
//         $rating->trust_comment           = $request->trust_comment;
//         $rating->trust_suggestion        = $request->trust_suggestion;
//         $rating->drive_value             = $request->drive_value;
//         $rating->drive_comment           = $request->drive_comment;
//         $rating->drive_suggestion        = $request->drive_suggestion;
//         $rating->inisiative_value        = $request->inisiative_value;
//         $rating->inisiatif_comment       = $request->inisiatif_comment;
//         $rating->inisiative_suggestion   = $request->inisiative_suggestion;
//         $rating->Reliable_value          = $request->Reliable_value;
//         $rating->reliable_comment        = $request->reliable_comment;
//         $rating->Reliable_suggestion     = $request->Reliable_suggestion;
//         $rating->reslut                  = $request->result;
//         $rating->result_comment          = $request->result_comment;
//         $rating->result_suggestion       = $request->result_suggestion;
//         // dd($rating);
//         $rating->save();


//         foreach($request['tugas'] as $key => $item_id)
//           {
//               $tugasnya = new tr_period_emp_task();
//               $tugasnya->tr_code_main_assessment = $id;
//               $tugasnya->Tr_period_emp_task_code = $request['autocode'][$key];
//               $tugasnya->Task                    = $request['tugas'][$key];
//               $tugasnya->Ms_Order_giver          = Auth::User()->name;
//               $tugasnya->Tr_period_emp_Code      = 'Q1-' . $request->Ms_Emp_Code. '-' . date('Ydm');
//               $tugasnya->initiative              = $request['initiative'][$key];
//               $tugasnya->mentoring               = $request['mentoring'][$key];
//               $tugasnya->konsisten               = $request['konsisten'][$key];
//               $tugasnya->akurasi                 = $request['akurasi'][$key];
//               $tugasnya->tepatwaktu              = $request['tepat_waktu'][$key];
//               $tugasnya->quality                 = $request['quality'][$key];
//               $tugasnya->start_date              = $request['start_date'][$key];
//               $tugasnya->end_date                = $request['end_date'][$key];
//               $tugasnya->Date                    = $request['end_date'][$key];
//               // dd($tugasnya);
//               $tugasnya->save();
//           }

//           foreach($request['tugas'] as $key => $item_id)
//           {

//             $result = new tr_task_result();
//             $result->tr_code_main_assessment     = $id;
//             $result->tr_period_emp_task          = $request->ms_periode .'-' . $request->Ms_Emp_Code;
//             $result->tr_period_emp_task_assesor  = $request['autocode'][$key];
//             $result->ms_assesor_code             = Auth::User()->name ;
//             $result->Jobs                        = $request['tugas'][$key];
//             $result->ResultNote                  = '';
//             $result->ScoreResult                 = 0;
//             $result->Date                        = Carbon::now()->toDateTimeString();
//             // dd($result);
//             $result->save();
//           }
//           foreach($request['tugas'] as $key => $item_id)
//           {
//             $period = new tr_period_asssement();
//             $period->tr_code_main_assessment     = $id;
//             $period->Tr_period_assement          = $request['autocode'][$key];
//             $period->tugas                       = $request['tugas'][$key];
//             $period->start_date                  = Carbon::now()->toDateTimeString();
//             // dd($period);
//             $period->save();
//           }
//           foreach($request['tugas'] as $key => $item_id)
//           {
//             $noteS = new tr_emp_asses_note();
//             $noteS->id_accessor_nt          = $request['autocode'][$key];
//             $noteS->Tr_Emp_Asses_Code       = $id;
//             $noteS->Ms_Emp_Assessor_Code    = Auth::User()->name;
//             $noteS->note                    = $request['tugas'][$key];
//             // dd($noteS);
//             $result->save();
//           }

//       Session::flash('warning', 'Assessment Berhasil DiUpadate.');
//       return view('asasmen.sukses');
//     }
//   }

public function edit_assassment(Request $request, $id)
  {
    $mains= DB::connection('mysql')->select("
    select  * from Tr_Review_EmpPeriod_h
    where Tr_Review_EmpPeriod_Code_h ='$id'
    order by created_at desc ");

    $heading= DB::connection('mysql')->select("
    select DISTINCT
				hasil.Tr_Review_EmpPeriod_Basic_Reviewer_Code,
        main.Tr_Review_EmpPeriod_Code_h as id,
        main.created_at,
        main.Ms_Emp_Code,
        main.Ms_Emp_Div,
				hasil.Ms_Reviewer_Code,
        hasil.Trust_value,
        hasil.trust_comment,
				hasil.trust_suggestion,
				hasil.TrustHigh,
				hasil.TrustLow,
        hasil.drive_value,
        hasil.drive_comment,
				hasil.drive_suggestion,
				hasil.DriveHigh,
				hasil.DriveLow,
        hasil.inisiative_value,
        hasil.inisiatif_comment,
				hasil.inisiative_suggestion,
				hasil.InisiativeHigh,
				hasil.InisitativeLow,
        hasil.Reliable_value,
        hasil.reliable_comment,
				hasil.Reliable_suggestion,
				hasil.ReliableHigh,
				hasil.ReliableLow,
        hasil.result,
        hasil.result_comment,
				hasil.result_suggestion,
				hasil.ResultHigh,
				hasil.ResultLow

        from Tr_Review_EmpPeriod_h main
        left join users user on main.rec_usercreated = user.name
        left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
        left join Tr_Review_EmpPeriod_Basic_Reviewer hasil on main.Tr_Review_EmpPeriod_Code_h = hasil.Tr_Review_EmpPeriod_Code_h
        where main.Tr_Review_EmpPeriod_Code_h  ='$id'
        order by main.created_at asc");

        $tugas= DB::connection('mysql')->select("
        select DISTINCT
        tugasnya.Tr_Review_EmpPeriod_Task_Reviewer_Code,
        tugasnya.TaskDesc,
        tugasnya.DateTask,
        tugasnya.Ms_Reviewer_Code,
        tugasnya.ResultDesc,
        tugasnya.ResultHigh,
        tugasnya.ResultLow,
        tugasnya.SugestReviewer,
        tugasnya.SuggestMgt,
        tugasnya.Suggest_BOD,
        tugasnya.Ms_Task_Status,
        tugasnya.Quality,
        tugasnya.Solutif,
        tugasnya.Inisiatif,
        tugasnya.Tuntas,
        tugasnya.Kualitas,
        tugasnya.Kecepatan,
        tugasnya.Update,
        tugasnya.Hasil,
        tugasnya.Konsisten,
        tugasnya.Tanggap

        from Tr_Review_EmpPeriod_h header
        left join Tr_Review_EmpPeriod_Task_Reviewer tugasnya on tugasnya.Tr_Review_EmpPeriod_Code_h = header.Tr_Review_EmpPeriod_Code_h
        where header.Tr_Review_EmpPeriod_Code_h ='$id'
        order by header.created_at asc");


    return view('asasmen.edit_assessment', compact('mains','heading', 'tugas'));
  }

  public function update_assassment_basic(Request $request, $id)
  {
    $user = auth()->user();
    $newdatetime = Carbon::now();
    $tahunSaatIni = $newdatetime->year;

      $main_ba = Tr_Review_EmpPeriod_h::where('Tr_Review_EmpPeriod_Code_h', $id)
      ->update([
          'rec_userupdate' => Auth::User()->name,
          'rec_dateupdate' => Carbon::now()->toDateTimeString()
      ]);

      $rating = new tr_review_empperiod_basic_reviewer();
      $rating->Tr_Review_EmpPeriod_Basic_Reviewer_Code = $request->Ms_Emp_Code . '-' .$tahunSaatIni.$request->ms_periode. '-'.'BASIC'.'-'. Auth::User()->name;
      $rating->DateReviewBasic                         = $newdatetime;
      $rating->Tr_Review_EmpPeriod_Code_h              = $id;
      $rating->Ms_Reviewer_Code        = Auth::User()->name;
      $rating->Trust_value             = $request->trust_value;
      $rating->trust_comment           = $request->trust_comment;
      $rating->trust_suggestion        = $request->trust_suggestion;
      $rating->TrustHigh               = $request->TrustHigh;
      $rating->TrustLow                = $request->TrustLow;
      $rating->drive_value             = $request->drive_value;
      $rating->drive_comment           = $request->drive_comment;
      $rating->drive_suggestion        = $request->drive_suggestion;
      $rating->DriveHigh               = $request->DriveHigh;
      $rating->DriveLow                = $request->DriveLow;
      $rating->inisiative_value        = $request->initiative_value;
      $rating->inisiatif_comment       = $request->inisiatif_comment;
      $rating->inisiative_suggestion   = $request->inisiative_suggestion;
      $rating->InisiativeHigh          = $request->InisiativeHigh;
      $rating->InisitativeLow          = $request->InisitativeLow;
      $rating->Reliable_value          = $request->reliable_value;
      $rating->reliable_comment        = $request->reliable_comment;
      $rating->Reliable_suggestion     = $request->Reliable_suggestion;
      $rating->ReliableHigh            = $request->ReliableHigh;
      $rating->ReliableLow             = $request->ReliableLow;
      $rating->result                  = $request->result;
      $rating->result_comment          = $request->result_comment;
      $rating->result_suggestion       = $request->result_suggestion;
      $rating->ResultHigh              = $request->ResultHighs;
      $rating->ResultLow               = $request->ResultLows;
      $rating->save();

      $timestamp = Carbon::now()->timestamp;

    foreach ($request['TaskDesc'] as $key => $item_id) {
      // Menggunakan loop untuk memastikan keunikan setiap entri
      do {
          // Menambahkan nilai acak
          $randomValue = mt_rand(100, 999);
          // Menggabungkan timestamp, nilai acak, dan nama pengguna
          $autoNumber = 'TASK' . '-' . Auth::user()->name . $timestamp . $randomValue;
          // Memastikan bahwa nomor otomatis tersebut belum ada dalam database
          $isUnique = !DB::table('Tr_Review_EmpPeriod_Task_Reviewer')
              ->where('Tr_Review_EmpPeriod_Task_Reviewer_Code', $autoNumber)
              ->exists();
      }
      while (!$isUnique);
              $tugasnya = new tr_review_empperiod_task_reviewer();
              $tugasnya->Tr_Review_EmpPeriod_Task_Reviewer_Code  = $autoNumber;
              $tugasnya->Tr_Review_EmpPeriod_Code_h              = $id;
              $tugasnya->TaskDesc                                = $request['TaskDesc'][$key];
              $tugasnya->DateTask                                = $request['DateTask'][$key];
              $tugasnya->Ms_Reviewer_Code                        = Auth::User()->name;
              $tugasnya->Ms_Task_Status                          = $request['Ms_Task_Status'][$key];
              $tugasnya->ResultDesc                              = $request['ResultDesc'][$key];
              $tugasnya->ResultHigh                              = $request['ResultHigh'][$key];
              $tugasnya->ResultLow                               = $request['ResultLow'][$key];
              $tugasnya->Quality                                 = $request['Quality'][$key];
              $tugasnya->Solutif                                 = $request['Solutif'][$key];
              $tugasnya->Inisiatif                               = $request['Inisiatif'][$key];
              $tugasnya->Tuntas                                  = $request['Tuntas'][$key];
              $tugasnya->Kualitas                                = 0;
              $tugasnya->Kecepatan                               = $request['Kecepatan'][$key];
              $tugasnya->Update                                  = $request['Update'][$key];
              $tugasnya->Hasil                                   = $request['Hasil'][$key];
              $tugasnya->Konsisten                               = $request['Konsisten'][$key];
              $tugasnya->Tanggap                                 = $request['Tanggap'][$key];
              if( Auth::User()->ms_divisi ='BOD')
              {
                $tugasnya->Suggest_BOD                             = $request['SugestReviewer'][$key];
              }
              else if ( Auth::User()->ms_divisi ='General Manager' || Auth::User()->ms_divisi ='Manager Operasional' || Auth::User()->ms_divisi ='Manager Finance')
              {
                $tugasnya->SuggestMgt                             = $request['SugestReviewer'][$key];
              }
              else
              {
                $tugasnya->SugestReviewer                          = $request['SugestReviewer'][$key];
              }
              $tugasnya->save();
          }
      Session::flash('warning', 'Assessment Berhasil DiUpadate.');
      return view('asasmen.sukses');
  }
  public function employee_create(Request $request)
  {
      $periode= DB::connection('mysql')->select("
      select * from ms_periode_assessment where rec_status ='1'
      ");
      $user = auth()->user();
      $employee = MasterEmployee::all();
      $operators = MasterEmployee::where('emp_name', '=', $user->username)->first();
      $ms_divisi = MsDivisi::all();

      $ms_rating_basic= DB::connection('mysql')->select("
      select * from ms_rating_asasmen_basic where rec_status ='1'
      ");

      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      order by created_at desc
      LIMIT 1
      ");
      $code_asas='ASSMN'.'-'. date('Ydm').'-0001';
      $max_emp_code = DB::connection('mysql')->select("
      SELECT
      Tr_Emp_Asses_Code
      FROM tr_emp_assesment
      order by id desc
      LIMIT 1
      ");

      foreach($max_emp_code as $row)
      {
        $kalimat = $row->Tr_Emp_Asses_Code;
        $sort_num = (int) substr($kalimat,-4,4);
        $sort_num++;
        $new_code = sprintf("%04s", $sort_num);
        $code_asas='ASSMN'.'-'. date('Ydm').'-'. $new_code;
      }

      $last_id4 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_emp_assesment
      where Ms_Emp_Code  ='".$operators."'
      ");

        return view('asasmen.asasmen_employs', compact('periode','user', 'operators', 'employee', 'ms_divisi','ms_rating_basic', 'code_asas'));
    }
    public function print_history_basic( Request $request, $id)
    {

      $mains= DB::connection('mysql')->select("
      select  * from Tr_Review_EmpPeriod_h
      where Tr_Review_EmpPeriod_Code_h ='$id'
      order by created_at desc ");

      $heading= DB::connection('mysql')->select("
      select DISTINCT
          hasil.Tr_Review_EmpPeriod_Basic_Reviewer_Code,
          main.Tr_Review_EmpPeriod_Code_h,
          main.created_at,
          main.Ms_Emp_Code,
          main.Ms_Emp_Div,
          hasil.Ms_Reviewer_Code,
          hasil.Trust_value,
          hasil.trust_comment,
          hasil.trust_suggestion,
          hasil.TrustHigh,
          hasil.TrustLow,
          hasil.drive_value,
          hasil.drive_comment,
          hasil.drive_suggestion,
          hasil.DriveHigh,
          hasil.DriveLow,
          hasil.inisiative_value,
          hasil.inisiatif_comment,
          hasil.inisiative_suggestion,
          hasil.InisiativeHigh,
          hasil.InisitativeLow,
          hasil.Reliable_value,
          hasil.reliable_comment,
          hasil.Reliable_suggestion,
          hasil.ReliableHigh,
          hasil.ReliableLow,
          hasil.result,
          hasil.result_comment,
          hasil.result_suggestion,
          hasil.ResultHigh,
          hasil.ResultLow

          from Tr_Review_EmpPeriod_h main
          left join users user on main.rec_usercreated = user.name
          left join master_employees emp on main.Ms_Emp_Code = emp.emp_name
          left join Tr_Review_EmpPeriod_Basic_Reviewer hasil on main.Tr_Review_EmpPeriod_Code_h = hasil.Tr_Review_EmpPeriod_Code_h
          where main.Tr_Review_EmpPeriod_Code_h  ='$id'
          order by main.created_at asc");

          $tugas= DB::connection('mysql')->select("
          select DISTINCT
          tugasnya.Tr_Review_EmpPeriod_Task_Reviewer_Code,
          tugasnya.TaskDesc,
          tugasnya.DateTask,
          tugasnya.Ms_Reviewer_Code,
          tugasnya.ResultDesc,
          tugasnya.ResultHigh,
          tugasnya.ResultLow,
          tugasnya.SugestReviewer,
          tugasnya.SuggestMgt,
          tugasnya.Suggest_BOD,
          tugasnya.Ms_Task_Status,
          tugasnya.Quality,
          tugasnya.Solutif,
          tugasnya.Inisiatif,
          tugasnya.Tuntas,
          tugasnya.Kualitas,
          tugasnya.Kecepatan,
          tugasnya.Update,
          tugasnya.Hasil,
          tugasnya.Konsisten,
          tugasnya.Tanggap

          from Tr_Review_EmpPeriod_h header
          left join Tr_Review_EmpPeriod_Task_Reviewer tugasnya on tugasnya.Tr_Review_EmpPeriod_Code_h = header.Tr_Review_EmpPeriod_Code_h
          where header.Tr_Review_EmpPeriod_Code_h ='$id'
          order by header.created_at asc");

        return view('asasmen.print_asasmen', compact ('mains','heading','tugas'));
    }
}
