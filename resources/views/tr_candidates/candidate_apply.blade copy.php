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

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<div id="card" class="container">
    <center>
    <div class="logo"><img src="https://hgs.co.id/wp-content/uploads/2020/06/LOGO-HGS-scaled.jpg" style="width:100px;height:70px;" > </div>
</center>
<!--<center><h2 >LENGKAPI DATA DIRI </center> </h2>-->
<center><p>* harap lengkapi semua data yang sudah di grouping, dengan cara membuka / menutup checklist disamping kalimat warna merah !</p></center>

<h5><input type="checkbox"name="other"> &nbsp;Data Pribadi </h5>
    <div class="card-body">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <form  action="/tr_candidates/candidate_apply" method="post" enctype="multipart/form-data">
        @csrf
            <fieldset   class="other">

    <div class="row">
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label for="">Nama Lengkap *</label>
                <input type="text" name="Name" id="" class="form-control" required>
            </div>
        </div>
        <br>
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label for="">No. Ktp *</label>
                <input type="number" name="Ktp"  id="" class="form-control" placeholder="0" required>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="form-group"><br>
                <label for="">Alamat / Domisili *</label>
                <input type="text" name="domisili"  id="" class="form-control" required>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">No. SIM *</label>
                <input type="number" name="no_sim"  id="" class="form-control" placeholder="0" required>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Type SIM</label>
                <select name = "type_sim" class="form-control" >
                <option value="Tidak Memiliki SIM" style="weight:50px">Tidak Memiliki SIM</option>
                    <option value="SIM A" style="weight:50px">SIM A</option>
                    <option value="SIM B1" style="weight:50px">SIM B1</option>
                    <option value="SIM B2" style="weight:50px">SIM B2</option>
                    <option value="SIM C" style="weight:50px">SIM C</option>
                    <option value="SIM D" style="weight:50px">SIM D</option>
                    <option value="SIM A Umum" style="weight:50px">SIM A Umum</option>
                    <option value="SIM B1 Umum" style="weight:50px">SIM B1 Umum</option>
                    <option value="SIM B2 Umum" style="weight:50px">SIM B2 Umum</option>

                </select>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Tempat lahir *</label>
                <input type="text" name="CityBirth"  id="" class="form-control" required>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Tanggal lahir *</label>
                <input class="form-control" type="date" name="Birthdate" value="1997-08-17" id="datetime">

            </div>
        </div>
        <div class="col-12 col-md-6">
                <label for="" >Status </label>
                <select name = "status" class="form-control" >
                    <option value="Menikah" style="weight:50px">Menikah</option>
                    <option value="Belum Menikah" style="weight:50px">Belum Menikah</option>
                </select>
        </div>
        <div class="col-12 col-md-6">
            <label for="" >Gender </label>
            <select  name = "jenis_kelamin" class="form-control" >
                <option value="P" style="weight:50px">Perempuan</option>
                <option value="L" style="weight:50px">Laki - Laki</option>
            </select>
        </div>
        <div class="col-12 col-md-12">
        <div class="form-group"> <br>
            <label for="">Agama</label>
            <select class="form-control" name="agama" >
                <option value="Islam" style="weight:50px">Islam</option>
                <option value="Protestan" style="weight:50px">Protestan</option>
                <option value="Katolik" style="weight:50px">Katolik</option>
                <option value="Hindu" style="weight:50px">Hindu</option>
                <option value="Buddha" style="weight:50px">Buddha</option>
                <option value="Khonghucu" style="weight:50px">Khonghucu</option>
                </select>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="">No. HP *</label>
            <input type="number" name="Handphone" id="" class="form-control" placeholder="+62" required>
        </div>
    </div>
    <div class="row">
        </div>
        <div class="col-12 col-md-12">
            <div class="form-group"><br>
                <label for="">Email *</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Your Email" id="mail" name="Email" required>
                    <div class="input-group-append">
                        <span class="input-group-text">@ex.com</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="form-group"><br>
                <label for="">Riwayat Penyakit ( Jelaskan jika ada / isi tidak ada jika tidak memiliki riwayat penyakit )</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="mail" name="riwayat_penyakit" required>
                    <div class="input-group-append">
                        <!-- <span class="input-group-text">@ex.com</span> -->
                    </div>
                </div>
            </div>
        </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="">Date</label>
            <input class="form-control" readonly=readonly name="tanggal" type="text" value="{{Carbon\Carbon::now()->format('d-m-Y')}}" />
        </div>
    </div>
    </div></div>
