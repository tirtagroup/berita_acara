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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Interview</h4>
<form  action="/report" method="post" enctype="multipart/form-data">
    @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif
  {{-- <form  action="/report/report_interview/{{$sudah_call['Tr_report_hrd_main_code']}}" method="post" enctype="multipart/form-data"> --}}
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
                <label class="form-label" for="collapsible-fullname">User</label>
                <input type="text" name="Ms_User_Code" id="collapsible-fullname" class="form-control" value="{{ $user->name }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Divisi</label>
                {{--  <select name = "ms_divisi" class="form-control" >
                    <option value="GA" style="weight:50px">GA</option>
                    <option value="Security" style="weight:50px">Security</option>
                    <option value="HRD" style="weight:50px">HRD</option>
                </select>  --}}
                <input type="text" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $user->ms_divisi }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Type Report</label>
                <input type="text" name="Ms_ReportType_Code" id="collapsible-fullname" class="form-control" value="Interview" readonly />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                <select name = 'ms_lokasi'class="form-control">
                    <option value="Pusat" style="weight:50px">HGS Pusat   </option>
                    <option value="Subang" style="weight:50px">HGS Subang </option>
                    <option value="Ciherang" style="weight:50px">HGS Ciherang</option>
                    <option value="Sentul" style="weight:50px">HGS Sentul</option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Perusahaan</label>
                  <select name = 'Ms_Perusahaan_Code_main'class="form-control">
                    <option value="PT. HGS" style="weight:50px">PT. Handal Guna Sarana </option>
                    <option value="PT. TGU" style="weight:50px">PT. Tirta Gracia Utama</option>
                    <option value="PT. TGF" style="weight:50px">PT. Tirta Gracia Fiesta</option>
                    <option value="Bukalapak" style="weight:50px">Bukalapak</option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Tanggal</label>
                  <input class="form-control" readonly=readonly type="text" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" />
              </div>
            </div>
        </div>
    </div>
