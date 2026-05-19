@extends('layouts/layoutMaster')

@section('title', $mode === 'create' ? 'Tambah Kategori PICA' : 'Edit Kategori PICA')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / PICA / <a href="{{ route('master.pica.kategori.index') }}">Kategori</a> /</span>
    {{ $mode === 'create' ? 'Tambah' : 'Edit' }}
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form method="POST"
            action="{{ $mode === 'create'
                       ? route('master.pica.kategori.store')
                       : route('master.pica.kategori.update', $kategori->id) }}">
        @csrf
        @if ($mode === 'edit') @method('PUT') @endif

        <div class="mb-3">
          <label class="form-label">Kode <span class="text-danger">*</span></label>
          <input type="text" name="kode" class="form-control"
                 value="{{ old('kode', $kategori->kode ?? '') }}"
                 maxlength="50" placeholder="HURUF_BESAR_UNDERSCORE"
                 {{ $mode === 'edit' ? 'readonly' : '' }}
                 required>
          <small class="text-muted">Hanya huruf besar, angka, underscore.</small>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control"
                 value="{{ old('nama', $kategori->nama ?? '') }}" maxlength="100" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="2" maxlength="255">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
        </div>

        <div class="mb-3 form-check">
          <input type="hidden" name="active" value="0">
          <input type="checkbox" name="active" value="1" class="form-check-input" id="active"
                 {{ old('active', $kategori->active ?? true) ? 'checked' : '' }}>
          <label class="form-check-label" for="active">Aktif</label>
        </div>

        <button type="submit" class="btn btn-primary">
          <i class="bx bx-save"></i> {{ $mode === 'create' ? 'Simpan' : 'Update' }}
        </button>
        <a href="{{ route('master.pica.kategori.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
