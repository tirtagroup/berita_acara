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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Form Asassment Kedisiplinan 2</h4>
{{--  <form  action="/asasmen/detail_employee2" method="post" enctype="multipart/form-data">  --}}
  <form  action="/asasmen/detail_Kedisiplinan_employee2" method="post" enctype="multipart/form-data">

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>
  Kedisiplinan 2
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
                <input type="text" name="Tr_Job_Assesment_all_code" id="collapsible-fullname" class="form-control" value="{{ $code  }}" readonly  required/>
                <input type="hidden" name="tr_assestment_code_h" id="collapsible-fullname" class="form-control" value="{{ $code_header  }}" readonly  required/>
              </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-fullname">Date</label>
              <input class="form-control"  type="date" name="created_at" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Pilih Divisi</label>
                <input type="text" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $nama_divisi  }}" readonly required/>
              </div>
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User</label>
                  <input type="text" name="rec_usercreate" id="collapsible-fullname" class="form-control" value="{{ $user->name  }}" readonly required/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Periode</label>
                <input type="text" name="Ass_periode" id="collapsible-fullname" class="form-control" value="{{ $periode  }}" readonly required/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Desc</label>
                <input type="text" name="Ass_desc" id="collapsible-fullname" class="form-control" value="{{ $desc  }}" readonly required/>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
</div>
<form>
  {{--  <form  action="/asasmen/detail_employee2" method="post" enctype="multipart/form-data">  --}}
    <form  action="/asasmen/detail_Kedisiplinan_employee2" method="post" enctype="multipart/form-data">
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
<center>
  <h2>
    Employees
  </h2>
</center>
            <table class="table table-bordered" id="journal-entrees">
                  <thead>
                    <tr>
                      <th width="12%">Nama Employee</th>
                      <th width="2%">Absensi</th>
                      <th width="2%">Report</th>
                      <th width="2%">Kerajinan</th>
                      <th width="10%">Note</th>
                    </tr>
                  </thead>
                  <tbody class="row-body">

                    @foreach ($disiplin1 as $data)
                      <tr class='entree-row'>
                          <td>
                            <input class="form-control" type="text" autoComplete="on"  list="suggestions" name="ass_employeecode[]" value="{{ $data->employee}}" readonly />
                            {{--  <input class="form-control" type="textarea" autoComplete="on"  list="suggestions" name="ass_employeecode[]" value="{{ $user->name }}"  />  --}}
                          </td>
                          <td>
                            <input class="form-control" type="number" autoComplete="on" value="{{ $data->ass_absen}}" readonly />
                              <select name="ass_absen2[]" class="form-control">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                              </select>
                          </td>
                          <td>
                            <input class="form-control" type="number" autoComplete="on" value="{{ $data->ass_report}}" readonly />
                              <select name="ass_report2[]" class="form-control">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                              </select>
                          </td>
                          <td>
                            <input class="form-control" type="number" autoComplete="on" value="{{ $data->ass_rajin}}" readonly />
                              <select name="ass_rajin2[]" class="form-control">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                              </select>
                          </td>
                          <td>
                            <input class="form-control" type="text" autoComplete="on" value="{{ $data->note}}" readonly />
                            <input class="form-control" type="textarea" autoComplete="on"  name="ass_note2[]"  placeholder="Enter Note"/>
                          </td>
                      </tr>
                    @endforeach
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
