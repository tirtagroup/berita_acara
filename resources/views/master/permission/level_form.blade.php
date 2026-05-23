@extends('layouts/layoutMaster')

@section('title', ($mode === 'create' ? 'Tambah' : 'Edit') . ' User Level')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / Permission / User Level /</span>
    {{ $mode === 'create' ? 'Tambah' : 'Edit ' . $item->kode }}
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="POST" action="{{ $mode === 'create'
        ? route('master.user-level.store')
        : route('master.user-level.update', $item->id) }}">
    @csrf
    @if ($mode === 'edit') @method('PUT') @endif

    <div class="card">
      <div class="card-body row g-3">
        <div class="col-md-4">
          <label class="form-label">Kode <span class="text-danger">*</span></label>
          <input type="text" name="kode" class="form-control" maxlength="50" required
                 value="{{ old('kode', $item->kode ?? '') }}"
                 placeholder="SUPER_ADMIN, ADMIN, KOORDINATOR, USER">
          <small class="text-muted">UNIQUE. Huruf besar + underscore.</small>
        </div>
        <div class="col-md-5">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control" maxlength="100" required
                 value="{{ old('nama', $item->nama ?? '') }}">
        </div>
        <div class="col-md-3">
          <label class="form-label">Urutan</label>
          <input type="number" name="urutan" class="form-control" min="0"
                 value="{{ old('urutan', $item->urutan ?? 10) }}">
        </div>

        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
        </div>

        <div class="col-md-6">
          <div class="form-check form-switch">
            <input type="hidden" name="is_super" value="0">
            <input type="checkbox" name="is_super" value="1" class="form-check-input"
              {{ old('is_super', $item->is_super ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">
              <strong>Is Super</strong>
              <small class="d-block text-muted">Bypass semua permission check (gunakan dengan hati-hati).</small>
            </label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-check form-switch">
            <input type="hidden" name="active" value="0">
            <input type="checkbox" name="active" value="1" class="form-check-input"
              {{ old('active', $item->active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-3 d-flex justify-content-between">
      <a href="{{ route('master.user-level.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-x"></i> Batal
      </a>
      <button class="btn btn-primary" type="submit">
        <i class="bx bx-save"></i> {{ $mode === 'create' ? 'Buat' : 'Update' }}
      </button>
    </div>
  </form>
</div>
@endsection
