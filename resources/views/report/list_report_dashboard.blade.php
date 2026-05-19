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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<div class="container">
  <h3 align="center">Report List</h3>
  @if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
</br>
{{--  <form  action="/list_report_call" method="post" enctype="multipart/form-data">
  @csrf
  <table >
    <tr>
     <td width="40%" align="right"><label>Select File for Upload</label></td>
     <td width="30">
      <input type="file" name="select_file" />
     </td>
     <td width="30%" align="left">
      <input type="submit" name="upload" class="btn btn-primary" value="Upload">
     </td>
    </tr>
    <tr>
     <td width="40%" align="right"></td>
     <td width="30"><span class="text-muted">.xls, .xslx</span></td>
     <td width="30%" align="left"></td>
    </tr>
   </table>
  </form>  --}}
    <hr>
<div class="row">
        <div class="panel panel-primary filterable">
            <table class="table" id="dataTable">
                <thead>
                  <tr >
                      <th>Tanggal</th>
                      <th>Total Lamar</th>
                      <th>Total Panggil</th>
                      <th>Panggil Terhubung</th>
                      <th>Datang Interview</th>
                      <th>Total Interviw</th>
                      {{--  <th>Action</th>  --}}
                  </tr>
              </thead>
              <thead>
                <tr class="filters">
                    {{--  <th><input type="datetime" class="form-control" placeholder="Search.." ></th>  --}}
                    {{--  <th><input type="text" class="form-control" placeholder="Total Lamar" ></th>
                    <th><input type="text" class="form-control" placeholder="Total Panggil" ></th>
                    <th><input type="text" class="form-control" placeholder="Panggil Terhubung" ></th>
                    <th><input type="text" class="form-control" placeholder="Datang Interview" ></th>
                    <th><input type="text" class="form-control" placeholder="Total Interviw" ></th>  --}}
                </tr>
            </thead>
                <tbody>
                  @foreach($reportmain_hrd as $row)
                  <tr>
                    {{--  <td>{{$row->NamaLowongan}}</td>  --}}
                    <td>{{ date_format(date_create($row->tanggal_main),"d/m/Y") }}</td>
                    <td>{{$row->total_lamar}}</td>
                    <td>{{$row->total_panggil}}</td>
                    <td>{{$row->total_ok_calls}}</td>
                    <td>{{$row->total_ok_interview}}</td>
                    <td>{{$row->total_interview}}</td>

                    {{--  <td>
                      <button type="button" class="btn btn-light">
                        <a href="/report/show_detail/{{$row->Tr_report_hrd_main_code}}"class="btn btn-outline-success">View</a>
                      </button>
                    </td>  --}}
                  </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        }
        else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>

<style>
  .filterable {
    margin-top: 15px;
  }
  .filterable .panel-heading .pull-right {
      margin-top: -20px;
  }
  .filterable .filters input[disabled] {
      background-color: transparent;
      border: none;
      cursor: auto;
      box-shadow: none;
      padding: 0;
      height: auto;
  }
  .filterable .filters input[disabled]::-webkit-input-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]::-moz-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]:-ms-input-placeholder {
      color: #333;
  }
</style>

<script>
  $(document).ready(function() {
        $('#dataTable').DataTable();
  });
</script>

@endsection
