<?php

namespace App\Http\Controllers;

use App\Models\Ms_Company;
use App\Models\MsLocation;
use App\Models\Tr_PICA_Emp_h;
use App\Models\Tr_PICA_Pertanyaan;
use App\Models\Tr_PICA_Preventive_Action;
use App\Models\Tr_Pica_Emp_D;
use App\Models\Tr_PICA_Action;
use App\Models\ms_divisi;
use App\Models\MasterEmployee;
use App\Models\Tr_BA_Main_New;
use App\Models\Tr_PICA_Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Carbon\Carbon;
use PDF;
use \Mpdf\Mpdf as MPDF;

class Tr_PICA_Controller extends Controller
{
    public function get_form_pika ()
    {
      $user = auth()->user();
      $lokasi = MsLocation::all();
      $employee = MasterEmployee::where('emp_inactive', '1')->get();
      $divisi = ms_divisi::all();
      $company = Ms_Company::all();
      $tr_ba = DB::connection('mysql')->select("
      select * from Tr_Ba_Main_New
      where rec_status ='1'
      and (CekFraud ='1' or CekSalahIsi ='1' or CekLaka ='1' or CekPelanggaran ='1' or CekRevisi ='1')
      ");
      // dd($tr_ba);
      return view ('pika.create_pika', compact('user', 'lokasi', 'company', 'tr_ba', 'employee') );
    }

    public function store_pica (Request $request)
    {

      $tanggalSekarang = Carbon::now();
      $ambiltanggal = Carbon::now()->format('dmY');
      $tahunSaatIni = $tanggalSekarang->year;
      $weeks = $tanggalSekarang->weekOfYear;
      $bulan = $tanggalSekarang->weekOfMonth;

      $counter = 1;
      do {
          $randomValue = str_pad($counter, 4, '0', STR_PAD_LEFT);
          $autoNumber = 'PICAH' . '-' . Auth::user()->username . $ambiltanggal . '-' . $randomValue;
          $isUnique = !DB::table('Tr_PICA_Emp_h')
              ->where('Tr_Pica_Emp_h_Code', $autoNumber)
              ->exists();
          $counter++;

          if ($counter > 9999) { // Mencegah infinite loop
              throw new \Exception("Gagal membuat kode unik PICAH");
          }
      } while (!$isUnique);

      $pica_heads = new Tr_PICA_Emp_h();
      $pica_heads->Ms_Company                     = $request->Company_Code;
      $pica_heads->Ms_Location                    = $request->Location_Code;
      $pica_heads->User_Created                   = Auth::User()->username;
      $pica_heads->Status_PICA                    = 'Belum Closing';
      $pica_heads->Tr_Pica_Emp_h_Code             = $autoNumber;
      $pica_heads->Emp_Code                       = $request->siapa_salah;
      $pica_heads->Date_PICA                      = Carbon::now();
      $pica_heads->SPV_Approval                   = '';
      $pica_heads->Kapan_Terjadi                  = $request->kapan_terjadi;
      $pica_heads->NoBA                           = $request->no_ba;
      $pica_heads->Apakah_Sudah_Pernah_Kejadian   = $request->pernah_kejadian;
      $pica_heads->Problem_Note                   = $request->problem_note;
      $pica_heads->save();

      foreach($request['pertanyaan'] as $key => $item_id)
      {
        $counter = 1;
          do {
              $randomValue3 = str_pad($counter, 4, '0', STR_PAD_LEFT);
              $autoNumber3 = 'ASK' . '-' . $ambiltanggal . '-' . $randomValue3;
              $isUnique = !DB::table('Tr_PICA_Pertanyaan')->where('Tr_PICA_Pertanyaan_Code', $autoNumber3)->exists(); // Perbaiki pengecekan
              $counter++;

              if ($counter > 9999) { // Mencegah infinite loop
                  throw new \Exception("Gagal membuat kode unik ASK");
              }
          } while (!$isUnique);


          $pica_dets = new Tr_PICA_Pertanyaan();
          $pica_dets->Tr_PICA_Pertanyaan_Code       = $autoNumber3;
          $pica_dets->Tr_Pica_emp_h_Code            = $autoNumber;
          $pica_dets->Tr_Pertanyaan                 = $request['pertanyaan'][$key];
          $pica_dets->Tr_Jawaban                    = $request['jawaban'][$key];
          $pica_dets->save();
      }

      foreach($request['actions'] as $key => $item_id)
      {
        $counter = 1;
          do {
              $randomValue4 = str_pad($counter, 4, '0', STR_PAD_LEFT);
              $autoNumber4 = 'Action' . '-' . $ambiltanggal . '-' . $randomValue4;
              $isUnique = !DB::table('Tr_PICA_Action')->where('Tr_Pica_Action_Code', $autoNumber4)->exists(); // Perbaiki pengecekan
              $counter++;

              if ($counter > 9999) { // Mencegah infinite loop
                  throw new \Exception("Gagal membuat kode unik Action");
              }
          } while (!$isUnique);


          $pica_dets = new Tr_PICA_Action();
          $pica_dets->Tr_Pica_Action_Code           = $autoNumber4;
          $pica_dets->Tr_Pica_emp_h_Code            = $autoNumber;
          $pica_dets->ApaYangAkanDilakukan          = $request['actions'][$key];
          $pica_dets->Kapan                         = $request['kapan_dilakukan'][$key];
          $pica_dets->save();

      }

      foreach($request['koreksi'] as $key => $item_id)
      {
        $counter = 1;
          do {
              $randomValue5 = str_pad($counter, 4, '0', STR_PAD_LEFT);
              $autoNumber5 = 'Preventive' . '-' . $ambiltanggal . '-' . $randomValue5;
              $isUnique = !DB::table('Tr_PICA_Preventive_Action')->where('Tr_PICA_Preventive_Action_Code', $autoNumber5)->exists(); // Perbaiki pengecekan
              $counter++;

              if ($counter > 9999) { // Mencegah infinite loop
                  throw new \Exception("Gagal membuat kode unik Preventive");
              }
          } while (!$isUnique);


          $pica_dets = new Tr_PICA_Preventive_Action ();
          $pica_dets->Tr_PICA_Preventive_Action_Code= $autoNumber5;
          $pica_dets->Tr_Pica_emp_h_Code            = $autoNumber;
          $pica_dets->Tr_Preventive                 = $request['koreksi'][$key];
          $pica_dets->save();
      }

      $code_h = Tr_PICA_Emp_h::where('Tr_Pica_Emp_h_Code', '=', $autoNumber )->first();
      $pertanyaan = Tr_PICA_Pertanyaan::where('Tr_Pica_emp_h_Code', '=', $autoNumber)->get();
      $action = Tr_PICA_Action::where('Tr_Pica_emp_h_Code', '=', $autoNumber)->get();
      $preventive = Tr_PICA_Preventive_Action::where('Tr_Pica_emp_h_Code', '=', $autoNumber)->get();
      // dd($code_d);
        $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s');
        $documentFileName = $pica_heads->Tr_Pica_Emp_h_Code.".pdf";
        // Create the mPDF document
        $document = new MPDF([
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

         // Write some simple Content
    $no = 1;
    $detailss = "";
    foreach ($pertanyaan as $row) {
        $detailss .= '
            <tr>
                <td style="text-align: center;">'.$no.'</td>
                <td style="text-align: center;">'.$row->Tr_Pertanyaan.'</td>
                <td style="text-align: center;">'.$row->Tr_Jawaban.'</td>
            </tr>';
            $no++;
        }

    $no = 1;
    $detailss2 = "";
    foreach ($action as $row) {
        $detailss2 .= '
            <tr>
                <td style="text-align: center;">'.$no.'</td>
                <td style="text-align: center;">'.$row->ApaYangAkanDilakukan.'</td>
                <td style="text-align: center;">'.date_format(date_create($code_h->Kapan),"d/m/Y").'</td>
            </tr>';
            $no++;
        }

    $no = 1;
    $detailss3 = "";
        foreach ($preventive as $row) {
            $detailss3 .= '
                <tr>
                    <td style="text-align: center;">'.$no.'</td>
                    <td style="text-align: center;">'.$row->Tr_Preventive.'</td>
                </tr>';
                $no++;
            }

        // Perbarui dokumen PDF
        $document->WriteHTML('
            <style>
                .special-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 8px;
                }
                .special-table th, .special-table td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                }
            </style>
            <div style="display: grid; grid-template-columns: 1fr 4fr 1fr; gap: 20px; align-items: center; width: 100%; margin-bottom: 0px;">
              <!-- Gambar di kolom pertama -->
              <div style="display: flex; align-items: center;">
                  <img width="90" height="50" src="https://i.imgur.com/MHpXScU.jpeg" style="margin-right: 20px;">
                  <div style="text-align: center;">
                      <h3 style="margin: 0;"> PICA (Problem Identification, Corrective Action & Preventive Action) </h3>
                  </div>
              </div>

              <!-- Teks di kolom ketiga -->
              <div style="text-align: center;">
              </div>
            </div>
            <hr/>
            <br>
            <table style="width: 100%;">
                <thead></thead>
                <tbody>
                    <tr>
                        <td style="font-size: 9px;">Nomor PICA</td><td style="font-size: 9px;">: '.$code_h->Tr_Pica_Emp_h_Code.' </td>
                        <td style="font-size: 9px;">Company</td><td style="font-size: 9px;">: '.$code_h->Ms_Company.' </td>
                        <td style="font-size: 9px;">Lokasi</td><td style="font-size: 9px;">: '.$code_h->Ms_Location.' </td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px;">Operator</td><td style="font-size: 9px;">: '.$code_h->User_Created.' </td>
                        <td style="font-size: 9px;">Date PICA</td><td style="font-size: 9px;">: '.date_format(date_create($code_h->Date_PICA),"d/m/Y").' </td>
                        <td style="font-size: 9px;">Kejadian Ke-Berapa?</td><td style="font-size: 9px;">: '.$code_h->Apakah_Sudah_Pernah_Kejadian.'</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px;">Status</td><td style="font-size: 9px;">: '.$code_h->Status_PICA.'</td>
                        <td style="font-size: 9px;">Kapan Terjadi</td><td style="font-size: 9px;">: '.date_format(date_create($code_h->Kapan_Terjadi),"d/m/Y").' </td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px;">Problem / Note</td><td style="font-size: 9px;">: '.$code_h->Problem_Note.'</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 100%;">
            <thead></thead>
            <tbody>
                <tr><td colspan="6"><strong>1. Problem Identification</strong></td></tr>
                <table class="special-table" style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$detailss.'
                    </tbody>
                </table>
            </tbody>
        </table>

        <table style="width: 100%;">
            <thead></thead>
            <tbody>
                <tr><td colspan="2"><strong>2. Corrective Action</strong></td></tr>
                <table class="special-table" style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Langkah-Langkah Koreksi</th>
                            <th>Kapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$detailss2.'
                    </tbody>
                </table>
            </tbody>
        </table>

        <table style="width: 100%;">
            <thead></thead>
            <tbody>
                <tr><td colspan="2"><strong>3. Preventive Action</strong></td></tr>
                <table class="special-table" style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Langkah-Langkah Pencegahan </th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$detailss3.'
                    </tbody>
                </table>
            </tbody>
        </table>

            <div class="card-body">
                <br>
                  <table class="table table-bordered mt-4" style="width: 100%;">
                      <thead>
                          <tr>
                              <th style="width: 5%;"> No. </th>
                              <th style="width: 30%;">PIC</th>
                              <th style="width: 20%;"></th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                <td>&nbsp; &nbsp; 1</td>
                                <td>'.$code_h->Emp_Code.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 2</td>
                                <td>Tri Hartati</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 3</td>
                                <td>Dwi Arif W</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 4</td>
                                <td>Cliff Rogers </td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 5</td>
                                <td>Alde Gonda</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 6</td>
                                <td>Charles W</td>
                                <td>.......</td>
                              </tr>
                      </tbody>
                  </table>
                <br>
                <table>
                    <tr>
                        <td><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td>
                    </tr>
                </table>
            ');

        // Simpan dan unduh file PDF
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, 'S'));
        return Storage::disk('public')->download($documentFileName, 'Request', $header);
    }

