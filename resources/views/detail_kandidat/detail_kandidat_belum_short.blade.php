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



  <h5 >FORMULIR LAMARAN KERJA</h5>
  <form  action="/tr_candidates/Shortlist/{{$header['id']}}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
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
              <td style=" font-weight: bold;">Area Yang Diminati          </td>
              <td>:                                                     </td>
              <td> {{$header['area_minat']  }}                       </td>
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

  <tr>
    <td>{{   $pengalaman_det2['Perusahaan2']  }}  </td>
    <td>{{   $pengalaman_det2['Posisi2']}} </td>
    <td>{{   $pengalaman_det2['Lama_kerja2'] }}</td>
    <td>{{   $pengalaman_det2['Gaji2']    }} </td>
    <td>{{   $pengalaman_det2['No_hp2']      }} </td>
    <td>{{   $pengalaman_det2['alasan_keluar2']      }} </td>
  </tr>

  <tr>
    <td>{{   $pengalaman_det3['Perusahaan3']  }}  </td>
    <td>{{   $pengalaman_det3['Posisi3']}} </td>
    <td>{{   $pengalaman_det3['Lama_kerja3'] }}</td>
    <td>{{   $pengalaman_det3['Gaji3']    }} </td>
    <td>{{   $pengalaman_det3['No_hp3']      }} </td>
    <td>{{   $pengalaman_det3['alasan_keluar3']      }} </td>
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
  <tr>
    <td>{{   $organisasi_det2['Nama_organisasi2']  }}  </td>
    <td>{{   $organisasi_det2['Jabatan2']}} </td>
    <td>{{   $organisasi_det2['Periode2']    }} </td>
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
  <tr>
    <td>{{   $skill_det2['Skill2']  }}  </td>
    <td>{{   $skill_det2['tingkat2']}} </td>
    <td>{{   $skill_det2['sertifikasi2']}} </td>
    <td>{{   $skill_det2['siap_tes2']    }} </td>
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
  <tr>
    <td>{{   $sosmed_det2['sosmed2']  }}  </td>
    <td>{{   $sosmed_det2['nickname2']}} </td>
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
  <tr>
    <td>{{   $keluarga2['hubungan2']  }}  </td>
    <td>{{   $keluarga2['namanya2']}} </td>
    <td>{{   $keluarga2['pendidikan2']}} </td>
    <td>{{   $keluarga2['pekerjaan2']}} </td>
    <td>{{   $keluarga2['tempat2']}} </td>
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

{{--  <br>
<center>
<i>pasfoto</i>
  <br>
  @if($poto == '')
   <img width="90" height="120" src="{{ asset('nophoto.jpg') }}">
  @else
   <img width="90" height="120" src="{{ asset($poto->file_path) }}">
  @endif
</center>
<br>  --}}
<br>
<center>
  <i>cv / resumen</i>
  <br>
  @if($cv == '')
   {{--  <img width="90" height="120" src="{{ asset('nodokumen.png') }}">  --}}
   <!-- <a href="http://example.com/files/myfile.jpeg" target="_blank">Download CV</a> -->
  @else
  <embed width="90" height="120" src="{{ asset($cv->file_cv) }}">
  <!-- <i class="fa fa-file-pdf-o" style="font-size:95px;color:red" ></i> -->



  @endif
</center>
<br>


<br>
<center>

    <table>
        <tr>
          <td>
            <label for="">Apakah Kandidat Layak Untuk Proses Selanjutnya?</label>
            <select name = "status_shortlist" class="form-control" >
                <option value="1" style="weight:50px">Iya</option>
                <option value="2" style="weight:50px">Tidak</option>
            </select>
              <label for="">Berikan Alasan Untuk Kandidat</label>
             <input type="text" name="alasan_shortlist" id="" class="form-control" required>

              @if($header['CekShorlist'] == False)
             <center> <button type="button" class="btn btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Already Shortlist</button> </center>
              @else
             <center> <button class="btn btn-success" type="submit" name="send" position-relative>Shortlist</button> </center>
              @endif
          </td>
            <tr>
        </table>
        <br>
        <br>

<a href="https://hgs.co.id/"> hgs.co.id </a>
</center>

</body>
</html>

@endsection

