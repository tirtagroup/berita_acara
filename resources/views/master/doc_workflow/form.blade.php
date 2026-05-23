@extends('layouts/layoutMaster')

@section('title', ($mode === 'create' ? 'Tambah' : 'Edit') . ' Dokumentasi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / Doc Workflow /</span>
    {{ $mode === 'create' ? 'Tambah Dokumentasi' : 'Edit: ' . $doc->judul }}
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="POST" action="{{ $mode === 'create'
        ? route('master.doc-workflow.store')
        : route('master.doc-workflow.update', $doc->id) }}">
    @csrf
    @if ($mode === 'edit') @method('PUT') @endif

    <div class="card mb-3">
      <div class="card-header"><h5 class="card-title m-0">Data Dokumentasi</h5></div>
      <div class="card-body row g-3">
        <div class="col-md-4">
          <label class="form-label">Kode (slug) <span class="text-danger">*</span></label>
          <input type="text" name="kode" class="form-control" maxlength="50" required
                 pattern="[a-z0-9_-]+"
                 value="{{ old('kode', $doc->kode ?? '') }}"
                 placeholder="ba-create, pica-meeting, ...">
          <small class="text-muted">Huruf kecil, angka, dash, underscore. URL: <code>/help/&lt;kode&gt;</code></small>
        </div>
        <div class="col-md-3">
          <label class="form-label">Modul <span class="text-danger">*</span></label>
          <select name="modul" class="form-select" required>
            @foreach (['BA','PICA','MASTER','UMUM'] as $m)
              <option value="{{ $m }}" {{ old('modul', $doc->modul ?? '') === $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Kategori <span class="text-danger">*</span></label>
          <select name="kategori" class="form-select" required>
            @foreach (['tutorial','faq','workflow','troubleshooting'] as $k)
              <option value="{{ $k }}" {{ old('kategori', $doc->kategori ?? '') === $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Urutan</label>
          <input type="number" name="urutan" class="form-control" min="0"
                 value="{{ old('urutan', $doc->urutan ?? 10) }}">
        </div>

        <div class="col-12">
          <label class="form-label">Judul <span class="text-danger">*</span></label>
          <input type="text" name="judul" class="form-control" maxlength="200" required
                 value="{{ old('judul', $doc->judul ?? '') }}">
        </div>

        <div class="col-12">
          <label class="form-label">Ringkasan (1-2 kalimat preview)</label>
          <textarea name="ringkasan" class="form-control" rows="2" maxlength="500"
                    placeholder="Tampil di card list di /help">{{ old('ringkasan', $doc->ringkasan ?? '') }}</textarea>
        </div>

        <div class="col-md-4">
          <label class="form-label">Target Role</label>
          <select name="target_role" class="form-select">
            @foreach (['all','admin','creator','pic','dewan','pelaku'] as $r)
              <option value="{{ $r }}" {{ old('target_role', $doc->target_role ?? 'all') === $r ? 'selected' : '' }}>{{ $r }}</option>
            @endforeach
          </select>
          <small class="text-muted">Untuk display label saja, tidak strict permission.</small>
        </div>
        <div class="col-md-4">
          <label class="form-label">Icon (boxicons class)</label>
          <input type="text" name="icon" class="form-control" maxlength="50"
                 value="{{ old('icon', $doc->icon ?? '') }}"
                 placeholder="bx-edit, bx-book-open, dll">
          <small class="text-muted">Lihat: <a href="https://boxicons.com/" target="_blank">boxicons.com</a></small>
        </div>
        <div class="col-md-4">
          <label class="form-label">Active</label>
          <div class="form-check form-switch mt-2">
            <input type="hidden" name="active" value="0">
            <input type="checkbox" name="active" value="1" class="form-check-input"
              {{ old('active', $doc->active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Aktif (muncul di /help)</label>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Konten (Markdown)</h5>
        <small class="text-muted">
          Support: # ## ### headings, **bold**, *italic*, `code`, ```fenced```, - list, 1. list, [link](url)
        </small>
      </div>
      <div class="card-body">
        <textarea name="konten" class="form-control" rows="25" required
                  style="font-family: ui-monospace,Menlo,monospace; font-size:.9em"
                  placeholder="# Heading utama&#10;&#10;Paragraph teks...&#10;&#10;## Sub heading&#10;&#10;- bullet item&#10;- another item">{{ old('konten', $doc->konten ?? '') }}</textarea>
      </div>
    </div>

    <div class="d-flex justify-content-between mb-4">
      <a href="{{ route('master.doc-workflow.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-x"></i> Batal
      </a>
      <div>
        @if ($mode === 'edit')
          <a href="{{ route('help.show', $doc->kode) }}" target="_blank" class="btn btn-outline-info me-2">
            <i class="bx bx-show"></i> Preview
          </a>
        @endif
        <button class="btn btn-primary" type="submit">
          <i class="bx bx-save"></i> {{ $mode === 'create' ? 'Buat' : 'Update' }}
        </button>
      </div>
    </div>
  </form>
</div>
@endsection
