<!DOCTYPE html>
<html lang="en">

  @extends('layouts/layoutMaster')

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
    <meta charset="UTF-8">
    <title>Panggil Kandidat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<style>

                      p {
                        border: 2px solid black;
                        margin: auto;
                        text-align: center;
                      }
                      p.garise
                      {
                          border-style: solid;
                          border-width: 1px;
                      }
                        .column {
                          float: left;
                          width: 50%;
                          padding: 10px;
                          height: 300px;
                        }
                        .row:after
                        {
                          content: "";
                          display: table;
                          clear: both;
                        }
                        table
                        {
                          width: 100%;
                        }
                        h5
                        {
                          text-align: center;

                        }
                        br
                        th
                        {
                          text-align: center;

                        }
                        img
                        {
                        display: -webkit-box;
                        margin-left: auto;
                        }
                        .summary-table {
                          border-spacing: 0;
                        }

                        .summary-table th,
                        .summary-table td {
                          border-bottom: 1px solid #EEEEEE; /* Grey 200 */

                          line-height: 1.5;
                          {{--  text-align: center;  --}}
                        }

  </style>



<body>
  <h5 >Detail Kandidat Belum Dipanggil</h5>
  {{--  <form  action="/tr_candidates/candidate_Call/{{$header['id']}}" method="post" enctype="multipart/form-data">  --}}
  <form action ="/tr_candidates/kandidat_belum_dihubungi/{{$header['id']}}" method ="post" enctype="multipart/form-data">
  {{ csrf_field() }}

  @if($poto == '')
   <img width="100" height="130" src="upload/nophoto.jpg">
  @else


<img width="100" height="130" src="{{ asset($poto->file_path) }}">
  @endif
  @if($cv == '')
   <img width="100" height="130" src="{{ asset('nodokumen.png') }}">
  @else
  <file  width="100" height="130" src="{{ asset($cv->file_cv) }}">
  @endif

<div>
  <input type="hidden" id="" name="CekCV" class="form-control" value="{{ $header->CekCV }}" >
</div>
            <table>
                <tr>
                    <td style=" font-weight: bold;">Nama                 </td>
                    <td>:                                               </td>
                    <td> {{$header['Name']}}                            </td>
                    <td style=" font-weight: bold;">No. HP               </td>
                    <td>:                                               </td>
                    <td> {{$header['Handphone']  }}                     </td>
                </tr>
                <tr>
                  <td style=" font-weight: bold;">NIK /KTP               </td>
                  <td>:                                                 </td>
                  <td> {{$header['Ktp']}}                               </td>
                  <td style=" font-weight: bold;">Email                  </td>
                  <td>:                                                 </td>
                  <td> {{$header['Email']  }}                           </td>
              </tr>
              <tr>
                <td style=" font-weight: bold;">Alamat                   </td>
                <td>:                                                   </td>
                <td> {{$header['domisili']}}                            </td>
                <td style=" font-weight: bold;">Gaji Yang Diharapkan     </td>
                <td>:                                                   </td>
                <td> {{$header['pengajuan_gaji']  }}                    </td>
            </tr>
            <tr>
              <td style=" font-weight: bold;">No. SIM             </td>
              <td>:                                                     </td>
              <td> {{$header['no_sim']}}                             </td>
              <td style=" font-weight: bold;">Type SIM       </td>
              <td>:                                                     </td>
              <td> {{$header['type_sim']  }}                      </td>
            </tr>
            <tr>
              <td style=" font-weight: bold;">Tempat Lahir               </td>
              <td>:                                                     </td>
              <td> {{$header['CityBirth']}}                             </td>
              <td style=" font-weight: bold;">Posisi Yang Dilamar Pertama       </td>
              <td>:                                                     </td>
              <td> {{$header['Position_aplly1']  }}                      </td>
            </tr>
            <tr>
              <td style=" font-weight: bold;">Tanggal Lahir              </td>
              <td>:                                                     </td>
              <td> {{ date_format(date_create($header->Birthdate),"d/m/Y") }} </td>
              <td style=" font-weight: bold;">Posisi Yang Dilamar Kedua            </td>
              <td>:                                                     </td>
              <td> {{$header['Position_aplly2']  }}                       </td>
            </tr>
            <tr>
              <td style=" font-weight: bold;">Status                      </td>
              <td>:                                                      </td>
              <td> {{$header['status']}}                                 </td>
              <td style=" font-weight: bold;">Ketersediaan Penempatan     </td>
              <td>:                                                      </td>
              <td> {{$header['ketersediaan']  }}                         </td>
            </tr>
            <tr>
              <td style=" font-weight: bold;">Jenis Kelamin                </td>
              <td>:                                                       </td>
              <td> {{$header['jenis_kelamin']}}                           </td>
              <td style=" font-weight: bold;">Tanggal Apply                </td>
              <td>:                                                       </td>
              <td> {{$header['created_at']  }}                               </td>
            </tr>
            <tr>
              <td style=" font-weight: bold;">Agama                        </td>
              <td>:                                                       </td>
              <td> {{$header['agama']}}                                   </td>
              <td style=" font-weight: bold;">Riwayat Penyakit    </td>
              <td>:   </td>
              <td>{{$header['riwayat_penyakit']}}    </td>
            </tr>
            <tr>
              <td style=" font-weight: bold;">Info Lowongan          </td>
              <td>:                                                     </td>
              <td> {{$header['info_lowongan']  }}                       </td>
            </tr>

  </table>

  <h5>1. PENDIDIKAN TERAKHIR</h5>