    public function get_dashboard_pika()
    {
      $user = auth()->user();

      $report = DB::connection('mysql')->select("
        select
        if(ket is null, 'belum dilihat',ket) ket,
        header.created_at,
        header.Status_PICA,
        header.Kapan_Terjadi,
        header.Tr_Pica_Emp_h_Code,
        header.Emp_Code,
        header.Problem_Note
        from
        Tr_PICA_Emp_h header
        left join
        (
          SELECT
          Tr_PICA_Emp_h_Code,
          count(0), 'sudah dilihat' ket
          from Tr_PICA_Comment
          WHERE Ms_User = '$user->username'
          GROUP BY Tr_PICA_Emp_h_Code
        ) d on header.Tr_Pica_Emp_h_Code = d.Tr_PICA_Emp_h_Code
          where  DATE(header.created_at) = CURRENT_DATE;
      ");
      // dd($report);
      return view ('pika.dashboard_pika', compact('report'));
    }
    public function detail_check_pica(Request $request, $id)
    {
      // dd($id);
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
        $isUnique = !DB::table('Tr_PICA_Comment')
            ->where('Tr_PICA_Comment_Code', $autoNumber)
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
          SELECT COUNT(1) as total FROM Tr_PICA_Comment WHERE Tr_PICA_Emp_h_Code = ? and Ms_User = ?
          ", [$kode_ba, $user]);
          $no_record = $lastno[0]->total;
          // dd($no_record, $user, $kode_ba);

          $lastno2 = DB::connection('mysql')->select("
          SELECT COUNT(1) as total FROM Tr_PICA_Comment WHERE Tr_PICA_Emp_h_Code = ?
          ", [$kode_ba]);
          $no_record2 = $lastno2[0]->total;
          if($no_record == 0){
              $data = DB::connection('mysql')->insert("
                  INSERT INTO Tr_PICA_Comment (
                      Tr_PICA_Emp_h_Code,
                      Tr_PICA_Comment_Code,
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
            $main_pica = Tr_PICA_Emp_h::where('Tr_PICA_Emp_h_Code', '=', $id)->first();
            $pertanyaan = DB::connection('mysql')->select("
            SELECT
            *
            from Tr_PICA_Pertanyaan
            where Tr_PICA_Emp_h_Code ='$id'
            ");
            $action = DB::connection('mysql')->select("
            SELECT
            *
            FROM Tr_PICA_Action
            where Tr_PICA_Emp_h_Code ='$id'
            ");
            $preventive = DB::connection('mysql')->select("
            SELECT
            *
            FROM Tr_PICA_Preventive_Action
            where Tr_PICA_Emp_h_Code ='$id'
            ");
            // $action = Tr_PICA_Action::where('Tr_Pica_emp_h_Code', '=', $id)->get();
            // dd($detail);
            return view('pika.detail_check_pica', compact('user','main_pica', 'pertanyaan', 'action', 'preventive'));
      }
    }
    public function priority_note(Request $request)
    {
      $code = $request->input('code');
      // dd($code);
          $data = DB::connection('mysql')->select("
              SELECT *
              FROM Tr_PICA_Comment
              WHERE Tr_PICA_Emp_h_Code = ?
              order by created_at desc
          ", [$code]);

          return response()->json($data);
    }
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
          $isUnique = !DB::table('Tr_PICA_Comment')
              ->where('Tr_PICA_Comment_Code', $autoNumber)
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
            SELECT COUNT(1) as total FROM Tr_PICA_Comment WHERE Tr_PICA_Emp_h_Code = ?
            ", [$kode_ba]);
            $no_record = $lastno[0]->total;
            $no_record_update = $no_record + 1;
            $ba_record_code = $kode_ba . '-' . $no_record_update;

            $data = DB::connection('mysql')->insert("
                INSERT INTO Tr_PICA_Comment (
                    Tr_PICA_Emp_h_Code,
                    Tr_PICA_Comment_Code,
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
    public function search_pica (Request $request)
    {
      $tgl_awal       = $request->tgl_awal;
      $tgl_akhir      = $request->tgl_akhir;
      $user = auth()->user();

      $report = DB::connection('mysql')->select("
        select
        if(ket is null, 'belum dilihat',ket) ket,
        header.created_at,
        header.Status_PICA,
        header.Kapan_Terjadi,
        header.Tr_Pica_Emp_h_Code,
        header.Emp_Code,
        header.Problem_Note
        from
        Tr_PICA_Emp_h header
        left join
        (
          SELECT
          Tr_PICA_Emp_h_Code,
          count(0), 'sudah dilihat' ket
          from Tr_PICA_Comment
          WHERE Ms_User = '$user->username'
          GROUP BY Tr_PICA_Emp_h_Code
        ) d on header.Tr_Pica_Emp_h_Code = d.Tr_PICA_Emp_h_Code
          where date(header.created_at) >= '$tgl_awal'
          and date(header.created_at) <= '$tgl_akhir'
      ");

      return view ('pika.dashboard_pika', compact('report','tgl_awal', 'tgl_akhir'));
    }

    public function reprint_pica (Request $request, $id)
    {
      $code_h = Tr_PICA_Emp_h::where('Tr_Pica_Emp_h_Code', '=', $id )->first();
      $pertanyaan = Tr_PICA_Pertanyaan::where('Tr_Pica_emp_h_Code', '=', $id)->get();
      $action = Tr_PICA_Action::where('Tr_Pica_emp_h_Code', '=', $id)->get();
      $preventive = Tr_PICA_Preventive_Action::where('Tr_Pica_emp_h_Code', '=', $id)->get();
      // dd($code_d);
        $datetime       = Carbon::now()->setTimezone("Asia/Jakarta")->format('Y-m-d H:i:s');
        $documentFileName = $id.".pdf";
        // Create the mPDF document
        $document = new MPDF([
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

         // Write some simple Content
    $no = 1;
    $detailss = "";
    foreach ($pertanyaan as $row) {
        $detailss .= '
            <tr>
                <td style="text-align: center;">'.$no.'</td>
                <td style="text-align: center;">'.$row->Tr_Pertanyaan.'</td>
                <td style="text-align: center;">'.$row->Tr_Jawaban.'</td>
            </tr>';
            $no++;
        }

    $no = 1;
    $detailss2 = "";
    foreach ($action as $row) {
        $detailss2 .= '
            <tr>
                <td style="text-align: center;">'.$no.'</td>
                <td style="text-align: center;">'.$row->ApaYangAkanDilakukan.'</td>
                <td style="text-align: center;">'.date_format(date_create($code_h->Kapan),"d/m/Y").'</td>
            </tr>';
            $no++;
        }

    $no = 1;
    $detailss3 = "";
        foreach ($preventive as $row) {
            $detailss3 .= '
                <tr>
                    <td style="text-align: center;">'.$no.'</td>
                    <td style="text-align: center;">'.$row->Tr_Preventive.'</td>
                </tr>';
                $no++;
            }

        // Perbarui dokumen PDF
        $document->WriteHTML('
            <style>
                .special-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 8px;
                }
                .special-table th, .special-table td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                }
            </style>
            <div style="display: grid; grid-template-columns: 1fr 4fr 1fr; gap: 20px; align-items: center; width: 100%; margin-bottom: 0px;">
              <!-- Gambar di kolom pertama -->
              <div style="display: flex; align-items: center;">
                  <img width="90" height="50" src="https://i.imgur.com/MHpXScU.jpeg" style="margin-right: 20px;">
                  <div style="text-align: center;">
                      <h3 style="margin: 0;"> PICA (Problem Identification, Corrective Action & Preventive Action) </h3>
                  </div>
              </div>

              <!-- Teks di kolom ketiga -->
              <div style="text-align: center;">
              </div>
            </div>
            <hr/>
            <br>
            <table style="width: 100%;">
                <thead></thead>
                <tbody>
                    <tr>
                        <td style="font-size: 9px;">Nomor PICA</td><td style="font-size: 9px;">: '.$code_h->Tr_Pica_Emp_h_Code.' </td>
                        <td style="font-size: 9px;">Company</td><td style="font-size: 9px;">: '.$code_h->Ms_Company.' </td>
                        <td style="font-size: 9px;">Lokasi</td><td style="font-size: 9px;">: '.$code_h->Ms_Location.' </td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px;">Operator</td><td style="font-size: 9px;">: '.$code_h->User_Created.' </td>
                        <td style="font-size: 9px;">Date PICA</td><td style="font-size: 9px;">: '.date_format(date_create($code_h->Date_PICA),"d/m/Y").' </td>
                        <td style="font-size: 9px;">Kejadian Ke-Berapa?</td><td style="font-size: 9px;">: '.$code_h->Apakah_Sudah_Pernah_Kejadian.'</td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px;">Status</td><td style="font-size: 9px;">: '.$code_h->Status_PICA.'</td>
                        <td style="font-size: 9px;">Kapan Terjadi</td><td style="font-size: 9px;">: '.date_format(date_create($code_h->Kapan_Terjadi),"d/m/Y").' </td>
                    </tr>
                    <tr>
                        <td style="font-size: 9px;">Problem / Note</td><td style="font-size: 9px;">: '.$code_h->Problem_Note.'</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table style="width: 100%;">
            <thead></thead>
            <tbody>
                <tr><td colspan="6"><strong>1. Problem Identification</strong></td></tr>
                <table class="special-table" style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$detailss.'
                    </tbody>
                </table>
            </tbody>
        </table>

        <table style="width: 100%;">
            <thead></thead>
            <tbody>
                <tr><td colspan="2"><strong>2. Corrective Action</strong></td></tr>
                <table class="special-table" style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Langkah-Langkah Koreksi</th>
                            <th>Kapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$detailss2.'
                    </tbody>
                </table>
            </tbody>
        </table>

        <table style="width: 100%;">
            <thead></thead>
            <tbody>
                <tr><td colspan="2"><strong>3. Preventive Action</strong></td></tr>
                <table class="special-table" style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Langkah-Langkah Pencegahan </th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$detailss3.'
                    </tbody>
                </table>
            </tbody>
        </table>

            <div class="card-body">
                <br>
                  <table class="table table-bordered mt-4" style="width: 100%;">
                      <thead>
                          <tr>
                              <th style="width: 5%;"> No. </th>
                              <th style="width: 30%;">PIC</th>
                              <th style="width: 20%;"></th>
                          </tr>
                      </thead>
                      <tbody>
                              <tr>
                                <td>&nbsp; &nbsp; 1</td>
                                <td>'.$code_h->Emp_Code.'</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 2</td>
                                <td>Tri Hartati</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 3</td>
                                <td>Dwi Arif W</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 4</td>
                                <td>Cliff Rogers </td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 5</td>
                                <td>Alde Gonda</td>
                                <td>.......</td>
                              </tr>
                              <tr>
                                <td>&nbsp; &nbsp; 6</td>
                                <td>Charles W</td>
                                <td>.......</td>
                              </tr>
                      </tbody>
                  </table>
                <br>
                <table>
                    <tr>
                        <td><p><b>Print Date : <span>'.$datetime.'</span></b></p> </td>
                    </tr>
                </table>
            ');

        // Simpan dan unduh file PDF
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, 'S'));
        return Storage::disk('public')->download($documentFileName, 'Request', $header);
    }
}