</div>
    <div class="accordion" id="collapsibleSection">
      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingDeliveryOptions">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">Interview</button>
        </h2>
        <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection">
        <form>
          <form  action="/report" method="post" enctype="multipart/form-data">
          {{-- <form  action="/report/report_interview/{{$sudah_call['Tr_report_hrd_main_code']}}" method="post" enctype="multipart/form-data"> --}}
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
                              <th>Perusahaan</th>
                              <th>Media</th>
                              <th>Yang Interview</th>
                              <th style="padding-left:5px;">Kandidat</th>
                              <th style="padding-left:5px;">Posisi</th>
                              <th style="padding-left:5px;">Nomor HP</th>
                              <th style="padding-left:5px;">Keterangan</th>
                              <th>Note</th>
                            </tr>
                          </thead>
                          <tbody class="row-body">

                          <tr class='entree-row'>
                            <td>
                              <select name= "Ms_Perusahaan_Code[]" class="form-control">
                                <option value="PT. HGS" style="weight:50px">PT. Handal Guna Sarana </option>
                                <option value="PT. TGU" style="weight:50px">PT. Tirta Gracia Utama</option>
                                <option value="PT. TGF" style="weight:50px">PT. Tirta Gracia Fiesta</option>
                                <option value="Bukalapak" style="weight:50px">Bukalapak</option>
                             </select>
                         </td>
                            <td>
                                <select name= "Ms_Media_Code[]" class="form-control">
                                  <option value = 'Jobstreet'>Jobstreet</option>
                                  <option value = 'Karir'>Karir</option>
                                  <option value = 'Top Karir'>Top Karir</option>
                                  <option value = 'Kita Lulus'>Kita Lulus</option>
                                  <option value = 'LinkIdn'>LinkIdn</option>
                                  <option value = 'Facebook'>Facebook</option>
                                  <option value = 'Instagram'>Instagram</option>
                                  <option value = 'Telegram'>Telegram</option>
                                  <option value = 'WA Group'>WA Group</option>
                                  <option value = 'MGM'>MGM</option>
                                  <option value = 'Teman /Relasi'>Teman /Relasi</option>
                                  <option value = 'Vendor'>Vendor</option>
                                  <option value = 'Jobs ID'>Jobs ID</option>
                                  <option value = 'Jobfair'>Jobfair</option>
                                  <option value = 'Olx'>Olx</option>
                                  <option value = 'Kupu.com'>Kupu.com</option>
                                  <option value = 'Website'>Website</option>
                                  <option value = 'Tiktok'>Tiktok</option>
                                  <option value = 'Mengetahui Sendiri'>Mengetahui Sendiri</option>
                                </select>
                            </td>
                            <td>
                              <input name="userinterview[]" class="form-control"  type="text"   required/>
                            </td>
                            <td>
                              <input name="NamaCandidate[]" class="form-control"  type="text"   required/>
                            </td>
                            <td>
                                 <select name= "NamaLowongan[]" class="form-control">
                                  <option value="OPERATIONAL TRANSPORT" style="font-weight: bold" disabled="disabled">1. DIVISI OPERATIONAL TRANSPORT</option>
                                  <option value="SPV Transport" style="weight:50px">    > SPV Transport</option>
                                  <option value="Management Trainee Logistic" style="weight:50px">    > Management Trainee Logistic</option>
                                  <option value="Koord. Transport" style="weight:50px"> > Koord. Transport</option>
                                  <option value="Dispatcher" style="weight:50px"> > Dispatcher</option>
                                  <option value="Data Entry" style="weight:50px">> Data Entry</option>
                                  <option value="Checker Plant" style="weight:50px">> Checker Plant</option>
                                  <option value="Driver" style="weight:50px">> Driver</option>
                                  <option value="Helper" style="weight:50px">> Helper</option>
                                  <option value="Motoris" style="weight:50px">> Motoris</option>
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
                                  <option value="Management Trainee FnB" style="weight:50px">    > Management Trainee FnB</option>
                                  <option value="Waiters" style="weight:50px">> Waiters</option>
                                  <option value="Cook Helper" style="weight:50px">> Cook Helper</option>
                                  <option value="Staff Gudang Resto" style="weight:50px">> Staff Gudang Resto</option>
                                  <option value="SALES" style="font-weight: bold" disabled="disabled">9. DIVISI SALES</option>
                                  <option value="OM (Operation Manager Sales)" style="weight:50px">> OM (Operation Manager Sales)</option>
                                  <option value="SPV Sales" style="weight:50px">> SPV Sales</option>
                                  <option value="Sales TO" style="weight:50px">> Sales TO</option>
                                  <option value="SMD" style="weight:50px">> SMD</option>
                                </select>
                            </td>

                            <td>
                              <input  name="Telepon[]" class="form-control"  type="number"   required/>
                            </td>
                            <td>
                              <select name ="hasil_interview[]" class="form-control">
                                <option value = "Lulus">Lulus</option>
                                <option value = "Tidak Lulus">Tidak Lulus</option>
                                <option value = "Tidak Hadir">Tidak Hadir</option>
                              </select>
                             </td>
                             <td>
                              <input  name="note[]" class="form-control"  type="text"   required/>
                             </td>
                          </tr>
                          <tr class="button-row">
                            <td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="8"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


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
          var perusahaan = '<td><select name= "Ms_Perusahaan_Code[]" class="form-control"><option value="Bukalapak" style="weight:50px">Bukalapak</option><option value="PT. HGS" style="weight:50px">PT. Handal Guna Sarana </option><option value="PT. TGU" style="weight:50px">PT. Tirta Gracia Utama</option><option value="PT. TGF" style="weight:50px">PT. Tirta Gracia Fiesta</option>  </td>';
          var medias = '<td><select name= "Ms_Media_Code[]" class="form-control"><option value = "Jobstreet">Jobstreet</option> <option value = "Karir">Karir</option>   <option value = "Top Karir">Top Karir</option>  <option value = "Kita Lulus">Kita Lulus</option> <option value = "LinkIdn">LinkIdn</option> <option value = "Facebook">Facebook</option> <option value = "Instagram">Instagram</option><option value = "Telegram">Telegram</option><option value = "WA Group">WA Group</option> <option value = "MGM">MGM</option> <option value = "Teman /Relasi">Teman /Relasi</option><option value = "Vendor">Vendor</option><option value = "Jobs ID">Jobs ID</option><option value = "Jobfair">Jobfair</option><option value = "Olx">Olx</option><option value = "Kupu.com">Kupu.com</option><option value = "Website">Website</option> <option value ="Tiktok">Tiktok</option><option value = "Mengetahui Sendiri">Mengetahui Sendiri</option> </td> ';
          var user_interview = '<td><input  onkeyUp="update_in(\'credit_in\');" name="userinterview[]" class="form-control"  type="text"  ></td>';
          var kandidat = '<td><input  onkeyUp="update_in(\'credit_in\');" name="NamaCandidate[]" class="form-control"  type="text"  ></td>';
          var namalowongan = '<td><select name= "NamaLowongan[]" class="form-control"><option value="OPERATIONAL TRANSPORT" style="font-weight: bold" disabled="disabled">1. DIVISI OPERATIONAL TRANSPORT</option><option value="SPV Transport" style="weight:50px">    > SPV Transport</option><option value="Management Trainee Logistic" style="weight:50px">    > Management Trainee Logistic</option> <option value="Koord. Transport" style="weight:50px"> > Koord. Transport</option><option value="Dispatcher" style="weight:50px"> > Dispatcher</option><option value="Data Entry" style="weight:50px">> Data Entry</option><option value="Checker Plant" style="weight:50px">> Checker Plant</option> <option value="Driver" style="weight:50px">> Driver</option> <option value="Helper" style="weight:50px">> Helper</option> <option value="Motoris" style="weight:50px">> Motoris</option><option value="HR GA" style="font-weight: bold" disabled="disabled">2. DIVISI HR GA</option><option value="Chif Security" style="weight:50px">> Chif Security</option><option value="SPV GA" style="weight:50px">> SPV GA</option><option value="Koord. HR" style="weight:50px">> Koord. HR</option><option value="Legal" style="weight:50px">> Legal</option> <option value="Koord. GA" style="weight:50px">> Koord. GA</option><option value="Security" style="weight:50px">> Security</option><option value="Staff Umum" style="weight:50px">> Staff Umum</option><option value="Finance" style="font-weight: bold" disabled="disabled">3. DIVISI FINANCE</option> <option value="Purchasing" style="weight:50px">> Purchasing</option><option value="Cashier" style="weight:50px">> Cashier</option> <option value="MT Finance" style="weight:50px">> MT Finance</option><option value="Staff AR" style="weight:50px">> Staff AR</option><option value="Staff Accounting" style="weight:50px">> Staff Accounting</option><option value="Staff Pajak" style="weight:50px">> Staff Pajak</option><option value="Staff Payroll" style="weight:50px">> Staff Payroll</option><option value="Auditor Internal" style="weight:50px">> Auditor Internal</option> <option value="FLEET" style="font-weight: bold" disabled="disabled">4. DIVISI FLEET</option><option value="SPV Fleet" style="weight:50px">> SPV Fleet</option> <option value="Koord. Fleet" style="weight:50px"> > Koord. Fleet</option><option value="Service Officer" style="weight:50px">> Service Officer</option> <option value="Mekanik Junior" style="weight:50px">> Mekanik Junior</option><option value="Mekanik Senior" style="weight:50px">> Mekanik Senior</option> <option value="Petroll Man" style="weight:50px">> Petroll Man</option> <option value="Tyre Man" style="weight:50px">> Tyre Man</option> <option value="PROJECT" style="font-weight: bold" disabled="disabled">5. DIVISI PROJECT</option><option value="PIC Project" style="weight:50px">> PIC Project</option><option value="BD (Bussines Development)" style="weight:50px">> BD (Bussines Development)</option> <option value="WEREHOUSE" style="font-weight: bold" disabled="disabled">6. DIVISI WEREHOUSE</option><option value="SPV Gudang" style="weight:50px">> SPV Gudang</option><option value="Kepala Gudang" style="weight:50px">> Kepala Gudang</option><option value="Leadership Gudang" style="weight:50px">> Leadership Gudang</option> <option value="Admin Gudang" style="weight:50px">> Admin Gudang</option><option value="Staff Gudang" style="weight:50px">> Staff Gudang</option><option value="Operator Forklip" style="weight:50px">> Operator Forklip</option><option value="Checker Gudang" style="weight:50px">> Checker Gudang</option><option value="IT" style="font-weight: bold" disabled="disabled">7. DIVISI IT</option><option value="SPV IT" style="weight:50px">> SPV IT</option> <option value="Senior Programmer" style="weight:50px">> Senior Programmer</option><option value="Junior Programmer" style="weight:50px">> Junior Programmer</option><option value="IT Support" style="weight:50px">> IT Support</option><option value="Restaurant" style="font-weight: bold" disabled="disabled">8. DIVISI  RESTAURANT</option><option value="Management Trainee FnB" style="weight:50px">    > Management Trainee FnB</option><option value="Waiters" style="weight:50px">> Waiters</option><option value="Cook Helper" style="weight:50px">> Cook Helper</option> <option value="Staff Gudang Resto" style="weight:50px">> Staff Gudang Resto</option><option value="SALES" style="font-weight: bold" disabled="disabled">9. DIVISI SALES</option> <option value="OM (Operation Manager Sales)" style="weight:50px">> OM (Operation Manager Sales)</option><option value="SPV Sales" style="weight:50px">> SPV Sales</option> <option value="Sales TO" style="weight:50px">> Sales TO</option> <option value="SMD" style="weight:50px">> SMD</option></td> ';
          var no_hp = '<td><input   onkeyUp="update_in(\'debit_in\');" name="Telepon[]" class="form-control"  type="text"  ></td>';
          var keterangan = '<td><select name ="hasil_interview[]" class="form-control"> <option value = "Lulus">Lulus</option><option value = "Tidak Lulus">Tidak Lulus</option><option value = "Tidak Hadir">Tidak Hadir</option></td> ';
          var notes = '<td><input  name="note[]" class="form-control"  type="text"   required/></option> </td>';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var add_button = '<td style="text-align:center;" colspan="8"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+perusahaan+medias+select_account+select_account_e+user_interview+kandidat+namalowongan+no_hp+keterangan+notes+remove_button+tr_e+tr_btn_s+add_button+tr_e);
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
              border-bottom: solid;
              border-width: 1px;
              border-color: #909090;
            }

            .new-row-btn,.new-row-btn:hover {
              width:900px;
              border:none;
              background:none;
              font-weight:bold;
            }
      </style>



@endsection
