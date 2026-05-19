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
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Report HRD</h4>
<form  action="/report" method="post" enctype="multipart/form-data">
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
                <input type="text" name="Ms_User_Code" id="collapsible-fullname" class="form-control" placeholder="Operator" />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Divisi</label>
                <select name = "ms_divisi" class="form-control" >
                    <option value="GA" style="weight:50px">GA</option>
                    <option value="Security" style="weight:50px">Security</option>
                    <option value="HRD" style="weight:50px">HRD</option>
                </select> 
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Type Report</label>
                  <select name = "Ms_ReportType_Code" class="form-control" >
                      <option value="Memo" style="weight:50px">Memo </option>
                      <option value="Opening Lowongan" style="weight:50px">Opening Lowongan</option>
                      <option value="Call" style="weight:50px">Call</option>
                      <option value="Interview" style="weight:50px">Interview</option>
                      <option value="Regist" style="weight:50px">Regist</option>
                  </select> 
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                <select name = 'ms_lokasi'class="form-control">
                    <option value="Pusat" style="weight:50px">Pusat   </option>
                    <option value="Subang" style="weight:50px">Subang </option>
                    <option value="Ciherang" style="weight:50px">Ciherang</option>
                    <option value="Sentul" style="weight:50px">Sentul</option>                   
                  </select>
                <!-- <input class="form-control" readonly=readonly  type="text" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" />  -->
              </div>
            </div>
        </div>
    </div>
