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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Form Asassment Disiplin 2</h4>
<form  action="/asasmen/asasmen_disiplin_detail2" method="post" enctype="multipart/form-data">

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>
Disiplin
  </title>
</head>
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
              <label class="form-label" for="collapsible-fullname">Code</label>
                <input type="text" name="Tr_report_main_code" id="collapsible-fullname" class="form-control"  value="{{ $Tr_Job_Assesment_all_code }}" readonly/>
                <input type="hidden" name="tr_assessment_code_h" id="collapsible-fullname" class="form-control" value="{{ $tr_assessment_code_h  }}" readonly  required/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-fullname">Date</label>
              <input class="form-control"  type="date" name="created_at" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Pilih Divisi</label>
                <select class="form-control"  name="nama_divisi" >
                  @foreach ($ms_divisi as $divisi)
                      <option value="{{$divisi->div_desc}}">
                          {{$divisi->div_desc}}
                  @endforeach
                </select>
                {{--  <a href="/security/report_closing/{{ $tipe->Tr_report_main_code }}" class="btn btn-warning edit" data-id="{{ $tipe->Tr_report_main_code }}">Closing</a>  --}}
              </div>
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User</label>
                  <input type="text" name="rec_usercreate" id="collapsible-fullname" class="form-control" value="{{ $user->name  }}" readonly required/>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Periode</label>
                  <input type="text" name="Ass_periode" id="collapsible-fullname" class="form-control"  required/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Desc</label>
                <input type="text" name="Ass_desc" id="collapsible-fullname" class="form-control" placeholder="Enter note" required/>
            </div>
            <div>
              <button class="btn btn-warning" type="submit">Proccess</button>
              {{--  <a href="/asasmen/detail_employee2" class="btn btn-warning edit">Proccess</a>  --}}
              {{--  <a href="/asasmen/detail_employee2/{{$divisi->div_desc}}" class="btn btn-warning edit">Proccess</a>  --}}
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
          var no_vehicle = '<td><input  name="no_vehicle[]" class="form-control"  type="text"   required/></td> ';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var jenis_vehicle = '<td><select name = "jenis_vehicle[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var status_vehicle = '<td><select name = "jenis_vehicle[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript = '<td><select name = "jenis_vehicle[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript1 = '<td><select name = "jenis_vehicle[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript2 = '<td><select name = "jenis_vehicle[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript3 = '<td><select name = "jenis_vehicle[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var add_button = '<td style="text-align:center;" colspan="8"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+no_vehicle+select_account+select_account_e+jenis_vehicle+status_vehicle+descript+descript1+descript2+descript3+remove_button+tr_e+tr_btn_s+add_button+tr_e);
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
            .option-font
            {
                font-size: 16px;
            }
      </style>



@endsection