<table rules="all" border="1" >
  <tr>
    <th>Nama Sekolah / Universitas </th>
    <th>Tahun Masuk </th>
    <th>Tahun Lulus </th>
    <th>Alamat Sekolah  </th>
    <th>Nilai Rata-rata / IPK   </th>
  </tr>
  <tr>
    <td>{{   $pendidikan_det['sekolah'] }}  </td>
    <td>{{   $pendidikan_det['tahunmasuk']}} </td>
    <td>{{   $pendidikan_det['tahunlulus'] }}</td>
    <td>{{   $pendidikan_det['alamat']    }} </td>
    <td>{{   $pendidikan_det['ipk']      }} </td>
  </tr>
</table>
<br>
<br>
<h5>2. PEKERJAAN TERAKHIR</h5>

<table rules="all" border="1" >
  <tr>
    <th>Nama Perusahaan </th>
    <th>Posisi </th>
    <th>Lama Berkerja </th>
    <th>Gaji  </th>
    <th>No HP Perusahaan   </th>
    <th>Alasan Keluar   </th>
  </tr>
  <tr>
    <td>{{   $pengalaman_det['Perusahaan']  }}  </td>
    <td>{{   $pengalaman_det['Posisi']}} </td>
    <td>{{   $pengalaman_det['Lama_kerja'] }}</td>
    <td>{{   $pengalaman_det['Gaji']    }} </td>
    <td>{{   $pengalaman_det['No_hp']      }} </td>
    <td>{{   $pengalaman_det['alasan_keluar']      }} </td>
  </tr>
</table>
<br>
<br>
<h5>3. ORGANISASI</h5>

<table rules="all" border="1" >
  <tr>
    <th>Nama Organisasi </th>
    <th>Jabatan </th>
    <th>Periode </th>
  </tr>
  <tr>
    <td>{{   $organisasi_det['Nama_organisasi']  }}  </td>
    <td>{{   $organisasi_det['Jabatan']}} </td>
    <td>{{   $organisasi_det['Periode']    }} </td>
  </tr>
</table>
<br>
<br>
<h5>4. SKILL</h5>
<table rules="all" border="1" >
  <tr>
    <th>Skill </th>
    <th>Tingkat Skill </th>
    <th>Ketesediaan Tes? </th>
  </tr>
  <tr>
    <td>{{   $skill_det['Skill']  }}  </td>
    <td>{{   $skill_det['tingkat']}} </td>
    <td>{{   $skill_det['siap_tes']    }} </td>
  </tr>
</table>
<br>
<br>
<h5>5. SOSIAL MEDIA</h5>
<table rules="all" border="1" >
  <tr>
    <th>Sosial Media </th>
    <th>Nickname / id </th>
  </tr>
  <tr>
    <td>{{   $sosmed_det['sosmed']  }}  </td>
    <td>{{   $sosmed_det['nickname']}} </td>
  </tr>
</table>
<br>
<br>
<h5>6. RIWAYAT KELUARGA</h5>
<table rules="all" border="1" >
  <tr>
    <th>Hubungan </th>
    <th>Nama</th>
    <th>Pendidikan Terakhir</th>
    <th>Pekerjaan</th>
    <th>Tempat Berkerja</th>
  </tr>
  <tr>
    <td>{{   $keluarga['hubungan']  }}  </td>
    <td>{{   $keluarga['namanya']}} </td>
    <td>{{   $keluarga['pendidikan']}} </td>
    <td>{{   $keluarga['pekerjaan']}} </td>
    <td>{{   $keluarga['tempat']}} </td>
  </tr>
</table>
<br>
<br>

<table rules="all" border="1" >
  <tr>
    <th>Alasan, kenapa layak di panggil interview? </th>
  </tr>
  <tr>
    <td>{{   $header['layak']  }}  </td>
  </tr>

