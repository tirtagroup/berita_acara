@extends('layouts/layoutMaster')

@section('title', 'Edit BA — ' . $ba->Tr_BA_Main_Code)

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span>
      <span class="text-muted fw-light">Berita Acara / Edit /</span>
      <code class="fs-6">{{ $ba->Tr_BA_Main_Code }}</code>
      <span class="badge bg-label-primary ms-2">{{ $ba->Ms_BA_type_Code }}</span>
    </span>
    <a href="{{ route('berita-acara-v2.show', ['kode' => $ba->Tr_BA_Main_Code]) }}" class="btn btn-sm btn-outline-secondary">
      <i class="bx bx-arrow-back"></i> Kembali ke Detail
    </a>
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {!! session('success') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="alert alert-warning">
    <i class="bx bx-edit"></i>
    <strong>Mode Edit.</strong> Konteks ({{ $ba->Ms_BA_type_Code }}), kode BA, dan pelapor tidak boleh diubah. Setelah save, audit trail tetap tercatat di `updated_at`.
  </div>

  <form method="POST" action="{{ route('berita-acara-v2.update', ['kode' => $ba->Tr_BA_Main_Code]) }}">
    @csrf

    {{-- ============ DATA UMUM ============ --}}
    <div class="card mb-3">
      <div class="card-header"><h5 class="card-title m-0">Data Umum</h5></div>
      <div class="card-body row g-3">
        <div class="col-md-3">
          <label class="form-label">Tanggal BA <span class="text-danger">*</span></label>
          <input type="date" name="Date_BA" class="form-control"
            value="{{ \Carbon\Carbon::parse($ba->Date_BA)->format('Y-m-d') }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Lokasi</label>
          <select name="rec_areacode" class="form-select select2">
            <option value="">— Pilih lokasi —</option>
            @foreach ($lokasi as $l)
              <option value="{{ $l->lokasi_code }}" {{ $ba->rec_areacode === $l->lokasi_code ? 'selected' : '' }}>
                {{ $l->lokasi_desc }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-5">
          <label class="form-label">Cabang / Company</label>
          <select name="rec_comcode" class="form-select select2">
            <option value="">— Pilih cabang —</option>
            @foreach ($company as $c)
              <option value="{{ $c->company_code }}" {{ $ba->rec_comcode === $c->company_code ? 'selected' : '' }}>
                {{ $c->description }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Karyawan subject (kode) <span class="text-danger">*</span></label>
          <input type="text" name="Ms_Emp_Code" class="form-control" value="{{ $ba->Ms_Emp_Code }}" maxlength="50" required>
          <small class="text-muted">Kode karyawan pelaku. Hati-hati ubah ini.</small>
        </div>
        <div class="col-md-6">
          <label class="form-label">Divisi pelaku</label>
          <select name="Ms_Emp_Div" class="form-select select2">
            <option value="">— Pilih divisi —</option>
            @foreach ($divisi as $d)
              <option value="{{ $d->subbdiv_code }}" {{ $ba->Ms_Emp_Div === $d->subbdiv_code ? 'selected' : '' }}>
                {{ $d->subbdiv_desc }} ({{ $d->subbdiv_code }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
          <textarea name="BA_Desc" class="form-control" rows="3" maxlength="1000" required>{{ $ba->BA_Desc }}</textarea>
        </div>
      </div>
    </div>

    {{-- ============ KATEGORI ============ --}}
    <div class="card mb-3">
      <div class="card-header"><h5 class="card-title m-0">Kategori (multi-select)</h5></div>
      <div class="card-body">
        <div class="row g-2">
          @foreach ($kategoriList as $kat)
            <div class="col-md-3">
              <label class="border rounded p-2 d-flex gap-2 h-100" style="cursor:pointer">
                <input type="checkbox" name="kategori_ids[]" value="{{ $kat->id }}" class="form-check-input mt-1"
                  {{ in_array($kat->id, $kategoriAttached) ? 'checked' : '' }}>
                <span>
                  <strong>{{ $kat->nama }}</strong>
                  <br><small class="text-muted"><code>{{ $kat->kode }}</code></small>
                </span>
              </label>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- ============ KRONOLOGI ============ --}}
    <div class="card mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Kronologi</h5>
        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-kronologi">
          <i class="bx bx-plus"></i> Tambah baris
        </button>
      </div>
      <div class="card-body">
        <div id="kronologi-list">
          @forelse ($kronologi as $i => $k)
            <div class="kronologi-item mb-2 d-flex gap-2">
              <textarea name="kronologi[]" class="form-control" rows="2" placeholder="Detail kronologi...">{{ $k->detail }}</textarea>
              <button type="button" class="btn btn-sm btn-outline-danger btn-remove-kronologi" title="Hapus"><i class="bx bx-trash"></i></button>
            </div>
          @empty
            <div class="kronologi-item mb-2 d-flex gap-2">
              <textarea name="kronologi[]" class="form-control" rows="2" placeholder="Detail kronologi..."></textarea>
              <button type="button" class="btn btn-sm btn-outline-danger btn-remove-kronologi" title="Hapus"><i class="bx bx-trash"></i></button>
            </div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- ============ ACTION BAR ============ --}}
    <div class="d-flex justify-content-between mb-4">
      <a href="{{ route('berita-acara-v2.show', ['kode' => $ba->Tr_BA_Main_Code]) }}" class="btn btn-outline-secondary">
        <i class="bx bx-x"></i> Batal
      </a>
      <button class="btn btn-primary" type="submit">
        <i class="bx bx-save"></i> Simpan perubahan
      </button>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof $.fn.select2 !== 'undefined') {
    $('.select2').select2({ width: '100%' });
  }
  document.getElementById('btn-add-kronologi').addEventListener('click', function () {
    const row = document.createElement('div');
    row.className = 'kronologi-item mb-2 d-flex gap-2';
    row.innerHTML = `
      <textarea name="kronologi[]" class="form-control" rows="2" placeholder="Detail kronologi..."></textarea>
      <button type="button" class="btn btn-sm btn-outline-danger btn-remove-kronologi" title="Hapus"><i class="bx bx-trash"></i></button>`;
    document.getElementById('kronologi-list').appendChild(row);
  });
  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-remove-kronologi')) {
      const items = document.querySelectorAll('.kronologi-item');
      if (items.length <= 1) {
        e.target.closest('.kronologi-item').querySelector('textarea').value = '';
        return;
      }
      e.target.closest('.kronologi-item').remove();
    }
  });
});
</script>
@endsection
