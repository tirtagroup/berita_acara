@extends('layouts/layoutMaster')

@section('title', 'Master Pertanyaan PICA')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / PICA /</span> Pertanyaan
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
          <label class="form-label">Scope</label>
          <select name="scope" class="form-select">
            <option value="">— Semua —</option>
            <option value="wajib_universal" {{ $request->scope === 'wajib_universal' ? 'selected' : '' }}>Wajib Universal</option>
            <option value="bantuan" {{ $request->scope === 'bantuan' ? 'selected' : '' }}>Bantuan</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Tipe</label>
          <select name="tipe" class="form-select">
            <option value="">— Semua —</option>
            <option value="pertanyaan" {{ $request->tipe === 'pertanyaan' ? 'selected' : '' }}>Pertanyaan</option>
            <option value="pernyataan" {{ $request->tipe === 'pernyataan' ? 'selected' : '' }}>Pernyataan</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Cari teks</label>
          <input type="text" name="q" class="form-control" value="{{ $request->q }}" placeholder="kata kunci...">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-outline-primary w-100"><i class="bx bx-search"></i> Filter</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0">Daftar Pertanyaan ({{ $items->count() }})</h5>
      <a href="{{ route('master.pica.pertanyaan.create') }}" class="btn btn-primary">
        <i class="bx bx-plus"></i> Tambah Pertanyaan
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th width="80">Kode</th>
            <th>Pertanyaan</th>
            <th width="100">Tipe</th>
            <th width="120">Scope</th>
            <th width="60">Urutan</th>
            <th width="80">Status</th>
            <th width="100">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i)
            <tr>
              <td><code>{{ $i->kode }}</code></td>
              <td><small>{{ $i->pertanyaan }}</small></td>
              <td>
                @if ($i->tipe === 'pertanyaan')
                  <span class="badge bg-label-primary">Pertanyaan</span>
                @else
                  <span class="badge bg-label-info">Pernyataan</span>
                @endif
              </td>
              <td>
                @if ($i->scope === 'wajib_universal')
                  <span class="badge bg-danger">Wajib Universal</span>
                @else
                  <span class="badge bg-secondary">Bantuan</span>
                @endif
              </td>
              <td>{{ $i->urutan }}</td>
              <td>
                @if ($i->active)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              </td>
              <td>
                <a href="{{ route('master.pica.pertanyaan.edit', $i->id) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bx bx-edit"></i>
                </a>
                <form action="{{ route('master.pica.pertanyaan.toggle', $i->id) }}" method="POST" class="d-inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning"
                          onclick="return confirm('Toggle status?');">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pertanyaan master.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    <a href="{{ route('master.pica.kategori.index') }}" class="btn btn-outline-secondary">
      ← Kelola Kategori PICA
    </a>
  </div>
</div>
@endsection
