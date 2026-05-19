<html>
@extends('layouts/contentNavbarLayout')

@section('content')
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
                        body
                        {

                        }
                        fieldset
                        {

                        }
                        br
                        {

                        }
                        h1
                        {

                        }
                        h2
                        {

                        }
                        h4
                        {

                        }
                        div
                        {

                        }
                        table
                        {

                        }
                        p
                        {

                        }
                        th
                        {
                          text-align: center;

                        }
                        img
                        {
                        display: -webkit-box;
                        margin-left: auto;
                        }

  </style>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

<body>
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



  <h5 >FORMULIR KANDIDAT BELUM INTERVIEW KETIGA</h5>
  {{--  <form  action="/tr_candidates/Shortlist/{{$header['id']}}" method="post" enctype="multipart/form-data">  --}}
    <form  action="/tr_candidates/candidate_interview3/{{$header['id']}}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
            <table>

            </table>
            <br>
            {{--  <h5 >DETAIL KANDIDAT BELUM INTERVIEW</h5>  --}}
            <table>


                <tr>
                  <td style=" font-weight: bold;">PIC Interview 1 (Hasil)               </td>
                  <td>:                                               </td>
                  <td> {{$header['PICInterview']}} ( {{$header['ms_kode_interview1']}}    )                         </td>
                  <td style=" font-weight: bold;">Tanggal Interview Pertama               </td>
                  <td>:                                               </td>
                  <td> {{$header['DateInterview']  }}                     </td>
              </tr>
              <tr>
                <td style=" font-weight: bold;">PIC Interview 2 (Hasil)               </td>
                <td>:                                               </td>
                <td> {{$header['PICInterview2']}}  ( {{$header['ms_kode_interview2']}} )                            </td>
                <td style=" font-weight: bold;">Tanggal Interview Kedua               </td>
                <td>:                                               </td>
                <td> {{$header['DateInterview2']  }}                     </td>
            </tr>

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
  <br> <br>
  <h5>1. PENDIDIKAN TERAKHIR</h5>
<table rules="all" border="1" >
  <tr>
    <th>Nama Sekolah / Universitas </th>
    <th>Jenjang </th>
    <th>Tahun Masuk </th>
    <th>Tahun Lulus </th>
    <th>Alamat Sekolah  </th>
    <th>Nilai Rata-rata / IPK   </th>
  </tr>
  <tr>
    <td>{{   $pendidikan_det['sekolah'] }}  </td>
    <td>{{   $pendidikan_det['jenjang'] }}  </td>
    <td>{{   $pendidikan_det['tahunmasuk']}} </td>
    <td>{{   $pendidikan_det['tahunlulus'] }}</td>
    <td>{{   $pendidikan_det['alamat']    }} </td>
    <td>{{   $pendidikan_det['ipk']      }} </td>
  </tr>
</table>
<br>
<br>
<h5>2. RIWAYAT PEKERJAAN</h5>

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
    <th>Sertifikasi </th>
    <th>Ketesediaan Tes? </th>
  </tr>
  <tr>
    <td>{{   $skill_det['Skill']  }}  </td>
    <td>{{   $skill_det['tingkat']}} </td>
    <td>{{   $skill_det['sertifikasi']}} </td>
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
<br>
<h5>DETAIL INTERVIEW PERTAMA</h5>
<br>
<div class="row">
  {{--  <div class="col-12 col-md-12">
    <div class="form-group">
        <label  for="">Latar Belakang</label>
        <input type="text" value="{{ $interview1->latar_belakang }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label for="">Pengalaman Kerja & Masa Kerja</label>
        <input type="text" value="{{ $interview1->pengalaman_kerja }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label for="">Rincian Pekerjaan Terdahulu</label>
        <input type="text" value="{{ $interview1->rincian_pekrjaan }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label for="">Alasan Keluar</label>
        <input type="text" value="{{ $interview1->alasan_keluar }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label for="">Referensi</label>
        <input type="text" value="{{ $interview1->referensi }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label for="">Alasan Melamar</label>
        <input type="text" value="{{ $interview1->alasan_melamar }}"  id="" class="form-control" readonly>
    </div>
  </div>  --}}
  {{--  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Fisik <br> (badan sehat, tegak,cara berpakaian, kebersihan, semangat, kerapihan, wajah segar, keadaan fisik secara utuh) *</label>
        <input type="text" value="{{ $interview1->fisik }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Sopan Santun <br> (menyapa, duduk setelah di persilahkan, posisi duduk baik, mata ke arah pewawancara, penuh perhatian) *</label>
        <input type="text" value="{{ $interview1->sopan_santun }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Hubungan Pendidikan & Pekerjaan <br> (tingkat pendidikan yang dapat menunjang diposisi yang dilamar)</label>
        <input type="text" value="{{ $interview1->pendidikan_kerja }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Prestasi Akademik <br> (prestasi puncak yang pernah diraih, kegiatan akademik)</label>
        <input type="text" value="{{ $interview1->prestasi }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Kemampuan Menyampaikan Pendapat <br> (menyampaikan pemikiran dengan baik, tata bahasa mudah dimengerti, tenang dan tidak ragu, arah pembicaraan jelas)</label>
        <input type="text" value="{{ $interview1->penyampaian_pendapat }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Kemampuan Komunikasi <br> (kemampuan mengemukakan ide secara sistematis dan logis, sehingga dapat dipahami orang lain)</label>
        <input type="text" value="{{ $interview1->komunikasi }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Daya Tangkap <br> (memahami pemikiran dengan baik dan mengemukakan pendapatnya dengan tenang, tidak ragu dan arah pembicaraanya jelas)</label>
        <input type="text" value="{{ $interview1->daya_tangkap }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Kemampuan Analis <br> (kemampuan untuk mengidentifikasi masalah dan kecakapan dalam melihat data dan fakta guna menentukan tindakan selanjtunya)</label>
        <input type="text" value="{{ $interview1->analis }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Kepercayaan Diri <br> (tidak gugup, tenang,tidak ragu, menyampaikan pemikiran, menunjukan keyakinan diri)</label>
        <input type="text" value="{{ $interview1->percaya_diri }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Stabilitas Emosi <br> (tidak mudah cemas, memiliki kemampuan yang jelas, dapat menyesuaian dengan situasi wawancara)</label>
        <input type="text" value="{{ $interview1->stabilitas_emosi }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Motivasi (menunjukan interst, energik)</label>
        <input type="text" value="{{ $interview1->motivasi }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Hasil Interview 1 </label>
        <input type="text" value="{{ $header->ms_kode_interview1 }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">User </label>
        <input type="text" value="{{ $interview1->user }}"  id="" class="form-control" readonly>
    </div>
  </div>

</div>  --}}



