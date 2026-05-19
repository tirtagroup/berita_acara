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

<!-- resources/views/user/index.blade.php -->

<table id="myTable">
    <thead>
        <tr>
            <th><input type="text" id="filterName" onkeyup="filterTable()" placeholder="Cari Nama"></th>
            <th><input type="text" id="filterAge" onkeyup="filterTable()" placeholder="Cari Divisi"></th>
            <th><input type="text" id="filterCity" onkeyup="filterTable()" placeholder="Cari Kota Lahir"></th>
            <th><input type="text" id="filterEmail" onkeyup="filterTable()" placeholder="Cari Tanggal Join"></th>
            {{--  <th><input type="text" id="filterEmail" onkeyup="filterTable()" placeholder="Action" readonly></th>  --}}
        </tr>
        <tr>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Kota Lahir</th>
            <th>Tanggal Join</th>
            {{--  <th>Action</th>  --}}
        </tr>
    </thead>
    <tbody>
        @foreach($employee as $user)
            <tr>
                {{--  <td>{{ $user->emp_name }}</td>  --}}
                <td data-table-header="Title"><a class="underlineHover" href="/detail_validasi_gm/{{ $user->emp_name }}">{{ $user->emp_name }}</a> </td>
                <td>{{ $user->emp_subdivision }}</td>
                <td>{{ $user->emp_kotalahir }}</td>
                <td>{{ $user->emp_datejoin }}</td>
                {{--  <td>Assasmen</td>  --}}
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Sisipkan script JavaScript untuk filter di sini -->

<script>
    function filterTable() {
        var inputName, inputAge, inputCity, inputEmail, filterName, filterAge, filterCity, filterEmail, table, tr, tdName, tdAge, tdCity, tdEmail, i;
        inputName = document.getElementById("filterName");
        inputAge = document.getElementById("filterAge");
        inputCity = document.getElementById("filterCity");
        inputEmail = document.getElementById("filterEmail");
        filterName = inputName.value.toUpperCase();
        filterAge = inputAge.value.toUpperCase();
        filterCity = inputCity.value.toUpperCase();
        filterEmail = inputEmail.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tdName = tr[i].getElementsByTagName("td")[0];
            tdAge = tr[i].getElementsByTagName("td")[1];
            tdCity = tr[i].getElementsByTagName("td")[2];
            tdEmail = tr[i].getElementsByTagName("td")[3];
            // Sesuaikan dengan jumlah dan urutan kolom di database

            if (tdName && tdAge && tdCity && tdEmail) {
                if (tdName.textContent.toUpperCase().indexOf(filterName) > -1 &&
                    tdAge.textContent.toUpperCase().indexOf(filterAge) > -1 &&
                    tdCity.textContent.toUpperCase().indexOf(filterCity) > -1 &&
                    tdEmail.textContent.toUpperCase().indexOf(filterEmail) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
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

