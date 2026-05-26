@extends('layouts/layoutMaster')

@section('title', 'Dashboard Berita Acara (v2)')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <div class="d-flex justify-content-between align-items-start mb-3">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Berita Acara /</span> Dashboard
    </h4>
    @include('components._help_button', ['slug' => 'workflow-overview'])
  </div>

  {{-- Filter --}}
  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="{{ url('/beritaacara/v2/dashboard') }}" class="row g-2 align-items-end">
        <div class="col-md-2">
          <label class="form-label">Tanggal awal</label>
          <input type="date" name="tgl_awal" class="form-control" value="{{ $tglAwal }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Tanggal akhir</label>
          <input type="date" name="tgl_akhir" class="form-control" value="{{ $tglAkhir }}">
        </div>
        <div class="col-md-3">
          <label class="form-label">Filter Kategori</label>
          <select name="kategori_id" class="form-select">
            <option value="">— Semua kategori —</option>
            @foreach ($kategoriList as $k)
              <option value="{{ $k->id }}" {{ $kategoriId == $k->id ? 'selected' : '' }}>
                {{ $k->nama }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1">
          <label class="form-label">Per pg</label>
          <select name="per_page" class="form-select">
            <option value="10"  {{ $perPage == 10  ? 'selected' : '' }}>10</option>
            <option value="25"  {{ $perPage == 25  ? 'selected' : '' }}>25</option>
            <option value="50"  {{ $perPage == 50  ? 'selected' : '' }}>50</option>
            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary"><i class="bx bx-filter"></i> Filter</button>
          <a href="{{ url('/beritaacara/v2/dashboard') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
        <div class="col-md-2 text-end">
          <a href="{{ route('berita-acara-v2.list') }}" class="btn btn-outline-info" title="Filter lanjut (kategori + opsi)">
            <i class="bx bx-list-ul"></i> List lengkap
          </a>
          <a href="{{ route('berita-acara-v2.create') }}" class="btn btn-success">
            <i class="bx bx-plus"></i> Input
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- Tab navigation --}}
  <ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-overview">
        <i class="bx bx-grid-alt"></i> Overview
        <span class="badge bg-label-primary ms-1">{{ $slices['ALL']['total'] }}</span>
      </button>
    </li>
    @foreach ($konteksList as $bu)
      <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-{{ strtolower($bu->kode) }}">
          {{ $bu->nama }}
          <span class="badge bg-label-primary ms-1">{{ $slices[$bu->kode]['total'] ?? 0 }}</span>
        </button>
      </li>
    @endforeach
  </ul>

  <div class="tab-content">
    {{-- ============================================================
         OVERVIEW TAB
         ============================================================ --}}
    <div class="tab-pane fade show active" id="tab-overview">
      @include('berita_acara_v2._dashboard_slice', [
        'slice'   => $slices['ALL'],
        'tabId'   => 'overview',
        'showAll' => true,
      ])
    </div>

    {{-- ============================================================
         PER-KONTEKS TABS
         ============================================================ --}}
    @foreach ($konteksList as $bu)
      <div class="tab-pane fade" id="tab-{{ strtolower($bu->kode) }}">
        @include('berita_acara_v2._dashboard_slice', [
          'slice'   => $slices[$bu->kode],
          'tabId'   => strtolower($bu->kode),
          'showAll' => false,
          'buName'  => $bu->nama,
        ])
      </div>
    @endforeach
  </div>

</div>

