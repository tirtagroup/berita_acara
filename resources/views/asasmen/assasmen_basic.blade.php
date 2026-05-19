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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-GLhlTQ8iS01n1LXRqzJ7GOmFStKlLl7pN5A9V3hRGJcb8PeO6PkB5R0M5FflF" crossorigin="anonymous">

@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Assessment Basic</h4>

  @if (session('success'))
  <div class="alert alert-primary">
    {{ session('success') }}
  </div>
  @endif

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>
    Basic
</title>
</head>

<div class="row">
  <div class="col">
    <div class="nav-align-top mb-3">
      <ul class="nav nav-tabs" role="tablist">
      </ul>
      <!--<form action="/asasmen/asasmen_save_basics" method="POST" enctype="multipart/form-data">-->
          <form action="/asasmen/asasmen_save_basics" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf

      <div class="card">

          <div class="row g-3 p-3">
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Code</label>
                    <input class="form-control"  type="text" placeholder="Auto Number" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Date</label>
                  <input class="form-control"  type="date" name="Ass_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Reviewer</label>
                    <input type="text" name="Ms_Emp_Assessor_Code" id="collapsible-fullname" class="form-control" value="{{ $user->username  }}" readonly required/>
                    <input type="hidden" name="" class="form-control" value="{{ $user->id }}"/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Reviewer Div.</label>
                    <input type="text" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $user->ms_divisi  }}" readonly required/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Staff</label>
                    <input type="text" name="" id="collapsible-fullname" class="form-control" value="{{ $operators->emp_name  }}"    readonly/>
                    <input type="hidden" name="Ms_Emp_Code" class="form-control" value="{{ $operators->emp_name }}"/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Staff Division</label>
                    <input type="text" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{ $operators->emp_subdivision  }}"    readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Position</label>
                  <input type="text" id="collapsible-fullname" class="form-control" value="{{ Auth::User()->sub_divisi }}"    readonly/>
                </div>
               <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Periode</label>
                   <select name="ms_periode" class="form-control" id="ms_periodes">
                     <option value="tidak memilih">-- pilih periode --</option>
                     @foreach ($periode as $periodes)
                     <option value="{{$periodes->Ms_Periode_Assessment_Desc}}">
                       {{$periodes->Ms_Periode_Assessment_Desc}}
                     @endforeach
                   </select>
                    {{--  <input type="text" name="ms_periode" class="form-control" id="periodeInput" placeholder="Contoh: 1 Januari - 31 Maret" readonly>  --}}
                </div>
        </div>


    <div class="p-3">
      <br>
      <br><center><h2>Rating</h2></center>


  <div class="row">
    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label" >1. Trust</label>
      <div class="col-sm-5">
         @for($i = -2; $i <= 3; $i++)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="trust_value_{{ $i }}" name="trust_value" value="{{ $i }}"  data-type="trust" onclick="updateTotal()" required>
            <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..." name="trust_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="trust_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="TrustHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-5">
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
            <input class="form-check-input" type="radio" id="drive_value_{{ $i }}" name="drive_value" value="{{ $i }}"  data-type="drive" onclick="updateTotal()" required>
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..." name="drive_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="drive_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="DriveHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-5">
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
            <input class="form-check-input" type="radio" id="inisiative_value_{{ $i }}" name="initiative_value" value="{{ $i }}"  data-type="inisiative" onclick="updateTotal()" required>
            <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..." name="inisiatif_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="inisiative_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="InisiativeHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-5">
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
            <input class="form-check-input" type="radio" id="Reliable_value_{{ $i }}" name="reliable_value" value="{{ $i }}"  data-type="Reliable" onclick="updateTotal()" required>
            <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..." name="reliable_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="Reliable_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label">Penilaian Plus</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="ReliableHigh" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-5">
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
            <input class="form-check-input" type="radio" id="result_{{ $i }}" name="result" value="{{ $i }}"  data-type="resluts" onclick="updateTotal()" required>
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
        @endfor
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Komentar</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..." name="result_comment" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Saran</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="result_suggestion" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="highTrustComment" class="col-sm-2 col-form-label ">Penilaian Plus</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="ResultHighs" required>
      </div>
    </div>
    <div class="mb-3 row">
      <label for="lowTrustComment" class="col-sm-2 col-form-label">Penilaian Minus</label>
      <div class="col-sm-5">
        <input type="text" class="form-control wide-input" placeholder="..."  name="ResultLows" required>
      </div>
    </div>
  </div>

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
    </div>

    <br><center><h2>Tugas</h2></center>
          <div class="accordion-body">
            <div class="content je">
              <div class="pure-g ">
                <div class="pure-u-1-24 ">
                </div>
                <div class="pure-u-11-12">
            <div class="">
              <div class="pure-g">
                <div class="pure-u-1-2">
        <div class="container">

