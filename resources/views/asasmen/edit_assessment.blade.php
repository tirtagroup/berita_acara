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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Edit Assessment Basic </h4>


  @if (session('success'))
  <div class="alert alert-primary">
    {{ session('success') }}
  </div>
  @endif

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
  <title>
    Edit Assessment
  </title>
</head>

<div class="row">
  <div class="col">
    <div class="nav-align-top mb-3">
      <ul class="nav nav-tabs" role="tablist">
      </ul>
      @foreach ($mains as $main)
      <form action="/assassment/update_basic/{{$main->Tr_Review_EmpPeriod_Code_h}}" method="POST" enctype="multipart/form-data">
        @csrf

      <div class="card">

          <div class="row g-3 p-3">
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Code</label>
                    <input type="text"  id="collapsible-fullname" class="form-control" name="code_main" value="{{ $main->Tr_Review_EmpPeriod_Code_h }}" readonly />
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Date Input</label>
                  <input class="form-control"  type="date"  value="@php $dateconv = strtotime($main->created_at); echo date('Y-m-d', $dateconv);  @endphp" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Reviewer</label>
                    <input type="hidden"  id="collapsible-fullname" class="form-control" value="{{ Auth::User()->name  }}" readonly required/>
                    <input type="text" class="form-control" value="{{ Auth::User()->name   }}" readonly/>
                  </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Staff</label>
                    <input type="hidden"  id="collapsible-fullname" class="form-control" value="{{ $main->Ms_Emp_Code  }}"    readonly/>
                    <input type="text"  name="Ms_Emp_Code" class="form-control" value="{{ $main->Ms_Emp_Code }}" readonly/>
                  </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Staff Div.</label>
                    <input type="text" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{ $main->Ms_Emp_Div  }}"    readonly/>
                </div>
                 <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Last Reviewer</label>
                    @if($main->rec_userupdate == null)
                    <input type="text"  class="form-control" value="{{ $main->rec_usercreated }}" readonly/>
                    @else
                    <input type="text"  class="form-control" value="{{ $main->rec_userupdate  }}" readonly/>
                    @endif
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Periode</label>
                    <input type="text" name="ms_periode" class="form-control" value="{{ $main->Ms_Periode  }}" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Total BA</label>

                </div>
                @endforeach
        </div>


    <div class="p-3">
      <br>
       @if (in_array(Auth::user()->sub_divisi, ['Manager Finance', 'General Manager', 'BOD', 'Manager Operasional']))

      @foreach($heading as $row)
      <br><center><h3 style="font-weight: bold; font-style: italic;">Rating By : <em style="color: rgb(0, 0, 255);">{{ $row->Ms_Reviewer_Code }}</em></h3></center>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label purple-label" >1. Trust</label>
          <div class="col-sm-5">
             @for($i = -2; $i <= 3; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($row->Trust_value == $i){ echo "checked";}else{ echo "disabled='disabled'";} ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->trust_comment }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->trust_suggestion }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->TrustHigh }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->TrustLow }}" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label purple-label">2. Drive</label>
          <div class="col-sm-5">
             @for($i = -2; $i <= 3; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="drive" <?php if($row->drive_value == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->drive_comment }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->drive_suggestion }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->DriveHigh }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->DriveLow }}" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label purple-label">3. Initiative</label>
          <div class="col-sm-5">
             @for($i = -2; $i <= 3; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="inisiative" <?php if($row->inisiative_value == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->inisiatif_comment }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->inisiative_suggestion }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->InisiativeHigh }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->InisitativeLow }}" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label purple-label">4. Reliable</label>
          <div class="col-sm-5">
             @for($i = -2; $i <= 3; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="Reliable" <?php if($row->Reliable_value == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->reliable_comment }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->Reliable_suggestion }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->ReliableHigh }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->ReliableLow }}" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label purple-label">5. Result</label>
          <div class="col-sm-5">
             @for($i = -2; $i <= 3; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="resluts" <?php if($row->result == $i){ echo "checked";}else{ echo "disabled='disabled'";}  ?> />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->result_comment }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->result_suggestion }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->ResultHigh }}" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
            <div class="col-sm-10">
              <input type="text" class="form-control wide-input" value="{{ $row->ResultLow }}" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Total Nilai</label>
          <div class="col-sm-5">
            <span  style="margin-left: .5rem;">{{ $row->Trust_value+$row->drive_value+$row->inisiative_value+$row->Reliable_value+$row->result }}</span>
          </div>
          <div class="col-sm-5">
          </div>
        </div>
      </div>
      @endforeach
    </div>
