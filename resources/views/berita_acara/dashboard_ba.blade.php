@extends('layouts/layoutMaster')

@section('title', 'History Kejadian-Temuan')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />
@endsection

@section('content')

@if (session('success'))
  <div class="alert alert-primary">{{ session('success') }}</div>
@endif

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms / </span> History Kejadian-Temuan</h4>

<div class="card p-3 mb-4">
  <div class="row">
    <div class="col-md-3">
      <label for="tgl_awal">Tanggal Awal</label>
      <input type="date" id="tgl_awal" class="form-control">
    </div>
    <div class="col-md-3">
      <label for="tgl_akhir">Tanggal Akhir</label>
      <input type="date" id="tgl_akhir" class="form-control">
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button id="filterBtn" class="btn btn-primary w-100">
        <i class="fas fa-search"></i> Filter
      </button>
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <a href="{{ url('dashboard_ba') }}" class="btn btn-secondary w-100">Reset</a>
    </div>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-bordered display nowrap" id="myTable" style="width:100%">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Code</th>
        <th>Fraud</th>
        <th>Kategori</th>
        <th>Kasus</th>
        <th>Detail Kasus</th>
        <th>Pelapor</th>
        <th>Divisi Pelapor</th>
        <th>Pelaku</th>
        <th>Divisi Pelaku</th>
        <th>Action</th>
      </tr>
      <tr>
        <th><input type="text" placeholder="Cari Tanggal" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Code" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Fraud" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Kategori" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Kasus" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Detail" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Pelapor" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Divisi Pelapor" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Pelaku" class="form-control form-control-sm" /></th>
        <th><input type="text" placeholder="Cari Divisi Pelaku" class="form-control form-control-sm" /></th>
        <th></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

@endsection

@section('vendor-script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
@endsection

@section('page-script')
<script>
  $(document).ready(function () {
    let table = $('#myTable').DataTable({
      scrollX: true,
      ordering: true,
      pageLength: 10,
      data: [],
      columns: [
        { data: 'created_at' },
        { data: 'Tr_BA_Main_Code' },
        { data: 'fraud' },
        { data: 'kategori' },
        { data: 'Ms_Kasus' },
        { data: 'MS_Detail_Kasus' },
        { data: 'Ms_Pelapor_Code' },
        { data: 'Ms_Pelapor_Div' },
        { data: 'Ms_Emp_Code' },
        { data: 'Ms_Emp_Div' },
        { data: 'action', orderable: false, searchable: false }
      ],
      initComplete: function () {
        this.api().columns().every(function () {
          let that = this;
          $('input', this.header()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
      }
    });

    $('#filterBtn').click(function () {
      const tgl_awal = $('#tgl_awal').val();
      const tgl_akhir = $('#tgl_akhir').val();

      if (!tgl_awal || !tgl_akhir) {
        alert('Silakan pilih tanggal awal dan akhir!');
        return;
      }

      $.ajax({
        url: "{{ url('/search_report_ba/temuan') }}",
        type: "POST",
        data: {
          _token: '{{ csrf_token() }}',
          tgl_awal: tgl_awal,
          tgl_akhir: tgl_akhir
        },
        success: function (response) {
          table.clear();

          const rows = response.data.map(function (row) {
            let kategori = '-';
            if (row.CekPelanggaran == 1) kategori = 'BA Pelanggaran SOP';
            else if (row.CekPerubahanSOP == 1) kategori = 'BA Perubahan SOP';
            else if (row.CekKehilangan == 1 || row.CekKerusakan == 1) kategori = 'Kehilangan dan Kerusakan';
            else if (row.CekPembelian == 1) kategori = 'Pembelian Barang';
            else if (row.CekLaka == 1) kategori = 'Laka';
            else if (row.CekRevisi == 1) kategori = 'BA Revisi';

            const fraud = row.CekFraud == 1 ? 'Fraud' : 'Tidak';

            const encodedCode = encodeURIComponent(row.Tr_BA_Main_Code);
            let print_url = '/berita_acara/print_berita_acara_salahisi/' + encodedCode;
            if (row.Ms_BA_type_Code === 'Laka') {
              print_url = '/berita_acara/print_berita_acara_laka/' + encodedCode;
            }

            return {
              created_at: row.created_at.substring(0, 10),
              Tr_BA_Main_Code: row.Tr_BA_Main_Code,
              fraud: fraud,
              kategori: kategori,
              Ms_Kasus: row.Ms_Kasus,
              MS_Detail_Kasus: row.MS_Detail_Kasus,
              Ms_Pelapor_Code: row.Ms_Pelapor_Code,
              Ms_Pelapor_Div: row.Ms_Pelapor_Div,
              Ms_Emp_Code: row.Ms_Emp_Code,
              Ms_Emp_Div: row.Ms_Emp_Div,
              action: `<a href="${print_url}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-success">Print</a>`
            };
          });

          table.rows.add(rows).draw();
        }
      });
    });
  });
</script>

@endsection
