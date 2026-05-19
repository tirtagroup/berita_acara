<html>

{{--  @extends('layouts/layoutMaster')  --}}

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

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{--  @if (Auth::check())
  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class='bx bx-power-off me-2'></i>
    <span class="align-middle">Logout</span>
  </a>
<form  method="POST" id="logout-form" action="{{ route('logout') }}">
  @csrf
</form>
@endif  --}}

<title>
    Berita Acara
</title>
</head>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<div id="card" class="container">
    <center>
    {{--  <div class="logo"><img src="https://hgs.co.id/wp-content/uploads/2020/06/LOGO-HGS-scaled.jpg" style="width:100px;height:70px;" > </div>  --}}
    </center>
        {{-- notifikasi form validasi --}}
		@if ($errors->has('file'))
		<span class="invalid-feedback" role="alert">
			<strong>{{ $errors->first('file') }}</strong>
		</span>
		@endif

		{{-- notifikasi sukses --}}
		@if ($sukses = Session::get('sukses'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $sukses }}</strong>
		</div>
		@endif

<center><h2>Berita Acara</h2></center>


<body>
    <div class="card-body">
        @if (count($errors) > 0)
        <div class="alert alert-danger">analuost
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
        <form onsubmit="return validateForm()"  action="/input_berita_acara_data" method="post" enctype="multipart/form-data">
        @csrf
            <fieldset   class="other" id="myDIV">

    {{--  <button type="button" class="btn btn-info">Go To Request Revisi</button>  --}}
    <a class="btn btn-info" href="/home_ba" role="button">Home</a>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Code</label>
                 <input type="text" name="Tr_BA_Code" id="" class="form-control" value="{{ $code_bass }}" readonly>
                <!--<input type="text" name="Tr_BA_Code" id="" class="form-control" placeholder="Auto Number" readonly>-->
            </div>
        </div>
        <br>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Date Input</label>
                <input type="text" name="rec_datecreated"  id="" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly>
            </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              <label for="">Date Peristiwa</label>
              <input type="date" name="Date_BA"  id="" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required>
          </div>
      </div>
         <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Company</label>
                <select class="form-control" name="Company_Code" required>
                    <option value="">-- Pilih --</option>
                  @foreach ($company as $pt)
                      <option value="{{$pt->description}}">
                          {{$pt->description}}
                  @endforeach
              </select>
                    <!--<input type="text" name="Company_Code" id="" class="form-control" value="{{$user->ms_company}}" readonly>-->
            </div>
        </div>
        <br>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Lokasi</label>
                    <select class="form-control select2" name="Location_Code" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($lokasi as $branch)
                            <option value="{{$branch->lokasi_desc}}">
                                {{$branch->lokasi_desc}}
                        @endforeach
                    </select>
                    <!--<input type="text" name="Location_Code" id="" class="form-control" value="{{$user->ms_branch}}" readonly>-->
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Admin *</label>
                <input type="text" name="BA_Admin" id="" class="form-control" value="{{$user->name}}" readonly>
            </div>
        </div>
        <br>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Divisi *</label>
                <input type="text" name="Admin_Div" id="" class="form-control" value="{{$user->ms_divisi}}" readonly>
            </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              <label for="">Indikasi Fraud ? * <em>(perhatikan kasusnya, indikasi fraud atau bukan)</em></label>
              <select name = "ms_fraud" class="form-control"  id="ms_fraud" required >
                <option value="" style="weight:50px">Pilih Status Fraud</option>
                <option value="1" style="weight:50px">Iya</option>
                <option value="0" style="weight:50px">Tidak</option>
                  <!--@foreach ($fraud as $frauds)-->
                  <!--    <option value="{{$frauds->ms_fraud_desc}}">-->
                  <!--        {{$frauds->ms_fraud_desc}}-->
                  <!--@endforeach-->
              </select>
          </div>
      </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                 <label for="">Kategori *</label>
                  <select name="Category_Code" class="form-control" id="Category_Code" required>
                      <option value="Pilih Kategori" style="font-weight: bold;">Pilih Kategori</option>
                      <option value="Pelanggaran SOP">Pelanggaran SOP</option>
                      <option value="Kehilangan">Kehilangan</option>
                      <option value="Kerusakan">Kerusakan</option>
                      <option value="Perubahan SOP">Perubahan SOP</option>
                      <option value="Pembelian Barang">Pembelian Barang</option>
                  </select>
              <p id="categoryError" style="color: red; display: none;">Silakan pilih kategori!.</p>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Kasus *</label>
                   <select name = "jenis" class="form-control select2"  id="jenis" disabled>
                    <!--<option value="">Pilih Kategori Untuk Membuka Kasus BA</option>-->
                    <option value="">-- Pilih --</option>
                      @foreach ($jenis as $jenises)
                          <option value="{{$jenises->description}}">
                              {{$jenises->description}}
                      @endforeach
                  </select>
            </div>
        </div>
         <div class="col-12 col-md-12">
          <div class="form-group">
              <label for="">Detail Kasus *</label>
                 <select name = "ms_kasus" class="form-control select2" required >
                     <option value="">-- Pilih --</option>
                    @foreach ($ms_kasus as $case)
                        <option value="{{$case->description}}">
                            {{$case->description}}
                    @endforeach
                </select>
          </div>
      </div>
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label for="">Note *</label>
                <input type="text" name="BA_Note"  id="" class="form-control" placeholder ="Enter Note" required>
            </div>
        </div>
        <div class="col-md-12">
          <label class="form-label" for="collapsible-phone">Kronologi</label>
          <div class="form-group">
            <textarea  cols="142" rows="10" name="kronlogi" required></textarea>
          </div>
        </div>
       </div>
       <table class="table table-bordered" id="journal-entrees">
        <thead>
          <tr>
            <th>Nama Pelaku</th>
            <th>Divisi Pelaku</th>
          </tr>
        </thead>
        <tbody class="row-body">
        <tr class='entree-row'>

          <td>
                <select name = "User_Code" id="cb_pelaku" class="form-control select2" required>
                    @foreach ($users as $pelakunya)
                        <option value="">-- Pilih --</option>
                        <option value="{{$pelakunya->id}}" data-name="{{$pelakunya->emp_id}}" data-divisi="{{$pelakunya->divisi}}">
                        {{$pelakunya->id}} - {{$pelakunya->emp_id}}
                    @endforeach
                </select>
              <!--<input name="User_Code" class="form-control"  type="text"   required/>-->
          </td>
          <td>
              <input type="text" class="form-control" id="Division_Code" name ="Division_Code" disabled>
              <!-- <select name = 'Division_Code'class="form-control" id="single3" required>-->
              <!--  <option value="" style="weight:50px">Pilih Divisi Pelaku</option>-->
              <!--  <option value="Approval_External" style="weight:50px">Approval_External</option>-->
              <!--  <option value="Approval_internal" style="weight:50px">Approval_internal</option>-->
              <!--  <option value="Account Renable" style="weight:50px">Account Renable</option>-->
              <!--  <option value="Audit" style="weight:50px">Audit</option>-->
              <!--  <option value="Business Development" style="weight:50px">Business Development</option>-->
              <!--  <option value="Cashier" style="weight:50px">Cashier</option>-->
              <!--  <option value="Checker Plant" style="weight:50px">Checker Plant</option>-->
                <!--<option value="Coordinator" style="weight:50px">Coordinator</option>-->
              <!--  <option value="Data Entry" style="weight:50px">Data Entry</option>-->
              <!--  <option value="Direktur" style="weight:50px">Direktur</option>-->
              <!--  <option value="Dispatcher" style="weight:50px">Dispatcher</option>-->
              <!--  <option value="Driver" style="weight:50px">Driver</option>-->
              <!--  <option value="General Manager" style="weight:50px">General Manager</option>-->
              <!--  <option value="Gudang" style="weight:50px">Gudang</option>-->
              <!--  <option value="helper" style="weight:50px">helper</option>-->
              <!--  <option value="HR" style="weight:50px">HR</option>-->
              <!--  <option value="IT Support" style="weight:50px">IT Support</option>-->
              <!--  <option value="IT Jaringan" style="weight:50px">IT Jaringan</option>-->
              <!--  <option value="Junior Mekanik" style="weight:50px">Junior Mekanik</option>-->
              <!--  <option value="Kepala Gudang" style="weight:50px">Kepala Gudang</option>-->
              <!--  <option value="Magang" style="weight:50px">Magang</option>-->
              <!--  <option value="Manager" style="weight:50px">Manager</option>-->
              <!--  <option value="Manager Finance" style="weight:50px">Manager Finance</option>-->
              <!--  <option value="Mechanic" style="weight:50px">Mechanic</option>-->
              <!--  <option value="Mechanic Group" style="weight:50px">Mechanic Group</option>-->
              <!--  <option value="Mechanic Supervisor" style="weight:50px">Mechanic Supervisor</option>-->
              <!--  <option value="Motoris" style="weight:50px">Motoris</option>-->
                <!--<option value="Operator" style="weight:50px">Operator</option>-->
              <!--  <option value="Petrolman" style="weight:50px">Petrolman</option>-->
              <!--  <option value="Pic Project" style="weight:50px">Pic Project</option>-->
              <!--  <option value="IT Programmer" style="weight:50px">IT Programmer</option>-->
              <!--  <option value="Purchasing" style="weight:50px">Purchasing</option>-->
              <!--  <option value="Quality Control" style="weight:50px">Quality Control</option>-->
              <!--  <option value="Sales" style="weight:50px">Sales</option>-->
              <!--  <option value="Sales Taking Order" style="weight:50px">Sales Taking Order</option>-->
              <!--  <option value="Security" style="weight:50px">Security</option>-->
              <!--  <option value="Senior Mekanik" style="weight:50px">Senior Mekanik</option>-->
              <!--  <option value="Service Officer" style="weight:50px">Service Officer</option>-->
              <!--  <option value="Staff Finance" style="weight:50px">Staff Finance</option>-->
              <!--  <option value="Staff Ga" style="weight:50px">Staff Ga</option>-->
              <!--  <option value="Staff Senior Petrolman" style="weight:50px">Staff Senior Petrolman</option>-->
                <!--<option value="Supervisor" style="weight:50px">Supervisor</option>-->
              <!--  <option value="Supervisor Fleet" style="weight:50px">Supervisor Fleet</option>-->
                <!--<option value="Umum" style="weight:50px">Umum</option>-->
              <!--  <option value="SO Fleet" style="weight:50px">SO Fleet</option>-->
              <!--  <option value="Petrollman" style="weight:50px">Petrollman</option>-->
              <!--  <option value="Service Officer" style="weight:50px">Service Officer</option>-->
              <!--  <option value="Koord. Service Officer" style="weight:50px">Koord. Service Officer</option>-->
              <!--</select>-->
          </td>
        </tr>
        {{--  <tr class="button-row">
          <td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="6"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
        </tr>  --}}
      </tbody>
    </table>

            <center>
            <label for="" >Dokumen Pendukung</label>
                    <br>
                    <div class="form-group">
                        <input  type="file" name="file_path" id="file" onchange="return validasiEkstensi()" >
                    </div>
                    <div id="feedback">
            </center>
            <br>
            <center>
               <label for="" >Dokumen Pendukung Tambahan</label>
                    <br>
                    <div class="form-group">
                        <input type="file" name="file_path2" id="file2" onchange="return validasiEkstensi2()">
                    </div>
                    <div id="feedback2">
            </center>
            <br>
            <center>
                <button class="btn btn-success" type="submit" name="send">Confirm</button>
            </center>
        </div>
        <br>
        <center>
        </center>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- jQuery (diperlukan oleh Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "-- Pilih --",
                    allowClear: true
                });
            });
        </script>

        <script>
            $('#cb_pelaku').on('change', function () {
                var selectedOption = $(this).find('option:selected'); // Ambil option yang dipilih
                var empId = selectedOption.data('name');              // Ambil emp_id dari data-name
                var divisi = selectedOption.data('divisi');           // Ambil divisi dari data-divisi

                $('#Division_Code').val(divisi);
                // $('#cb_pelaku option:selected').text(empId);
                // selectedOption.text(empId);
            });
        </script>

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

                    <script>
                      var rupiah2 = document.getElementById("rupiah2");
                      rupiah2.addEventListener("keyup", function(e) {
                      // tambahkan 'Rp.' pada saat form di ketik
                      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                      rupiah2.value = formatRupiah(this.value, "Rp. ");
                      });

                      /* Fungsi formatRupiah */
                      function formatRupiah(angka, prefix) {
                      var number_string = angka.replace(/[^,\d]/g, "").toString(),
                          split = number_string.split(","),
                          sisa = split[0].length % 3,
                          rupiah2 = split[0].substr(0, sisa),
                          ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                      // tambahkan titik jika yang di input sudah menjadi angka ribuan
                      if (ribuan) {
                          separator = sisa ? "." : "";
                          rupiah2 += separator + ribuan.join(".");
                      }

                      rupiah2 = split[1] != undefined ? rupiah2 + "," + split[1] : rupiah2;
                      return prefix == undefined ? rupiah2 : rupiah2 ? "Rp. " + rupiah2 : "";
                      }

                  </script>

                  <script>
                    var rupiah3 = document.getElementById("rupiah3");
                    rupiah3.addEventListener("keyup", function(e) {
                    // tambahkan 'Rp.' pada saat form di ketik
                    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                    rupiah3.value = formatRupiah(this.value, "Rp. ");
                    });

                    /* Fungsi formatRupiah */
                    function formatRupiah(angka, prefix) {
                    var number_string = angka.replace(/[^,\d]/g, "").toString(),
                        split = number_string.split(","),
                        sisa = split[0].length % 3,
                        rupiah3 = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    // tambahkan titik jika yang di input sudah menjadi angka ribuan
                    if (ribuan) {
                        separator = sisa ? "." : "";
                        rupiah3 += separator + ribuan.join(".");
                    }

                    rupiah3 = split[1] != undefined ? rupiah3 + "," + split[1] : rupiah3;
                    return prefix == undefined ? rupiah3 : rupiah3 ? "Rp. " + rupiah3 : "";
                    }

                </script>

                <script>
                  var rupiah4 = document.getElementById("rupiah4");
                  rupiah4.addEventListener("keyup", function(e) {
                  // tambahkan 'Rp.' pada saat form di ketik
                  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                  rupiah4.value = formatRupiah(this.value, "Rp. ");
                  });

                  /* Fungsi formatRupiah */
                  function formatRupiah(angka, prefix) {
                  var number_string = angka.replace(/[^,\d]/g, "").toString(),
                      split = number_string.split(","),
                      sisa = split[0].length % 3,
                      rupiah4 = split[0].substr(0, sisa),
                      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                  // tambahkan titik jika yang di input sudah menjadi angka ribuan
                  if (ribuan) {
                      separator = sisa ? "." : "";
                      rupiah4 += separator + ribuan.join(".");
                  }

                  rupiah4 = split[1] != undefined ? rupiah4 + "," + split[1] : rupiah4;
                  return prefix == undefined ? rupiah4 : rupiah4 ? "Rp. " + rupiah4 : "";
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

                    <style>
                        h5
                        {
                            color: red;
                        }
                    </style>


                    <script>
                      function checkMe(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe2(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck2").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck2").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe3(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck3").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck3").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe4(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck4").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck4").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe5(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck5").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck5").style.display = "none";
                      }

                      }
                    </script>

                    <script>
                      function checkMe6(selected)
                      {
                      if(selected)
                      {
                      document.getElementById("divcheck6").style.display = "";
                      }
                      else
                      {
                      document.getElementById("divcheck6").style.display = "none";
                      }

                      }
                    </script>
                    
                    
                    <script>
                      document.getElementById('Category_Code').addEventListener('change', function() {
                          var opsiPertama = this.value;
                          var opsiKedua = document.getElementById('jenis');

                          if (opsiPertama !== '') {
                              opsiKedua.disabled = false; 
                          } else {
                              opsiKedua.disabled = true; 
                              opsiKedua.selectedIndex = 0; 
                          }
                      });
                  </script>
                  
                   <script>
                        function validateForm() {
                          var selectedOption = document.getElementById('single3').value;
                    
                          if (selectedOption === "") {
                            alert("Silakan pilih divisi pelaku sebelum confirm berita acara.");
                            return false; // Prevent form submission
                          }
                    
                          // Lanjutkan dengan mengirim formulir jika validasi berhasil
                          return true;
                        }
                      </script>
                      
                       <script>
                    function validateForm() {
                        var selectedCategory = document.getElementById("Category_Code").value;
                        var categoryError = document.getElementById("categoryError");

                        if (selectedCategory === "Pilih Kategori") {
                            categoryError.style.display = "block";
                            return false; // Mencegah pengiriman formulir jika kategori tidak valid
                        } else {
                            categoryError.style.display = "none";
                            return true;
                        }
                    }

                    // Menambahkan event listener pada peristiwa submit pada formulir
                    document.getElementById("yourFormId").addEventListener("submit", function (event) {
                        if (!validateForm()) {
                            event.preventDefault(); // Mencegah pengiriman formulir jika validasi gagal
                        }
                    });
                </script>

  </body>
</html>


        {{--  @stop  --}}







