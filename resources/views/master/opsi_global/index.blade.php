@extends('layouts/layoutMaster')

@section('title', 'Semua Opsi (Global)')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master /</span> Semua Opsi (Global, Multi-Parent)
  </h4>

  <div class="alert alert-info">
    <strong>ℹ️ Multi-parent:</strong> 1 opsi (mis. "Salah kirim") bisa attach ke banyak kategori sekaligus.
    Form di kanan support multi-select kategori. Bila opsi dengan deskripsi sama sudah ada, akan di-reuse.
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="row">
    {{-- LEFT: List opsi global --}}
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title m-0">
            Daftar Opsi Global ({{ $opsi->count() }} unik)
          </h5>
        </div>

        <div class="card-body border-bottom">
          <form method="GET" action="{{ route('master.opsi.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
              <label class="form-label">Filter kategori</label>
              <select name="kategori_id" class="form-select select2-filter">
                <option value="">— Semua kategori —</option>
                @foreach ($kategoriList as $k)
                  <option value="{{ $k->id }}" {{ $filterKategori == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }} ({{ $k->kode }})
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Cari deskripsi</label>
              <input type="text" name="q" class="form-control" value="{{ $filterQ }}" placeholder="kata kunci...">
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-outline-primary w-100">
                <i class="bx bx-search"></i> Filter
              </button>
            </div>
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th>Deskripsi</th>
                <th>Kategori (Parent) → Konteks</th>
                <th width="80">Status</th>
                <th width="80">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($opsi as $o)
                <tr>
                  <td><strong>{{ $o->deskripsi }}</strong></td>
                  <td>
                    @forelse ($o->kategoris as $k)
                      <div class="mb-1">
                        <a href="{{ route('master.kategori.opsi.index', $k->id) }}"
                           class="badge bg-label-primary text-decoration-none me-1"
                           title="Kode di kategori ini: {{ $k->pivot->kode }}">
                          {{ $k->nama }}
                          <small>({{ $k->pivot->kode }})</small>
                        </a>
                        @if ($k->konteksList->count() > 0)
                          <small class="ms-1 text-muted">
                            @foreach ($k->konteksList as $kn)
                              <span title="{{ $kn->nama }}">{{ $kn->kode }}</span>{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                          </small>
                        @endif
                      </div>
                    @empty
                      <span class="text-muted small">(orphan — tidak ke-attach kategori manapun)</span>
                    @endforelse
                  </td>
                  <td>
                    @if ($o->active)
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('master.opsi.edit', $o->id) }}" class="btn btn-sm btn-outline-primary" title="Edit deskripsi & kelola attach/detach kategori">
                      <i class="bx bx-edit"></i> Edit
                    </a>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-muted">Tidak ada opsi yang match filter.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- RIGHT: Form add opsi (multi-parent picker) --}}
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title m-0 text-white">+ Tambah Opsi ke Banyak Kategori</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('master.opsi.store') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">Kategori Parent <span class="text-danger">*</span> (multi)</label>
              <select name="kategori_ids[]" class="form-select select2-form" multiple required>
                @foreach ($kategoriList as $k)
                  <option value="{{ $k->id }}"
                          {{ collect(old('kategori_ids', $filterKategori ? [$filterKategori] : []))->contains($k->id) ? 'selected' : '' }}>
                    {{ $k->nama }} ({{ $k->kode }})
                  </option>
                @endforeach
              </select>
              <small class="text-muted">Pilih satu/banyak kategori yang akan mendapat opsi ini.</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
              <textarea name="deskripsi" class="form-control" rows="2" maxlength="500" required>{{ old('deskripsi') }}</textarea>
              <small class="text-muted">Bila sudah ada di sistem, akan di-reuse (tidak duplikat).</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Kode <span class="text-danger">*</span></label>
              <input type="text" name="kode" class="form-control" maxlength="10" value="{{ old('kode') }}" required>
              <small class="text-muted">Kode akan dipakai di SEMUA kategori yang dipilih. Bila kode sudah dipakai di salah satu kategori, attach ke kategori itu di-skip.</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Urutan</label>
              <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', 0) }}">
            </div>

            <div class="mb-3 form-check">
              <input type="hidden" name="active" value="0">
              <input type="checkbox" name="active" value="1" class="form-check-input" id="active-check" checked>
              <label class="form-check-label" for="active-check">Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">
              <i class="bx bx-save"></i> Simpan
            </button>
          </form>
        </div>
      </div>
      <div class="mt-2">
        <a href="{{ route('master.kategori.index') }}" class="btn btn-link btn-sm">
          ← Kembali ke daftar kategori
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof $.fn.select2 !== 'undefined') {
      $('.select2-filter').select2({ width: '100%' });
      $('.select2-form').select2({ width: '100%', placeholder: 'Pilih kategori (multi)' });
    }
  });
</script>
@endsection
