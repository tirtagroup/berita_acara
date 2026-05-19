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

<title>
    Laka
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

<center><h2>Berita Acara Laka</h2></center>

<body>
        <form  action="/ba_laka" method="post" enctype="multipart/form-data">
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
                <select class="form-control" name="Company_Code" required>
                  @foreach ($company as $pt)
                      <option value="{{$pt->description}}">
                          {{$pt->description}}
                  @endforeach
              </select>
                    <!--<input type="text" name="Company_Code" id="" class="form-control" value="{{$user->ms_company}}" readonly>-->
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Lokasi</label>
                    <select class="form-control" name="Location_Code" >
                        @foreach ($lokasi as $branch)
                            <option value="{{$branch->lokasi_desc}}">
                                {{$branch->lokasi_desc}}
                        @endforeach
                    </select>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Operator *</label>
                <input type="text" name="User_Code" id="" class="form-control" value="{{$user->username}}" readonly>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Divisi *</label>
                  <input type="text" name="Division_Code" id="" class="form-control" value="{{$user->ms_divisi}}" readonly>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="">Kategori *</label>
                <input type="text" name="Category_Code" id="collapsible-fullname" class="form-control" value="Laka" required readonly/>
            </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              <label for="">Jenis *</label>
              {{--  <input type="text" name="jenis" id="collapsible-fullname" class="form-control" value="Laka" required readonly/>  --}}
                 <select name = "ms_jenis_laka" class="form-control" >
                    @foreach ($ms_jenis_laka as $jenises)
                        <option value="{{$jenises->description}}">
                            {{$jenises->description}}
                    @endforeach
                </select>
          </div>
      </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
              <label for="">Faktor *</label>
              <select name = "ms_faktor_laka" class="form-control" required>
                @foreach ($ms_faktor_laka as $jenises)
                    <option value="{{$jenises->description}}">
                        {{$jenises->description}}
                @endforeach
            </select>
          </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Klasifikasi *</label>
            <select name = "ms_klasifikasi_laka" class="form-control" required>
              @foreach ($ms_klasifikasi_laka as $jenises)
                  <option value="{{$jenises->description}}">
                      {{$jenises->description}}
              @endforeach
          </select>
        </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="form-group">
          <label for="">Dampak *</label>
          <select name = "ms_dampak_laka" class="form-control" required>
            @foreach ($ms_dampak_laka as $jenises)
                <option value="{{$jenises->description}}">
                    {{$jenises->description}}
            @endforeach
        </select>
      </div>
  </div>

      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Type Laka *</label>
            <select name ="type_laka" class="form-control" required>
              <option value = "Tunggal">Tunggal</option>
              <option value = "Ganda (Tidak Ada Korban)">Ganda (Tidak Ada Korban)</option>
              <option value = "Ganda (Ada Korban)">Ganda (Ada Korban)</option>
            </select>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Fatality *</label>
            <select name = 'fatality'class="form-control">
              <option value="Iya" style="weight:50px">Iya</option>
              <option value="Tidak" style="weight:50px">Tidak</option>
            </select>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Dispatcher *</label>
              <!--<input type="text" name="dispatcher" id="" class="form-control" required>-->
               <select name="dispatcher" class="form-control" required>
                     @foreach ($users as $pelakunya2)
                            <option value="{{$pelakunya2->emp_name}}">
                                {{$pelakunya2->emp_name}}</option>
                     @endforeach
                </select>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">SPK *</label>
              <input type="text" name="spk" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">No. Armada *</label>
              <input type="text" name="no_armada" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Jam Keluar *</label>
              <input type="time" name="jam_keluar" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Tanggal Kejadian *</label>
              <input type="date" name="date_laka" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Jam Kejadian *</label>
              <input type="time" name="jam_kejadian" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Lokasi Kejadian *</label>
              <input type="text" name="lokasi_kejadian" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Speed *</label>
              <input type="text" name="speed" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Jalur/Rute *</label>
              <input type="text" name="rute" id="" class="form-control" required>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="">Bengkel Terakhir *</label>
              <input type="text" name="bengkel_terakhir" id="" class="form-control" required>
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
                  <textarea  cols="147" rows="10" name="kronlogi" class="form-control" required></textarea>
                </div>
         </div>
        </div>

                    <table class="table table-bordered" id="dynamic-table">
                          <thead>
                            <tr>
                              <th>Driver / Helper</th>
                              <th>Nama</th>
                              <th>Usia</th>
                              <th>Penguji</th>
                              <th>Average Income</th>
                              <th>Istirahat Terakhir</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class='entree-row'>
                                <td>
                                  <select name ="posisi[]" class="form-control" required>
                                    <option value = "Driver">Driver</option>
                                    <option value = "Helper">Helper</option>
                                  </select>
                                </td>
                                <td>
                                     <select name = "nama[]" class="form-control" required>
                                              @foreach ($users as $pelakunya)
                                                  <option value="{{$pelakunya->emp_name}}">
                                                      {{$pelakunya->emp_name}} </option>
                                              @endforeach
                                     </select>
                                  <!--<input name="nama[]" class="form-control"  type="text"   required/>-->
                                </td>
                                <td>
                                    <input  name="usia[]" class="form-control"  type="text"   required/>
                                </td>
                                <td>
                                    <!--<input  name="penguji[]" class="form-control"  type="text"   required/>-->
                                    <select name = "penguji[]" class="form-control" >
                                              @foreach ($users as $pelakunya)
                                                  <option value="{{$pelakunya->emp_name}}">
                                                      {{$pelakunya->emp_name}}</option>
                                              @endforeach
                                     </select>
                                </td>
                                <td>
                                  <input  name="avg_income[]" class="form-control"  type="text"   required/>
                              </td>
                              <td>
                                <input  name="istirahat_last[]" class="form-control"  type="text"   required/>
                            </td>
                                <td>
                                  <button type="button" class="remove-row-btn btn btn btn-danger" onclick="removeRow(this)">Remove</button>
                                </td>
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
          var table = document.getElementById("dynamic-table").getElementsByTagName('tbody')[0];
          var newRow = table.insertRow(table.rows.length);
          var nama1 = newRow.insertCell(0);
          var nama2 = newRow.insertCell(1);
          var nama3 = newRow.insertCell(2);
          var nama4 = newRow.insertCell(3);
          var nama5 = newRow.insertCell(4);
          var nama6 = newRow.insertCell(5);
          var actionCell = newRow.insertCell(6);

          nama1.innerHTML = ' <select name ="posisi[]" class="form-control"><option value = "Driver">Driver</option> <option value = "Helper">Helper</option> </select>';
          nama2.innerHTML = ' <select name = "nama[]" class="form-control" >@foreach ($users as $pelakunya)<option value="{{$pelakunya->emp_name}}"> {{$pelakunya->emp_name}}  @endforeach</select>';
          nama3.innerHTML = '<input  name="usia[]" class="form-control"  type="text"   required/>';
          nama4.innerHTML = '<select name = "penguji[]" class="form-control" >@foreach ($users as $pelakunya)<option value="{{$pelakunya->emp_name}}"> {{$pelakunya->emp_name}} @endforeach</select>';
          nama5.innerHTML = '<input  name="avg_income[]" class="form-control"  type="text"   required/>';
          nama6.innerHTML = '<input  name="istirahat_last[]" class="form-control"  type="text"   required/>';
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