</table>
<br>
<br>
<br>
<div class="row g-3">
  <div class="col-12 col-md-6">
    <label for="" class="form-label">Apakah Kandidat Dapat Dihubungi ?</label>
      <select name = 'Cek_Sambung'class="form-control">
        <option value="Terhubung">Iya</option>
        <option value="Tidak Terhubung">Tidak</option>
      </select>
    </div>
  <div class="col-md-6">
    <label class="form-label" for="collapsible-phone">Note Call  </label>
    <input type="text" id="" name="alasan_sambung" class="form-control" required>
  </div>
  <div class="col-12 col-md-6">
    <label for="" class="form-label">Apakah Kandidat Bersedia Hadir ?</label>
      <select name = 'ketersediaan_hadir'class="form-control">
        <option value="2">Iya</option>
        <option value="0">Tidak</option>
      </select>
  </div>
  <div class="col-md-6">
    <label class="form-label" for="collapsible-phone">Tanggal Interview  </label>
    <input type="date" id="" name="jadwal_interview" class="form-control" required>
  </div>
  <div class="col-12 col-md-6">
    <label for="" class="form-label">Jam Interview</label>
        <input type="time" id="" name="Time_int" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label" for="collapsible-phone">Ruangan</label>
      <select name = 'Lokasi'class="form-control">
        <option value="Ruangan 1">Ruangan 1</option>
        <option value="Ruangan 2">Ruangan 2</option>
        <option value="Ruangan 3">Ruangan 3</option>
      </select>
  </div>
  <div class="col-md-6">
    <label class="form-label" for="collapsible-phone">Model Interview</label>
      <select name = 'Int_model'class="form-control">
        <option value="Online">Online</option>
        <option value="Offline">Offline</option>
      </select>
  </div>
  <div class="col-12 col-md-6">
    <label for="" class="form-label">PIC Interview</label>
        <input type="text" id="" name="Interviewer" class="form-control" required>
  </div>
</div>

    <br>
    <div class="mt-1">
      @if($header['CekCall'] == True)
                <button type="button" class="btn btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Already Called</button>
      @else
                <button class="btn btn-success" type="submit" name="sends" position-relative>Confirm</button>
      @endif
      {{--  <button class="btn btn-success" type="button"  ><a target="_blank" href="https://wa.me/{{preg_replace('/^0?/', '62', $header->Handphone)}}?text=Halo%20nama%20saya%20nadine">Call WA</a></button>  --}}
      {{--  <button class="btn btn-success" type="button"  ><a target="_blank" href="https://wa.me/{{preg_replace('/^0?/', '62', $header->Handphone)}}?text=Halo%20nama%20saya%20nadine">Schedule</a></button>  --}}
      <button type="button" id="addNewBook" class="btn btn-success">Schedule</button>
    </div>

    <!-- boostrap model -->
    <div class="modal fade" id="ajax-book-model" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxBookModel"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST">
              <input type="hidden" name="id" id="id">

              <table class="summary-table">
                <thead>
                  <tr>
                    <th scope="col">PIC</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jam</th>
                    <th scope="col">Ruangan</th>
                    <th scope="col">Kandidat</th>
                    {{--  <th scope="col">Model</th>  --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach ($jadwals as $tipe)
                  <tr>
                      <td>{{ $tipe->Interviewer}}</td>
                      <td>{{ date_format(date_create($tipe->Date_int),"d/m/Y") }}
                      <td>{{ $tipe->Time_int}}</td>
                      <td>{{ $tipe->Lokasi}}</td>
                      <td>{{ $tipe->Ms_Candidate_Code}}</td>
                      {{--  <td>{{ $tipe->Int_model}}</td>  --}}
                  </tr>
                  @endforeach
                </tbody>
                {{--  <tfoot>
                  <tr>
                      <th>No. Pol</th>
                      <th>No. KIR</th>
                      <th>Pemilik</th>
                      <th>Jenis</th>
                      <th>Masa Berlaku</th>
                      <th>Lokasi</th>
                  </tr>
              </tfoot>  --}}
              </table>


            </form>
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->
<script type="text/javascript">
 $(document).ready(function($){

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Schedule Interview");
       $('#ajax-book-model').modal('show');
    });

    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-branch') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Branch");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#branch_code').val(res.branch_code);
              $('#description').val(res.description);
              $('user_created').val(res.user_created);
           }
        });
    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-branch') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){

              window.location.reload();
           }
        });
       }

    });

    $('body').on('click', '#btn-save', function (event) {

          var id = $("#id").val();
          var branch_code   = $("#branch_code").val();
          var description = $("#description").val();
          var user_created = $("#user_created").val();

          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-branch') }}",
            data: {
              id:id,
              branch_code:branch_code,
              description:description,
              user_created:user_created,
            },
            dataType: 'json',
            success: function(res){
             window.location.reload();
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
           }
        });

    });

});
</script>


  </body>
</html>

@endsection

