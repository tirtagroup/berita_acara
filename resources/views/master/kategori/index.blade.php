@extends('layouts/layoutMaster')

@section('title', 'Master Kategori BA')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master /</span> Kategori Berita Acara
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0">Daftar Kategori ({{ $kategori->count() }})</h5>
      <a href="{{ route('master.kategori.create') }}" class="btn btn-primary">
        <i class="bx bx-plus"></i> Tambah Kategori
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped" id="kategori-table">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Parent</th>
            <th>BU</th>
            <th>Status</th>
            <th>Opsi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kategori as $k)
            <tr>
              <td><code>{{ $k->kode }}</code></td>
              <td>{{ $k->nama }}</td>
              <td>{{ $k->parent?->nama ?? '—' }}</td>
              <td>
                @forelse ($k->businessUnits as $bu)
                  <small title="{{ $bu->nama }} — {{ $bu->pivot->level }}">{{ $bu->kode }}</small>{{ !$loop->last ? ', ' : '' }}
                @empty
                  <small class="text-muted">—</small>
                @endforelse
              </td>
              <td>
                @if ($k->active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              </td>
              <td>
                <a href="{{ route('master.kategori.opsi.index', $k->id) }}" class="btn btn-sm btn-outline-info">
                  <i class="bx bx-list-ul"></i> Kelola Opsi
                </a>
              </td>
              <td>
                <a href="{{ route('master.kategori.edit', $k->id) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bx bx-edit"></i>
                </a>
                <form action="{{ route('master.kategori.toggle', $k->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning"
                          onclick="return confirm('Toggle status kategori ini?');">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <a href="{{ route('master.mapping.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-grid-alt"></i> Atur Mapping BU × Kategori
      </a>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof $.fn.DataTable !== 'undefined') {
      $('#kategori-table').DataTable({ pageLength: 25 });
    }
  });
</script>
@endsection
