@extends('layouts/layoutMaster')

@section('title', $mode === 'create' ? 'Tambah Kategori' : 'Edit Kategori')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master / <a href="{{ route('master.kategori.index') }}">Kategori</a> /</span>
    {{ $mode === 'create' ? 'Tambah' : 'Edit' }}
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form method="POST"
            action="{{ $mode === 'create'
                       ? route('master.kategori.store')
                       : route('master.kategori.update', $kategori->id) }}">
        @csrf
        @if ($mode === 'edit') @method('PUT') @endif

        <div class="mb-3">
          <label class="form-label">Kode <span class="text-danger">*</span></label>
          <input type="text"
                 name="kode"
                 class="form-control"
                 value="{{ old('kode', $kategori->kode ?? '') }}"
                 placeholder="HURUF_BESAR_UNDERSCORE (mis. PELANGGARAN_SOP)"
                 maxlength="50"
                 {{ $mode === 'edit' ? 'readonly' : '' }}
                 required>
          <small class="text-muted">Kode tidak bisa diubah setelah dibuat. Hanya huruf besar, angka, dan underscore.</small>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text"
                 name="nama"
                 class="form-control"
                 value="{{ old('nama', $kategori->nama ?? '') }}"
                 maxlength="100"
                 required>
        </div>

        <div class="mb-3">
          <label class="form-label">Parent Kategori</label>
          <select name="parent_id" class="form-select select2">
            <option value="">— Tidak ada parent (top kategori) —</option>
            @foreach ($parentOptions as $p)
              <option value="{{ $p->id }}"
                      {{ old('parent_id', $kategori->parent_id ?? '') == $p->id ? 'selected' : '' }}>
                {{ $p->nama }} ({{ $p->kode }})
              </option>
            @endforeach
          </select>
          <small class="text-muted">Kategori parent untuk hierarki (opsional).</small>
        </div>

        <div class="mb-3 form-check">
          <input type="hidden" name="active" value="0">
          <input type="checkbox" name="active" value="1"
                 class="form-check-input"
                 id="active-check"
                 {{ old('active', $kategori->active ?? true) ? 'checked' : '' }}>
          <label class="form-check-label" for="active-check">Aktif</label>
        </div>

        <button type="submit" class="btn btn-primary">
          <i class="bx bx-save"></i>
          {{ $mode === 'create' ? 'Simpan' : 'Update' }}
        </button>
        <a href="{{ route('master.kategori.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>

  @if ($mode === 'edit')
    {{-- ============ Konteks Mapping (manage langsung) ============ --}}
    <div class="card mt-4">
      <div class="card-header bg-light">
        <h5 class="card-title m-0">Konteks Mapping</h5>
        <small class="text-muted">Atur Konteks mana yang relevan + level untuk kategori ini. <strong>Wajib</strong> = auto-check di wizard BA, <strong>Disarankan</strong> = highlighted, <strong>Opsional</strong> = tersedia.</small>
      </div>
      <div class="card-body">
        @if ($kategori->konteksList->count() === 0)
          <p class="text-muted small mb-3">Belum ada Konteks yang attach ke kategori ini.</p>
        @else
          <div class="row g-2 mb-3">
            @foreach ($kategori->konteksList as $k)
              <div class="col-md-4">
                <div class="card border">
                  <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <div>
                        <strong>{{ $k->kode }}</strong>
                        <br><small class="text-muted">{{ $k->nama }}</small>
                      </div>
                      <form action="{{ route('master.kategori.konteks.detach', [$kategori->id, $k->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Detach Konteks {{ $k->kode }} dari kategori ini?');"
                                title="Detach">
                          <i class="bx bx-x"></i>
                        </button>
                      </form>
                    </div>
                    <form action="{{ route('master.kategori.konteks.upsert', $kategori->id) }}" method="POST">
                      @csrf
                      <input type="hidden" name="konteks_id" value="{{ $k->id }}">
                      <div class="input-group input-group-sm">
                        <select name="level" class="form-select form-select-sm">
                          @foreach ($allLevels as $lv)
                            <option value="{{ $lv }}" {{ $k->pivot->level === $lv ? 'selected' : '' }}>{{ ucfirst($lv) }}</option>
                          @endforeach
                        </select>
                        <button type="submit" class="btn btn-outline-primary"><i class="bx bx-save"></i></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        @if ($availableKonteks->count() > 0)
          <hr>
          <h6 class="mb-2">Attach Konteks baru</h6>
          <form action="{{ route('master.kategori.konteks.upsert', $kategori->id) }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-5">
              <label class="form-label">Konteks</label>
              <select name="konteks_id" class="form-select" required>
                <option value="">— Pilih Konteks —</option>
                @foreach ($availableKonteks as $k)
                  <option value="{{ $k->id }}">{{ $k->kode }} — {{ $k->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Level</label>
              <select name="level" class="form-select" required>
                @foreach ($allLevels as $lv)
                  <option value="{{ $lv }}" {{ $lv === 'opsional' ? 'selected' : '' }}>{{ ucfirst($lv) }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bx bx-link"></i> Attach
              </button>
            </div>
          </form>
        @else
          <small class="text-muted">Semua Konteks sudah attach.</small>
        @endif
      </div>
    </div>
  @endif

</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof $.fn.select2 !== 'undefined') {
      $('.select2').select2();
    }
  });
</script>
@endsection
