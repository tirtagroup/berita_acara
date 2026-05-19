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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Form Asassment Leadership</h4>


  @if (session('success'))
  <div class="alert alert-primary">
    {{ session('success') }}
  </div>
  @endif

<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>
Leadership
  </title>
</head>

<div class="row">
  <div class="col">
    <div class="nav-align-top mb-3">
      <ul class="nav nav-tabs" role="tablist">
      </ul>
      <form action="/asasmen/asasmen_save_leadership" method="POST" enctype="multipart/form-data">
        @csrf    

      <div class="card">
       
          <div class="row g-3 p-3">
            <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Code</label>
                  <input type="text" name="Tr_Emp_Asses_Code" id="collapsible-fullname" class="form-control" value="{{ $code_asas }}" readonly />
                </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Date</label>
                <input class="form-control"  type="date" name="Ass_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Assesor</label>
                  <input type="text" name="Ms_Emp_Assessor_Code" id="collapsible-fullname" class="form-control" value="{{ $user->username  }}" readonly required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Divisi Assesor</label>
                  <input type="text" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $user->ms_divisi  }}" readonly required/>
              </div>


              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Nama Staff</label>
                  {{-- <select class="js-states form-control" id="single" name="Ms_Emp_Code" >
                      @foreach ($employee as $staff)
                      <option value="{{$staff->emp_name}}">
                          {{$staff->emp_name}}</option>
                      @endforeach
                  </select> --}}
                  <input type="text" name="" id="collapsible-fullname" class="form-control" value="{{ $operators->emp_name  }}"    readonly/>
                  <input type="hidden" name="Ms_Emp_Code" value="{{ $operators->id }}"/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Divisi Staff</label>
                  <input type="text" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{ $operators->emp_subdivision }}"    readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Ms Type Assasment</label>
                  <select name="Ms_type_asses" class="form-control" >
                    <option value="Leadership 1">Leadership 1</option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Jabatan</label>
                <select name="Ms_record_asses" class="form-control" >
                  <option value="Supervisor">Supervisor</option>
                  <option value="HRD">HRD</option>
                </select>
              </div>
        </div>






    <div class="p-3">
      <br>
      <br><center><h2>Rating</h2></center>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Mengarahkan</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="mengarahkan_value_{{ $i }}" name="mengarahkan_value" value="{{ $i }}"  data-type="trust" onclick="updateTotal()">
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="mengarahkan_comment">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Problem Solve</label>
          <div class="col-sm-5">         
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="problem_solving_value_{{ $i }}" name="problem_solving_value" value="{{ $i }}"  data-type="drive" onclick="updateTotal()">
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="problem_solving_comment">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Planing</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="planning_value_{{ $i }}" name="planning_value" value="{{ $i }}"  data-type="inisiative" onclick="updateTotal()">
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="planning_comment">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Analisa</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="analisa_value_{{ $i }}" name="analisa_value" value="{{ $i }}"  data-type="Reliable" onclick="updateTotal()">
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="analisa_comment">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Kualitas komunikasi</label>
          <div class="col-sm-5">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="kualitas_komunikasi_value_{{ $i }}" name="kualitas_komunikasi_value" value="{{ $i }}"  data-type="resluts" onclick="updateTotal()">
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-5">
            <input type="text" class="form-control" placeholder="Enter Comment" name="kualitas_komunikasi_comment">             
          </div>             
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Total Nilai</label>
          <div class="col-sm-5">
            <span id="total-score" style="margin-left: .5rem;">0</span>
          </div>
          <div class="col-sm-5">         
          </div>             
        </div>
      </div>
    </div>
<br>



    </div>
    <br>
    <div class="accordion" id="collapsibleSection">
      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingDeliveryOptions">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">Isi Pesan Disini</button>
        </h2>
        <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection">
    
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
    
              {{--  <div class="col-md-12">
                <label class="form-label" for="collapsible-fullname">Note</label>
                <input type="text" name="note_asses" placeholder="Enter Note" id="collapsible-fullname" class="form-control" />
              </div>
            </div>  --}}
    
    
            <div id="dynamic-container">
              <!-- Existing input element goes here -->
              <div class="input-row">
              </div>
            </div>
            {{--  <button type="button" onclick="addRow()">Add Input</button>  --}}
            <button type="button" onclick="addRow()" style="color: green;" class="add-icon">
              <i class="fas fa-plus"></i>
            </button>
                <div class="col-md-6">
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
       
            <div class="accordion-body">
                    <div class="content je">
                      <div class="pure-g ">
                        <div class="pure-u-1-24 ">
                        </div>
                        <div class="pure-u-11-12">
                    <div class="">
                      <div class="pure-g">
                        <div class="pure-u-1-2">
                          <br>
    
    
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
    
            <!--<a href="/print_asasmen/"class="btn btn-primary me-sm-3 me-1">Submit</a>-->
            <input type="submit" value="Submit" class="btn btn-primary me-sm-3 me-1">
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
      
          </div>
    
    
    
       </div>
    </div>
    </form>    
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
            .add-icon, .remove-icon {
              cursor: pointer;
              margin-left: 5px;
              padding: 0;
              background: none;
              border: none;
            }

      </style>

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
        const trustValue = parseInt($('input[name="mengarahkan_value"]:checked').val()) || 0;
        const driveValue = parseInt($('input[name="problem_solving_value"]:checked').val()) || 0;
        const inisiatValue = parseInt($('input[name="planning_value"]:checked').val()) || 0;
        const reliableValue = parseInt($('input[name="analisa_value"]:checked').val()) || 0;
        const resultValue = parseInt($('input[name="kualitas_komunikasi_value"]:checked').val()) || 0;

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
      function addRow() {
        var container = document.getElementById("dynamic-container");
        var newRow = document.createElement("div");
        newRow.className = "input-row";
        newRow.innerHTML =
          '<span class="remove-icon" onclick="removeRow(this)"> <i class="fas fa-trash-alt" style="color: red;"></i></span>' +
          '<input name="dynamic_input[]" class="form-control" type="text"/>';
        container.appendChild(newRow);
      }

      function removeRow(button) {
        var row = button.parentNode;
        row.parentNode.removeChild(row);
      }
    </script>




@endsection
