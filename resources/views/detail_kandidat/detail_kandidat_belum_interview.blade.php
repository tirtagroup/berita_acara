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



  <h5 >FORMULIR KANDIDAT BELUM INTERVIEW </h5>
  {{--  <form  action="/tr_candidates/Shortlist/{{$header['id']}}" method="post" enctype="multipart/form-data">  --}}
    <form  action="/tr_candidates/candidate_interview/{{$header['id']}}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
            <table>
                
            </table>
            <br>
            {{--  <h5 >DETAIL KANDIDAT BELUM INTERVIEW</h5>  --}}
            <table>

                <tr>
                    <td style=" font-weight: bold;">PIC Shortlist                </td>
                    <td>:                                               </td>
                    <td> {{$header['PICShortlist']}}                            </td>
                    <td style=" font-weight: bold;">Tanggal Shortlist              </td>
                    <td>:                                               </td>
                    <td> {{$header['DateShorlist']  }}                     </td>
                </tr>
                <tr>
                    <td style=" font-weight: bold;">PIC Call               </td>
                    <td>:                                               </td>
                    <td> {{$header['PICCall']}}                            </td>
                    <td style=" font-weight: bold;">Tanggal Menghubungi               </td>
                    <td>:                                               </td>
                    <td> {{$header['DateCall']  }}                     </td>
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
<h5>INTERVIEW PERTAMA</h5>
<br>
<table id="tabelMenarik">
  <tr>
      <td>Lanjut Atau Tidak ?</td>
      <td>
          <label>
              <input type="radio" name="lanjut_tidaklanjut" value="Lanjut"> Lanjut
          </label>
      </td>
      <td>
          <label>
              <input type="radio" name="lanjut_tidaklanjut" value="Tidak"> Tidak
          </label>
      </td>
  </tr>
  <tr>
    <td>Prioritas Atau Biasa ?</td>
    <td>
        <label>
            <input type="radio" name="priority" value="Prioritas"> Prioritas
        </label>
    </td>
    <td>
        <label>
            <input type="radio" name="priority" value="Biasa"> Biasa
        </label>
    </td>
  </tr>
  <tr>
    <td>Langsung BD Atau Biasa ?</td>
    <td>
        <label>
            <input type="radio" name="langsungBD" value="langsungBD"> Langsung BD
        </label>
    </td>
    <td>
        <label>
            <input type="radio" name="langsungBD" value="Biasa"> Biasa
        </label>
    </td>
  </tr>
</table>
<table id="tabelMenarik">
  <tr>
    <td>Drive</td>
    <td>
      <select  style="width: 100px; height: 40px;"  name="drive">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </td>
    <td >
          <input style="width: 950px; height: 40px;" type="text" placeholder="Enter Note Drive" name="notedrive" required>
    </td>
  </tr>
  <tr>
    <td>Skill</td>
    <td>
      <select  style="width: 100px; height: 40px;"  name="skill" >
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </td>
    <td >
          <input style="width: 950px; height: 40px;" type="text" placeholder="Enter Note Skill" name="noteskill" required>
    </td>
  </tr>
  <tr>
    <td>Solving</td>
    <td>
      <select  style="width: 100px; height: 40px;"  name="solving" >
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </td>
    <td >
          <input style="width: 950px; height: 40px;" type="text" placeholder="Enter Note Solving" name="notesolving" required>
    </td>
  </tr>
  <tr>
    <td>Leadership</td>
    <td>
      <select  style="width: 100px; height: 40px;"  name="leadership" >
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </td>
    <td >
          <input style="width: 950px; height: 40px;" type="text" placeholder="Enter Note Leadership" name="noteleadership" required>
    </td>
  </tr>
  <tr>
    <td>Initiative</td>
    <td>
      <select  style="width: 100px; height: 40px;"  name="initiative" >
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </td>
    <td >
          <input style="width: 950px; height: 40px;" type="text" placeholder="Enter Note Initiative" name="noteinitiative" required>
    </td>
  </tr>
  <tr>
    <td>Attitude</td>
    <td>
      <select  style="width: 100px; height: 40px;"  name="attitude" >
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </td>
    <td >
          <input style="width: 950px; height: 40px;" type="text" placeholder="Enter Note Attitude" name="noteattitude" required>
    </td>
  </tr>