@endif

<div class="p-3">
@if ($main->rec_usercreated == Auth::User()->name || $main->rec_userupdate == Auth::User()->name )
<div class="row">
    <div class="mb-3 row">
      <center><h4 style="font-weight: bold; font-style: italic; color: rgb(0, 0, 255);">Anda Sudah Assessment Di Periode Ini </h4></center>
    </div>
  </div>

@else
<div class="p-3">
  <center><h3 style="font-weight: bold; font-style: italic;">Rating By : <em style="color: rgb(0, 0, 255);">{{ Auth::User()->name }}</em></h3></center>
  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label" >1. Trust</label>
      <div class="col-sm-5">
         @for($i = -2; $i <= 3; $i++)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="trust_value_{{ $i }}" name="trust_value" value="{{ $i }}"  data-type="trust" onclick="updateTotal()">
            <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..." name="trust_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="trust_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="TrustHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="TrustLow" required>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">2. Drive</label>
      <div class="col-sm-5">
         @for($i = -2; $i <= 3; $i++)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="drive_value_{{ $i }}" name="drive_value" value="{{ $i }}"  data-type="drive" onclick="updateTotal()">
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..." name="drive_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="drive_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="DriveHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="DriveLow" required>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">3. Initiative</label>
      <div class="col-sm-5">
         @for($i = -2; $i <= 3; $i++)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="inisiative_value_{{ $i }}" name="inisiative_value" value="{{ $i }}"  data-type="inisiative" onclick="updateTotal()">
            <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..." name="inisiatif_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="inisiative_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="InisiativeHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="InisitativeLow" required>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">4. Reliable</label>
      <div class="col-sm-5">
         @for($i = -2; $i <= 3; $i++)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="Reliable_value_{{ $i }}" name="Reliable_value" value="{{ $i }}"  data-type="Reliable" onclick="updateTotal()">
            <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..." name="reliable_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="Reliable_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="ReliableHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="ReliableLow" required>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">5. Result</label>
      <div class="col-sm-5">
         @for($i = -2; $i <= 3; $i++)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="result_{{ $i }}" name="result" value="{{ $i }}"  data-type="resluts" onclick="updateTotal()">
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..." name="result_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="result_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Penilaian Plus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="ResultHighs" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-10">
        <input type="text" class="form-control wide-input" placeholder="..."  name="ResultLows" required>
      </div>
    </div>
  </div>
  @endif
  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Totals</label>
      <div class="col-sm-5">
        <span id="total-score" style="margin-left: .5rem;">0</span>
      </div>
      <div class="col-sm-5">
      </div>
    </div>
  </div>


