@extends('layouts/layoutMaster')

@section('title', $doc->judul . ' — Help')

@section('content')
@php
  $modulColor = ['BA' => 'primary', 'PICA' => 'warning', 'MASTER' => 'info', 'UMUM' => 'secondary'];
  $color = $modulColor[$doc->modul] ?? 'secondary';
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  {{-- Breadcrumb --}}
  <nav class="mb-3 small">
    <a href="{{ route('help.index') }}"><i class="bx bx-help-circle"></i> Help</a>
    <span class="text-muted">/</span>
    <span class="badge bg-label-{{ $color }}">{{ $doc->modul }}</span>
    <span class="text-muted">/</span>
    <span class="text-muted">{{ $doc->kategori }}</span>
  </nav>

  <div class="row">
    {{-- Main content --}}
    <div class="col-lg-9">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
            <h4 class="mb-1">
              <i class="bx {{ $doc->icon ?: 'bx-file' }} text-{{ $color }}"></i>
              {{ $doc->judul }}
            </h4>
            @if ($doc->ringkasan)
              <small class="text-muted">{{ $doc->ringkasan }}</small>
            @endif
          </div>
          <div>
            <span class="badge bg-label-{{ $color }}">{{ $doc->modul }}</span>
            <span class="badge bg-label-secondary">{{ $doc->kategori }}</span>
            @if ($doc->target_role !== 'all')
              <span class="badge bg-label-info">untuk: {{ $doc->target_role }}</span>
            @endif
          </div>
        </div>
        <div class="card-body doc-content">
          {!! $html !!}
        </div>
        <div class="card-footer text-muted small">
          Kode: <code>{{ $doc->kode }}</code>
          · Updated: {{ $doc->updated_at?->diffForHumans() }}
          @if ($doc->updated_by)
            by {{ $doc->updated_by }}
          @endif
        </div>
      </div>

      <div class="mt-3">
        <a href="{{ route('help.index') }}" class="btn btn-outline-secondary">
          <i class="bx bx-arrow-back"></i> Kembali ke Help Center
        </a>
      </div>
    </div>

    {{-- Sidebar: related docs --}}
    <div class="col-lg-3">
      @if ($related->isNotEmpty())
        <div class="card">
          <div class="card-header py-2">
            <strong>Lainnya di {{ $doc->modul }}</strong>
          </div>
          <div class="list-group list-group-flush">
            @foreach ($related as $r)
              <a href="{{ route('help.show', ['kode' => $r->kode]) }}"
                 class="list-group-item list-group-item-action">
                <i class="bx {{ $r->icon ?: 'bx-file' }} text-muted small"></i>
                {{ $r->judul }}
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

<style>
  .doc-content h3 { font-size: 1.5rem; font-weight: 600; }
  .doc-content h4 { font-size: 1.25rem; font-weight: 600; }
  .doc-content h5 { font-size: 1.1rem; font-weight: 500; }
  .doc-content pre { font-size: 0.85em; max-height: 400px; overflow: auto; }
  .doc-content code { font-size: 0.9em; }
  .doc-content ul, .doc-content ol { padding-left: 1.5rem; }
  .doc-content p { margin-bottom: 0.75rem; }
</style>
@endsection
