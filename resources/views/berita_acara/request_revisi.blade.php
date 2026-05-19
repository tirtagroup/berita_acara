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
<form method="POST" id="logout-form" action="{{ route('logout') }}">
  @csrf
</form>
@endif  --}}

<title>
    Request
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
		@if(session('message'))
    <div class="notification show">
        {{ session('message') }}
    </div>
@endif

<center><h2>Request Revisi</h2></center>

<body>
        <form  action="/request_revisi" method="post" enctype="multipart/form-data">
        @csrf
            <fieldset   class="other" id="myDIV">

{{--  <a class="btn btn-info" href="/input_berita_acara" role="button">Go To Berita Acara</a>  --}}
<a class="btn btn-info" href="/home_ba" role="button">Home</a>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Code</label>
                <input type="text" name="Tr_BA_Code" id="" class="form-control" value="{{ $code_bas }}" readonly>
                {{--  <input type="text" name="Tr_BA_Code" id="" class="form-control" placeholder="Auto Number" readonly>  --}}
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Date Input</label>
                <input type="text" name="created_at"  id="" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly>
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
              <!--  <select class="form-control" name="Company_Code" >-->
              <!--    @foreach ($company as $pt)-->
              <!--        <option value="{{$pt->description}}">-->
              <!--            {{$pt->description}}-->
              <!--    @endforeach-->
              <!--</select>-->
                    <input type="text" name="Company_Code" id="" class="form-control" value="{{$user->ms_company}}" readonly>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Lokasi</label>
                    <!--<select class="form-control" name="Location_Code" >-->
                    <!--    @foreach ($lokasi as $branch)-->
                    <!--        <option value="{{$branch->lokasi_desc}}">-->
                    <!--            {{$branch->lokasi_desc}}-->
                    <!--    @endforeach-->
                    <!--</select>-->
                    <input type="text" name="Location_Code" id="" class="form-control" value="{{$user->ms_branch}}" readonly>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">User Input *</label>
                <input type="text" name="BA_Admin" id="" class="form-control" value="{{$user->username}}" readonly>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Divisi  *</label>
                  <input type="text" name="Admin_Div" id="" class="form-control" value="{{$user->sub_divisi}}" readonly required>
            </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="form-group">
              <label for="">Pelaku *</label>
              <select name = "User_Code" id="cb_pelaku" class="form-control select2" required>
                      <option value="">-- Pilih --</option>
                      @foreach ($users as $pelakunya)
                          <option value="{{$pelakunya->id}}" data-name="{{$pelakunya->emp_id}}" data-divisi="{{$pelakunya->divisi}}">
                          {{$pelakunya->id}} - {{$pelakunya->emp_id}}
                      @endforeach
             </select>
              <!--<input type="text" name="User Code"  id="" class="form-control" placeholder ="Masukan Nama Pelaku" required>-->
          </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Divisi Pelaku *</label>
            <input type="text" class="form-control" id="Division_Code" name ="Division_Code" disabled>
            <!--  <select name = 'Division_Code'class="form-control" required>-->
            <!--        <option value="Approval_External" style="weight:50px">Approval_External</option>-->
            <!--        <option value="Approval_internal" style="weight:50px">Approval_internal</option>-->
            <!--        <option value="Account Renable" style="weight:50px">Account Renable</option>-->
            <!--        <option value="Audit" style="weight:50px">Audit</option>-->
            <!--        <option value="Business Development" style="weight:50px">Business Development</option>-->
            <!--        <option value="Cashier" style="weight:50px">Cashier</option>-->
            <!--        <option value="Checker Plant" style="weight:50px">Checker Plant</option>-->
                    <!--<option value="Coordinator" style="weight:50px">Coordinator</option>-->
            <!--        <option value="Data Entry" style="weight:50px">Data Entry</option>-->
            <!--        <option value="Direktur" style="weight:50px">Direktur</option>-->
            <!--        <option value="Dispatcher" style="weight:50px">Dispatcher</option>-->
            <!--        <option value="Driver" style="weight:50px">Driver</option>-->
            <!--        <option value="General Manager" style="weight:50px">General Manager</option>-->
            <!--        <option value="Gudang" style="weight:50px">Gudang</option>-->
            <!--        <option value="helper" style="weight:50px">helper</option>-->
            <!--        <option value="HR" style="weight:50px">HR</option>-->
            <!--        <option value="IT Support" style="weight:50px">IT Support</option>-->
            <!--        <option value="IT Jaringan" style="weight:50px">IT Jaringan</option>-->
            <!--        <option value="IT Programmer" style="weight:50px">IT Programmer</option>-->
            <!--        <option value="Junior Mekanik" style="weight:50px">Junior Mekanik</option>-->
            <!--        <option value="Kepala Gudang" style="weight:50px">Kepala Gudang</option>-->
            <!--        <option value="Last Mile" style="weight:50px">Last Mile</option>-->
            <!--        <option value="Magang" style="weight:50px">Magang</option>-->
            <!--        <option value="Manager" style="weight:50px">Manager</option>-->
            <!--        <option value="Manager Finance" style="weight:50px">Manager Finance</option>-->
            <!--        <option value="Mechanic" style="weight:50px">Mechanic</option>-->
            <!--        <option value="Mechanic Group" style="weight:50px">Mechanic Group</option>-->
            <!--        <option value="Mechanic Supervisor" style="weight:50px">Mechanic Supervisor</option>-->
            <!--        <option value="Operational Manager" style="weight:50px">Operational Manager</option>-->
            <!--        <option value="Petrolman" style="weight:50px">Petrolman</option>-->
            <!--        <option value="Pic Project" style="weight:50px">Pic Project</option>-->
            <!--        <option value="Purchasing" style="weight:50px">Purchasing</option>-->
            <!--        <option value="Quality Control" style="weight:50px">Quality Control</option>-->
            <!--        <option value="Sales" style="weight:50px">Sales</option>-->
            <!--        <option value="Sales Taking Order" style="weight:50px">Sales Taking Order</option>-->
            <!--        <option value="Security" style="weight:50px">Security</option>-->
            <!--        <option value="Senior Mekanik" style="weight:50px">Senior Mekanik</option>-->
            <!--        <option value="Service Officer" style="weight:50px">Service Officer</option>-->
            <!--        <option value="Staff Finance" style="weight:50px">Staff Finance</option>-->
            <!--        <option value="Staff Ga" style="weight:50px">Staff Ga</option>-->
            <!--        <option value="Staff Senior Petrolman" style="weight:50px">Staff Senior Petrolman</option>-->
                    <!--<option value="Supervisor" style="weight:50px">Supervisor</option>-->
            <!--        <option value="Supervisor Fleet" style="weight:50px">Supervisor Fleet</option>-->
                    <!--<option value="Umum" style="weight:50px">Umum</option>-->
            <!--        <option value="SO Fleet" style="weight:50px">SO Fleet</option>-->
            <!--        <option value="Petrollman" style="weight:50px">Petrollman</option>-->
            <!--        <option value="Service Officer" style="weight:50px">Service Officer</option>-->
            <!--        <option value="Koord. Service Officer" style="weight:50px">Koord. Service Officer</option>-->
            <!--</select>-->
        </div>
    </div>
        {{-- <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Kategori *</label>
                     <select name = "Category_Code" class="form-control" required>
                        <!--<option value="Salah Isi Dokumen" style="weight:50px">Salah Isi Dokumen</option>-->
                        <option value="Kesalahan Sistem" style="weight:50px">Kesalahan Sistem</option>
                        <option value="Kesalahan Operator" style="weight:50px">Kesalahan Operator</option>
                        <option value="Temuan" style="weight:50px">Temuan</option>
                     </select>
            </div>
        </div> --}}
         <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Kasus *</label>
                   <select name = "jenis" class="form-control" required>
                       <option value="">-- Pilih --</option>
                        <option value="Kesalahan Sistem" style="weight:50px">Kesalahan Sistem</option>
                        <option value="Kesalahan Operator" style="weight:50px">Kesalahan Operator</option>
                        <option value="Temuan" style="weight:50px">Temuan</option>
                      @foreach ($jenis as $jenises)
                          <option value="{{$jenises->description}}">
                              {{$jenises->description}}
                      @endforeach
                  </select>
            </div>
        </div>
         <div class="col-12 col-md-6">
          <div class="form-group">
              <label for="">Detail Kasus *</label>
                 <select name = "ms_kasus" class="form-control select2" required>
                     <option value="">-- Pilih --</option>
                    @foreach ($ms_kasus as $case)
                        <option value="{{$case->description}}">
                            {{$case->description}}
                    @endforeach
                </select>
          </div>
      </div>
       
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Note *</label>
                <input type="text" name="BA_Note"  id="" class="form-control" placeholder ="Enter Note" required>
            </div>
        </div>
         <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Kronologi</label>
                <div class="form-group">
                  <textarea name="kronlogi" class="form-control" id="" rows="10" placeholder="" required ></textarea>
                </div>
         </div>
    </div>


    <table class="table table-bordered" id="myTable">
      <thead>
        <tr>
          <th>Code Doc.</th>
        </tr>
      </thead>
      <tbody>
        <tr class='entree-row'>
            <td>
                <input name="code_doc" class="form-control"  type="text"  placeholder="Enter Code Transaction" required/>
            </td>
  </table>

                    <table class="table table-bordered" id="dynamic-table">
                          <thead>
                            <tr>
                              <th>Kolom Salah</th>
                              <th>Value Salah</th>
                              <th>Kolom Benar</th>
                              <th>Value Benar</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class='entree-row'>
                                <td>
                                    <input name="field_salah[]" class="form-control"  type="text"   required/>
                                </td>
                                <td>
                                    <input  name="value_salah[]" class="form-control"  type="text"   required/>
                                </td>
                                <td>
                                    <input  name="field_benar[]" class="form-control"  type="text"   required/>
                                </td>
                                <td>
                                    <input  name="value_benar[]" class="form-control"  type="text"   required/>
                                </td>
                                <td><button type="button" class="remove-row-btn btn btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                            </tr>
                            {{-- <tr class="button-row">
                              <td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="5"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
                            </tr> --}}
                          </tbody>
                      </table>
                      <button type="button" class="add-row-btn btn btn-info" onclick="addRow()">Add Row</button>
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

        function newRow() {
          var tr_s = "<tr name='entree-row' class='entree-row '>";
          var tr_btn_s = "<tr class='button-row'>";
          var tr_e = "</tr>";
          var account_in_s = '<td><input name="code_doc[]" class="form-control"  type="text"   required/></td> ';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var debit_in = '<td><input   onkeyUp="update_in(\'debit_in\');" name="field_salah[]" class="form-control"  type="text"  ></td>';
          var credit_in = '<td><input  onkeyUp="update_in(\'credit_in\');" name="value_salah[]" class="form-control"  type="text"  ></td>';
          var t1 = '<td><input name="field_benar[]" class="form-control"  type="text"   required/></td> ';
          var t2 = '<td><input name="value_benar[]" class="form-control"  type="text"   required/></td> ';
          var add_button = '<td style="text-align:center;" colspan="5"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+account_in_s+select_account+select_account_e+debit_in+credit_in+t1+t2+remove_button+tr_e+tr_btn_s+add_button+tr_e);
          ///enables focus highlight on new rows///
          inputhighlight();
        };

       </script>

       <script>
        function addRow() {
          var table = document.getElementById("dynamic-table").getElementsByTagName('tbody')[0];
          var newRow = table.insertRow(table.rows.length);
          var nama1 = newRow.insertCell(0);
          var nama2 = newRow.insertCell(1);
          var nama3 = newRow.insertCell(2);
          var nama4 = newRow.insertCell(3);
          var actionCell = newRow.insertCell(4);

          nama1.innerHTML = '<input name="field_salah[]" class="form-control"  type="text"   required/>';
          nama2.innerHTML = '<input  name="value_salah[]" class="form-control"  type="text"   required/>';
          nama3.innerHTML = '<input  name="field_benar[]" class="form-control"  type="text"   required/>';
          nama4.innerHTML = '<input  name="value_benar[]" class="form-control"  type="text"   required/>';
          actionCell.innerHTML = '<button type="button" class="remove-row-btn btn btn-danger" onclick="removeRow(this)">Remove</button>';
        }

        function removeRow(button) {
          var row = button.parentNode.parentNode;
          row.parentNode.removeChild(row);
        }
      </script>

                    <style>
                        h5
                        {
                            color: red;
                        }
                         .je tr.button-row, .je tr.button-row button
                        {
                            background: #1f8dd6;
                            color:white;
                            font-size:100%;
                        }

                        .je .button-td
                        {
                        text-align: center;
                        border: solid;
                        border-width: 1px;
                        border-color: gray;
                        }

                        .je table thead
                        {
                        /* border-bottom: solid; */
                        /* border-width: 1px; */
                        /* border-color: #909090; */
                        }

                        .new-row-btn,.new-row-btn:hover
                        {
                        width:900px;
                        border:none;
                        background:none;
                        font-weight:bold;
                        }


                        .notification {
                          position: fixed;
                          top: 5%;
                          left: 50%;
                          transform: translate(-50%, -50%);
                          padding: 10px 20px;
                          border-radius: 5px;
                          background-color: #f3280d;
                          color: white;
                          font-size: 16px;
                          box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                          opacity: 0;
                          transition: opacity 0.3s;
                          z-index: 1000;
                      }

                      .notification.show {
                          opacity: 1;
                      }

                    </style>

  </body>
</html>


        {{--  @stop  --}}







