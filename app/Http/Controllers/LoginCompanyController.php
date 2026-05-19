<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Createtr_candidateRequest;
use App\Http\Requests\Updatetr_candidateRequest;
use App\Repositories\tr_candidateRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\candidate_detail;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\logincompany;
use App\Models\PostLoker;
use App\Models\tr_shortlist_tracking;
use App\Models\Tr_candidate_header;
use App\Models\tr_candidate;
use App\Models\Pendidikan;
use App\Models\Pengalaman;
use App\Models\Organisasi;
use App\Models\Skill;
use App\Models\SocialMedia;
use App\Models\Photos;
use App\Models\Keluarga;
use App\Models\CurriculumVitae;
use App\Models\Dashboard_belum_shortlist;
use App\Models\DashboardAllCandidates;
use App\Models\Ms_Status_Short;
use App\Models\tr_import_data;
use App\Models\tr_candidate_jobportal;
use App\Models\InterviewHRD;
use App\Models\ms_kode_interview;
use App\Models\InterviewUser;


use Redirect;
use Flash;
use Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginCompanyController extends Controller
{
    public function editstatus(Request $request, $id)
    {
        // dd($id);die;
        $user = Auth::user();
        $master_short = Ms_Status_Short::all();
        $kandidat = DB::connection('mysql')->select("
        SELECT * from tr_candidate where Email ='$id'
        ");
        //$kandidat = tr_candidate::where('Email', $id);
        // dd($kandidat);die;
        return view ('tr_candidates.edit_status', compact('user', 'master_short','kandidat'));
    }

    public function update_status(Request $request)
    {
        $save_tracking = new tr_shortlist_tracking();
        $save_tracking->rec_usercreated = $request->rec_usercreated;
        $save_tracking->rec_datecreated = Carbon::now()->toDateTimeString();
        $save_tracking->rec_status      = 1;
        $save_tracking->tracking_code   = '';
        $save_tracking->ms_status_short = $request->ms_status_short;
        $save_tracking->kandidat        = $request->kandidat;
        $save_tracking->no_hp           = $request->no_hp;
        $save_tracking->email           = $request->email;

        $save_tracking->save();

        $update_status = tr_candidate::where('Email', $save_tracking->email )
        ->update([
            'ms_short_status' => $request->ms_status_short,
            'PICShortlist' => $request->rec_usercreated,
            'DateShorlist' => Carbon::now()->toDateTimeString()
        ]);

        $update_status = tr_import_data::where('email', $save_tracking->email )
        ->update([
            'shortlisted' => 'Done'
        ]);


        $user = Auth::user();
        $master_short = Ms_Status_Short::all();
        $call = DB::connection('mysql')->select("
          SELECT
           kandidat.Name as Name,
           kandidat.Ktp  as Ktp,
           kandidat.domisili as domisili,
           kandidat.Birthdate, (YEAR(CURDATE())-YEAR(Birthdate)) AS umur,
           kandidat.status as status,
           kandidat.jenis_kelamin as jenis_kelamin,
           kandidat.agama as agama,
           kandidat.Handphone as Handphone,
           kandidat.Email as Email,
           kandidat.pengajuan_gaji as pengajuan_gaji,
           kandidat.Info_lowongan as Info_lowongan,
           kandidat.Position_aplly1 as Position_aplly1,
           kandidat.created_at as created_at,
           pengalaman.Perusahaan as Perusahaan,
           kandidat.PICShortlist as PICShortlist,
           kandidat.CekShorlist as CekShorlist,
           kandidat.CekCV as CekCV,
           kandidat.status_shortlist as status_shortlist,
           kandidat.ms_short_status as ms_short_status

           FROM tr_candidate kandidat LEFT JOIN
           candidate_pengalaman pengalaman on kandidat.Ktp = pengalaman.Ktp
           WHERE  kandidat.rec_status ='1';

          ");
        return view('tr_candidates.all_candidates', compact('user','call', 'master_short'));
    }
    public function index_company()
    {
        return view ('loker_company.indexcompany');
    }
    public function loginformcompany()
    {
        return view('loker_company.homecompany');
    }
    public function logincompany()
    {
        return view('loker_company.homecompany');
    }
    public function homecandidat()
    {
        return view('loker_company.kandidat');
    }
    public function kandidat_all()
    {

        $user = Auth::user();
        $master_short = Ms_Status_Short::all();

        $call = DB::connection('mysql')->select("


        SELECT

        kandidat.Name as Name,
        kandidat.Ktp  as Ktp,
        kandidat.domisili as domisili,
        kandidat.Birthdate, (YEAR(CURDATE())-YEAR(Birthdate)) AS umur,
        kandidat.status as status,
        kandidat.jenis_kelamin as jenis_kelamin,
        kandidat.agama as agama,
        kandidat.Handphone as Handphone,
        kandidat.Email as Email,
        kandidat.pengajuan_gaji as pengajuan_gaji,
        kandidat.Info_lowongan as Info_lowongan,
        kandidat.Position_aplly1 as Position_aplly1,
        kandidat.created_at as created_at,
        pengalaman.Perusahaan as Perusahaan,
        kandidat.PICShortlist as PICShortlist,
        kandidat.CekShorlist as CekShorlist,
        kandidat.CekCV as CekCV,
        kandidat.status_shortlist as status_shortlist,
        kandidat.ms_short_status as ms_short_status

        FROM tr_candidate kandidat LEFT JOIN
        candidate_pengalaman pengalaman on kandidat.Ktp = pengalaman.Ktp
        WHERE  kandidat.rec_status ='1' and CekCV ='Software HRD'

          ");

        return view('tr_candidates.all_candidates', compact('user','call', 'master_short'));

    }
    public function kandidat_all_jobportal()
    {

        $user = Auth::user();
        $master_short = Ms_Status_Short::all();

        $call = DB::connection('mysql')->select("


        SELECT

        kandidat.Name as Name,
        kandidat.Ktp  as Ktp,
        kandidat.domisili as domisili,
        kandidat.Birthdate, (YEAR(CURDATE())-YEAR(Birthdate)) AS umur,
        kandidat.status as status,
        kandidat.jenis_kelamin as jenis_kelamin,
        kandidat.agama as agama,
        kandidat.Handphone as Handphone,
        kandidat.Email as Email,
        kandidat.pengajuan_gaji as pengajuan_gaji,
        kandidat.Info_lowongan as Info_lowongan,
        kandidat.Position_aplly1 as Position_aplly1,
        kandidat.created_at as created_at,
        pengalaman.Perusahaan as Perusahaan,
        kandidat.PICShortlist as PICShortlist,
        kandidat.CekShorlist as CekShorlist,
        kandidat.CekCV as CekCV,
        kandidat.status_shortlist as status_shortlist,
        kandidat.ms_short_status as ms_short_status

        FROM tr_candidate_jobportal kandidat LEFT JOIN
        candidate_pengalaman pengalaman on kandidat.Ktp = pengalaman.Ktp
        WHERE  kandidat.rec_status ='1' and CekCV !='Software HRD'

          ");

        return view('tr_candidates.all_candidates_jobportal', compact('user','call', 'master_short'));

    }

    public function kandidat_belum()
    {

        $user = Auth::user();
        $call = DB::connection('mysql')->select("
        SELECT

           kandidat.Name as Name,
           kandidat.Ktp  as Ktp,
           kandidat.domisili as domisili,
           kandidat.Birthdate, (YEAR(CURDATE())-YEAR(Birthdate)) AS umur,
           kandidat.status as status,
           kandidat.jenis_kelamin as jenis_kelamin,
           kandidat.agama as agama,
           kandidat.Handphone as Handphone,
           kandidat.Email as Email,
           kandidat.pengajuan_gaji as pengajuan_gaji,
           kandidat.Info_lowongan as Info_lowongan,
           kandidat.Position_aplly1 as Position_aplly1,
           kandidat.created_at as created_at,
           pengalaman.Perusahaan as Perusahaan,
           kandidat.PICShortlist as PICShortlist,
           kandidat.CekShorlist as CekShorlist,
           kandidat.CekCV as CekCV,
           kandidat.status_shortlist as status_shortlist

           FROM tr_candidate kandidat LEFT JOIN
           candidate_pengalaman pengalaman on kandidat.Ktp = pengalaman.Ktp
           WHERE kandidat.ms_short_status='' and kandidat.rec_status ='1' and CekCV ='Software HRD';


        ");
        // $call =  Dashboard_belum_shortlist::all();
        return view('tr_candidates.kandidat_belum_short', compact('user','call'));

    }

    public function kandidat_lolos_shortlist()
    {

        $user = Auth::user();
        // $call = tr_candidate::where('status_shortlist', '=', 1,)->orderByDesc('created_at', 'desc')->get();
        $call = tr_candidate::select('*')
                ->where('status_shortlist', '=', 1)
                ->where('CekCall', '=', null)
                ->where('CekInterview', '=', null)
                ->get();

        return view('tr_candidates.kandidat_lolos_short', compact('user','call'));

    }
    public function detail_kandidat_lolos_shortlist (Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        return view('detail_kandidat.detail_kandidat_lolos_short', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));
    }
    public function kandidat_gagal_shortlist()
    {

        $user = Auth::user();
        $call = tr_candidate::where('status_shortlist', '=', 2,)->orderByDesc('created_at', 'desc')->get();

        return view('tr_candidates.kandidat_gagal_short', compact('user','call'));

    }
    public function detail_kandidat_gagal_shortlist (Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Ktp', '=', $id)->first();
        // dd($header);die;
        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        return view('detail_kandidat.detail_kandidat_gagal_short', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));
    }

    public function kandidat_belum_dihubungi()
    {
        $user = Auth::user();
        // $call = tr_candidate::all();
        // $call = tr_candidate::select('*')
        // ->where('CekShorlist', '=', 1)
        // ->where('status_shortlist', '=', 1)
        // ->where('Cek_Sambung', '=', null)
        // ->where('CekCall', '=', null)
        // ->where('CekInterview', '=', null)
        // ->where('CekCV', '=', 'Software HRD')
        // ->get();
        $call = DB::connection('mysql')->select("
          select   * 
            from tr_candidate 
            where CekShorlist ='1' and status_shortlist ='1' and Cek_Sambung is null and CekCall is null  and CekInterview is null 
            order by updated_at desc
            LIMIT 100
            ;
          ");

        return view('tr_candidates.kandidat_belum_dihubungi', compact('user','call'));

    }

    public function kandidat_belum_dihubungi_jobportal()
    {
      $user = Auth::user();
      $call = DB::connection('mysql')->select("
      SELECT * FROM tr_candidate_jobportal
      WHERE CekShorlist ='1' and status_shortlist ='1' and Cek_Sambung is null and CekCall is null and CekInterview is null;
      ");


        // $call = tr_candidate::all();
        // $call = tr_candidate::select('*')
        // ->where('CekShorlist', '=', 1)
        // ->where('status_shortlist', '=', 1)
        // ->where('Cek_Sambung', '=', null)
        // ->where('CekCall', '=', null)
        // ->where('CekInterview', '=', null)
        // ->get();

        // dd($call);die;

        return view('tr_candidates.kandidat_belum_dihubungi_jobportal', compact('user','call'));

    }
    public function detail_kandidat_belum_dihubungi(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();

        $jadwals = DB::connection('mysql')->select("
        select
        Date_int,
        Time_int,
        Interviewer,
        Lokasi,
        Ms_Candidate_Code,
        Int_model
        from
        tr_candidate kandidat_main
        left JOIN tr_int_sched skejul on kandidat_main.Name = skejul.Ms_candidate_code
        where kandidat_main.CekInterview is null and skejul.Ms_Candidate_Code is not null
        order by skejul.created_at desc
        ");
        if(!isset($cv) || $cv == null){
            $cv = "";
        }

        return view('detail_kandidat.detail_kandidat_belum_dihubungi', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv', 'jadwals'));

    }

    public function detail_kandidat_belum_dihubungi_jobportal(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate_jobportal::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();

        $jadwals = DB::connection('mysql')->select("
        select
        Date_int,
        Time_int,
        Interviewer,
        Lokasi,
        Ms_Candidate_Code,
        Int_model
        from
        tr_candidate kandidat_main
        left JOIN tr_int_sched skejul on kandidat_main.Name = skejul.Ms_candidate_code
        where kandidat_main.CekInterview is null and skejul.Ms_Candidate_Code is not null
        order by skejul.created_at desc
        ");
        if(!isset($cv) || $cv == null){
            $cv = "";
        }

        return view('detail_kandidat.detail_kandidat_belum_dihubungi_jobportal', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv', 'jadwals'));

    }
    public function kandidat_tidak_terhubung()
    {

        $user = Auth::user();
        $call = tr_candidate::where('Cek_Sambung', '=', 0,)->orderByDesc('created_at', 'desc')->get();

        return view('tr_candidates.kandidat_tidak_dapat_dihubungi', compact('user','call'));

    }
    public function kandidat_terhubung()
    {

        $user = Auth::user();
        $call = tr_candidate::select('*')
        ->where('Cek_Sambung', '=', 2)
        ->where('CekInterview', '=', null)
        ->get();
        return view('tr_candidates.kandidat_dapat_dihubungi', compact('user','call'));

    }
    public function detail_kandidat_terhubung(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->id)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->id)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->id)->first();
        $skill_det = Skill::where('Ktp','=', $header->id)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->id)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->id)->first();
        $poto = Photos::where('Ktp','=', $header->id)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->id)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }

        return view('detail_kandidat.detail_kandidat_terhubung', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));

    }
    public function detail_kandidat_tidak_terhubung(Request $request, $id)
    {
       // $user = auth()->user();
        $user = auth()->user();
        // print ($user->name);
        $divisi = $user->divisi;
        // $divisi = $user->divisi;
        // dd($divisi);die;

        $header  = Tr_candidate_header::where('Ktp', '=', $id)->first();
        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        // $pengalaman_det2 = Pengalaman2::where('Ktp','=', $header->Ktp)->first();
        // $pengalaman_det3 = Pengalaman3::where('Ktp','=', $header->Ktp)->first();

        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        // $organisasi_det2 = Organisasi2::where('Ktp', '=', $header->Ktp)->first();

        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        // $skill_det2 = Skill2::where('Ktp','=', $header->Ktp)->first();

        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        // $sosmed_det2 = SocialMedia2::where('Ktp', '=', $header->Ktp)->first();

        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        // $keluarga2 = Keluarga2::where('Ktp', '=', $header->Ktp)->first();

        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        if(!isset($poto) || $poto == null){
            $poto = "";
        }
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        // dd($keluarga->Ktp);die;

        return view('detail_kandidat.detail_kandidat_tidak_terhubung', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));

    }
    public function kandidat_belum_interview()
    {
        $user = Auth::user();
        $call = tr_candidate::select('*')
        ->where('CekShorlist', '=', 1)
        ->where('CekCall', '=', 1)
        ->where('Cek_Sambung', '=', 'Terhubung')
        ->where('CekInterview', '=', null)
        ->where('CekCV', '=', 'Software HRD')
        ->get();
        return view('tr_candidates.kandidat_belum_interview', compact('user','call'));

    }
    public function kandidat_belum_interview_jobportal()
    {
        $user = Auth::user();
        $call = tr_candidate_jobportal::select('*')
        ->where('CekShorlist', '=', 1)
        ->where('CekCall', '=', 1)
        ->where('Cek_Sambung', '=', 'Terhubung')
        ->where('CekInterview', '=', null)
        ->get();
        return view('tr_candidates.kandidat_belum_interview_jobportal', compact('user','call'));

    }
    public function detail_kandidat_belum_interview(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        $ms_kode_interview = ms_kode_interview::all();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }

        return view('detail_kandidat.detail_kandidat_belum_interview', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv', 'ms_kode_interview'));

    }
    public function detail_kandidat_belum_interview_jobportal(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate_jobportal::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }

        return view('detail_kandidat.detail_kandidat_belum_interview_jobportal', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));

    }
    
    public function kandidat_belum_interview2()
    {
        $user = Auth::user();
        $kandidat = tr_candidate::select('*')
        ->where('CekShorlist', '=', 1)
        ->where('CekCall', '=', 1)
        ->where('Cek_Sambung', '=', 'Terhubung')
        ->where('CekInterview', '=', 1)
        ->where('ms_kode_interview1', '!=', null)
        ->where('ms_kode_interview2', '=', null)
        ->get();
        // dd($kandidat);die;
        return view('tr_candidates.kandidat_belum_interview2', compact('user','kandidat'));

    }
    public function detail_kandidat_belum_interview2(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->username;
        $header = tr_candidate::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $interview1 = InterviewHRD::where('Tr_report_hrd_main_code', '=', $header->Tr_report_hrd_main_code)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
         $ms_kode_interview = ms_kode_interview::all();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        // dd($interview1);die;
        return view('detail_kandidat.detail_kandidat_belum_interview2', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv', 'interview1',  'ms_kode_interview'));

    }
     public function kandidat_belum_interview3()
    {
        $user = Auth::user();
        $kandidat = tr_candidate::select('*')
        ->where('CekShorlist', '=', 1)
        ->where('CekCall', '=', 1)
        ->where('Cek_Sambung', '=', 'Terhubung')
        ->where('CekInterview', '=', 1)
        ->where('ms_kode_interview1', '!=', null)
        ->where('ms_kode_interview2', '!=', null)
        ->where('ms_kode_interview3', '=', null)
        ->get();
        // dd($kandidat);die;
        return view('tr_candidates.kandidat_belum_interview3', compact('user','kandidat'));

    }
    public function detail_kandidat_belum_interview3(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->username;
        $header = tr_candidate::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $interview1 = InterviewHRD::where('Tr_report_hrd_main_code', '=', $header->Tr_report_hrd_main_code)->first();
        $interview2 = InterviewUser::where('Tr_report_hrd_main_code', '=', $header->Tr_report_hrd_main_code)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        $ms_kode_interview = ms_kode_interview::all();
        // dd($interview2);die;
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        // dd($interview1);die;
        return view('detail_kandidat.detail_kandidat_belum_interview3', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv', 'interview1', 'interview2', 'ms_kode_interview'));

    }
    
    public function kandidat_lolos_interview()
    {
        // $user = Auth::user();
        // $call = tr_candidate::where('status_interview', '=', 1,)->orderByDesc('created_at', 'desc')->get();

        $user = Auth::user();
        $call = tr_candidate::select('*')
        ->where('CekShorlist', '=', 1)
        ->where('CekCall', '=', 1)
        ->where('CekInterview', '=', 1)
        ->where('status_interview', '=', 'Lulus')
        ->get();

        return view('tr_candidates.kandidat_lolos_interview', compact('user','call'));

    }
    public function detail_kandidat_lolos_interview(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Ktp', '=', $id)->first();

        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }

        return view('detail_kandidat.detail_kandidat_lolos_interview', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));

    }
    public function kandidat_tidak_lolos_interview()
    {
        $user = Auth::user();
        $call = tr_candidate::select('*')
        ->where('CekShorlist', '=', 1)
        ->where('CekCall', '=', 1)
        ->where('CekInterview', '=', 1)
        ->where('status_interview', '=', 'Tidak Lulus')
        ->where('ms_kode_interview1', '=', 'Tidak Lulus')
        ->get();

        return view('tr_candidates.kandidat_tidak_lolos_interview', compact('user','call'));

    }
    public function detail_kandidat_tidak_lolos_interview(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Ktp', '=', $id)->first();
        // dd($id);die;
        $pendidikan_det = Pendidikan::where('Ktp','=', $id)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $id)->first();
        $organisasi_det = Organisasi::where('Ktp', '=', $id)->first();
        $skill_det = Skill::where('Ktp','=', $id)->first();
        $sosmed_det = SocialMedia::where('Ktp', '=', $id)->first();
        $keluarga = Keluarga::where('Ktp', '=', $id)->first();
        $poto = Photos::where('Ktp','=', $id)->first();
        $cv = CurriculumVitae::where('Ktp','=', $id)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }

        return view('detail_kandidat.detail_kandidat_tidak_lolos_interview', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));

    }

    public function save_login(Request $request)
    {
        $last_code = DB::connection('mysql')->select("
        SELECT
        Tr_Lowongan_Code
        FROM tr_lowongan_main
        order by created_at desc
        LIMIT 1
        ");
        // dd($last_code);die;
        $last_date = DB::connection('mysql')->select("
        SELECT
        created_at
        FROM tr_lowongan_main
        order by created_at desc
        LIMIT 1
        ");
        // dd($last_date);die;
        $todayDate = date('Y-m-d');
        foreach($last_code as $codes)
        { $kode = $codes->Tr_Lowongan_Code;}
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

        $ambilkode=PostLoker::where($request->Tr_Lowongan_Code)->get();
        $nambah=count($ambilkode)+1;
        if ($nambah <20)
        {
            $Tr_Lowongan_Code='Loker'. '-'. date('Ydm').'-'."00".$nambah;
        }

        $unTuksave = new PostLoker();
        $unTuksave->Tr_Lowongan_Code        = $Tr_Lowongan_Code;
        $unTuksave->Ms_Company_code         = $request->Ms_Company_code;
        $unTuksave->PosisiDesc              = $request->PosisiDesc;
        $unTuksave->Date_Lowongan           = $request->Date_Lowongan;
        $unTuksave->Date_Expired            = $request->Date_Expired;
        $unTuksave->Posisi                  = $request->Posisi;
        $unTuksave->SendTo                  = $request->SendTo;
        $unTuksave->EmailTo                 = $request->EmailTo;
        $unTuksave->RequirementDesc         = $request->RequirementDesc;
        // dd($unTuksave);die;

        $unTuksave->save();
        return view('home');
    }
    public function update_candidate_by_email(Request $request, $id)
    {
      $selectedId = $request->input('status_shortlist');
      dd($selectedId);die;
      $user = auth()->user();
      //  dd($request->status_shortlist);die;
      $update_status = tr_candidate::where('Email', $id)
      ->update([
          'ms_short_status' => $request->status_shortlist,
          'PICShortlist' => $user->username,
          'DateShorlist' => Carbon::now()->toDateTimeString()
      ]);

    }
}
