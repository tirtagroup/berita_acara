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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Edit Status</h4>
<form  action="/update_status" method="post" enctype="multipart/form-data">
@csrf
<div class="row">
  <div class="col">
    <div class="nav-align-top mb-3">
      <ul class="nav nav-tabs" role="tablist">
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
          <div class="row g-3">
            @foreach ($kandidat as $kandidats)

            @endforeach
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Operator</label>
                  <input type="text" name="rec_usercreated" id="collapsible-fullname" class="form-control" value="{{ $user->username }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Date</label>
                <input type="date" name="rec_datecreated" id="collapsible-fullname" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"  readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Kandidat</label>
                <input type="text" name="kandidat" id="collapsible-fullname" class="form-control" value="{{ $kandidats->Name }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Posisi Yang Dilamar</label>
                <input type="text" name="posisi" id="collapsible-fullname" class="form-control" value="{{ $kandidats->Position_aplly1 }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">No. HP</label>
                <input type="text" name="no_hp" id="collapsible-fullname" class="form-control" value="{{ $kandidats->Handphone }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Email</label>
                <input type="text" name="email" id="collapsible-fullname" class="form-control" value="{{ $kandidats->Email  }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Gaji Yang Diharapkan</label>
                <input type="text" name="Ms_User_Code" id="collapsible-fullname" class="form-control" value="{{ $kandidats->pengajuan_gaji }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Status</label>
                <select class="form-control" name="ms_status_short" >
                        @foreach ($master_short as $ms)
                            <option value="{{$ms->status_desc}}">
                                {{$ms->status_desc}}
                        @endforeach
                      </select>
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
        </div>
       </div>
    </div>
  </div>
</div>


    <script>

        function newRow() {
          var tr_s = "<tr name='entree-row' class='entree-row '>";
          var tr_btn_s = "<tr class='button-row'>";
          var tr_e = "</tr>";
          var account_in_s = '<td> <select name ="Ms_Media_Code[]" class="form-control"> <option value = "Jobstreet">Jobstreet</option><option value = "LinkIdn">LinkIdn</option><option value = "Jobs ID">Jobs ID</option><option value = "Sosial Media">Sosial Media</option><option value = "Olx">Olx</option> </td>';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var debit_in = '<td><select name = "MS_Jabatan_Code[]" class="form-control" ><option value="Gudang" style="weight:50px">Gudang </option><option value="Sales" style="weight:50px">Sales</option><option value="Dispatcher" style="weight:50px">Dispatcher</option>  ></td>';
          var credit_in = '<td><select name = "Ms_Perusahaan_Code[]"class="form-control"><option value="Bukalapak" style="weight:50px">Bukalapak</option> <option value="PT. HGS" style="weight:50px">PT. Handal Guna Sarana </option> <option value="PT. TGU" style="weight:50px">PT. Tirta Gracia Utama</option><option value="PT. TGF" style="weight:50px">PT. Tirta Gracia Fiesta</option></td>';
          var memo_in = '<td><input type="text" name="Qty[]" placeholder="Enter Jumlah" class="form-control" /> ';
          var add_button = '<td style="text-align:center;" colspan="5"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+account_in_s+select_account+select_account_e+debit_in+credit_in+memo_in+remove_button+tr_e+tr_btn_s+add_button+tr_e);
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

            /* #main {
              width: 60%;
              margin: 5%;
            } */
      </style>



@endsection