{{-- Untuk Dynamic Row --}}
        <div id="dynamic-container">
          <!-- Existing input element goes here -->
          <div class="input-row">
          </div>
        </div>
        <p>
          <span class="arrow-down"></span> klik disini untuk menambah tugas.
        </p>
        <button type="button" onclick="addRow()" style="color: green;" class="add-icon">
          <i class="fas fa-plus"></i>
        </button>

        </div>
      </div>
    </div>
  </div>
</div>
<br>
            <input type="submit" value="Submit" class="btn btn-primary me-sm-3 me-1">
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
          </div>
       </div>
    </div>
    </form>
  </div>

  <script>
    var rowNum = 1;

    function addRow() {
      var container = document.getElementById("dynamic-container");

      // Function to create a divider
      function createDivider() {
        var divider = document.createElement("hr");
        divider.className = "row-divider";
        container.appendChild(divider);
      }

      var rowNumber = rowNum++;

      // Job, Date, Reviewer, Status, Quality
      var firstRow = document.createElement("div");
      firstRow.className = "input-row row";
      firstRow.innerHTML = '<div class="col-md-6">' +
          '<label style="color: rgb(0, 0, 255);" class="bold-italic" for="type">(' + rowNumber + ').Tugas</label>'+
          '<input class="form-control" type="text" placeholder="Enter Tugas.." required name="TaskDesc[]" required>'+
        '</div>'+
        '<div class="col-md-3">'+
            '<label class="bold-italic" for="type">Date</label>'+
            '<input class="form-control" type="date" name="DateTask[]" required>'+
        '</div>'+
        '<div class="col-md-3">'+
            '<label class="bold-italic" for="type">Reviewer</label>'+
            '<input class="form-control" type="text" name="Ms_Reviewer_Code[]"  value="{{ Auth::User()->name }}" readonly>'+
        '</div>';
      container.appendChild(firstRow);

      // Adding new rows
      var secondRow = document.createElement("div");
      secondRow.className = "input-row row";
      secondRow.innerHTML = '<div class="col-md-6">'+
          '<label class="bold-italic" for="resultHigh">ResultPlus</label>'+
          '<input name="ResultHigh[]" class="form-control" type="text" placeholder="Enter Result Plus.." required/>'+
        '</div>'+
        '<div class="col-md-6">'+
            '<label class="bold-italic" for="resultLow">ResultMinus</label>'+
            '<input name="ResultLow[]" class="form-control" type="text"  placeholder="Enter Result Minus.." required/>'+
        '</div>';
      container.appendChild(secondRow);

      // Adding new rows
      var thirdRow = document.createElement("div");
      thirdRow.className = "input-row row";
      thirdRow.innerHTML = '<div class="col-md-6">' +
          '<label class="bold-italic" for="resultDesc">Komentar </label>'+
          '<input name="ResultDesc[]" class="form-control" type="text" placeholder="Enter Komentar.." required/>'+
        '</div>'+
        '<div class="col-md-6">'+
            '<label class="bold-italic" for="suggest">Saran</label>'+
            '<input name="SugestReviewer[]" class="form-control" type="text"  placeholder="Enter Suggest" required/>'+
        '</div>';
      container.appendChild(thirdRow);

      // Adding new rows
      var fourRow = document.createElement("div");
      fourRow.className = "input-row row";
      fourRow.innerHTML = '<div class="col-md-1">'+
          '<label class="bold-italic" for="resultDesc">Quality: </label>'+
          '<input name="Quality[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
        '</div>'+
        '<div class="col-md-1">'+
            '<label class="bold-italic" for="suggest">Solutif:</label>'+
            '<input name="Solutif[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0"  min="-2" max="3" required/>'+
        '</div>'+
        '<div class="col-md-1">'+
            '<label class="bold-italic" for="suggest">Inisiatif:</label>'+
            '<input name="Inisiatif[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
        '</div>'+
        '<div class="col-md-1">'+
            '<label class="bold-italic" for="suggest">Tuntas:</label>'+
            '<input name="Tuntas[]" class="form-control" type="number" inputmode="numeric" step="1"  value="0" min="-2" max="3" required/>'+
        '</div>'+
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

      // Menambahkan pembatas

    }

    function removeRow(icon) {
      var row = icon.closest('.input-row');
      var divider = row.nextElementSibling; // Assuming the divider is always next to the row
      row.remove();
      divider.remove();
    }

    // Menambahkan event listener untuk mengubah warna input type number
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
          const inisiatValue = parseInt($('input[name="initiative_value"]:checked').val()) || 0;
          const reliableValue = parseInt($('input[name="reliable_value"]:checked').val()) || 0;
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
        // Mendapatkan tanggal saat ini
        var currentDate = new Date();
        // Mendapatkan bulan dari tanggal saat ini (0-11)
        var currentMonth = currentDate.getMonth();
        // Mengatur nilai input berdasarkan bulan
        var periodeInput = document.getElementById("periodeInput");

        if (currentMonth >= 0 && currentMonth <= 2) {
            periodeInput.value = "Q1";
        } else if (currentMonth >= 3 && currentMonth <= 5) {
            periodeInput.value = "Q2";
        } else if (currentMonth >= 6 && currentMonth <= 8) {
            periodeInput.value = "Q3";
        } else {
            periodeInput.value = "Q4";
        }
    </script>
    
    <script>
      function validateForm() {
        var periode = document.getElementById('ms_periodes').value;
        if (periode == 'tidak memilih') {
          alert("Harap pilih periode yang valid.");
          return false;  // Mencegah form untuk disubmit
        }
        return true;  // Form akan disubmit jika validasi lulus
      }
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
      #dynamic-table th:nth-child(2),
      #dynamic-table td:nth-child(2) {
          display: none;
      }
      table#dynamic-table {
        width: 100%;
        border-collapse: collapse;
    }

    #dynamic-table th,
    #dynamic-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #dynamic-table th {
        font-size: smaller;
    }

    /* Atur lebar kolom individu */
    #dynamic-table th:nth-child(1),
    #dynamic-table td:nth-child(1) {
        width: 2%;
    }

    #dynamic-table th:nth-child(2),
    #dynamic-table td:nth-child(2) {
        width: 1%;
    }

    #dynamic-table th:nth-child(3),
    #dynamic-table td:nth-child(3) {
        width: 55%; /* Atur lebar kolom "Job" */
    }

    /* Kolom lain disesuaikan agar total lebar tetap 100% */
    #dynamic-table th:nth-child(4),
    #dynamic-table td:nth-child(4),
    #dynamic-table th:nth-child(5),
    #dynamic-table td:nth-child(5),
    #dynamic-table th:nth-child(6),
    #dynamic-table td:nth-child(6),
    #dynamic-table th:nth-child(7),
    #dynamic-table td:nth-child(7),
    #dynamic-table th:nth-child(8),
    #dynamic-table td:nth-child(8),
    #dynamic-table th:nth-child(9),
    #dynamic-table td:nth-child(9),
    #dynamic-table th:nth-child(10),
    #dynamic-table td:nth-child(10),
    #dynamic-table th:nth-child(11),
    #dynamic-table td:nth-child(11),
    #dynamic-table th:nth-child(12),
    #dynamic-table td:nth-child(12) {
    width: 3.4%; /* Disesuaikan agar total lebar tetap 100% */
    }
    .purple-label {
    color: rgb(0, 0, 255);
    font-style: italic;
    }
    .wide-input {
    width: 200%;
    }
    .row-divider {
      border-top: 2px solid rgb(253, 3, 3);
      margin-top: 10px;
      margin-bottom: 10px;
  }
</style>

@endsection
