@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">-->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />-->

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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Berita Acara Kejadian</h4>

<form onsubmit="return validateForm()" action="/input_berita_acara_spv" method="post" enctype="multipart/form-data">

  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
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
                <input type="text" name="Tr_BA_Code" id="collapsible-fullname" class="form-control" placeholder="Auto Number" value="{{ $code_bas }}" readonly/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Date Input</label>
              <input type="text" name="rec_datecreated"  id="" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Date Peristiwa</label>
              <input type="date" name="Date_BA"  id="" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Company</label>
              <select class="form-control" name="Company_Code" required>
                @foreach ($company as $pt)
                    <option value="{{$pt->description}}">
                        {{$pt->description}}
                @endforeach
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
            </div>

             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Admin</label>
                  <input type="text" name="BA_Admin" id="" class="form-control" value="{{$user->username}}" readonly>
                {{--  <input type="text" name="BA_Admin" id="collapsible-fullname" class="form-control" placeholder="Admin" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Admin Divisi</label>
                <input type="text" name="Admin_Div" id="" class="form-control" value="{{$user->sub_divisi}}" readonly required>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="">Indikasi Fraud ?* <em>(perhatikan kasusnya, indikasi fraud atau bukan)</em></label>
                    <select name = "ms_fraud" class="form-control"  id="ms_fraud" required>
                      <option value="" style="weight:50px">Pilih Status Fraud</option>
                      <option value="1" style="weight:50px">Iya</option>
                      <option value="0" style="weight:50px">Tidak</option>
                    </select>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Kategori</label>
                 <select name = "Category_Code" class="form-control" id="Category_Code" required>
                  <option value="Pilih Kategori" style="weight:50px">Pilih Kategori</option>
                  <option value="Pelanggaran SOP" style="weight:50px">Pelanggaran SOP</option>
                  <option value="Kehilangan" style="weight:50px">Kehilangan</option>
                  <option value="Kerusakan" style="weight:50px">Kerusakan</option>
                  <option value="Perubahan SOP" style="weight:50px">Perubahan SOP</option>
                  {{--  <option value="Kehilangan Asset" style="weight:50px">Kehilangan Asset</option>  --}}
                  <option value="Pembelian Barang" style="weight:50px">Pembelian Barang</option>
                  {{--  <option value="Kesalahan Sistem" style="weight:50px">Kesalahan Sistem</option>  --}}
                  {{--  <option value="Temuan" style="weight:50px">Temuan</option>  --}}
                  {{--  <option value="Kerusakan Asset" style="weight:50px">Kerusakan Asset</option>  --}}
                  {{--  <option value="Kejadian" style="weight:50px">Kejadian</option>  --}}
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Kasus</label>
                    <select name = "jenis" class="form-control"  id="jenis" disabled>
                    <option value="">Pilih Kategori Untuk Membuka Kasus BA</option>
                      @foreach ($jenis as $jenises)
                            <option value="{{$jenises->description}}">
                          {{$jenises->description}}
                        @endforeach
                    </select>
                <!--<select name = "jenis" class="form-control" >-->
                <!--  @foreach ($jenis as $jenises)-->
                <!--      <option value="{{$jenises->description}}">-->
                <!--          {{$jenises->description}}-->
                <!--  @endforeach-->
                <!--</select>-->
              </div>
              <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Detail Kasus</label>
                
                 <select name = "ms_kasus" id="single2" class="js-states form-controls" required>
                  @foreach ($ms_kasus as $case)
                      <option value="{{$case->description}}">
                          {{$case->description}}
                  @endforeach
                </select>
               <!-- <select name = "ms_kasus" class="form-control" >-->
               <!--   @foreach ($ms_kasus as $case)-->
               <!--       <option value="{{$case->description}}">-->
               <!--           {{$case->description}}-->
               <!--   @endforeach-->
               <!--</select>-->
                {{--  <input type="text" name="pool" id="collapsible-fullname" class="form-control" placeholder="Pool" required/>  --}}
              </div>
              {{--  <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Dispatcher</label>
                  <select name = "dispatcher" class="form-control" required>
                    @foreach ($employee as $pegawai)
                        <option value="{{$pegawai->emp_name}}">
                            {{$pegawai->emp_name}}
                    @endforeach
                  </select>  --}}
                  {{--  <input type="text" name="dispatcher" id="collapsible-fullname" class="form-control" placeholder="" required/>  --}}
              {{--  </div>  --}}

              {{--  <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Mengetahui 1</label>
                  <input type="text" name="mengetahui1" id="collapsible-fullname" class="form-control" placeholder="Lokasi" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Mengetahui 2</label>
                  <input type="text" name="mengetahui2" id="collapsible-fullname" class="form-control" placeholder="Lokasi" required/>
              </div>  --}}
              <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Note</label>
                  <input type="text" name="BA_Note" id="collapsible-fullname" class="form-control" placeholder="Enter Note" required/>
              </div>
              {{--  <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">BA Number</label>
                <input type="number"  readonly=readonly id="" class="form-control" value="{{ $ba_main->id }}"  >
              </div>  --}}
              <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Kronologi</label>
                <div class="form-group">
                  <textarea  cols="135" rows="10" name="kronlogi" class="form-control" required></textarea>
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
          <form  action="/input_berita_acara_spv" method="post" enctype="multipart/form-data">
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
                              <th>Nama Pelaku</th>
                              <th>Divisi </th>
                            </tr>
                          </thead>
                          <tbody class="row-body">
                          <tr class='entree-row'>

                            <td>
                                            <select name = "User_Code" id="cb_pelaku" class="js-states form-control" required>
                                                  @foreach ($users as $pelakunya)
                                                      <option value="{{$pelakunya->id}}" data-name="{{$pelakunya->emp_id}}" data-divisi="{{$pelakunya->divisi}}">
                                                      {{$pelakunya->id}} - {{$pelakunya->emp_id}}
                                                  @endforeach
                                            </select>
                                              <!--<input name="User_Code" class="form-control"  type="text"   required/>-->
                                        </td>
                            <td>
                              <div>
                                <input type="text" class="form-control" id="Division_Code" name ="Division_Code" disabled>
                              </div>
              <!--  <select name = 'Division_Code'class="form-control" id="single3" class="js-states form-control" required>-->
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
              <!--  <option value="Operasional" style="weight:50px">Operasional</option>-->
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
              <!--  <option value="Staff" style="weight:50px">Staff</option>-->
              <!--  <option value="Leader" style="weight:50px">Leader</option>-->
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- </div>
      </div>
    </div>	 -->

      <div class="mt-1">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
      </div>
   </div>
</div>


    <script>

        function newRow() {
          var tr_s = "<tr name='entree-row' class='entree-row '>";
          var tr_btn_s = "<tr class='button-row'>";
          var tr_e = "</tr>";
          var account_in_s = '<td><select name ="posisi[]" class="form-control"><option value = "Driver">Driver</option> <option value = "Helper">Helper</option> </select></td> ';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var debit_in = '<td><input   onkeyUp="update_in(\'debit_in\');" name="nama[]" class="form-control"  type="text"  ></td>';
          var credit_in = '<td><input  onkeyUp="update_in(\'credit_in\');" name="usia[]" class="form-control"  type="text"  ></td>';
          var t1 = '<td><input name="penguji[]" class="form-control"  type="text"   required/></td> ';
          var t2 = '<td><input name="avg_income[]" class="form-control"  type="text"   required/></td> ';
          var t3 = '<td><input name="istirahat_last[]" class="form-control"  type="text"   required/></td> ';
          var add_button = '<td style="text-align:center;" colspan="6"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+select_account+select_account_e+t1+t2+remove_button+tr_e+tr_btn_s+add_button+tr_e);
          ///enables focus highlight on new rows///
          inputhighlight();
        };

    </script>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
      $("#cb_pelaku").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });

      $('#cb_pelaku').on('change', function() {
          var selectedOption = $(this).find('option:selected');  // Ambil option yang dipilih
          var empId = selectedOption.data('name');  // Ambil emp_id
          var divisi = selectedOption.data('divisi');
          // Tampilkan emp_id sebagai tampilan dropdown yang dipilih
          $(this).val(empId);  // Set nilai yang dipilih ke select dropdown
          $(this).trigger('change');  // Trigger untuk memilih opsi baru

          // Update text di dropdown dengan nama karyawan
          var displayText = empId;
          $(this).siblings('.select2').find('.selection .select2-selection__rendered').text(displayText);

          $('#Division_Code').val(divisi);
      });

      $("#multiple").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
    </script>
    
     <script>
      $("#single2").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
      $("#multiple").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
    </script>
    
    <script>
      $("#single3").select2({
          placeholder: "Select Divisi",
          allowClear: true
      });
      $("#multiple").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
    </script>
    
    <script>
      $("#single4").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
      $("#multiple").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
    </script>
    
    <script>
      $("#single5").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
      $("#multiple").select2({
          placeholder: "Select Pelaku",
          allowClear: true
      });
    </script>
    
    <script>
      document.getElementById('Category_Code').addEventListener('change', function() {
          var opsiPertama = this.value;
          var opsiKedua = document.getElementById('jenis');

          if (opsiPertama !== '') {
              opsiKedua.disabled = false; // Aktifkan select option kedua
          } else {
              opsiKedua.disabled = true; // Nonaktifkan select option kedua
              opsiKedua.selectedIndex = 0; // Reset opsi kedua jika opsi pertama dikosongkan
          }
      });
  </script>
  
   <script>
    function validateForm() {
      var selectedOption = document.getElementById('single3').value;

      if (selectedOption === "") {
        alert("Silakan pilih divisi pelaku, sebelum confirm!");
        return false; // Prevent form submission
      }

      // Lanjutkan dengan mengirim formulir jika validasi berhasil
      return true;
    }
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
