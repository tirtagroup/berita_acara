@extends('layouts/layoutMaster')

@section('title', 'Master Doc Workflow')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="text-muted fw-light">Master /</span> Doc Workflow</span>
    <div class="d-flex gap-2">
      <a href="{{ route('help.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-help-circle"></i> View Help Center
      </a>
      <a href="{{ route('master.doc-workflow.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i> Tambah Dokumentasi
      </a>
    </div>
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Filter --}}
  <div class="card mb-3">
    <div class="card-body py-2">
      <form method="GET" action="{{ route('master.doc-workflow.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label small mb-1">Cari</label>
          <input type="text" name="q" class="form-control form-control-sm" placeholder="judul atau kode..." value="{{ $q }}">
        </div>
        <div class="col-md-3">
          <label class="form-label small mb-1">Modul</label>
          <select name="modul" class="form-select form-select-sm">
            <option value="">— Semua —</option>
            @foreach (['BA','PICA','MASTER','UMUM'] as $m)
              <option value="{{ $m }}" {{ $modul === $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label small mb-1">Kategori</label>
          <select name="kategori" class="form-select form-select-sm">
            <option value="">— Semua —</option>
            @foreach (['tutorial','faq','workflow','troubleshooting'] as $k)
              <option value="{{ $k }}" {{ $kategori === $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 d-flex gap-1">
          <button class="btn btn-sm btn-primary flex-grow-1" type="submit"><i class="bx bx-filter"></i> Apply</button>
          <a href="{{ route('master.doc-workflow.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th width="50">Order</th>
            <th>Kode</th>
            <th>Modul</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Target Role</th>
            <th width="80">Status</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($docs as $d)
            <tr>
              <td class="text-center"><small>{{ $d->urutan }}</small></td>
              <td><code class="small">{{ $d->kode }}</code></td>
              <td><span class="badge bg-label-primary small">{{ $d->modul }}</span></td>
              <td><span class="badge bg-label-secondary small">{{ $d->kategori }}</span></td>
              <td>
                <strong>{{ $d->judul }}</strong>
                @if ($d->ringkasan)
                  <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($d->ringkasan, 80) }}</small>
                @endif
              </td>
              <td><small>{{ $d->target_role }}</small></td>
              <td>
                @if ($d->active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              </td>
              <td>
                <a href="{{ route('help.show', $d->kode) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Preview">
                  <i class="bx bx-show"></i>
                </a>
                <a href="{{ route('master.doc-workflow.edit', $d->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                  <i class="bx bx-edit"></i>
                </a>
                <form method="POST" action="{{ route('master.doc-workflow.toggle', $d->id) }}" class="d-inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning" title="Toggle aktif">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
                <form method="POST" action="{{ route('master.doc-workflow.destroy', $d->id) }}" class="d-inline"
                      onsubmit="return confirm('Hapus dokumentasi {{ $d->judul }}?');">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                    <i class="bx bx-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada dokumentasi.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <small class="text-muted">Total: <strong>{{ $docs->count() }}</strong> dokumentasi</small>
    </div>
  </div>
</div>
@endsection
