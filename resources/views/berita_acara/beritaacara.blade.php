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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Berita Acara Salah isi Dokumen</h4>
<form  action="/beritaacara" method="post" enctype="multipart/form-data">

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>
    BA Salah Isi
  </title>
</head>
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

@csrf
<div class="row">
  <div class="col">
    <div class="nav-align-top mb-3">
      <ul class="nav nav-tabs" role="tablist">
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Code</label>
                <input type="text" name="Tr_BA_Code" id="collapsible-fullname" class="form-control" placeholder="Auto Number" required readonly/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Date</label>
                <input type="date" name="Date_BA" id="collapsible-fullname" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"  required/>
            </div>
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Admin BA(Atasan)</label>
                <select name = "BA_Admin" class="form-control" required>
                  @foreach ($employee as $pegawai)
                      <option value="{{$pegawai->emp_name}}">
                          {{$pegawai->emp_name}}
                  @endforeach
                </select>
                {{--  <input type="text" name="BA_Admin" id="collapsible-fullname" class="form-control" placeholder="Admin" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Admin Divisi(Atasan)</label>
                <select name = "Admin_Div" class="form-control" required>
                     @foreach ($divisi as $divisies)
                        <option value="{{$divisies->subbdiv_desc}}">
                            {{$divisies->subbdiv_desc}}
                    @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User Salah Input</label>
                <select name = "User_Code" class="form-control" required>
                  @foreach ($employee as $pegawai)
                      <option value="{{$pegawai->emp_name}}">
                          {{$pegawai->emp_name}}
                  @endforeach
                </select>
                {{--  <input type="text" name="User_Code" id="collapsible-fullname" class="form-control" placeholder="User" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">User Divisi</label>
                  <select name = "Division_Code" class="form-control" required>
                      @foreach ($divisi as $divisies)
                          <option value="{{$divisies->subbdiv_desc}}">
                              {{$divisies->subbdiv_desc}}
                      @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Kategori</label>
                <select name = "Category_Code" class="form-control" required>
                    <option value="Temuan" style="weight:50px">Temuan</option>
                    <option value="BA" style="weight:50px">BA</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Jenis</label>
                <select name = "jenis" class="form-control" required>
                    <option value="Salah isi Dokumen" style="weight:50px">Salah isi Dokumen</option>
                    <option value="Laka" style="weight:50px"><a href="/beritaacra/berita_acara_laka"></a>Laka</option>
                    <option value="Fraud" style="weight:50px">Fraud</option>
                    <option value="Pelanggaran SOP" style="weight:50px">Pelanggaran SOP</option>
                    <option value="Kerusakan Asset" style="weight:50px">Kerusakan Asset</option>
                    <option value="Petrollman" style="weight:50px">Petrollman</option>
                    <option value="Investigasi" style="weight:50px">Investigasi</option>
                    <option value="Kesalahan Sistem" style="weight:50px">Kesalahan Sistem</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Company </label>
                  <select name = 'Company_Code'class="form-control" required>
                    <option value="PT. Handal Guna Sarana" style="weight:50px">PT. Handal Guna Sarana</option>
                    <option value="PT. Tirta Gracia Utama" style="weight:50px">PT. Tirta Gracia Utama </option>
                    <option value="PT. Tirta Gracia Fiesta" style="weight:50px">PT. Tirta Gracia Fiesta</option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                <select class="form-control" name="Location_Code" required>
                  @foreach ($lokasi as $branch)
                      <option value="{{$branch->lokasi_desc}}">
                          {{$branch->lokasi_desc}}
                  @endforeach
                </select>
                  {{--  <input type="text" name="Location_Code" id="collapsible-fullname" class="form-control" placeholder="Lokasi" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">BA Type</label>
                <select name = 'BA_Type_Code' class="form-control" required>
                  <option value="Gudang" style="weight:50px">Gudang</option>
                  <option value="Bengkel" style="weight:50px">Bengkel </option>
                  <option value="Dispatcher" style="weight:50px">Dispatcher</option>
                  <option value="Kasir" style="weight:50px">Kasir</option>
                  <option value="Finance" style="weight:50px">Finance </option>
                  <option value="Purchasing" style="weight:50px">Purchasing</option>
                  <option value="GA" style="weight:50px">GA</option>
                  <option value="Security" style="weight:50px">Security</option>
                  <option value="HRD" style="weight:50px">HRD</option>
                </select>
              </div>
              {{--  <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Mengetahui 1</label>
                <input type="text"  name="mengetahui1" id="" class="form-control"  >
              </div>
               <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Posisi Yang Mengetahui 1</label>
                <select name = "atasan1" class="form-control" >
                    <option value="Spv. Kasir" style="weight:50px">Spv. Kasir</option>
                    <option value="Spv. Finance" style="weight:50px">Spv. Finance</option>
                    <option value="Spv. Dispatcher" style="weight:50px">Spv. Dispatcher</option>
                    <option value="Spv. Gudang" style="weight:50px">Spv. Gudang</option>
                    <option value="Spv. Purchasing" style="weight:50px">Spv. Purchasing</option>
                    <option value="Spv. Fleet" style="weight:50px">Spv. Fleet</option>
                    <option value="Spv. Project" style="weight:50px">Spv. Project</option>
                    <option value="Spv. IT" style="weight:50px">Spv. IT</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Mengetahui 2</label>
                <input type="text" name="mengetahui2"  id="" class="form-control" >
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Posisi Yang Mengetahui 2</label>
                <select name = "atasan2" class="form-control" >
                    <option value="Spv. Kasir" style="weight:50px">Spv. Kasir</option>
                    <option value="Spv. Finance" style="weight:50px">Spv. Finance</option>
                    <option value="Spv. Dispatcher" style="weight:50px">Spv. Dispatcher</option>
                    <option value="Spv. Gudang" style="weight:50px">Spv. Gudang</option>
                    <option value="Spv. Purchasing" style="weight:50px">Spv. Purchasing</option>
                    <option value="Spv. Fleet" style="weight:50px">Spv. Fleet</option>
                    <option value="Spv. Project" style="weight:50px">Spv. Project</option>
                    <option value="Spv. IT" style="weight:50px">Spv. IT</option>
                </select>
              </div>  --}}
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Perlu Approval</label>
                  <select name = 'perlu_approval'class="form-control" required>
                    <option value="1" style="weight:50px">Iya</option>
                    <option value="2" style="weight:50px">Tidak </option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Note</label>
                  <input type="text" name="BA_Note" id="collapsible-fullname" class="form-control" placeholder="Note" required/>
              </div>
              <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Kronologi</label>
                <div class="form-group">
                  <textarea name="kronlogi" class="form-control" id="" rows="10" placeholder="" required ></textarea>
              </div>
              </div>
            </div>
        </div>
    </div>
</div>
    <!-- <div class="accordion" id="collapsibleSection">
      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingDeliveryOptions">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">Temuan</button>
        </h2>
        <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection"> -->
        <form>
          <form  action="/report" method="post" enctype="multipart/form-data">
        @csrf
        <div class="accordion-body">
                <div class="content je">
                  <div class="pure-g ">
                    <div class="pure-u-1-24 ">
                    </div>
                    <div class="pure-u-11-12">
                <div class="">
                  <div class="pure-g">
                    <div class="pure-u-1-2">

                    <table class="table table-bordered" id="journal-entrees">
                          <thead>
                            <tr>
                              <th>Code Doc.</th>
                              <th>Field Salah</th>
                              <th>Value Salah</th>
                              <th>Field Benar</th>
                              <th>Value Benar</th>
                            </tr>
                          </thead>
                          <tbody class="row-body">
                          <tr class='entree-row'>
                            <td>
                                <input name="code_doc[]" class="form-control"  type="text"   required/>
                            </td>
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
                          </tr>
                          <tr class="button-row">
                            <td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="5"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- </div>
      </div>
    </div>	 -->

    <br>
    <center>
      <label for="" >Dokumen Pendukung</label>
              <br>
              <div class="form-group">
                  <input  type="file" name="file_path" id="file" onchange="return validasiEkstensi()">
              </div>
              <div id="feedback">
      </center>
    <br>

      <div class="mt-1">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
      </div>
   </div>
</div>


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
                  }
                  else
                  {
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

      <style>

            .je tr.button-row, .je tr.button-row button {
              background: #1f8dd6;
              color:white;
              font-size:100%;
            }

            .je .button-td {
              text-align: center;
              border: solid;
              border-width: 1px;
              border-color: gray;
            }

            .je table thead {
              /* border-bottom: solid; */
              /* border-width: 1px; */
              /* border-color: #909090; */
            }

            .new-row-btn,.new-row-btn:hover {
              width:900px;
              border:none;
              background:none;
              font-weight:bold;
            }
      </style>



@endsection