</table>
<br>
<br>
<div class="row">
    <div class="col-12 col-md-6">
    <div class="form-group">
        <label for="">Hasil Interview Pertama</label>
          <select class="form-control" name="status_interview" >
            @foreach ($ms_kode_interview as $kode)
                <option value="{{$kode->desciption}}">
                    {{$kode->desciption}}
            @endforeach
          </select>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="form-group">
        <label  for="">User</label>
        <input type="text" name="user"  id="" class="form-control" >
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label  for="">Alasan Melamar</label>
        <input type="text" name="alasan_melamar"  id="" class="form-control" >
    </div>
  </div>
  <div class="col-12 col-md-12">
    <div class="form-group">
        <label  for="">Alasan Keluar Di Perusahaan Terakhir</label>
        <input type="text" name="alasan_keluar"  id="" class="form-control" >
    </div>
  </div>
  </div>
  <!--  <div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label  for="">Latar Belakang *</label>-->
  <!--      <input type="text" name="latar_belakang"  id="" class="form-control" required>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Pengalaman Kerja & Masa Kerja *</label>-->
  <!--      <input type="text" name="pengalaman_kerja"  id="" class="form-control" required>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Rincian Pekerjaan Terdahulu *</label>-->
  <!--      <input type="text" name="rincian_pekrjaan"  id="" class="form-control" required>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Alasan Keluar *</label>-->
  <!--      <input type="text" name="alasan_keluar"  id="" class="form-control" required>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Referensi *</label>-->
  <!--      <input type="text" name="referensi"  id="" class="form-control" required>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Alasan Melamar *</label>-->
  <!--      <input type="text" name="alasan_melamar"  id="" class="form-control" required>-->
  <!--  </div>-->
  <!--</div> -->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Fisik <br> (badan sehat, tegak,cara berpakaian, kebersihan, semangat, kerapihan, wajah segar, keadaan fisik secara utuh) *</label>-->
  <!--      <select  name = "fisik" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--    </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Sopan Santun <br> (menyapa, duduk setelah di persilahkan, posisi duduk baik, mata ke arah pewawancara, penuh perhatian) *</label>-->
  <!--      <select  name = "sopan_santun" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Hubungan Pendidikan & Pekerjaan <br> (tingkat pendidikan yang dapat menunjang diposisi yang dilamar)</label>-->
  <!--      <select  name = "pendidikan_kerja" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Prestasi Akademik <br> (prestasi puncak yang pernah diraih, kegiatan akademik)</label>-->
  <!--      <select  name = "prestasi" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Kemampuan Menyampaikan Pendapat <br> (menyampaikan pemikiran dengan baik, tata bahasa mudah dimengerti, tenang dan tidak ragu, arah pembicaraan jelas)</label>-->
  <!--      <select  name = "penyampaian_pendapat" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Kemampuan Komunikasi <br> (kemampuan mengemukakan ide secara sistematis dan logis, sehingga dapat dipahami orang lain)</label>-->
  <!--      <select  name = "komunikasi" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Daya Tangkap <br> (memahami pemikiran dengan baik dan mengemukakan pendapatnya dengan tenang, tidak ragu dan arah pembicaraanya jelas)</label>-->
  <!--      <select  name = "daya_tangkap" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Kemampuan Analis <br> (kemampuan untuk mengidentifikasi masalah dan kecakapan dalam melihat data dan fakta guna menentukan tindakan selanjtunya)</label>-->
  <!--      <select  name = "analis" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Kepercayaan Diri <br> (tidak gugup, tenang,tidak ragu, menyampaikan pemikiran, menunjukan keyakinan diri)</label>-->
  <!--      <select  name = "percaya_diri" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Stabilitas Emosi <br> (tidak mudah cemas, memiliki kemampuan yang jelas, dapat menyesuaian dengan situasi wawancara)</label>-->
  <!--      <select  name = "stabilitas_emosi" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Motivasi (menunjukan interst, energik)</label>-->
  <!--      <select  name = "motivasi" class="form-control" >-->
  <!--        <option value="Baik" style="weight:50px">Baik</option>-->
  <!--        <option value="Cukup" style="weight:50px">Cukup</option>-->
  <!--        <option value="Kurang" style="weight:50px">Kurang</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  
  <!-- <div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label  for="">Lanjut Atau Tidak ?</label>-->
  <!--      <select class="form-control" name="lanjut_tidaklanjut" >-->
  <!--        <option value="Lanjut">Lanjut</option>-->
  <!--        <option value="Tidak Lanjut">Tidak Lanjut</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label  for="">Prioritas Atau Biasa ?</label>-->
  <!--      <select class="form-control" name="priority" >-->
  <!--        <option value="Prioritas">Prioritas</option>-->
  <!--        <option value="Biasa">Biasa</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label  for="">Langsung Ke BD Atau Biasa ?</label>-->
  <!--      <select class="form-control" name="langsungBD" >-->
  <!--        <option value="Langsung Ke BD">Langsung Ke BD</option>-->
  <!--        <option value="Biasa">Biasa</option>-->
  <!--      </select>-->
  <!--  </div>-->
  <!--</div>-->
  
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label  for="">User *</label>-->
  <!--      <input type="text" name="user"  id="" class="form-control" required>-->
  <!--  </div>-->
  <!--</div>-->
  <!--<div class="col-12 col-md-6">-->
  <!--  <div class="form-group">-->
  <!--      <label for="">Hasil Interview Pertama</label>-->
  <!--        <select class="form-control" name="status_interview" >-->
  <!--          @foreach ($ms_kode_interview as $kode)-->
  <!--              <option value="{{$kode->desciption}}">-->
  <!--                  {{$kode->desciption}}-->
  <!--          @endforeach-->
  <!--        </select>-->
  <!--  </div>-->
  <!--</div>-->
<!--</div>-->
<table>
    <tr>
      <td>
            <br>
        <center> <label for="">Note</label>
                <input type="text" name="alasan_interview" id="" class="form-control" required>
        </center>
            <br>
          @if($header['CekInterview'] == True)
                <center> <button type="button" class="btn btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Already Interview</button> </center>
          @else
                <center> <button class="btn btn-success" type="submit" name="send" position-relative>Confirm</button> </center>
          @endif
      </td>
        <tr>
</table>
<br>

</body>
</html>

@endsection

