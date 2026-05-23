@extends('layouts/layoutMaster')

@section('title', 'Master Panels')

@section('content')
@php
  $modulColor = ['BA' => 'primary', 'PICA' => 'warning', 'MASTER' => 'info', 'HELP' => 'success', 'UMUM' => 'secondary'];
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span><span class="text-muted fw-light">Master / Permission /</span> Panels</span>
    <div class="d-flex gap-2">
      <a href="{{ route('master.user-level.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-user"></i> User Levels
      </a>
      <a href="{{ route('master.permission-matrix.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-grid-alt"></i> Permission Matrix
      </a>
      <a href="{{ route('master.panel.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i> Tambah Panel
      </a>
    </div>
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="alert alert-info small">
    <strong>Panel</strong> = section/page aplikasi yang permission-able. Mis. <code>BA_LIST</code>, <code>MASTER_KONTEKS</code>.
    Panel yang <strong>scopable=true</strong> punya row-level scope (own/participant/all). Master panel biasanya scopable=false.
  </div>

  {{-- Filter --}}
  <div class="card mb-3">
    <div class="card-body py-2">
      <form method="GET" class="d-flex gap-2 align-items-end">
        <div>
          <label class="form-label small mb-1">Modul</label>
          <select name="modul" class="form-select form-select-sm">
            <option value="">— Semua —</option>
            @foreach (['BA','PICA','MASTER','HELP','UMUM'] as $m)
              <option value="{{ $m }}" {{ $modul === $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-sm btn-primary">Filter</button>
        <a href="{{ route('master.panel.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th width="50">#</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Modul</th>
            <th>URL</th>
            <th width="80">Scopable</th>
            <th>Supported Scopes</th>
            <th width="80">Status</th>
            <th width="120">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $row)
            <tr>
              <td class="text-center"><small>{{ $row->urutan }}</small></td>
              <td><code>{{ $row->kode }}</code></td>
              <td>
                @if ($row->icon)
                  <i class="bx {{ $row->icon }} text-muted me-1"></i>
                @endif
                {{ $row->nama }}
              </td>
              <td>
                <span class="badge bg-label-{{ $modulColor[$row->modul] ?? 'secondary' }}">{{ $row->modul }}</span>
              </td>
              <td><small><code>{{ $row->url ?? '—' }}</code></small></td>
              <td>
                @if ($row->scopable)
                  <span class="badge bg-info">✓</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td>
                @if (!empty($row->supported_scopes))
                  @foreach ($row->supported_scopes as $s)
                    <span class="badge bg-label-secondary small">{{ $s }}</span>
                  @endforeach
                @else
                  <small class="text-muted">—</small>
                @endif
              </td>
              <td>
                @if ($row->active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Off</span>
                @endif
              </td>
              <td>
                <a href="{{ route('master.panel.edit', $row->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                  <i class="bx bx-edit"></i>
                </a>
                <form action="{{ route('master.panel.toggle', $row->id) }}" method="POST" class="d-inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning" title="Toggle">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="text-center text-muted py-4">Belum ada panel.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <small class="text-muted">Total: <strong>{{ $items->count() }}</strong> panel</small>
    </div>
  </div>
</div>
@endsection