</div>   
    <h6> Type Report </h6>   
    <div class="accordion" id="collapsibleSection">
      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingDeliveryAddress">
          <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryAddress" aria-expanded="true" aria-controls="collapseDeliveryAddress"> Report Memo </button>
        </h2>
        <div id="collapseDeliveryAddress" class="accordion-collapse collapse show" data-bs-parent="#collapsibleSection">
      <form>
      <form  action="/report" method="post" enctype="multipart/form-data">
        @csrf
        <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Company</label>
                <select name = "rec_comcode" class="form-control" >
                    <option value="PT. HGS" style="weight:50px">PT. Handal Guna Sarana </option>
                    <option value="PT. TGU" style="weight:50px">PT. Tirta Gracia Utama</option>
                    <option value="PT. TGF" style="weight:50px">PT. Tirta Gracia Fiesta</option>
                </select> 
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Location</label>
                <select name = "rec_areacode" class="form-control" >
                    <option value="HGS" style="weight:50px">HGS</option>
                    <option value="HGS0002" style="weight:50px">HGS0002</option>
                    <option value="HGS0003" style="weight:50px">HGS0003</option>
                    <option value="TGU0001" style="weight:50px">TGU0001</option>
                    <option value="TGU0002" style="weight:50px">TGU0002</option>
                    <option value="TGU0003" style="weight:50px">TGU0003</option>
                    <option value="TGF0001" style="weight:50px">TGF0001</option>
                </select>      
            </div>
              <div class="col-12">
                <label class="form-label" for="collapsible-address">Memo</label>
                <textarea name="Memo" class="form-control" id="collapsible-address" rows="5" placeholder="Report..."></textarea>
              </div>
              <div class="col-md-6">
                        <!-- <div class="mt-1">
                          <button type="submit" id="btnSave" name="submit" value="submit" class="btn btn-primary me-sm-3 me-1">Submit</button> 
                          <button type="submit"class="btn btn-primary me-sm-3 me-1">Submit</button>
                          <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <!-- </form> -->
            
      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingDeliveryOptions">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions"> Opening Lowongan</button>
        </h2>
        <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection">
        <!-- <form>  
        <form  action="/report" method="post" enctype="multipart/form-data"> -->
        <div class="accordion-body">
            <div class="row">
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Posisi</label>
                <select name = "MS_Jabatan_Code" class="form-control" >
                    <option value="Gudang" style="weight:50px">Gudang </option>
                    <option value="Sales" style="weight:50px">Sales</option>
                    <option value="Dispatcher" style="weight:50px">Dispatcher</option>
                </select> 
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Media</label>
                  <select name ='Ms_Media_Code' class="form-control">
                      <option value = 'Jobstreet'>Jobstreet</option>
                      <option value = 'LinkIdn'>LinkIdn</option>
                      <option value = 'Jobs ID'>Jobs ID</option>
                      <option value = 'Sosial Media'>Sosial Media</option>
                      <option value = 'Olx'>Olx</option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Perusahaan</label>
                  <select name = 'Ms_Perusahaan_Code'class="form-control">
                    <option value="Bukalapak" style="weight:50px">Bukalapak</option>
                    <option value="PT. HGS" style="weight:50px">PT. Handal Guna Sarana </option>
                    <option value="PT. TGU" style="weight:50px">PT. Tirta Gracia Utama</option>
                    <option value="PT. TGF" style="weight:50px">PT. Tirta Gracia Fiesta</option>                   
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Jumlah</label>
                <textarea name="Qty" class="form-control" id="collapsible-address" rows="1" placeholder="Report..."></textarea>    
              </div>
              <br>
                <div class="col-md-6">
                <br>
                          <!-- <div class="mt-1">
                          <button type="submit" id="btnSubmit" name="save" value="save" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                          </div> -->
                      </div>
                  </div>
                </div>
              </div>
            </div>
      <!-- </form> -->

      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingCall">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseCall" aria-expanded="false" aria-controls="collapseCall"> Call</button>
        </h2>
        <div id="collapseCall" class="accordion-collapse collapse" aria-labelledby="headingCall" data-bs-parent="#collapsibleSection">
      <!-- <form>  
      <form  action="/report" method="post" enctype="multipart/form-data"> -->
        <div class="accordion-body">
            <div class="row">
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Nama Kandidat</label>
                <input type="text" id="collapsible-fullname" name="Nama_kandidat" class="form-control" placeholder="Nama" />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Nama Lowongan</label>
                  <select name= "NamaLowongan" class="form-control">
                      <option value = "Dispatcher">Dispatcher</option>
                      <option value = "Staff Gudang" >Staff Gudang</option>
                      <option value = "Kasir">Kasir</option>
                  </select>  
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Nomer HP</label>
                <input type="text" name="Telepon" id="collapsible-fullname" class="form-control" placeholder="08232" />   
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Status</label>
                  <select name ="Ms_Status" class="form-control">
                      <option value = "Terhubung">Terhubung</option>
                      <option value = "Tidak Terhubung">Tidak Terhubung</option>
                      <option value = "Tidak Aktif">Tidak Aktif</option>
                  </select>  
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Tanggal Interview</label>
                <input type="date" id="collapsible-fullname" class="form-control"  />   
              </div>
                        <!-- <div class="mt-1">
                          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                          <button type="reset" class="btn btn-label-secondary">Cancel</button>
                         </div> -->
                    </div>
                  </div>
                </div>
              </div>
        <!-- </form> -->

      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingPaymentMethod">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePaymentMethod" aria-expanded="false" aria-controls="collapsePaymentMethod"> Interview </button>
        </h2>
        <div id="collapsePaymentMethod" class="accordion-collapse collapse" aria-labelledby="headingPaymentMethod" data-bs-parent="#collapsibleSection">
          <!-- <form> -->
          <!-- <form  action="/report" method="post" enctype="multipart/form-data"> -->
            <div class="accordion-body">
            <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label" for="collapsible-phone">Nama Kandidat</label>
                    <input type="text" name ="NamaCandidate" id="collapsible-fullname" class="form-control" /> 
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="collapsible-fullname">Hasil Interview</label>
                    <select name = "hasil_interview" class="form-control" >
                        <option value="PT. HGS" style="weight:50px">Lulus </option>
                        <option value="PT. TGU" style="weight:50px">Tidak Lulus</option>
                    </select> 
                  </div>
          </form>
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

@endsection