</fieldset>
    <table >
        <center><h4>PENGALAMAN KERJA </center> </h4>
    <h5 for=""><input type="checkbox">&nbsp;Pengalaman Kerja</h5>
                        {{--  <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for=""><input type="checkbox" name="othaersss">&nbsp;Belum berpengalaman (Fresh graduate)</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for=""><input type="checkbox" name="others" value="masih berkerja">&nbsp;Berpengalaman (Masih berkerja)</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for=""><input type="checkbox" name="others" value="tidak berkerja">&nbsp;Berpengalaman &nbsp;&nbsp;&nbsp;&nbsp;(Tidak berkerja)</label>
                                </div>
                            </div>
                        </div>  --}}
                        {{--  <fieldset  id='TextBoxesGroup'class="others">  --}}
                        <div class="row">
                            <div class="col-12 col-md-6">
                                    <div id="inputFormRow">
                                <div class="form-group">
                                    <label for="">*1. Nama Perusahaan</label>
                                    <input type="text" name="Perusahaan" id="" class="form-control" required>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Posisi</label>
                                    <input type="text" name="Posisi" id="" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Lama Berkerja</label>
                                    <input type="text" name="Lama_kerja" id="" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Gaji </label>
                                    <input type="text" name="Gaji" id="rupiah" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Nomor Telepon Perusahaan </label>
                                    <input type="number" name="No_hp" id="" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="" >Alasan Keluar</label>
                                    <input type="text" name="alasan_keluar" id="" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="" >Komentar Tentang Perusahaan</label>
                                    <input type="text" name="komentar" id="" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  <div class="input_fields_wrap">
                        <div>
                    <button class="add_field_button">Tambah Pengalaman</button>
                        </div>
                    </div>  --}}
                    <h5 for=""><input type="checkbox" name="others">&nbsp;Pengalaman Kerja Lainya</h5>
                    </fieldset>
                    <br>

                    <fieldset  id='TextBoxesGroup'class="others">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                    <div id="inputFormRow">
                                <div class="form-group">
                                    <label for="">2. Nama Perusahaan</label>
                                    <input type="text" name="Perusahaan2" id="" class="form-control">
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Posisi</label>
                                    <input type="text" name="Posisi2" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Lama Berkerja</label>
                                    <input type="text" name="Lama_kerja2" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Gaji </label>
                                    <input type="text" name="Gaji2" id="rupiah" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Nomor Telepon Perusahaan </label>
                                    <input type="number" name="No_hp2" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="" >Alasan Keluar</label>
                                    <input type="text" name="alasan_keluar2" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="" >Komentar Tentang Perusahaan</label>
                                    <input type="text" name="komentar2" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    </fieldset>

                    <h5 for=""><input type="checkbox" name="otherss">&nbsp;Pengalaman Kerja Lainya</h5>
                    </fieldset>
                    <br>

                    <fieldset  id='TextBoxesGroup'class="otherss">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                    <div id="inputFormRow">
                                <div class="form-group">
                                    <label for="">3. Nama Perusahaan</label>
                                    <input type="text" name="Perusahaan3" id="" class="form-control">
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Posisi</label>
                                    <input type="text" name="Posisi3" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Lama Berkerja</label>
                                    <input type="text" name="Lama_kerja3" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Gaji </label>
                                    <input type="text" name="Gaji3" id="rupiah" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">Nomor Telepon Perusahaan </label>
                                    <input type="number" name="No_hp3" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="" >Alasan Keluar</label>
                                    <input type="text" name="alasan_keluar3" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="" >Komentar Tentang Perusahaan</label>
                                    <input type="text" name="komentar3" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    </fieldset>

                    <center><h4>PENDIDIKAN TERAKHIR</center> </h4>
                    <br>
    {{--  <h5 for=""><input type="checkbox" name="otherss" value="Riwayat Pendidikan">&nbsp;Pendidikan Terakhir</h5>  --}}
            <!-- <fieldset  id='TextBoxesGroup'class="otherss"> -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">Jenjang Pendidikan</label>
                            <select name = "jenjang" class="form-control" >
                                <option value="Magister (Strata 2)" style="weight:50px">Magister (Strata 2)</option>
                                <option value="Sarjana (Strata 1)" style="weight:50px">Sarjana (Strata 1)</option>
                                <option value="Diploma 3 (D3)" style="weight:50px">Diploma 3 (D3)</option>
                                <option value="Sekolah Menengah Atas / Kejuaruan(SMA/SMK)" style="weight:50px">Sekolah Menengah Atas / Kejuaruan(SMA/SMK)</option>
                                <option value="Sekolah Menengah Pertama" style="weight:50px">Sekolah Menengah Pertama</option>
                                <option value="Sekolah Dasar (SD)" style="weight:50px">Sekolah Dasar (SD)</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">Nama Sekolah / Universitas</label>
                            <input type="text" name="sekolah" id="" class="form-control" required>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Jurusan</label>
                            <input type="text" name="jurusan" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Tahun Masuk</label>
                            <input type="text" name="tahunmasuk" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Tahun Lulus</label>
                            <input type="text" name="tahunlulus" id="rupiah" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Alamat Sekolah / Universitas </label>
                            <input type="text" name="alamat" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="" >Nilai Rata-Rata / IPK</label>
                            <input type="text" name="ipk" id="" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>
            <script>
            $(document).ready(function() {
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wrapss");
                var add_button      = $(".add_field_buttonss");

                var x = 1;
                $(add_button).click(function(e){
                    e.preventDefault();
                    if(x < max_fields){
                        x++;
                        $(wrapper).append('<div> <div class="row"><div class="col-12 col-md-6"><div id="inputFormRow"><div class="form-group"><label for="">* Nama Sekolah / Universitas</label><input type="text" name="sekolah" id="" class="form-control"></div></div></div><div class="col-12 col-md-6"><div class="form-group"><label for="">Tahun Masuk</label><input type="text" name="tahunmasuk" id="" class="form-control"></div></div><div class="col-12 col-md-6"><div class="form-group"><label for="">Tahun Lulus</label><input type="text" name="tahunlulus" id="rupiah" class="form-control"></div></div><div class="col-12 col-md-6"><div class="form-group"><label for="">Alamat Sekolah / Universitas </label><input type="text" name="alamat" id="" class="form-control"></div></div><div class="col-12 col-md-6"><div class="form-group"><label for="" >Nilai Rata-Rata / IPK</label><input type="text" name="ipk" id="" class="form-control"></div></div></div> </div> </div>');
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
            </script>
            <center><h4>PENGALAMAN ORGANISASI</center> </h4>
            <br>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">* 1. Nama Organisasi / Pelatihan</label>
                            <input type="text" name="Nama_organisasi" id="" class="form-control">
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Jabatan</label>
                            <input type="text" name="Jabatan" id="" class="form-control" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <input type="text" name="Periode" id="rupiah" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="input_fields_wraps">
                <div>
            <button class="add_field_buttons">Tambah Organisasi</button>
                </div>
            </div>  --}}
            </fieldset>

            <h5 for=""><input type="checkbox" name="othersss" value="Pengalaman Organisasi / Pelatihan">&nbsp;Organisasi / Pelatihan Lainya</h5>
            <fieldset  id='TextBoxesGroup'class="othersss">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">2. Nama Organisasi / Pelatihan</label>
                            <input type="text" name="Nama_organisasi2" id="" class="form-control">
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Jabatan</label>
                            <input type="text" name="Jabatan2" id="" class="form-control" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <input type="text" name="Periode2" id="rupiah" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>
            <script>
            $(document).ready(function() {
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wraps");
                var add_button      = $(".add_field_buttons");

                var x = 1;
                $(add_button).click(function(e){
                    e.preventDefault();
                    if(x < max_fields){
                        x++;
                        $(wrapper).append('<div> <div class="row"><div class="col-12 col-md-6"><div id="inputFormRow"><div class="form-group"><label for="">* Nama Organisasi / Pelatihan</label><input type="text" name="Nama_organisasi" id="" class="form-control"></div></div></div><div class="col-12 col-md-6"><div class="form-group"><label for="">Jabatan</label><input type="text" name="Jabatan" id="" class="form-control"></div> </div> <div class="col-12 col-md-6"> <div class="form-group"> <label for="">Periode</label><input type="text" name="Periode" id="rupiah" class="form-control"></div></div> </div> </div>    </div>');
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
            </script>
            <center><h4>SKILL / KETERAMPILAN</center> </h4>
            <br>
            {{--  <h5 for=""><input type="checkbox" name="otherssss" value="Skill">&nbsp;Skill</h5>
            <fieldset  id='TextBoxesGroup'class="otherssss">  --}}
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">1. Skill</label>
                            <input type="text" name="Skill" id="" class="form-control" required>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Tingkat</label>
                            <select name = "tingkat" class="form-control" >
                                <option value="Mahir / Expert" style="weight:50px">Mahir / Expert</option>
                                <option value="Menengah" style="weight:50px">Menengah</option>
                                <option value="Masih Belajar" style="weight:50px">Masih Belajar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">Sertifikat?</label>
                            <select name = "sertifikasi" class="form-control" >
                                <option value="Ada" style="weight:50px">Ada</option>
                                <option value="Tidak" style="weight:50px">Tidak Ada</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Siap Mengikuti Tes?</label>
                            <select name = "siap_tes" class="form-control" >
                                <option value="Siap" style="weight:50px">Siap</option>
                                <option value="Tidak Siap" style="weight:50px">Tidak Siap</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>

            <h5 for=""><input type="checkbox" name="otherssss" value="Skill">&nbsp;Skill Lainya</h5>
            <fieldset  id='TextBoxesGroup'class="otherssss">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">2.Skill</label>
                            <input type="text" name="Skill2" id="" class="form-control">
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Tingkat</label>
                            <select name = "tingkat2" class="form-control" >
                                <option value="Mahir / Expert" style="weight:50px">Mahir / Expert</option>
                                <option value="Menengah" style="weight:50px">Menengah</option>
                                <option value="Masih Belajar" style="weight:50px">Masih Belajar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">Sertifikat?</label>
                            <select name = "sertifikasi2" class="form-control" >
                                <option value="Ada" style="weight:50px">Ada</option>
                                <option value="Tidak" style="weight:50px">Tidak Ada</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Siap Mengikuti Tes?</label>
                            <select name = "siap_tes2" class="form-control" >
                                <option value="Siap" style="weight:50px">Siap</option>
                                <option value="Tidak Siap" style="weight:50px">Tidak Siap</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>
            <script>
            $(document).ready(function() {
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wrapssss");
                var add_button      = $(".add_field_buttonssss");

                var x = 1;
                $(add_button).click(function(e){
                    e.preventDefault();
                    if(x < max_fields){
                        x++;
                        $(wrapper).append('<div> <div class="row"><div class="col-12 col-md-6"> <div id="inputFormRow"><div class="form-group"> <label for="">* Skill</label><input type="text" name="Skill" id="" class="form-control"></div></div> </div><div class="col-12 col-md-6"><div class="form-group"><label for="">Tingkat</label><select name = "tingkat" class="form-control" ><option value="Mahir / Expert" style="weight:50px">Mahir / Expert</option><option value="Menengah" style="weight:50px">Menengah</option><option value="Masih Belajar" style="weight:50px">Masih Belajar</option> </select></div></div> <div class="col-12 col-md-6"><div id="inputFormRow"><div class="form-group"> <label for="">Sertifikat?</label><select name = "sertifikasi" class="form-control" ><option value="Ada" style="weight:50px">Ada</option> <option value="Tidak" style="weight:50px">Tidak Ada</option></select></div>  </div>                   </div> <div class="col-12 col-md-6"><div class="form-group"> <label for="">Siap Mengikuti Tes?</label><select name = "siap_tes" class="form-control" ><option value="Siap" style="weight:50px">Siap</option> <option value="Tidak Siap" style="weight:50px">Tidak Siap</option></select> </div></div> </div> </div>     </div>');
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
            </script>
            <center><h4>SOCIAL MEDIA</center> </h4>
            <br>
              {{--  <h5 for=""><input type="checkbox" name="othersssss" value="Social Media">&nbsp;Social Media</h5>
             <fieldset  id='TextBoxesGroup'class="othersssss">  --}}
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">* 1. Social Media</label>
                            <select name = "sosmed" class="form-control" >
                                <option value="Facebook" style="weight:50px">Facebook</option>
                                <option value="Instagram" style="weight:50px">Instagram</option>
                                <option value="Twitter" style="weight:50px">Twitter</option>
                                <option value="LinkedIn" style="weight:50px">LinkedIn</option>
                                <option value="TikTok" style="weight:50px">TikTok</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="">Nickname / ID</label>
                            <input type="text" name="nickname" id="" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>

            <h5 for=""><input type="checkbox" name="othersssss" value="Social Media">&nbsp;Media Sosial Lainya</h5>
             <fieldset  id='TextBoxesGroup'class="othersssss">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for=""> 2. Social Media</label>
                            <select name = "sosmed2" class="form-control" >
                                <option value="Facebook" style="weight:50px">Facebook</option>
                                <option value="Instagram" style="weight:50px">Instagram</option>
                                <option value="Twitter" style="weight:50px">Twitter</option>
                                <option value="LinkedIn" style="weight:50px">LinkedIn</option>
                                <option value="TikTok" style="weight:50px">TikTok</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="">Nickname / ID</label>
                            <input type="text" name="nickname2" id="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>

            <script>
            $(document).ready(function() {
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wrapsssss");
                var add_button      = $(".add_field_buttonsssss");

                var x = 1;
                $(add_button).click(function(e){
                    e.preventDefault();
                    if(x < max_fields){
                        x++;
                        $(wrapper).append('<div> <div class="row"><div class="col-12 col-md-4">  <div id="inputFormRow"><div class="form-group"><label for="">* Social Media</label> <select name = "sosmed" class="form-control" > <option value="Facebook" style="weight:50px">Facebook</option> <option value="Instagram" style="weight:50px">Instagram</option><option value="Twitter" style="weight:50px">Twitter</option> <option value="LinkedIn" style="weight:50px">LinkedIn</option><option value="TikTok" style="weight:50px">TikTok</option> </select> </div> </div> </div> <div class="col-12 col-md-8">  <div class="form-group"><label for="">Nickname / ID</label><input type="text" name="nickname" id="" class="form-control"> </div> </div> </div>    </div>   </div>');
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
            </script>
            <center><h4>RIWAYAT KELUARGA</center> </h4>
            <br>
            {{--  <h5 for=""><input type="checkbox" name="otherssssss" value="Riwayat Keluarga">&nbsp;Riwayat Keluarga</h5>
            <fieldset  id='TextBoxesGroup'class="otherssssss">   --}}
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">* Hubungan</label>
                            <select name = "hubungan" class="form-control" >
                                <option value="Ayah" style="weight:50px">Ayah</option>
                                <option value="Ibu" style="weight:50px">Ibu</option>
                                <option value="Saudara Kandung" style="weight:50px">Saudara Kandung</option>
                                <option value="Sepupu" style="weight:50px">Sepupu</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="namanya" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Pekerjaan</label>
                            <input type="text" name="pekerjaan" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Tempat Berkerja</label>
                            <input type="text" name="tempat" id="" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="input_fields_wrapsssssss">
                <div>
            <button class="add_field_buttonsssssss">Tambah Keluarga</button>
                </div>
            </div>  --}}
            </fieldset>

            <h5 for=""><input type="checkbox" name="otherssssss" value="Riwayat Keluarga">&nbsp;Hubungan Keluarga Lainya</h5>
            <fieldset  id='TextBoxesGroup'class="otherssssss">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div id="inputFormRow">
                        <div class="form-group">
                            <label for="">2. Hubungan</label>
                            <select name = "hubungan2" class="form-control" >
                                <option value="Ayah" style="weight:50px">Ayah</option>
                                <option value="Ibu" style="weight:50px">Ibu</option>
                                <option value="Saudara Kandung" style="weight:50px">Saudara Kandung</option>
                                <option value="Sepupu" style="weight:50px">Sepupu</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="namanya2" id="" class="form-control" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan2" id="" class="form-control" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Pekerjaan</label>
                            <input type="text" name="pekerjaan2" id="" class="form-control" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Tempat Berkerja</label>
                            <input type="text" name="tempat2" id="" class="form-control" >
                        </div>
                    </div>
                </div>
            </div>
            </fieldset>

            <script>
            $(document).ready(function() {
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wrapsssssss");
                var add_button      = $(".add_field_buttonsssssss");

                var x = 1;
                $(add_button).click(function(e){
                    e.preventDefault();
                    if(x < max_fields){
                        x++;
                        $(wrapper).append('<div> <div class="row"> <div class="col-12 col-md-6"><div id="inputFormRow"><div class="form-group"> <label for="">* Hubungan</label> <select name = "hubungan" class="form-control" >  <option value="Ayah" style="weight:50px">Ayah</option><option value="Ibu" style="weight:50px">Ibu</option><option value="Saudara Kandung" style="weight:50px">Saudara Kandung</option> <option value="Sepupu" style="weight:50px">Sepupu</option> </select></div> </div></div><div class="col-12 col-md-6"> <div class="form-group"> <label for="">Nama</label><input type="text" name="namanya" id="" class="form-control"></div> </div><div class="col-12 col-md-6"><div class="form-group"> <label for="">Pendidikan Terakhir</label><input type="text" name="pendidikan" id="" class="form-control"> </div></div><div class="col-12 col-md-6"><div class="form-group"><label for="">Pekerjaan</label> <input type="text" name="pekerjaan" id="" class="form-control"></div> </div><div class="col-12 col-md-6"><div class="form-group"><label for="">Tempat Berkerja</label> <input type="text" name="tempat" id="" class="form-control"></div></div> </div>  </div>   </div>');
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
            </script>

            <br>

            <div class="row">
            <div class="col-12 col-md-6">
                    <div id="inputFormRow">
                <div class="form-group">
                    <label for="">Gaji yang diharapkan *</label>
                    <!--<input type="text" name="pengajuan_gaji" id="currency-field" class="form-control"  data-type="currency">-->
                    <input type="text" name="pengajuan_gaji" class="form-control" >
                </div>
            </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">Info Lowongan Dari *</label>
                    <select name = "info_lowongan" class="form-control" >
                        <option value="LinkIdn" style="weight:50px">LinkIdn</option>
                        <option value="Jobstreet" style="weight:50px">Jobstreet</option>
                        <option value="Karir" style="weight:50px">Karir</option>
                        <option value="LokerId" style="weight:50px">LokerId</option>
                        <option value="OLX" style="weight:50px">OLX</option>
                        <option value="Sosial Media" style="weight:50px">Sosial Media</option>
                        <option value="Teman / Relasi" style="weight:50px">Teman / Relasi</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">Posisi Yang Dilamar Pertama *</label>
                    <select name = "Position_aplly1" class="form-control" >
                    <!-- <select style="width: 735px;" name = "Position_aplly" class="form-control" > -->
                    <option value="OPERATIONAL TRANSPORT" style="font-weight: bold" disabled="disabled">1. DIVISI OPERATIONAL TRANSPORT</option>
                    <option value="SPV Transport" style="weight:50px">    > SPV Transport</option>
                    <option value="Koord. Transport" style="weight:50px"> > Koord. Transport</option>
                    <option value="Dispatcher" style="weight:50px"> > Dispatcher</option>
                    <option value="Data Entry" style="weight:50px">> Data Entry</option>
                    <option value="Checker Plant" style="weight:50px">> Checker Plant</option>
                    <option value="HR GA" style="font-weight: bold" disabled="disabled">2. DIVISI HR GA</option>
                    <option value="Chif Security" style="weight:50px">> Chif Security</option>
                    <option value="SPV GA" style="weight:50px">> SPV GA</option><option value="Koord. HR" style="weight:50px">> Koord. HR</option>
                    <option value="Legal" style="weight:50px">> Legal</option>
                    <option value="Koord. GA" style="weight:50px">> Koord. GA</option>
                    <option value="Security" style="weight:50px">> Security</option>
                    <option value="Staff Umum" style="weight:50px">> Staff Umum</option>
                    <option value="Finance" style="font-weight: bold" disabled="disabled">3. DIVISI FINANCE</option>
                    <option value="Purchasing" style="weight:50px">> Purchasing</option>
                    <option value="Cashier" style="weight:50px">> Cashier</option>
                    <option value="MT Finance" style="weight:50px">> MT Finance</option>
                    <option value="Staff AR" style="weight:50px">> Staff AR</option>
                    <option value="Staff Accounting" style="weight:50px">> Staff Accounting</option>
                    <option value="Staff Pajak" style="weight:50px">> Staff Pajak</option>
                    <option value="Staff Payroll" style="weight:50px">> Staff Payroll</option>
                    <option value="Auditor Internal" style="weight:50px">> Auditor Internal</option>
                    <option value="FLEET" style="font-weight: bold" disabled="disabled">4. DIVISI FLEET</option>
                    <option value="SPV Fleet" style="weight:50px">> SPV Fleet</option>
                    <option value="Koord. Fleet" style="weight:50px"> > Koord. Fleet</option>
                    <option value="Service Officer" style="weight:50px">> Service Officer</option>
                    <option value="Mekanik Junior" style="weight:50px">> Mekanik Junior</option>
                    <option value="Mekanik Senior" style="weight:50px">> Mekanik Senior</option>
                    <option value="Petroll Man" style="weight:50px">> Petroll Man</option>
                    <option value="Tyre Man" style="weight:50px">> Tyre Man</option>
                    <option value="PROJECT" style="font-weight: bold" disabled="disabled">5. DIVISI PROJECT</option>
                    <option value="PIC Project" style="weight:50px">> PIC Project</option>
                    <option value="BD (Bussines Development)" style="weight:50px">> BD (Bussines Development)</option>
                    <option value="WEREHOUSE" style="font-weight: bold" disabled="disabled">6. DIVISI WEREHOUSE</option>
                    <option value="SPV Gudang" style="weight:50px">> SPV Gudang</option>
                    <option value="Kepala Gudang" style="weight:50px">> Kepala Gudang</option>
                    <option value="Leadership Gudang" style="weight:50px">> Leadership Gudang</option>
                    <option value="Admin Gudang" style="weight:50px">> Admin Gudang</option>
                    <option value="Staff Gudang" style="weight:50px">> Staff Gudang</option>
                    <option value="Operator Forklip" style="weight:50px">> Operator Forklip</option>
                    <option value="Checker Gudang" style="weight:50px">> Checker Gudang</option>
                    <option value="IT" style="font-weight: bold" disabled="disabled">7. DIVISI IT</option>
                    <option value="SPV IT" style="weight:50px">> SPV IT</option>
                    <option value="Senior Programmer" style="weight:50px">> Senior Programmer</option>
                    <option value="Junior Programmer" style="weight:50px">> Junior Programmer</option>
                    <option value="IT Support" style="weight:50px">> IT Support</option>
                    <option value="Restaurant" style="font-weight: bold" disabled="disabled">8. DIVISI  RESTAURANT</option>
                    <option value="Waiters" style="weight:50px">> Waiters</option>
                    <option value="Cook Helper" style="weight:50px">> Cook Helper</option>
                    <option value="Staff Gudang Resto" style="weight:50px">> Staff Gudang Resto</option>
                    <option value="SALES" style="font-weight: bold" disabled="disabled">9. DIVISI SALES</option>
                    <option value="OM (Operation Manager Sales)" style="weight:50px">> OM (Operation Manager Sales)</option>
                    <option value="SPV Sales" style="weight:50px">> SPV Sales</option>
                     <option value="Sales TO" style="weight:50px">> Sales TO</option>
                    <option value="SMD" style="weight:50px">> SMD</option>


                </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">Posisi Yang Dilamar Kedua *</label>
                    <select name = "Position_aplly2" class="form-control" >
                    <option value="OPERATIONAL TRANSPORT" style="font-weight: bold" disabled="disabled">1. DIVISI OPERATIONAL TRANSPORT</option>
                    <option value="SPV Transport" style="weight:50px">    > SPV Transport</option>
                    <option value="Koord. Transport" style="weight:50px"> > Koord. Transport</option>
                    <option value="Dispatcher" style="weight:50px"> > Dispatcher</option>
                    <option value="Data Entry" style="weight:50px">> Data Entry</option>
                    <option value="Checker Plant" style="weight:50px">> Checker Plant</option>
                    <option value="HR GA" style="font-weight: bold" disabled="disabled">2. DIVISI HR GA</option>
                    <option value="Chif Security" style="weight:50px">> Chif Security</option>
                    <option value="SPV GA" style="weight:50px">> SPV GA</option> <option value="Koord. HR" style="weight:50px">> Koord. HR</option>
                    <option value="Legal" style="weight:50px">> Legal</option>
                    <option value="Koord. GA" style="weight:50px">> Koord. GA</option>
                    <option value="Security" style="weight:50px">> Security</option>
                    <option value="Staff Umum" style="weight:50px">> Staff Umum</option>
                    <option value="Finance" style="font-weight: bold" disabled="disabled">3. DIVISI FINANCE</option>
                    <option value="Purchasing" style="weight:50px">> Purchasing</option>
                    <option value="Cashier" style="weight:50px">> Cashier</option>
                    <option value="MT Finance" style="weight:50px">> MT Finance</option>
                    <option value="Staff AR" style="weight:50px">> Staff AR</option>
                    <option value="Staff Accounting" style="weight:50px">> Staff Accounting</option>
                    <option value="Staff Pajak" style="weight:50px">> Staff Pajak</option>
                    <option value="Staff Payroll" style="weight:50px">> Staff Payroll</option>
                    <option value="Auditor Internal" style="weight:50px">> Auditor Internal</option>
                    <option value="FLEET" style="font-weight: bold" disabled="disabled">4. DIVISI FLEET</option>
                    <option value="SPV Fleet" style="weight:50px">> SPV Fleet</option>
                    <option value="Koord. Fleet" style="weight:50px"> > Koord. Fleet</option>
                    <option value="Service Officer" style="weight:50px">> Service Officer</option>
                    <option value="Mekanik Junior" style="weight:50px">> Mekanik Junior</option>
                    <option value="Mekanik Senior" style="weight:50px">> Mekanik Senior</option>
                    <option value="Petroll Man" style="weight:50px">> Petroll Man</option>
                    <option value="Tyre Man" style="weight:50px">> Tyre Man</option>
                    <option value="PROJECT" style="font-weight: bold" disabled="disabled">5. DIVISI PROJECT</option>
                    <option value="PIC Project" style="weight:50px">> PIC Project</option>
                    <option value="BD (Bussines Development)" style="weight:50px">> BD (Bussines Development)</option>
                    <option value="WEREHOUSE" style="font-weight: bold" disabled="disabled">6. DIVISI WEREHOUSE</option>
                    <option value="SPV Gudang" style="weight:50px">> SPV Gudang</option>
                    <option value="Kepala Gudang" style="weight:50px">> Kepala Gudang</option>
                    <option value="Leadership Gudang" style="weight:50px">> Leadership Gudang</option>
                    <option value="Admin Gudang" style="weight:50px">> Admin Gudang</option>
                    <option value="Staff Gudang" style="weight:50px">> Staff Gudang</option>
                    <option value="Operator Forklip" style="weight:50px">> Operator Forklip</option>
                    <option value="Checker Gudang" style="weight:50px">> Checker Gudang</option>
                    <option value="IT" style="font-weight: bold" disabled="disabled">7. DIVISI IT</option>
                    <option value="SPV IT" style="weight:50px">> SPV IT</option>
                    <option value="Senior Programmer" style="weight:50px">> Senior Programmer</option>
                    <option value="Junior Programmer" style="weight:50px">> Junior Programmer</option>
                    <option value="IT Support" style="weight:50px">> IT Support</option>
                    <option value="Restaurant" style="font-weight: bold" disabled="disabled">8. DIVISI RESTAURANT</option>
                    <option value="Waiters" style="weight:50px">> Waiters</option>
                    <option value="Cook Helper" style="weight:50px">> Cook Helper</option>
                    <option value="Staff Gudang Resto" style="weight:50px">> Staff Gudang Resto</option>
                    <option value="SALES" style="font-weight: bold" disabled="disabled">9. DIVISI SALES</option>
                    <option value="OM (Operation Manager Sales)" style="weight:50px">> OM (Operation Manager Sales)</option>
                    <option value="SPV Sales" style="weight:50px">> SPV Sales</option>
                    <option value="Sales TO" style="weight:50px">> Sales TO</option>
                    <option value="SMD" style="weight:50px">> SMD</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">Area Yang Diminati</label>
                    <select name = "area_minat" class="form-control" >
                        <option value="Bersedia" style="weight:50px">Jakarta</option>
                        <option value="Tidak Bersedia" style="weight:50px">Bandung</option>
                        <option value="Tidak Bersedia" style="weight:50px">Bogor</option>
                        <option value="Tidak Bersedia" style="weight:50px">Subang</option>
                        <option value="Tidak Bersedia" style="weight:50px">Sukabumi</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">Siap Di Tempatkan Dimana Saja? * </label>
                    <select name = "ketersediaan" class="form-control" >
                        <option value="Bersedia" style="weight:50px">Ya</option>
                    <option value="Tidak Bersedia" style="weight:50px">Tidak</option>
                    </select>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-12">
                    <div >
                <div class="form-group">
                <label for="">Bersedia interview kapan?</label>
                <input class="form-control" type="date" name="tanggal_ketesediaan" value="2022-01-01" id="datetime" required>
                </div>
            </div>
            </div>
    </div>
            <div class="row">
            <div class="col-12 col-md-12">
                    <div id="inputFormRow">
                <div class="form-group">
                    <label for="">Jelaskan, Kenapa anda layak diundang interview? *</label> <br>
                    <input type="text" name="layak" class="form-control">
                </div>
            </div>
            </div>
            </div>

            {{-- <div class="row">
            <div class="col-12 col-md-6">
                    <div id="inputFormRow">
                <div class="form-group">
                    <label for="">Gaji yang diharapkan *</label>
                    <input type="text" name="pengajuan_gaji" id="currency-field" class="form-control"  data-type="currency" required>
                </div>
            </div>
            </div>
            <div class="col-12 col-md-4">
                <label for="" >Info Lowongan Dari</label>
                <select style="width: 735px;" name = "info_lowongan" class="form-control" >
                    <option value="LinkIdn" style="weight:50px">LinkIdn</option>
                    <option value="Jobstreet" style="weight:50px">Jobstreet</option>
                    <option value="Karir" style="weight:50px">Karir</option>
                    <option value="LokerId" style="weight:50px">LokerId</option>
                    <option value="OLX" style="weight:50px">OLX</option>
                    <option value="Sosial Media" style="weight:50px">Sosial Media</option>
                    <option value="Teman / Relasi" style="weight:50px">Teman / Relasi</option>
                </select>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <div id="inputFormRow">
                <div class="form-group">
                    <label for="" >Posisi Yang Dilamar *</label>
                <select style="width: 735px;" name = "Position_aplly" class="form-control" >
                    <option value="OPERATIONAL TRANSPORT" style="weight:50px">1. OPERATIONAL TRANSPORT</option>
                    <option value="SPV Transport" style="weight:50px">SPV Transport</option>
                    <option value="Koord. Transport" style="weight:50px">Koord. Transport</option>
                    <option value="Dispatcher" style="weight:50px">Dispatcher</option>
                    <option value="Data Entry" style="weight:50px">Data Entry</option>
                    <option value="Checker Plant" style="weight:50px">Checker Plant</option>
                    <option value="HR GA" style="weight:50px">2. HR GA</option>
                    <option value="Chif Security" style="weight:50px">Chif Security</option>
                    <option value="SPV GA" style="weight:50px">SPV GA</option>
                    <option value="Legal" style="weight:50px">Legal</option>
                    <option value="Koord. GA" style="weight:50px">Koord. GA</option>
                    <option value="Security" style="weight:50px">Security</option>
                    <option value="Staff Umum" style="weight:50px">Staff Umum</option>
                    <option value="3. Finance" style="weight:50px">3. FINANCE</option>
                    <option value="Cashier" style="weight:50px">Cashier</option>
                    <option value="MT Finance" style="weight:50px">MT Finance</option>
                    <option value="Staff AR" style="weight:50px">Staff AR</option>
                    <option value="Staff Accounting" style="weight:50px">Staff Accounting</option>
                    <option value="Staff Pajak" style="weight:50px">Staff Pajak</option>
                    <option value="Staff Payroll" style="weight:50px">Staff Payroll</option>
                    <option value="4. FLEET" style="weight:50px">4. FLEET</option>
                    <option value="SPV Fleet" style="weight:50px">SPV Fleet</option>
                    <option value="Koord. Fleet" style="weight:50px">Koord. Fleet</option>
                    <option value="Service Officer" style="weight:50px">Service Officer</option>
                    <option value="Mekanik Junior" style="weight:50px">Mekanik Junior</option>
                    <option value="Mekanik Senior" style="weight:50px">Mekanik Senior</option>
                    <option value="Petroll Man" style="weight:50px">Petroll Man</option>
                    <option value="Tyre Man" style="weight:50px">Tyre Man</option>
                    <option value="5. PROJECT" style="weight:50px">5. PROJECT</option>
                    <option value="PIC Project" style="weight:50px">PIC Project</option>
                    <option value="BD (Bussines Development)" style="weight:50px">BD (Bussines Development)</option>
                    <option value="6. WEREHOUSE" style="weight:50px">6. WEREHOUSE</option>
                    <option value="SPV Gudang" style="weight:50px">SPV Gudang</option>
                    <option value="Kepala Gudang" style="weight:50px">Kepala Gudang</option>
                    <option value="Leadership Gudang" style="weight:50px">Leadership Gudang</option>
                    <option value="Admin Gudang" style="weight:50px">Admin Gudang</option>
                    <option value="Operator Forklip" style="weight:50px">Operator Forklip</option>
                    <option value="Checker Gudang" style="weight:50px">Checker Gudang</option>
                    <option value="7. IT" style="weight:50px">7. IT</option>
                    <option value="SPV IT" style="weight:50px">SPV IT</option>
                    <option value="Senior Programmer" style="weight:50px">Senior Programmer</option>
                    <option value="Junior Programmer" style="weight:50px">Junior Programmer</option>
                    <option value="IT Support" style="weight:50px">IT Support</option>
                    <option value="8. Restaurant" style="weight:50px">8. RESTAURANT</option>
                    <option value="Waiters" style="weight:50px">Waiters</option>
                    <option value="Cook Helper" style="weight:50px">Cook Helper</option>
                    <option value="Staff Gudang Resto" style="weight:50px">Staff Gudang Resto</option>

                </select>
                </div>
            </div>
            </div>
            <div class="col-12 col-md-4">
                <label for="" >Bersedia di tempatkan dimana saja? *</label>
                <select style="width: 735px;" name = "ketersediaan" class="form-control" >
                    <option value="Bersedia" style="weight:50px">Ya</option>
                    <option value="Tidak Bersedia" style="weight:50px">Tidak</option>
                </select>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-12">
                    <div id="inputFormRow">
                <div class="form-group">
                    <label for="">Jelaskan, Kenapa anda layak diundang interview? *</label> <br>
                    <textarea  cols="188" rows="5" name="layak"></textarea>
                </div>
            </div>
            </div>
            </div> --}}


            {{-- <div class="row">
            <div class="col-12 col-md-15">
                <div class="form-group">
                    <label for="">Gaji yang diharapkan</label>
                    <input type="number" name="pengajuan_gaji" id="" class="form-control" >
                </div>
                <div class="row">
                <div class="col-12 col-md-3">
                    <label for="" >Info Lowongan Dari</label>
                    <br>
                        <select name="Info_lowongan" style="width: 1329px;">
                        <option value="LinkIdn" style="weight:50px">LinkIdn</option>
                        <option value="Jobstreet" style="weight:50px">Jobstreet</option>
                        <option value="Karir" style="weight:50px">Karir</option>
                        <option value="LokerId" style="weight:50px">LokerId</option>
                        <option value="OLX" style="weight:50px">OLX</option>
                        <option value="Sosial Media" style="weight:50px">Sosial Media</option>
                        <option value="Teman / Relasi" style="weight:50px">Teman / Relasi</option>
                    </select>
                </div>
            </div>
                <div class="row">
                <div class="col-12 col-md-4">
                <label for="" >Posisi Yang Dilamar</label>
                <br>
                    <select name="Position_aplly" style="width: 1329px;">
                    <option value="Programmer" style="weight:50px">Programmer</option>
                    <option value="GA" style="weight:50px">GA</option>
                    <option value="Finance" style="weight:50px">Finance</option>
                    <option value="Gudang" style="weight:50px">Gudang</option>
                    <option value="Driver" style="weight:50px">Driver</option>
                    <option value="Helper" style="weight:50px">Helper</option>
                    <option value="IT Support" style="weight:50px">IT Support</option>
                </select>
                </div>
            </div>
            <div class="row">

            <div class="col-12 col-md-4">
                <label for="" >Bersedia di tempatkan dimana saja?</label>
                <br>
                    <select name="ketersediaan" style="width: 1329px;">
                <option value="Bersedia" style="weight:50px">Ya</option>
                <option value="Tidak Bersedia" style="weight:50px">Tidak</option>
                </select>
                </div>
            </div> --}}

            <center>
            <label for="" >Pas Foto Terbaru</label>
                    <br>
                    <div class="form-group">
                        <input  type="file" name="file_path" id="file" onchange="return validasiEkstensi()" >
                    </div>
                    <div id="feedback">
            </center>
            <br>
            <center>
               <label for="" >CV / Resumen </label>
                    <br>
                    <div class="form-group">
                        <input type="file" name="file_cv" id="file2" onchange="return validasiEkstensi2()">
                    </div>
                    <div id="feedback2">
            </center>
            <br>
            <center>
                <button class="btn btn-success" type="submit" name="send">Kirim Lamaran</button>
            </center>
        </div>
        <br>
        <center>
        </center>





        <script>
            const fileUploader = document.getElementById('file');
                const feedback = document.getElementById('feedback');

                fileUploader.addEventListener('change', (event) => {
                const file = event.target.files[0];
                console.log('file', file);

                const size = file.size;
                console.log('size', size);
                let msg = '';

                if (size > 1024 * 1024) {
                    msg = `<span style="color:red;">Ukuran maksimal 1MB. kamu telah upload dengan ukuran ${returnFileSize(size)}</span>`;
                } else {
                    msg = `<span style="color:green;">  ${returnFileSize(size)} berhasil di upload. </span>`;
                }
                feedback.innerHTML = msg;
                });

                function returnFileSize(number) {
                if(number < 1024) {
                    return number + 'bytes';
                } else if(number >= 1024 && number < 1048576) {
                    return (number/1024).toFixed(2) + 'KB';
                } else if(number >= 1048576) {
                    return (number/1048576).toFixed(2) + 'MB';
                }
                }
            </script>

        <script>
                        function validasiEkstensi(){
                            var inputFile = document.getElementById('file');
                            var pathFile = inputFile.value;
                            var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
                            if(!ekstensiOk.exec(pathFile)){
                                alert('Silakan upload file dengan ekstensi .jpeg/.jpg/.png');
                                inputFile.value = '';
                                return false;
                            }else{
                                // Preview gambar
                                if (inputFile.files && inputFile.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById('preview').innerHTML = '<img src="'+e.target.result+'" style="height:500px"/>';
                                    };
                                    reader.readAsDataURL(inputFile.files[0]);
                                }
                            }
                        }
                        </script>

                    <script>
                        function validasiEkstensi2(){
                            var inputFile = document.getElementById('file2');
                            var pathFile = inputFile.value;
                            var ekstensiOk = /(\.pdf)$/i;
                            if(!ekstensiOk.exec(pathFile)){
                                alert('Silakan upload file dengan ekstensi .pdf');
                                inputFile.value = '';
                                return false;
                            }else{
                                // Preview gambar
                                if (inputFile.files && inputFile.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById('preview').innerHTML = '<img src="'+e.target.result+'" style="height:500px"/>';
                                    };
                                    reader.readAsDataURL(inputFile.files[0]);
                                }
                            }
                        }
                        </script>
        <script>
        function addRow() {
            var template = document.querySelector('#rowTemplate'),
            tbl = document.querySelector('#myTable'),
            td_slNo = template.content.querySelectorAll("tr")[0],
            tr_count = tbl.rows.length;
            td_slNo.textContent = tr_count;
            var clone = document.importNode(template.content, true);
            tbl.appendChild(clone);
        }
        </script>
        <script>
            function addRows() {
                var template = document.querySelector('#rowTemplates'),
                tbl = document.querySelector('#myTables'),
                td_slNo = template.content.querySelectorAll("td")[0],
                tr_count = tbl.rows.length;
                td_slNo.textContent = tr_count;
                var clone = document.importNode(template.content, true);
                tbl.appendChild(clone);
            }
            </script>
            <script>
                function addRowss() {
                    var template = document.querySelector('#rowTemplatess'),
                    tbl = document.querySelector('#myTabless'),
                    td_slNo = template.content.querySelectorAll("td")[0],
                    tr_count = tbl.rows.length;

                    td_slNo.textContent = tr_count;
                    var clone = document.importNode(template.content, true);
                    tbl.appendChild(clone);
                }
                </script>
                <script>
                    function addRowssosmed() {
                        var template = document.querySelector('#rowTemplatesosmed'),
                        tbl = document.querySelector('#myTables_sosmed'),
                        td_slNo = template.content.querySelectorAll("td")[0],
                        tr_count = tbl.rows.length;

                        td_slNo.textContent = tr_count;
                        var clone = document.importNode(template.content, true);
                        tbl.appendChild(clone);
                    }
                    </script>
                    <script>
                        function addRowskeluarga() {
                            var template = document.querySelector('#rowTemplateskeluarga'),
                            tbl = document.querySelector('#myTables_keluarga'),
                            td_slNo = template.content.querySelectorAll("td")[0],
                            tr_count = tbl.rows.length;

                            td_slNo.textContent = tr_count;
                            var clone = document.importNode(template.content, true);
                            tbl.appendChild(clone);
                        }
                        </script>

                    <script>
                        var rupiah = document.getElementById("rupiah");
                        rupiah.addEventListener("keyup", function(e) {
                        // tambahkan 'Rp.' pada saat form di ketik
                        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                        rupiah.value = formatRupiah(this.value, "Rp. ");
                        });

                        /* Fungsi formatRupiah */
                        function formatRupiah(angka, prefix) {
                        var number_string = angka.replace(/[^,\d]/g, "").toString(),
                            split = number_string.split(","),
                            sisa = split[0].length % 3,
                            rupiah = split[0].substr(0, sisa),
                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                        // tambahkan titik jika yang di input sudah menjadi angka ribuan
                        if (ribuan) {
                            separator = sisa ? "." : "";
                            rupiah += separator + ribuan.join(".");
                        }

                        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
                        }

                    </script>

                    <script >
                        // Jquery Dependency

                        $("input[data-type='currency']").on({
                            keyup: function() {
                            formatCurrency($(this));
                            },
                            blur: function() {
                            formatCurrency($(this), "blur");
                            }
                        });


                        function formatNumber(n) {
                        // format number 1000000 to 1,234,567
                        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        }


                        function formatCurrency(input, blur) {
                        // appends $ to value, validates decimal side
                        // and puts cursor back in right position.

                        // get input value
                        var input_val = input.val();

                        // don't validate empty input
                        if (input_val === "") { return; }

                        // original length
                        var original_len = input_val.length;

                        // initial caret position
                        var caret_pos = input.prop("selectionStart");

                        // check for decimal
                        if (input_val.indexOf(".") >= 0) {

                            // get position of first decimal
                            // this prevents multiple decimals from
                            // being entered
                            var decimal_pos = input_val.indexOf(".");

                            // split number by decimal point
                            var left_side = input_val.substring(0, decimal_pos);
                            var right_side = input_val.substring(decimal_pos);

                            // add commas to left side of number
                            left_side = formatNumber(left_side);

                            // validate right side
                            right_side = formatNumber(right_side);

                            // On blur make sure 2 numbers after decimal
                            if (blur === "blur") {
                            right_side += "00";
                            }

                            // Limit decimal to only 2 digits
                            right_side = right_side.substring(0, 2);

                            // join number by .
                            input_val = "Rp" + left_side + "." + right_side;

                        } else {
                            // no decimal entered
                            // add commas to number
                            // remove all non-digits
                            input_val = formatNumber(input_val);
                            input_val = "Rp," + input_val;

                            // final formatting
                            if (blur === "blur") {
                            input_val += ".00";
                            }
                        }

                        // send updated string to input
                        input.val(input_val);

                        // put caret back in the right position
                        var updated_len = input_val.length;
                        caret_pos = updated_len - original_len + caret_pos;
                        input[0].setSelectionRange(caret_pos, caret_pos);
                        }
                    </script>
                    <script>
                        var span = $('<span>').css('display','inline-block')
                        .css('word-break','break-all').appendTo('body').css('visibility','hidden');
                        function initSpan(textarea){
                        span.text(textarea.text())
                            .width(textarea.width())
                            .css('font',textarea.css('font'));
                        }
                        $('textarea').on({
                            input: function(){
                            var text = $(this).val();
                            span.text(text);
                            $(this).height(text ? span.height() : '1.1em');
                            },
                            focus: function(){
                            initSpan($(this));
                            },
                            keypress: function(e){
                                if(e.which == 13) e.preventDefault();
                            }
                        });
                    </script>

        @stop







