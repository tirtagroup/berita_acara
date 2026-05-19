@extends('layouts/layoutMaster')

@section('title', 'Master Kategori PICA')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / PICA /</span> Kategori
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0">Daftar Kategori PICA ({{ $kategori->count() }})</h5>
      <a href="{{ route('master.pica.kategori.create') }}" class="btn btn-primary">
        <i class="bx bx-plus"></i> Tambah Kategori
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($kategori as $k)
            <tr>
              <td><code>{{ $k->kode }}</code></td>
              <td>{{ $k->nama }}</td>
              <td><small>{{ $k->deskripsi ?? '—' }}</small></td>
              <td>
                @if ($k->active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              </td>
              <td>
                <a href="{{ route('master.pica.kategori.edit', $k->id) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bx bx-edit"></i>
                </a>
                <form action="{{ route('master.pica.kategori.toggle', $k->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning"
                          onclick="return confirm('Toggle status kategori?');">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori PICA. Tambah di atas →</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    <a href="{{ route('master.pica.pertanyaan.index') }}" class="btn btn-outline-secondary">
      <i class="bx bx-list-ul"></i> Kelola Pertanyaan Master →
    </a>
  </div>
</div>
@endsection
