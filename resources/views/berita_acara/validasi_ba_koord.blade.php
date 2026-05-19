<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include DataTables CSS and JavaScript -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <!-- Include DataTables Buttons extension for export -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">

    <title>
      Approval Koordinator
    </title>
</head>

<body>
    <div class="container">
      <center>
        <h2>Approval Koordinator</h2>
      </center>
        <a class="btn btn-info" href="/home_ba" role="button">Home</a>
        <br><br>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                  <th scope="col">Code</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">User Input</th>
                  <th scope="col">Pelaku</th>
                  <th scope="col">Divisi Pelaku</th>
                  <th scope="col">Kasus</th>
                  <th scope="col">Detail</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($main_ba as $ba)
              <tr>
              <td data-table-header="Title"><a class="underlineHover" href="/detail_validasi_koord/{{ $ba->Tr_BA_Main_Code }}">{{ $ba->Tr_BA_Main_Code }}</a> </td>
              <td>{{ date_format(date_create($ba->created_at),"Y/m/d") }}</td>
              <td>{{ $ba->Ms_Emp_Code}}</td>
              <td>{{ $ba->Ms_Pelapor_Code}}</td>
              <td>{{ $ba->Ms_Emp_Div}}</td>
              <td>{{ $ba->Ms_Kasus}}</td>
              <td>{{ $ba->MS_Detail_Kasus}}</td>
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with options
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "pageLength": 10 // Jumlah baris per halaman
            });
        });
    </script>
</body>
</html>
