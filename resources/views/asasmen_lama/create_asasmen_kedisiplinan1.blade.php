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
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Form Asassment Kedisiplinan</h4>
<form  action="/asasmen/create_asasmen_kedisiplinan1" method="post" enctype="multipart/form-data" id="myForm2">
<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>Kedisiplinan</title>
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
                  <input type="hidden" name="Tr_Job_Assesment_all_code" id="collapsible-fullname" class="form-control"  value="{{ $Tr_Job_Assesment_all_code ?? '' }}" readonly/>
                  <input type="text" name="tr_assessment_code_h" id="collapsible-fullname" class="form-control"  value="{{ $tr_assessment_code_h ?? '' }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Date</label>
                  <input class="form-control"  type="date" name="Ass_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User</label>
                  <input type="text" name="rec_usercreated" id="collapsible-fullname" class="form-control" value="{{ $user->name  }}" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Divisi</label>
                <input type="text" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $user->ms_divisi }}" readonly required/>
            </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Periode</label>
                  <input type="text" name="Ass_periode" id="collapsible-fullname" class="form-control"   required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Desc</label>
                  <input type="text" name="Ass_desc" id="collapsible-fullname" class="form-control"   required/>
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
                    <center><h2>Employees</h2></center>
                    <table class="table table-bordered" id="journal-entrees2">
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
                            <tr class='entree-row'>
                              <td>
                                  <input type="text" name="ass_employeecode[]" class="form-control" value="{{ $user->name }}" readonly/>
                              </td>
                              <td>
                                  <select name="ass_absen[]" class="form-control">
                                      @for ($i = 1; $i <= 10; $i++)
                                          <option value="{{ $i }}">{{ $i }}</option>
                                      @endfor
                                  </select>
                              </td>
                              <td>
                                  <select name="ass_report[]" class="form-control">
                                      @for ($i = 1; $i <= 10; $i++)
                                          <option value="{{ $i }}">{{ $i }}</option>
                                      @endfor
                                  </select>
                              </td>
                              <td>
                                  <select name="ass_rajin[]" class="form-control">
                                      @for ($i = 1; $i <= 10; $i++)
                                          <option value="{{ $i }}">{{ $i }}</option>
                                      @endfor
                                  </select>
                              </td>
                              <td>
                                  <input type="text" name="ass_note[]" class="form-control" placeholder="Enter note" required />
                              </td>
                          </tr>
                        </tbody>
                      </table>
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
  // Event listener for form submission
  document.getElementById("myForm2").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    if (confirm("Are you sure you want to submit this form?")) {
      var form = event.target; // Get the form element
      var formData = new FormData(form); // Create a FormData object from the form

      fetch(form.action, {
        method: form.method,
        body: formData
      })
        .then(function(response) {
          if (response.ok) {
            alert("Form submitted successfully!");
            form.reset(); // Reset the form after successful submission
          } else {
            alert("Error submitting the form. Please try again.");
          }
        })
        .catch(function(error) {
          console.error("Error:", error);
        });
    }
  });
  //get data from table
  function getDataFromTable() {
    var table = document.getElementById("journal-entrees2");
    var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    var data = [];

    for (var i = 0; i < rows.length; i++) {
      var row = rows[i];
      var rowData = {
        ms_employee_D: row.querySelector("input[name='ms_employee_D']").value,
        absen: row.querySelector("select[name='ass_absen']").value,
        report: row.querySelector("select[name='ass_report']").value,
        rajin: row.querySelector("select[name='ass_rajin']").value,
        d_note: row.querySelector("input[name='ass_note']").value,
      };
      data.push(rowData);
    }

    return data;
  }

  function submitForm() {
    var form = document.getElementById("myForm2");
    var formData = new FormData(form);
    var tableData = getDataFromTable();
    formData.append("table_data", JSON.stringify(tableData));

    if (confirm("Are you sure you want to submit this form?")) {
    fetch(form.action, {
      method: form.method,
      body: formData
    })
      .then(function(response) {
        if (response.ok) {
          alert("Form submitted successfully!");
          form.reset();
        } else {
          // Error handling
        }
      })
      .catch(function(error) {
        console.error("Error:", error);
      });
  }
}
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
