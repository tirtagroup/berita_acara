@extends('layouts/layoutMaster')

@section('title', 'Edit Opsi: ' . $opsi->deskripsi)

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / <a href="{{ route('master.opsi.index') }}">Opsi</a> /</span>
    Edit: {{ $opsi->deskripsi }}
  </h4>

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

  {{-- SECTION 1: Edit deskripsi global --}}
  <div class="card mb-4">
    <div class="card-header bg-light">
      <h5 class="card-title m-0">1. Deskripsi Opsi (Global)</h5>
      <small class="text-muted">Perubahan akan apply ke semua kategori yang attach ke opsi ini.</small>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('master.opsi.update', $opsi->id) }}">
        @csrf
        @method('PUT')
        <div class="row g-2 align-items-end">
          <div class="col-md-8">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="2" maxlength="500" required>{{ old('deskripsi', $opsi->deskripsi) }}</textarea>
          </div>
          <div class="col-md-2">
            <div class="form-check">
              <input type="hidden" name="active" value="0">
              <input type="checkbox" name="active" value="1" class="form-check-input" id="active-check" {{ $opsi->active ? 'checked' : '' }}>
              <label class="form-check-label" for="active-check">Aktif (global)</label>
            </div>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Update Global</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- SECTION 2: Kategori yang attached --}}
  @php $totalKat = $opsi->kategoris->count(); @endphp
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0">2. Kategori yang Attach ke Opsi Ini ({{ $totalKat }})</h5>
      @if ($totalKat <= 1)
        <small class="text-warning">
          <i class="bx bx-info-circle"></i> Min 1 kategori — detach di-disable bila hanya 1 tersisa
        </small>
      @endif
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Kategori</th>
            <th width="120">Kode (di kategori)</th>
            <th width="100">Urutan</th>
            <th width="100">Aktif</th>
            <th width="180">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($opsi->kategoris as $k)
            <tr>
              <form method="POST"
                    action="{{ route('master.opsi.mapping.update', [$opsi->id, $k->id]) }}">
                @csrf
                @method('PUT')
                <td>
                  <strong>{{ $k->nama }}</strong><br>
                  <code class="small">{{ $k->kode }}</code>
                </td>
                <td>
                  <input type="text" name="kode" value="{{ $k->pivot->kode }}" class="form-control form-control-sm" maxlength="10" required>
                </td>
                <td>
                  <input type="number" name="sort_order" value="{{ $k->pivot->sort_order }}" class="form-control form-control-sm" min="0">
                </td>
                <td class="text-center">
                  <input type="hidden" name="active" value="0">
                  <input type="checkbox" name="active" value="1" class="form-check-input" {{ $k->pivot->active ? 'checked' : '' }}>
                </td>
                <td>
                  <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="bx bx-save"></i> Update
                  </button>
              </form>
              <form method="POST"
                    action="{{ route('master.opsi.detach', [$opsi->id, $k->id]) }}"
                    class="d-inline"
                    onsubmit="return confirm('Detach opsi ini dari kategori {{ $k->nama }}?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-sm btn-outline-danger"
                        @if ($totalKat <= 1) disabled title="Tidak bisa detach: minimum 1 kategori harus tersisa" @endif>
                  <i class="bx bx-x-circle"></i> Detach
                </button>
              </form>
                </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">
                Opsi ini belum attach ke kategori manapun (orphan). Attach di section di bawah.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- SECTION 3: Konteks langsung di opsi (untuk filter wizard) --}}
  <div class="card mb-4">
    <div class="card-header bg-light">
      <h5 class="card-title m-0">3. Konteks Tag</h5>
      <small class="text-muted">Tag Konteks langsung untuk opsi ini. Wizard menampilkan opsi hanya bila Konteks user match tag di sini.</small>
    </div>
    <div class="card-body">
      @if ($opsi->konteksList->count() === 0)
        <p class="text-muted small">Belum tag Konteks. Opsi ini tidak akan muncul di wizard.</p>
      @else
        <div class="d-flex flex-wrap gap-2 mb-3">
          @foreach ($opsi->konteksList as $k)
            <span class="badge bg-label-primary p-2">
              <strong>{{ $k->kode }}</strong> &mdash; {{ $k->nama }}
              <form action="{{ route('master.opsi.konteks.detach', [$opsi->id, $k->id]) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-link p-0 ms-2"
                        onclick="return confirm('Detach Konteks {{ $k->kode }} dari opsi ini?');"
                        title="Detach">
                  <i class="bx bx-x"></i>
                </button>
              </form>
            </span>
          @endforeach
        </div>
      @endif

      @if ($availableKonteks->count() > 0)
        <form action="{{ route('master.opsi.konteks.attach', $opsi->id) }}" method="POST" class="row g-2 align-items-end">
          @csrf
          <div class="col-md-9">
            <label class="form-label">Tambah Konteks (multi)</label>
            <select name="konteks_ids[]" class="form-select select2-konteks" multiple required>
              @foreach ($availableKonteks as $k)
                <option value="{{ $k->id }}">{{ $k->kode }} &mdash; {{ $k->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">
              <i class="bx bx-link"></i> Attach Konteks
            </button>
          </div>
        </form>
      @else
        <small class="text-muted">Opsi ini sudah tag semua Konteks yang ada.</small>
      @endif
    </div>
  </div>

  @if ($availableKat->count() > 0)
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="card-title m-0 text-white">4. Attach ke Kategori Baru</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('master.opsi.attach', $opsi->id) }}" class="row g-2 align-items-end">
          @csrf
          <div class="col-md-6">
            <label class="form-label">Kategori target</label>
            <select name="kategori_id" class="form-select select2-attach" required>
              <option value="">— Pilih kategori —</option>
              @foreach ($availableKat as $k)
                <option value="{{ $k->id }}">{{ $k->nama }} ({{ $k->kode }})</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" maxlength="10" required>
          </div>
          <div class="col-md-2">
            <label class="form-label">Urutan</label>
            <input type="number" name="sort_order" class="form-control" min="0" value="0">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
              <i class="bx bx-link"></i> Attach
            </button>
          </div>
        </form>
      </div>
    </div>
  @else
    <div class="alert alert-secondary">
      Opsi ini sudah attach ke <strong>semua</strong> kategori yang tersedia. Tidak ada kategori untuk di-attach lagi.
    </div>
  @endif

  <div class="mt-3">
    <a href="{{ route('master.opsi.index') }}" class="btn btn-link">← Kembali ke list opsi global</a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof $.fn.select2 !== 'undefined') {
      $('.select2-attach').select2({ width: '100%' });
      $('.select2-konteks').select2({ width: '100%', placeholder: 'Pilih Konteks (multi)' });
    }
  });
</script>
@endsection
