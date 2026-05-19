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

<head>
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<title>
    Tidak Terhubung
  </title>
</head>

<div class="container">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Kandidat Tidak Bisa Dihubungi</h4>
   <li class="nav-item dropdown">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Filter
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
             <a class="dropdown-item" href="/tr_candidates/all_candidates">- Semua Kandidat</a>
              <a class="dropdown-item" style="font-weight: bold" > 1. SHORTING </a>
              {{--  <a class="dropdown-item" href="{{ route('trCandidates.index') }}"> - Semua Kandidat</a>  --}}
              <a class="dropdown-item" href="/tr_candidates/kandidat_belum_short">- Belum Di Shortlist</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_lolos_short">- Lolos Shortlist</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_gagal_short">- Tidak Lolos Shortlist</a>
              <a class="dropdown-item" style="font-weight: bold" > 2. PANGGIL </a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_belum_dihubungi">- Belum Di Panggil</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_dapat_dihubungi">- Panggilan Terhubung</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_tidak_dapat_dihubungi">- Panggilan Tidak Terhubung</a>
              <a class="dropdown-item" style="font-weight: bold" > 3. INTERVIEW </a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_belum_interview">- Interview 1</a>
              {{--  <a class="dropdown-item" href="/tr_candidates/kandidat_interviewlulus"> &nbsp;&nbsp;L </a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_interviewTL"> &nbsp;&nbsp;TL</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_interviewuser"> &nbsp;&nbsp;IU</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_interviewpriority"> &nbsp;&nbsp;P </a>  --}}
              <a class="dropdown-item" href="/tr_candidates/kandidat_interview2">- Interview 2</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_interview3">- Interview 3</a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_lolos_interview">- Lolos Interview </a>
              <a class="dropdown-item" href="/tr_candidates/kandidat_tidak_lolos_interview">- Tidak Lolos Interview</a>
          </div>
</div>
    <hr>
<div class="row">
        <div class="panel panel-primary filterable">
            <table class="table" id="dataTable">
                <thead>
                  <tr >
                    <th scope="col" >Nama</th>
                    <th scope="col" >Domisili</th>
                    <th scope="col" >Usia</th>
                    <th scope="col" >Jenis Kelamin</th>
                    <th scope="col" >Agama</th>
                    <th scope="col" >Handphone</th>
                    <th scope="col" >Posisi</th>
                    <th scope="col" >Tgl.Melamar</th>
                    <th scope="col" >Perusahaan Terakhir</th>
                  </tr>
              </thead>
              <thead>
                <tr class="filters">
                </tr>
            </thead>
                <tbody>
                  @foreach($call as $trCandidate)
                  <tr>

                    <td data-table-header="Title"><a class="underlineHover" href="/detail_kandidat/detail_kandidat_tidak_terhubung/{{ $trCandidate->Ktp }}">{{ $trCandidate->Name }}</a> </td>
                    <td>{{ $trCandidate->domisili }}</td>
                    <td>{{ $trCandidate->umur }}</td>
                    <td>{{ $trCandidate->jenis_kelamin }}</td>
                    <td>{{ $trCandidate->agama }}</td>
                    <td>{{ $trCandidate->Handphone }}</td>
                    <td>{{ $trCandidate->Position_aplly1 }}</td>
                    <td>{{ date_format(date_create($trCandidate->created_at),"d/m/Y") }}</td>
                    <td>{{ $trCandidate->Perusahaan }}</td>

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
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
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
