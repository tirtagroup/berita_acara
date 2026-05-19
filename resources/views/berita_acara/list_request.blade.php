@extends('layouts/layoutMaster')

@section('title', 'Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

@section('vendor-script')
<!-- Vendor scripts can be included here if needed -->
@endsection

@section('page-script')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
<script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-primary">
        {{ session('success') }}
    </div>
@endif

<title>
  History Request Revisi
</title>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> History Request Revisi</h4>

<form method="POST" action="{{ url('search_revisit/revisi') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" for="multicol-birthdate-start">Tanggal awal</label>
                    <input type="date" id="multicol-birthdate-start" value="@isset($tgl_awal){{$tgl_awal}}@endisset" name="tgl_awal" class="form-control datepicker" placeholder="YYYY-MM-DD" />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="multicol-birthdate-end">Tanggal akhir</label>
                    <input type="date" id="multicol-birthdate-end" value="@isset($tgl_akhir){{$tgl_akhir}}@endisset" name="tgl_akhir" class="form-control datepicker" placeholder="YYYY-MM-DD" />
                </div>
                <div class="col-md-6 mt-2">
                    {{--  <button type="submit" class="btn btn-primary me-1">Cari</button>  --}}
                    <button type="submit" class="btn btn-primary me-1">
                      <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ Url('berita_acara/report_ba') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
          <label><strong>Noted:</strong></label>
          <ul style="list-style-type: none; padding: 0;">
              <li style="display: flex; align-items: center;">
                  <button class="color-0 btn btn-sm" style="width: 50px;">0</button> <span> = Approve Koordinator</span>
              </li>
              <li style="display: flex; align-items: center;">
                  <button class="color-1 btn btn-sm" style="width: 50px;">1</button> <span> = Approve Supervisor</span>
              </li>
              <li style="display: flex; align-items: center;">
                  <button class="color-2 btn btn-sm" style="width: 50px;">2</button> <span> = Approve HR</span>
              </li>
              <li style="display: flex; align-items: center;">
                  <button class="color-3 btn btn-sm" style="width: 50px;">3</button> <span> = Approve Manager Finance</span>
              </li>
              <li style="display: flex; align-items: center;">
                  <button class="color-4 btn btn-sm" style="width: 50px;">4</button> <span> = Approve Manager Operasional</span>
              </li>
              <li style="display: flex; align-items: center;">
                  <button class="color-5 btn btn-sm" style="width: 50px;">5</button> <span> = Approve General Manager</span>
              </li>
              <li style="display: flex; align-items: center;">
                  <button class="color-6 btn btn-sm" style="width: 50px;">6</button> <span> = Approve IT</span>
              </li>
              <li style="display: flex; align-items: center;">
                  <button class="color-7 btn btn-sm" style="width: 50px;">7</button> <span> = Approve BOD</span>
              </li>
          </ul>
      </div>

    </div>
</form>

<div class="table-responsive">
    <table class="table" id="myTable">
        <thead>
            <tr>
                <th>Code</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Divisi Pelapor</th>
                <th>Pelaku</th>
                <th>Divisi Pelaku</th>
                <th>Tracking</th>
                <th>Kasus</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($main_ba_new as $ba)
              <tr>
                  <td data-table-header="Title">
                      <a class="underlineHover" href="/request_revisi/{{ $ba->Tr_BA_Main_Code }}">{{ $ba->Tr_BA_Main_Code }}</a>
                  </td>
                  <td>{{ date_format(date_create($ba->created_at), "Y/m/d") }}</td>
                  <td>{{ $ba->Ms_Pelapor_Code }}</td>
                  <td>{{ $ba->Ms_Pelapor_Div }}</td>
                  <td>{{ $ba->Ms_Emp_Code }}</td>
                  <td>{{ $ba->Ms_Emp_Div }}</td>
                  <td>
                      @php
                          $trackingClass = 'color-' . $ba->trace; // Misalnya $ba->trace adalah nilai dari tracking
                      @endphp
                      <button class="form-control {{ $trackingClass }}">{{ $ba->trace }}</button>
                  </td>
                  <td>{{ $ba->Ms_Kasus }}</td>
                  <td>{{ $ba->MS_Detail_Kasus }}</td>
              </tr>
          @endforeach
      </tbody>

    </table>
</div>

<script>
  $(document).ready(function() {
      $('#myTable').DataTable({
          "ordering": false,
          initComplete: function() {
              this.api().columns().every(function(d) {
                  var column = this;
                  var theadname = $('#myTable th').eq([d]).text();
                  var select = $('<select class="form-control"><option value="">' + theadname + ': All</option></select>')
                      .appendTo($(column.header()).empty())
                      .on('change', function() {
                          var val = $.fn.dataTable.util.escapeRegex($(this).val());
                          column.search(val ? '^' + val + '$' : '', true, false).draw();
                      });

                  // Hanya untuk kolom Tracking
                  if (theadname === 'Tracking') {
                      // Menentukan nilai unik dari data di kolom Tracking
                      var uniqueValues = column.data().unique().sort();
                      // Hanya ambil nilai dari 0 hingga 7
                      var filteredValues = uniqueValues.filter(value => /^[0-7]$/.test(value));

                      filteredValues.each(function(d, j) {
                          select.append('<option value="' + d + '">' + d + '</option>');
                      });
                  } else {
                      column.data().unique().sort().each(function(d, j) {
                          select.append('<option value="' + d + '">' + d + '</option>');
                      });
                  }
              });
          }
      });
  });
</script>


<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .color-0 { background-color: red; color: white; }
    .color-1 { background-color: #ff9999; color: white; } /* merah muda */
    .color-2 { background-color: #ffcccc; color: black; } /* merah lebih muda */
    .color-3 { background-color: yellow; }
    .color-4 { background-color: #ffff99; } /* kuning lebih muda */
    .color-5 { background-color: #99ff99; } /* hijau muda */
    .color-6 { background-color: green; color: white; }
    .color-7 { background-color: #006400; color: white; } /* sangat hijau */
</style>
@endsection
