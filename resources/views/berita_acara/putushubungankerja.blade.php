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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Pemutusan Hubungan Kerja</h4>
<form  action="/form_phk" method="post" enctype="multipart/form-data">
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
                <input type="text" name="sp_main_code" id="collapsible-fullname" class="form-control" placeholder="Auto Number" value="{{ $sp_main_code }}" readonly/>
                <input type="hidden" name="tr_acc_sp_h_code" id="collapsible-fullname" class="form-control" placeholder="Auto Number" value="{{ $tr_acc_sp_h_code }}" readonly />
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Date</label>
              <input class="form-control"  type="date" name="rec_datecreated" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Company </label>
                    <select class="form-control" name="ms_company" >
                        @foreach ($pt as $nama_pt)
                            <option value="{{$nama_pt->description}}">
                                {{$nama_pt->description}}
                        @endforeach
                    </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                    <select class="form-control" name="ms_lokasi" >
                        @foreach ($lokasi as $loc)
                            <option value="{{$loc->lokasi_desc}}">
                                {{$loc->lokasi_desc}}
                        @endforeach
                    </select>
              </div>
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User</label>
                    <input type="text" name="rec_usercreated" id="collapsible-fullname" class="form-control" placeholder="Admin" value="{{ $user->name}}" readonly/>
              </div>
              <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Employee</label>
              <input type="text" name="sp_employee" id="collapsible-fullname" class="form-control" value="{{$pegawainya->emp_id}}" readonly/>

            </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Divisi</label>
                    <input type="text" name="sp_divisi" id="collapsible-fullname" class="form-control" value="{{$pegawainya->emp_iddivision}}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Berlaku Sampai</label>
                  <input class="form-control"  type="date" name="masa_berlaku" required/>
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
          <form  action="/form_phk" method="post" enctype="multipart/form-data">
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
                              <th style="width:1px">No. </th>
                              <th>Catatan</th>
                            </tr>
                          </thead>
                          <tbody class="row-body">
                          <tr class='entree-row'>
                            <td>
                              1
                            </td>
                            <td>
                              <input  name="sp_note[]" class="form-control"  type="text"   required/>
                            </td>
                          </tr>
                          <tr class="button-row">
                            <td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="6"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
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
          var account_in_s = '<td>2</td> ';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var debit_in = '<td><input   onkeyUp="update_in(\'debit_in\');" name="sp_note[]" class="form-control"  type="text"  ></td>';
          //var credit_in = '<td><input  onkeyUp="update_in(\'credit_in\');" name="usia[]" class="form-control"  type="text"  ></td>';
          //var t1 = '<td><input name="penguji[]" class="form-control"  type="text"   required/></td> ';
          //var t2 = '<td><input name="avg_income[]" class="form-control"  type="text"   required/></td> ';
          //var t3 = '<td><input name="istirahat_last[]" class="form-control"  type="text"   required/></td> ';
          var add_button = '<td style="text-align:center;" colspan="6"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+account_in_s+debit_in+select_account+select_account_e+remove_button+tr_e+tr_btn_s+add_button+tr_e);
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
