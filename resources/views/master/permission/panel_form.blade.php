@extends('layouts/layoutMaster')

@section('title', ($mode === 'create' ? 'Tambah' : 'Edit') . ' Panel')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / Permission / Panel /</span>
    {{ $mode === 'create' ? 'Tambah' : 'Edit ' . $item->kode }}
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="POST" action="{{ $mode === 'create'
        ? route('master.panel.store')
        : route('master.panel.update', $item->id) }}">
    @csrf
    @if ($mode === 'edit') @method('PUT') @endif

    <div class="card">
      <div class="card-body row g-3">
        <div class="col-md-4">
          <label class="form-label">Kode <span class="text-danger">*</span></label>
          <input type="text" name="kode" class="form-control" maxlength="50" required
                 value="{{ old('kode', $item->kode ?? '') }}"
                 placeholder="BA_LIST, MASTER_KONTEKS, dll">
          <small class="text-muted">UNIQUE. Huruf besar + underscore.</small>
        </div>
        <div class="col-md-5">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control" maxlength="100" required
                 value="{{ old('nama', $item->nama ?? '') }}">
        </div>
        <div class="col-md-3">
          <label class="form-label">Modul <span class="text-danger">*</span></label>
          <select name="modul" class="form-select" required>
            @foreach (['BA','PICA','MASTER','HELP','UMUM'] as $m)
              <option value="{{ $m }}" {{ old('modul', $item->modul ?? '') === $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">URL</label>
          <input type="text" name="url" class="form-control" maxlength="255"
                 value="{{ old('url', $item->url ?? '') }}"
                 placeholder="/beritaacara/v2/list">
        </div>
        <div class="col-md-3">
          <label class="form-label">Icon (boxicons)</label>
          <input type="text" name="icon" class="form-control" maxlength="50"
                 value="{{ old('icon', $item->icon ?? '') }}"
                 placeholder="bx-list-ul">
        </div>
        <div class="col-md-3">
          <label class="form-label">Urutan</label>
          <input type="number" name="urutan" class="form-control" min="0"
                 value="{{ old('urutan', $item->urutan ?? 10) }}">
        </div>

        <div class="col-md-3">
          <label class="form-label">Scopable</label>
          <div class="form-check form-switch mt-2">
            <input type="hidden" name="scopable" value="0">
            <input type="checkbox" name="scopable" value="1" class="form-check-input"
              {{ old('scopable', $item->scopable ?? false) ? 'checked' : '' }}>
            <label class="form-check-label small">Row-level scope</label>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Supported Scopes</label>
          <input type="text" name="supported_scopes" class="form-control"
                 value="{{ old('supported_scopes', is_array($item->supported_scopes ?? null) ? implode(', ', $item->supported_scopes) : '') }}"
                 placeholder="all, own, participant, division">
          <small class="text-muted">Comma-separated. Untuk BA: <code>all, own, division</code>. Untuk PICA: <code>all, own, participant</code>. Master non-scopable: kosongkan.</small>
        </div>
        <div class="col-md-3">
          <label class="form-label">Active</label>
          <div class="form-check form-switch mt-2">
            <input type="hidden" name="active" value="0">
            <input type="checkbox" name="active" value="1" class="form-check-input"
              {{ old('active', $item->active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Aktif</label>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-3 d-flex justify-content-between">
      <a href="{{ route('master.panel.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-x"></i> Batal
      </a>
      <button class="btn btn-primary" type="submit">
        <i class="bx bx-save"></i> {{ $mode === 'create' ? 'Buat' : 'Update' }}
      </button>
    </div>
  </form>
</div>
@endsection