<br><center><h2>Tugas</h2></center>
      <div class="accordion-body">
        <div class="content je">
          <div class="pure-g ">
            <div class="pure-u-1-24 ">
              @foreach ($tugas as $key => $task)
              <div class="input-row row">
                  <!-- First row -->
                  <div class="col-md-6">
                      <label style="color: rgb(0, 0, 255);" class="bold-italic" for="type">({{ $key + 1 }}).Tugas</label>
                      <input class="form-control" type="text" value="{{ $task->TaskDesc }}" style="color: rgb(0, 0, 255);" readonly>
                  </div>
                  <div class="col-md-3" >
                      <label class="bold-italic" for="type">Date</label>
                      <input class="form-control" type="date" value="{{ $task->DateTask }}" readonly>
                  </div>
                  <div class="col-md-3">
                      <label class="bold-italic" for="type">Reviewer</label>
                      <input class="form-control" type="text" value="{{ $task->Ms_Reviewer_Code }}" readonly>
                  </div>
                  <!-- Second row -->
                  <div class="col-md-6">
                      <label class="bold-italic" for="resultHigh">ResultPlus</label>
                      <input class="form-control" type="text" value="{{ $task->ResultHigh }}" readonly>
                  </div>
                  <div class="col-md-6">
                      <label class="bold-italic" for="resultLow">ResultMinus</label>
                      <input class="form-control" type="text" value="{{ $task->ResultLow }}" readonly>
                  </div>

                  <!-- Third row -->
                  <div class="col-md-6">
                      <label class="bold-italic" for="resultDesc">Komentar </label>
                      <input class="form-control" type="text" value="{{ $task->ResultDesc }}" readonly>
                  </div>
                  <div class="col-md-6">
                      <label class="bold-italic" for="suggest">Suggest</label>
                      <input class="form-control" type="text" value="{{ $task->Suggest_BOD }}" readonly>
                  </div>

                  <!-- Fourth row -->
                  <div class="col-md-1">
                      <label class="bold-italic" for="resultDesc">Quality: </label>
                      <input class="form-control" type="text" value="{{ $task->Quality }}" readonly style="color:{{ $task->Quality <= 0 ? 'red' : 'green' }}">
                  </div>
                  <div class="col-md-1">
                      <label class="bold-italic" for="suggest">Solutif:</label>
                      <input class="form-control" type="text" value="{{ $task->Solutif }}" readonly style="color:{{ $task->Solutif <= 0 ? 'red' : 'green' }}">
                  </div>
                  <div class="col-md-1">
                      <label class="bold-italic" for="suggest">Inisiatif:</label>
                      <input class="form-control" type="text" value="{{ $task->Inisiatif }}" readonly style="color:{{ $task->Inisiatif <= 0 ? 'red' : 'green' }}">
                  </div>
                  <div class="col-md-1">
                      <label class="bold-italic" for="suggest">Tuntas:</label>
                      <input class="form-control" type="text" value="{{ $task->Tuntas }}" readonly style="color:{{ $task->Tuntas <= 0 ? 'red' : 'green' }}">
                  </div>
                  <div class="col-md-1">
                    <label class="bold-italic" for="suggest">Kualitas:</label>
                    <input class="form-control" type="text" value="{{ $task->Kualitas }}" readonly style="color:{{ $task->Kualitas <= 0 ? 'red' : 'green' }}">
                </div>
                <div class="col-md-1">
                  <label class="bold-italic" for="suggest">Kecepatan:</label>
                  <input class="form-control" type="text" value="{{ $task->Kecepatan }}" readonly style="color:{{ $task->Kecepatan <= 0 ? 'red' : 'green' }}">
                </div>
                <div class="col-md-1">
                    <label class="bold-italic" for="suggest">Update:</label>
                    <input class="form-control" type="text" value="{{ $task->Update }}" readonly style="color:{{ $task->Update <= 0 ? 'red' : 'green' }}">
                </div>
                <div class="col-md-1">
                  <label class="bold-italic" for="suggest">Hasil:</label>
                  <input class="form-control" type="text" value="{{ $task->Hasil }}" readonly style="color:{{ $task->Hasil <= 0 ? 'red' : 'green' }}">
                </div>
                <div class="col-md-1">
                  <label class="bold-italic" for="suggest">Konsisten:</label>
                      <input class="form-control" type="text" value="{{ $task->Konsisten }}" readonly style="color:{{ $task->Konsisten <= 0 ? 'red' : 'green' }}">
                    </div>
                    <div class="col-md-1">
                      <label class="bold-italic" for="suggest">Tanggap:</label>
                      <input class="form-control" type="text" value="{{ $task->Tanggap }}" readonly style="color:{{ $task->Tanggap <= 0 ? 'red' : 'green' }}">
                    </div>
                    <div class="col-md-2">
                      <label class="bold-italic" for="status">Status:</label>
                      <input class="form-control" type="text" value="{{ $task->Ms_Task_Status }}" readonly>
                    </div>
                    <hr style="border: 1px solid rgb(0, 0, 255); margin: 10px 0;">
              </div>
      @endforeach

<br><center><h2>Tambah Tugas</h2></center>

    <div id="dynamic-container">
      <div class="input-row">
      </div>
    </div>
    <p>
      <span class="arrow-down"></span> Click icon here to add target
    </p>
    <button type="button" onclick="addRow()" style="color: green;" class="add-icon">
      <i class="fas fa-plus"></i>
    </button>

      <div class="mt-1">

        <!--<a href="/print_asasmen/"class="btn btn-primary me-sm-3 me-1">Submit</a>-->
        <input type="submit" value="Submit" class="btn btn-primary me-sm-3 me-1">
        <button type="reset" class="btn btn-label-secondary">Cancel</button>

      </div>
   </div>
