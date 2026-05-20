@extends('layouts/layoutMaster')

@section('title', 'Dashboard PICA (v2)')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('content')
@php
  $statusColor = [
    'DRAFT'           => 'secondary',
    'PREPARING'       => 'info',
    'WAITING_PELAKU'  => 'warning',
    'ACTION_PLANNING' => 'primary',
    'CLOSED'          => 'success',
    'Belum Closing'   => 'dark',  // legacy
  ];
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">PICA /</span> Dashboard
    </h4>
    <div class="d-flex gap-2">
      <a href="{{ route('pica-v2.list') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bx bx-list-ul"></i> List PICA
      </a>
      <a href="{{ route('pica-v2.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i> Buat PICA Baru
      </a>
    </div>
  </div>

  {{-- ============ FILTER ============ --}}
  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="{{ route('pica-v2.dashboard') }}" class="row g-2 align-items-end">
        <div class="col-md-2">
          <label class="form-label">Tanggal awal</label>
          <input type="date" name="tgl_awal" class="form-control" value="{{ $tglAwal }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Tanggal akhir</label>
          <input type="date" name="tgl_akhir" class="form-control" value="{{ $tglAkhir }}">
        </div>
        <div class="col-md-3">
          <label class="form-label">Konteks</label>
          <select name="konteks_kode" class="form-select">
            <option value="">— Semua Konteks —</option>
            @foreach ($konteksList as $k)
              <option value="{{ $k->kode }}" {{ $konteksKode === $k->kode ? 'selected' : '' }}>
                {{ $k->kode }} — {{ $k->nama }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary w-100" type="submit"><i class="bx bx-filter-alt"></i> Apply</button>
        </div>
        <div class="col-md-2">
          <a href="{{ route('pica-v2.dashboard') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
      </form>
    </div>
  </div>

  {{-- ============ STAT CARDS ============ --}}
  <div class="row g-3 mb-3">
    <div class="col-md col-6">
      <div class="card">
        <div class="card-body py-3 text-center">
          <small class="text-muted text-uppercase">Total</small>
          <h3 class="mb-0">{{ $stats['total'] }}</h3>
        </div>
      </div>
    </div>
    @foreach (['PREPARING', 'WAITING_PELAKU', 'ACTION_PLANNING', 'CLOSED', 'Belum Closing'] as $s)
      @php $c = $stats['per_status'][$s] ?? 0; @endphp
      <div class="col-md col-6">
        <a href="{{ route('pica-v2.list', ['status' => [$s], 'tgl_awal' => $tglAwal, 'tgl_akhir' => $tglAkhir, 'konteks_kode' => $konteksKode]) }}"
           class="card text-decoration-none">
          <div class="card-body py-3 text-center">
            <small class="text-muted text-uppercase">{{ $s }}</small>
            <h3 class="mb-0 text-{{ $statusColor[$s] ?? 'secondary' }}">{{ $c }}</h3>
            @if ($s === 'Belum Closing')
              <small class="text-muted d-block">(legacy)</small>
            @endif
          </div>
        </a>
      </div>
    @endforeach
  </div>

  {{-- ============ CHARTS ============ --}}
  <div class="row g-3 mb-3">
    {{-- Donut per status --}}
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header"><strong>PICA per Status</strong></div>
        <div class="card-body"><div id="chart-status"></div></div>
      </div>
    </div>
    {{-- Donut per Konteks --}}
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header"><strong>PICA per Konteks</strong></div>
        <div class="card-body"><div id="chart-konteks"></div></div>
      </div>
    </div>
    {{-- Bar per kategori --}}
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-header"><strong>Top Kategori PICA</strong></div>
        <div class="card-body"><div id="chart-kategori"></div></div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-3">
    {{-- Line trend daily --}}
    <div class="col-12">
      <div class="card">
        <div class="card-header"><strong>Trend PICA Harian</strong></div>
        <div class="card-body"><div id="chart-trend"></div></div>
      </div>
    </div>
  </div>

  {{-- ============ RECENT TABLE ============ --}}
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      <strong>10 PICA Terakhir</strong>
      <a href="{{ route('pica-v2.list', ['tgl_awal' => $tglAwal, 'tgl_akhir' => $tglAkhir, 'konteks_kode' => $konteksKode]) }}"
         class="btn btn-sm btn-outline-primary">Lihat semua →</a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover table-sm align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Kode</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Konteks</th>
              <th>Pelaku</th>
              <th>Problem</th>
              <th>Kategori</th>
              <th width="100">Progress</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recent as $r)
              <tr>
                <td>
                  <a href="{{ route('pica-v2.discussion', ['kode' => $r->Tr_Pica_Emp_h_Code]) }}">
                    <code>{{ $r->Tr_Pica_Emp_h_Code }}</code>
                  </a>
                </td>
                <td><small>{{ \Carbon\Carbon::parse($r->Date_PICA)->format('d M Y') }}</small></td>
                <td>
                  <span class="badge bg-label-{{ $statusColor[$r->Status_PICA] ?? 'secondary' }}">
                    {{ $r->Status_PICA }}
                  </span>
                </td>
                <td><small>{{ $r->konteks_kode ?? '—' }}</small></td>
                <td>
                  <a href="{{ route('pica-v2.list', ['pelaku' => $r->Emp_Code]) }}">
                    {{ $r->pelaku_name }}
                  </a>
                </td>
                <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($r->Problem_Note, 60) }}</small></td>
                <td>
                  @foreach (($r->kategori ?? []) as $kat)
                    <span class="badge bg-label-info small">{{ $kat }}</span>
                  @endforeach
                </td>
                <td>
                  @if ($r->progress['total'] > 0)
                    <small>{{ $r->progress['terisi'] }}/{{ $r->progress['total'] }}</small>
                    <div class="progress" style="height:5px">
                      <div class="progress-bar bg-{{ $r->progress['terisi'] >= $r->progress['total'] ? 'success' : 'warning' }}"
                           style="width: {{ $r->progress['total'] ? ($r->progress['terisi'] / $r->progress['total'] * 100) : 0 }}%"></div>
                    </div>
                  @else
                    <small class="text-muted">—</small>
                  @endif
                </td>
              </tr>
            @empty
              <tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada PICA pada rentang ini.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const stats = @json($stats);
  const statusColors = ['#6c757d', '#03c3ec', '#ffab00', '#696cff', '#71dd37']; // DRAFT, PREPARING, WAITING_PELAKU, ACTION_PLANNING, CLOSED
  const statusLabels = ['DRAFT', 'PREPARING', 'WAITING_PELAKU', 'ACTION_PLANNING', 'CLOSED'];

  // Donut: status
  const elStatus = document.getElementById('chart-status');
  if (elStatus && stats.total > 0) {
    new ApexCharts(elStatus, {
      chart: { type: 'donut', height: 280 },
      labels: statusLabels,
      series: statusLabels.map(s => stats.per_status[s] ?? 0),
      colors: statusColors,
      legend: { position: 'bottom' },
      dataLabels: { enabled: true, formatter: (val, opts) => opts.w.config.series[opts.seriesIndex] || '' },
    }).render();
  } else if (elStatus) {
    elStatus.innerHTML = '<div class="text-center text-muted py-5">Tidak ada data.</div>';
  }

  // Donut: Konteks
  const elKonteks = document.getElementById('chart-konteks');
  if (elKonteks && stats.per_konteks.length > 0) {
    new ApexCharts(elKonteks, {
      chart: { type: 'donut', height: 280 },
      labels: stats.per_konteks.map(r => r.konteks),
      series: stats.per_konteks.map(r => r.cnt),
      legend: { position: 'bottom' },
    }).render();
  } else if (elKonteks) {
    elKonteks.innerHTML = '<div class="text-center text-muted py-5">Tidak ada data.</div>';
  }

  // Bar: kategori
  const elKat = document.getElementById('chart-kategori');
  if (elKat && stats.per_kategori.length > 0) {
    new ApexCharts(elKat, {
      chart: { type: 'bar', height: 280 },
      plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
      series: [{ name: 'PICA', data: stats.per_kategori.map(r => r.cnt) }],
      xaxis: { categories: stats.per_kategori.map(r => r.nama) },
      dataLabels: { enabled: true },
      colors: ['#696cff'],
    }).render();
  } else if (elKat) {
    elKat.innerHTML = '<div class="text-center text-muted py-5">Belum ada kategori.</div>';
  }

  // Line: trend
  const elTrend = document.getElementById('chart-trend');
  if (elTrend) {
    new ApexCharts(elTrend, {
      chart: { type: 'area', height: 250, toolbar: { show: false } },
      series: [{ name: 'PICA dibuat', data: stats.trend.map(r => r.cnt) }],
      xaxis: { categories: stats.trend.map(r => r.tgl), type: 'datetime' },
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 2 },
      colors: ['#71dd37'],
      fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
    }).render();
  }
});
</script>
@endsection
