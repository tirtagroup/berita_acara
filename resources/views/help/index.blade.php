@extends('layouts/layoutMaster')

@section('title', 'Help Center')

@section('content')
@php
  $modulColor = ['BA' => 'primary', 'PICA' => 'warning', 'MASTER' => 'info', 'UMUM' => 'secondary'];
  $modulNama  = ['BA' => 'Berita Acara', 'PICA' => 'PICA', 'MASTER' => 'Master Data', 'UMUM' => 'Umum'];
  $kategoriIcon = ['tutorial' => 'bx-book-open', 'faq' => 'bx-question-mark', 'workflow' => 'bx-flow-chart', 'troubleshooting' => 'bx-wrench'];
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <h4 class="fw-bold py-3 mb-0">
      <i class="bx bx-help-circle"></i> Help Center
    </h4>
    @auth
      @php $isAdmin = in_array(strtolower(auth()->user()->role ?? ''), ['admin','super_admin','superadmin','administrator']); @endphp
      @if ($isAdmin)
        <a href="{{ route('master.doc-workflow.index') }}" class="btn btn-sm btn-outline-secondary">
          <i class="bx bx-cog"></i> Manage Docs (Admin)
        </a>
      @endif
    @endauth
  </div>

  {{-- Search bar --}}
  <div class="card mb-3">
    <div class="card-body py-2">
      <form method="GET" action="{{ route('help.index') }}" class="d-flex gap-2">
        <input type="text" name="q" class="form-control" placeholder="Cari tutorial / FAQ..."
               value="{{ $q }}" autofocus>
        <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Cari</button>
        @if ($q !== '')
          <a href="{{ route('help.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
      </form>
    </div>
  </div>

  @if ($q !== '' && $grouped->isEmpty())
    <div class="alert alert-warning">
      Tidak ada dokumentasi yang cocok dengan "<strong>{{ $q }}</strong>".
    </div>
  @endif

  {{-- Grouped by modul --}}
  @foreach ($grouped as $modulKode => $docs)
    @php $color = $modulColor[$modulKode] ?? 'secondary'; @endphp
    <div class="card mb-3">
      <div class="card-header py-2 bg-label-{{ $color }}">
        <h5 class="card-title mb-0">
          <span class="badge bg-{{ $color }} me-1">{{ $modulKode }}</span>
          {{ $modulNama[$modulKode] ?? $modulKode }}
          <small class="text-muted">({{ $docs->count() }} dokumen)</small>
        </h5>
      </div>
      <div class="card-body">
        <div class="row g-3">
          @foreach ($docs as $d)
            <div class="col-md-6">
              <a href="{{ route('help.show', ['kode' => $d->kode]) }}"
                 class="card text-decoration-none border h-100" style="transition: all .15s">
                <div class="card-body py-2">
                  <div class="d-flex align-items-start gap-2">
                    <i class="bx {{ $d->icon ?: $kategoriIcon[$d->kategori] ?? 'bx-file' }} bx-md text-{{ $color }}"></i>
                    <div class="flex-grow-1">
                      <h6 class="mb-1">{{ $d->judul }}</h6>
                      <small class="text-muted d-block">{{ $d->ringkasan ?: '—' }}</small>
                      <small class="text-muted">
                        <span class="badge bg-label-{{ $color }} small">{{ $d->kategori }}</span>
                        @if ($d->target_role !== 'all')
                          <span class="badge bg-label-secondary small">untuk: {{ $d->target_role }}</span>
                        @endif
                      </small>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
