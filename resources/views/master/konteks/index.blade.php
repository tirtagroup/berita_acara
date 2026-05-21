@extends('layouts/layoutMaster')

@section('title', 'Master Konteks')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span><span class="text-muted fw-light">Master /</span> Konteks</span>
    <a href="{{ route('master.konteks.create') }}" class="btn btn-primary">
      <i class="bx bx-plus"></i> Tambah Konteks
    </a>
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="alert alert-info small">
    Konteks adalah dimensi utama BA/PICA (LAKA, FNB, OP_HR, REVISI).
    Konteks dipakai untuk filter kategori di wizard + slicer di dashboard.
  </div>

  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th width="60">ID</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th width="100">Status</th>
            <th width="120">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $row)
            <tr>
              <td><small class="text-muted">{{ $row->id }}</small></td>
              <td><code>{{ $row->kode }}</code></td>
              <td>{{ $row->nama }}</td>
              <td><small class="text-muted">{{ $row->deskripsi ?? '—' }}</small></td>
              <td>
                @if ($row->active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              </td>
              <td>
                <a href="{{ route('master.konteks.edit', $row->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                  <i class="bx bx-edit"></i>
                </a>
                <form action="{{ route('master.konteks.toggle', $row->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Toggle status konteks ini?');">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning" title="Toggle aktif">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada konteks.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
