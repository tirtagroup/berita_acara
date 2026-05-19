@extends('layouts/layoutMaster')

@section('title', $mode === 'create' ? 'Tambah Pertanyaan PICA' : 'Edit Pertanyaan PICA')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / PICA / <a href="{{ route('master.pica.pertanyaan.index') }}">Pertanyaan</a> /</span>
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
                       ? route('master.pica.pertanyaan.store')
                       : route('master.pica.pertanyaan.update', $item->id) }}">
        @csrf
        @if ($mode === 'edit') @method('PUT') @endif

        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Kode <span class="text-danger">*</span></label>
            <input type="text" name="kode" class="form-control"
                   value="{{ old('kode', $item->kode ?? '') }}"
                   maxlength="50" placeholder="WHY_PERTAMA, AKAR_MASALAH, ..."
                   {{ $mode === 'edit' ? 'readonly' : '' }} required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tipe <span class="text-danger">*</span></label>
            <select name="tipe" class="form-select" required>
              <option value="pertanyaan" {{ old('tipe', $item->tipe ?? 'pertanyaan') === 'pertanyaan' ? 'selected' : '' }}>
                Pertanyaan (jawaban text)
              </option>
              <option value="pernyataan" {{ old('tipe', $item->tipe ?? '') === 'pernyataan' ? 'selected' : '' }}>
                Pernyataan (ack: Setuju/Tidak Setuju)
              </option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Scope <span class="text-danger">*</span></label>
            <select name="scope" class="form-select" required>
              <option value="bantuan" {{ old('scope', $item->scope ?? 'bantuan') === 'bantuan' ? 'selected' : '' }}>
                Bantuan (PIC pilih saat setup)
              </option>
              <option value="wajib_universal" {{ old('scope', $item->scope ?? '') === 'wajib_universal' ? 'selected' : '' }}>
                Wajib Universal (auto di semua PICA)
              </option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label">Pertanyaan / Pernyataan <span class="text-danger">*</span></label>
            <textarea name="pertanyaan" class="form-control" rows="3" required>{{ old('pertanyaan', $item->pertanyaan ?? '') }}</textarea>
            <small class="text-muted">Untuk tipe "Pernyataan", isi sebagai pernyataan deklaratif (mis. "Pelaku telah membaca SOP terbaru").</small>
          </div>

          <div class="col-md-3">
            <label class="form-label">Urutan</label>
            <input type="number" name="urutan" class="form-control" min="0"
                   value="{{ old('urutan', $item->urutan ?? 0) }}">
          </div>

          <div class="col-md-3 d-flex align-items-end">
            <div class="form-check">
              <input type="hidden" name="active" value="0">
              <input type="checkbox" name="active" value="1" class="form-check-input" id="active"
                     {{ old('active', $item->active ?? true) ? 'checked' : '' }}>
              <label class="form-check-label" for="active">Aktif</label>
            </div>
          </div>
        </div>

        <hr>
        <button type="submit" class="btn btn-primary">
          <i class="bx bx-save"></i> {{ $mode === 'create' ? 'Simpan' : 'Update' }}
        </button>
        <a href="{{ route('master.pica.pertanyaan.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
