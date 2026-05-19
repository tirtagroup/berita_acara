<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createtr_candidateRequest;
use App\Http\Requests\Updatetr_candidateRequest;
use App\Repositories\tr_candidateRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\candidate_detail;
use App\Models\Tr_candidate_header;
use App\Models\tr_candidate;
use App\Models\Pendidikan;
use App\Models\Pengalaman;
use App\Models\Pengalaman2;
use App\Models\Pengalaman3;
use App\Models\Organisasi;
use App\Models\Organisasi2;
use App\Models\Skill;
use App\Models\Skill2;
use App\Models\SocialMedia;
use App\Models\SocialMedia2;
use App\Models\Photos;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\Keluarga;
use App\Models\Keluarga2;
use App\Models\Login;
use App\Models\CurriculumVitae;
use App\Models\Main_reportHRD;
use App\Models\Tr_Call_H;
use App\Models\CallHRD;
use App\Models\InterviewHRD;
use App\Models\tr_import_data;
use App\Models\Jadwal_Interview;
use App\Models\tr_candidate_jobportal;
use App\Models\InterviewUser;
use Redirect;
use Flash;
use Response;
use DB;
use Carbon\Carbon;
use App\Exports\ExportKandidat;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class tr_candidateController extends Controller
{
    public function index_cv()
    {
      return view('tr_candidates.candidate_apply');
    }

    public function store_cv(Request $request)
    {
      $update_import = tr_import_data::where('email', $request->Email)
        ->update([
            'shortlisted' => "Done"
        ]);

      $last_id = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_report_hrd_main
      order by created_at desc
      LIMIT 1
      ");
      foreach($last_id as $asas)
      { $idnya = $asas->id;}

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
          $Tr_report_hrd_main_code='MAINHRD'. '-'. date('Ydm').'-'."00".$idnya;
      }
      // dd($Tr_report_hrd_main_code);die;

      $main_report_hrd = new Main_reportHRD();
      $main_report_hrd->Tr_report_hrd_main_code = $Tr_report_hrd_main_code;
      $main_report_hrd->Ms_ReportType_Code      = 'CV Candidate';
      $main_report_hrd->posisi1                 = $request->Position_aplly1;
      $main_report_hrd->posisi2                 = $request->Position_aplly2;
      $main_report_hrd->save();

        $candidate_header = new tr_candidate();
        $candidate_header->Tr_report_hrd_main_code = $main_report_hrd->Tr_report_hrd_main_code;
        $candidate_header->Name = $request->Name;
        $candidate_header->Ktp = $request->Ktp;
        $candidate_header->domisili = $request->domisili;
        $candidate_header->CityBirth = $request->CityBirth;
        $candidate_header->Birthdate = $request->Birthdate;
        $candidate_header->status = $request->status;
        $candidate_header->jenis_kelamin = $request->jenis_kelamin;
        $candidate_header->agama = $request->agama;
        $candidate_header->Handphone = $request->Handphone;
        $candidate_header->Email = $request->Email;
        $candidate_header->pengajuan_gaji = $request->pengajuan_gaji;
        $candidate_header->info_lowongan = $request->info_lowongan;
        $candidate_header->Position_aplly1 = $request->Position_aplly1;
        $candidate_header->ketersediaan = $request->ketersediaan;
        $candidate_header->layak = $request->layak;
        $candidate_header->patner = $request->patner;
        $candidate_header->Position_aplly2 = $request->Position_aplly2;
        $candidate_header->area_minat = $request->area_minat;
        $candidate_header->no_sim = $request->no_sim;
        $candidate_header->type_sim = $request->type_sim;
        $candidate_header->riwayat_penyakit = $request->riwayat_penyakit;
        $candidate_header->rec_status = '1';
        $candidate_header->CekCV = 'Software HRD';
        $candidate_header->CekShorlist =  '1';
        $candidate_header->status_shortlist =  '1';
        $candidate_header->CekCall =  '1';
        $candidate_header->Cek_Sambung =  'Terhubung';
        // $candidate_header->ms_short_status = "Shortlisted";
        // $candidate_header->status_shortlist = "1";
        // $candidate_header->alasan_shortlist = "OK";
        // $candidate_header->DateShorlist = Carbon::now()->toDateTimeString();
        // $candidate_header->PICShortlist = "HRD Pusat";
        // dd($candidate_header);die;
        $candidate_header->save();

        $pendidikan = new Pendidikan();
        $pendidikan->ktp = $request->Ktp;
        $pendidikan->jenjang = $request->jenjang;
        $pendidikan->sekolah = $request->sekolah;
        $pendidikan->jurusan = $request->jurusan;
        $pendidikan->tahunmasuk = $request->tahunmasuk;
        $pendidikan->tahunlulus = $request->tahunlulus;
        $pendidikan->alamat = $request->alamat;
        $pendidikan->ipk = $request->ipk;
        // dd($pendidikan);die;
        $pendidikan->save();

        $pengalaman = new Pengalaman();
        $pengalaman->Ktp = $request->Ktp;
        $pengalaman->Perusahaan = $request->Perusahaan;
        $pengalaman->Posisi = $request->Posisi;
        $pengalaman->Lama_kerja = $request->Lama_kerja;
        $pengalaman->Gaji = $request->Gaji;
        $pengalaman->No_hp = $request->No_hp;
        $pengalaman->alasan_keluar = $request->alasan_keluar;
        $pengalaman->komentar = $request->komentar;
        // dd($pengalaman);die;
        $pengalaman->save();

        $pengalaman2 = new Pengalaman2();
        $pengalaman2->Ktp = $request->Ktp;
        $pengalaman2->Perusahaan2 = $request->Perusahaan2;
        $pengalaman2->Posisi2 = $request->Posisi2;
        $pengalaman2->Lama_kerja2 = $request->Lama_kerja2;
        $pengalaman2->Gaji2 = $request->Gaji2;
        $pengalaman2->No_hp2 = $request->No_hp2;
        $pengalaman2->alasan_keluar2 = $request->alasan_keluar2;
        $pengalaman2->komentar2 = $request->komentar2;
        // dd($pengalaman2);die;
        $pengalaman2->save();

        $pengalaman3 = new Pengalaman3();
        $pengalaman3->Ktp = $request->Ktp;
        $pengalaman3->Perusahaan3 = $request->Perusahaan3;
        $pengalaman3->Posisi3 = $request->Posisi3;
        $pengalaman3->Lama_kerja3 = $request->Lama_kerja3;
        $pengalaman3->Gaji3 = $request->Gaji3;
        $pengalaman3->No_hp3 = $request->No_hp3;
        $pengalaman3->alasan_keluar3 = $request->alasan_keluar3;
        $pengalaman3->komentar3 = $request->komentar3;
        $pengalaman3->save();

        $organisasi = new Organisasi();
        $organisasi->Ktp = $request->Ktp;
        $organisasi->Nama_organisasi = $request->Nama_organisasi;
        $organisasi->Jabatan = $request->Jabatan;
        $organisasi->Periode = $request->Periode;
        $organisasi->save();

        $organisasi2 = new Organisasi2();
        $organisasi2->Ktp = $request->Ktp;
        $organisasi2->Nama_organisasi2 = $request->Nama_organisasi2;
        $organisasi2->Jabatan2 = $request->Jabatan2;
        $organisasi2->Periode2 = $request->Periode2;
        $organisasi2->save();

        $skill = new Skill();
        $skill->Ktp = $request->Ktp;
        $skill->Skill = $request->Skill;
        $skill->tingkat = $request->tingkat;
        $skill->sertifikasi = $request->sertifikasi;
        $skill->siap_tes = $request->siap_tes;
        $skill->save();

        $skill2 = new Skill2();
        $skill2->Ktp = $request->Ktp;
        $skill2->Skill2 = $request->Skill2;
        $skill2->tingkat2 = $request->tingkat2;
        $skill2->sertifikasi2 = $request->sertifikasi2;
        $skill2->siap_tes2 = $request->siap_tes2;
        $skill2->save();

        $sosmeds = new SocialMedia();
        $sosmeds->Ktp = $request->Ktp;
        $sosmeds->sosmed = $request->sosmed;
        $sosmeds->nickname = $request->nickname;
        $sosmeds->save();

        $sosmeds2 = new SocialMedia2();
        $sosmeds2->Ktp = $request->Ktp;
        $sosmeds2->sosmed2 = $request->sosmed2;
        $sosmeds2->nickname2 = $request->nickname2;
        $sosmeds2->save();

        $keluarga = new Keluarga();
        $keluarga->Ktp = $request->Ktp;
        $keluarga->hubungan = $request->hubungan;
        $keluarga->namanya = $request->namanya;
        $keluarga->pendidikan = $request->pendidikan;
        $keluarga->pekerjaan = $request->pekerjaan;
        $keluarga->tempat = $request->tempat;
        $keluarga->save();

        $keluarga2 = new Keluarga2();
        $keluarga2->Ktp = $request->Ktp;
        $keluarga2->hubungan2 = $request->hubungan2;
        $keluarga2->namanya2 = $request->namanya2;
        $keluarga2->pendidikan2 = $request->pendidikan2;
        $keluarga2->pekerjaan2 = $request->pekerjaan2;
        $keluarga2->tempat2 = $request->tempat2;
        // dd($keluarga2);die;
        $keluarga2->save();

        $photonya = new Photos();
        $photonya->id_tr_candidate = $candidate_header->id;
        $photonya->Ktp = $request->Ktp;

        if($request->file('file_path'))
        {
            $file= $request->file('file_path');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $photonya->file_path = 'upload/' . $filename;
        }
        // dd($photonya);die;
        $photonya->save();

        $cvnya = new CurriculumVitae();
        $cvnya->id_tr_candidate = $candidate_header->id;
        $cvnya->Ktp = $request->Ktp;

        if($request->file('file_cv'))
        {
            $file= $request->file('file_cv');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $cvnya->file_cv = 'upload/' . $filename;
        }
        // dd($cvnya);die;
        $cvnya->save();

        $header = array(
            'Name'             =>   $request->Name,
            'Ktp'              =>   $request->Ktp,
            'domisili'         =>   $request->domisili,
            'CityBirth'        =>   $request->CityBirth,
            'Birthdate'        =>   $request->Birthdate,
            'status'           =>   $request->status,
            'jenis_kelamin'    =>   $request->jenis_kelamin,
            'agama'            =>   $request->agama,
            'Handphone'        =>   $request->Handphone,
            'Email'            =>   $request->Email,
            'pengajuan_gaji'   =>   $request->pengajuan_gaji,
            'Position_aplly'   =>   $request->Position_aplly,
            'info_lowongan'    =>   $request->info_lowongan,
            'ketersediaan'     =>   $request->ketersediaan,
            'layak'            =>   $request->layak,
            'tanggal_ketesediaan' =>   $request->tanggal_ketesediaan,
            'tanggal'          =>   $request->tanggal,

            'sekolah'          =>  $request->sekolah,
            'tahunmasuk'       =>   $request->tahunmasuk,
            'tahunlulus'       =>   $request->tahunlulus,
            'alamat'           =>   $request->alamat,
            'ipk'              =>   $request->ipk,

            'Perusahaan'       =>   $request->Perusahaan,
            'Posisi'           =>   $request->Posisi,
            'Lama_kerja'       =>   $request->Lama_kerja,
            'Gaji'             =>   $request->Gaji,
            'No_hp'            =>   $request->No_hp,
            'alasan_keluar'    =>   $request->alasan_keluar,

            'Nama_organisasi'  =>   $request->Nama_organisasi,
            'Jabatan'          =>   $request->Jabatan,
            'Periode'          =>   $request->Periode,

            'Skill'            =>   $request->Skill,
            'tingkat'          =>   $request->tingkat,
            'siap_tes'         =>   $request->siap_tes,

            'sosmed'           =>   $request->sosmed,
            'nickname'         =>   $request->nickname,

            'hubungan'         =>   $request->hubungan,
            'namanya'          =>   $request->namanya,
            'pendidikan'       =>   $request->pendidikan,
            'pekerjaan'        =>   $request->pekerjaan,
            'tempat'           =>   $request->tempat
        );



        // Mail::to("hrd.pusat@hgs.co.id") ->cc(['pokenbir@gmail.com'])->send(new SendEmail($header));
        // Mail::to("muhamadaliridwan18@gmail.com") ->cc(['muhamadaliridwan18@yahoo.com'])->send(new SendEmail($header));
		    // return "Terimakasih, lamaran anda akan segera kami review. Tunggu kabar selanjutnya ya ";
        return view ('tr_candidates.terimakasih');
    }

    public function detail_belum_short (Request $request, $id)
    {
        $header  = Tr_candidate_header::where('Ktp', '=', $id)->first();
        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det2 = Pengalaman2::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det3 = Pengalaman3::where('Ktp','=', $header->Ktp)->first();

        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $organisasi_det2 = Organisasi2::where('Ktp', '=', $header->Ktp)->first();

        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $skill_det2 = Skill2::where('Ktp','=', $header->Ktp)->first();

        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $sosmed_det2 = SocialMedia2::where('Ktp', '=', $header->Ktp)->first();

        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $keluarga2 = Keluarga2::where('Ktp', '=', $header->Ktp)->first();

        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        if(!isset($poto) || $poto == null){
            $poto = "";
        }
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        // dd($cv);die;

        return view('detail_kandidat.detail_kandidat_belum_short', compact('header','pendidikan_det','pengalaman_det','pengalaman_det2','pengalaman_det3','organisasi_det', 'organisasi_det2','skill_det','skill_det2','sosmed_det','sosmed_det2','keluarga','keluarga2','poto', 'cv'));
    }

    /**
     * Show the form for editing the specified tr_candidate.
     *
     * @param int $id
     *
     * @return Response
     */

    public function edit_from_erika (Request $request, $id)
    {


        $header  = tr_import_data::where('Email', '=', $id)->first();
        $ktp_otomatis =  $header->full_name.'1';

        //Declare Applied At
        $formattedDate = $header->apply_at;
        // $carbonDate = Carbon::createFromFormat('d F Y', $textDate);
        // $formattedDate = $carbonDate->format('d-m-Y');
        // dd($header);die;
        //Declare BirthDate


        // $textDate2 = $header->birthdate;
        $formattedDate2 = $header->birthdate;
        // $carbonDate2 = Carbon::createFromFormat('m.d.Y', $textDate2);
        // $formattedDate2 = $carbonDate2->format('m/d/Y');

        // return view('tr_candidates.edit_from_jobportal', compact('header', 'ktp_otomatis'));
        return view('tr_candidates.edit_from_jobportal', compact('header', 'ktp_otomatis', 'formattedDate', 'formattedDate2'));
    }
    public function detail_kandidat_progress (Request $request, $id)
    {

        $header  = Tr_candidate_header::where('Ktp', '=', $id)->first();
        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det2 = Pengalaman2::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det3 = Pengalaman3::where('Ktp','=', $header->Ktp)->first();

        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $organisasi_det2 = Organisasi2::where('Ktp', '=', $header->Ktp)->first();

        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $skill_det2 = Skill2::where('Ktp','=', $header->Ktp)->first();

        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $sosmed_det2 = SocialMedia2::where('Ktp', '=', $header->Ktp)->first();

        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $keluarga2 = Keluarga2::where('Ktp', '=', $header->Ktp)->first();

        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        if(!isset($poto) || $poto == null){
            $poto = "";
        }
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        // dd($cv);die;

        return view('detail_kandidat.detail_kandidat_progress', compact('header','pendidikan_det','pengalaman_det','pengalaman_det2','pengalaman_det3','organisasi_det', 'organisasi_det2','skill_det','skill_det2','sosmed_det','sosmed_det2','keluarga','keluarga2','poto', 'cv'));
    }

    public function detail_kandidat_progress_jobportal (Request $request, $id)
    {

        $header  = tr_candidate_jobportal::where('Ktp', '=', $id)->first();
        $pendidikan_det = Pendidikan::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det2 = Pengalaman2::where('Ktp','=', $header->Ktp)->first();
        $pengalaman_det3 = Pengalaman3::where('Ktp','=', $header->Ktp)->first();

        $organisasi_det = Organisasi::where('Ktp', '=', $header->Ktp)->first();
        $organisasi_det2 = Organisasi2::where('Ktp', '=', $header->Ktp)->first();

        $skill_det = Skill::where('Ktp','=', $header->Ktp)->first();
        $skill_det2 = Skill2::where('Ktp','=', $header->Ktp)->first();

        $sosmed_det = SocialMedia::where('Ktp', '=', $header->Ktp)->first();
        $sosmed_det2 = SocialMedia2::where('Ktp', '=', $header->Ktp)->first();

        $keluarga = Keluarga::where('Ktp', '=', $header->Ktp)->first();
        $keluarga2 = Keluarga2::where('Ktp', '=', $header->Ktp)->first();

        $poto = Photos::where('Ktp','=', $header->Ktp)->first();
        if(!isset($poto) || $poto == null){
            $poto = "";
        }
        $cv = CurriculumVitae::where('Ktp','=', $header->Ktp)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        // dd($cv);die;

        return view('detail_kandidat.detail_kandidat_progress', compact('header','pendidikan_det','pengalaman_det','pengalaman_det2','pengalaman_det3','organisasi_det', 'organisasi_det2','skill_det','skill_det2','sosmed_det','sosmed_det2','keluarga','keluarga2','poto', 'cv'));
    }

    public function download_cv (Request $request, $id)
    {
        $header  = Tr_candidate_header::where('Ktp', '=', $id)->first();
        $pendidikan_det = Pendidikan::where('Ktp','=', $header->id)->first();
        $pengalaman_det = Pengalaman::where('Ktp','=', $header->id)->first();
        $pengalaman_det2 = Pengalaman2::where('Ktp','=', $header->id)->first();
        $pengalaman_det3 = Pengalaman3::where('Ktp','=', $header->id)->first();

        $organisasi_det = Organisasi::where('Ktp', '=', $header->id)->first();
        $organisasi_det2 = Organisasi2::where('Ktp', '=', $header->id)->first();

        $skill_det = Skill::where('Ktp','=', $header->id)->first();
        $skill_det2 = Skill2::where('Ktp','=', $header->id)->first();

        $sosmed_det = SocialMedia::where('Ktp', '=', $header->id)->first();
        $sosmed_det2 = SocialMedia2::where('Ktp', '=', $header->id)->first();

        $keluarga = Keluarga::where('Ktp', '=', $header->id)->first();
        $keluarga2 = Keluarga2::where('Ktp', '=', $header->id)->first();

        $poto = Photos::where('Ktp','=', $header->id)->first();
        if(!isset($poto) || $poto == null){
            $poto = "";
        }
        $cv = CurriculumVitae::where('Ktp','=', $header->id)->first();
        if(!isset($cv) || $cv == null){
            $cv = "";
        }
        // dd($cv);die;


        return view('detail_kandidat.download_cv', compact('header','pendidikan_det','pengalaman_det','pengalaman_det2','pengalaman_det3','organisasi_det', 'organisasi_det2','skill_det','skill_det2','sosmed_det','sosmed_det2','keluarga','keluarga2','poto', 'cv'));
    }

    public function shortlist1(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $shorting_candidate = []; where('id', '=', $id)->first();
        return view('tr_candidates.txs')->with('shorting_candidate', $shorting_candidate);
    }
    public function shortlistPost(Request $request, $id)
    {
        $user = auth()->user();
        $user = $user->name;
        $shorting_candidate = [];
        $shorting_candidate = tr_candidate::where('id', '=', $id)->first();
        if (!empty($shorting_candidate))
        {
            $shorting_candidate->CekShorlist =  "1";
            $shorting_candidate->ms_short_status = "Shortlisted";
            $shorting_candidate->status_shortlist = $request->status_shortlist;
            $shorting_candidate->alasan_shortlist = $request->alasan_shortlist;
            $shorting_candidate->DateShorlist = Carbon::now()->toDateTimeString();
            $shorting_candidate->PICShortlist = $user;
            // dd($shorting_candidate);die;

            $shorting_candidate->save();
            // return "Kandidat telah di shorting.";

            $user = Auth::user();
            $call = tr_candidate::where('CekShorlist', '=', null,)->orderByDesc('created_at', 'desc')->get();

        return view('tr_candidates.kandidat_belum_short', compact('user','call'));
        }
    }

    public function validasipanggilhrd(Request $request, $id)
    {
        $user = auth()->user();
        print ($user->name);
        $user = $user->name;
        $header = tr_candidate::where('Handphone', '=', $id)->first();

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

        return view('tr_candidates.candidate_call', compact('header','pendidikan_det','pengalaman_det','organisasi_det','skill_det','sosmed_det','keluarga','poto', 'cv'));

    }
    public function post_panggil(Request $request, $id)
     {
        $user = auth()->user();
        $user = $user->name;
        $shorting_candidate = [];

        $shorting_candidate = tr_candidate::where('id', '=', $id)->first();
        $shorting_candidate->CekCall = "1";
        $shorting_candidate->jadwal_interview = $request->jadwal_interview;
        $shorting_candidate->PICCall = $user;
        $shorting_candidate->Cek_Sambung = $request->Cek_Sambung;
        $shorting_candidate->alasan_sambung = $request->alasan_sambung;
        $shorting_candidate->DateCall = now();
        // dd($shorting_candidate);die;
        $shorting_candidate->save();

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
          $call_H->tr_candidate_call_code_h       = '';
          $call_H->Ms_Caller_code                 = $user;
          $call_H->Date_Call                      = $shorting_candidate->DateCall;
          $call_H->Total_Call_HGS                 = 0;
          $call_H->Total_Call_TGU                 = 0;
          $call_H->Total_Call_TGF                 = 0;
          $call_H->Total_Call                     = 0;
           $call_H->save();

          $report_call = new CallHRD();
          $report_call->Ms_User_Code            = $user;
          $report_call->ms_divisi               = '';
          $report_call->Tr_Report_Lowongan_Call = $call_H->tr_candidate_call_code_h ;
          $report_call->Tr_report_hrd_main_code = $shorting_candidate->Tr_report_hrd_main_code;
          $report_call->Ms_ReportType_Code      = 'Call';
          $report_call->Nama_kandidat           = $shorting_candidate->Name;
          $report_call->Ms_Media_Code           = $request->CekCV;
          $report_call->NamaLowongan            = $shorting_candidate->Position_aplly1;
          $report_call->Telepon                 = $shorting_candidate->Handphone;
          $report_call->Ms_Status               = $shorting_candidate->Cek_Sambung;
          $report_call->Ms_Perusahaan_Code      = '';
          $report_call->Tr_Candidate_Sort_Code  = 1;
          $report_call->Tr_status_interview     = 0;
          $report_call->save();

          $jadwal = new Jadwal_Interview();
          $jadwal->tr_int_sched_Code        = $tr_candidate_call_code_h;
          $jadwal->Date_int                 = $request->jadwal_interview;
          $jadwal->Time_int                 = $request->Time_int;
          $jadwal->Interviewer              = $request->Interviewer;
          $jadwal->Lokasi                   = $request->Lokasi;
          $jadwal->Ms_Candidate_Code        = $shorting_candidate->Name;
          $jadwal->Int_model                = $request->Int_model;
          // dd($jadwal);die;
          $jadwal->save();

          $user = Auth::user();
          $call = tr_candidate::select('*')
          ->where('status_shortlist', '=', 1)
          ->where('CekCall', '=', null)
          ->where('CekInterview', '=', null)
          ->get();

        return view('tr_candidates.kandidat_belum_dihubungi', compact('user','call'));
    }

    public function post_panggiljobportal(Request $request, $id)
     {
        $user = auth()->user();
        $user = $user->name;
        $shorting_candidate = [];

        $shorting_candidate = tr_candidate_jobportal::where('id', '=', $id)->first();
        $shorting_candidate->CekCall = "1";
        $shorting_candidate->jadwal_interview = $request->jadwal_interview;
        $shorting_candidate->PICCall = $user;
        $shorting_candidate->Cek_Sambung = $request->Cek_Sambung;
        $shorting_candidate->alasan_sambung = $request->alasan_sambung;
        $shorting_candidate->DateCall = now();
        // dd($shorting_candidate);die;
        $shorting_candidate->save();

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
          $call_H->tr_candidate_call_code_h       = '';
          $call_H->Ms_Caller_code                 = $user;
          $call_H->Date_Call                      = $shorting_candidate->DateCall;
          $call_H->Total_Call_HGS                 = 0;
          $call_H->Total_Call_TGU                 = 0;
          $call_H->Total_Call_TGF                 = 0;
          $call_H->Total_Call                     = 0;
           $call_H->save();

          $report_call = new CallHRD();
          $report_call->Ms_User_Code            = $user;
          $report_call->ms_divisi               = '';
          $report_call->Tr_Report_Lowongan_Call = $call_H->tr_candidate_call_code_h ;
          $report_call->Tr_report_hrd_main_code = $shorting_candidate->Tr_report_hrd_main_code;
          $report_call->Ms_ReportType_Code      = 'Call';
          $report_call->Nama_kandidat           = $shorting_candidate->Name;
          $report_call->Ms_Media_Code           = $request->CekCV;
          $report_call->NamaLowongan            = $shorting_candidate->Position_aplly1;
          $report_call->Telepon                 = $shorting_candidate->Handphone;
          $report_call->Ms_Status               = $shorting_candidate->Cek_Sambung;
          $report_call->Ms_Perusahaan_Code      = '';
          $report_call->Tr_Candidate_Sort_Code  = 1;
          $report_call->Tr_status_interview     = 0;
          $report_call->save();

          $jadwal = new Jadwal_Interview();
          $jadwal->tr_int_sched_Code        = $tr_candidate_call_code_h;
          $jadwal->Date_int                 = $request->jadwal_interview;
          $jadwal->Time_int                 = $request->Time_int;
          $jadwal->Interviewer              = $request->Interviewer;
          $jadwal->Lokasi                   = $request->Lokasi;
          $jadwal->Ms_Candidate_Code        = $shorting_candidate->Name;
          $jadwal->Int_model                = $request->Int_model;
          // dd($jadwal);die;
          $jadwal->save();

          $user = Auth::user();
          $call = tr_candidate::select('*')
          ->where('status_shortlist', '=', 1)
          ->where('CekCall', '=', null)
          ->where('CekInterview', '=', null)
          ->get();

        return view('tr_candidates.kandidat_belum_dihubungi', compact('user','call'));
    }


    public function post_interview(Request $request, $id)
    {
         $user = auth()->user();
        $shorting_candidate = [];
        $shorting_candidate = tr_candidate::where('id', '=', $id)->first();

        $shorting_candidate->PICInterview       = $user->username;
        $shorting_candidate->CekInterview       = "1";
        $shorting_candidate->DateInterview      = now();
        $shorting_candidate->status_interview   = $request->status_interview;
        $shorting_candidate->alasan_interview   = $request->alasan_interview;
        $shorting_candidate->ms_kode_interview1 = $request->status_interview;
        $shorting_candidate->save();

        $report_interview = new InterviewHRD();
        $report_interview->Ms_User_Code            = $user->username;
        $report_interview->ms_divisi               = $user->ms_divisi;
        $report_interview->tr_lowongan_Interview   = '';
        $report_interview->Tr_report_hrd_main_code = $shorting_candidate->Tr_report_hrd_main_code;
        $report_interview->Ms_ReportType_Code      = 'Interview';
        $report_interview->Ms_Media_Code           = '';
        $report_interview->NamaLowongan            = $shorting_candidate->Position_aplly1;
        $report_interview->userinterview           = $user->username;
        $report_interview->Ms_Perusahaan_Code      = '';
        $report_interview->NamaCandidate           = $shorting_candidate->Name;
        $report_interview->Telepon                 = $shorting_candidate->Handphone;
        $report_interview->lanjut_tidaklanjut      = $request->lanjut_tidaklanjut;
        $report_interview->priority                = $request->priority;
        $report_interview->langsungBD              = $request->langsungBD;
        $report_interview->drive                   = $request->drive;
        $report_interview->notedrive               = $request->notedrive;
        $report_interview->skill                   = $request->skill;
        $report_interview->noteskill               = $request->noteskill;
        $report_interview->solving                 = $request->solving;
        $report_interview->notesolving             = $request->notesolving;
        $report_interview->leadership              = $request->leadership;
        $report_interview->noteleadership          = $request->noteleadership;
        $report_interview->initiative              = $request->initiative;
        $report_interview->noteinitiative          = $request->noteinitiative;
        $report_interview->attitude                =  $request->attitude;
        $report_interview->noteattitude            = $request->noteattitude;
        $report_interview->note                    = $request->alasan_interview;
        $report_interview->alasan_melamar          = $request->alasan_melamar;
        $report_interview->alasan_keluar           = $request->alasan_keluar;
        $report_interview->hasil_interview         = $shorting_candidate->status_interview;
        $report_interview->user                    = $request->user;
        $report_interview->note                    = $request->alasan_interview;
        $report_interview->hasil_interview         = $shorting_candidate->status_interview;
        $report_interview->Tr_status_interview     = 1;
        // dd($report_interview);die;
        $report_interview->save();

        $user = Auth::user();
        $call = tr_candidate::select('*')
        ->where('Cek_Sambung', '=', 1)
        ->where('CekInterview', '=', null)
        ->get();

        return view('tr_candidates.kandidat_belum_interview', compact('user','call'));
    }
    
    public function post_interview2(Request $request, $id)
    {
        $user = auth()->user();
        $shorting_candidate = [];
        $shorting_candidate = tr_candidate::where('id', '=', $id)->first();

        $shorting_candidate->PICInterview2       = $user->username;
        $shorting_candidate->CekInterview2       = "1";
        $shorting_candidate->DateInterview2      = now();
        $shorting_candidate->status_interview2   = $request->hasil_interview;
        $shorting_candidate->alasan_interview2   = $request->alasan_interview;
        $shorting_candidate->ms_kode_interview2  = $request->hasil_interview;
        // dd($shorting_candidate);die;
        $shorting_candidate->save();

        $report_interviews = new InterviewUser();
        $report_interviews->rec_usercreated         = $user->username;
        $report_interviews->ms_divisi               = $user->ms_divisi;
        //$report_interview->tr_lowongan_Interview   = '';
        $report_interviews->Tr_report_hrd_main_code = $shorting_candidate->Tr_report_hrd_main_code;
        $report_interviews->Ms_ReportType_Code      = 'Interview User';
        $report_interviews->Ms_Media_Code           = '';
        $report_interviews->NamaLowongan            = $shorting_candidate->Position_aplly1;
        $report_interviews->userinterview           = $user->username;
        $report_interviews->Ms_Perusahaan_Code      = '';
        $report_interviews->NamaCandidate           = $shorting_candidate->Name;
        $report_interviews->Telepon                 = $shorting_candidate->Handphone;
        $report_interviews->skill                   = $request->skill;
        $report_interviews->attitude                = $request->attitude;
        $report_interviews->leadership              = $request->leadership;
        $report_interviews->inisiative              = $request->inisiative;
        $report_interviews->problem_solve           = $request->problem_solve;
        $report_interviews->drive                   = $request->drive;
        $report_interviews->pengalaman_dengan_posisi= $request->pengalaman_dengan_posisi;
        $report_interviews->jam_kerja               = $request->jam_kerja;
        $report_interviews->prestasi                = $request->prestasi;
        $report_interviews->soft_skill              = $request->soft_skill;
        $report_interviews->user                    = $request->user;
        $report_interviews->note                    = $request->alasan_interview;
        $report_interviews->hasil_interview         = $request->hasil_interview;
        $report_interviews->Tr_status_interview     = 1;
        // dd($report_interviews);die;
        $report_interviews->save();

        $user = Auth::user();
        $kandidat = tr_candidate::select('*')
        ->where('CekShorlist', '=', 1)
        ->where('CekCall', '=', 1)
        ->where('Cek_Sambung', '=', 'Terhubung')
        ->where('CekInterview2', '=', 1)
        ->where('ms_kode_interview1', '!=', null)
        ->where('ms_kode_interview2', '=', null)
        ->get();

        // return view('tr_candidates.kandidat_belum_interview2', compact('user','kandidat'));
        return redirect('/tr_candidates/kandidat_interview2');
    }


    public function post_interview_jobportal(Request $request, $id)
    {
        $user = auth()->user();
        $user = $user->name;
        $shorting_candidate = [];
        $shorting_candidate = tr_candidate_jobportal::where('id', '=', $id)->first();
        // $shorting_candidate->CekCall = "1";

        $shorting_candidate->PICInterview = $user;
        $shorting_candidate->CekInterview = "1";
        $shorting_candidate->DateInterview = now();
        $shorting_candidate->status_interview = $request->status_interview;
        $shorting_candidate->alasan_interview = $request->alasan_interview;
        $shorting_candidate->save();

        $report_interview = new InterviewHRD();
        $report_interview->Ms_User_Code            = $user;
        $report_interview->ms_divisi               = '';
        $report_interview->tr_lowongan_Interview   = '';
        $report_interview->Tr_report_hrd_main_code = $shorting_candidate->Tr_report_hrd_main_code;
        $report_interview->Ms_ReportType_Code      = 'Interview';
        $report_interview->Ms_Media_Code           = '';
        $report_interview->NamaLowongan            = $shorting_candidate->Position_aplly1;
        $report_interview->Ms_Perusahaan_Code      = '';
        $report_interview->NamaCandidate           = $shorting_candidate->Name;
        $report_interview->Telepon                 = $shorting_candidate->Handphone;
        $report_interview->hasil_interview         = $shorting_candidate->status_interview;
        $report_interview->Tr_status_interview     = 1;
        $report_interview->save();

        $user = Auth::user();
        $call = tr_candidate::select('*')
        ->where('Cek_Sambung', '=', 1)
        ->where('CekInterview', '=', null)
        ->get();

        return view('tr_candidates.kandidat_dapat_dihubungi', compact('user','call'));
    }

    public function store_from_erika(Request $request)
    {
      $user = auth()->user();
      $update_import = tr_import_data::where('email', $request->Email)
        ->update([
            'shortlisted' => "Done"
        ]);

      $last_id = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_report_hrd_main
      order by created_at desc
      LIMIT 1
      ");
      foreach($last_id as $asas)
      { $idnya = $asas->id;}

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
          $Tr_report_hrd_main_code='MAINHRD'. '-'. date('Ydm').'-'."00".$idnya;
      }
      // dd($Tr_report_hrd_main_code);die;

      $main_report_hrd = new Main_reportHRD();
      $main_report_hrd->Tr_report_hrd_main_code = $Tr_report_hrd_main_code;
      $main_report_hrd->Ms_ReportType_Code      = 'CV Candidate';
      $main_report_hrd->posisi1                 = $request->Position_aplly1;
      $main_report_hrd->posisi2                 = $request->Position_aplly2;
      $main_report_hrd->save();

        $candidate_header = new tr_candidate_jobportal();
        $candidate_header->Tr_report_hrd_main_code = $main_report_hrd->Tr_report_hrd_main_code;
        $candidate_header->Name = $request->Name;
        $candidate_header->Ktp = $request->Ktp;
        $candidate_header->domisili = $request->domisili;
        $candidate_header->CityBirth = $request->CityBirth;
        $candidate_header->Birthdate = $request->Birthdate;
        $candidate_header->status = $request->status;
        $candidate_header->jenis_kelamin = $request->jenis_kelamin;
        $candidate_header->agama = $request->agama;
        $candidate_header->Handphone = $request->Handphone;
        $candidate_header->Email = $request->Email;
        $candidate_header->pengajuan_gaji = $request->pengajuan_gaji;
        $candidate_header->info_lowongan = $request->info_lowongan;
        $candidate_header->Position_aplly1 = $request->Position_aplly1;
        $candidate_header->ketersediaan = $request->ketersediaan;
        $candidate_header->layak = $request->layak;
        $candidate_header->patner = $request->patner;
        $candidate_header->Position_aplly2 = $request->Position_aplly2;
        $candidate_header->area_minat = $request->area_minat;
        $candidate_header->no_sim = $request->no_sim;
        $candidate_header->type_sim = $request->type_sim;
        $candidate_header->riwayat_penyakit = $request->riwayat_penyakit;
        $candidate_header->rec_status = '1';
        $candidate_header->CekCV = 'Erika';
        $candidate_header->created_at = $request->tanggal;
        $candidate_header->CekShorlist =  "1";
        $candidate_header->ms_short_status = "Shortlisted";
        $candidate_header->status_shortlist = "1";
        $candidate_header->alasan_shortlist = "OK";
        $candidate_header->DateShorlist = Carbon::now()->toDateTimeString();
        $candidate_header->PICShortlist = $user->username;
        // dd($candidate_header);die;
        $candidate_header->save();

        $pendidikan = new Pendidikan();
        $pendidikan->ktp = $request->Ktp;
        $pendidikan->jenjang = $request->jenjang;
        $pendidikan->sekolah = $request->sekolah;
        $pendidikan->jurusan = $request->jurusan;
        $pendidikan->tahunmasuk = $request->tahunmasuk;
        $pendidikan->tahunlulus = $request->tahunlulus;
        $pendidikan->alamat = $request->alamat;
        $pendidikan->ipk = $request->ipk;
        // dd($pendidikan);die;
        $pendidikan->save();

        $pengalaman = new Pengalaman();
        $pengalaman->Ktp = $request->Ktp;
        $pengalaman->Perusahaan = $request->Perusahaan;
        $pengalaman->Posisi = $request->Posisi;
        $pengalaman->Lama_kerja = $request->Lama_kerja;
        $pengalaman->Gaji = $request->Gaji;
        $pengalaman->No_hp = $request->No_hp;
        $pengalaman->alasan_keluar = $request->alasan_keluar;
        $pengalaman->komentar = $request->komentar;
        // dd($pengalaman);die;
        $pengalaman->save();

        $pengalaman2 = new Pengalaman2();
        $pengalaman2->Ktp = $request->Ktp;
        $pengalaman2->Perusahaan2 = $request->Perusahaan2;
        $pengalaman2->Posisi2 = $request->Posisi2;
        $pengalaman2->Lama_kerja2 = $request->Lama_kerja2;
        $pengalaman2->Gaji2 = $request->Gaji2;
        $pengalaman2->No_hp2 = $request->No_hp2;
        $pengalaman2->alasan_keluar2 = $request->alasan_keluar2;
        $pengalaman2->komentar2 = $request->komentar2;
        // dd($pengalaman2);die;
        $pengalaman2->save();

        $pengalaman3 = new Pengalaman3();
        $pengalaman3->Ktp = $request->Ktp;
        $pengalaman3->Perusahaan3 = $request->Perusahaan3;
        $pengalaman3->Posisi3 = $request->Posisi3;
        $pengalaman3->Lama_kerja3 = $request->Lama_kerja3;
        $pengalaman3->Gaji3 = $request->Gaji3;
        $pengalaman3->No_hp3 = $request->No_hp3;
        $pengalaman3->alasan_keluar3 = $request->alasan_keluar3;
        $pengalaman3->komentar3 = $request->komentar3;
        $pengalaman3->save();

        $organisasi = new Organisasi();
        $organisasi->Ktp = $request->Ktp;
        $organisasi->Nama_organisasi = $request->Nama_organisasi;
        $organisasi->Jabatan = $request->Jabatan;
        $organisasi->Periode = $request->Periode;
        $organisasi->save();

        $organisasi2 = new Organisasi2();
        $organisasi2->Ktp = $request->Ktp;
        $organisasi2->Nama_organisasi2 = $request->Nama_organisasi2;
        $organisasi2->Jabatan2 = $request->Jabatan2;
        $organisasi2->Periode2 = $request->Periode2;
        $organisasi2->save();

        $skill = new Skill();
        $skill->Ktp = $request->Ktp;
        $skill->Skill = $request->Skill;
        $skill->tingkat = $request->tingkat;
        $skill->sertifikasi = $request->sertifikasi;
        $skill->siap_tes = $request->siap_tes;
        $skill->save();

        $skill2 = new Skill2();
        $skill2->Ktp = $request->Ktp;
        $skill2->Skill2 = $request->Skill2;
        $skill2->tingkat2 = $request->tingkat2;
        $skill2->sertifikasi2 = $request->sertifikasi2;
        $skill2->siap_tes2 = $request->siap_tes2;
        $skill2->save();

        $sosmeds = new SocialMedia();
        $sosmeds->Ktp = $request->Ktp;
        $sosmeds->sosmed = $request->sosmed;
        $sosmeds->nickname = $request->nickname;
        $sosmeds->save();

        $sosmeds2 = new SocialMedia2();
        $sosmeds2->Ktp = $request->Ktp;
        $sosmeds2->sosmed2 = $request->sosmed2;
        $sosmeds2->nickname2 = $request->nickname2;
        $sosmeds2->save();

        $keluarga = new Keluarga();
        $keluarga->Ktp = $request->Ktp;
        $keluarga->hubungan = $request->hubungan;
        $keluarga->namanya = $request->namanya;
        $keluarga->pendidikan = $request->pendidikan;
        $keluarga->pekerjaan = $request->pekerjaan;
        $keluarga->tempat = $request->tempat;
        $keluarga->save();

        $keluarga2 = new Keluarga2();
        $keluarga2->Ktp = $request->Ktp;
        $keluarga2->hubungan2 = $request->hubungan2;
        $keluarga2->namanya2 = $request->namanya2;
        $keluarga2->pendidikan2 = $request->pendidikan2;
        $keluarga2->pekerjaan2 = $request->pekerjaan2;
        $keluarga2->tempat2 = $request->tempat2;
        // dd($keluarga2);die;
        $keluarga2->save();

        $photonya = new Photos();
        $photonya->id_tr_candidate = $candidate_header->id;
        $photonya->Ktp = $request->Ktp;

        if($request->file('file_path'))
        {
            $file= $request->file('file_path');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $photonya->file_path = 'upload/' . $filename;
        }
        // dd($photonya);die;
        $photonya->save();

        $cvnya = new CurriculumVitae();
        $cvnya->id_tr_candidate = $candidate_header->id;
        $cvnya->Ktp = $request->Ktp;

        if($request->file('file_cv'))
        {
            $file= $request->file('file_cv');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $cvnya->file_cv = 'upload/' . $filename;
        }
        // dd($cvnya);die;
        $cvnya->save();

        $kandidat = DB::connection('mysql')->select("
        SELECT
        *
        FROM tr_import_data
        where shortlisted is null
        ");

        return view('hrd.import_data', compact('kandidat'));
    }
 public function isi_kandidat(Request $request)
    {
      $last_id = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_report_hrd_main
      order by created_at desc
      LIMIT 1
      ");
      foreach($last_id as $asas)
      { $idnya = $asas->id;}

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
          $Tr_report_hrd_main_code='MAINHRD'. '-'. date('Ydm').'-'."00".$idnya;
      }

      return view('hrd.isi_kandidat',compact('Tr_report_hrd_main_code'));
    }

