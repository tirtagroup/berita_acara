@extends('layouts/layoutMaster')

@section('title', 'Master User Level')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span><span class="text-muted fw-light">Master / Permission /</span> User Level</span>
    <div class="d-flex gap-2">
      <a href="{{ route('master.permission-matrix.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-grid-alt"></i> Permission Matrix
      </a>
      <a href="{{ route('master.panel.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-window"></i> Panels
      </a>
      <a href="{{ route('master.user-level.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i> Tambah Level
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
    Level user mendefinisikan tier/role group. Tiap user mapped ke 1 level via <code>users.level_id</code>.
    Permission dikelola per-level di Permission Matrix.
  </div>

  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th width="60">#</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th width="80">Super</th>
            <th width="100">Users</th>
            <th width="80">Status</th>
            <th width="120">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $row)
            <tr>
              <td class="text-center"><small>{{ $row->urutan }}</small></td>
              <td><code>{{ $row->kode }}</code></td>
              <td><strong>{{ $row->nama }}</strong></td>
              <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($row->deskripsi, 80) ?: '—' }}</small></td>
              <td>
                @if ($row->is_super)
                  <span class="badge bg-danger">SUPER</span>
                @else
                  —
                @endif
              </td>
              <td><span class="badge bg-label-primary">{{ $row->users_count }}</span></td>
              <td>
                @if ($row->active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              </td>
              <td>
                <a href="{{ route('master.user-level.edit', $row->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                  <i class="bx bx-edit"></i>
                </a>
                <form action="{{ route('master.user-level.toggle', $row->id) }}" method="POST" class="d-inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning" title="Toggle active">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada level.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
