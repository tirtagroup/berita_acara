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

@section('content')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<link href="//https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="//https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="//https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="container">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> BA Request Revisi</h4>
   
          <!--<div class="dropdown">-->
          <!--  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
          <!--    Periode-->
          <!--  </button>-->
          <!--  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
          <!--    <a class="dropdown-item" href="#">Daily</a>-->
          <!--    <a class="dropdown-item" href="#">Weekly</a>-->
          <!--    <a class="dropdown-item" href="#">Monthly</a>-->
          <!--</div>-->
    <form method="POST" action="{{ url('search_report_revisi/report_ba') }}">
       {{ csrf_field() }}
      <div class="col-md-4">
        <label class="form-label" for="multicol-birthdate">Tanggal awal</label>
        <input type="text" id="multicol-birthdate" value = "@if (isset($tgl_awal)) {{$tgl_awal}}  @endif" name="tgl_awal" class="form-control dob-picker" placeholder="YYYY-MM-DD" required />
      </div> 
      <div class="col-md-4">
        <label class="form-label" for="multicol-birthdate">Tanggal akhir</label>
        <input type="text" id="multicol-birthdate" value = "@if (isset($tgl_akhir)) {{$tgl_akhir}}  @endif" name="tgl_akhir" class="form-control dob-picker" placeholder="YYYY-MM-DD" required />
      </div>
        <div class="pt-4">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Cari</button>
          <a href="{{ Url('dashboard_revisi') }}" class="btn btn-secondary me-sm-3 me-1">Cancel</a>
        </div> 
    </form>          
          
</div>
    <hr>
<div class="row">
        <div  class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                  <tr >
                      <th>Tanggal</th>
                      <th>Code</th>
                      <!--<th>Company</th>-->
                      <th>Lokasi</th>
                      <th>User Input</th>
                      <th>Pelaku</th>
                      <th>Divisi Pelaku</th>
                      <th>Kasus</th>
                      <!--<th>Kategori</th>-->
                      <th>Datail Kasus</th>
                      <th>Tracking</th>
                      <th>Kronologi</th>
                  </tr>
              </thead>
              <thead>
                <tr class="filters">
                </tr>
            </thead>
                <tbody>
                  @foreach($report as $row)
                  <tr>
                    <td>{{date_format(date_create($row->created_at),"Y-m-d") }}</td>
                    <td>{{$row->Tr_BA_Main_Code}}</td>
                    <!--<td>{{$row->rec_comcode}}</td>-->
                    <td>{{$row->rec_areacode}}</td>
                    <td>{{$row->Ms_Pelapor_Code}}</td>
                    <td>{{$row->Ms_Emp_Code}}</td>
                    <td>{{$row->Ms_Emp_Div}}</td>
                    <td>{{$row->Ms_Kasus}}</td>
                    <td>{{$row->MS_Detail_Kasus}}</td>
                    <td>{{$row->trace}}</td>
                    <td>{{$row->kronlogi}}</td>
                  </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ],
        order: [[0, 'desc']]
    } );
} );
</script>

<script>
  $(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
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
