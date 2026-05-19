<?php

namespace App\Http\Controllers;
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
use App\Models\Request_Revisi;
use App\Models\Tr_BA_Revisi;
use App\Mail\SendEmail;
use App\Models\tr_approval_ba_tracking;
use App\Models\Ms_Kasus;
use App\Models\ms_jenis_laka;
use App\Models\ms_faktor_laka;
use App\Models\ms_klasifikasi_laka;
use App\Models\ms_dampak_laka;
use App\Models\User;
use App\Models\Ms_fraud;
use App\Models\Tr_BA_Main_New;
use App\Models\Tr_BA_Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use Session;
use Carbon\Carbon;
use PDF;
use \Mpdf\Mpdf as MPDF; 



class BeritaAcaraController extends Controller
{
    public function index_ba()
    {
      $ms_katergori = Ms_Case_Category::all();
      $divisi = ms_divisi::all();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();

      $last_code = DB::connection('mysql')->select("
         SELECT
         id
         FROM tr_ba_main
         order by created_at desc
         LIMIT 1
         ");
        //  dd($last_code);die;
        foreach($last_code as $codes)
        { $kode = $codes->id;}
        $ba_main_new = new Tr_Ba_Main_New();
        $ba_main_new->id = $kode;
      // dd($ms_katergori );die;
      return view('berita_acara.beritaacara', compact('ms_katergori', 'ba_main_new', 'divisi', 'lokasi', 'employee'));
    }

    public function index_ba_laka()
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
      $company = Ms_Company::all();
      $ms_katergori = Ms_Case_Category::all();
      $users = User::all();

      $last_code = DB::connection('mysql')->select("
         SELECT
         id
         FROM tr_ba_main
         order by created_at desc
         LIMIT 1
         ");
        //  dd($last_code);die;
        foreach($last_code as $codes)
        { $kode = $codes->id;}
        $ba_main = new BA_Main();
        $ba_main->id = $kode;
      // dd($user );die;
      return view('berita_acara.berita_acara_laka', compact('user', 'lokasi', 'employee', 'divisi', 'company', 'ms_katergori', 'ba_main', 'divisi', 'users'));
    }
    public function dashboard_ba_laka()
    {
      $report = DB::connection('mysql')->select("
          SELECT
          main.created_at,
          main.Tr_BA_Main_Code,
          CekFraud,
          Ms_BA_type_Code,
          Ms_Kasus,
          MS_Detail_Kasus,
          header.ms_klasifikasi_laka as ms_kasus,
          Ms_Pelapor_Code,
            CekPelanggaran,
            CekKerusakan,
            CekFraud,
            CekRevisi,
            CekDisiplin,
            CekSalahIsi,
            CekNoClosing,
            CekLaka,
            CekPembelian,	
            CekKehilangan,
            CekPerubahanSOP,
          detail.nama as Ms_Emp_Code,
          detail.posisi as Ms_Emp_Div

          FROM Tr_Ba_Main_New main
          left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
          left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
          where main.rec_status ='1'
          and Ms_BA_type_Code='Laka'
          ORDER BY main.created_at desc
     ");

     $userlogin = DB::connection('mysql')->select("
     select  * from users where activate ='1' ORDER BY username asc
     ");
     $users = DB::connection('mysql')->select("
     select  * from master_employees where emp_inactive ='1' ORDER BY emp_name asc
     ");
     $jenis = DB::connection('mysql')->select("
     select * from ms_kasus_head where ms_type ='Berita Acara' and rec_status ='1' order by description asc
     ");
     $ms_kasus = DB::connection('mysql')->select("
     select * from ms_kasus where rec_status ='1' order by description asc
     ");

     return view('berita_acara.dashboard_ba', compact('report', 'userlogin', 'users', 'jenis', 'ms_kasus'));
    }
     public function dashboard_ba()
{
    $report = DB::connection('mysql')->select("
        SELECT
            created_at,
            Tr_BA_Main_Code,
            CekFraud,
            Ms_BA_type_Code,
            Ms_Kasus,
            MS_Detail_Kasus,
            Ms_Pelapor_Code,
            Ms_Pelapor_Div,
            rec_usercreated,
            CekPelanggaran,
            CekKerusakan,
            CekFraud,
            CekRevisi,
            CekDisiplin,
            CekSalahIsi,
            CekNoClosing,
            CekLaka,
            CekPembelian,
            CekKehilangan,
            CekPerubahanSOP,
            Ms_Emp_Code,
            Ms_Emp_Div
        FROM Tr_Ba_Main_New
        WHERE rec_status = '1'
          AND Ms_Kasus != 'Laka'
          AND Ms_BA_type_Code = 'BA Kejadian'
        ORDER BY created_at DESC
    ");

    // dd($report); // Tambahkan ini untuk cek isi
    return view('berita_acara.dashboard_ba', compact('report'));
}

   
    public function print_ba(Request $request, $id)
    {
      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
      
      
      $dok1 = BA_docs::where('ba_main_code', '=', $id )->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id )->first();
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s');   
        // Setup a filename 
        // Setup a filename 
        $documentFileName = $id.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
    
        $kronologi = ""; 
			if(isset($ba_kronologi->kronlogi) ){
				$kronologi = $ba_kronologi->kronlogi;
			}      
      $fraud = '' ;
      if($main_ba_new->CekFraud == '1'){
         $fraud = 'Iya'; 
      } 
      else{
          $fraud = 'Tidak';  
      }
      $docsx1 = '';
      $docs1 = "upload/logohgs.jpg";
        if(!empty($dok1)){
            $docs1 = url('/'.$dok1->file_path);
            if($docs1 == url('/')){
                $docsx1 = '';
            }
            else{
                $docsx1 = '<img width="250" height="130" src="'.$docs1.'">';
            }
        }
      $docsx2 = '';  
      $docs2 = "upload/logohgs.jpg";
        if(!empty($dok2)){
            $docs2 = url('/'.$dok2->file_path2);
            if($docs2 == url('/')){
                $docsx2 = '';
            }
            else{
                $docsx2 = '<img width="250" height="130" src="'.$docs2.'">';
            }
        }        
    
        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Berita Acara Kejadian</center></h3>
                  <hr/>
                  <br>
  <table style="width: 100%;">
  <thead>
    <tr>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Code</td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
      <td>Perusahaan</td><td>: '.$main_ba_new->rec_comcode.'</td>
    </tr>
    <tr>
      <td>Kategori</td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
      <td>Kasus</td><td>: '.$main_ba_new->Ms_Kasus.'</td>
    </tr>
    <tr>
      <td>Tanggal BA</td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").' </td>
      <td>Tanggal Peristiwa</td><td>: '.date_format(date_create($main_ba_new->Date_BA),"d/m/Y").' </td>
    </tr>
    <tr>
      <td>User Input</td><td>: '.$main_ba_new->Ms_Pelapor_Code.' </td>
      <td>Divisi yang Input</td><td>: '.$main_ba_new->Ms_Pelapor_Div.' </td>
    </tr>
    <tr>
      <td>Pelaku</td><td>: '.$main_ba_new->Ms_Emp_Code.' </td>
      <td>Divisi Pelaku</td><td> : '.$main_ba_new->Ms_Emp_Div.' </td>
    </tr>
    <tr>
      <td>Lokasi</td><td>: '.$main_ba_new->rec_areacode.'</td>
      <td >Detail Kasus</td><td>: '.$main_ba_new->MS_Detail_Kasus.'</td>
    </tr>  
    <tr>
      <td><strong>Fraud ?</strong></td><td>: 
        '.$fraud.'
      </td>
      <td></td><td></td>
    </tr>
    </tbody>
</table>
<br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">
                        '.$kronologi.' 
                      </div>
          <br>

                      <center>
                        <h3>
                           Dokumen
                         </h3>
                       </center>

                       <table class="table table-bordered mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                  <td>'.$docsx1.'
                                  </td>
                                  <td>'.$docsx2.'
                                  </td>
                            </tr>      
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-bordered mt-4" style="width: 100%;">
                      <thead>
                          <tr>
                              <th style="width: 5%;"> No. </th>
                              <th style="width: 30%;">PIC</th>
                              <th style="width: 30%;">Divisi</th>
                              <th style="width: 20%;"></th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                <td>&nbsp; &nbsp; 1</td>
                                <td>'.$main_ba_new->Ms_Emp_Code.'</td>
                                <td>'.$main_ba_new->Ms_Emp_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 2</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Code.'</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 3</td>
                                <td>Tri Hartati</td>
                                <td>Manager Finance</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 4</td>
                                <td>Dwi Arif W / Yesy Tjandra</td>
                                <td>Manager Operasional</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 5</td>
                                <td>Cliff Rogers </td>
                                <td>General Manager</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 6</td>
                                <td>Diana L</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 7</td>
                                <td>Charles W</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                      </tbody>
                  </table>

                <div class="card-body">
          <br>
          <br>  
          <table>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>
        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //

            //pdf
            // $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
            // $data = [
            //   'main_ba_new' => $main_ba_new, 
            //   'detail'      => $detail,
            //   'ba_kronologi'=> $ba_kronologi, 
            //   'dok1'        => $dok1, 
            //   'dok2'        => $dok2,
            //   'datetime'    => $datetime
            // ];
            // $pdf = PDF::loadView('berita_acara.print_berita_acara_salahisi',$data);
            // return $pdf->download($id.'.pdf');      
      
    //   return view ('berita_acara.print_berita_acara_salahisi', compact('main_ba', 'detail','ba_kronologi') );
      //return view ('berita_acara.print_berita_acara_salahisi', compact('main_ba_new', 'detail','ba_kronologi', 'dok1', 'dok2') );
    }
    
    public function print_ba_laka(Request $request, $id)
    {
      // dd($id);die;

      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $laka_h = BA_laka_header::where('tr_ba_main_code', '=', $id)->first();
      // dd($main_ba);die;
      $laka_d = BA_laka_detail::where('tr_ba_laka_code_h', '=', $laka_h->tr_ba_laka_code)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s');   
        // Setup a filename 
        $documentFileName = $id.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
    
      $no=1;
      $laka_ = '';
      foreach($laka_d as $row){

        $laka_ .= 
        '<tr>

        <td>'.$no.'</td>
        <td>'.$row->posisi.'</td>
        <td>'.$row->nama.'</td>
        <td>'.$row->usia.'</td>
        <td>'.$row->penguji.'</td>
        <td>Rp. '.$row->avg_income.'</td>
        <td>'.$row->istirahat_last.'</td>
        </tr>';
      }    
    
        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Berita Acara Laka</center></h3>
                  <hr/>
                  <br>
                        <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                            </tr>
                        </thead>
                        <tbody>     
                          <tr>
                            <td>Code</td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
                            <td>Perusahaan</td><td>: '.$main_ba_new->rec_comcode.'</td>
                          </tr>

                          <tr>
                            <td>Jenis Laka</td><td>: '.$laka_h->ms_jenis_laka.'</td>
                            <td>Faktor</td><td>: '.$laka_h->ms_faktor_laka.'</td>
                          </tr>
                          <tr>
                            <td>Klasifikasi</td><td>: '.$laka_h->ms_klasifikasi_laka.'</td>
                            <td>Dampak</td><td>: '.$laka_h->ms_dampak_laka.'</td>
                          </tr>

                          <tr>
                            <td>BA Type</td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
                            <td>Location</td><td>: '.$main_ba_new->rec_areacode.'</td>
                          </tr>
                          <tr>
                            <td>Kategori</td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
                            <td>Type</td><td>: '.$laka_h->type_laka.'</td>
                          </tr>
                          <tr>
                            <td>Tanggal BA</td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").'  </td>
                            <td>Fatality</td><td>: '.$laka_h->fatality.'</td>
                          </tr>
                          <tr>
                            <td>SPK</td><td>: '.$laka_h->spk.' </td>
                            <td >No. Armada&nbsp</td><td>: '.$laka_h->no_armada.' </td>
                          </tr>
                          <tr>
                            <td>Tgl Kejadian</td><td>: '.date_format(date_create($laka_h->date_laka),"d/m/Y").' </td>
                            <td >Jam Keluar</td><td>: '.$laka_h->jam_keluar.' </td>
                          </tr>
                          <tr>
                            <td>Loc. Kejadian</td><td>: '.$laka_h->lokasi_kejadian.' </td>
                            <td >Jam Kejadian</td><td>: '.$laka_h->jam_kejadian.' </td>
                          </tr>
                          <tr>
                          <td>Rute</td><td>: '.$laka_h->rute.' </td>
                          <td >Dispatcher</td><td>: '.$laka_h->dispatcher.' </td>
                          </tr>
                          <tr>
                            <td>Speed</td><td>: '.$laka_h->speed.' </td>
                            <td >Bengkel Terakhir</td><td>: '.$laka_h->bengkel_terakhir.' </td>
                          </tr>
                         </tbody>   
                      </table>
                      <br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">'.$ba_kronologi->kronlogi.'</div>
                      <br>
                      <br>
            <table class="table table-bordered mt-4" style="width: 100%;" >
                <thead>
                    <tr>
                        <th style="width: 5%;"> No. </th>
                        <th style="width: 10%;">Jabatan</th>
                        <th style="width: 15%;">Nama</th>
                        <th style="width: 5%;">Usia</th>
                        <th style="width: 15%;">Penguji</th>
                        <th style="width: 10%;">Avg. Income</th>
                        <th style="width: 10%;">Istirahat Last</th>
                    </tr>
                </thead>
                <tbody>'.$laka_.'
                </tbody>
            </table>
            <br>
            <br>
          <br>
          <br>
          <br>
          <table>
            <tr><td >Operator <br> <br> <br> <br> <br> <br></td></tr>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>

        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //


    }
    
   

    public function exportPDF(Request $request, $id)
    {
        $product = BA_Main::where('Tr_BA_Code', '=', $id)->first();
        $pdf = PDF::loadView('product.pdf', ['product' => $product]);

        return $pdf->download('product.pdf');
    }
    public function store_ba(Request $request)
    {
      $last_id = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_ba_main
      order by Date_BA desc
      LIMIT 1
      ");
      foreach($last_id as $asas)
      { $idnya = $asas->id+1;}
      $last_code = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_ba_main
      order by id desc
      LIMIT 1
      ");
      $last_date = DB::connection('mysql')->select("
      SELECT
      created_at
      FROM tr_ba_main
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
      $ambilkode=BA_Main::where($request->Tr_BA_Code)->get();
      $nambah=count($ambilkode)+1;
      if ($nambah <1000000)
      {
        $Tr_BA_Code='BA'. '-'. date('Ydm').'-'."00".$idnya;
      }

      $main_ba = new BA_Main();
      $main_ba->Tr_BA_Code        = $Tr_BA_Code;
      $main_ba->BA_Type_Code      = $request->BA_Type_Code;
      $main_ba->BA_Admin          = $request->BA_Admin;
      $main_ba->Admin_Div         = $request->Admin_Div;
      $main_ba->User_Code         = $request->User_Code;
      $main_ba->BA_Note           = $request->BA_Note;
      $main_ba->Date_BA           = Carbon::now();;
      $main_ba->Division_Code     = $request->Division_Code;
      $main_ba->Position_Code     = $request->Position_Code;
      $main_ba->Category_Code     = $request->Category_Code;
      $main_ba->jenis             = $request->jenis;
      $main_ba->Location_Code     = $request->Location_Code;
      $main_ba->Company_Code      = $request->Company_Code;
      $main_ba->mengetahui1       = $request->mengetahui1;
      $main_ba->atasan1           = $request->atasan1;
      $main_ba->mengetahui2       = $request->mengetahui2;
      $main_ba->atasan2           = $request->atasan2;
      $main_ba->perlu_approval    = $request->perlu_approval;
      $main_ba->rec_status        = '1';
    //   dd($main_ba);die;
      $main_ba->save();

      if ($request->jenis =='Salah isi Dokumen')
        {
          foreach($request['code_doc'] as $key => $item_id)
            {
                $ba_salah_isi_d = new BA_Salah_Isi_d();
                $ba_salah_isi_d->tr_ba_code_main    = $main_ba->Tr_BA_Code ;
                $ba_salah_isi_d->code_doc           = $request['code_doc'][$key];
                $ba_salah_isi_d->field_salah        = $request['field_salah'][$key];
                $ba_salah_isi_d->value_salah        = $request['value_salah'][$key];
                $ba_salah_isi_d->field_benar        = $request['field_benar'][$key];
                $ba_salah_isi_d->value_benar        = $request['value_benar'][$key];
                $ba_salah_isi_d->save();
            }

          $ba_kronologi = new Tr_BA_Kronologi();
          $ba_kronologi->tr_ba_kronologi_code = $main_ba->Tr_BA_Code;
          $ba_kronologi->tr_ba_main_code = $main_ba->Tr_BA_Code;
          $ba_kronologi->kronlogi = $request->kronlogi;
          $ba_kronologi->save();

          $ba_doc = new BA_docs();
          $ba_doc->ba_main_code = $main_ba->Tr_BA_Code;

          if($request->file('file_path'))
          {
              $file= $request->file('file_path');
              $filename= date('YmdHi').$file->getClientOriginalName();
              $file-> move(public_path('upload'), $filename);
              $ba_doc->file_path = 'upload/' . $filename;
          }
          $ba_doc->save();
          // dd($ba_doc);die;
          session()->flash('success', 'Data berhasil disimpan!');
          return redirect('berita_acara_laka');
        }

        else if ($request->Category_Code =='Laka')
        {
          $ba_kronologis = new Tr_BA_Kronologi();
          $ba_kronologis->tr_ba_kronologi_code = $main_ba->Tr_BA_Code;
          $ba_kronologis->tr_ba_main_code = $main_ba->Tr_BA_Code;
          $ba_kronologis->kronlogi = $request->kronlogi;
          $ba_kronologis->save();

          $last_code = DB::connection('mysql')->select("
            SELECT
            id
            FROM tr_ba_laka_h
            order by id desc
            LIMIT 1
            ");
            $last_date = DB::connection('mysql')->select("
            SELECT
            created_at
            FROM tr_ba_laka_h
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
            $ambilkode=BA_laka_header::where($request->tr_ba_laka_code)->get();
            $nambah=count($ambilkode)+1;
            if ($nambah <1000000)
            {
              $tr_ba_laka_code='LAKA'. '-'. date('Ydm').'-'."00".$nambah;
            }

          $ba_laka_head = new BA_laka_header();
          $ba_laka_head->tr_ba_laka_code        = $tr_ba_laka_code;
          $ba_laka_head->tr_ba_main_code        = $main_ba->Tr_BA_Code;
          $ba_laka_head->type_laka              = $request->type_laka;
          $ba_laka_head->pool                   = $request->pool;
          $ba_laka_head->dispatcher             = $request->dispatcher;
          $ba_laka_head->spk                    = $request->spk;
          $ba_laka_head->no_armada              = $request->no_armada;
          $ba_laka_head->jam_keluar             = $request->jam_keluar;
          $ba_laka_head->jam_kejadian           = $request->jam_kejadian;
          $ba_laka_head->rallying               = $request->rallying;
          $ba_laka_head->speed                  = $request->speed;
          $ba_laka_head->in_pool                = $request->in_pool;
          $ba_laka_head->out_pool               = $request->out_pool;
          $ba_laka_head->rute                   = $request->rute;
          $ba_laka_head->bengkel_terakhir       = $request->bengkel_terakhir;
          $ba_laka_head->lokasi_kejadian        = $request->lokasi_kejadian;
          $ba_laka_head->date_laka              = $request->date_laka;
          $ba_laka_head->fatality               = $request->fatality;
          $ba_laka_head->save();
          // dd($ba_laka_head);die;
          foreach($request['posisi'] as $key => $item_id)
            {
                $ba_laka_detail = new BA_laka_detail();
                $ba_laka_detail->tr_ba_laka_code_h  = $ba_laka_head->tr_ba_laka_code;
                $ba_laka_detail->posisi             = $request['posisi'][$key];
                $ba_laka_detail->nama               = $request['nama'][$key];
                $ba_laka_detail->usia               = $request['usia'][$key];
                $ba_laka_detail->penguji            = $request['penguji'][$key];
                $ba_laka_detail->avg_income         = $request['avg_income'][$key];
                $ba_laka_detail->istirahat_last     = $request['istirahat_last'][$key];
                $ba_laka_detail->save();
            }

            session()->flash('success', 'Data berhasil disimpan!');
            return redirect('berita_acara_laka');
        }
        // return view('home');
    }

    public function report_ba()
    {
         $main_BA = []; // kosongkan data awal
    $tgl_awal = null;
    $tgl_akhir = null;
    return view('berita_acara.report_ba', compact('main_BA', 'tgl_awal', 'tgl_akhir'));
    }
    
    public function search_report_ba(Request $request)
    {
      
       $tgl_awal       = $request->tgl_awal;        
       $tgl_akhir      = $request->tgl_akhir;    
       
       
       $main_BA = DB::connection('mysql')->select("
       select
		
		    mains.created_at,
        mains.Tr_BA_Main_Code,
        mains.Date_BA,
        mains.rec_areacode,
		    mains.Ms_Pelapor_Code,
		    mains.Ms_Pelapor_Div,
        mains.Ms_Emp_Code,
        mains.Ms_Emp_Div,
        CASE WHEN mains.CekFraud = 1 THEN 'Fraud' ELSE 'Tidak Fraud' END AS CekFraud,
        mains.Ms_BA_type_Code,
        mains.Ms_Kasus,
        mains.MS_Detail_Kasus,
        mains.rec_comcode,
            CekPelanggaran,
            CekKerusakan,
            CekFraud,
            CekRevisi,
            CekDisiplin,
            CekSalahIsi,
            CekNoClosing,
            CekLaka,
            CekPembelian,	
            CekKehilangan,
            CekPerubahanSOP,        
		    krono.kronlogi
        from
        Tr_Ba_Main_New mains 
		    left join tr_ba_kronologi krono on mains.Tr_BA_Main_Code = krono.tr_ba_main_code
        where date(mains.created_at) >= '$tgl_awal' and date(mains.created_at) <= '$tgl_akhir'
        and rec_status ='1' 
        and mains.Ms_BA_type_Code ='BA Kejadian'
        -- and YEAR(mains.created_at) >= 2024
        order by mains.created_at DESC
         ");
        
      return view('berita_acara.report_ba', compact('main_BA', 'tgl_awal', 'tgl_akhir'));
    }    
    
    public function search_report_laka(Request $request)
    {
      
       $tgl_awal       = $request->tgl_awal;        
       $tgl_akhir      = $request->tgl_akhir;    
       
      $report = DB::connection('mysql')->select("
        select DISTINCT
        main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Pelapor_Code,
	      header.no_armada,
	      header.ms_jenis_laka,
        header.ms_faktor_laka,
        header.ms_klasifikasi_laka,
        header.ms_dampak_laka,
		    header.type_laka,
		    header.fatality,
	      detail.nama,
	      detail.posisi,
	      detail.penguji
        from
        Tr_Ba_Main_New main
		    left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
		    left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where 
        date(main.created_at) >= '$tgl_awal' and date(main.created_at) <= '$tgl_akhir'
        and rec_status ='1' and Ms_BA_type_Code ='Laka'
        order by created_at DESC
      ");
   
      return view('berita_acara.report_laka', compact('report', 'tgl_awal', 'tgl_akhir'));
    }     
    
    public function search_report_revisi(Request $request)
    {
      
       $tgl_awal       = $request->tgl_awal;        
       $tgl_akhir      = $request->tgl_akhir;    
       $report = DB::connection('mysql')->select("
      select
        Main.created_at,
				Main.Tr_BA_Main_Code,
        Main.rec_comcode,
        Main.rec_areacode,
        Main.Ms_Pelapor_Code,
        Main.Ms_Emp_Code,
        Main.Ms_Emp_Div,
		Main.Ms_BA_type_Code,
		Main.Ms_Kasus,
		Main.MS_Detail_Kasus,
		krono.kronlogi,
		MAX(tracking.approval_ba_tracking) as trace
        from
        Tr_Ba_Main_New Main
		left join tr_ba_kronologi krono on Main.Tr_BA_Main_Code = krono.tr_ba_main_code
		left join tr_approval_ba_tracking tracking on Main.Tr_BA_Main_Code = tracking.approval_ba_main_code
      where 
      date(Main.created_at) >= '$tgl_awal' and date(Main.created_at) <='$tgl_akhir'
      and Main.rec_status ='1'
      and Main.CekRevisi = '1' and Main.Ms_BA_type_Code ='BA Revisi'
      -- and YEAR(Main.created_at) >= 2024
	  GROUP BY  Main.Tr_BA_Main_Code
      order by Main.created_at asc
      ");
      return view('berita_acara.dashboard_revisi', compact('report', 'tgl_awal', 'tgl_akhir'));       

    }     

    public function home_ba(Request $request)
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
      $jenis = Ms_Jenis_BA::all();
      $company = Ms_Company::all();

      return view('berita_acara.home_ba', compact('user','lokasi', 'employee', 'divisi', 'jenis', 'company'));
    }

    public function index_all_ba(Request $request)
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
    //   $users = User::all();
      $company = Ms_Company::all();
      $fraud = Ms_fraud::all();
    //   $users = DB::connection('mysql')->select("
    //   select  * from master_employees where emp_inactive ='1' ORDER BY emp_name asc
    //   ");
    $users = DB::connection('mysql_new')->SELECT("
      (SELECT 
          driver_id AS id, 
          driver_name AS emp_id,
          'Driver' AS divisi
      FROM ms_driver WHERE ms_driver.rec_status = '1')

      UNION ALL

      (SELECT 
          helper_id AS id, 
          helper_name AS emp_id,
          'Helper' AS divisi
      FROM ms_helper where ms_helper.rec_status = '1')

      UNION ALL

      (SELECT 
          e.Ms_Emp_Code AS id, 
          e.Emp_Name AS emp_id,
          d.div_id AS divisi
      FROM Ms_User_Emp e
      JOIN ms_division d ON e.emp_division = d.div_id
      where e.rec_status = '1')
      ");

      $jenis = DB::connection('mysql')->select("
      select * from ms_kasus_head where ms_type ='Berita Acara' and rec_status ='1' order by description asc
      ");
      $ms_kasus = DB::connection('mysql')->select("
      select * from ms_kasus where ms_kasus_head1 !='01' and rec_status ='1' order by description asc
      ");
      
      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM Tr_Ba_Main_New
      order by created_at desc
      LIMIT 1
      ");

      $twoChars = substr($user->username, 0, 3);

      foreach($last_id2 as $asas2)
      { $idnya2 = $asas2->id+1;}
      $ambilkode2=Tr_BA_Main_New::where($request->Tr_BA_Code)->get();
      $nambah2=count($ambilkode2)+1;
      if ($nambah2 <1000000)
      {
        $code_bass='BA'. '-'. $user->ms_divisi.'-'. date('Ydm').'-'."00".$idnya2;
      }

      return view('berita_acara.berita_acara_all', compact('code_bass','user','lokasi', 'employee', 'divisi', 'jenis', 'company', 'ms_kasus', 'users',  'fraud'));
    }
    
    public function store_all_ba(Request $request)
    {
 
      $timestamp = Carbon::now()->timestamp;
  
      $tanggalSekarang = Carbon::now();
      $tahunSaatIni = $tanggalSekarang->year;
      $weeks = $tanggalSekarang->weekOfYear;
    //   dd($tahunSaatIni);
      // Tentukan rentang periode
      $startDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-01-01');
      $endDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-03-31');
      $startDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-04-01');
      $endDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-06-30');
      $startDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-07-01');
      $endDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-09-31');      
      $startDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-10-01');
      $endDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-12-31');

     if(Carbon::now()->between($startDate1, $endDate1)){
      $periodeQ = 'Q1';
     };
     
     if(Carbon::now()->between($startDate2, $endDate2)){
      $periodeQ = 'Q2';
     };
     if(Carbon::now()->between($startDate3, $endDate3)){
      $periodeQ = 'Q3';
     };   
     if(Carbon::now()->between($startDate4, $endDate4)){
      $periodeQ = 'Q4';
     };
     if(Carbon::now()){
      $periodeQ = 'Q4';
     };
     if(Carbon::now()){
      $periodeQ = 'Q4';
     };
      $period_H = $request->User_Code . '-' .$tahunSaatIni.$periodeQ;
      do
      {
        $randomValue = mt_rand(100, 999);
        $autoNumber = $request->User_Code . '-' . $request->Category_Code . $weeks. $tahunSaatIni . $randomValue;
        $isUnique = !DB::table('Tr_Ba_Main_New')
            ->where('Tr_BA_Main_Code', $autoNumber)
            ->exists();
      }
      while (!$isUnique);
      
      $divisi_code = DB::connection('mysql_new')->SELECT("
      SELECT *
      FROM (
      (SELECT 
                driver_id AS id, 
                driver_name AS emp_id,
                'Driver' AS divisi
            FROM ms_driver WHERE ms_driver.rec_status = '1')

            UNION ALL

            (SELECT 
                helper_id AS id, 
                helper_name AS emp_id,
                'Helper' AS divisi
            FROM ms_helper where ms_helper.rec_status = '1')

            UNION ALL

            (SELECT 
                e.Ms_Emp_Code AS id, 
                e.Emp_Name AS emp_id,
                d.div_id AS divisi
            FROM Ms_User_Emp e
            JOIN ms_division d ON e.emp_division = d.div_id
            where e.rec_status = '1')
            ) AS all_employees
      WHERE id = '$request->User_Code'
      ");
      
      if ($divisi_code[0]->divisi != '') {
        $code_divisi = $divisi_code[0]->divisi;
      }

      $user = auth()->user();
      
      $main_ba_new = new Tr_Ba_Main_New();
      $main_ba_new->Tr_BA_Main_Code        = $autoNumber;
      $main_ba_new->Ms_BA_type_Code        = 'BA Kejadian';
      $main_ba_new->Ms_Emp_Code            = $request->User_Code;
      $main_ba_new->Ms_Emp_Div             = $code_divisi;
      $main_ba_new->Ms_Pelapor_Code        = $request->BA_Admin;
      $main_ba_new->Ms_Pelapor_Div         = $request->Admin_Div;
      $main_ba_new->Date_BA                = $request->Date_BA;
      $main_ba_new->BA_Desc                = $request->BA_Note;
      if($request->Category_Code == 'Pelanggaran SOP')
      {
        $main_ba_new->CekPelanggaran = 1;
      }
      else if($request->Category_Code != 'Pelanggaran SOP')
      {
        $main_ba_new->CekPelanggaran = 0;
      }
      if($request->Category_Code == 'Kerusakan')
      {
        $main_ba_new->CekKerusakan = 1;
      }
      else if($request->Category_Code != 'Kerusakan')
      {
        $main_ba_new->CekKerusakan = 0;
      }
      if($request->Category_Code == 'Kehilangan')
      {
        $main_ba_new->CekKehilangan = 1;
      }
      else if($request->Category_Code != 'Kehilangan')
      {
        $main_ba_new->CekKehilangan = 0;
      }
      if($request->Category_Code == 'Pembelian Barang')
      {
        $main_ba_new->CekPembelian = 1;
      }
      else if($request->Category_Code != 'Pembelian Barang')
      {
        $main_ba_new->CekPembelian = 0;
      }
      if($request->Category_Code == 'Perubahan SOP')
      {
        $main_ba_new->CekPerubahanSOP = 1;
      }
      else if($request->Category_Code != 'Perubahan SOP')
      {
        $main_ba_new->CekPerubahanSOP = 0;
      }
      $main_ba_new->CekFraud               = $request->ms_fraud;
      $main_ba_new->Ms_Kasus               = $request->jenis;
      $main_ba_new->Ms_Detail_Kasus        = $request->ms_kasus;
      $main_ba_new->Tr_EmpPeriod_Code      = $period_H;
      $main_ba_new->rec_usercreated        = Auth::User()->name;
      $main_ba_new->rec_datecreated        = Carbon::now();
      $main_ba_new->rec_comcode            = $request->Company_Code;
      $main_ba_new->rec_areacode           = $request->Location_Code;
      $main_ba_new->rec_status             = 1;
      // dd($main_ba_new);
      $main_ba_new->save();

    //   $main_ba = new BA_Main();
    //   $main_ba->Tr_BA_Code        = $main_ba_new->Tr_BA_Main_Code;
    //   $main_ba->BA_Type_Code      = $request->BA_Type_Code;
    //   $main_ba->BA_Admin          = $request->BA_Admin;
    //   $main_ba->Admin_Div         = $request->Admin_Div;
    //   $main_ba->User_Code         = $request->User_Code;
    //   $main_ba->BA_Note           = $request->BA_Note;
    //   $main_ba->Date_BA           = $request->Date_BA;
    //   $main_ba->Division_Code     = $request->Division_Code;
    //   $main_ba->Position_Code     = $request->Position_Code;
    //   $main_ba->Category_Code     = $request->Category_Code;
    //   $main_ba->ba_status         = 'Berita Acara';
    //   $main_ba->ms_fraud          = $request->ms_fraud;
    //   $main_ba->jenis             = $request->jenis;
    //   $main_ba->ms_kasus          = $request->ms_kasus;
    //   $main_ba->Location_Code     = $request->Location_Code;
    //   $main_ba->Company_Code      = $request->Company_Code;
    //   $main_ba->mengetahui1       = $request->mengetahui1;
    //   $main_ba->atasan1           = $request->atasan1;
    //   $main_ba->mengetahui2       = $request->mengetahui2;
    //   $main_ba->atasan2           = $request->atasan2;
    //   $main_ba->perlu_approval    = $request->perlu_approval;
    //   $main_ba->created_at        = Carbon::now();
    //   $main_ba->rec_status        = '1';
    //   $main_ba->save();

      $ba_kronologi = new Tr_BA_Kronologi();
      $ba_kronologi->tr_ba_kronologi_code = 'Kronologi' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
      $ba_kronologi->tr_ba_main_code = $main_ba_new->Tr_BA_Main_Code;
      $ba_kronologi->kronlogi = $request->kronlogi;
      $ba_kronologi->save();

      //poto 1
      $ba_doc = new BA_docs();
      $ba_doc->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

      if($request->file('file_path'))
      {
          $file= $request->file('file_path');
          $filename= date('YmdHi').$file->getClientOriginalName();
          $file-> move(public_path('upload'), $filename);
          $ba_doc->file_path = 'upload/' . $filename;
      }
      $ba_doc->save();

      //poto 2
      $ba_doc2 = new BA_docs2();
      $ba_doc2->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

      if($request->file('file_path2'))
      {
          $file= $request->file('file_path2');
          $filename= date('YmdHi').$file->getClientOriginalName();
          $file-> move(public_path('upload'), $filename);
          $ba_doc2->file_path2 = 'upload/' . $filename;
      }
      // dd($ba_doc2);die;
      $ba_doc2->save();
//  dd('lucu gitu2');
      $main_ba = Tr_BA_Main_New::where('Tr_BA_Main_Code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
    // dd($main_ba_new->MS_Detail_Kasus);
      $dok1 = BA_docs::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
 // Setup a filename 
        $documentFileName = $main_ba_new->Tr_BA_Main_Code.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
            $kronologi = ""; 
			if(isset($ba_kronologi->kronlogi) ){
				$kronologi = $ba_kronologi->kronlogi;
			}
      
      $fraud = '' ;
      if($main_ba_new->CekFraud == '1'){
         $fraud = 'Iya'; 
      } 
      else{
          $fraud = 'Tidak';  
      }
      $docsx1 = '';
      $docs1 = "upload/logohgs.jpg";
        if(!empty($dok1)){
            $docs1 = url('/'.$dok1->file_path);
            if($docs1 == url('/')){
                $docsx1 = '';
            }
            else{
                $docsx1 = '<img width="250" height="130" src="'.$docs1.'">';
            }
        }
      $docsx2 = '';  
      $docs2 = "upload/logohgs.jpg";
        if(!empty($dok2)){
            $docs2 = url('/'.$dok2->file_path2);
            if($docs2 == url('/')){
                $docsx2 = '';
            }
            else{
                $docsx2 = '<img width="250" height="130" src="'.$docs2.'">';
            }
        }      
    
        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Berita Acara Kejadian</center></h3>
                  <hr/>
                  <br>
  <table style="width: 100%;">
  <thead>
    <tr>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Code</td><td>: '.$main_ba->Tr_BA_Main_Code.' </td>
      <td>Perusahaan</td><td>: '.$main_ba->rec_comcode.'</td>
    </tr>
    <tr>
      <td>Kategori</td><td>: '.$main_ba->Ms_BA_type_Code.'</td>
      <td>Kasus</td><td>: '.$main_ba->Ms_Kasus.'</td>
    </tr>
    <tr>
      <td>Tanggal BA</td><td>: '.date_format(date_create($main_ba->created_at),"d/m/Y").' </td>
      <td>Tanggal Peristiwa</td><td>: '.date_format(date_create($main_ba->Date_BA),"d/m/Y").' </td>
    </tr>
    <tr>
      <td>User Input</td><td>: '.$main_ba->Ms_Pelapor_Code.' </td>
      <td>Divisi yang Input</td><td>: '.$main_ba->Ms_Pelapor_Div.' </td>
    </tr>
    <tr>
      <td>Pelaku</td><td>: '.$main_ba->Ms_Emp_Code.' </td>
      <td>Divisi Pelaku</td><td> : '.$main_ba->Ms_Emp_Div.' </td>
    </tr>
    <tr>
      <td>Lokasi</td><td>: '.$main_ba->rec_areacode.'</td>
      <td>Detail Kasus</td><td>: '.$main_ba->MS_Detail_Kasus.'</td>
    </tr>  
    <tr>
      <td><strong>Fraud ?</strong></td><td>: 
        '.$fraud.'
      </td>
      <td></td><td></td>
    </tr>
    </tbody>
</table>
<br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">
                        '.$kronologi.' 
                      </div>
          <br>

                      <center>
                        <h3>
                           Dokumen
                         </h3>
                       </center>

                       <table class="table table-bordered mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                  <td>'.$docsx1.'
                                  </td>
                                  <td>'.$docsx2.'
                                  </td>
                            </tr>      
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-bordered mt-4" style="width: 100%;">
                      <thead>
                          <tr>
                              <th style="width: 5%;"> No. </th>
                              <th style="width: 30%;">PIC</th>
                              <th style="width: 30%;">Divisi</th>
                              <th style="width: 20%;"></th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                <td>&nbsp; &nbsp; 1</td>
                                <td>'.$main_ba_new->Ms_Emp_Code.'</td>
                                <td>'.$main_ba_new->Ms_Emp_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 2</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Code.'</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 3</td>
                                <td>Tri Hartati</td>
                                <td>Manager Finance</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 4</td>
                                <td>Dwi Arif W / Yesy Tjandra</td>
                                <td>Manager Operasional</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 5</td>
                                <td>Cliff Rogers </td>
                                <td>General Manager</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 6</td>
                                <td>Diana L</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 7</td>
                                <td>Charles W / Diana L</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                      </tbody>
                  </table>

                <div class="card-body">
          <br>
          <br>  
          <table>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>
        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //      
      
      // dd($main_ba);die;
            //pdf
            // $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
            // $data = [
            //   'main_ba_new' => $main_ba_new, 
            //   //'detail'      => $detail,
            //   'ba_kronologi'=> $ba_kronologi, 
            //   'dok1'        => $dok1, 
            //   'dok2'        => $dok2,
            //   'datetime'    => $datetime
            // ];
            // $pdf = PDF::loadView('berita_acara.print_berita_acara_salahisi',$data);
            // return $pdf->download($main_ba_new->Tr_BA_Main_Code.'.pdf');       
      
    //return view('berita_acara.print_berita_acara_salahisi', compact('main_ba_new', 'dok1', 'dok2', 'ba_kronologi'));
    }

    // public function store_all_ba(Request $request)
    // {
   
    //   $main_ba = new BA_Main();
    //   $main_ba->Tr_BA_Code        = $request->Tr_BA_Code;
    //   $main_ba->BA_Type_Code      = $request->BA_Type_Code;
    //   $main_ba->BA_Admin          = $request->BA_Admin;
    //   $main_ba->Admin_Div         = $request->Admin_Div;
    //   $main_ba->User_Code         = $request->User_Code;
    //   $main_ba->BA_Note           = $request->BA_Note;
    //   $main_ba->Date_BA           = $request->Date_BA;
    //   $main_ba->Division_Code     = $request->Division_Code;
    //   $main_ba->Position_Code     = $request->Position_Code;
    //   $main_ba->Category_Code     = $request->Category_Code;
    //   $main_ba->ba_status         = 'Berita Acara';
    //   $main_ba->ms_fraud          = $request->ms_fraud;
    //   $main_ba->jenis             = $request->jenis;
    //   $main_ba->ms_kasus          = $request->ms_kasus;
    //   $main_ba->Location_Code     = $request->Location_Code;
    //   $main_ba->Company_Code      = $request->Company_Code;
    //   $main_ba->mengetahui1       = $request->mengetahui1;
    //   $main_ba->atasan1           = $request->atasan1;
    //   $main_ba->mengetahui2       = $request->mengetahui2;
    //   $main_ba->atasan2           = $request->atasan2;
    //   $main_ba->perlu_approval    = $request->perlu_approval;
    //   $main_ba->created_at        = Carbon::now();
    //   $main_ba->rec_status        = '1';
    //   $main_ba->save();

    //   $ba_kronologi = new Tr_BA_Kronologi();
    //   $ba_kronologi->tr_ba_kronologi_code = 'Auto number';
    //   $ba_kronologi->tr_ba_main_code = $main_ba->Tr_BA_Code;
    //   $ba_kronologi->kronlogi = $request->kronlogi;
    //   $ba_kronologi->save();

    //   $ba_doc = new BA_docs();
    //   $ba_doc->ba_main_code = $main_ba->Tr_BA_Code;

    //   if($request->file('file_path'))
    //   {
    //       $file= $request->file('file_path');
    //       $filename= date('YmdHi').$file->getClientOriginalName();
    //       $file-> move(public_path('upload'), $filename);
    //       $ba_doc->file_path = 'upload/' . $filename;
    //   }
    //   $ba_doc->save();

    //   $ba_doc2 = new BA_docs2();
    //   $ba_doc2->ba_main_code = $main_ba->Tr_BA_Code;

    //   if($request->file('file_path2'))
    //   {
    //       $file= $request->file('file_path2');
    //       $filename= date('YmdHi').$file->getClientOriginalName();
    //       $file-> move(public_path('upload'), $filename);
    //       $ba_doc2->file_path2 = 'upload/' . $filename;
    //   }
    //   $ba_doc2->save();

    //   $main_ba = BA_Main::where('Tr_BA_Code', '=', $main_ba->Tr_BA_Code )->first();
    //   $dok1 = BA_docs::where('ba_main_code', '=', $main_ba->Tr_BA_Code )->first();
    //   $dok2 = BA_docs2::where('ba_main_code', '=', $main_ba->Tr_BA_Code )->first();
    //   $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba->Tr_BA_Code)->first();
    // return view('berita_acara.print_berita_acara_salahisi', compact('main_ba', 'dok1', 'dok2', 'ba_kronologi'));
    // }

    public function print_ba_user(Request $request, $id)
    {
      $main_ba = BA_Main::where('Tr_BA_Code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba->Tr_BA_Code)->first();
      return view('berita_acara.print_ba_user', compact('main_ba', 'dok1', 'dok2', 'ba_kronologi'));
    }
    // Validasi Koordinator
    public function validasi_ba_koord()
    {
      $user = auth()->user();
      
      $main_ba = DB::connection('mysql')->select("
      SELECT
      main.Tr_BA_Main_Code,
      main.created_at,
      main.Ms_Pelapor_Code,
      main.Ms_Pelapor_Div,
      main.Ms_Emp_Div,
      main.Ms_Emp_Code,
      main.rec_usercreated,
      main.Ms_Kasus,
      main.MS_Detail_Kasus,
      revisi_h.user_created as User_Code,
      revisi_h.note as BA_Note

      FROM Tr_Ba_Main_New main
      left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code

      left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
      WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval is null and main.Cekrevisi = '1'
      and main.Ms_Pelapor_Div ='$user->ms_divisi' GROUP BY main.Tr_BA_Main_Code 
      order by main.created_at DESC
      ");

      return view ('berita_acara.validasi_ba_koord', compact('main_ba'));
    }
    public function detail_validasi_koord(Request $request, $id)
    {
      // dd($id);die;
      $user = auth()->user();
      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
      
      return view('berita_acara.detail_validasi_koord', compact('user','main_ba_new', 'detail','ba_kronologi', 'dok1', 'dok2'));

    }

    public function store_validasi1_koord(Request $request,$id)
    {

      $keputusan = $request->input('keputusan');
      
      if ($keputusan == 'setuju')
      {
        $user = auth()->user();

        $tracking_approval = new tr_approval_ba_tracking();
        $tracking_approval->rec_comcode           = $user->ms_company;
        $tracking_approval->approval_ba_code      = "AutoNumber";
        $tracking_approval->approval_ba_main_code = $id;
        $tracking_approval->approval_ba_tracking  = 0;
        $tracking_approval->approval_ba_desc      = "Approved Koordinator";
        $tracking_approval->pic                   = $user->username;
        $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
        $tracking_approval->note                  = $request->note3;
        $tracking_approval->status_approve        = 'Approved';
        $tracking_approval->save();

        $main_ba = Tr_BA_Revisi::where('Tr_BA_Main_Code', $id)
        ->update([
            'Cek_Koor_Approval'  => '1',
            'Date_Koor_Approved' => Carbon::now(),
            'Koor_Code'          => $user->username,
            'Koor_Note'          => $request->note3
        ]);

        $main_ba = DB::connection('mysql')->select("
        SELECT
        main.*
        FROM Tr_Ba_Main_New main
        left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code
  
        left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
        WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval is null and main.Cekrevisi = '1'
        and main.Ms_Pelapor_Div ='$user->ms_divisi' 
        order by main.created_at DESC
        ");

        return view ('berita_acara.validasi_ba_koord', compact('main_ba'));
      }
      elseif ($keputusan == 'tidak_setuju')
      {
        $user = auth()->user();
        $tracking_approval = new tr_approval_ba_tracking();
        $tracking_approval->rec_comcode           = $user->ms_company;
        $tracking_approval->approval_ba_code      = "AutoNumber";
        $tracking_approval->approval_ba_main_code = $id;
        $tracking_approval->approval_ba_tracking  = 0;
        $tracking_approval->approval_ba_desc      = "Approved Koordinator";
        $tracking_approval->pic                   = $user->username;
        $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
        $tracking_approval->note                  = $request->note3;
        $tracking_approval->status_approve        = 'Denied';
        $tracking_approval->save();

        // $main_ba = BA_Main::where('Tr_BA_Code', $id)
        // ->update([
        //     'mengetahui_koord' => $user->username,
        //     'note_koord' => $request->note3,
        //     'ba_status' => 'Denied'
        // ]);
        $main_ba = Tr_BA_Revisi::where('Tr_BA_Main_Code', $id)
        ->update([
            'Cek_Koor_Approval'  => '2',
            'Date_Koor_Approved' => Carbon::now(),
            'Koor_Code'          => $user->username,
            'Koor_Note'          => $request->note3
        ]);
        $main_ba = DB::connection('mysql')->select("
        SELECT
        main.*
        FROM Tr_Ba_Main_New main
        left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code
  
        left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
        WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval is null
        and main.Ms_Pelapor_Div ='$user->ms_divisi' 
        order by main.created_at DESC
        ");


        return view ('berita_acara.validasi_ba_koord', compact('main_ba'));
      }
    }

    //   $user = auth()->user();
    //   $tracking_approval = new tr_approval_ba_tracking();
    //   $tracking_approval->rec_comcode           = $user->ms_company;
    //   $tracking_approval->approval_ba_code      = "AutoNumber";
    //   $tracking_approval->approval_ba_main_code = $id;
    //   $tracking_approval->approval_ba_tracking  = 0;
    //   $tracking_approval->approval_ba_desc      = "Approved Koordinator";
    //   $tracking_approval->pic                   = $user->username;
    //   $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
    //   $tracking_approval->note                  = $request->note3;
    //   $tracking_approval->save();

    //   $main_ba = BA_Main::where('Tr_BA_Code', $id)
    //   ->update([
    //       'mengetahui_koord' => $user->username,
    //       'note_koord' => $request->note3,
    //       'ba_status' => 'Request'
    //   ]);

    //   $main_ba = DB::connection('mysql')->select("
    //   SELECT
    //   *
    //   FROM tr_ba_main
    //   WHERE rec_status ='1' and ba_status ='Request' and mengetahui_koord is null
    //   order by created_at DESC
    //   ");
    //   return view ('berita_acara.validasi_ba_koord', compact('main_ba'));
    // }

    // Validasi Spv
    public function validasi_ba()
    {
      $user = auth()->user();
      
      if ($user->username == 'Fernando' )
      {
          $main_ba = DB::connection('mysql')->select("
          SELECT
          main.Tr_BA_Main_Code,
          main.created_at,
          main.Ms_Pelapor_Code,
          main.Ms_Pelapor_Div,
          main.Ms_Emp_Div,
          main.Ms_Emp_Code,
          main.Ms_Kasus,
          main.MS_Detail_Kasus,
          revisi_h.note as BA_Desc
    
          FROM Tr_Ba_Main_New main

          left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval is null
          and (main.Ms_Pelapor_Div ='Fleet'  or main.Ms_Pelapor_Div ='Dispatcher' or main.Ms_Pelapor_Div ='Pic Project')
          order by main.created_at DESC
          ");
      }
       else if ($user->username == 'ifanuella Reinaldo')
      {
          $main_ba = DB::connection('mysql')->select("
          SELECT
          main.Tr_BA_Main_Code,
          main.created_at,
          main.Ms_Pelapor_Code,
          main.Ms_Pelapor_Div,
          main.Ms_Emp_Div,
          main.Ms_Emp_Code,
          main.Ms_Kasus,
          main.MS_Detail_Kasus,
          revisi_h.note as BA_Desc
    
          FROM Tr_Ba_Main_New main

          left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval is null
          and (main.Ms_Pelapor_Div ='Fleet'  or main.Ms_Pelapor_Div ='Dispatcher' or main.Ms_Pelapor_Div ='Pic Project' or main.Ms_Pelapor_Div ='Gudang' or main.Ms_Pelapor_Div ='Security')
          order by main.created_at DESC
          ");
      }
      else
      {
          $main_ba = DB::connection('mysql')->select("
          SELECT
          main.Tr_BA_Main_Code,
          main.created_at,
          main.Ms_Pelapor_Code,
          main.Ms_Pelapor_Div,
          main.Ms_Emp_Div,
          main.Ms_Emp_Code,
          main.Ms_Kasus,
          main.MS_Detail_Kasus,
          revisi_h.note as BA_Desc
    
          FROM Tr_Ba_Main_New main
          left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval is null
          and main.Ms_Pelapor_Div ='$user->ms_divisi' 
          order by main.created_at DESC
      ");
      }
      
      return view ('berita_acara.validasi_ba', compact('main_ba'));
    }
    public function detail_validasi(Request $request, $id)
    {
      $user = auth()->user();
      $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
      $tracking = tr_approval_ba_tracking::where('approval_ba_main_code', '=', $id)->first();
    //   dd($user->ms_divisi);die;
      if ($tracking == '')
      {
        session()->flash('success', 'BA Belum Di Approve Koordinator!');
          return redirect('validasi_ba');
      }
      else if ($tracking == 'null')
      {
        session()->flash('success', 'BA Belum Di Approve Koordinator!');
          return redirect('validasi_ba');
      }
      else if ($user->ms_divisi == 'Purchasing')
      {
        return view('berita_acara.detail_validasi', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
      }
      else 
      {
        return view('berita_acara.detail_validasi', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
      }

        // return view('berita_acara.detail_validasi', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));

    }
    public function store_validasi1(Request $request,$id)
    {
      $keputusan = $request->input('keputusan');

        if ($keputusan == 'setuju')
        {
            $user = auth()->user();
            $tracking_approval = new tr_approval_ba_tracking();
            $tracking_approval->rec_comcode           = $user->ms_company;
            $tracking_approval->approval_ba_code      = "AutoNumber";
            $tracking_approval->approval_ba_main_code = $id;
            $tracking_approval->approval_ba_tracking  = 1;
            $tracking_approval->approval_ba_desc      = "Approved Supervisor";
            $tracking_approval->pic                   = $user->username;
            $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
            $tracking_approval->note                  = $request->note2;
            $tracking_approval->status_approve        = 'Approved';
            $tracking_approval->save();


            DB::connection('mysql')->table('Tr_BA_Revisi')
            ->where('Tr_BA_Main_Code', $id)
            ->update([
                      'Cek_Spv_Approval'  => "1",
                      'Date_SPV_Approved' => Carbon::now(),
                      'Spv_Code'          => $user->username,
                      'Spv_Note'          => $request->note3
                    ]);
            $main_ba = DB::connection('mysql')->select("
              SELECT
              main.*
              FROM Tr_Ba_Main_New as main
              left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
              WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval is null
              order by main.created_at DESC
              ");
            return redirect('validasi_ba');
      }
      elseif ($keputusan == 'tidak_setuju')
      {
        $user = auth()->user();
        $tracking_approval = new tr_approval_ba_tracking();
        $tracking_approval->rec_comcode           = $user->ms_company;
        $tracking_approval->approval_ba_code      = "AutoNumber";
        $tracking_approval->approval_ba_main_code = $id;
        $tracking_approval->approval_ba_tracking  = 1;
        $tracking_approval->approval_ba_desc      = "Approved Supervisor";
        $tracking_approval->pic                   = $user->username;
        $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
        $tracking_approval->note                  = $request->note2;
        $tracking_approval->status_approve        = 'Denied';
        $tracking_approval->save();

        // $main_ba = BA_Main::where('Tr_BA_Code', $id)
        // ->update([
        //     'mengetahui1' => $request->username2,
        //     'note2' => $request->note2,
        //     'ba_status' => 'Denied'
        // ]);

        DB::connection('mysql')->table('Tr_BA_Revisi')
        ->where('Tr_BA_Main_Code', $id)
        ->update([
                  'Cek_Spv_Approval'  => "2",
                  'Date_SPV_Approved' => Carbon::now(),
                  'Spv_Code'          => $user->username,
                  'Spv_Note'          => $request->note3
                ]);        

        $main_ba = DB::connection('mysql')->select("
          SELECT
          main.*
          FROM Tr_Ba_Main_New as main
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval is null
          order by main.created_at DESC
          ");
        return redirect('validasi_ba');
      }

    }
    //Validasi HRD
    public function validasi_ba2()
    {
      $user = auth()->user();
      $main_ba = DB::connection('mysql')->select("
      SELECT
      main.*
      FROM Tr_Ba_Main_New as main
      left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
      WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval is null
      order by main.created_at DESC
      ");
      
      if( $user->ms_divisi == 'HR')
      {
        return view ('berita_acara.validasi_ba2', compact('main_ba'));
      }

     else
       {
         Session::flash('warning', 'Anda tidak memiliki izin untuk mengakses halaman ini.');

         return view('berita_acara.error');
       }
    }
    public function detail_validasi2(Request $request, $id)
    {
      $user = auth()->user();
      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
      $tracking = DB::connection('mysql')->select("
      SELECT
      tracking.approval_ba_tracking,
      tracking.approval_ba_desc,
      tracking.pic,
      tracking.note
      FROM Tr_Ba_Main_New mainya
      left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Main_Code = tracking.approval_ba_main_code
      where approval_ba_main_code = '$id'
      ");
      // dd($tracking);die;

      return view('berita_acara.detail_validasi2', compact('user','main_ba_new', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
    }

    public function store_validasi2(Request $request,$id)
    {
      $keputusan = $request->input('keputusan');

        if ($keputusan == 'setuju')
        {

          
            $user = auth()->user();
            $tracking_approval = new tr_approval_ba_tracking();
            $tracking_approval->rec_comcode           = $user->ms_company;
            $tracking_approval->approval_ba_code      = "AutoNumber";
            $tracking_approval->approval_ba_main_code = $id;
            $tracking_approval->approval_ba_tracking  = 2;
            $tracking_approval->approval_ba_desc      = "HRD";
            $tracking_approval->pic                   = $user->username;
            $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
            $tracking_approval->note                  = $request->note3;
            $tracking_approval->status_approve        = 'Approved';
            $tracking_approval->save();

            // $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', $id)
            // ->update([
            //     //'mengetahui2' => $request->username3,
            //     //'note3' => $request->note3,
            //     'CekPelanggaran' => '3'
            // ]);
            DB::connection('mysql')->table('Tr_BA_Revisi')
            ->where('Tr_BA_Main_Code', $id)
            ->update([
                      'Cek_HR_Approval'  => "1",
                      'Date_HR_Approved' => Carbon::now(),
                      'HR_Code'          => $user->username,
                      'HR_Note'          => $request->note3
                    ]);        

            $main_ba = DB::connection('mysql')->select("
                    SELECT
                    main.*
                    FROM Tr_Ba_Main_New as main
                    left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
                    WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval is null
                    order by main.created_at DESC
                    ");

            return view('berita_acara.validasi_ba2', compact('main_ba'));
        }
        else if ($keputusan == 'tidak_setuju')
        {
            $user = auth()->user();
            $tracking_approval = new tr_approval_ba_tracking();
            $tracking_approval->rec_comcode           = $user->ms_company;
            $tracking_approval->approval_ba_code      = "AutoNumber";
            $tracking_approval->approval_ba_main_code = $id;
            $tracking_approval->approval_ba_tracking  = 2;
            $tracking_approval->approval_ba_desc      = "HRD";
            $tracking_approval->pic                   = $user->username;
            $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
            $tracking_approval->note                  = $request->note3;
            $tracking_approval->status_approve        = 'Denied';
            $tracking_approval->save();

            // $main_ba = Tr_Ba_Main_New::where('Tr_BA_Code', $id)
            // ->update([
            //     //'mengetahui2' => $request->username3,
            //     //'note3' => $request->note3,
            //     'ba_status' => 'Denied'
            // ]);

            DB::connection('mysql')->table('Tr_BA_Revisi')
            ->where('Tr_BA_Main_Code', $id)
            ->update([
                      'Cek_HR_Approval'  => "2",
                      'Date_HR_Approved' => Carbon::now(),
                      'HR_Code'          => $user->username,
                      'HR_Note'          => $request->note3
                    ]);              

            $main_ba = DB::connection('mysql')->select("
                    SELECT
                    main.*
                    FROM Tr_Ba_Main_New
                    left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
                    WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval is null
                    order by main.created_at DESC
                    ");
            return view('berita_acara.validasi_ba2', compact('main_ba'));
        }

    }
    //Validasi Manager Finance
    public function validasi_ba3()
    {
      $user = auth()->user();
      $main_ba = DB::connection('mysql')->select("
      SELECT
      main.*
      FROM Tr_Ba_Main_New as main
      left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
      WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and Cek_Finance_Approval is null
      order by main.created_at DESC
      ");
      
      if( $user->sub_divisi == 'Manager Finance')
      {
        return view ('berita_acara.validasi_ba3', compact('main_ba'));
      }

      else
       {
         Session::flash('warning', 'Anda tidak memiliki izin untuk mengakses halaman ini.');

         return view('berita_acara.error');
       }
    }
    public function detail_validasi3(Request $request, $id)
    {
      $user = auth()->user();
      $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();

      $tracking = DB::connection('mysql')->select("
      SELECT
      tracking.approval_ba_tracking,
      tracking.approval_ba_desc,
      tracking.pic,
      tracking.note
      FROM Tr_Ba_Main_New mainya
      left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Main_Code = tracking.approval_ba_main_code
      where approval_ba_main_code = '$id'
      ");
      return view('berita_acara.detail_validasi3', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
    }
    public function store_validasi3(Request $request,$id)
    {
      $keputusan = $request->input('keputusan');

      if ($keputusan == 'setuju')
      {
          $user = auth()->user();
          $tracking_approval = new tr_approval_ba_tracking();
          $tracking_approval->rec_comcode           = $user->ms_company;
          $tracking_approval->approval_ba_code      = "AutoNumber";
          $tracking_approval->approval_ba_main_code = $id;
          $tracking_approval->approval_ba_tracking  = 3;
          $tracking_approval->approval_ba_desc      = "Manager Finance";
          $tracking_approval->pic                   = $user->username;
          $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
          $tracking_approval->note                  = $request->note3;
          $tracking_approval->status_approve        = 'Approved';
          $tracking_approval->save();

          // $main_ba = BA_Main::where('Tr_BA_Code', $id)
          // ->update([
          //     'mengetahui3' => $user->username,
          //     'note4' => $request->note3,
          //     'ba_status' => 'pending'
          // ]);

          DB::connection('mysql')->table('Tr_BA_Revisi')
          ->where('Tr_BA_Main_Code', $id)
          ->update([
                    'Cek_Finance_Approval'  => "1",
                    'Finance_Date' => Carbon::now(),
                    'Finance_Code'          => $user->username,
                    'Finance_Note'          => $request->note3
                  ]);                

          $main_ba = DB::connection('mysql')->select("
            SELECT
            main.*
            FROM Tr_Ba_Main_New as main
            left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
            WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and Cek_Finance_Approval is null
            order by main.created_at DESC
            ");
          return view('berita_acara.validasi_ba3', compact('main_ba'));
      }

      else if ($keputusan == 'tidak_setuju')
      {
          $user = auth()->user();
          $tracking_approval = new tr_approval_ba_tracking();
          $tracking_approval->rec_comcode           = $user->ms_company;
          $tracking_approval->approval_ba_code      = "AutoNumber";
          $tracking_approval->approval_ba_main_code = $id;
          $tracking_approval->approval_ba_tracking  = 3;
          $tracking_approval->approval_ba_desc      = "Manager Finance";
          $tracking_approval->pic                   = $user->username;
          $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
          $tracking_approval->note                  = $request->note3;
          $tracking_approval->status_approve        = 'Denied';
          $tracking_approval->save();

          // $main_ba = BA_Main::where('Tr_BA_Code', $id)
          // ->update([
          //     'mengetahui3' => $user->username,
          //     'note4' => $request->note3,
          //     'ba_status' => 'Denied'
          // ]);

          DB::connection('mysql')->table('Tr_BA_Revisi')
          ->where('Tr_BA_Main_Code', $id)
          ->update([
                    'Cek_Finance_Approval'  => "2",
                    'Finance_Date' => Carbon::now(),
                    'Finance_Code'          => $user->username,
                    'Finance_Note'          => $request->note3
                  ]);  

          $main_ba = DB::connection('mysql')->select("
          SELECT
          main.*
          FROM Tr_Ba_Main_New as main
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and Cek_Finance_Approval is null
          order by main.created_at DESC
            ");
          return view('berita_acara.validasi_ba3', compact('main_ba'));
      }

    }

    //Validasi Manager Ops
    public function validasi_manager()
    {

      $user = auth()->user();
      $main_ba = DB::connection('mysql')->select("
      SELECT main.*
      FROM Tr_Ba_Main_New as main
      left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
      WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval is null
      order by main.created_at DESC
      ");

      return view ('berita_acara.validasi_manager', compact('main_ba'));
    }

    public function detail_validasi_manager(Request $request, $id)
    {
      $user = auth()->user();
      $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();

      $tracking = DB::connection('mysql')->select("
      SELECT
      tracking.approval_ba_tracking,
      tracking.approval_ba_desc,
      tracking.pic,
      tracking.note
      FROM Tr_Ba_Main_New mainya
      left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Main_Code = tracking.approval_ba_main_code
      where approval_ba_main_code = '$id'
      ");
      return view('berita_acara.detail_validasi_manager', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
    }
    public function store_validasi_manager(Request $request,$id)
    {
      $keputusan = $request->input('keputusan');

      if ($keputusan == 'setuju')
      {
          $user = auth()->user();
          $tracking_approval = new tr_approval_ba_tracking();
          $tracking_approval->rec_comcode           = $user->ms_company;
          $tracking_approval->approval_ba_code      = "AutoNumber";
          $tracking_approval->approval_ba_main_code = $id;
          $tracking_approval->approval_ba_tracking  = 4;
          $tracking_approval->approval_ba_desc      = "Manager Operasional";
          $tracking_approval->pic                   = $user->username;
          $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
          $tracking_approval->note                  = $request->note3;
          $tracking_approval->status_approve        = 'Approved';
          $tracking_approval->save();

          // $main_ba = BA_Main::where('Tr_BA_Code', $id)
          // ->update([
          //     'mengetahui4' => $user->username,
          //     'note4' => $request->note3,
          //     'ba_status' => 'pending'
          // ]);

          DB::connection('mysql')->table('Tr_BA_Revisi')
          ->where('Tr_BA_Main_Code', $id)
          ->update([
                    'CeK_Mgt_Approval'  => "1",
                    'Mgt_Date' =>  Carbon::now(),
                    'Mgt_Code'          => $user->username,
                    'Mgt_Note'          => $request->note3
                  ]);  

          $main_ba = DB::connection('mysql')->select("
          SELECT main.*
          FROM Tr_Ba_Main_New as main
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and  main.rec_comcode ='$user->ms_company' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval is null
          order by main.created_at DESC
            ");

          return view('berita_acara.validasi_manager', compact('main_ba'));
      }
      else if ($keputusan == 'tidak_setuju')
      {
          $user = auth()->user();
          $tracking_approval = new tr_approval_ba_tracking();
          $tracking_approval->rec_comcode           = $user->ms_company;
          $tracking_approval->approval_ba_code      = "AutoNumber";
          $tracking_approval->approval_ba_main_code = $id;
          $tracking_approval->approval_ba_tracking  = 4;
          $tracking_approval->approval_ba_desc      = "Manager Operasional";
          $tracking_approval->pic                   = $user->username;
          $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
          $tracking_approval->note                  = $request->note3;
          $tracking_approval->status_approve        = 'Denied';
          $tracking_approval->save();

          // $main_ba = BA_Main::where('Tr_BA_Code', $id)
          // ->update([
          //     'mengetahui4' => $user->username,
          //     'note4' => $request->note3,
          //     'ba_status' => 'Denied'
          // ]);

          DB::connection('mysql')->table('Tr_BA_Revisi')
          ->where('Tr_BA_Main_Code', $id)
          ->update([
                    'CeK_Mgt_Approval'  => "1",
                    'Mgt_Date' =>  Carbon::now(),
                    'Mgt_Code'          => $user->username,
                    'Mgt_Note'          => $request->note3
                  ]);  

          $main_ba = DB::connection('mysql')->select("
          SELECT main.*
          FROM Tr_Ba_Main_New as main
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and  main.rec_comcode ='$user->ms_company' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval is null
          order by main.created_at DESC
            ");

          return view('berita_acara.validasi_manager', compact('main_ba'));
      }
    }

     //Validasi GM
     public function validasi_gm()
     {
       $user = auth()->user();

       $main_ba = DB::connection('mysql')->select("
       SELECT main.*
       FROM Tr_Ba_Main_New as main
       left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
       WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval = '0'
       order by main.created_at DESC
       ");

       if( $user->ms_divisi == 'General Manager')
      {
        return view ('berita_acara.validasi_gm', compact('main_ba'));
      }

        else
       {
         Session::flash('warning', 'Anda tidak memiliki izin untuk mengakses halaman ini.');

         return view('berita_acara.error');
       }
     }

     public function detail_validasi_gm(Request $request, $id)
     {
       $user = auth()->user();
       $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
       $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
       $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
       $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
       $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();

       $tracking = DB::connection('mysql')->select("
       SELECT
       tracking.approval_ba_tracking,
       tracking.approval_ba_desc,
       tracking.pic,
       tracking.note
       FROM Tr_Ba_Main_New mainya
       left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Main_Code = tracking.approval_ba_main_code
       where approval_ba_main_code = '$id'
       ");
       return view('berita_acara.detail_validasi_gm', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
     }
     public function store_validasi_gm(Request $request,$id)
     {

      $keputusan = $request->input('keputusan');

        if ($keputusan == 'setuju')
        {
            $user = auth()->user();
            $tracking_approval = new tr_approval_ba_tracking();
            $tracking_approval->rec_comcode           = $user->ms_company;
            $tracking_approval->approval_ba_code      = "AutoNumber";
            $tracking_approval->approval_ba_main_code = $id;
            $tracking_approval->approval_ba_tracking  = 5;
            $tracking_approval->approval_ba_desc      = "General Manager";
            $tracking_approval->pic                   = $user->username;
            $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
            $tracking_approval->note                  = $request->note3;
            $tracking_approval->status_approve        = 'Approved';
            $tracking_approval->save();

            // $main_ba = BA_Main::where('Tr_BA_Code', $id)
            // ->update([
            //     'mengetahui5' => $user->username,
            //     'note5' => $request->note3,
            //     'ba_status' => 'pending'
            // ]);

            DB::connection('mysql')->table('Tr_BA_Revisi')
            ->where('Tr_BA_Main_Code', $id)
            ->update([
                      'CeK_Gm_Approval'  => "1",
                      'Gm_Date' =>  Carbon::now(),
                      'Gm_Code'          => $user->username,
                      'Gm_Note'          => $request->note3
                    ]);              

            $main_ba = DB::connection('mysql')->select("
            SELECT main.*
            FROM Tr_Ba_Main_New as main
            left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
            WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval = '0'
            order by main.created_at DESC
              ");
            return view('berita_acara.validasi_gm', compact('main_ba'));
        }
        else if ($keputusan == 'tidak_setuju')
        {

            $user = auth()->user();
            $tracking_approval = new tr_approval_ba_tracking();
            $tracking_approval->rec_comcode           = $user->ms_company;
            $tracking_approval->approval_ba_code      = "AutoNumber";
            $tracking_approval->approval_ba_main_code = $id;
            $tracking_approval->approval_ba_tracking  = 5;
            $tracking_approval->approval_ba_desc      = "General Manager";
            $tracking_approval->pic                   = $user->username;
            $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
            $tracking_approval->note                  = $request->note3;
            $tracking_approval->status_approve        = 'Denied';
            $tracking_approval->save();

            // $main_ba = BA_Main::where('Tr_BA_Code', $id)
            // ->update([
            //     'mengetahui5' => $user->username,
            //     'note5' => $request->note3,
            //     'ba_status' => 'Denied'
            // ]);

            DB::connection('mysql')->table('Tr_BA_Revisi')
            ->where('Tr_BA_Main_Code', $id)
            ->update([
                      'CeK_Gm_Approval'  => "2",
                      'Gm_Date' =>  Carbon::now(),
                      'Gm_Code'          => $user->username,
                      'Gm_Note'          => $request->note3
                    ]);     

            $main_ba = DB::connection('mysql')->select("
            SELECT main.*
            FROM Tr_Ba_Main_New as main
            left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
            WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval = '0'
            order by main.created_at DESC
              ");
            return view('berita_acara.validasi_gm', compact('main_ba'));
        }
     }

      //Validasi BOD
      public function validasi_it()
      {
        $user = auth()->user();
          
        $main_ba = DB::connection('mysql')->select("
        SELECT main.*
        FROM Tr_Ba_Main_New as main
        left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
        WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval  = '1' and CeK_It_Approval = '0'
        order by main.created_at DESC
        ");
        
         if( $user->ms_divisi == 'Software')
      {
        return view ('berita_acara.validasi_it', compact('main_ba'));
      }

     else
       {
         Session::flash('warning', 'Anda tidak memiliki izin untuk mengakses halaman ini.');

         return view('berita_acara.error');
       }
        
      }
      public function detail_validasi_it(Request $request, $id)
      {
        $user = auth()->user();
        $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
        $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
        $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
        $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
        $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();

        $tracking = DB::connection('mysql')->select("
        SELECT
        tracking.approval_ba_tracking,
        tracking.approval_ba_desc,
        tracking.pic,
        tracking.note
        FROM Tr_Ba_Main_New mainya
        left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Main_Code = tracking.approval_ba_main_code
        where approval_ba_main_code = '$id'
        ");

        return view('berita_acara.detail_validasi_it', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
        // return view('berita_acara.detail_validasi_bod', compact('main_ba', 'dok1', 'dok2', 'user'));
      }

      public function store_validasi_it(Request $request,$id)
      {
        $keputusan = $request->input('keputusan');

        if ($keputusan == 'setuju')
        {
            $user = auth()->user();
            $tracking_approval = new tr_approval_ba_tracking();
            $tracking_approval->rec_comcode           = $user->ms_company;
            $tracking_approval->approval_ba_code      = "AutoNumber";
            $tracking_approval->approval_ba_main_code = $id;
            $tracking_approval->approval_ba_tracking  = 6;
            $tracking_approval->approval_ba_desc      = "IT";
            $tracking_approval->pic                   = $user->username;
            $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
            $tracking_approval->note                  = $request->note3;
            $tracking_approval->status_approve        = 'Approved';
            $tracking_approval->save();

            // $main_ba = BA_Main::where('Tr_BA_Code', $id)
            // ->update([
            //     'mengetahui_it' => $user->username,
            //     'note_it' => $request->note3,
            //     'ba_status' => 'pending'
            // ]);

            DB::connection('mysql')->table('Tr_BA_Revisi')
            ->where('Tr_BA_Main_Code', $id)
            ->update([
                      'CeK_It_Approval'  => "1",
                      'It_Date' =>  Carbon::now(),
                      'It_Code'          => $user->username,
                      'It_Note'          => $request->note3
                    ]); 


            $main_ba = DB::connection('mysql')->select("
            SELECT main.*
            FROM Tr_Ba_Main_New as main
            left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
            WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval  = '1' and CeK_It_Approval = '0'
            order by main.created_at DESC
                ");
            return view('berita_acara.validasi_it', compact('main_ba'));
        }
        else if ($keputusan == 'tidak_setuju')
        {

            $user = auth()->user();
            $tracking_approval = new tr_approval_ba_tracking();
            $tracking_approval->rec_comcode           = $user->ms_company;
            $tracking_approval->approval_ba_code      = "AutoNumber";
            $tracking_approval->approval_ba_main_code = $id;
            $tracking_approval->approval_ba_tracking  = 6;
            $tracking_approval->approval_ba_desc      = "IT";
            $tracking_approval->pic                   = $user->username;
            $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
            $tracking_approval->note                  = $request->note3;
            $tracking_approval->status_approve        = 'Denied';
            $tracking_approval->save();

            // $main_ba = BA_Main::where('Tr_BA_Code', $id)
            // ->update([
            //     'mengetahui_it' => $user->username,
            //     'note_it' => $request->note3,
            //     'ba_status' => 'Denied'
            // ]);

            DB::connection('mysql')->table('Tr_BA_Revisi')
            ->where('Tr_BA_Main_Code', $id)
            ->update([
                      'CeK_It_Approval'  => "2",
                      'It_Date' =>  Carbon::now(),
                      'It_Code'          => $user->username,
                      'It_Note'          => $request->note3
                    ]); 

            $main_ba = DB::connection('mysql')->select("
            SELECT main.*
            FROM Tr_Ba_Main_New as main
            left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
            WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval  = '1' and CeK_It_Approval = '0'
            order by main.created_at DESC
                ");
            return view('berita_acara.validasi_it', compact('main_ba'));
        }
      }
    //Validasi BOD
    public function validasi_bod()
    {
      $user = auth()->user();
      $main_ba = DB::connection('mysql')->select("
      SELECT main.*
      FROM Tr_Ba_Main_New as main
      left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
      WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval  = '1' and CeK_It_Approval = '1' and CeK_Bod_Approval is null
      order by main.created_at DESC
      ");

     if( $user->ms_divisi == 'BOD')
      {
        return view ('berita_acara.validasi_bod', compact('main_ba'));
      }

     else
       {
         Session::flash('warning', 'Anda tidak memiliki izin untuk mengakses halaman ini.');

         return view('berita_acara.error');
       }
      
    }
    public function detail_validasi_bod(Request $request, $id)
    {
      $user = auth()->user();
      $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();

      $tracking = DB::connection('mysql')->select("
      SELECT
      tracking.approval_ba_tracking,
      tracking.approval_ba_desc,
      tracking.pic,
      tracking.note
      FROM Tr_Ba_Main_New mainya
      left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Main_Code = tracking.approval_ba_main_code
      where approval_ba_main_code = '$id'
      ");

      return view('berita_acara.detail_validasi_bod', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
      // return view('berita_acara.detail_validasi_bod', compact('main_ba', 'dok1', 'dok2', 'user'));
    }
    public function store_validasi_bod(Request $request,$id)
    {
      $keputusan = $request->input('keputusan');

      if ($keputusan == 'setuju')
      {
          $user = auth()->user();
          $tracking_approval = new tr_approval_ba_tracking();
          $tracking_approval->rec_comcode           = $user->ms_company;
          $tracking_approval->approval_ba_code      = "AutoNumber";
          $tracking_approval->approval_ba_main_code = $id;
          $tracking_approval->approval_ba_tracking  = 7;
          $tracking_approval->approval_ba_desc      = "BOD";
          $tracking_approval->pic                   = $user->username;
          $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
          $tracking_approval->note                  = $request->note3;
          $tracking_approval->status_approve        = 'Approved';
          $tracking_approval->save();

          // $main_ba = BA_Main::where('Tr_BA_Code', $id)
          // ->update([
          //     'ba_bod' => $request->username5,
          //     'note_bod' => $request->note5,
          //     'ba_status' => 'Approve'
          // ]);

          DB::connection('mysql')->table('Tr_BA_Revisi')
          ->where('Tr_BA_Main_Code', $id)
          ->update([
                    'CeK_Bod_Approval'  => "1",
                    'Bod_Date' =>  Carbon::now(),
                    'Bod_Code'          => $user->username,
                    'Bod_Note'          => $request->note3
                  ]);

          $main_ba = DB::connection('mysql')->select("
          SELECT main.*
          FROM Tr_Ba_Main_New as main
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval  = '1' and CeK_It_Approval = '1' and CeK_Bod_Approval is null
          order by main.created_at DESC
            ");
          return view('berita_acara.validasi_bod', compact('main_ba'));
      }
      else if ($keputusan == 'tidak_setuju')
      {
          $user = auth()->user();
          $tracking_approval = new tr_approval_ba_tracking();
          $tracking_approval->rec_comcode           = $user->ms_company;
          $tracking_approval->approval_ba_code      = "AutoNumber";
          $tracking_approval->approval_ba_main_code = $id;
          $tracking_approval->approval_ba_tracking  = 7;
          $tracking_approval->approval_ba_desc      = "BOD";
          $tracking_approval->pic                   = $user->username;
          $tracking_approval->approval_ba_divisi    = $user->ms_divisi;
          $tracking_approval->note                  = $request->note3;
          $tracking_approval->status_approve        = 'Denied';
          $tracking_approval->save();

          // $main_ba = BA_Main::where('Tr_BA_Code', $id)
          // ->update([
          //     'ba_bod' => $request->username5,
          //     'note_bod' => $request->note5,
          //     'ba_status' => 'Denied'
          // ]);

          DB::connection('mysql')->table('Tr_BA_Revisi')
          ->where('Tr_BA_Main_Code', $id)
          ->update([
                    'CeK_Bod_Approval'  => "2",
                    'Bod_Date' =>  Carbon::now(),
                    'Bod_Code'          => $user->username,
                    'Bod_Note'          => $request->note3
                  ]);          

          $main_ba = DB::connection('mysql')->select("
          SELECT main.*
          FROM Tr_Ba_Main_New as main
          left JOIN Tr_BA_Revisi on main.Tr_BA_Main_Code = Tr_BA_Revisi.Tr_BA_Main_Code
          WHERE main.rec_status ='1' and Tr_BA_Revisi.Cek_Koor_Approval = '1' and Cek_Spv_Approval = '1' and Cek_HR_Approval = '1' and CeK_Mgt_Approval = '1' and CeK_Gm_Approval  = '1' and CeK_It_Approval = '1' and CeK_Bod_Approval is null
          order by main.created_at DESC
            ");
          return view('berita_acara.validasi_bod', compact('main_ba'));
      }
    }

    public function index_request_revisi(Request $request)
   {
      $code_ba  = DB::connection('mysql')->select("
      SELECT Tr_BA_Code FROM `tr_ba_main` WHERE rec_status='1' and ba_status is null and mengetahui1 is null
      ");

      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
      $company = Ms_Company::all();
    //   $users = User::all();
    //   $users = DB::connection('mysql')->select("
    //   select  * from master_employees where emp_inactive ='1' and emp_subdivision !='driver' and emp_subdivision !='helper' and emp_subdivision !='motorist' ORDER BY emp_name asc
    //   ");
    $users = DB::connection('mysql_new')->SELECT("
      (SELECT 
          driver_id AS id, 
          driver_name AS emp_id,
          'Driver' AS divisi
      FROM ms_driver WHERE ms_driver.rec_status = '1')

      UNION ALL

      (SELECT 
          helper_id AS id, 
          helper_name AS emp_id,
          'Helper' AS divisi
      FROM ms_helper where ms_helper.rec_status = '1')

      UNION ALL

      (SELECT 
          e.Ms_Emp_Code AS id, 
          e.Emp_Name AS emp_id,
          d.div_id AS divisi
      FROM Ms_User_Emp e
      JOIN ms_division d ON e.emp_division = d.div_id
      where e.rec_status = '1')
      ");

      $jenis = DB::connection('mysql')->select("
      select * from ms_kasus_head where ms_type ='Request' and rec_status ='1'
      ");
      
      $ms_kasus = DB::connection('mysql')->select("
      select * from ms_kasus where ms_kasus_head1 ='01' and rec_status ='1'
      ");

      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_ba_main
      order by created_at desc
      LIMIT 1
      ");

      $twoChars = substr($user->username, 0, 3);

      foreach($last_id2 as $asas2)
      { $idnya2 = $asas2->id+1;}
      $ambilkode2=Tr_Ba_Main_New::where($request->Tr_BA_Main_Code)->get();
      $nambah2=count($ambilkode2)+1;
      if ($nambah2 <10000000)
      {
        $code_bas='BA'. '-'. $user->ms_divisi.'-'. date('Ydm').'-'."00".$idnya2;
      }
        // dd($ambilkode2);
      return view('berita_acara.request_revisi', compact('code_bas','user','lokasi', 'employee', 'divisi', 'jenis', 'company', 'ms_kasus', 'users'));
    }
    public function store_request_revisi(Request $request)
    {
      
      $timestamp        = Carbon::now()->timestamp;
	    $tanggalSekarang  = Carbon::now();
      $tahunSaatIni     = $tanggalSekarang->year;
      $weeks            = $tanggalSekarang->weekOfYear;
      // Tentukan rentang periode
      $startDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-01-01');
      $endDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-03-31');
      $startDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-04-01');
      $endDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-06-30');
      $startDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-07-01');
      $endDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-09-31');      
      $startDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-10-01');
      $endDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-12-31');

     if(Carbon::now()->between($startDate1, $endDate1)){
      $periodeQ = 'Q1';
     };
     if(Carbon::now()->between($startDate2, $endDate2)){
      $periodeQ = 'Q2';
     };
     if(Carbon::now()->between($startDate3, $endDate3)){
      $periodeQ = 'Q3';
     };                 
     if(Carbon::now()->between($startDate4, $endDate4)){
      $periodeQ = 'Q4';
     };
     if(Carbon::now()){
      $periodeQ = 'Q4';
     };
      $period_H = $request->User_Code . '-' .$tahunSaatIni.$periodeQ;
      do
      {
        $randomValue = mt_rand(100, 999);
        $autoNumber = $request->User_Code . '-' . $request->Category_Code . $weeks. $tahunSaatIni . $randomValue;
        $isUnique = !DB::table('Tr_Ba_Main_New')
            ->where('Tr_BA_Main_Code', $autoNumber)
            ->exists();
      }
      while (!$isUnique);
      
      $divisi_code = DB::connection('mysql_new')->SELECT("
      SELECT *
      FROM (
      (SELECT 
                driver_id AS id, 
                driver_name AS emp_id,
                'Driver' AS divisi
            FROM ms_driver WHERE ms_driver.rec_status = '1')

            UNION ALL

            (SELECT 
                helper_id AS id, 
                helper_name AS emp_id,
                'Helper' AS divisi
            FROM ms_helper where ms_helper.rec_status = '1')

            UNION ALL

            (SELECT 
                e.Ms_Emp_Code AS id, 
                e.Emp_Name AS emp_id,
                d.div_id AS divisi
            FROM Ms_User_Emp e
            JOIN ms_division d ON e.emp_division = d.div_id
            where e.rec_status = '1')
            ) AS all_employees
      WHERE id = '$request->User_Code'
      ");
      
      if ($divisi_code[0]->divisi != '') {
        $code_divisi = $divisi_code[0]->divisi;
      }

      $main_ba_new = new Tr_Ba_Main_New();
      $main_ba_new->Tr_BA_Main_Code        = $autoNumber;
      $main_ba_new->Ms_BA_type_Code        = 'BA Revisi';
      $main_ba_new->Ms_Emp_Code            = $request->User_Code;
      $main_ba_new->Ms_Emp_Div             = $code_divisi;
      $main_ba_new->Ms_Pelapor_Code        = $request->BA_Admin;
      $main_ba_new->Ms_Pelapor_Div         = $request->Admin_Div;
      $main_ba_new->Date_BA                = $request->Date_BA;
      $main_ba_new->BA_Desc                = $request->BA_Note;

      $main_ba_new->CekPelanggaran         = 0;
      $main_ba_new->CekKerusakan           = 0;
      $main_ba_new->CekKehilangan          = 0;
      $main_ba_new->CekPembelian           = 0;
      $main_ba_new->CekPerubahanSOP        = 0;
      $main_ba_new->CekFraud               = 0;
      $main_ba_new->CekRevisi              = 1;
      if($request->jenis == 'Salah Isi Dokumen')
      {
        $main_ba_new->CekSalahIsi = 1;
      }
      else if($request->jenis != 'Salah Isi Dokumen')
      {
        $main_ba_new->CekSalahIsi = 0;
      }
      if($request->jenis == 'Tidak Closing')
      {
        $main_ba_new->CekNoClosing = 1;
      }
      else if($request->jenis != 'Tidak Closing')
      {
        $main_ba_new->CekNoClosing = 0;
      }

      

      $main_ba_new->Ms_Kasus               = $request->jenis;
      $main_ba_new->Ms_Detail_Kasus        = $request->ms_kasus;
      $main_ba_new->Tr_EmpPeriod_Code      = $period_H;
      $main_ba_new->rec_usercreated        = Auth::User()->name;
      $main_ba_new->rec_datecreated        = Carbon::now();
      $main_ba_new->rec_comcode            = $request->Company_Code;
      $main_ba_new->rec_areacode           = $request->Location_Code;
      $main_ba_new->rec_status             = 1;
      $main_ba_new->save();

      $kode = $request->input('Tr_BA_Code');
      $existingData = DB::table('Tr_Ba_Main_New')->where('Tr_BA_Main_Code', $kode)->first();
      if ($existingData)
      {
        return back()->with('message', 'Kode BA sudah ada dalam database, karena ada user lain yang sedang membuat request revisi juga. Silakan refresh halaman secara berkala, Terima Kasih.');
      }
      else
      {
          // $main_ba = new BA_Main();
          // $main_ba->Tr_BA_Code        = $main_ba_new->Tr_BA_Main_Code;
          // $main_ba->BA_Type_Code      = 'BA Revisi';
          // $main_ba->BA_Admin          = $request->BA_Admin;
          // $main_ba->Admin_Div         = $request->Admin_Div;
          // $main_ba->User_Code         = $request->User_Code;
          // $main_ba->BA_Note           = $request->BA_Note;
          // $main_ba->Date_BA           = $request->Date_BA;
          // $main_ba->Division_Code     = $request->Division_Code;
          // $main_ba->Position_Code     = $request->Position_Code;
          // $main_ba->Category_Code     = $request->Category_Code;
          // $main_ba->ba_status         = 'Request';
          // $main_ba->jenis             = $request->jenis;
          // $main_ba->Location_Code     = $request->Location_Code;
          // $main_ba->Company_Code      = $request->Company_Code;
          // $main_ba->mengetahui1       = $request->mengetahui1;
          // $main_ba->atasan1           = $request->atasan1;
          // $main_ba->mengetahui2       = $request->mengetahui2;
          // $main_ba->atasan2           = $request->atasan2;
          // $main_ba->perlu_approval    = $request->perlu_approval;
          // $main_ba->ms_kasus          = $request->ms_kasus;
          // $main_ba->rec_status        = '1';
          // $main_ba->created_at        = Carbon::now();
          // $main_ba->save();         

          $last_id = DB::connection('mysql')->select("
            SELECT
            id
            FROM tr_ba_request_revisi
            order by created_at desc
            LIMIT 1
            ");
          foreach($last_id as $asas) {
              $idnya = $asas->id;
          }
          $last_code = DB::connection('mysql')->select("
            SELECT
            tr_ba_request_revisi_code
            FROM tr_ba_request_revisi
            order by created_at desc
            LIMIT 1
            ");
          $last_date = DB::connection('mysql')->select("
            SELECT
            created_at
            FROM tr_ba_request_revisi
            order by created_at desc
            LIMIT 1
            ");
          $todayDate = date('Y-m-d');
          foreach($last_code as $codes) {
              $kode = $codes->tr_ba_request_revisi_code;
          }
          foreach($last_date as $datess) {
              $tanggal = $datess->created_at;
          }
          if($tanggal == $todayDate) {
              $code = $kode + 1;
          } else {
              $code =  1;
          }
          $ambilkode=Request_Revisi::where($request->tr_ba_request_revisi_code)->get();
          $nambah=count($ambilkode)+1;
          if ($nambah <1000000) {
              $tr_ba_request_revisi_code='RQBA'. '-'.$idnya. date('Ydm').'-'."000".$idnya;
          }

          $tr_request = new Request_Revisi();
          $tr_request->user_created             = $request->User_Code;
          $tr_request->user_updated             = '';
          $tr_request->rec_status               = 1;
          $tr_request->rec_datecreated          = Carbon::now()->toDateTimeString();
          $tr_request->rec_dateupdate           = '';
          $tr_request->tr_ba_request_revisi_code= 'RQBA' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
          $tr_request->tr_ba_main_code          = $main_ba_new->Tr_BA_Main_Code;
          $tr_request->note                     = $request->BA_Note;
          // dd($tr_request);die;
          $tr_request->save();

           foreach($request['field_salah'] as $key => $item_id)
          {
              $randomValue = mt_rand(100, 999);
              $ba_salah_isi_d = new BA_Salah_Isi_d();
              $ba_salah_isi_d->tr_ba_code_main    = $main_ba_new->Tr_BA_Main_Code;
              $ba_salah_isi_d->tr_ba_code_request = $tr_request->tr_ba_request_revisi_code;
              $ba_salah_isi_d->code_ba            = 'RQDET' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
              $ba_salah_isi_d->code_doc           = $request->code_doc;
              $ba_salah_isi_d->field_salah        = $request['field_salah'][$key];
              $ba_salah_isi_d->value_salah        = $request['value_salah'][$key];
              $ba_salah_isi_d->field_benar        = $request['field_benar'][$key];
              $ba_salah_isi_d->value_benar        = $request['value_benar'][$key];
              // dd($ba_salah_isi_d);die;
              $ba_salah_isi_d->save();
          }
          
          foreach($request['field_salah'] as $key => $item_id)
          {
              $randomValue = mt_rand(100, 999);
              $Tr_BA_Revisi = new Tr_BA_Revisi();
              $Tr_BA_Revisi->Tr_BA_Revisi_Code     = 'REVISI' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
              $Tr_BA_Revisi->Tr_BA_Main_Code       = $main_ba_new->Tr_BA_Main_Code;

              $Tr_BA_Revisi->Code_Transaction      = $request->code_doc;
              $Tr_BA_Revisi->FieldSalah            = $request['field_salah'][$key];
              $Tr_BA_Revisi->FieldSeharusnya       = $request['field_benar'][$key];
              $Tr_BA_Revisi->ValueFieldSalah       = $request['value_salah'][$key];
              $Tr_BA_Revisi->ValueFieldSeharusnya  = $request['value_benar'][$key];
              $Tr_BA_Revisi->save();
          }

          $randomValue = mt_rand(100, 999);
          $ba_kronologi = new Tr_BA_Kronologi();
          $ba_kronologi->tr_ba_kronologi_code = 'Kronologi' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
          $ba_kronologi->tr_ba_main_code = $main_ba_new->Tr_BA_Main_Code;
          $ba_kronologi->kronlogi = $request->kronlogi;
          $ba_kronologi->save();

          //poto pertama
          $ba_doc = new BA_docs();
          $ba_doc->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

          if($request->file('file_path')) {
              $file= $request->file('file_path');
              $filename= date('YmdHi').$file->getClientOriginalName();
              $file-> move(public_path('upload'), $filename);
              $ba_doc->file_path = 'upload/' . $filename;
          }
          $ba_doc->save();


          //poto kedua
          $ba_doc2 = new BA_docs2();
          $ba_doc2->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

          if($request->file('file_path2')) {
              $file= $request->file('file_path2');
              $filename= date('YmdHi').$file->getClientOriginalName();
              $file-> move(public_path('upload'), $filename);
              $ba_doc2->file_path2 = 'upload/' . $filename;
          }
          $ba_doc2->save();
          $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
          $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $main_ba_new->Tr_BA_Main_Code)->get();
          $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
          $dok1 = BA_docs::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
          $dok2 = BA_docs2::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();

          $tracking = DB::connection('mysql')->select("
            SELECT
            *
            FROM tr_ba_main mainya
            left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Code = tracking.approval_ba_main_code
            where approval_ba_main_code = '$main_ba_new->Tr_BA_Main_Code'
            ");
            
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
       // Setup a filename 
        $documentFileName = $main_ba_new->Tr_BA_Main_Code.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
        $kronologi = ""; 
			if(isset($ba_kronologi->kronlogi) ){
				$kronologi = $ba_kronologi->kronlogi;
			}
                          
			$no=1;	  
			$trakings = "";
			foreach($tracking as $row){
			   $trakings .=  '<tr>
                    <td> &nbsp; &nbsp;'.$no.'</td>
                    <td> '.$row->pic.'</td>
                    <td> '.$row->approval_ba_desc.'</td>
                    <td> '.$row->note.'</td>
                    <td>  .....  </td>
                </tr>';
               $no++ ;
			   }
			$no=1;  
			$detailss = "";  
			foreach($detail as $row){
			$detailss .= '
			  <tr>
                          <td> &nbsp; &nbsp; '.$no.' &nbsp;</td>
                          <td>'.$row->code_doc.'</td>
                          <td>'.$row->field_salah.'</td>
                          <td>'.$row->value_salah.'</td>
                          <td>'.$row->field_benar.'</td>
                          <td>'.$row->value_benar.'</td>
                        </tr>';
              $no++ ;
			}        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Request Revisi</center></h3>
                  <hr/>
                  <br>
					 <table  style="width: 100%;">
                          <thead>
                            <tr>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                            </tr>
                          </thead>
                          <tbody>            
                          <tr>
                            <td>Code </td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
                            <td>Perusahaan </td><td>: '.$main_ba_new->rec_comcode.'</td>
                          </tr>
                          <tr> 
                            <td>Kategori </td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
                            <td>Jenis </td><td>: '.$main_ba_new->Ms_Kasus.'</td>
                          </tr>
                          <tr>
                            <td>Tanggal BA </td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").' </td>
                            <td>Tanggal Peristiwa </td><td>: '.date_format(date_create($main_ba_new->Date_BA),"d/m/Y").' </td>
                          </tr>
                          <tr>
                            <td>User Input </td><td>: '.$main_ba_new->Ms_Pelapor_Code.' </td>
                            <td>Divisi </td><td>: '.$main_ba_new->Ms_Pelapor_Div.' </td>
                          </tr>
                          <tr>
                            <td>Pelaku </td><td>: '.$main_ba_new->Ms_Emp_Code.' </td>
                            <td>Divisi Pelaku  </td><td>: '.$main_ba_new->Ms_Emp_Div.' </td>
                          </tr>
                          <tr>
                            <td>Kasus </td><td>: '.$main_ba_new->MS_Detail_Kasus.'</td>
                            <td>Lokasi </td><td>: '.$main_ba_new->rec_areacode.'</td>
                          </tr>
                          </tbody>
                      </table>
                      <br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">
                        '.$kronologi.'
                      </div>

            <br>
            <center><h3>Detail Transaksi</h3> </center>
            <table class="table table-bordered mt-4" style="width: 100%;" >
                <thead>
                    <tr>
                        <th style="width: 5%;"> No. </th>
                        <th style="width: 10%;">Code Doc.</th>
                        <th style="width: 10%;">Field Salah</th>
                        <th style="width: 10%;">Value Salah</th>
                        <th style="width: 10%;">Field Benar</th>
                        <th style="width: 10%;">Value Benar</th></tr>
                    </tr>
                </thead>
                <tbody>
                   '.$detailss.'
                </tbody>
            </table>
            <br>
            <br>
            <table class="table table-bordered mt-4"  style="width: 100%;">
              <thead>
                  <tr>
                    <tr>
                      <th style="width: 5%;"> No. </th>
                      <th  style="width: 15%;">PIC</th>
                      <th style="width: 15%;">Divisi</th>
                      <th style="width: 40%;">Note</th>
                      <th></th>
                  </tr>
                  </tr>
              </thead>
              <tbody>
                    '.$trakings.'				  
              </tbody>
            </table>
          <br>
          <br>  
          <table>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>
        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header);  

      //pdf
    //   $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
	   // $data = [
    //     'main_ba_new'   => $main_ba_new , 
    //     'detail'        => $detail,
    //     'ba_kronologi'  => $ba_kronologi, 
    //     'dok1'          => $dok1, 
    //     'dok2'          => $dok2, 
    //     'tracking'      => $tracking,
    //     'datetime'      => $datetime
    //   ];
    //   $pdf = PDF::loadView('berita_acara.print_ba_request',$data);

    //   return $pdf->download($main_ba_new->Tr_BA_Main_Code.'.pdf');
          //return view('berita_acara.print_ba_request', compact('main_ba_new', 'detail', 'ba_kronologi', 'dok1', 'dok2', 'tracking'));
      }
    }
    public function print_request_revisi(Request $request, $id)
    {
    //   dd($id);
      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id )->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id )->first();

      $tracking = DB::connection('mysql')->select("
      SELECT * FROM Tr_Ba_Main_New mainya left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Main_Code = tracking.approval_ba_main_code where approval_ba_main_code = '$id'
      ");
      
       $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
       // Setup a filename 
        $documentFileName = $id.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
        $kronologi = ""; 
			if(isset($ba_kronologi->kronlogi) ){
				$kronologi = $ba_kronologi->kronlogi;
			}
                          
			$no=1;	  
			$trakings = "";
			foreach($tracking as $row){
			   $trakings .=  '<tr>
                    <td> &nbsp; &nbsp;'.$no.'</td>
                    <td> '.$row->pic.'</td>
                    <td> '.$row->approval_ba_desc.'</td>
                    <td> '.$row->note.'</td>
                    <td>  .....  </td>
                </tr>';
               $no++ ;
			   }
			$no=1;  
			$detailss = "";  
			foreach($detail as $row){
			$detailss .= '
			  <tr>
                          <td> &nbsp; &nbsp; '.$no.' &nbsp;</td>
                          <td>'.$row->code_doc.'</td>
                          <td>'.$row->field_salah.'</td>
                          <td>'.$row->value_salah.'</td>
                          <td>'.$row->field_benar.'</td>
                          <td>'.$row->value_benar.'</td>
                        </tr>';
              $no++ ;
			}        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Request Revisi</center></h3>
                  <hr/>
                  <br>
					 <table  style="width: 100%;">
                          <thead>
                            <tr>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                            </tr>
                          </thead>
                          <tbody>            
                          <tr>
                            <td>Code </td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
                            <td>Perusahaan </td><td>: '.$main_ba_new->rec_comcode.'</td>
                          </tr>
                          <tr> 
                            <td>Kategori </td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
                            <td>Jenis </td><td>: '.$main_ba_new->Ms_Kasus.'</td>
                          </tr>
                          <tr>
                            <td>Tanggal BA </td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").' </td>
                            <td>Tanggal Peristiwa </td><td>: '.date_format(date_create($main_ba_new->Date_BA),"d/m/Y").' </td>
                          </tr>
                          <tr>
                            <td>User Input </td><td>: '.$main_ba_new->Ms_Pelapor_Code.' </td>
                            <td>Divisi </td><td>: '.$main_ba_new->Ms_Pelapor_Div.' </td>
                          </tr>
                          <tr>
                            <td>Pelaku </td><td>: '.$main_ba_new->Ms_Emp_Code.' </td>
                            <td>Divisi Pelaku  </td><td>: '.$main_ba_new->Ms_Emp_Div.' </td>
                          </tr>
                          <tr>
                            <td>Kasus </td><td>: '.$main_ba_new->MS_Detail_Kasus.'</td>
                            <td>Lokasi </td><td>: '.$main_ba_new->rec_areacode.'</td>
                          </tr>
                          </tbody>
                      </table>
                      <br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">
                        '.$kronologi.'
                      </div>

            <br>
            <center><h3>Detail Transaksi</h3> </center>
            <table class="table table-bordered mt-4" style="width: 100%;" >
                <thead>
                    <tr>
                        <th style="width: 5%;"> No. </th>
                        <th style="width: 10%;">Code Doc.</th>
                        <th style="width: 10%;">Field Salah</th>
                        <th style="width: 10%;">Value Salah</th>
                        <th style="width: 10%;">Field Benar</th>
                        <th style="width: 10%;">Value Benar</th></tr>
                    </tr>
                </thead>
                <tbody>
                   '.$detailss.'
                </tbody>
            </table>
            <br>
            <br>
            <table class="table table-bordered mt-4"  style="width: 100%;">
              <thead>
                  <tr>
                    <tr>
                      <th style="width: 5%;"> No. </th>
                      <th  style="width: 15%;">PIC</th>
                      <th style="width: 15%;">Divisi</th>
                      <th style="width: 40%;">Note</th>
                      <th></th>
                  </tr>
                  </tr>
              </thead>
              <tbody>
                    '.$trakings.'				  
              </tbody>
            </table>
          <br>
          <br>  
          <table>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>
        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header);      
      

      //pdf
    //   $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('d/m/Y H:i:s'); 
	   // $data = [
    //     'main_ba_new'   => $main_ba_new , 
    //     'detail'        => $detail,
    //     'ba_kronologi'  => $ba_kronologi, 
    //     'dok1'          => $dok1, 
    //     'dok2'          => $dok2, 
    //     'tracking'      => $tracking,
    //     'datetime'      => $datetime
    //   ];
    //   $pdf = PDF::loadView('berita_acara.print_ba_request',$data);

    //   return $pdf->download($id.'.pdf');

      //return view('berita_acara.print_ba_request', compact('main_ba_new', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
    }
    
    public function print_request_revisis(Request $request, $id)
    {
    //   dd($id);
      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $id )->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $id )->first();

      $tracking = DB::connection('mysql')->select("
      SELECT
      *
      FROM tr_ba_main mainya
      left join tr_approval_ba_tracking tracking on mainya.Tr_BA_Code = tracking.approval_ba_main_code
      where approval_ba_main_code = '$id'
      ");
      
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
       // Setup a filename 
        $documentFileName = $id.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
        $kronologi = ""; 
			if(isset($ba_kronologi->kronlogi) ){
				$kronologi = $ba_kronologi->kronlogi;
			}
                          
			$no=1;	  
			$trakings = "";
			foreach($tracking as $row){
			   $trakings .=  '<tr>
                    <td> &nbsp; &nbsp;'.$no.'</td>
                    <td> '.$row->pic.'</td>
                    <td> '.$row->approval_ba_desc.'</td>
                    <td> '.$row->note.'</td>
                    <td>  .....  </td>
                </tr>';
               $no++ ;
			   }
			$no=1;  
			$detailss = "";  
			foreach($detail as $row){
			$detailss .= '
			  <tr>
                          <td> &nbsp; &nbsp; '.$no.' &nbsp;</td>
                          <td>'.$row->code_doc.'</td>
                          <td>'.$row->field_salah.'</td>
                          <td>'.$row->value_salah.'</td>
                          <td>'.$row->field_benar.'</td>
                          <td>'.$row->value_benar.'</td>
                        </tr>';
              $no++ ;
			}        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Request Revisi</center></h3>
                  <hr/>
                  <br>
					 <table  style="width: 100%;">
                          <thead>
                            <tr>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                            </tr>
                          </thead>
                          <tbody>            
                          <tr>
                            <td>Code </td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
                            <td>Perusahaan </td><td>: '.$main_ba_new->rec_comcode.'</td>
                          </tr>
                          <tr> 
                            <td>Kategori </td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
                            <td>Jenis </td><td>: '.$main_ba_new->Ms_Kasus.'</td>
                          </tr>
                          <tr>
                            <td>Tanggal BA </td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").' </td>
                            <td>Tanggal Peristiwa </td><td>: '.date_format(date_create($main_ba_new->Date_BA),"d/m/Y").' </td>
                          </tr>
                          <tr>
                            <td>User Input </td><td>: '.$main_ba_new->Ms_Pelapor_Code.' </td>
                            <td>Divisi </td><td>: '.$main_ba_new->Ms_Pelapor_Div.' </td>
                          </tr>
                          <tr>
                            <td>Pelaku </td><td>: '.$main_ba_new->Ms_Emp_Code.' </td>
                            <td>Divisi Pelaku  </td><td>: '.$main_ba_new->Ms_Emp_Div.' </td>
                          </tr>
                          <tr>
                            <td>Kasus </td><td>: '.$main_ba_new->MS_Detail_Kasus.'</td>
                            <td>Lokasi </td><td>: '.$main_ba_new->rec_areacode.'</td>
                          </tr>
                          </tbody>
                      </table>
                      <br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">
                        '.$kronologi.'
                      </div>

            <br>
            <center><h3>Detail Transaksi</h3> </center>
            <table class="table table-bordered mt-4" style="width: 100%;" >
                <thead>
                    <tr>
                        <th style="width: 5%;"> No. </th>
                        <th style="width: 10%;">Code Doc.</th>
                        <th style="width: 10%;">Field Salah</th>
                        <th style="width: 10%;">Value Salah</th>
                        <th style="width: 10%;">Field Benar</th>
                        <th style="width: 10%;">Value Benar</th></tr>
                    </tr>
                </thead>
                <tbody>
                   '.$detailss.'
                </tbody>
            </table>
            <br>
            <br>
            <table class="table table-bordered mt-4"  style="width: 100%;">
              <thead>
                  <tr>
                    <tr>
                      <th style="width: 5%;"> No. </th>
                      <th  style="width: 15%;">PIC</th>
                      <th style="width: 15%;">Divisi</th>
                      <th style="width: 40%;">Note</th>
                      <th></th>
                  </tr>
                  </tr>
              </thead>
              <tbody>
                    '.$trakings.'				  
              </tbody>
            </table>
          <br>
          <br>  
          <table>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>
        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); 
      
      
      
      
      

      //pdf
    //   $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('d/m/Y H:i:s'); 
	   // $data = [
    //     'main_ba_new'   => $main_ba_new , 
    //     'detail'        => $detail,
    //     'ba_kronologi'  => $ba_kronologi, 
    //     'dok1'          => $dok1, 
    //     'dok2'          => $dok2, 
    //     'tracking'      => $tracking,
    //     'datetime'      => $datetime
    //   ];
    //   $pdf = PDF::loadView('berita_acara.print_ba_request',$data);

    //   return $pdf->download($id.'.pdf');

      //return view('berita_acara.print_ba_request', compact('main_ba_new', 'detail','ba_kronologi', 'dok1', 'dok2', 'tracking'));
    }    
    
    
    public function list_request(Request $request)
    {
      $user = auth()->user();
      $main_ba_new = DB::connection('mysql')->select("
          SELECT
      main.Ms_Kasus,
      main.MS_Detail_Kasus,
      main.Tr_BA_Main_Code,
      main.created_at,
	  main.CekPelanggaran,
	  main.Ms_Pelapor_Code,
	  main.Ms_Pelapor_Div,
	  main.Ms_Emp_Code,
	  main.Ms_Emp_Div,
      revisi_h.user_created,
      revisi_h.note,
	  MAX(track.approval_ba_tracking) as trace

      FROM Tr_Ba_Main_New main
      left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code
	  left join tr_approval_ba_tracking track on main.Tr_BA_Main_Code = track.approval_ba_main_code
      WHERE main.rec_status ='1' 
      and main.CekRevisi = '1' and main.Ms_BA_type_Code ='BA Revisi' 
      GROUP BY  main.Tr_BA_Main_Code 
     
      ");

      return view ('berita_acara.list_request', compact('main_ba_new'));
    }
    
    public function search_revisi(request $request)
    {

      $tgl_awal       = $request->tgl_awal;
      $tgl_akhir      = $request->tgl_akhir;

      $main_ba_new = DB::connection('mysql')->select("
          SELECT
          main.Ms_Kasus,
          main.MS_Detail_Kasus,
          main.Tr_BA_Main_Code,
          main.created_at,
          main.CekPelanggaran,
          main.Ms_Pelapor_Code,
          main.Ms_Pelapor_Div,
          main.Ms_Emp_Code,
          main.Ms_Emp_Div,
          revisi_h.user_created,
          revisi_h.note,
          MAX(track.approval_ba_tracking) as trace

          FROM Tr_Ba_Main_New main
          left JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code
	        left join tr_approval_ba_tracking track on main.Tr_BA_Main_Code = track.approval_ba_main_code
          WHERE main.rec_status ='1'
          and main.CekRevisi = '1' and main.Ms_BA_type_Code ='BA Revisi'
          and date(main.created_at) >= '$tgl_awal'
					and date(main.created_at) <= '$tgl_akhir'
          GROUP BY  main.Tr_BA_Main_Code
      ");
      return view ('berita_acara.list_request', compact('main_ba_new', 'tgl_awal', 'tgl_akhir'));
    }


    public function list_request_untuk_koord(Request $request)
    {
      $user = auth()->user();
      $main_ba_new = DB::connection('mysql')->select("
     SELECT main.Tr_BA_Main_Code, 
     main.created_at, 
     main.Ms_Emp_Div, 
     main.CekPelanggaran, 
     revisi_h.user_created, 
     revisi_h.note, 
     MAX(track.approval_ba_tracking) as trace 
     FROM Tr_Ba_Main_New main left 
     JOIN tr_ba_request_revisi revisi_h on main.Tr_BA_Main_Code = revisi_h.tr_ba_main_code 
     left join tr_approval_ba_tracking track on main.Tr_BA_Main_Code = track.approval_ba_main_code 
     WHERE main.rec_status ='1' and main.CekRevisi = '1' and main.Ms_BA_type_Code ='BA Revisi' 
     -- and main.Division_Code ='$user->ms_divisi' 
     GROUP BY main.Tr_BA_Main_Code order by main.created_at desc;
      ");

      return view ('berita_acara.list_request_untuk_koord', compact('main_ba_new'));
    }
     public function dashboard_revisi()
    {
       $report = DB::connection('mysql')->select("
select
        Main.created_at,
		Main.Tr_BA_Main_Code,
        Main.rec_comcode,
        Main.rec_areacode,
        Main.Ms_Pelapor_Code,
        Main.Ms_Emp_Code,
        Main.Ms_Emp_Div,
		Main.Ms_BA_type_Code,
	    Main.Ms_Kasus,
	    Main.MS_Detail_Kasus,
	    krono.kronlogi,
	    MAX(tracking.approval_ba_tracking) as trace
        from
        Tr_Ba_Main_New Main
	  left join tr_ba_kronologi krono on Main.Tr_BA_Main_Code = krono.tr_ba_main_code
	  left join tr_approval_ba_tracking tracking on Main.Tr_BA_Main_Code = tracking.approval_ba_main_code
      where Main.rec_status ='1'
      and Main.CekRevisi = '1' and Main.Ms_BA_type_Code ='BA Revisi'
      -- and YEAR(Main.created_at) >= 2024
	  GROUP BY  Main.Tr_BA_Main_Code
      order by Main.created_at asc
      ");
      return view('berita_acara.dashboard_revisi', compact('report'));
    }
    public function index_berita_acara_spv(Request $request)
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
      $company = Ms_Company::all();
      $ms_katergori = Ms_Case_Category::all();
      $ms_kasus = Ms_Kasus::all();
      $users = DB::connection('mysql_new')->SELECT("
      (SELECT 
          driver_id AS id, 
          driver_name AS emp_id,
          'Driver' AS divisi
      FROM ms_driver WHERE ms_driver.rec_status = '1')

      UNION ALL

      (SELECT 
          helper_id AS id, 
          helper_name AS emp_id,
          'Helper' AS divisi
      FROM ms_helper where ms_helper.rec_status = '1')

      UNION ALL

      (SELECT 
          e.Ms_Emp_Code AS id, 
          e.Emp_Name AS emp_id,
          d.div_id AS divisi
      FROM Ms_User_Emp e
      JOIN ms_division d ON e.emp_division = d.div_id
      where e.rec_status = '1')
      ");
        //       $users = DB::connection('mysql')->select("
              
        // select   * from master_employees where emp_inactive ='1'  ORDER BY emp_name asc 
        //       ");
    //   $users = User::all();

      $jenis = DB::connection('mysql')->select("
      select * from ms_kasus_head where ms_type ='Berita Acara' and rec_status ='1' order by description asc
      ");
      
      $ms_kasus = DB::connection('mysql')->select("
      select * from ms_kasus where ms_kasus_head1 !='01' and rec_status ='1' order by description asc
      ");

      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_ba_main
      order by created_at desc
      LIMIT 1
      ");

      $twoChars = substr($user->username, 0, 3);

      foreach($last_id2 as $asas2)
      { $idnya2 = $asas2->id+1;}
      $ambilkode2=Tr_Ba_Main_New::where($request->Tr_BA_Code)->get();
      $nambah2=count($ambilkode2)+1;
      if ($nambah2 <1000000)
      {
        $code_bas='BA'. '-'. $user->ms_divisi.'-'. date('Ydm').'-'."00".$idnya2;
      }

        return view('berita_acara.input_berita_acara_spv', compact('user', 'lokasi', 'employee', 'divisi', 'company', 'ms_katergori', 'divisi', 'code_bas', 'jenis', 'ms_kasus', 'users'));
    }

    public function store_berita_acara_spv(Request $request)
    {

      $timestamp = Carbon::now()->timestamp;
      $tanggalSekarang = Carbon::now();
      $tahunSaatIni = $tanggalSekarang->year;
      $weeks = $tanggalSekarang->weekOfYear;
      // Tentukan rentang periode
      $startDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-01-01');
      $endDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-03-31');
      $startDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-04-01');
      $endDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-06-30');
      $startDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-07-01');
      $endDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-09-31');      
      $startDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-10-01');
      $endDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-12-31');

     if(Carbon::now()->between($startDate1, $endDate1)){
      $periodeQ = 'Q1';
     };
     if(Carbon::now()->between($startDate2, $endDate2)){
      $periodeQ = 'Q2';
     };
     if(Carbon::now()->between($startDate3, $endDate3)){
      $periodeQ = 'Q3';
     };                 
     if(Carbon::now()->between($startDate4, $endDate4)){
      $periodeQ = 'Q4';
     };
     if(Carbon::now()){
      $periodeQ = 'Q4';
     };
      $period_H = $request->User_Code . '-' .$tahunSaatIni.$periodeQ;
      do
      {
        $randomValue = mt_rand(100, 999);
        // $autoNumber = 'BA' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
        $autoNumber = $request->User_Code . '-' . $request->Category_Code . $weeks. $tahunSaatIni . $randomValue;
        $isUnique = !DB::table('Tr_Ba_Main_New')
            ->where('Tr_BA_Main_Code', $autoNumber)
            ->exists();
      }
      while (!$isUnique);
      
      $divisi_code = DB::connection('mysql_new')->SELECT("
      SELECT *
      FROM (
      (SELECT 
                driver_id AS id, 
                driver_name AS emp_id,
                'Driver' AS divisi
            FROM ms_driver WHERE ms_driver.rec_status = '1')

            UNION ALL

            (SELECT 
                helper_id AS id, 
                helper_name AS emp_id,
                'Helper' AS divisi
            FROM ms_helper where ms_helper.rec_status = '1')

            UNION ALL

            (SELECT 
                e.Ms_Emp_Code AS id, 
                e.Emp_Name AS emp_id,
                d.div_id AS divisi
            FROM Ms_User_Emp e
            JOIN ms_division d ON e.emp_division = d.div_id
            where e.rec_status = '1')
            ) AS all_employees
      WHERE id = '$request->User_Code'
      ");
      
      if ($divisi_code[0]->divisi != '') {
        $code_divisi = $divisi_code[0]->divisi;
      }

      $user = auth()->user();
      
      $main_ba_new = new Tr_Ba_Main_New();
      $main_ba_new->Tr_BA_Main_Code        = $autoNumber;
      $main_ba_new->Ms_BA_type_Code        = 'BA Kejadian';
      $main_ba_new->Ms_Emp_Code            = $request->User_Code;
      $main_ba_new->Ms_Emp_Div             = $code_divisi;
      $main_ba_new->Ms_Pelapor_Code        = $request->BA_Admin;
      $main_ba_new->Ms_Pelapor_Div         = $request->Admin_Div;
      $main_ba_new->Date_BA                = $request->Date_BA;
      $main_ba_new->BA_Desc                = $request->BA_Note;
      if($request->Category_Code == 'Pelanggaran SOP')
      {
        $main_ba_new->CekPelanggaran = 1;
      }
      else if($request->Category_Code != 'Pelanggaran SOP')
      {
        $main_ba_new->CekPelanggaran = 0;
      }
      if($request->Category_Code == 'Kerusakan')
      {
        $main_ba_new->CekKerusakan = 1;
      }
      else if($request->Category_Code != 'Kerusakan')
      {
        $main_ba_new->CekKerusakan = 0;
      }
      if($request->Category_Code == 'Kehilangan')
      {
        $main_ba_new->CekKehilangan = 1;
      }
      else if($request->Category_Code != 'Kehilangan')
      {
        $main_ba_new->CekKehilangan = 0;
      }
      if($request->Category_Code == 'Pembelian Barang')
      {
        $main_ba_new->CekPembelian = 1;
      }
      else if($request->Category_Code != 'Pembelian Barang')
      {
        $main_ba_new->CekPembelian = 0;
      }
      if($request->Category_Code == 'Perubahan SOP')
      {
        $main_ba_new->CekPerubahanSOP = 1;
      }
      else if($request->Category_Code != 'Perubahan SOP')
      {
        $main_ba_new->CekPerubahanSOP = 0;
      }
      $main_ba_new->CekFraud               = $request->ms_fraud;
      $main_ba_new->Ms_Kasus               = $request->jenis;
      $main_ba_new->Ms_Detail_Kasus        = $request->ms_kasus;
      $main_ba_new->Tr_EmpPeriod_Code      = $period_H;
      $main_ba_new->rec_usercreated        = Auth::User()->name;
      $main_ba_new->rec_datecreated        = Carbon::now();
      $main_ba_new->rec_comcode            = $request->Company_Code;
      $main_ba_new->rec_areacode           = $request->Location_Code;
      $main_ba_new->rec_status             = 1;
      $main_ba_new->save();
      
      // $main_ba = new BA_Main();
      // $main_ba->Tr_BA_Code        = $main_ba_new->Tr_BA_Main_Code;
      // $main_ba->BA_Type_Code      = $request->BA_Type_Code;
      // $main_ba->BA_Admin          = $request->BA_Admin;
      // $main_ba->Admin_Div         = $request->Admin_Div;
      // $main_ba->User_Code         = $request->User_Code;
      // $main_ba->Division_Code     = $request->Division_Code;
      // $main_ba->BA_Note           = $request->BA_Note;
      // $main_ba->Date_BA           = $request->Date_BA;
      // $main_ba->Division_Code     = $request->Division_Code;
      // $main_ba->Position_Code     = $request->Position_Code;
      // $main_ba->Category_Code     = $request->Category_Code;
      // $main_ba->ba_status         = 'Berita Acara';
      // $main_ba->ms_fraud          = $request->ms_fraud;
      // $main_ba->jenis             = $request->jenis;
      // $main_ba->ms_kasus          = $request->ms_kasus;
      // $main_ba->Location_Code     = $request->Location_Code;
      // $main_ba->Company_Code      = $request->Company_Code;
      // $main_ba->mengetahui1       = $request->mengetahui1;
      // $main_ba->atasan1           = $request->atasan1;
      // $main_ba->mengetahui2       = $request->mengetahui2;
      // $main_ba->atasan2           = $request->atasan2;
      // $main_ba->perlu_approval    = $request->perlu_approval;
      // $main_ba->created_at        = Carbon::now();
      // $main_ba->rec_status        = '1';
      // // dd($main_ba);die;
      // $main_ba->save();

      $ba_kronologi = new Tr_BA_Kronologi();
      $ba_kronologi->tr_ba_kronologi_code = 'Kronologi' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
      $ba_kronologi->tr_ba_main_code = $main_ba_new->Tr_BA_Main_Code;
      $ba_kronologi->kronlogi = $request->kronlogi;
      $ba_kronologi->save();

      //poto 1
      $ba_doc = new BA_docs();
      $ba_doc->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

      if($request->file('file_path'))
      {
          $file= $request->file('file_path');
          $filename= date('YmdHi').$file->getClientOriginalName();
          $file-> move(public_path('upload'), $filename);
          $ba_doc->file_path = 'upload/' . $filename;
      }
      $ba_doc->save();

      //poto 2
      $ba_doc2 = new BA_docs2();
      $ba_doc2->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

      if($request->file('file_path2'))
      {
          $file= $request->file('file_path2');
          $filename= date('YmdHi').$file->getClientOriginalName();
          $file-> move(public_path('upload'), $filename);
          $ba_doc2->file_path2 = 'upload/' . $filename;
      }
      // dd($ba_doc2);die;
      $ba_doc2->save();    

      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
      // dd($main_ba);die;
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
      // Setup a filename 
        $documentFileName = $main_ba_new->Tr_BA_Main_Code.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
    $kronologi = ""; 
			if(isset($ba_kronologi->kronlogi) ){
				$kronologi = $ba_kronologi->kronlogi;
			}
      
      $fraud = '' ;
      if($main_ba_new->CekFraud == '1'){
         $fraud = 'Iya'; 
      } 
      else{
          $fraud = 'Tidak';  
      }
      $docsx1 = '';
      $docs1 = "upload/logohgs.jpg";
        if(!empty($dok1)){
            $docs1 = url('/'.$dok1->file_path);
            if($docs1 == url('/')){
                $docsx1 = '';
            }
            else{
                $docsx1 =  '<img width="250" height="130" src="'.$docs1.'">';
            }            
        }
      $docsx2 = '';  
      $docs2 = "upload/logohgs.jpg";
        if(!empty($dok2)){
            $docs2 = url('/'.$dok2->file_path2);
            if($docs2 == url('/')){
                $docsx2 = '';
            }
            else{
                $docsx2 = '<img width="250" height="130" src="'.$docs2.'">';
            }            
        }        
    
        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Berita Acara Kejadian</center></h3>
                  <hr/>
                  <br>
  <table style="width: 100%;">
  <thead>
    <tr>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Code</td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
      <td>Perusahaan</td><td>: '.$main_ba_new->rec_comcode.'</td>
    </tr>
    <tr>
      <td>Kategori</td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
      <td>Kasus</td><td>: '.$main_ba_new->Ms_Kasus.'</td>
    </tr>
    <tr>
      <td>Tanggal BA</td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").' </td>
      <td>Tanggal Peristiwa</td><td>: '.date_format(date_create($main_ba_new->Date_BA),"d/m/Y").' </td>
    </tr>
    <tr>
      <td>User Input</td><td>: '.$main_ba_new->Ms_Pelapor_Code.' </td>
      <td>Divisi yang Input</td><td>: '.$main_ba_new->Ms_Pelapor_Div.' </td>
    </tr>
    <tr>
      <td>Pelaku</td><td>: '.$main_ba_new->Ms_Emp_Code.' </td>
      <td>Divisi Pelaku</td><td> : '.$main_ba_new->Ms_Emp_Div.' </td>
    </tr>
    <tr>
      <td>Lokasi</td><td>: '.$main_ba_new->rec_areacode.'</td>
      <td >Detail Kasus</td><td>: '.$main_ba_new->MS_Detail_Kasus.'</td>
    </tr>  
    <tr>
      <td><strong>Fraud ?</strong></td><td>: 
        '.$fraud.'
      </td>
      <td></td><td></td>
    </tr>
    </tbody>
</table>
<br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">
                        '.$kronologi.' 
                      </div>
          <br>

                      <center>
                        <h3>
                           Dokumen
                         </h3>
                       </center>

                       <table class="table table-bordered mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                  <td>'.$docsx1.'
                                  </td>
                                  <td>'.$docsx2.'
                                  </td>
                            </tr>      
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-bordered mt-4" style="width: 100%;">
                      <thead>
                          <tr>
                              <th style="width: 5%;"> No. </th>
                              <th style="width: 30%;">PIC</th>
                              <th style="width: 30%;">Divisi</th>
                              <th style="width: 20%;"></th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                <td>&nbsp; &nbsp; 1</td>
                                <td>'.$main_ba_new->Ms_Emp_Code.'</td>
                                <td>'.$main_ba_new->Ms_Emp_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 2</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Code.'</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 3</td>
                                <td>Tri Hartati</td>
                                <td>Manager Finance</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 4</td>
                                <td>Dwi Arif W / Yesy Tjandra</td>
                                <td>Manager Operasional</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 5</td>
                                <td>Cliff Rogers </td>
                                <td>General Manager</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 6</td>
                                <td>Diana L</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 7</td>
                                <td>Charles W / Diana L</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                      </tbody>
                  </table>

                <div class="card-body">
          <br>
          <br>  
          <table>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>
        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //      
      
                  //pdf
            // $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
            // $data = [
            //   'main_ba_new' => $main_ba_new, 
            //   //'detail'      => $detail,
            //   'ba_kronologi'=> $ba_kronologi, 
            //   'dok1'        => $dok1, 
            //   'dok2'        => $dok2,
            //   'datetime'    => $datetime
            // ];
            // $pdf = PDF::loadView('berita_acara.print_berita_acara_salahisi',$data);
            // return $pdf->download($main_ba_new->Tr_BA_Main_Code.'.pdf');   
      
    //return view('berita_acara.print_berita_acara_salahisi', compact('main_ba_new', 'dok1', 'dok2', 'ba_kronologi'));
    }
    public function ba_laka(Request $request)
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
      $company = Ms_Company::all();
      $ms_katergori = Ms_Case_Category::all();
      $ms_kasus = Ms_Kasus::all();
      $ms_jenis_laka = ms_jenis_laka::all();
      $ms_faktor_laka = ms_faktor_laka::all();
      $ms_klasifikasi_laka = ms_klasifikasi_laka::all();
      $ms_dampak_laka = ms_dampak_laka::all();
    //   $users = DB::connection('mysql')->select("
    //   select  * from master_employees where emp_inactive ='1' and (emp_subdivision ='driver' or emp_subdivision ='helper' or  emp_subdivision = 'Operasional') order BY emp_name asc
    //   ");
      $users2 = DB::connection('mysql')->select("
      select  * from master_employees where emp_inactive ='1'  order BY emp_name asc
      ");
      
      $users = DB::connection('mysql_new')->select("
    SELECT 
        driver_id AS id, 
        driver_name AS emp_name,
        'Driver' AS divisi
    FROM ms_driver 
    WHERE ms_driver.rec_status = '1'

    UNION

    SELECT 
        helper_id AS id, 
        helper_name AS emp_name,
        'Helper' AS divisi
    FROM ms_helper 
    WHERE ms_helper.rec_status = '1'
    
    UNION 
    
    SELECT 
        Ms_Emp_Code AS id, 
        Emp_Name AS emp_name,
        'Operasional' AS divisi
    FROM Ms_User_Emp
    where emp_division = 'Operasional' or emp_subdivision ='Dispatcher'
");

        

      $jenis = DB::connection('mysql')->select("
      select * from ms_kasus_head where ms_type ='Berita Acara'
      ");

      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_ba_main
      order by created_at desc
      LIMIT 1
      ");

      $twoChars = substr($user->username, 0, 3);

      foreach($last_id2 as $asas2)
      { $idnya2 = $asas2->id+1;}
      $ambilkode2=Tr_Ba_Main_New::where($request->Tr_BA_Code)->get();
      $nambah2=count($ambilkode2)+1;
      if ($nambah2 <1000000)
      {
        $code_bas='BA'. '-'. $user->ms_divisi.'-'. date('Ydm').'-'."00".$idnya2;
      }

     return view('berita_acara.ba_laka', compact('user', 'lokasi', 'employee', 'divisi', 'company', 'ms_katergori', 'divisi', 'code_bas', 'jenis', 'ms_kasus', 'ms_jenis_laka', 'ms_faktor_laka', 'ms_klasifikasi_laka', 'ms_dampak_laka', 'users', 'users2'));
    }

    public function store_ba_laka(Request $request)
    {
      
      $timestamp = Carbon::now()->timestamp;
      $tanggalSekarang = Carbon::now();
      $tahunSaatIni = $tanggalSekarang->year;
      $weeks = $tanggalSekarang->weekOfYear;
      // Tentukan rentang periode
      $startDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-01-01');
      $endDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-03-31');
      $startDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-04-01');
      $endDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-06-30');
      $startDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-07-01');
      $endDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-09-31');      
      $startDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-10-01');
      $endDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-12-31');

     if(Carbon::now()->between($startDate1, $endDate1)){
      $periodeQ = 'Q1';
     };
     if(Carbon::now()->between($startDate2, $endDate2)){
      $periodeQ = 'Q2';
     };
     if(Carbon::now()->between($startDate3, $endDate3)){
      $periodeQ = 'Q3';
     };                 
     if(Carbon::now()->between($startDate4, $endDate4)){
      $periodeQ = 'Q4';
     };
     if(Carbon::now()){
      $periodeQ = 'Q4';
     };
      $period_H = $request->User_Code . '-' .$tahunSaatIni.$periodeQ;
      do
      {
        $randomValue = mt_rand(100, 999);
        // $autoNumber = 'BA' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
        $autoNumber = $request->User_Code . '-' . 'Laka' . $weeks. $tahunSaatIni . $randomValue;
        $isUnique = !DB::table('Tr_Ba_Main_New')
            ->where('Tr_BA_Main_Code', $autoNumber)
            ->exists();
      }
      while (!$isUnique);

      $main_ba_new = new Tr_Ba_Main_New();
      $main_ba_new->Tr_BA_Main_Code        = $autoNumber;
      $main_ba_new->Ms_BA_type_Code        = 'Laka';
      $main_ba_new->Ms_Emp_Code            = '';
      $main_ba_new->Ms_Emp_Div             = '';
      $main_ba_new->Ms_Pelapor_Code        = $request->User_Code;
      $main_ba_new->Ms_Pelapor_Div         = $request->Division_Code;
      $main_ba_new->Date_BA                = $request->Date_BA;
      $main_ba_new->BA_Desc                = $request->BA_Note;

      $main_ba_new->CekPelanggaran         = 0;
      $main_ba_new->CekKerusakan           = 0;
      $main_ba_new->CekKehilangan          = 0;
      $main_ba_new->CekPembelian           = 0;
      $main_ba_new->CekPerubahanSOP        = 0;
      $main_ba_new->CekFraud               = 0;
      $main_ba_new->CekLaka                = 1;
      $main_ba_new->Ms_Kasus               = 'Laka';
      $main_ba_new->Ms_Detail_Kasus        = 'Laka';
      $main_ba_new->Tr_EmpPeriod_Code      = '';
      $main_ba_new->rec_usercreated        = Auth::User()->name;
      $main_ba_new->rec_datecreated        = Carbon::now();
      $main_ba_new->rec_comcode            = $request->Company_Code;
      $main_ba_new->rec_areacode           = $request->Location_Code;
      $main_ba_new->rec_status             = 1;
      $main_ba_new->save();

      $ba_kronologis = new Tr_BA_Kronologi();
      $ba_kronologis->tr_ba_kronologi_code = 'Kronologi' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
      $ba_kronologis->tr_ba_main_code = $main_ba_new->Tr_BA_Main_Code;
      $ba_kronologis->kronlogi = $request->kronlogi;
      $ba_kronologis->save();

      $last_code = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_ba_laka_h
      order by id desc
      LIMIT 1
      ");
      $last_date = DB::connection('mysql')->select("
      SELECT
      created_at
      FROM tr_ba_laka_h
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
      $ambilkode=BA_laka_header::where($request->tr_ba_laka_code)->get();
      $nambah=count($ambilkode)+1;
      if ($nambah <1000000)
      {
        $tr_ba_laka_code='LAKA'. '-'. date('Ydm').'-'."00".$nambah;
      }

    $ba_laka_head = new BA_laka_header();
    $ba_laka_head->tr_ba_laka_code        = 'Laka' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
    $ba_laka_head->tr_ba_main_code        = $main_ba_new->Tr_BA_Main_Code;
    $ba_laka_head->ms_jenis_laka          = $request->ms_jenis_laka;
    $ba_laka_head->ms_faktor_laka         = $request->ms_faktor_laka;
    $ba_laka_head->ms_klasifikasi_laka    = $request->ms_klasifikasi_laka;
    $ba_laka_head->ms_dampak_laka         = $request->ms_dampak_laka;
    $ba_laka_head->type_laka              = $request->type_laka;
    $ba_laka_head->pool                   = $request->pool;
    $ba_laka_head->dispatcher             = $request->dispatcher;
    $ba_laka_head->spk                    = $request->spk;
    $ba_laka_head->no_armada              = $request->no_armada;
    $ba_laka_head->jam_keluar             = $request->jam_keluar;
    $ba_laka_head->jam_kejadian           = $request->jam_kejadian;
    $ba_laka_head->rallying               = '';
    $ba_laka_head->speed                  = $request->speed;
    $ba_laka_head->in_pool                = '';
    $ba_laka_head->out_pool               = '';
    $ba_laka_head->rute                   = $request->rute;
    $ba_laka_head->bengkel_terakhir       = $request->bengkel_terakhir;
    $ba_laka_head->lokasi_kejadian        = $request->lokasi_kejadian;
    $ba_laka_head->date_laka              = $request->date_laka;
    $ba_laka_head->fatality               = $request->fatality;
    $ba_laka_head->save();
    foreach($request['posisi'] as $key => $item_id)
      {
          $ba_laka_detail = new BA_laka_detail();
          $ba_laka_detail->tr_ba_laka_code_h  = $ba_laka_head->tr_ba_laka_code;
          $ba_laka_detail->posisi             = $request['posisi'][$key];
          $ba_laka_detail->nama               = $request['nama'][$key];
          $ba_laka_detail->usia               = $request['usia'][$key];
          $ba_laka_detail->penguji            = $request['penguji'][$key];
          $ba_laka_detail->avg_income         = $request['avg_income'][$key];
          $ba_laka_detail->istirahat_last     = $request['istirahat_last'][$key];
          $ba_laka_detail->save();
      }

      // session()->flash('success', 'Data berhasil disimpan!');
      // return redirect('ba_laka');


      // $main_ba = BA_Main::where('Tr_BA_Code', '=', $main_ba->Tr_BA_Code )->first();
      // $dok1 = BA_docs::where('ba_main_code', '=', $main_ba->Tr_BA_Code )->first();
      // $dok2 = BA_docs2::where('ba_main_code', '=', $main_ba->Tr_BA_Code )->first();
      // $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba->Tr_BA_Code)->first();

      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
      $laka_h = BA_laka_header::where('tr_ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
      $laka_d = BA_laka_detail::where('tr_ba_laka_code_h', '=', $laka_h->tr_ba_laka_code)->get();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
      
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s');   
        // Setup a filename 
        $documentFileName = $main_ba_new->Tr_BA_Main_Code.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);     
 
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
    
      $no=1;
      $laka_ = '';
      foreach($laka_d as $row){

        $laka_ .= 
        '<tr>
        <td>'.$no.'</td>
        <td>'.$row->posisi.'</td>
        <td>'.$row->nama.'</td>
        <td>'.$row->usia.'</td>
        <td>'.$row->penguji.'</td>
        <td>Rp. '.$row->avg_income.'</td>
        <td>'.$row->istirahat_last.'</td>
        </tr>';
      }    
    
        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Berita Acara Laka</center></h3>
                  <hr/>
                  <br>
                        <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                                <th style="width: 15%;"></th>
                                <th style="width: 35%;"></th>
                            </tr>
                        </thead>
                        <tbody>     
                          <tr>
                            <td>Code</td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
                            <td>Perusahaan</td><td>: '.$main_ba_new->rec_comcode.'</td>
                          </tr>

                          <tr>
                            <td>Jenis Laka</td><td>: '.$laka_h->ms_jenis_laka.'</td>
                            <td>Faktor</td><td>: '.$laka_h->ms_faktor_laka.'</td>
                          </tr>
                          <tr>
                            <td>Klasifikasi</td><td>: '.$laka_h->ms_klasifikasi_laka.'</td>
                            <td>Dampak</td><td>: '.$laka_h->ms_dampak_laka.'</td>
                          </tr>

                          <tr>
                            <td>BA Type</td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
                            <td>Location</td><td>: '.$main_ba_new->rec_areacode.'</td>
                          </tr>
                          <tr>
                            <td>Kategori</td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
                            <td>Type</td><td>: '.$laka_h->type_laka.'</td>
                          </tr>
                          <tr>
                            <td>Tanggal BA</td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").'  </td>
                            <td>Fatality</td><td>: '.$laka_h->fatality.'</td>
                          </tr>
                          <tr>
                            <td>SPK</td><td>: '.$laka_h->spk.' </td>
                            <td >No. Armada&nbsp</td><td>: '.$laka_h->no_armada.' </td>
                          </tr>
                          <tr>
                            <td>Tgl Kejadian</td><td>: '.date_format(date_create($laka_h->date_laka),"d/m/Y").' </td>
                            <td >Jam Keluar</td><td>: '.$laka_h->jam_keluar.' </td>
                          </tr>
                          <tr>
                            <td>Loc. Kejadian</td><td>: '.$laka_h->lokasi_kejadian.' </td>
                            <td >Jam Kejadian</td><td>: '.$laka_h->jam_kejadian.' </td>
                          </tr>
                          <tr>
                          <td>Rute</td><td>: '.$laka_h->rute.' </td>
                          <td >Dispatcher</td><td>: '.$laka_h->dispatcher.' </td>
                          </tr>
                          <tr>
                            <td>Speed</td><td>: '.$laka_h->speed.' </td>
                            <td >Bengkel Terakhir</td><td>: '.$laka_h->bengkel_terakhir.' </td>
                          </tr>
                         </tbody>   
                      </table>
                      <br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">'.$ba_kronologi->kronlogi.'</div>
                      <br>
                      <br>
            <table class="table table-bordered mt-4" style="width: 100%;" >
                <thead>
                    <tr>
                        <th style="width: 5%;"> No. </th>
                        <th style="width: 10%;">Jabatan</th>
                        <th style="width: 15%;">Nama</th>
                        <th style="width: 5%;">Usia</th>
                        <th style="width: 15%;">Penguji</th>
                        <th style="width: 10%;">Avg. Income</th>
                        <th style="width: 10%;">Istirahat Last</th>
                    </tr>
                </thead>
                <tbody>'.$laka_.'
                </tbody>
            </table>
            <br>
            <br>
          <br>
          <br>
          <br>
          <table>
            <tr><td >Operator <br> <br> <br> <br> <br> <br></td></tr>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>

        ');
        
        
        // Save PDF on your public storage 
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
         
        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //
            //pdf
            // $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s'); 
            // $data = [
            //   'main_ba_new'   => $main_ba_new,
            //   'laka_h'        => $laka_h,
            //   'laka_d'        => $laka_d,
            //   'ba_kronologi'  => $ba_kronologi,
            //   'datetime'      => $datetime
            // ];
            // $pdf = PDF::loadView('berita_acara.print_berita_acara_laka',$data);
      
            // return $pdf->download($main_ba_new->Tr_BA_Main_Code.'.pdf');      

      //return view ('berita_acara.print_berita_acara_laka', compact('main_ba_new', 'laka_h', 'laka_d','ba_kronologi') );
    }
     public function report_laka(Request $request)
    {
      $report = DB::connection('mysql')->select("
        select DISTINCT
        main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Pelapor_Code,
	      header.no_armada,
	      header.ms_jenis_laka,
        header.ms_faktor_laka,
        header.ms_klasifikasi_laka,
        header.ms_dampak_laka,
		    header.type_laka,
		    header.fatality,
	      detail.nama,
	      detail.posisi,
	      detail.penguji
        from
        Tr_Ba_Main_New main
		    left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
		    left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1' and Ms_BA_type_Code ='Laka'
        order by created_at DESC
      ");

      return view('berita_acara.report_laka', compact('report'));
    }
     public function dashboard_semua_ba(Request $request)
    {
      $report = DB::connection('mysql')->select("
          select count(sumkas) as total, 
                            Tr_BA_Main_Code,
                            Ms_BA_type_Code,	
                            Ms_Emp_Code,	
                            Ms_Emp_Div,
                            Ms_Pelapor_Code,
                            Ms_Pelapor_Div,
                            Date_BA,
                            BA_Desc,
                            CekPelanggaran,
                            CekKerusakan,	
                            CekFraud,
                            CekRevisi,
                            CekDisiplin,
                            CekSalahIsi,
                            CekNoClosing,
                            CekLaka,
                            CekPembelian,
                            CekKehilangan,	
                            CekPerubahanSOP,	
                            MS_Detail_Kasus,
                            Tr_EmpPeriod_Code,
                            rec_usercreated,
                            rec_userupdate,
                            rec_datecreated,
                            rec_dateupdate,
                            rec_comcode,
                            rec_areacode  
                              from 
                                (
                                 select 
                                      Tr_Ba_Main_New.Ms_Emp_Code as sumkas,
                                      Tr_Ba_Main_New.Tr_BA_Main_Code,
                                      Tr_Ba_Main_New.Ms_BA_type_Code,	
                                      Tr_Ba_Main_New.Ms_Emp_Code,	
                                      Tr_Ba_Main_New.Ms_Emp_Div,
                                      Tr_Ba_Main_New.Ms_Pelapor_Code,
                                      Tr_Ba_Main_New.Ms_Pelapor_Div,
                                      Tr_Ba_Main_New.Date_BA,
                                      Tr_Ba_Main_New.BA_Desc,
                                      Tr_Ba_Main_New.CekPelanggaran,
                                      Tr_Ba_Main_New.CekKerusakan,	
                                      Tr_Ba_Main_New.CekFraud,
                                      Tr_Ba_Main_New.CekRevisi,
                                      Tr_Ba_Main_New.CekDisiplin,
                                      Tr_Ba_Main_New.CekSalahIsi,
                                      Tr_Ba_Main_New.CekNoClosing,
                                      Tr_Ba_Main_New.CekLaka,
                                      Tr_Ba_Main_New.CekPembelian,
                                      Tr_Ba_Main_New.CekKehilangan,	
                                      Tr_Ba_Main_New.CekPerubahanSOP,	
                                      Tr_Ba_Main_New.MS_Detail_Kasus,
                                      Tr_Ba_Main_New.Tr_EmpPeriod_Code,
                                      Tr_Ba_Main_New.rec_usercreated,
                                      Tr_Ba_Main_New.rec_userupdate,
                                      Tr_Ba_Main_New.rec_datecreated,
                                      Tr_Ba_Main_New.rec_dateupdate,
                                      Tr_Ba_Main_New.rec_comcode,
                                      Tr_Ba_Main_New.rec_areacode 
                                    from Tr_Ba_Main_New 
                                    where Ms_BA_type_Code != 'Laka' OR 
                                  Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                  Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                  Tr_Ba_Main_New.CekFraud  = '1' OR
                                  Tr_Ba_Main_New.CekRevisi  = '1' OR
                                  Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                  Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                  Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                  Tr_Ba_Main_New.CekLaka  = '1' OR
                                  Tr_Ba_Main_New.CekPembelian  = '1' OR
                                  Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                  Tr_Ba_Main_New.CekPerubahanSOP  = '1'
                                 UNION ALL 
                                 select Tr_Ba_Main_New.Ms_Emp_Code as sumkas,
                                    tr_ba_laka_d.nama as Ms_Emp_Code,  
                                    Tr_Ba_Main_New.Tr_BA_Main_Code,
                                    Tr_Ba_Main_New.Ms_BA_type_Code,	
                                    Tr_Ba_Main_New.Ms_Emp_Div,
                                    Tr_Ba_Main_New.Ms_Pelapor_Code,
                                    Tr_Ba_Main_New.Ms_Pelapor_Div,
                                    Tr_Ba_Main_New.Date_BA,
                                    Tr_Ba_Main_New.BA_Desc,
                                    Tr_Ba_Main_New.CekPelanggaran,
                                    Tr_Ba_Main_New.CekKerusakan,	
                                    Tr_Ba_Main_New.CekFraud,
                                    Tr_Ba_Main_New.CekRevisi,
                                    Tr_Ba_Main_New.CekDisiplin,
                                    Tr_Ba_Main_New.CekSalahIsi,
                                    Tr_Ba_Main_New.CekNoClosing,
                                    Tr_Ba_Main_New.CekLaka,
                                    Tr_Ba_Main_New.CekPembelian,
                                    Tr_Ba_Main_New.CekKehilangan,	
                                    Tr_Ba_Main_New.CekPerubahanSOP,	
                                    Tr_Ba_Main_New.MS_Detail_Kasus,
                                    Tr_Ba_Main_New.Tr_EmpPeriod_Code,
                                    Tr_Ba_Main_New.rec_usercreated,
                                    Tr_Ba_Main_New.rec_userupdate,
                                    Tr_Ba_Main_New.rec_datecreated,
                                    Tr_Ba_Main_New.rec_dateupdate,
                                    Tr_Ba_Main_New.rec_comcode,
                                    Tr_Ba_Main_New.rec_areacode
                                    from tr_ba_laka_h 
                                    right join tr_ba_laka_d on tr_ba_laka_h.tr_ba_laka_code = tr_ba_laka_d.tr_ba_laka_code_h 
                                    left join Tr_Ba_Main_New on tr_ba_laka_h.tr_ba_main_code = Tr_Ba_Main_New.Tr_BA_Main_Code 
                                  where Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                    Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                    Tr_Ba_Main_New.CekFraud  = '1' OR
                                    Tr_Ba_Main_New.CekRevisi  = '1' OR
                                    Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                    Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                    Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                    Tr_Ba_Main_New.CekLaka  = '1' OR
                                    Tr_Ba_Main_New.CekPembelian  = '1' OR
                                    Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                    Tr_Ba_Main_New.CekPerubahanSOP  = '1' 
                                 ) tab 
                                 group by Ms_Emp_Code 
                                 order by total desc;");

      $pelaku = DB::connection('mysql')->select("
                                                select count(sumkas) as total, Ms_Emp_Code  
                                                from 
                                                  (
                                                   select Tr_Ba_Main_New.Ms_Emp_Code as sumkas, Tr_Ba_Main_New.Ms_Emp_Code 
                                                      from Tr_Ba_Main_New 
                                                      where Ms_BA_type_Code != 'Laka' OR 
                                                      Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1' 
                                                   UNION ALL 
                                                   select Tr_Ba_Main_New.Ms_Emp_Code as sumkas, tr_ba_laka_d.nama as Ms_Emp_Code  
                                                      from tr_ba_laka_h 
                                                      right join tr_ba_laka_d on tr_ba_laka_h.tr_ba_laka_code = tr_ba_laka_d.tr_ba_laka_code_h 
                                                      left join Tr_Ba_Main_New on tr_ba_laka_h.tr_ba_main_code = Tr_Ba_Main_New.Tr_BA_Main_Code
                                                      where Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1'  
                                                   ) tab 
                                                   group by Ms_Emp_Code 
                                                   order by total desc;
                                               ");

      $pelapor = DB::connection('mysql')->select("
                                                select count(sumkas) as total, Ms_Pelapor_Code
                                                from 
                                                  (
                                                   select Tr_Ba_Main_New.Ms_Pelapor_Code as sumkas, Ms_Pelapor_Code 
                                                      from Tr_Ba_Main_New 
                                                      where Ms_BA_type_Code != 'Laka' OR 
                                                      Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1' 
                                                   UNION ALL 
                                                   select Tr_Ba_Main_New.Ms_Pelapor_Code as sumkas, Ms_Pelapor_Code 
                                                      from tr_ba_laka_h 
                                                      right join tr_ba_laka_d on tr_ba_laka_h.tr_ba_laka_code = tr_ba_laka_d.tr_ba_laka_code_h 
                                                      left join Tr_Ba_Main_New on tr_ba_laka_h.tr_ba_main_code = Tr_Ba_Main_New.Tr_BA_Main_Code
                                                      where Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1'  
                                                   ) tab 
                                                   group by Ms_Pelapor_Code
                                                   order by total desc;
                                               ");

      $kasus = DB::connection('mysql')->select("
                                                select count(sumkas) as total, Ms_Kasus
                                                from
                                                  (
                                                   select Tr_Ba_Main_New.Ms_Kasus as sumkas, Tr_Ba_Main_New.Ms_Kasus 
                                                      from Tr_Ba_Main_New 
                                                      where Ms_BA_type_Code != 'Laka' OR 
                                                      Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1'  
                                                   UNION ALL 
                                                   select Tr_Ba_Main_New.Ms_Kasus as sumkas, Tr_Ba_Main_New.Ms_Kasus 
                                                      from tr_ba_laka_h 
                                                      right join tr_ba_laka_d on tr_ba_laka_h.tr_ba_laka_code = tr_ba_laka_d.tr_ba_laka_code_h 
                                                      left join Tr_Ba_Main_New on tr_ba_laka_h.tr_ba_main_code = Tr_Ba_Main_New.Tr_BA_Main_Code 
                                                      where Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1' 
                                                   ) tab 
                                                   group by Ms_Kasus
                                                   order by total desc;
                                               ");
      $detail_kasus = DB::connection('mysql')->select("
                                                select count(sumkas) as total, MS_Detail_Kasus
                                                from 
                                                  (
                                                   select Tr_Ba_Main_New.MS_Detail_Kasus as sumkas, Tr_Ba_Main_New.MS_Detail_Kasus 
                                                      from Tr_Ba_Main_New 
                                                      where Ms_BA_type_Code != 'Laka' OR 
                                                      Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1'  
                                                   UNION ALL 
                                                   select Tr_Ba_Main_New.MS_Detail_Kasus as sumkas, Tr_Ba_Main_New.MS_Detail_Kasus 
                                                      from tr_ba_laka_h 
                                                      right join tr_ba_laka_d on tr_ba_laka_h.tr_ba_laka_code = tr_ba_laka_d.tr_ba_laka_code_h 
                                                      left join Tr_Ba_Main_New on tr_ba_laka_h.tr_ba_main_code = Tr_Ba_Main_New.Tr_BA_Main_Code
                                                      where Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1'  
                                                   ) tab 
                                                   group by MS_Detail_Kasus
                                                   order by total desc;
                                               ");

      $devisi = DB::connection('mysql')->select("
                                                select count(sumkas) as total, Ms_Emp_Div
                                                from 
                                                  (
                                                   select Tr_Ba_Main_New.Ms_Emp_Div as sumkas, Tr_Ba_Main_New.Ms_Emp_Div 
                                                      from Tr_Ba_Main_New 
                                                      where Ms_BA_type_Code != 'Laka' OR 
                                                      Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1'  
                                                   UNION ALL 
                                                   select Tr_Ba_Main_New.Ms_Emp_Div as sumkas, Tr_Ba_Main_New.Ms_Emp_Div 
                                                      from tr_ba_laka_h 
                                                      right join tr_ba_laka_d on tr_ba_laka_h.tr_ba_laka_code = tr_ba_laka_d.tr_ba_laka_code_h 
                                                      left join Tr_Ba_Main_New on tr_ba_laka_h.tr_ba_main_code = Tr_Ba_Main_New.Tr_BA_Main_Code 
                                                      where Tr_Ba_Main_New.CekPelanggaran = '1' OR
                                                      Tr_Ba_Main_New.CekKerusakan  = '1' OR	
                                                      Tr_Ba_Main_New.CekFraud  = '1' OR
                                                      Tr_Ba_Main_New.CekRevisi  = '1' OR
                                                      Tr_Ba_Main_New.CekDisiplin  = '1' OR
                                                      Tr_Ba_Main_New.CekSalahIsi  = '1' OR
                                                      Tr_Ba_Main_New.CekNoClosing  = '1' OR
                                                      Tr_Ba_Main_New.CekLaka  = '1' OR
                                                      Tr_Ba_Main_New.CekPembelian  = '1' OR
                                                      Tr_Ba_Main_New.CekKehilangan  = '1' OR	
                                                      Tr_Ba_Main_New.CekPerubahanSOP  = '1' 
                                                   ) tab 
                                                   group by Ms_Emp_Div 
                                                   order by total desc;
                                               ");

      $kategori = DB::connection('mysql')->select("
      select  sum(CekKerusakan) as kerusakan, sum(CekRevisi) as revisi, sum(CekDisiplin) as disiplin, sum(CekSalahIsi) as salahisi, sum(CekNoClosing) as noclosing, sum(CekLaka) as laka, sum(CekPembelian) as pembelian, sum(CekKehilangan) as kehilangan, sum(CekPerubahanSOP) as perubahansop 
      from (
      select CekKerusakan, CekFraud, CekRevisi, CekDisiplin, CekSalahIsi, CekNoClosing, CekLaka, CekPembelian, CekKehilangan, CekPerubahanSOP
       from Tr_Ba_Main_New 
       where Ms_BA_type_Code != 'Laka' OR 
       Tr_Ba_Main_New.CekPelanggaran = '1' OR
       Tr_Ba_Main_New.CekKerusakan  = '1' OR	
       Tr_Ba_Main_New.CekFraud  = '1' OR
       Tr_Ba_Main_New.CekRevisi  = '1' OR
       Tr_Ba_Main_New.CekDisiplin  = '1' OR
       Tr_Ba_Main_New.CekSalahIsi  = '1' OR
       Tr_Ba_Main_New.CekNoClosing  = '1' OR
       Tr_Ba_Main_New.CekLaka  = '1' OR
       Tr_Ba_Main_New.CekPembelian  = '1' OR
       Tr_Ba_Main_New.CekKehilangan  = '1' OR	
       Tr_Ba_Main_New.CekPerubahanSOP  = '1' 
      UNION ALL 
      select CekKerusakan, CekFraud, CekRevisi, CekDisiplin, CekSalahIsi, CekNoClosing, CekLaka, CekPembelian, CekKehilangan, CekPerubahanSOP
        from tr_ba_laka_h 
        right join tr_ba_laka_d on tr_ba_laka_h.tr_ba_laka_code = tr_ba_laka_d.tr_ba_laka_code_h 
        left join Tr_Ba_Main_New on tr_ba_laka_h.tr_ba_main_code = Tr_Ba_Main_New.Tr_BA_Main_Code 
        where Tr_Ba_Main_New.CekPelanggaran = '1' OR
        Tr_Ba_Main_New.CekKerusakan  = '1' OR	
        Tr_Ba_Main_New.CekFraud  = '1' OR
        Tr_Ba_Main_New.CekRevisi  = '1' OR
        Tr_Ba_Main_New.CekDisiplin  = '1' OR
        Tr_Ba_Main_New.CekSalahIsi  = '1' OR
        Tr_Ba_Main_New.CekNoClosing  = '1' OR
        Tr_Ba_Main_New.CekLaka  = '1' OR
        Tr_Ba_Main_New.CekPembelian  = '1' OR
        Tr_Ba_Main_New.CekKehilangan  = '1' OR	
        Tr_Ba_Main_New.CekPerubahanSOP  = '1'
      ) tab ");                                    
      $userlogin = DB::connection('mysql')->select("
      select  * from users where activate ='1' ORDER BY username asc
      ");
      
    //   $users = DB::connection('mysql')->select("
    //   select  * from tr_ba_main where rec_status ='1' ORDER BY User_Code asc
    //   ");
      $users = DB::connection('mysql')->select("
      select  * from master_employees where emp_inactive ='1' ORDER BY emp_name asc
      ");
      $jenis = DB::connection('mysql')->select("
      select * from ms_kasus_head where ms_type ='Berita Acara' and rec_status ='1' order by description asc
      ");
      $ms_kasus = DB::connection('mysql')->select("
      select * from ms_kasus where rec_status ='1' order by description asc
      ");

      return view('berita_acara.dashboard_semua_ba', compact('pelaku', 'pelapor', 'kasus', 'detail_kasus', 'devisi', 'kategori', 'report', 'userlogin', 'users', 'jenis', 'ms_kasus'));
    }

    public function view_detail_pelaku(Request $request, $id)
    {
      //$main = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->whereDate('created_at', Carbon::today())->first();
      $report = DB::connection('mysql')->select("
     
      SELECT
      main.Tr_BA_Main_Code,
	  main.created_at,
      main.rec_comcode,
      main.rec_areacode,
      main.Ms_Kasus,
      main.Ms_Pelapor_Code,
      main.Ms_Emp_Code,
      main.Ms_Emp_Div,
      main.MS_Detail_Kasus

      FROM Tr_Ba_Main_New main
      left join tr_ba_kronologi krono on main.Tr_BA_Main_Code = krono.tr_ba_main_code
      left join tr_ba_salah_isi_detail detail_revisi on main.Tr_BA_Main_Code = detail_revisi.tr_ba_code_main

      where main.Ms_Emp_Code = '$id' and main.rec_status ='1'
      and CONVERT(main.created_at, date) = CURDATE()
union
			
	  SELECT
      main.Tr_BA_Main_Code,
	  main.created_at,
      main.rec_comcode,
      main.rec_areacode,
      main.Ms_Kasus,
      main.Ms_Pelapor_Code,
      detail.nama as Ms_Emp_Code,
      detail.posisi as Ms_Emp_Div,
      main.MS_Detail_Kasus
			
      FROM Tr_Ba_Main_New main
      left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	  left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
      
	  where detail.nama = '$id' and main.rec_status ='1'			
    and CONVERT(main.created_at, date) = CURDATE()
      ");
      // dd($id);die;
      return view('berita_acara.detail_pelaku', compact('report','id'));
    }

    public function view_detail_pelaku_week(Request $request, $id)
    {
      $main = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $report = DB::connection('mysql')->select("
     
      SELECT
      main.Tr_BA_Main_Code,
	    main.created_at,
      main.rec_comcode,
      main.rec_areacode,
      main.Ms_Kasus,
      main.Ms_Pelapor_Code,
      main.Ms_Emp_Code,
      main.Ms_Emp_Div,
      main.MS_Detail_Kasus

      FROM Tr_Ba_Main_New main
      left join tr_ba_kronologi krono on main.Tr_BA_Main_Code = krono.tr_ba_main_code
      left join tr_ba_salah_isi_detail detail_revisi on main.Tr_BA_Main_Code = detail_revisi.tr_ba_code_main

      where main.Ms_Emp_Code = '$id' and main.rec_status ='1'
      and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
union
			
	  SELECT
      main.Tr_BA_Main_Code,
	  main.created_at,
      main.rec_comcode,
      main.rec_areacode,
      main.Ms_Kasus,
      main.Ms_Pelapor_Code,
      detail.nama as Ms_Emp_Code,
      detail.posisi as Ms_Emp_Div,
      main.MS_Detail_Kasus
			
      FROM Tr_Ba_Main_New main
      left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	  left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
      
	  where detail.nama = '$id' and main.rec_status ='1'			
    and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
      ");
      // dd($id);die;
      return view('berita_acara.detail_pelaku', compact('report','id'));
    }
    public function view_detail_pelaku_month(Request $request, $id)
    {
      $main = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
      $report = DB::connection('mysql')->select("
     
      SELECT
      main.Tr_BA_Main_Code,
	    main.created_at,
      main.rec_comcode,
      main.rec_areacode,
      main.Ms_Kasus,
      main.Ms_Pelapor_Code,
      main.Ms_Emp_Code,
      main.Ms_Emp_Div,
      main.MS_Detail_Kasus

      FROM Tr_Ba_Main_New main
      left join tr_ba_kronologi krono on main.Tr_BA_Main_Code = krono.tr_ba_main_code
      left join tr_ba_salah_isi_detail detail_revisi on main.Tr_BA_Main_Code = detail_revisi.tr_ba_code_main

      where main.Ms_Emp_Code = '$id' and main.rec_status ='1'
      and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
union
			
	  SELECT
      main.Tr_BA_Main_Code,
	  main.created_at,
      main.rec_comcode,
      main.rec_areacode,
      main.Ms_Kasus,
      main.Ms_Pelapor_Code,
      detail.nama as Ms_Emp_Code,
      detail.posisi as Ms_Emp_Div,
      main.MS_Detail_Kasus
			
      FROM Tr_Ba_Main_New main
      left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	  left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
      
	  where detail.nama = '$id' and main.rec_status ='1'			
    and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
      ");
      // dd($id);die;
      return view('berita_acara.detail_pelaku', compact('report','id'));
    }  
    public function viewkategoriday(Request $request,$id)
    {

      if($id == 'pelanggaran'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and CekRevisi = '0'
        and main.created_at >= curdate()
        and CekPelanggaran ='1'        
                    ");
      }
      elseif($id == 'perubahan'){
        $report = DB::connection('mysql')->select("
        SELECT        
        main.Tr_BA_Main_Code,
	      main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= curdate()
        and CekPerubahanSOP ='1'
                    ");
      }
      elseif($id == 'kehilangankerusakan'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	      main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= curdate()
        and (CekKehilangan ='1' or CekKerusakan ='1')
                    ");
      }
      elseif($id == 'pembelian'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	      main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= curdate()
        and CekPembelian ='1'
                    ");
      }
      elseif($id == 'laka'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	      main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        detail.nama as Ms_Emp_Code,
        detail.posisi as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= curdate()
        and CekLaka ='1'
                    ");
      }
      elseif($id == 'revisi'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and CekRevisi = '1'
        and main.created_at >= curdate()
                    ");
      }
      return view('berita_acara.detail_pelaku', compact('report','id'));
    }   

    public function viewkategoriweek(Request $request,$id)
    {

      if($id == 'pelanggaran'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and CekRevisi = '0'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        and CekPelanggaran ='1'        
                    ");
      }
      elseif($id == 'perubahan'){
        $report = DB::connection('mysql')->select("
        SELECT        
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        and CekPerubahanSOP ='1'
                    ");
      }
      elseif($id == 'kehilangankerusakan'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        and (CekKehilangan ='1' or CekKerusakan ='1')
                    ");
      }
      elseif($id == 'pembelian'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        and CekPembelian ='1'
                    ");
      }
      elseif($id == 'laka'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        and CekLaka ='1'
                    ");
      }
      elseif($id == 'revisi'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and CekRevisi = '1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    ");
      }
      return view('berita_acara.detail_pelaku', compact('report','id'));
    }       

    public function viewkategorimonth(Request $request,$id)
    {

      if($id == 'pelanggaran'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and CekRevisi = '0'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        and CekPelanggaran ='1'        
                    ");
      }
      elseif($id == 'perubahan'){
        $report = DB::connection('mysql')->select("
        SELECT        
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        and CekPerubahanSOP ='1'
                    ");
      }
      elseif($id == 'kehilangankerusakan'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        and (CekKehilangan ='1' or CekKerusakan ='1')
                    ");
      }
      elseif($id == 'pembelian'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        and CekPembelian ='1'
                    ");
      }
      elseif($id == 'laka'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	      main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        detail.nama as Ms_Emp_Code,
        detail.posisi as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        and CekLaka ='1'
                    ");
      }
      elseif($id == 'revisi'){
        $report = DB::connection('mysql')->select("
        SELECT
        main.Tr_BA_Main_Code,
	    main.created_at,
        main.rec_comcode,
        main.rec_areacode,
        main.Ms_Kasus,
        main.MS_Detail_Kasus,
        main.Ms_Pelapor_Code,
        main.Ms_Emp_Code as Ms_Emp_Code,
        main.Ms_Emp_Div as Ms_Emp_Div
        FROM Tr_Ba_Main_New main
        left join tr_ba_laka_h header on main.Tr_BA_Main_Code = header.tr_ba_main_code
	      left join tr_ba_laka_d detail on header.tr_ba_laka_code = detail.tr_ba_laka_code_h
        where rec_status ='1'
        and CekRevisi = '1'
        and main.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    ");
      }
      return view('berita_acara.detail_pelaku', compact('report','id'));
    }       
    
   
   
//test   
   
    public function testdobel()
    {

      $main_ba_test = DB::connection('mysql')->select("
      SELECT Tr_Ba_Main_New.Tr_BA_Main_Code, 
      Tr_Ba_Main_New.rec_status, 
      Tr_Ba_Main_New.created_at,
      Tr_Ba_Main_New.Ms_Pelapor_Code , 
      tr_ba_kronologi.kronlogi 
      FROM `Tr_Ba_Main_New` 
      right join tr_ba_kronologi on Tr_Ba_Main_New.Tr_BA_Main_Code = tr_ba_kronologi.tr_ba_main_code 
      WHERE date(Tr_Ba_Main_New.created_at) 
      -- Between '2024-04-16' and '2024-04-23' 
      order by Tr_Ba_Main_New.created_at desc;
      ");

        //dd($main_ba_test);
        return view ('berita_acara.testdobel', compact('main_ba_test'));
      


    }  
    
    
   public function action_temuan ()
  {
    $user = auth()->user();

    $report = DB::connection('mysql')->select("
    SELECT
		if(ket is null, 'belum dilihat',ket) ket,
		h.Tr_BA_Main_Code,
    CekPelanggaran,
    CekKerusakan,
    CekFraud,
    CekRevisi,
    CekDisiplin,
    CekSalahIsi,
    CekNoClosing,
    CekLaka,
    CekPembelian,
    CekKehilangan,
    CekPerubahanSOP,
    created_at,
    Date_BA,
    rec_comcode,
    rec_areacode,
    Ms_Pelapor_Code,
    Ms_Pelapor_Div,
    Ms_Emp_Code,
    Ms_Emp_Div,
    Ms_Kasus,
    MS_Detail_Kasus,
    BA_Desc
    FROM
        Tr_Ba_Main_New h
		LEFT JOIN
		(
		SELECT
				Tr_BA_Main_Code,
				count(0), 'sudah dilihat' ket
				from Tr_BA_Comment
				WHERE Ms_User = '$user->username'
				GROUP BY Tr_BA_Main_Code
		) d on h.Tr_BA_Main_Code = d.Tr_BA_Main_Code
    WHERE
        rec_status = '1'
				-- and h.Tr_BA_Main_Code =
       AND DATE(created_at) = CURRENT_DATE;
      ");

// dd($user_veiw);
      return view ('berita_acara.check_temuan', compact ('report'));

  }
  
   public function search_temuan(request $request)
  {

     $tgl_awal  = $request->tgl_awal;
      $tgl_akhir = $request->tgl_akhir;
      $user = auth()->user();
  
      $report = DB::connection('mysql')->select("
          SELECT
              IF(ket IS NULL, 'belum dilihat', ket) ket,
              h.Tr_BA_Main_Code,
              CekPelanggaran,
              CekKerusakan,
              CekFraud,
              CekRevisi,
              CekDisiplin,
              CekSalahIsi,
              CekNoClosing,
              CekLaka,
              CekPembelian,
              CekKehilangan,
              CekPerubahanSOP,
              created_at,
              Date_BA,
              rec_comcode,
              rec_areacode,
              Ms_Pelapor_Code,
              Ms_Pelapor_Div,
              Ms_Emp_Code,
              Ms_Emp_Div,
              Ms_Kasus,
              MS_Detail_Kasus,
              BA_Desc
          FROM Tr_Ba_Main_New h
          LEFT JOIN (
              SELECT
                  Tr_BA_Main_Code,
                  COUNT(0), 'sudah dilihat' ket
              FROM Tr_BA_Comment
              WHERE Ms_User = ?
              GROUP BY Tr_BA_Main_Code
          ) d ON h.Tr_BA_Main_Code = d.Tr_BA_Main_Code
          WHERE rec_status = '1'
            AND DATE(created_at) >= ?
            AND DATE(created_at) <= ?
          ORDER BY created_at DESC
      ", [$user->username, $tgl_awal, $tgl_akhir]);
  
      return response()->json(['data' => $report]);
  }

    

  public function detail_check_temuan(Request $request, $id)
  {
    $kode_ba =$id;
    {
    $user =  auth()->user()->username;
    $timestamp = Carbon::now()->timestamp;
    $tanggalSekarang = Carbon::now();
    $tahunSaatIni = $tanggalSekarang->year;
    $weeks = $tanggalSekarang->weekOfYear;
    do
    {
      $randomValue = mt_rand(100, 999);
      $autoNumber = 'Comment' . $weeks. $tahunSaatIni . $randomValue;
      $isUnique = !DB::table('Tr_BA_Comment')
          ->where('Tr_BA_Comment_Code', $autoNumber)
          ->exists();
    }
    while (!$isUnique);

        
        $status = $request->input('status');
        $jakartaTime = Carbon::now('Asia/Jakarta');
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        $dayName = $days[$jakartaTime->format('l')];
        $monthName = $months[$jakartaTime->format('F')];

        $formattedTime = $dayName . ', ' . $jakartaTime->format('j') . ' ' . $monthName . ' ' . $jakartaTime->format('Y') . ' | ' . $jakartaTime->format('H:i');
        $note = "dilihat pada : $formattedTime";
        $lastno = DB::connection('mysql')->select("
        SELECT COUNT(1) as total FROM Tr_BA_Comment WHERE Tr_BA_Main_Code = ? and Ms_User = ?
        ", [$kode_ba, $user]);
        $no_record = $lastno[0]->total;
        // dd($no_record, $user, $kode_ba);

        $lastno2 = DB::connection('mysql')->select("
        SELECT COUNT(1) as total FROM Tr_BA_Comment WHERE Tr_BA_Main_Code = ?
        ", [$kode_ba]);
        $no_record2 = $lastno2[0]->total;
        if($no_record == 0){
            $data = DB::connection('mysql')->insert("
                INSERT INTO Tr_BA_Comment (
                    Tr_BA_Main_Code,
                    Tr_BA_Comment_Code,
                    Comment,
                    created_at,
                    Ms_User

                ) VALUES (
                    '$id',
                    '$autoNumber',
                    '$note',
                    '$jakartaTime',
                    '$user'
                )
            ");
          }
          $main_ba = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $id)->first();
          $dok1 = BA_docs::where('ba_main_code', '=', $id)->first();
          $dok2 = BA_docs2::where('ba_main_code', '=', $id)->first();
          $detail = BA_Salah_Isi_d::where('tr_ba_code_main', '=', $id)->get();
          $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $id)->first();
          return view('berita_acara.detail_check_temuan', compact('user','main_ba', 'detail','ba_kronologi', 'dok1', 'dok2'));


    }
  }
  public function priority_note(Request $request)
  {
    $code = $request->input('code');
    // dd($code);
        $data = DB::connection('mysql')->select("
            SELECT *
            FROM Tr_BA_Comment
            WHERE Tr_BA_Main_Code = ?
            order by created_at desc
        ", [$code]);

        return response()->json($data);
  }

  public function store_detail_check_temuan(request $request, $id)
  {
    $user = auth()->user();
    $timestamp = Carbon::now()->timestamp;
    $tanggalSekarang = Carbon::now();
    $tahunSaatIni = $tanggalSekarang->year;
    $weeks = $tanggalSekarang->weekOfYear;
    do
    {
      $randomValue = mt_rand(100, 999);
      $autoNumber = 'Comment' . $weeks. $tahunSaatIni . $randomValue;
      $isUnique = !DB::table('Tr_BA_Comment')
          ->where('Tr_BA_Comment_Code', $autoNumber)
          ->exists();
    }
    while (!$isUnique);
    $comment = new Tr_BA_Comment();
    $comment->Tr_BA_Comment_Code = $autoNumber;
    $comment->Tr_BA_Main_Code    = $id;
    $comment->Ms_User            = $user->username;
    $comment->Comment            = $request->comment;
    $comment->save();

    session()->flash('success', 'BA sudah di check!');
    return redirect('/action_temuan');
  }

//   public function index_berita_acara_all(Request $request)
//     {
//       $user = auth()->user();
//       $lokasi = MsLocation::all();
//       $employee = MasterEmployee::all();
//       $divisi = ms_divisi::all();
//       $company = Ms_Company::all();
//       $ms_kasus = Ms_Kasus::all();
//       $users = DB::connection('mysql')->select("

//       select   * from master_employees where emp_inactive ='1'  ORDER BY emp_name asc
//       ");
//       $jenis = DB::connection('mysql')->select("
//       select * from ms_kasus_head where ms_type ='Berita Acara' and rec_status ='1' order by description asc
//       ");
//       $ms_kasus = DB::connection('mysql')->select("
//       select * from ms_kasus where ms_kasus_head1 !='01' and rec_status ='1' order by description asc
//       ");
//       $last_id2 = DB::connection('mysql')->select("
//       SELECT
//       id
//       FROM tr_ba_main
//       order by created_at desc
//       LIMIT 1
//       ");

//       $twoChars = substr($user->username, 0, 3);

//       foreach($last_id2 as $asas2)
//       { $idnya2 = $asas2->id+1;}
//       $ambilkode2=Tr_Ba_Main_New::where($request->Tr_BA_Code)->get();
//       $nambah2=count($ambilkode2)+1;
//       if ($nambah2 <1000000)
//       {
//         $code_bas='BA'. '-'. $user->ms_divisi.'-'. date('Ydm').'-'."00".$idnya2;
//       }

//         return view('berita_acara.berita_acara_format_baru', compact('user', 'lokasi', 'employee', 'divisi', 'company', 'divisi','ms_kasus', 'code_bas', 'jenis', 'users'));
//     }

    public function add_prioritas_note(Request $request)
    {
      $user =  auth()->user()->username;
      $timestamp = Carbon::now()->timestamp;
      $tanggalSekarang = Carbon::now();
      $tahunSaatIni = $tanggalSekarang->year;
      $weeks = $tanggalSekarang->weekOfYear;
      do
        {
          $randomValue = mt_rand(100, 999);
          $autoNumber = 'Comment' . $weeks. $tahunSaatIni . $randomValue;
          $isUnique = !DB::table('Tr_BA_Comment')
              ->where('Tr_BA_Comment_Code', $autoNumber)
              ->exists();
        }
        while (!$isUnique);
        try {

            $status = $request->input('status');
            $kode_ba = $request->input('kode_ba');
            $note = $request->input('note');
            $prioritas = $request->input('prioritas');
            $jakartaTime = Carbon::now('Asia/Jakarta');
            // dd($kode_ba);
            $user =  auth()->user()->username;
            $user_updated = ", rec_userupdate = '${user}'";

            $lastno = DB::connection('mysql')->select("
            SELECT COUNT(1) as total FROM Tr_BA_Comment WHERE Tr_BA_Main_Code = ?
            ", [$kode_ba]);
            $no_record = $lastno[0]->total;
            $no_record_update = $no_record + 1;
            $ba_record_code = $kode_ba . '-' . $no_record_update;
            
            $data = DB::connection('mysql')->insert("
                INSERT INTO Tr_BA_Comment (
                    Tr_BA_Main_Code,
                    Tr_BA_Comment_Code,
                    Comment,
                    created_at,
                    Ms_User

                ) VALUES (
                    '$kode_ba',
                    '$autoNumber',
                    '$note',
                    '$jakartaTime',
                    '$user'
                )
            ");
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data successfully saved.', $data
            ]);
            // DB::rollBack();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
   
 public function index_berita_acara_all(Request $request)
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::all();
      $divisi = ms_divisi::all();
      $company = Ms_Company::all();
      $ms_kasus = Ms_Kasus::all();
      $users = DB::connection('mysql')->select("

      select   * from master_employees where emp_inactive ='1'  ORDER BY emp_name asc
      ");
      $jenis = DB::connection('mysql')->select("
      select * from ms_kasus_head where ms_type ='Berita Acara' and rec_status ='1' order by description asc
      ");
      $ms_kasus = DB::connection('mysql')->select("
      select * from ms_kasus where ms_kasus_head1 !='01' and rec_status ='1' order by description asc
      ");
      $last_id2 = DB::connection('mysql')->select("
      SELECT
      id
      FROM tr_ba_main
      order by created_at desc
      LIMIT 1
      ");

      $twoChars = substr($user->username, 0, 3);

      foreach($last_id2 as $asas2)
      { $idnya2 = $asas2->id+1;}
      $ambilkode2=Tr_Ba_Main_New::where($request->Tr_BA_Code)->get();
      $nambah2=count($ambilkode2)+1;
      if ($nambah2 <1000000)
      {
        $code_bas='BA'. '-'. $user->ms_divisi.'-'. date('Ydm').'-'."00".$idnya2;
      }
session()->flash('success', 'Form Masih Dalam Tahap Pengembangan. Silahkan Pilih Menu Kejadian-Temuan Untuk Isi Berita Acara');
        return view('berita_acara.berita_acara_format_baru', compact('user', 'lokasi', 'employee', 'divisi', 'company', 'divisi','ms_kasus', 'code_bas', 'jenis', 'users'));
    }

    public function store_berita_acara_all(Request $request)
    {

      $timestamp = Carbon::now()->timestamp;
      $tanggalSekarang = Carbon::now();
      $tahunSaatIni = $tanggalSekarang->year;
      $weeks = $tanggalSekarang->weekOfYear;
      // Tentukan rentang periode
      $startDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-01-01');
      $endDate1 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-03-31');
      $startDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-04-01');
      $endDate2 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-06-30');
      $startDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-07-01');
      $endDate3 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-09-31');
      $startDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-10-01');
      $endDate4 = Carbon::createFromFormat('Y-m-d', $tahunSaatIni.'-12-31');

     if(Carbon::now()->between($startDate1, $endDate1)){
      $periodeQ = 'Q1';
     };
     if(Carbon::now()->between($startDate2, $endDate2)){
      $periodeQ = 'Q2';
     };
     if(Carbon::now()->between($startDate3, $endDate3)){
      $periodeQ = 'Q3';
     };
     if(Carbon::now()->between($startDate4, $endDate4)){
      $periodeQ = 'Q4';
     };
     if(Carbon::now()){
      $periodeQ = 'Q4';
     };
      $period_H = $request->User_Code . '-' .$tahunSaatIni.$periodeQ;
      do
      {
        $randomValue = mt_rand(100, 999);
        // $autoNumber = 'BA' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
        $autoNumber = $request->User_Code . '-' . $request->Category_Code . $weeks. $tahunSaatIni . $randomValue;
        $isUnique = !DB::table('Tr_Ba_Main_New')
            ->where('Tr_BA_Main_Code', $autoNumber)
            ->exists();
      }
      while (!$isUnique);

      $main_ba_new = new Tr_Ba_Main_New();
      $main_ba_new->Tr_BA_Main_Code        = $autoNumber;
      $main_ba_new->Ms_BA_type_Code        = 'BA Kejadian';
      $main_ba_new->Ms_Emp_Code            = $request->User_Code;
      $main_ba_new->Ms_Emp_Div             = $request->Division_Code;
      $main_ba_new->Ms_Pelapor_Code        = $request->BA_Admin;
      $main_ba_new->Ms_Pelapor_Div         = $request->Admin_Div;
      $main_ba_new->Date_BA                = $request->Date_BA;
      $main_ba_new->BA_Desc                = $request->BA_Note;
      if($request->Category_Code == 'Pelanggaran SOP')
      {
        $main_ba_new->CekPelanggaran = 1;
      }
      else if($request->Category_Code != 'Pelanggaran SOP')
      {
        $main_ba_new->CekPelanggaran = 0;
      }
      if($request->Category_Code == 'Kerusakan')
      {
        $main_ba_new->CekKerusakan = 1;
      }
      else if($request->Category_Code != 'Kerusakan')
      {
        $main_ba_new->CekKerusakan = 0;
      }
      if($request->Category_Code == 'Kehilangan')
      {
        $main_ba_new->CekKehilangan = 1;
      }
      else if($request->Category_Code != 'Kehilangan')
      {
        $main_ba_new->CekKehilangan = 0;
      }
      if($request->Category_Code == 'Pembelian Barang')
      {
        $main_ba_new->CekPembelian = 1;
      }
      else if($request->Category_Code != 'Pembelian Barang')
      {
        $main_ba_new->CekPembelian = 0;
      }
      if($request->Category_Code == 'Perubahan SOP')
      {
        $main_ba_new->CekPerubahanSOP = 1;
      }
      else if($request->Category_Code != 'Perubahan SOP')
      {
        $main_ba_new->CekPerubahanSOP = 0;
      }
      $main_ba_new->CekFraud               = $request->ms_fraud;
      $main_ba_new->Ms_Kasus               = $request->jenis;
      $main_ba_new->Ms_Detail_Kasus        = $request->ms_kasus;
      $main_ba_new->Tr_EmpPeriod_Code      = $period_H;
      $main_ba_new->rec_usercreated        = Auth::User()->name;
      $main_ba_new->rec_datecreated        = Carbon::now();
      $main_ba_new->rec_comcode            = $request->Company_Code;
      $main_ba_new->rec_areacode           = $request->Location_Code;
      $main_ba_new->rec_status             = 1;
      $main_ba_new->save();

      $ba_kronologi = new Tr_BA_Kronologi();
      $ba_kronologi->tr_ba_kronologi_code = 'Kronologi' . '-' . Auth::user()->ms_divisi . $timestamp . $randomValue;
      $ba_kronologi->tr_ba_main_code = $main_ba_new->Tr_BA_Main_Code;
      $ba_kronologi->kronlogi = $request->kronlogi;
      $ba_kronologi->save();

      //poto 1
      $ba_doc = new BA_docs();
      $ba_doc->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

      if($request->file('file_path'))
      {
          $file= $request->file('file_path');
          $filename= date('YmdHi').$file->getClientOriginalName();
          $file-> move(public_path('upload'), $filename);
          $ba_doc->file_path = 'upload/' . $filename;
      }
      $ba_doc->save();

      //poto 2
      $ba_doc2 = new BA_docs2();
      $ba_doc2->ba_main_code = $main_ba_new->Tr_BA_Main_Code;

      if($request->file('file_path2'))
      {
          $file= $request->file('file_path2');
          $filename= date('YmdHi').$file->getClientOriginalName();
          $file-> move(public_path('upload'), $filename);
          $ba_doc2->file_path2 = 'upload/' . $filename;
      }
      // dd($ba_doc2);die;
      $ba_doc2->save();

      $main_ba_new = Tr_Ba_Main_New::where('Tr_BA_Main_Code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $dok1 = BA_docs::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $dok2 = BA_docs2::where('ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code )->first();
      $ba_kronologi = Tr_BA_Kronologi::where('tr_ba_main_code', '=', $main_ba_new->Tr_BA_Main_Code)->first();
      // dd($main_ba);die;
      $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s');
      // Setup a filename
        $documentFileName = $main_ba_new->Tr_BA_Main_Code.".pdf";
        // Create the mPDF document
        $document = new MPDF( [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_header' => '2',
            'margin_top'    => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);
        // Set some header informations for output
        $header = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
        ];
    $kronologi = "";
			if(isset($ba_kronologi->kronlogi) ){
				$kronologi = $ba_kronologi->kronlogi;
			}

      $fraud = '' ;
      if($main_ba_new->CekFraud == '1'){
         $fraud = 'Iya';
      }
      else{
          $fraud = 'Tidak';
      }
      $docsx1 = '';
      $docs1 = "upload/logohgs.jpg";
        if(!empty($dok1)){
            $docs1 = url('/'.$dok1->file_path);
            if($docs1 == url('/')){
                $docsx1 = '';
            }
            else{
                $docsx1 =  '<img width="250" height="130" src="'.$docs1.'">';
            }
        }
      $docsx2 = '';
      $docs2 = "upload/logohgs.jpg";
        if(!empty($dok2)){
            $docs2 = url('/'.$dok2->file_path2);
            if($docs2 == url('/')){
                $docsx2 = '';
            }
            else{
                $docsx2 = '<img width="250" height="130" src="'.$docs2.'">';
            }
        }

        // Write some simple Content
        $document->WriteHTML('
         <img width="90" height="50" src="'.url('/upload/logohgs.jpg').'" style="margin-bottom:-20px;">
                  <h3 style= "text-align: center;"><center>Berita Acara Kejadian</center></h3>
                  <hr/>
                  <br>
  <table style="width: 100%;">
  <thead>
    <tr>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
        <th style="width: 15%;"></th>
        <th style="width: 35%;"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Code</td><td>: '.$main_ba_new->Tr_BA_Main_Code.' </td>
      <td>Perusahaan</td><td>: '.$main_ba_new->rec_comcode.'</td>
    </tr>
    <tr>
      <td>Kategori</td><td>: '.$main_ba_new->Ms_BA_type_Code.'</td>
      <td>Kasus</td><td>: '.$main_ba_new->Ms_Kasus.'</td>
    </tr>
    <tr>
      <td>Tanggal BA</td><td>: '.date_format(date_create($main_ba_new->created_at),"d/m/Y").' </td>
      <td>Tanggal Peristiwa</td><td>: '.date_format(date_create($main_ba_new->Date_BA),"d/m/Y").' </td>
    </tr>
    <tr>
      <td>User Input</td><td>: '.$main_ba_new->Ms_Pelapor_Code.' </td>
      <td>Divisi yang Input</td><td>: '.$main_ba_new->Ms_Pelapor_Div.' </td>
    </tr>
    <tr>
      <td>Pelaku</td><td>: '.$main_ba_new->Ms_Emp_Code.' </td>
      <td>Divisi Pelaku</td><td> : '.$main_ba_new->Ms_Emp_Div.' </td>
    </tr>
    <tr>
      <td>Lokasi</td><td>: '.$main_ba_new->rec_areacode.'</td>
      <td >Detail Kasus</td><td>: '.$main_ba_new->MS_Detail_Kasus.'</td>
    </tr>
    <tr>
      <td><strong>Fraud ?</strong></td><td>:
        '.$fraud.'
      </td>
      <td></td><td></td>
    </tr>
    </tbody>
</table>
<br>
                      <h4>Kronologi:</h4>
                      <divid="outputText">
                        '.$kronologi.'
                      </div>
          <br>

                      <center>
                        <h3>
                           Dokumen
                         </h3>
                       </center>

                       <table class="table table-bordered mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                                <th style="width: 50%;">Dokumen Pendukung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                  <td>'.$docsx1.'
                                  </td>
                                  <td>'.$docsx2.'
                                  </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-bordered mt-4" style="width: 100%;">
                      <thead>
                          <tr>
                              <th style="width: 5%;"> No. </th>
                              <th style="width: 30%;">PIC</th>
                              <th style="width: 30%;">Divisi</th>
                              <th style="width: 20%;"></th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                <td>&nbsp; &nbsp; 1</td>
                                <td>'.$main_ba_new->Ms_Emp_Code.'</td>
                                <td>'.$main_ba_new->Ms_Emp_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 2</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Code.'</td>
                                <td>'.$main_ba_new->Ms_Pelapor_Div.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 3</td>
                                <td>Tri Hartati</td>
                                <td>Manager Finance</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 4</td>
                                <td>Dwi Arif W / Yesy Tjandra</td>
                                <td>Manager Operasional</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 5</td>
                                <td>Cliff Rogers </td>
                                <td>General Manager</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 6</td>
                                <td>Diana L</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 7</td>
                                <td>Charles W / Diana L</td>
                                <td>BOD</td>
                                <td>.......</td>
                              </tr>
                      </tbody>
                  </table>

                <div class="card-body">
          <br>
          <br>
          <table>
            <tr><td ><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td></tr>
          </table>
        ');

        // Save PDF on your public storage
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //
    }

    
}