@extends('layouts/layoutMaster')

@section('title', 'Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

@section('vendor-script')
<!-- Vendor scripts can be included here if needed -->
@endsection

@section('page-script')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
<script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-primary">
        {{ session('success') }}
    </div>
@endif

<title>
  Action Kejadian-Temuan
</title>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Action Kejadian-Temuan</h4>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('search_report_ba/temuan') }}">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label" for="multicol-birthdate-start">Tanggal awal</label>
                <input type="date" id="multicol-birthdate-start" value="@isset($tgl_awal){{$tgl_awal}}@endisset" name="tgl_awal" class="form-control datepicker" placeholder="YYYY-MM-DD" />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="multicol-birthdate-end">Tanggal akhir</label>
                <input type="date" id="multicol-birthdate-end" value="@isset($tgl_akhir){{$tgl_akhir}}@endisset" name="tgl_akhir" class="form-control datepicker" placeholder="YYYY-MM-DD" />
            </div>
            <div class="col-md-6 mt-2">
                <button type="submit" class="btn btn-primary me-1">
                  <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ Url('home') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
  </div>
</form>

<div class="table-responsive">
    <table class="table" id="myTable">
        <thead>
            <tr>
              <th>Tanggal </th>
              <th>Code </th>
              <th>Fraud </th>
              <th>Kategori</th>
              <th>Kasus</th>
              <th>Detail Kasus</th>
              <th>Pelapor</th>
              <th>Divisi Pelapor</th>
              <th>Pelaku</th>
              <th>Divisi Pelaku</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody>
          @foreach($report as $row)
          <tr>
            <td>{{date_format(date_create($row->created_at),"Y-m-d") }}</td>
            <td>{{$row->Tr_BA_Main_Code}}</td>
            <td>
              @if($row->CekFraud == '1')
              Fraud
              @else
              Tidak
              @endif
            </td>
            <td>
            @if($row->CekPelanggaran == '1')
            BA Pelanggaran SOP
            @elseif($row->CekPerubahanSOP == '1')
            BA Perubahan SOP
            @elseif($row->CekKehilangan == '1' or $row->CekKerusakan == '1')
            Kehilangan Dan Kerusakan
            @elseif($row->CekPembelian == '1')
            Pembelian Barang
            @elseif($row->CekLaka == '1')
            Laka
            @elseif($row->CekRevisi == '1')
            Ba Revisi
            @endif
            </td>
            <td>{{$row->Ms_Kasus}}</td>
            <td>{{$row->MS_Detail_Kasus}}</td>
            <td>{{$row->Ms_Pelapor_Code}}</td>
            <td>{{$row->Ms_Pelapor_Div}}</td>
            <td>{{$row->Ms_Emp_Code}}</td>
            <td>{{$row->Ms_Emp_Div}}</td>
            <td>
              @if($row->ket == 'belum dilihat')
                <button type="button" class="btn btn-info">
                  <a class="underlineHover" href="/detail_check_temuan/{{ $row->Tr_BA_Main_Code }}"><i class="fas fa-eye"></i> Check</a>
                </button>
                @else
                <button type="button" class="btn btn-danger">
                <a class="underlineHover" href="/detail_check_temuan/{{ $row->Tr_BA_Main_Code }}"><i class="fa-solid fa-eye-slash"></i> Checked</a>
                </button>
              @endif

            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
</div>
    </div>    
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{--  <script>

  // ketika tombol di click
  $(document).on('click', '.detail_ba', function() {
    alert('bebas tapi bukan ');

      var row = $(this).closest('tr');
      var kode_ba = row.find('td:eq(1)').text();

      Swal.fire({
          title: 'Konfirmasi',
          text: 'Apakah Anda ingin menuju halaman detail employee?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya, Lanjutkan',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "/detail_check_temuan" +
                  "?kode_ba=" + encodeURIComponent(kode_ba) ; // Pastikan kode ditambahkan ke URL

              window.location.href = url;
          }
      });
  });
  //
  // buat dapetin parameter di url
  function getUrlParameter(name) {
      name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
      var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
      var results = regex.exec(location.search);
      return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  }
  // jadiin tekt url ke variabel
  var jenis = getUrlParameter('jenis');
  var jenis2 = getUrlParameter('jenis2');
</script>  --}}

<script>
  $(document).ready(function() {
      $('#myTable').DataTable({
          "ordering": false,
          initComplete: function() {
              this.api().columns().every(function(d) {
                  var column = this;
                  var theadname = $('#myTable th').eq([d]).text();
                  var select = $('<select class="form-control"><option value="">' + theadname + ': All</option></select>')
                      .appendTo($(column.header()).empty())
                      .on('change', function() {
                          var val = $.fn.dataTable.util.escapeRegex($(this).val());
                          column.search(val ? '^' + val + '$' : '', true, false).draw();
                      });

                  // Hanya untuk kolom Tracking
                  if (theadname === 'Tracking') {
                      // Menentukan nilai unik dari data di kolom Tracking
                      var uniqueValues = column.data().unique().sort();
                      // Hanya ambil nilai dari 0 hingga 7
                      var filteredValues = uniqueValues.filter(value => /^[0-7]$/.test(value));

                      filteredValues.each(function(d, j) {
                          select.append('<option value="' + d + '">' + d + '</option>');
                      });
                  } else {
                      column.data().unique().sort().each(function(d, j) {
                          select.append('<option value="' + d + '">' + d + '</option>');
                      });
                  }
              });
          }
      });
  });
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
</style>
@endsection
