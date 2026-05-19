@extends('layouts/layoutMaster')

@section('title', 'DataTables - Advanced Tables')

@section('content')

<!-- <!DOCTYPE html>
<html> -->
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
  /* background-color: #dddddd; */
}
</style>
</head>
<body>

<h2>List Report</h2>
<input id="myInput" type="text" placeholder="Search..">
<br><br>

<!-- <table>
<th>
      <ul class="nav nav-tabs">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Periode</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Daily</a></li>
            <li><a class="dropdown-item" href="#">Weekly</a></li>  
            <li><a class="dropdown-item" href="#">Monthly</a></li>        
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Perusahaan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Memo Harian</a></li>
            <li><a class="dropdown-item" href="#">Temuan Pelanggaran</a></li>
            <li><a class="dropdown-item" href="#">Temuan Kerusakan</a></li>
            <li><a class="dropdown-item" href="#">Absen Driver</a></li>
            <li><a class="dropdown-item" href="#">Truck List</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
</th>
</table> -->

<table>
  <thead>
  <tr>
      
      <th>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Periode</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Daily</a></li>
            <li><a class="dropdown-item" href="#">Weekly</a></li>  
            <li><a class="dropdown-item" href="#">Monthly</a></li>        
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
      <th>Type Report</th>
      <th>User</th>
      <th>Divisi</th>     
      <th>Lokasi</th>  
      <th>Action</th> 
  </tr>
  </thead>
  <tbody id="myTable">
        @foreach($reportmain_hrd as $row)
          <tr>
            <td>{{$row->Tr_report_hrd_main_code}}</td>
            <td>{{$row->Ms_ReportType_Code}}</td>
            <td>{{ date_format(date_create($row->created_at),"d/m/Y") }}</td>
            <td>{{$row->Ms_User_Code}}</td>
            <td>{{$row->ms_divisi}}</td>   
            <td>{{$row->ms_lokasi}}</td> 
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

</body>
<!-- </html> -->
