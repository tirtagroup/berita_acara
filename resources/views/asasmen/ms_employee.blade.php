@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

@section('vendor-script')
<!--<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>-->
@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection
  <title>
    History Asasmen
  </title>
@section('content')

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@if (session('success'))
  <div class="alert alert-primary">
    {{ session('success') }}
  </div>
  @endif

<!-- resources/views/user/index.blade.php -->
<div class="table-responsive">
<table class="table" id="myTable">
    <thead>
        <tr>
          <th>Name</th>
          <th>Division </th>
          <th>Last Assessor </th>
          <th>Periode Assessment</th>
          <th>Code</th>
          <th>Action</th>
        </tr>
        <tr>
          <th>Name</th>
          <th>Division </th>
          <th>Last Assessor </th>
          <th>Periode Assessment</th>
          <th>Code</th>
          <th></th>
        </tr>
    </thead>
    <tbody>
      @foreach($employee as $row)
            <tr>
              <td>{{$row->emp_name}}</td>
              <td>{{$row->emp_subdivision}}</td>
              <td>{{$row->user_update}}</td>
              <td>({{$tahunSaatIni}}){{$periodeQ}}</td>
              <td>{{$row->Tr_Review_EmpPeriod_Code_h}}</td>
              <td>
                <button type="button" class="btn btn-light">
                    @if($row->Tr_Review_EmpPeriod_Code_h !== $row->emp_name .'-'.$tahunSaatIni . $periodeQ)
                        <a href="/asasmen/create_asasmen_basic/{{ $row->emp_name }}" class="btn btn-outline-success">Assess</a>
                    @elseif($row->Tr_Review_EmpPeriod_Code_h == $row->emp_name .'-'.$tahunSaatIni . $periodeQ && (Auth::User()->sub_divisi == 'Supervisor' || Auth::User()->sub_divisi == 'Manager Finance' || Auth::User()->sub_divisi == 'Manager Operasional' || Auth::User()->sub_divisi == 'General Manager' || Auth::User()->sub_divisi == 'BOD' || Auth::User()->sub_divisi == 'HR'))
                        <a href="/asasmen/create_asasmen_basic_edit/{{ $row->Tr_Review_EmpPeriod_Code_h }}" class="btn btn-outline-success">Assess</a>
                    @else
                        <a href="#" class="btn btn-outline-danger">Already Assessment</a>
                    @endif
                </button>
            </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- Sisipkan script JavaScript untuk filter di sini -->

<script>
    $(document).ready(function() {
    $('#myTable').DataTable( {
        "ordering": false,
        initComplete: function () {
            this.api().columns([0,1,2,3,4,5,6]).every( function (d) {//THis is used for specific column
                var column = this;
                var theadname = $('#myTable th').eq([d]).text();
                var select = $('<select  class="form-control"><option value="">'+theadname+': All</option></select>')
                .appendTo($(column.header()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });

                    $(column.footer()).empty();
            } );
        }
    } );
  } );
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

  input {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      margin-bottom: 10px;
  }
</style>

@endsection

