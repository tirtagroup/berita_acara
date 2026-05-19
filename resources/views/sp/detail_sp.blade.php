<html>

  @section('title', ' Horizontal Layouts - Forms')

  @section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

  @endsection

  @section('vendor-script')
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

  @endsection

  @section('page-script')
  <script src="{{asset('assets/js/form-layouts.js')}}"></script>
  <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

  @endsection


  @section('content')
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
    <title>
        Action BA
      </title>
    </head>


@section('content')

<body>
  <img width="90" height="50" src="{{ asset('upload/logohgs.jpg')  }}">
</body>    <br>
            <center>
              <h2 style="padding-left:10px;">PT. Handal Guna Sarana</h2>
            </center>
            <center>
              <p >Jl. Arteri Permat Hijau, Grand ITC Permata Hijau Blok Saphire No. 19, RT.7/RW.10, Grogol Utara, Kec. Kby. Lama, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12210</p>
            <center>
                      <p class="garise"></p>

                      @foreach($code_main as $row)
                      @endforeach
                      <body>
                        <table>
                          <tr>
                            <td style="padding-left:10px; font-size 100px">Nomor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $row->sp_main_code }} </td>
                          </tr>
                          <tr>
                            <td style="padding-left:10px;">Lampiran &nbsp;&nbsp;&nbsp;&nbsp;: 1 (satu) berkas</td>
                          </tr>
                          <tr>
                            <td style="padding-left:10px;">Perihal &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $row->sp_type }}</td>
                          </tr>
                          <tr>
                            <td style="padding-left:10px;">Kepada Yth.</td>
                          </tr>
                          <tr>
                            <td style="padding-left:10px;">Sdr. {{ $row->sp_employee }}</td>
                          </tr>
                          <tr>
                            <td style="padding-left:10px;">{{ $row->sp_divisi }}</td>
                          </tr>
                      </table>
                      <br>
                      @if($row->sp_type == 'Panggil Mentoring')
                      <p class="left" style="padding-left:10px;">
                      Sehubungan dengan datangnya surat ini, kami mengundang Sdr. {{ $row->sp_employee }}, untuk menjelaskan beberapa kasus berita acara yang bersangkutan dengan Sdr. {{ $row->sp_employee }}, PT. Handal Guna Sarana memberikan catatan sebagai berikut :
                      </p>
                      @elseif($row->sp_type == 'Surat Peringatan 1')
                      <p class="left" style="padding-left:10px;">
                        Sehubungan dengan kinerja Sdr. {{ $row->sp_employee }} yang dianggap telah melanggar surat perjanjian kerja yang telah disepakati sebelumnya, PT. Handal Guna Sarana memberikan peringatan kepada Sdr. {{ $row->sp_employee }} atas tindakan yang perlu di perbaiki, yaitu sebagai berikut :
                      </p>
                      @else
                      <p class="left" style="padding-left:10px;">
                        Sehubungan dengan kinerja Sdr. {{ $row->sp_employee }} yang dianggap telah melanggar surat perjanjian kerja yang telah disepakati sebelumnya, PT. Handal Guna Sarana memutuskan untuk menghentikan hubungan kerja dengan Sdr. {{ $row->sp_employee }} atas tindakan yang merugikan perusahaan, yaitu sebagai berikut :
                      </p>
                      @endif

                      <div class="card-body">
                        <table>
                            <thead>
                                <tr>
                                  <tr>
                                    <th style="width:1px"></th>
                                    <th ></th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $no=1;?>
                                @foreach($detail as $rows)
                                  <tr>
                                    <td scope="row">{{ $no }}</td>
                                    <td>. {{$rows->sp_note }}</td>
                                  </tr>
                                  <?php $no++ ;?>
                                @endforeach
                            </tbody>
                        </table>
                      </div>
            <br>
            {{--  <p class="left" style="padding-left:10px;">
                Oleh karena itu, surat peringatan pertama ini diberikan dengan tujuan sebagai teguran kepada Sdr. {{ $row->sp_employee }} agar dapat melaksanakan tata tertib sesuai sistem kerja yang telah berlaku. Adapun masa berlakunya surat peringatan ini akan berakhir pada 30 September 2023.
            </p>  --}}
            <p class="left" style="padding-left:10px;">
              Demikian surat ini dibuat agar dilaksanakan dan dipatuhi oleh anda.
            </p>
            <p class="left" style="padding-left:10px;">
              Tertanda,
            </p>
              <p class="left" style="padding-left:10px;">
              <span>{{ $row->ms_lokasi }}, <p="tanggalContainer">{{ date('d F Y', strtotime($row->rec_datecreated)) }}</p></span>
              </p>
            <p class="left" style="padding-left:10px;">
              PT. Handal Guna Sarana
            </p>
            <p class="left" style="padding-left:10px;">
              HRD Manager
            </p>

            <br>
            <br>
            <br>
          <table>
            <th>
              <p>Print Date : <span id="datetime"></span></p><script>var dt = new Date();
                document.getElementById("datetime").innerHTML=dt.toLocaleString();</script>
            </th>
          </table>

        </div>
    </div>

      <style>
      table, th, td
      {
          border: 0px solid black;
      }

      table
      {
              width: 100%;
      }
      p.garise
      {
              border-style: solid;
              border-width: 1px;

      }
       th, textarea,thead, tbody
      {
       font-size: 30px;
      }
      td
      {
        font-size: 20px;
       }
       p
      {
        font-size: 20px;
       }
      tab
      {
        display: inline-block;
          margin-left: 20px;
      }
      </style>

      <style type="text/css">
        .left    { text-align: left;}
        .right   { text-align: right;}
        .center  { text-align: center;}
        .justify { text-align: justify;}
     </style>

     <script>
      // Mendapatkan tanggal dari server (contoh format: '2023-12-05 06:27:34')
      var tanggalDariServer = "{{ $row->rec_datecreated }}";

      // Membuat objek Date dari string tanggal
      var tanggalObj = new Date(tanggalDariServer);

      // Array nama bulan
      var namaBulan = [
          'Januari', 'Februari', 'Maret', 'April',
          'Mei', 'Juni', 'Juli', 'Agustus',
          'September', 'Oktober', 'November', 'Desember'
      ];

      // Mendapatkan informasi tanggal, bulan, dan tahun
      var tanggal = tanggalObj.getDate();
      var bulan = namaBulan[tanggalObj.getMonth()];
      var tahun = tanggalObj.getFullYear();

      // Menampilkan hasil dalam elemen dengan id "tanggalContainer"
      var container = document.getElementById('tanggalContainer');
      container.innerHTML = tanggal + ' ' + bulan + ' ' + tahun;
  </script>


      <div>
        <p><button onclick="window.print()" type="button" class="btn btn-default btn-sm">
        </button>
        </p>
      </div>


</body>
    </html>



















