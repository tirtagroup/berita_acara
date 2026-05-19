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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Form Asassment Basic (User)</h4>
<form  action="/asasmen/create_asasmen_basic_1" method="post" enctype="multipart/form-data">
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
  <title>
    Basic
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
                  <input type="hidden" name="Tr_Job_Assesment_all_code" id="collapsible-fullname" class="form-control"  value="{{ $Tr_Job_Assesment_all_code }}" readonly/>
                  <input type="text" name="tr_assessment_code_h" id="collapsible-fullname" class="form-control"  value="{{ $tr_assessment_code_h }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Date</label>
                  <input class="form-control"  type="date" name="Ass_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User</label>
                  <input type="text" name="rec_usercreated" id="collapsible-fullname" class="form-control" value="{{ $user->name  }}" readonly required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Divisi</label>
                  <input type="text" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $operators->emp_iddivision  }}" readonly required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Periode</label>
                  <select   name = 'Ass_periode'class="form-control">
                    <option value="Q1" >Q1</option>
                    <option value="Q2" >Q2</option>
                    <option value="Q3" >Q3</option>
                  </select>
                  {{--  <input type="text" name="Ass_periode" id="collapsible-fullname" class="form-control"   required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Desc</label>
                  <input type="text" name="Ass_desc" id="collapsible-fullname" class="form-control"   required/>
              </div>
            </div>
        </div>
    </div>
</div>
        <form>
          <form  action="/asasmen/create_asasmen_basic_1" method="post" enctype="multipart/form-data">
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
<center><h2>Employees</h2></center>
                    <table class="table table-bordered" id="journal-entrees">
                          <thead>
                            <tr>
                              <th width="12%">Nama</th>
                              <th width="2%">Trust</th>
                              <th width="2%">Drive</th>
                              <th width="2%">Basic</th>
                              <th width="2%">Inisiatif</th>
                              <th width="2%">Hasil</th>
                              <th width="2%">Skill</th>
                              <th width="20%">Note</th>
                            </tr>
                          </thead>
                          <tbody class="row-body">
                          <tr class='entree-row'>
                            <td>
                              <input class="form-control" type="textarea" autoComplete="on"  list="suggestions" name="ass_employeecode[]" value="{{ $user->name }}" readonly />
                          </td>

                            <td>
                                <select   name = 'ass_trust[]'class="form-control">
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>
                                    <option value="10" >10</option>
                                </select>
                            </td>
                            <td>
                                <select  name = 'ass_Drive[]'class="form-control">
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>
                                    <option value="10" >10</option>
                                </select>
                            </td>
                            <td>
                                <select  name = 'ass_basic[]'class="form-control">
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>
                                    <option value="10" >10</option>
                                </select>
                            </td>
                            <td>
                                <select  name = 'ass_inisiatif[]'class="form-control">
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>
                                    <option value="10" >10</option>
                                </select>
                            </td>
                            <td>
                                <select  name = 'ass_hasil[]'class="form-control">
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>
                                    <option value="10" >10</option>
                                </select>
                            </td>
                            <td>
                                <select  name = 'ass_skill[]'class="form-control">
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>
                                    <option value="10" >10</option>
                                </select>
                            </td>
                            <td>
                              <input type="text" name="ass_note[]" id="collapsible-fullname" class="form-control" placeholder="Enter note" required/>
                            </td>
                          </tr>
                            {{--  <tr class="button-row">
                            <td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="15"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
                          </tr>  --}}
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

          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var jenis_vehicle = '<td><select name = "trust1[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var status_vehicle = '<td><select name = "drive1[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript = '<td><select name = "basic1[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript1 = '<td><select name = "inisiatif1[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript2 = '<td><select name = "hasil1[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var descript3 = '<td><select name = "skill1[]"class="form-control"><option value="1" >1</option><option value="2" >2</option> <option value="3" >3</option><option value="4" >4</option> <option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option></select></td>';
          var notes = '<td><input  name="note1[]" class="form-control"  type="text"   required/></td> ';
          //var add_button = '<td style="text-align:center;" colspan="8"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+no_vehicle+select_account+select_account_e+jenis_vehicle+status_vehicle+descript+descript1+descript2+descript3+notes+remove_button+tr_e+tr_btn_s+add_button+tr_e);
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
