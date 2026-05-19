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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Form Asassment Basic</h4>


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

      <form action="/update_asasmen" method="POST" enctype="multipart/form-data">
        @csrf
    @if($details)
    @foreach($details as $detail)
      <div class="card">
          <div class="row g-3 p-3">
                <div class="col-md-6">
                  @foreach($details as $detail)
                  <label class="form-label" for="collapsible-fullname">Code</label>
                    <input class="form-control"  type="text" name="Tr_Emp_Asses_Code" value="{{   $detail->Tr_Emp_Asses_Code }} " readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Date</label>
                  <input class="form-control"  type="text" name="Ass_date" value="{{date_format(date_create($detail->created_at),"d-m-Y") }}" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Assesor</label>
                    <input type="text" name="Ms_Emp_Assessor_Code" id="collapsible-fullname" class="form-control" value="{{   $detail->rec_usercreated }}" readonly required/>
                    {{--  <input type="hidden" name="" class="form-control" value="{{ $user->id }}"/>  --}}
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Divisi Assesor</label>
                    <input type="text" name="ms_divisi" id="collapsible-fullname" class="form-control" value="{{ $detail->ms_divisi }}" readonly required/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Nama Staff</label>
                    <input type="text" name="" id="collapsible-fullname" class="form-control" value="{{   $detail->Ms_emp_code }}"    readonly/>
                    {{--  <input type="hidden" name="Ms_Emp_Code" class="form-control" value="{{ $operators->emp_id }}"/>  --}}
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Divisi Staff</label>
                    <input type="text" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{   $detail->Ms_Emp_Div }}"    readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="collapsible-fullname">Ms Type Assasment</label>
                  <input type="text" name="Ms_Emp_Div" id="collapsible-fullname" class="form-control" value="{{   $detail->Ms_type_asses }}"    readonly/>
                </div>
                <input class="form-control"  type="hidden" name="Tr_Emp_Assesor_Code" value="{{   $id_emp_asses }} " readonly/>
                <div class="col-md-6">
               </div>
        </div>
        @endforeach
    <div class="p-3">
      <br>
      <br><center><h2>Rating</h2></center>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Trust</label>
          <div class="col-sm-3">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              {{--  <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($detail->Trust_value == $i){ echo "checked";}else{ echo "enable='enable'";} ?> />  --}}
              <input class="form-check-input" type="radio" name="trust" value="{{ $i }}" data-type="trust" {{ $detail->Trust_value == $i ? 'checked' : '' }} />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-7">
            <input type="text" class="form-control"  value="{{ $detail->trust_comment }}" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Drive</label>
          <div class="col-sm-3">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              {{--  <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($detail->drive_value == $i){ echo "checked";}else{ echo "enable='enable'";} ?> />  --}}
              <input class="form-check-input" type="radio" name="drive" value="{{ $i }}" data-type="drive" {{ $detail->drive_value == $i ? 'checked' : '' }} />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-7">
            <input type="text" class="form-control"  value="{{ $detail->drive_comment }}" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Inisiative</label>
          <div class="col-sm-3">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              {{--  <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($detail->inisiative_value == $i){ echo "checked";}else{ echo "enable='enable'";} ?> />  --}}
              <input class="form-check-input" type="radio" name="inisiatif" value="{{ $i }}" data-type="inisiatif" {{ $detail->inisiative_value == $i ? 'checked' : '' }} />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-7">
            <input type="text" class="form-control"  value="{{ $detail->inisiatif_comment }}" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Reliable</label>
          <div class="col-sm-3">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              {{--  <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($detail->Reliable_value == $i){ echo "checked";}else{ echo "enable='enable'";} ?> />  --}}
              <input class="form-check-input" type="radio" name="reliable" value="{{ $i }}" data-type="reliable" {{ $detail->Reliable_value == $i ? 'checked' : '' }} />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-7">
            <input type="text" class="form-control"  value="{{ $detail->reliable_comment }}" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Result</label>
          <div class="col-sm-3">
            @for($i = 1; $i <= 5; $i++)
            <div class="form-check form-check-inline">
              {{--  <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($detail->reslut == $i){ echo "checked";}else{ echo "enable='enable'";} ?> />  --}}
              <input class="form-check-input" type="radio" name="result" value="{{ $i }}" data-type="result" {{ $detail->reslut == $i ? 'checked' : '' }} />
              <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
            </div>
            @endfor
          </div>
          <div class="col-sm-7">
            <input type="text" class="form-control"  value="{{ $detail->result_comment }}" readonly>
          </div>
        </div>
      </div>
      <br><center><h2>Target</h2></center>
      <table class="table table-bordered" id="dynamic-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="70%">Target</th>
                <th width="10%">Status</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            @foreach($notes as $rows)
                <tr>
                    <td>{{ $counter++ }}</td>
                    {{--  <td>{{ $rows->note }} </td>  --}}
                    <td>
                      <input type="text" class="form-control" name="note[]" value="{{ $rows->note }}" readonly>
                    </td>
                    <td>
                        <select class="form-control" name="status[]">
                            <option value="In Progress" {{ $rows->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Unhandle" {{ $rows->status == 'Unhandle' ? 'selected' : '' }}>Unhandle</option>
                            <option value="Finish" {{ $rows->status == 'Finish' ? 'selected' : '' }}>Finish</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
            <br>
            <button type="button" class="add-row-btn btn btn-info" onclick="addRows()">Tambah Target</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-3 row">
            {{--  <label for="inputPassword" class="col-sm-2 col-form-label">Total Nilai</label>
           <div class="col-sm-5">
            <span id="total-score" style="margin-left: .5rem;">0</span>
          </div>  --}}
          <div class="col-sm-5">
          </div>
        </div>
      </div>
    </div>
  </div>
          <div class="mt-1">
            <input type="submit" value="Update" class="btn btn-primary me-sm-3 me-1">
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
          </div>
       </div>
    </div>
    </form>
  </div>
</div>
</div>

@endforeach
@endif
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


    {{--  <script>
      function addRows() {
          var table = document.getElementById("dynamic-table").getElementsByTagName('tbody')[0];
          var newRow = table.insertRow(table.rows.length);
          var nama1 = newRow.insertCell(0);
          var nama2 = newRow.insertCell(1);
          var nama3 = newRow.insertCell(2);
          var actionCell = newRow.insertCell(3);
          var rowCount = table.rows.length;

          nama2.innerHTML = '<input name="note[]" class="form-control" type="text" required/>';
          nama3.innerHTML = '<select name="status[]" class="form-control"> <option value="Finish">Finish</option><option value="In Progress">In Progress</option><option value="Unhandle">Unhandle</option>';
          actionCell.innerHTML = '<button type="button" class="remove-row-btn btn btn-danger" onclick="removeRow(this)">Remove</button>';

          syncRowNumbers();
      }

      function removeRow(button) {
          var row = button.parentNode.parentNode;
          row.parentNode.removeChild(row);

          syncRowNumbers();
      }

      function syncRowNumbers() {
          var table = document.getElementById("dynamic-table").getElementsByTagName('tbody')[0];

          for (var i = 0; i < table.rows.length; i++) {
              table.rows[i].cells[0].innerHTML = i + 1;
          }
      }
  </script>  --}}

  <script>
        function addRows() {
          var table = document.getElementById("dynamic-table").getElementsByTagName('tbody')[0];
          var newRow = table.insertRow(table.rows.length);
          var nama1 = newRow.insertCell(0);
          var nama2 = newRow.insertCell(1);
          var nama3 = newRow.insertCell(2);
          var actionCell = newRow.insertCell(3);

          // Menghitung jumlah baris pada tabel
          var rowCount = table.rows.length;

          // Menambahkan nomor otomatis pada kolom No
          nama2.innerHTML = '<input name="note[]" class="form-control" type="text" required/>';
          nama3.innerHTML = '<select name="status[]" class="form-control"> <option value="Finish">Finish</option><option value="In Progress">In Progress</option><option value="Unhandle">Unhandle</option>';
          actionCell.innerHTML = '<button type="button" class="remove-row-btn btn btn-danger" onclick="removeRow(this)">Remove</button>';

          // Menyinkronkan nomor setiap baris
          syncRowNumbers();
      }

      function removeRow(button) {
          var row = button.parentNode.parentNode;
          row.parentNode.removeChild(row);

          // Setelah menghapus baris, menyinkronkan nomor kembali
          syncRowNumbers();
      }

      function syncRowNumbers() {
          var table = document.getElementById("dynamic-table").getElementsByTagName('tbody')[0];

          // Menyinkronkan nomor pada setiap baris
          for (var i = 0; i < table.rows.length; i++) {
              table.rows[i].cells[0].innerHTML = i + 1;
          }
      }

  </script>


@endsection
