@extends('layouts/layoutMaster')

@section('title', $mode === 'create' ? 'Tambah Konteks' : 'Edit Konteks')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / Konteks /</span>
    {{ $mode === 'create' ? 'Tambah' : 'Edit ' . $konteks->kode }}
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ $mode === 'create'
            ? route('master.konteks.store')
            : route('master.konteks.update', $konteks->id) }}">
        @csrf
        @if ($mode === 'edit') @method('PUT') @endif

        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Kode <span class="text-danger">*</span></label>
            <input type="text" name="kode" class="form-control" maxlength="50" required
                   value="{{ old('kode', $konteks->kode ?? '') }}"
                   placeholder="LAKA, FNB, OP_HR, REVISI, ...">
            <small class="text-muted">UNIQUE. Pakai huruf besar + underscore.</small>
          </div>
          <div class="col-md-5">
            <label class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control" maxlength="100" required
                   value="{{ old('nama', $konteks->nama ?? '') }}"
                   placeholder="mis. LAKA Truck, FnB, Operation/HR, Permintaan Revisi">
          </div>
          <div class="col-md-4">
            <label class="form-label">Active</label>
            <div class="form-check form-switch mt-2">
              <input type="hidden" name="active" value="0">
              <input type="checkbox" name="active" value="1" class="form-check-input"
                {{ old('active', $konteks->active ?? true) ? 'checked' : '' }}>
              <label class="form-check-label">Aktif (muncul di wizard)</label>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="2" maxlength="255"
                      placeholder="Kapan dipakai konteks ini...">{{ old('deskripsi', $konteks->deskripsi ?? '') }}</textarea>
          </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
          <a href="{{ route('master.konteks.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-x"></i> Batal
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> {{ $mode === 'create' ? 'Buat' : 'Update' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
