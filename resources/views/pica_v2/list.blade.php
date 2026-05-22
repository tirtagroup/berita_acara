@extends('layouts/layoutMaster')

@section('title', 'List PICA (v2)')

@section('content')
@php
  $statusColor = [
    'DRAFT'           => 'secondary',
    'PREPARING'       => 'info',
    'MEETING'  => 'warning',
    'ACTION_PLANNING' => 'primary',
    'CLOSED'          => 'success',
    'Belum Closing'   => 'dark',  // legacy
  ];
  $allStatuses = ['DRAFT', 'PREPARING', 'MEETING', 'ACTION_PLANNING', 'CLOSED', 'Belum Closing'];
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">PICA /</span> List
    </h4>
    <div class="d-flex gap-2">
      <a href="{{ route('pica-v2.dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bx bx-bar-chart-square"></i> Dashboard
      </a>
      <a href="{{ route('pica-v2.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i> Buat PICA
      </a>
    </div>
  </div>

  {{-- ============ FILTER ============ --}}
  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="{{ route('pica-v2.list') }}" class="row g-2 align-items-end">
        <div class="col-md-2">
          <label class="form-label">Tanggal awal</label>
          <input type="date" name="tgl_awal" class="form-control form-control-sm" value="{{ $tglAwal }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Tanggal akhir</label>
          <input type="date" name="tgl_akhir" class="form-control form-control-sm" value="{{ $tglAkhir }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Konteks</label>
          <select name="konteks_kode" class="form-select form-select-sm">
            <option value="">— Semua Konteks —</option>
            @foreach ($konteksList as $k)
              <option value="{{ $k->kode }}" {{ $konteksKode === $k->kode ? 'selected' : '' }}>{{ $k->kode }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Pelaku (kode/nama)</label>
          <input type="text" name="pelaku" class="form-control form-control-sm" value="{{ $pelakuQ }}" placeholder="cari pelaku...">
        </div>
        <div class="col-md-2">
          <label class="form-label">Per page</label>
          <select name="per_page" class="form-select form-select-sm">
            @foreach ([10, 25, 50, 100] as $pp)
              <option value="{{ $pp }}" {{ $perPage == $pp ? 'selected' : '' }}>{{ $pp }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary btn-sm" type="submit"><i class="bx bx-filter-alt"></i> Apply</button>
        </div>

        {{-- Row 2: status checkboxes + kategori multi --}}
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <div>
            @foreach ($allStatuses as $s)
              <label class="form-check-label me-2 small">
                <input type="checkbox" name="status[]" value="{{ $s }}" class="form-check-input"
                  {{ in_array($s, $status) ? 'checked' : '' }}>
                <span class="badge bg-label-{{ $statusColor[$s] ?? 'secondary' }}">{{ $s }}</span>
              </label>
            @endforeach
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Kategori (multi)</label>
          <select name="kategori_ids[]" multiple class="form-select form-select-sm" size="3">
            @foreach ($kategoriList as $k)
              <option value="{{ $k->id }}" {{ in_array($k->id, $kategoriIds) ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
          </select>
          <small class="text-muted">Ctrl/Cmd+click untuk multi-select.</small>
        </div>

        <div class="col-12">
          <a href="{{ route('pica-v2.list') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-reset"></i> Reset filter
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- ============ TABLE ============ --}}
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      <small class="text-muted">Total: <strong>{{ $rows->total() }}</strong> PICA</small>
      <small class="text-muted">Page {{ $rows->currentPage() }} dari {{ $rows->lastPage() }}</small>
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
              <th>BA Link</th>
              <th width="100">Wajib Q</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rows as $r)
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
                  <a href="{{ route('pica-v2.list', ['pelaku' => $r->Emp_Code]) }}" class="text-decoration-none">
                    {{ $r->pelaku_name }}
                  </a>
                </td>
                <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($r->Problem_Note, 80) }}</small></td>
                <td>
                  @foreach (($r->kategori ?? []) as $kat)
                    <span class="badge bg-label-info small">{{ $kat }}</span>
                  @endforeach
                </td>
                <td>
                  @if ($r->NoBA)
                    <a href="{{ route('berita-acara-v2.show') }}?kode={{ $r->NoBA }}" class="small">
                      {{ $r->NoBA }}
                    </a>
                  @else
                    <small class="text-muted">—</small>
                  @endif
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
              <tr><td colspan="9" class="text-center py-4 text-muted">Tidak ada PICA dengan filter ini.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if ($rows->hasPages())
      <div class="card-footer">
        {{ $rows->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
