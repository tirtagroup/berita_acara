@extends('layouts/layoutMaster')

@section('title', 'DataTables - Advanced Tables')

@section('content')

 <!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<script>
  document.getElementById("btn").addEventListener("click", () => {
    let table2excel = new Table2Excel();
    table2excel.export(document.querySelector("#Record"));
  });

</script>




<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
}
</style>

  <link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>
    History Main
  </title>
</head>
<body>

<h2>List Report</h2>
<div class="row">
  <div class="col">
    <input id="myInput" class="form-control" type="text" placeholder="Search..">
  </div>
  <div class="col">
    {{--  <input id="daterange" class="form-control" >  --}}
  </div>
</div>

{{--  <button class="btn btn-primary" id="btn">Export to Excel</button>  --}}
<br>

<table id="Record">
  <thead>
  <tr>
      <th>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Periode</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/list_report_daily" name="filtering" value="Daily">Today</a></li>
            <li><a class="dropdown-item" href="/list_report_weekly">Last Week</a></li>
            <li><a class="dropdown-item" href="/list_report_monthly">Last Month</a></li>
          </ul>
        </li>
      </th>
      <th>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Perusahaan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Tirta Gracia Utama</a></li>
            <li><a class="dropdown-item" href="#">Tirta Gracia Fiesta</a></li>
            <li><a class="dropdown-item" href="#">PT. Handal Guna Sarana</a></li>
          </ul>
        </li>
      </th>
      <th>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Type Report</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Opening lowongan</a></li>
            <li><a class="dropdown-item" href="#">Call</a></li>
            <li><a class="dropdown-item" href="#">Interview</a></li>
          </ul>
        </li>
      </th>
      <th>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Code</a>
        </li>
      </th>
      <th>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Action</a>
        </li>
      </th>
  </tr>
  </thead>
  <tbody id="myTable">
        @foreach($reportmain_hrd as $row)
          <tr>
            <td>{{ date_format(date_create($row->created_at),"d/m/Y") }}</td>
            <td>{{$row->Ms_Perusahaan_Code_main}}</td>
            <td>{{$row->Ms_ReportType_Code}}</td>
            <td>{{$row->Tr_report_hrd_main_code}}</td>
            <td>
              <button type="button" class="btn btn-light">
                <a href="/report/show_detail/{{$row->Tr_report_hrd_main_code}}"class="btn btn-outline-success">View</a>
              </button>
            </td>
          </tr>
        @endforeach
  </tbody>
</table>
@endsection

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
		    $('#example').DataTable( {
		        dom: 'Bfrtip',
		        buttons: [
		            'copy', 'csv', 'excel', 'pdf', 'print'
		        ]
		    } );
		} );
	</script>

</body>
</html>
