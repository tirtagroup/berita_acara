@extends('layouts/layoutMaster')

@section('title', 'Home — BA & PICA Overview')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('content')
@php
  $statusColor = [
    'DRAFT'     => 'secondary',
    'PREPARING' => 'info',
    'MEETING'   => 'warning',
    'FINALIZED' => 'primary',
    'DONE'      => 'success',
  ];
  $konteksColor = [
    'LAKA'   => 'danger',
    'FNB'    => 'success',
    'OP_HR'  => 'info',
    'REVISI' => 'warning',
    'FMCG'   => 'primary',
  ];
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Home /</span> Overview BA &amp; PICA
    </h4>
    <div class="d-flex gap-2">
      <a href="{{ url('/beritaacara/v2/dashboard') }}" class="btn btn-sm btn-outline-primary">
        <i class="bx bx-detail"></i> Detail Dashboard BA
      </a>
      <a href="{{ url('/pica/v2/dashboard') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-detail"></i> Detail Dashboard PICA
      </a>
    </div>
  </div>

  {{-- ============ FILTER ============ --}}
  <div class="card mb-3">
    <div class="card-body py-3">
      <form method="GET" action="{{ url('/home-v2') }}" class="row g-2 align-items-end">
        <div class="col-md-2">
          <label class="form-label small mb-1">Tanggal awal</label>
          <input type="date" name="tgl_awal" value="{{ $tglAwal }}" class="form-control form-control-sm">
        </div>
        <div class="col-md-2">
          <label class="form-label small mb-1">Tanggal akhir</label>
          <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" class="form-control form-control-sm">
        </div>
        <div class="col-md-2">
          <label class="form-label small mb-1">Konteks</label>
          <select name="konteks_kode" class="form-select form-select-sm">
            <option value="">— semua konteks —</option>
            @foreach ($konteksList as $k)
              <option value="{{ $k->kode }}" {{ $konteksKode === $k->kode ? 'selected' : '' }}>
                {{ $k->kode }} — {{ $k->nama }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-sm btn-primary">
            <i class="bx bx-filter-alt"></i> Apply
          </button>
          <a href="{{ url('/home-v2') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>

  {{-- ============ 4 KPI CARDS ============ --}}
  <div class="row g-3 mb-3">
    <div class="col-md-3">
      <div class="card h-100 border-primary">
        <div class="card-body py-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <small class="text-muted">Total BA</small>
              <h3 class="mb-0 mt-1 text-primary">{{ number_format($baTotal) }}</h3>
              <small class="text-muted">{{ $tglAwal }} → {{ $tglAkhir }}</small>
            </div>
            <i class="bx bx-book text-primary fs-1"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100 border-info">
        <div class="card-body py-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <small class="text-muted">Total PICA</small>
              <h3 class="mb-0 mt-1 text-info">{{ number_format($picaTotal) }}</h3>
              <small class="text-muted">{{ $picaActiveCount }} active · {{ $picaDoneCount }} done</small>
            </div>
            <i class="bx bx-check-circle text-info fs-1"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100 border-success">
        <div class="card-body py-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <small class="text-muted">PICA Closure Rate</small>
              <h3 class="mb-0 mt-1 text-success">{{ $closureRate }}%</h3>
              <small class="text-muted">DONE / total PICA</small>
            </div>
            <i class="bx bx-trending-up text-success fs-1"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card h-100 border-warning">
        <div class="card-body py-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <small class="text-muted">BA → PICA Rate</small>
              <h3 class="mb-0 mt-1 text-warning">{{ $baToPicaRate }}%</h3>
              <small class="text-muted">% BA yang follow-up PICA</small>
            </div>
            <i class="bx bx-link text-warning fs-1"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ============ 2 CHART ROW ============ --}}
  <div class="row g-3 mb-3">
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header py-2">
          <h6 class="mb-0">BA — Top Kategori (top 8)</h6>
        </div>
        <div class="card-body">
          @if ($baTopKategori->isEmpty())
            <div class="text-center text-muted py-4">Tidak ada data BA di periode ini.</div>
          @else
            <div id="ba-kategori-chart"></div>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header py-2">
          <h6 class="mb-0">PICA — Per Status</h6>
        </div>
        <div class="card-body">
          @if ($picaTotal === 0)
            <div class="text-center text-muted py-4">Tidak ada data PICA di periode ini.</div>
          @else
            <div id="pica-status-chart"></div>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- ============ Per-Konteks summary ============ --}}
  @if ($baPerKonteks->isNotEmpty() && !$konteksKode)
    <div class="card mb-3">
      <div class="card-header py-2">
        <h6 class="mb-0">BA Per Konteks</h6>
      </div>
      <div class="card-body py-3">
        <div class="d-flex gap-2 flex-wrap">
          @foreach ($baPerKonteks as $row)
            <div class="d-flex align-items-center gap-2">
              <span class="badge bg-{{ $konteksColor[$row->kode] ?? 'secondary' }}">{{ $row->kode }}</span>
              <strong>{{ number_format($row->cnt) }}</strong>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  {{-- ============ 2 RECENT LIST ROW ============ --}}
  <div class="row g-3 mb-3">
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">BA Terbaru</h6>
          <a href="{{ url('/beritaacara/v2/dashboard') }}" class="btn btn-sm btn-link p-0">lihat semua →</a>
        </div>
        <div class="card-body p-0">
          @if ($baRecent->isEmpty())
            <div class="text-center text-muted py-4">Belum ada BA di periode ini.</div>
          @else
            <table class="table table-sm align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th width="100">Kode</th>
                  <th width="90">Tanggal</th>
                  <th width="70">Konteks</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($baRecent as $ba)
                  <tr>
                    <td><small><code>{{ $ba->kode }}</code></small></td>
                    <td><small>{{ \Carbon\Carbon::parse($ba->Date_BA)->format('d M') }}</small></td>
                    <td>
                      @if ($ba->konteks)
                        <span class="badge bg-{{ $konteksColor[$ba->konteks] ?? 'secondary' }}">{{ $ba->konteks }}</span>
                      @else
                        <small class="text-muted">—</small>
                      @endif
                    </td>
                    <td><small>{{ \Illuminate\Support\Str::limit($ba->deskripsi, 60) }}</small></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">PICA Terbaru</h6>
          <a href="{{ url('/pica/v2/dashboard') }}" class="btn btn-sm btn-link p-0">lihat semua →</a>
        </div>
        <div class="card-body p-0">
          @if ($picaRecent->isEmpty())
            <div class="text-center text-muted py-4">Belum ada PICA di periode ini.</div>
          @else
            <table class="table table-sm align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th width="120">Kode</th>
                  <th width="90">Tanggal</th>
                  <th width="100">Status</th>
                  <th>BA Link</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($picaRecent as $pica)
                  <tr>
                    <td><small><code>{{ $pica->kode }}</code></small></td>
                    <td><small>{{ \Carbon\Carbon::parse($pica->Date_PICA)->format('d M') }}</small></td>
                    <td>
                      <span class="badge bg-{{ $statusColor[$pica->status] ?? 'dark' }}">{{ $pica->status }}</span>
                    </td>
                    <td><small><code>{{ $pica->ba_kode ?: '—' }}</code></small></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- ============ Quick Actions ============ --}}
  <div class="card">
    <div class="card-body py-3">
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ url('/beritaacara/v2/create') }}" class="btn btn-sm btn-primary">
          <i class="bx bx-plus"></i> Buat BA Baru
        </a>
        <a href="{{ route('pica-v2.create') }}" class="btn btn-sm btn-info">
          <i class="bx bx-plus"></i> Buat PICA Baru
        </a>
        <a href="{{ url('/beritaacara/v2/list') }}" class="btn btn-sm btn-outline-secondary">
          <i class="bx bx-list-ul"></i> List BA
        </a>
        <a href="{{ route('pica-v2.list') }}" class="btn btn-sm btn-outline-secondary">
          <i class="bx bx-list-ul"></i> List PICA
        </a>
      </div>
    </div>
  </div>