</div>
</form>



      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <!-- Select2 -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
      <script>
        $("#single").select2({
            placeholder: "Select Employee",
            allowClear: true
        });
        $("#multiple").select2({
            placeholder: "Select Employee",
            allowClear: true
        });
        $(document).ready(function () {

        $("#repeatDivBtn").click(function () {

          $newid = $(this).data("increment");
          $repeatDiv = $("#repeatDiv").wrap('<div/>').parent().html();
          $('#repeatDiv').unwrap();
          $($repeatDiv).insertAfter($(".repeatDiv").last());
          $(".repeatDiv").last().attr('id',   "repeatDiv" + '_' + $newid);
          $("#repeatDiv" + '_' + $newid).append('<div class="input-group-append"><button type="button" class="btn btn-danger removeDivBtn" data-id="repeatDiv'+'_'+ $newid+'">Remove</button></div>');
          $newid++;
          $(this).data("increment", $newid);

        });


        $(document).on('click', '.removeDivBtn', function () {

          $divId = $(this).data("id");
          $("#"+$divId).remove();
          $inc = $("#repeatDivBtn").data("increment");
          $("#repeatDivBtn").data("increment", $inc-1);

        });

        });


      </script>

      <script>
       // Fungsi untuk mengupdate total nilai
      function updateTotal() {
        // Inisialisasi total nilai
        let totalValue = 0;

        // Mendapatkan nilai terpilih untuk masing-masing grup
        const trustValue = parseInt($('input[name="trust_value"]:checked').val()) || 0;
        const driveValue = parseInt($('input[name="drive_value"]:checked').val()) || 0;
        const inisiatValue = parseInt($('input[name="inisiative_value"]:checked').val()) || 0;
        const reliableValue = parseInt($('input[name="Reliable_value"]:checked').val()) || 0;
        const resultValue = parseInt($('input[name="result"]:checked').val()) || 0;

        // Menghitung total nilai
        totalValue = trustValue + driveValue + inisiatValue + reliableValue + resultValue;

        // Menampilkan total nilai
        $('#total-score').text(totalValue);

        // Menetapkan warna total berdasarkan kondisi
        if (totalValue > 10) {
          $('#total-score').css('color', 'red');
        } else {
          $('#total-score').css('color', 'red'); // atau warna lain sesuai kebutuhan
        }
      }
    </script>


    <script>
      var rowNum = 1;

      function addRow() {
          var container = document.getElementById("dynamic-container");

          function createDivider() {
              var divider = document.createElement("hr");
              divider.className = "row-divider";
              container.appendChild(divider);
          }

          var rowNumber = rowNum++;

          var firstRow = document.createElement("div");
          firstRow.className = "input-row row";
          firstRow.innerHTML = '<div class="col-md-6">' +
              '<label style="color: rgb(0, 0, 255);" class="bold-italic" for="type">(' + rowNumber + ').Tugas Tambahan</label>' +
              '<input class="form-control" type="text" placeholder="Enter Tugas.." required name="TaskDesc[]">' +
              '</div>' +
              '<div class="col-md-3">' +
              '<label class="bold-italic" for="type">Date</label>' +
              '<input class="form-control" type="date" name="DateTask[]">' +
              '</div>' +
              '<div class="col-md-3">' +
              '<label class="bold-italic" for="type">Reviewer</label>' +
              '<input class="form-control" type="text" name="Ms_Reviewer_Code[]" value="{{ Auth::User()->name }}" readonly>' +
              '</div>';
          container.appendChild(firstRow);

          var secondRow = document.createElement("div");
          secondRow.className = "input-row row";
          secondRow.innerHTML = '<div class="col-md-6">' +
              '<label class="bold-italic" for="resultHigh">ResultPlus</label>' +
              '<input name="ResultHigh[]" class="form-control" type="text" placeholder="Enter Result Plus.." required/>' +
              '</div>' +
              '<div class="col-md-6">' +
              '<label class="bold-italic" for="resultLow">ResultMinus</label>' +
              '<input name="ResultLow[]" class="form-control" type="text"  placeholder="Enter Result Minus.." required/>' +
              '</div>';
          container.appendChild(secondRow);

          var thirdRow = document.createElement("div");
          thirdRow.className = "input-row row";
          thirdRow.innerHTML = '<div class="col-md-6">' +
              '<label class="bold-italic" for="resultDesc">Komentar </label>' +
              '<input name="ResultDesc[]" class="form-control" type="text" placeholder="Enter Komentar.." required/>' +
              '</div>' +
              '<div class="col-md-6">' +
              '<label class="bold-italic" for="suggest">Suggest</label>' +
              '<input name="SugestReviewer[]" class="form-control" type="text"  placeholder="Enter Suggest" required/>' +
              '</div>';
          container.appendChild(thirdRow);

          var fourRow = document.createElement("div");
          fourRow.className = "input-row row";
          fourRow.innerHTML = '<div class="col-md-1">' +
              '<label class="bold-italic" for="resultDesc">Quality: </label>' +
              '<input name="Quality[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
              '</div>' +
              '<div class="col-md-1">' +
              '<label class="bold-italic" for="suggest">Solutif:</label>' +
              '<input name="Solutif[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0"  min="-2" max="3" required/>'+
              '</div>' +
              '<div class="col-md-1">' +
              '<label class="bold-italic" for="suggest">Inisiatif:</label>' +
              '<input name="Inisiatif[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>' +
              '</div>' +
              '<div class="col-md-1">' +
              '<label class="bold-italic" for="suggest">Tuntas:</label>' +
              '<input name="Tuntas[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
              '</div>' +
              '<div class="col-md-1">'+
                '<label class="bold-italic" for="suggest">Kecepatan:</label>'+
                '<input name="Kecepatan[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
              '</div>'+
              '<div class="col-md-1">'+
                  '<label class="bold-italic" for="suggest">Update:</label>'+
                  '<input name="Update[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
              '</div>'+
              '<div class="col-md-1">'+
                '<label class="bold-italic" for="suggest">Hasil:</label>'+
                '<input name="Hasil[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
              '</div>'+
              '<div class="col-md-1">'+
                '<label class="bold-italic" for="suggest">Konsisten:</label>'+
                '<input name="Konsisten[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
              '</div>'+
              '<div class="col-md-1">'+
                '<label class="bold-italic" for="suggest">Tanggap:</label>'+
                '<input name="Tanggap[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
              '</div>'+
              '<div class="col-md-2">' +
                '<label class="bold-italic" for="status">Status:</label>' +
                '<select name="Ms_Task_Status[]" class="form-control" >' +
                '  <option value="Finish">Finish</option>' +
                '  <option value="In Progress">In Progress</option>' +
                '  <option value="Unhandle">Unhandle</option>' +
                '  <option value="Pending">Pending</option>' +
                '  <option value="Fail">Fail</option>' +
                '</select>' +
                '</div>'+
                '<hr style="border: 1px solid rgb(0, 0, 255); margin: 10px 0;">';
          container.appendChild(fourRow);

          // ... (lanjutkan dengan menambahkan baris-baris berikutnya)


      }

      function removeRow(icon) {
          var row = icon.closest('.input-row');
          var divider = row.nextElementSibling;
          row.remove();
          divider.remove();
      }
      document.addEventListener('input', function(event) {
        var target = event.target;
        if (target.classList.contains('form-control') && target.type === 'number') {
          var value = parseInt(target.value);
          if (value > 0) {
            target.style.color = 'green';
          } else if (value < 0) {
            target.style.color = 'red';
          } else {
            target.style.color = ''; // Default color if value is 0
          }
        }
      });
  </script>






  <style>

    .arrow-down {
      width: 0;
      height: 0;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-top: 15px solid green; /* Sesuaikan dengan warna tombol Anda */
      display: inline-block;
      margin-right: 5px; /* Sesuaikan dengan ruang antara tanda panah dan tombol */
    }

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
    .add-icon, .remove-icon {
      cursor: pointer;
      margin-left: 5px;
      padding: 0;
      background: none;
      border: none;
    }
    .input-row {
      display: flex;
      align-items: center;
    }

    .input-row input {
      margin-right: 10px;
    }
    .bold-italic {
      font-weight: bold;
      font-style: italic;
    }
     #myTable th:first-child,
     #myTable td:first-child {
    display: none;
    }
    .purple-label {
      color: rgb(0, 0, 255);
      font-style: italic;
      }
      .row-divider {
        border-top: 2px solid rgb(0, 0, 255);
        margin-top: 10px;
        margin-bottom: 10px;

  </style>


@endsection
