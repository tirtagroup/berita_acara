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

<!-- resources/views/user/index.blade.php -->

<table id="myTable">
    <thead>
        <tr>
            <th><input type="text" id="filterDate" onkeyup="filterTable()" placeholder="Cari Tanggal"></th>
            <th><input type="text" id="filterCode" onkeyup="filterTable()" placeholder="Cari Code"></th>
            <th><input type="text" id="filterName" onkeyup="filterTable()" placeholder="Cari Nama"></th>
            <th><input type="text" id="filterAge" onkeyup="filterTable()" placeholder="Cari Divisi"></th>
            <th><input type="text" id="filterCity" onkeyup="filterTable()" placeholder="Cari Assesor"></th>
            <th><input type="text" id="filterCity" onkeyup="filterTable()" placeholder="" readonly></th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Code</th>
            <th>Empolyee</th>
            <th>Divisi</th>
            <th>Assesor</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employee as $user)
            <tr>
              <td>{{date_format(date_create($user->created_at),"Y-m-d") }}</td>
                <td>{{ $user->Tr_Emp_Asses_Code }}</td>
                <td>{{ $user->Ms_emp_code }}</td>
                <td>{{ $user->Ms_Emp_Div }}</td>
                <td>{{ $user->Ms_Emp_Assessor_Code }}</td>
                <td>
                    <a href="/print_asasmen/{{$user->Tr_Emp_Asses_Code}}"class="btn btn-outline-success">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Sisipkan script JavaScript untuk filter di sini -->

<script>
    function filterTable() {
        var inputDate, inputCode, inputName, inputAge, inputCity, filterName, filterAge, filterCity, table, tr, tdName, tdAge, tdCity, tdEmail, i;
        inputDate = document.getElementById("filterDate");
        inputCode = document.getElementById("filterCode");
        inputName = document.getElementById("filterName");
        inputAge = document.getElementById("filterAge");
        inputCity = document.getElementById("filterCity");
        filterDate = inputDate.value.toUpperCase();
        filterCode = inputCode.value.toUpperCase();
        filterName = inputName.value.toUpperCase();
        filterAge = inputAge.value.toUpperCase();
        filterCity = inputCity.value.toUpperCase();

        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tdDate = tr[i].getElementsByTagName("td")[0];
            tdCode = tr[i].getElementsByTagName("td")[1];
            tdName = tr[i].getElementsByTagName("td")[2];
            tdAge = tr[i].getElementsByTagName("td")[3];
            tdCity = tr[i].getElementsByTagName("td")[4];

            // Sesuaikan dengan jumlah dan urutan kolom di database

            if (tdDate && tdCode && tdName && tdAge && tdCity  ) {
                if (tdDate.textContent.toUpperCase().indexOf(filterDate) > -1 &&
                    tdCode.textContent.toUpperCase().indexOf(filterCode) > -1 &&
                    tdName.textContent.toUpperCase().indexOf(filterName) > -1 &&
                    tdAge.textContent.toUpperCase().indexOf(filterAge) > -1 &&
                    tdCity.textContent.toUpperCase().indexOf(filterCity) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }


</script>

<script>
  $(document).ready(function() {
      $('#myTable').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'excel'
          ],
          order: [[0, 'desc']]
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