<script>
  // Kumpulkan data untuk semua tab (chart payload)
  const chartTabsData = @json($chartTabsData);

  document.addEventListener('DOMContentLoaded', function() {
    chartTabsData.forEach(function(data) {
      renderSliceCharts(data);
    });
  });

  function renderSliceCharts(data) {
    const { tabId, showAll, daily, perKonteks, topKategori, topOpsi, perCabang } = data;

    // Donut Konteks (overview only)
    if (showAll) {
      const elKonteks = document.getElementById('chart-konteks-' + tabId);
      if (elKonteks && perKonteks && Object.keys(perKonteks).length > 0) {
        new ApexCharts(elKonteks, {
          chart: { type: 'donut', height: 280 },
          series: Object.values(perKonteks).map(v => parseInt(v)),
          labels: Object.keys(perKonteks),
          legend: { position: 'bottom' },
        }).render();
      }
    }

    // Line Trend
    const elTrend = document.getElementById('chart-trend-' + tabId);
    if (elTrend && daily && Object.keys(daily).length > 0) {
      new ApexCharts(elTrend, {
        chart: { type: 'line', height: 260, toolbar: { show: false } },
        series: [{ name: 'Jumlah BA', data: Object.values(daily).map(v => parseInt(v)) }],
        xaxis: { categories: Object.keys(daily) },
        stroke: { curve: 'smooth', width: 2 },
        markers: { size: 4 },
      }).render();
    }

    // Bar Top Kategori
    const elKat = document.getElementById('chart-kategori-' + tabId);
    if (elKat && topKategori && topKategori.length > 0) {
      new ApexCharts(elKat, {
        chart: { type: 'bar', height: 280, toolbar: { show: false } },
        series: [{ name: 'Jumlah', data: topKategori.map(k => parseInt(k.cnt)) }],
        xaxis: { categories: topKategori.map(k => k.nama) },
        plotOptions: { bar: { horizontal: false, borderRadius: 4 } },
      }).render();
    } else if (elKat) {
      elKat.innerHTML = '<div class="text-center text-muted py-5">Tidak ada data.</div>';
    }

    // Bar Top Opsi (horizontal — deskripsi opsi bisa panjang)
    const elOpsi = document.getElementById('chart-opsi-' + tabId);
    if (elOpsi && topOpsi && topOpsi.length > 0) {
      new ApexCharts(elOpsi, {
        chart: { type: 'bar', height: 320, toolbar: { show: false } },
        series: [{ name: 'Jumlah BA', data: topOpsi.map(o => parseInt(o.cnt)) }],
        xaxis: { categories: topOpsi.map(o => o.deskripsi) },
        plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
        colors: ['#71dd37'],
        dataLabels: { enabled: true },
      }).render();
    } else if (elOpsi) {
      elOpsi.innerHTML = '<div class="text-center text-muted py-4 small">Belum ada BA dengan opsi terpilih pada rentang ini.</div>';
    }

    // Bar Per Cabang (horizontal)
    const elCabang = document.getElementById('chart-cabang-' + tabId);
    if (elCabang && perCabang && perCabang.length > 0) {
      new ApexCharts(elCabang, {
        chart: { type: 'bar', height: 280, toolbar: { show: false } },
        series: [{ name: 'Jumlah', data: perCabang.map(c => parseInt(c.cnt)) }],
        xaxis: { categories: perCabang.map(c => c.cabang || '(no cabang)') },
        plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
      }).render();
    }
  }

  // ===== DataTables: sort + per-column filter pada Recent BA tables =====
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof $.fn.DataTable === 'undefined') return;

    function initRecentBaDataTable(tableEl) {
      const $table = $(tableEl);
      if ($table.data('dt-initialized')) return;
      $table.data('dt-initialized', true);

      // Tambah row filter di thead SEBELUM init DataTables
      const $thead = $table.find('thead');
      const $headerRow = $thead.find('tr:first');
      const colCount = $headerRow.find('th').length;
      const $filterRow = $('<tr class="dt-filter-row"></tr>');
      for (let i = 0; i < colCount; i++) {
        const $th = $headerRow.find('th').eq(i);
        const label = $th.text().trim();
        const noFilter = $th.attr('data-no-filter') === '1';
        if (noFilter) {
          $filterRow.append('<th></th>');
        } else {
          $filterRow.append(
            '<th>' +
              '<input type="text" class="form-control form-control-sm dt-col-filter" ' +
              'placeholder="Filter ' + label + '..." autocomplete="off">' +
            '</th>'
          );
        }
      }
      $thead.append($filterRow);

      const dt = $table.DataTable({
        paging: false,
        info: false,
        ordering: true,
        searching: true,
        dom: '<"row mb-2"<"col-sm-6"><"col-sm-6 d-flex justify-content-end"f>>t',
        orderCellsTop: true,   // sort dari row 1 (label) saja
        order: [[0, 'desc']],
        language: { search: '', searchPlaceholder: 'Cari semua kolom...' },
      });

      // Pakai pattern DataTables official: columns().every() + bind ke header(i)
      dt.columns().every(function () {
        const column = this;
        const $input = $('input.dt-col-filter', column.header());
        // Above selector tidak work karena header() = row 1 th (yang punya label).
        // Cari input di filter row eq same index:
        const colIdx = column.index();
        const $filterInput = $filterRow.find('th').eq(colIdx).find('input.dt-col-filter');

        $filterInput.on('keyup change input clear', function () {
          if (column.search() !== this.value) {
            column.search(this.value, false, false).draw();
          }
        });
      });

      // Prevent sort triggered by clicking di filter input
      $filterRow.find('input').on('click mousedown', function (e) {
        e.stopPropagation();
      });
    }

    // Init untuk tab Overview (visible saat load)
    const overviewTable = document.getElementById('recent-ba-table-overview');
    if (overviewTable) initRecentBaDataTable(overviewTable);

    // Init lazy saat tab konteks lain di-klik (kalau init langsung, DataTable hitung width salah karena hidden)
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(btn => {
      btn.addEventListener('shown.bs.tab', function (e) {
        const targetId = e.target.getAttribute('data-bs-target');
        if (targetId) {
          const tab = document.querySelector(targetId);
          if (tab) {
            const table = tab.querySelector('.recent-ba-table');
            if (table) initRecentBaDataTable(table);
          }
        }
      });
    });
  });
</script>
@endsection