</div>

{{-- ============ CHARTS (ApexCharts) ============ --}}
@if ($baTopKategori->isNotEmpty())
<script>
  document.addEventListener('DOMContentLoaded', function() {
    new ApexCharts(document.querySelector("#ba-kategori-chart"), {
      chart: { type: 'bar', height: 300, toolbar: { show: false } },
      series: [{
        name: 'Jumlah BA',
        data: @json($baTopKategori->pluck('cnt')->all())
      }],
      xaxis: {
        categories: @json($baTopKategori->pluck('nama')->all()),
        labels: { style: { fontSize: '11px' } }
      },
      plotOptions: { bar: { horizontal: true, distributed: true } },
      legend: { show: false },
      dataLabels: { enabled: true, style: { fontSize: '11px' } },
      colors: ['#696cff', '#03c3ec', '#71dd37', '#ffab00', '#ff3e1d', '#8592a3', '#566a7f', '#a8b1bb']
    }).render();
  });
</script>
@endif

@if ($picaTotal > 0)
<script>
  document.addEventListener('DOMContentLoaded', function() {
    new ApexCharts(document.querySelector("#pica-status-chart"), {
      chart: { type: 'donut', height: 300 },
      series: @json(array_values($picaPerStatus)),
      labels: @json(array_keys($picaPerStatus)),
      colors: ['#8592a3', '#03c3ec', '#ffab00', '#696cff', '#71dd37'],
      legend: { position: 'bottom', fontSize: '12px' },
      dataLabels: { enabled: true, formatter: (val) => val.toFixed(1) + '%' }
    }).render();
  });
</script>
@endif
@endsection
