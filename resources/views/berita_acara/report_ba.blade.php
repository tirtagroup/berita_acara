@extends('layouts.layoutMaster')

@section('title', 'Laporan BA Kejadian')

@section('vendor-style')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
  <style>
    #dataTable td,
    #dataTable th {
      white-space: normal; /* teks bisa wrap */
      vertical-align: top;
    }

    /* Header kolom Kronologi */
    th.kronologi-header {
      min-width: 450px !important;
      max-width: 700px !important;
      white-space: normal;
      word-break: break-word;
      vertical-align: top;
    }

    /* Cell kolom Kronologi */
    td.kronologi-cell {
      min-width: 450px !important;
      max-width: 700px !important;
      white-space: normal !important;
      word-break: break-word;
      vertical-align: top;
    }

    .dataTables_filter {
      float: right !important;
    }

    .dataTables_length {
      float: left !important;
    }

    .dt-buttons {
      margin-top: 10px;
    }

    .dataTables_wrapper .row:nth-child(3) {
      margin-top: 10px;
    }
  </style>
@endsection

@section('content')
<div class="container">
  <h4 class="mb-4">Laporan Berita Acara Kejadian</h4>

  <form action="{{ url('search_report_ba') }}" method="GET" class="mb-4">
    <div class="row">
      <div class="col-md-3">
        <label>Tanggal Awal</label>
        <input type="text" name="tgl_awal" class="form-control dob-picker" value="{{ request('tgl_awal') }}">
      </div>
      <div class="col-md-3">
        <label>Tanggal Akhir</label>
        <input type="text" name="tgl_akhir" class="form-control dob-picker" value="{{ request('tgl_akhir') }}">
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Tampilkan</button>
      </div>
    </div>
  </form>

  @if(isset($main_BA))
  <div class="table-responsive">
    <table id="dataTable" class="table table-bordered display nowrap" style="width:100%">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Kode BA</th>
          <th>Tanggal BA</th>
          <th>Area Code</th>
          <th>Pelapor</th>
          <th>Divisi Pelapor</th>
          <th>Karyawan</th>
          <th>Divisi Karyawan</th>
          <th>Cek Fraud</th>
          <th>Jenis BA</th>
          <th>Kasus</th>
          <th>Detail Kasus</th>
          <th>Comcode</th>
          <th class="kronologi-header">Kronologi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($main_BA as $item)
        <tr>
          <td title="{{ $item->created_at }}">{{ $item->created_at }}</td>
          <td title="{{ $item->Tr_BA_Main_Code }}">{{ $item->Tr_BA_Main_Code }}</td>
          <td title="{{ $item->Date_BA }}">{{ $item->Date_BA }}</td>
          <td title="{{ $item->rec_areacode }}">{{ $item->rec_areacode }}</td>
          <td title="{{ $item->Ms_Pelapor_Code }}">{{ $item->Ms_Pelapor_Code }}</td>
          <td title="{{ $item->Ms_Pelapor_Div }}">{{ $item->Ms_Pelapor_Div }}</td>
          <td title="{{ $item->Ms_Emp_Code }}">{{ $item->Ms_Emp_Code }}</td>
          <td title="{{ $item->Ms_Emp_Div }}">{{ $item->Ms_Emp_Div }}</td>
          <td title="{{ $item->CekFraud }}">{{ $item->CekFraud }}</td>
          <td title="{{ $item->Ms_BA_type_Code }}">{{ $item->Ms_BA_type_Code }}</td>
          <td title="{{ $item->Ms_Kasus }}">{{ $item->Ms_Kasus }}</td>
          <td title="{{ $item->MS_Detail_Kasus }}">{{ $item->MS_Detail_Kasus }}</td>
          <td title="{{ $item->rec_comcode }}">{{ $item->rec_comcode }}</td>
          <td class="kronologi-cell" title="{{ $item->kronlogi }}">{{ $item->kronlogi }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <div class="alert alert-info mt-4">Silakan pilih tanggal terlebih dahulu untuk menampilkan data.</div>
  @endif
</div>
@endsection

@section('vendor-script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('page-script')
  <script>
    $(document).ready(function () {
      $(".dob-picker").flatpickr({ dateFormat: "Y-m-d" });

      @if(isset($main_BA))
        $('#dataTable').DataTable({
          dom:
            '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
            '<"row"<"col-sm-12"tr>>' +
            '<"row"<"col-sm-6"B><"col-sm-6"p>>',
          buttons: [
            {
              extend: 'excelHtml5',
              className: 'btn btn-success',
              title: 'Laporan_BA_Kejadian'
            },
            {
              extend: 'pdfHtml5',
              className: 'btn btn-danger',
              title: 'Laporan_BA_Kejadian',
              orientation: 'landscape',
              pageSize: 'A4'
            }
          ],
          scrollX: true,
          pageLength: 10,
          lengthMenu: [10, 25, 50, 100],
          order: [[0, 'desc']]
        });
      @endif
    }); 
  </script>
@endsection