public function store_from_isi_kandidat(Request $request)
    {
      $user = auth()->user();
      $update_import = tr_import_data::where('email', $request->Email)
        ->update([
            'shortlisted' => "Done"
        ]);

      $last_id = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_report_hrd_main
      order by created_at desc
      LIMIT 1
      ");
      foreach($last_id as $asas)
      { $idnya = $asas->id;}

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
          $Tr_report_hrd_main_code='MAINHRD'. '-'. date('Ydm').'-'."00".$idnya;
      }
      // dd($Tr_report_hrd_main_code);die;

      $main_report_hrd = new Main_reportHRD();
      $main_report_hrd->Tr_report_hrd_main_code = $Tr_report_hrd_main_code;
      $main_report_hrd->Ms_ReportType_Code      = 'CV Candidate';
      $main_report_hrd->posisi1                 = $request->Position_aplly1;
      $main_report_hrd->posisi2                 = $request->Position_aplly2;
      $main_report_hrd->save();

        $candidate_header = new tr_candidate_jobportal();
        $candidate_header->Tr_report_hrd_main_code = $main_report_hrd->Tr_report_hrd_main_code;
        $candidate_header->Name = $request->Name;
        $candidate_header->Ktp = $request->Ktp;
        $candidate_header->domisili = $request->domisili;
        $candidate_header->CityBirth = $request->CityBirth;
        $candidate_header->Birthdate = $request->Birthdate;
        $candidate_header->status = $request->status;
        $candidate_header->jenis_kelamin = $request->jenis_kelamin;
        $candidate_header->agama = $request->agama;
        $candidate_header->Handphone = $request->Handphone;
        $candidate_header->Email = $request->Email;
        $candidate_header->pengajuan_gaji = $request->pengajuan_gaji;
        $candidate_header->info_lowongan = $request->info_lowongan;
        $candidate_header->Position_aplly1 = $request->Position_aplly1;
        $candidate_header->ketersediaan = $request->ketersediaan;
        $candidate_header->layak = $request->layak;
        $candidate_header->patner = $request->patner;
        $candidate_header->Position_aplly2 = $request->Position_aplly2;
        $candidate_header->area_minat = $request->area_minat;
        $candidate_header->no_sim = $request->no_sim;
        $candidate_header->type_sim = $request->type_sim;
        $candidate_header->riwayat_penyakit = $request->riwayat_penyakit;
        $candidate_header->rec_status = '1';
        $candidate_header->CekCV = $request->CekCV;
        $candidate_header->created_at = $request->tanggal;

        $candidate_header->CekShorlist =  "1";
        $candidate_header->ms_short_status = "Shortlisted";
        $candidate_header->status_shortlist = "1";
        $candidate_header->alasan_shortlist = "OK";
        $candidate_header->DateShorlist = Carbon::now()->toDateTimeString();
        $candidate_header->PICShortlist = $user->username;
        // dd($candidate_header);die;
        $candidate_header->save();

        $pendidikan = new Pendidikan();
        $pendidikan->ktp = $request->Ktp;
        $pendidikan->jenjang = $request->jenjang;
        $pendidikan->sekolah = $request->sekolah;
        $pendidikan->jurusan = $request->jurusan;
        $pendidikan->tahunmasuk = $request->tahunmasuk;
        $pendidikan->tahunlulus = $request->tahunlulus;
        $pendidikan->alamat = $request->alamat;
        $pendidikan->ipk = $request->ipk;
        // dd($pendidikan);die;
        $pendidikan->save();

        $pengalaman = new Pengalaman();
        $pengalaman->Ktp = $request->Ktp;
        $pengalaman->Perusahaan = $request->Perusahaan;
        $pengalaman->Posisi = $request->Posisi;
        $pengalaman->Lama_kerja = $request->Lama_kerja;
        $pengalaman->Gaji = $request->Gaji;
        $pengalaman->No_hp = $request->No_hp;
        $pengalaman->alasan_keluar = $request->alasan_keluar;
        $pengalaman->komentar = $request->komentar;
        // dd($pengalaman);die;
        $pengalaman->save();

        $pengalaman2 = new Pengalaman2();
        $pengalaman2->Ktp = $request->Ktp;
        $pengalaman2->Perusahaan2 = $request->Perusahaan2;
        $pengalaman2->Posisi2 = $request->Posisi2;
        $pengalaman2->Lama_kerja2 = $request->Lama_kerja2;
        $pengalaman2->Gaji2 = $request->Gaji2;
        $pengalaman2->No_hp2 = $request->No_hp2;
        $pengalaman2->alasan_keluar2 = $request->alasan_keluar2;
        $pengalaman2->komentar2 = $request->komentar2;
        // dd($pengalaman2);die;
        $pengalaman2->save();

        $pengalaman3 = new Pengalaman3();
        $pengalaman3->Ktp = $request->Ktp;
        $pengalaman3->Perusahaan3 = $request->Perusahaan3;
        $pengalaman3->Posisi3 = $request->Posisi3;
        $pengalaman3->Lama_kerja3 = $request->Lama_kerja3;
        $pengalaman3->Gaji3 = $request->Gaji3;
        $pengalaman3->No_hp3 = $request->No_hp3;
        $pengalaman3->alasan_keluar3 = $request->alasan_keluar3;
        $pengalaman3->komentar3 = $request->komentar3;
        $pengalaman3->save();

        $organisasi = new Organisasi();
        $organisasi->Ktp = $request->Ktp;
        $organisasi->Nama_organisasi = $request->Nama_organisasi;
        $organisasi->Jabatan = $request->Jabatan;
        $organisasi->Periode = $request->Periode;
        $organisasi->save();

        $organisasi2 = new Organisasi2();
        $organisasi2->Ktp = $request->Ktp;
        $organisasi2->Nama_organisasi2 = $request->Nama_organisasi2;
        $organisasi2->Jabatan2 = $request->Jabatan2;
        $organisasi2->Periode2 = $request->Periode2;
        $organisasi2->save();

        $skill = new Skill();
        $skill->Ktp = $request->Ktp;
        $skill->Skill = $request->Skill;
        $skill->tingkat = $request->tingkat;
        $skill->sertifikasi = $request->sertifikasi;
        $skill->siap_tes = $request->siap_tes;
        $skill->save();

        $skill2 = new Skill2();
        $skill2->Ktp = $request->Ktp;
        $skill2->Skill2 = $request->Skill2;
        $skill2->tingkat2 = $request->tingkat2;
        $skill2->sertifikasi2 = $request->sertifikasi2;
        $skill2->siap_tes2 = $request->siap_tes2;
        $skill2->save();

        $sosmeds = new SocialMedia();
        $sosmeds->Ktp = $request->Ktp;
        $sosmeds->sosmed = $request->sosmed;
        $sosmeds->nickname = $request->nickname;
        $sosmeds->save();

        $sosmeds2 = new SocialMedia2();
        $sosmeds2->Ktp = $request->Ktp;
        $sosmeds2->sosmed2 = $request->sosmed2;
        $sosmeds2->nickname2 = $request->nickname2;
        $sosmeds2->save();

        $keluarga = new Keluarga();
        $keluarga->Ktp = $request->Ktp;
        $keluarga->hubungan = $request->hubungan;
        $keluarga->namanya = $request->namanya;
        $keluarga->pendidikan = $request->pendidikan;
        $keluarga->pekerjaan = $request->pekerjaan;
        $keluarga->tempat = $request->tempat;
        $keluarga->save();

        $keluarga2 = new Keluarga2();
        $keluarga2->Ktp = $request->Ktp;
        $keluarga2->hubungan2 = $request->hubungan2;
        $keluarga2->namanya2 = $request->namanya2;
        $keluarga2->pendidikan2 = $request->pendidikan2;
        $keluarga2->pekerjaan2 = $request->pekerjaan2;
        $keluarga2->tempat2 = $request->tempat2;
        // dd($keluarga2);die;
        $keluarga2->save();

        $photonya = new Photos();
        $photonya->id_tr_candidate = $candidate_header->id;
        $photonya->Ktp = $request->Ktp;

        if($request->file('file_path'))
        {
            $file= $request->file('file_path');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $photonya->file_path = 'upload/' . $filename;
        }
        // dd($photonya);die;
        $photonya->save();

        $cvnya = new CurriculumVitae();
        $cvnya->id_tr_candidate = $candidate_header->id;
        $cvnya->Ktp = $request->Ktp;

        if($request->file('file_cv'))
        {
            $file= $request->file('file_cv');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $cvnya->file_cv = 'upload/' . $filename;
        }
        // dd($cvnya);die;
        $cvnya->save();

        $kandidat = DB::connection('mysql')->select("
        SELECT
        *
        FROM tr_import_data
        where shortlisted is null
        ");

       session()->flash('success', 'Data berhasil disimpan!');
        return redirect('isi_kandidat');
    }

    public function lihat_jadwal(Request $request)
    {
      $jadwals = DB::connection('mysql')->select("
     select
      Date_int,
      Time_int,
      Interviewer,
      Lokasi,
      Ms_Candidate_Code,
      Int_model
      from
      tr_candidate_jobportal kandidat_main
      left JOIN tr_int_sched skejul on kandidat_main.Name = skejul.Ms_candidate_code
      where kandidat_main.rec_status='1'and kandidat_main.CekInterview is null and skejul.Ms_Candidate_Code is not null
     
		 
		 union
		 
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
      where kandidat_main.rec_status='1'and kandidat_main.CekInterview is null and skejul.Ms_Candidate_Code is not null
      ");

      return view ('hrd.jadwal_interview',compact('jadwals'));

    }
    
    public function driver_apply(Request $request)
    {

      return view('tr_candidates.candidates_driver');
    }

    public function store_cv_driver(Request $request)
    {
      $update_import = tr_import_data::where('email', $request->Email)
        ->update([
            'shortlisted' => "Done"
        ]);

      $last_id = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_report_hrd_main
      order by created_at desc
      LIMIT 1
      ");
      foreach($last_id as $asas)
      { $idnya = $asas->id;}

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
          $Tr_report_hrd_main_code='MAINHRD'. '-'. date('Ydm').'-'."00".$idnya;
      }
      // dd($Tr_report_hrd_main_code);die;

      $main_report_hrd = new Main_reportHRD();
      $main_report_hrd->Tr_report_hrd_main_code = $Tr_report_hrd_main_code;
      $main_report_hrd->Ms_ReportType_Code      = 'CV Candidate';
      $main_report_hrd->posisi1                 = $request->Position_aplly1;
      $main_report_hrd->posisi2                 = $request->Position_aplly2;

      $main_report_hrd->save();

        $candidate_header = new tr_candidate();
        $candidate_header->Tr_report_hrd_main_code = $main_report_hrd->Tr_report_hrd_main_code;
        $candidate_header->Name = $request->Name;
        $candidate_header->nama_panggilan = $request->nama_panggilan;
        $candidate_header->Ktp = $request->Ktp;
        $candidate_header->alamat_ktp = $request->alamat_ktp;
        $candidate_header->masa_berlaku_ktp = $request->masa_berlaku_ktp;
        $candidate_header->nama_ibu = $request->nama_ibu;
        $candidate_header->domisili = $request->domisili;
        $candidate_header->CityBirth = $request->CityBirth;
        $candidate_header->Birthdate = $request->Birthdate;
        $candidate_header->umur = $request->umur;
        $candidate_header->status = $request->status;
        $candidate_header->jenis_kelamin = $request->jenis_kelamin;
        $candidate_header->agama = $request->agama;
        $candidate_header->Handphone = $request->Handphone;
        $candidate_header->Email = $request->Email;
        $candidate_header->pengajuan_gaji = $request->pengajuan_gaji;
        $candidate_header->info_lowongan = $request->info_lowongan;
        $candidate_header->Position_aplly1 = $request->Position_aplly1;
        $candidate_header->ketersediaan = $request->ketersediaan;
        $candidate_header->layak = $request->layak;
        $candidate_header->patner = $request->patner;
        $candidate_header->Position_aplly2 = $request->Position_aplly2;
        $candidate_header->area_minat = $request->area_minat;
        $candidate_header->no_sim = $request->no_sim;
        $candidate_header->type_sim = $request->type_sim;
        $candidate_header->masa_berlaku_sim = $request->masa_berlaku_sim;
        $candidate_header->riwayat_penyakit = $request->riwayat_penyakit;
        $candidate_header->rec_status = '1';
        $candidate_header->CekCV = 'Software HRD';
        // $candidate_header->CekShorlist =  "1";
        // $candidate_header->ms_short_status = "Shortlisted";
        // $candidate_header->status_shortlist = "1";
        // $candidate_header->alasan_shortlist = "OK";
        // $candidate_header->DateShorlist = Carbon::now()->toDateTimeString();
        // $candidate_header->PICShortlist = "HRD Pusat";
        // dd($candidate_header);die;
        $candidate_header->save();

        $pendidikan = new Pendidikan();
        $pendidikan->ktp = $request->Ktp;
        $pendidikan->jenjang = $request->jenjang;
        $pendidikan->sekolah = $request->sekolah;
        $pendidikan->jurusan = $request->jurusan;
        $pendidikan->tahunmasuk = $request->tahunmasuk;
        $pendidikan->tahunlulus = $request->tahunlulus;
        $pendidikan->alamat = $request->alamat;
        $pendidikan->ipk = $request->ipk;
        // dd($pendidikan);die;
        $pendidikan->save();

        $pengalaman = new Pengalaman();
        $pengalaman->Ktp = $request->Ktp;
        $pengalaman->Perusahaan = $request->Perusahaan;
        $pengalaman->Posisi = $request->Posisi;
        $pengalaman->Lama_kerja = $request->Lama_kerja;
        $pengalaman->Gaji = $request->Gaji;
        $pengalaman->No_hp = $request->No_hp;
        $pengalaman->alasan_keluar = $request->alasan_keluar;
        $pengalaman->komentar = $request->komentar;
        // dd($pengalaman);die;
        $pengalaman->save();

        $pengalaman2 = new Pengalaman2();
        $pengalaman2->Ktp = $request->Ktp;
        $pengalaman2->Perusahaan2 = $request->Perusahaan2;
        $pengalaman2->Posisi2 = $request->Posisi2;
        $pengalaman2->Lama_kerja2 = $request->Lama_kerja2;
        $pengalaman2->Gaji2 = $request->Gaji2;
        $pengalaman2->No_hp2 = $request->No_hp2;
        $pengalaman2->alasan_keluar2 = $request->alasan_keluar2;
        $pengalaman2->komentar2 = $request->komentar2;
        // dd($pengalaman2);die;
        $pengalaman2->save();

        $pengalaman3 = new Pengalaman3();
        $pengalaman3->Ktp = $request->Ktp;
        $pengalaman3->Perusahaan3 = $request->Perusahaan3;
        $pengalaman3->Posisi3 = $request->Posisi3;
        $pengalaman3->Lama_kerja3 = $request->Lama_kerja3;
        $pengalaman3->Gaji3 = $request->Gaji3;
        $pengalaman3->No_hp3 = $request->No_hp3;
        $pengalaman3->alasan_keluar3 = $request->alasan_keluar3;
        $pengalaman3->komentar3 = $request->komentar3;
        // dd($pengalaman3);die;
        $pengalaman3->save();

        $organisasi = new Organisasi();
        $organisasi->Ktp = $request->Ktp;
        $organisasi->Nama_organisasi = $request->Nama_organisasi;
        $organisasi->Jabatan = $request->Jabatan;
        $organisasi->Periode = $request->Periode;
        // dd($organisasi);die;
        $organisasi->save();

        $organisasi2 = new Organisasi2();
        $organisasi2->Ktp = $request->Ktp;
        $organisasi2->Nama_organisasi2 = $request->Nama_organisasi2;
        $organisasi2->Jabatan2 = $request->Jabatan2;
        $organisasi2->Periode2 = $request->Periode2;
        // dd($organisasi2);die;
        $organisasi2->save();

        $skill = new Skill();
        $skill->Ktp = $request->Ktp;
        $skill->Skill = $request->Skill;
        $skill->tingkat = $request->tingkat;
        $skill->sertifikasi = $request->sertifikasi;
        $skill->siap_tes = $request->siap_tes;
        $skill->save();

        $skill2 = new Skill2();
        $skill2->Ktp = $request->Ktp;
        $skill2->Skill2 = $request->Skill2;
        $skill2->tingkat2 = $request->tingkat2;
        $skill2->sertifikasi2 = $request->sertifikasi2;
        $skill2->siap_tes2 = $request->siap_tes2;
        $skill2->save();

        $sosmeds = new SocialMedia();
        $sosmeds->Ktp = $request->Ktp;
        $sosmeds->sosmed = $request->sosmed;
        $sosmeds->nickname = $request->nickname;
        $sosmeds->save();

        $sosmeds2 = new SocialMedia2();
        $sosmeds2->Ktp = $request->Ktp;
        $sosmeds2->sosmed2 = $request->sosmed2;
        $sosmeds2->nickname2 = $request->nickname2;
        $sosmeds2->save();

        $keluarga = new Keluarga();
        $keluarga->Ktp = $request->Ktp;
        $keluarga->hubungan = $request->hubungan;
        $keluarga->namanya = $request->namanya;
        $keluarga->pendidikan = $request->pendidikan;
        $keluarga->pekerjaan = $request->pekerjaan;
        $keluarga->tempat = $request->tempat;
        $keluarga->save();

        $keluarga2 = new Keluarga2();
        $keluarga2->Ktp = $request->Ktp;
        $keluarga2->hubungan2 = $request->hubungan2;
        $keluarga2->namanya2 = $request->namanya2;
        $keluarga2->pendidikan2 = $request->pendidikan2;
        $keluarga2->pekerjaan2 = $request->pekerjaan2;
        $keluarga2->tempat2 = $request->tempat2;
        // dd($keluarga2);die;
        $keluarga2->save();

        $photonya = new Photos();
        $photonya->id_tr_candidate = $candidate_header->id;
        $photonya->Ktp = $request->Ktp;

        if($request->file('file_path'))
        {
            $file= $request->file('file_path');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $photonya->file_path = 'upload/' . $filename;
        }
        // dd($photonya);die;
        $photonya->save();

        $cvnya = new CurriculumVitae();
        $cvnya->id_tr_candidate = $candidate_header->id;
        $cvnya->Ktp = $request->Ktp;

        if($request->file('file_cv'))
        {
            $file= $request->file('file_cv');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('upload'), $filename);
            $cvnya->file_cv = 'upload/' . $filename;
        }
        // dd($cvnya);die;
        $cvnya->save();

        $header = array(
            'Name'             =>   $request->Name,
            'Ktp'              =>   $request->Ktp,
            'domisili'         =>   $request->domisili,
            'CityBirth'        =>   $request->CityBirth,
            'Birthdate'        =>   $request->Birthdate,
            'status'           =>   $request->status,
            'jenis_kelamin'    =>   $request->jenis_kelamin,
            'agama'            =>   $request->agama,
            'Handphone'        =>   $request->Handphone,
            'Email'            =>   $request->Email,
            'pengajuan_gaji'   =>   $request->pengajuan_gaji,
            'Position_aplly'   =>   $request->Position_aplly,
            'info_lowongan'    =>   $request->info_lowongan,
            'ketersediaan'     =>   $request->ketersediaan,
            'layak'            =>   $request->layak,
            'tanggal_ketesediaan' =>   $request->tanggal_ketesediaan,
            'tanggal'          =>   $request->tanggal,

            'sekolah'          =>  $request->sekolah,
            'tahunmasuk'       =>   $request->tahunmasuk,
            'tahunlulus'       =>   $request->tahunlulus,
            'alamat'           =>   $request->alamat,
            'ipk'              =>   $request->ipk,

            'Perusahaan'       =>   $request->Perusahaan,
            'Posisi'           =>   $request->Posisi,
            'Lama_kerja'       =>   $request->Lama_kerja,
            'Gaji'             =>   $request->Gaji,
            'No_hp'            =>   $request->No_hp,
            'alasan_keluar'    =>   $request->alasan_keluar,

            'Nama_organisasi'  =>   $request->Nama_organisasi,
            'Jabatan'          =>   $request->Jabatan,
            'Periode'          =>   $request->Periode,

            'Skill'            =>   $request->Skill,
            'tingkat'          =>   $request->tingkat,
            'siap_tes'         =>   $request->siap_tes,

            'sosmed'           =>   $request->sosmed,
            'nickname'         =>   $request->nickname,

            'hubungan'         =>   $request->hubungan,
            'namanya'          =>   $request->namanya,
            'pendidikan'       =>   $request->pendidikan,
            'pekerjaan'        =>   $request->pekerjaan,
            'tempat'           =>   $request->tempat
        );

        return view ('tr_candidates.terimakasih');
    }
}