<table class="table" id="dataTable">
  <thead>
    <tr >
      <th scope="col" >Fisik</th>
      <th scope="col" >Sopan</th>
      <th scope="col" >Pendidikan Dan Posisi</th>
      <th scope="col" >Prestasi</th>
      <th scope="col" >Penyampaian Pendapat</th>
      <th scope="col" >Komunikasi</th>
      <th scope="col" >Daya Tangkap</th>
      <th scope="col" >Analisa</th>
      <th scope="col" >Percaya Diri</th>
      <th scope="col" >Stabilitas Emosi</th>
      <th scope="col" >Motivasi</th>
      <th scope="col" >Hasil Interview1</th>
      <th scope="col" >PIC Interview1</th>
    </tr>
</thead>
<tbody>
  <tr>
      <td>{{ $interview1->fisik }}</td>
      <td>{{ $interview1->sopan_santun }}</td>
      <td>{{ $interview1->pendidikan_kerja }}</td>
      <td>{{ $interview1->prestasi }}</td>
      <td>{{ $interview1->penyampaian_pendapat }}</td>
      <td>{{ $interview1->komunikasi }}</td>
      <td>{{ $interview1->daya_tangkap }}</td>
      <td>{{ $interview1->analis }}</td>
      <td>{{ $interview1->percaya_diri }}</td>
      <td>{{ $interview1->stabilitas_emosi }}</td>
      <td>{{ $interview1->motivasi }}</td>
      <td>{{ $interview1->hasil_interview }}</td>
      <td>{{ $header->PICInterview }}</td>
  </tr>
</tbody>
</table>

<table>
    <tr>
      <td>
        <center> <label for="">Komentar Interview Pertama</label>
          <input type="text" value="{{ $interview1->note }}"  id="" class="form-control" readonly>
        </center>
            <br>
      </td>
        <tr>
</table>
<br>

<br>
<br>
<h5>DETAIL INTERVIEW KEDUA</h5>
<br>
<div class="row">
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label  for="">Skill (apakah sesuai dengan yg diharapkan ?) *</label>
        <input type="text" value="{{ $interview2->skill }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Attitude (kira2 apakah punya karakter dan attitude yg sesuai ?) *</label>
        <input type="text" value="{{ $interview2->attitude }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Leaderships (apakah ada tanda2 kepemimpinan ?)*</label>
        <input type="text" value="{{ $interview2->leadership }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Inisiative  (apakah ada potensi punya inisiative tinggi ? )*</label>
        <input type="text" value="{{ $interview2->inisiative }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Problem Solving (potensi memecahkan masalah) *</label>
        <input type="text" value="{{ $interview2->problem_solve }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Drive (semangat )*</label>
        <input type="text" value="{{ $interview2->drive }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Pengalaman Kerja Dengan Posisi Yang Dilamar (jobdescnya apakah sesuai) *</label>
        <input type="text" value="{{ $interview2->pengalaman_dengan_posisi }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Jam Kerja (ketersediaan jam kerja dan penempatan) *</label>
        <input type="text" value="{{ $interview2->jam_kerja }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Prestasi (pencapaian atau reward di tempat sebelumnya) *</label>
        <input type="text" value="{{ $interview2->prestasi }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Soft Skill (skill lainya yang dimiliki kandidat) *</label>
        <input type="text" value="{{ $interview2->soft_skill }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
      <label for="">Hasil Interview Kedua</label>
      <input type="text" value="{{ $interview2->hasil_interview }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Interviewer 3 *</label>
        <input type="text" value="{{ $interview2->Tr_status_interview }}"  id="" class="form-control" readonly>
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label for="">Komentar Interview Kedua*</label>
        <input type="text" value="{{ $interview2->note }}"  id="" class="form-control" readonly>
    </div>
  </div>
</div>
<br>
<br>
<center>
  <button class="btn btn-success" type="submit" name="send" position-relative>Confirm</button>
</center>

</body>
</html>

@endsection

