@extends('layouts/layoutMaster')

@section('title', 'Opsi Kategori — ' . $kategori->nama)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / <a href="{{ route('master.kategori.index') }}">Kategori</a> /</span>
    Opsi: {{ $kategori->nama }}
  </h4>

  <div class="alert alert-info">
    <strong>ℹ️ Info:</strong> Opsi sekarang <strong>multi-parent</strong> — 1 opsi (mis. "Salah kirim") bisa attach ke beberapa kategori.
    Edit deskripsi opsi <strong>global</strong> di <a href="{{ route('master.opsi.index') }}">halaman semua opsi</a>.
    Halaman ini hanya edit <em>mapping</em> (kode, urutan, status) opsi di kategori ini.
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
    {{-- LEFT: List opsi di kategori ini --}}
    <div class="col-md-7">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title m-0">Daftar Opsi di kategori ini ({{ $kategori->opsi->count() }})</h5>
          <button type="button" class="btn btn-primary btn-sm" id="btn-scroll-form">
            <i class="bx bx-plus"></i> Tambah Opsi Baru
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th width="80">Kode</th>
                <th>Deskripsi</th>
                <th width="80">Order</th>
                <th width="80">Status</th>
                <th width="120">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($kategori->opsi as $o)
                <tr>
                  <td><code>{{ $o->pivot->kode }}</code></td>
                  <td>{{ $o->deskripsi }}</td>
                  <td>{{ $o->pivot->sort_order }}</td>
                  <td>
                    @if ($o->pivot->active)
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-primary"
                            onclick="editOpsi({{ $o->id }}, '{{ $o->pivot->kode }}', '{{ addslashes($o->deskripsi) }}', {{ $o->pivot->sort_order }}, {{ $o->pivot->active ? 1 : 0 }})">
                      <i class="bx bx-edit"></i>
                    </button>
                    <form action="{{ route('master.kategori.opsi.toggle', [$kategori->id, $o->id]) }}" method="POST" class="d-inline">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-sm btn-outline-warning"
                              onclick="return confirm('Toggle status opsi?');">
                        <i class="bx bx-power-off"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada opsi. Tambah di kanan →</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- RIGHT: Form add / edit mapping opsi --}}
    <div class="col-md-5">
      <div class="card" id="opsi-form-card">
        <div class="card-header">
          <h5 class="card-title m-0" id="opsi-form-title">Tambah Opsi ke Kategori Ini</h5>
        </div>
        <div class="card-body">
          <form method="POST" id="opsi-form"
                action="{{ route('master.kategori.opsi.store', $kategori->id) }}">
            @csrf
            <input type="hidden" name="_method" id="opsi-method" value="POST">

            <div class="mb-3">
              <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
              <textarea name="deskripsi" id="opsi-deskripsi" class="form-control" rows="3" maxlength="500" required></textarea>
              <small class="text-muted">Bila deskripsi sudah ada di sistem (case-insensitive), opsi yang sama akan di-reuse.</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Kode <span class="text-danger">*</span></label>
              <input type="text" name="kode" id="opsi-kode" class="form-control" maxlength="10" required>
              <small class="text-muted">Unik di dalam kategori ini.</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Urutan</label>
              <input type="number" name="sort_order" id="opsi-sort" class="form-control" min="0" value="0">
            </div>

            <div class="mb-3 form-check">
              <input type="hidden" name="active" value="0">
              <input type="checkbox" name="active" value="1" class="form-check-input" id="opsi-active" checked>
              <label class="form-check-label" for="opsi-active">Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" onclick="resetOpsiForm()">Reset</button>
          </form>
        </div>
      </div>
      <div class="mt-2">
        <a href="{{ route('master.kategori.index') }}" class="btn btn-link">← Kembali ke daftar kategori</a>
      </div>
    </div>
  </div>
</div>

<script>
  function editOpsi(id, kode, deskripsi, sort, active) {
    document.getElementById('opsi-form').action = '{{ route('master.kategori.opsi.index', $kategori->id) }}/' + id;
    document.getElementById('opsi-method').value = 'PUT';
    document.getElementById('opsi-form-title').innerText = 'Edit Mapping Opsi (id=' + id + ')';
    document.getElementById('opsi-kode').value = kode;
    document.getElementById('opsi-deskripsi').value = deskripsi;
    document.getElementById('opsi-sort').value = sort;
    document.getElementById('opsi-active').checked = active === 1;
    window.scrollTo({ top: document.getElementById('opsi-form-card').offsetTop, behavior: 'smooth' });
  }
  function resetOpsiForm() {
    document.getElementById('opsi-form').action = '{{ route('master.kategori.opsi.store', $kategori->id) }}';
    document.getElementById('opsi-method').value = 'POST';
    document.getElementById('opsi-form-title').innerText = 'Tambah Opsi ke Kategori Ini';
    document.getElementById('opsi-form').reset();
    document.getElementById('opsi-active').checked = true;
  }

  // Tombol "Tambah Opsi Baru" — scroll & focus form di kanan
  document.getElementById('btn-scroll-form')?.addEventListener('click', function() {
    resetOpsiForm();
    const card = document.getElementById('opsi-form-card');
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    card.classList.add('border-primary');
    setTimeout(() => card.classList.remove('border-primary'), 1500);
    setTimeout(() => document.getElementById('opsi-deskripsi').focus(), 400);
  });
</script>
@endsection
