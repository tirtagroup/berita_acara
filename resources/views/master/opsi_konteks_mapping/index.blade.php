@extends('layouts/layoutMaster')

@section('title', 'Mapping Opsi × Konteks')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="text-muted fw-light">Master /</span> Mapping Opsi × Konteks</span>
    <div class="d-flex gap-2 flex-wrap">
      @include('components._help_button', ['slug' => 'master-mapping'])
      <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-add-opsi">
        <i class="bx bx-plus"></i> Opsi Baru
      </button>
      <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal-add-kategori">
        <i class="bx bx-plus"></i> Kategori Baru
      </button>
      <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-add-konteks">
        <i class="bx bx-plus"></i> Konteks Baru
      </button>
      <a href="{{ route('master.mapping.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bx bx-grid-alt"></i> Konteks × Kategori
      </a>
    </div>
  </h4>

  <div class="alert alert-info small">
    Tag opsi langsung ke konteks. Wizard menampilkan opsi hanya bila konteks user match tag di sini.
    Kolom <strong>Parent kategori</strong> bisa di-edit langsung (Select2 multi). Semua auto-save.
  </div>

  {{-- ============ FILTER BAR ============ --}}
  <div class="card mb-3">
    <div class="card-body py-2">
      <div class="row g-2 align-items-center">
        <div class="col-md-3">
          <label class="form-label small mb-1">Cari opsi</label>
          <input type="text" id="filter-search" class="form-control form-control-sm" placeholder="Ketik deskripsi opsi...">
        </div>
        <div class="col-md-3">
          <label class="form-label small mb-1">Filter kategori (multi)</label>
          <select id="filter-kategori" class="form-select form-select-sm" multiple>
            @foreach ($allKategori as $kat)
              <option value="{{ $kat->id }}">{{ $kat->kode }} — {{ $kat->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label small mb-1">Filter konteks (tagged)</label>
          <div>
            @foreach ($konteksList as $k)
              <button type="button" class="btn btn-sm btn-outline-primary me-1 mb-1 filter-konteks-btn"
                      data-konteks="{{ $k->id }}">
                {{ $k->kode }}
              </button>
            @endforeach
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label small mb-1">&nbsp;</label>
          <div class="form-check">
            <input type="checkbox" id="filter-orphan" class="form-check-input">
            <label class="form-check-label small" for="filter-orphan">Hanya tanpa kategori</label>
          </div>
        </div>
        <div class="col-12 mt-1">
          <button type="button" class="btn btn-link btn-sm p-0" id="btn-reset-filter">
            <i class="bx bx-reset"></i> Reset filter
          </button>
          <span class="text-muted small ms-3" id="visible-count">{{ $opsi->count() }} dari {{ $opsi->count() }} opsi</span>
        </div>
      </div>
    </div>
  </div>

  {{-- ============ MATRIX TABLE ============ --}}
  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-bordered table-sm align-middle mb-0" id="opsi-matrix">
        <thead class="table-light sticky-top" style="z-index:5">
          <tr>
            <th style="min-width:220px">Opsi (deskripsi)</th>
            <th style="min-width:280px">Parent kategori (edit langsung)</th>
            @foreach ($konteksList as $k)
              <th class="text-center" style="min-width:90px">
                {{ $k->kode }}<br>
                <small class="text-muted fw-normal">{{ $k->nama }}</small>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @forelse ($opsi as $o)
            @php
              $taggedKonteks = $mappings->get($o->id, []);
              $attachedKatIds = $o->kategoris->pluck('id')->all();
            @endphp
            <tr class="opsi-row"
                data-opsi-id="{{ $o->id }}"
                data-deskripsi="{{ strtolower($o->deskripsi) }}"
                data-kategori-ids="{{ implode(',', $attachedKatIds) }}"
                data-konteks-ids="{{ implode(',', $taggedKonteks) }}">
              <td><strong>{{ $o->deskripsi }}</strong></td>
              <td>
                <select class="form-select form-select-sm kategori-multi" multiple data-opsi-id="{{ $o->id }}"
                        style="width:100%">
                  @foreach ($allKategori as $kat)
                    <option value="{{ $kat->id }}" {{ in_array($kat->id, $attachedKatIds) ? 'selected' : '' }}>
                      {{ $kat->kode }} — {{ $kat->nama }}
                    </option>
                  @endforeach
                </select>
              </td>
              @foreach ($konteksList as $k)
                <td class="text-center">
                  <div class="form-check d-inline-block">
                    <input type="checkbox" class="form-check-input opsi-konteks-toggle"
                           data-opsi="{{ $o->id }}"
                           data-konteks="{{ $k->id }}"
                           {{ in_array($k->id, $taggedKonteks) ? 'checked' : '' }}>
                  </div>
                </td>
              @endforeach
            </tr>
          @empty
            <tr>
              <td colspan="{{ 2 + $konteksList->count() }}" class="text-center text-muted py-4">
                Belum ada opsi aktif. Buat dulu di <a href="{{ route('master.opsi.index') }}">Master Opsi Global</a>.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
      <span id="save-status" class="text-muted small">Perubahan disimpan otomatis.</span>
      <small class="text-muted">{{ $opsi->count() }} opsi × {{ $konteksList->count() }} konteks</small>
    </div>
  </div>
</div>

{{-- ============ MODAL: ADD OPSI ============ --}}
<div class="modal fade" id="modal-add-opsi" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-add-opsi">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Opsi Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info small">
            Setelah dibuat, opsi muncul di matrix. Anda bisa attach ke kategori + konteks lewat row baru.
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
            <textarea name="deskripsi" class="form-control" rows="2" maxlength="500" required
                      placeholder="mis. 'Lupa pakai helm', 'Alat rusak', 'Pelanggaran SOP'"></textarea>
            <small class="text-muted">UNIQUE — case-insensitive.</small>
          </div>
          <div id="opsi-modal-error" class="text-danger small"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan & Reload</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ============ MODAL: ADD KATEGORI ============ --}}
<div class="modal fade" id="modal-add-kategori" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-add-kategori">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kategori Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-2">
            <div class="col-md-5">
              <label class="form-label">Kode <span class="text-danger">*</span></label>
              <input type="text" name="kode" class="form-control" maxlength="50" required
                     pattern="[A-Z0-9_]+" placeholder="PELANGGARAN_SOP">
              <small class="text-muted">Huruf besar + underscore.</small>
            </div>
            <div class="col-md-7">
              <label class="form-label">Nama <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" maxlength="100" required
                     placeholder="Pelanggaran SOP">
            </div>
          </div>
          <div id="kategori-modal-error" class="text-danger small mt-2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan & Reload</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ============ MODAL: ADD KONTEKS ============ --}}
<div class="modal fade" id="modal-add-konteks" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-add-konteks">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Konteks Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning small">
            Konteks baru = kolom baru di matrix. Setelah save, page reload otomatis.
          </div>
          <div class="row g-2">
            <div class="col-md-4">
              <label class="form-label">Kode <span class="text-danger">*</span></label>
              <input type="text" name="kode" class="form-control" maxlength="50" required
                     placeholder="LAKA, FNB, OP_HR, REVISI">
            </div>
            <div class="col-md-8">
              <label class="form-label">Nama <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" maxlength="100" required>
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="2" maxlength="255"></textarea>
            </div>
          </div>
          <div id="konteks-modal-error" class="text-danger small mt-2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan & Reload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .opsi-row.hidden-filter { display: none; }
  .filter-konteks-btn.active { background: #696cff; color: white; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const csrf = '{{ csrf_token() }}';
  const urlToggle = '{{ route('master.opsi-mapping.update') }}';
  const urlSync   = '{{ route('master.opsi-mapping.sync-kategori') }}';
  const status    = document.getElementById('save-status');
  const visibleCt = document.getElementById('visible-count');
  const totalOpsi = {{ $opsi->count() }};

  // ===== Select2 init untuk semua kategori multi =====
  $('.kategori-multi').select2({
    width: '100%',
    placeholder: 'Pilih kategori (multi)...',
    closeOnSelect: false,
  });

  $('#filter-kategori').select2({
    width: '100%',
    placeholder: 'Semua kategori',
    allowClear: true,
  });

  // ===== AJAX: toggle checkbox konteks =====
  document.querySelectorAll('.opsi-konteks-toggle').forEach(cb => {
    cb.addEventListener('change', async (e) => {
      const opsiId    = e.target.dataset.opsi;
      const konteksId = e.target.dataset.konteks;
      const active    = e.target.checked ? 1 : 0;
      e.target.disabled = true;
      setStatus('Menyimpan...', 'info');
      try {
        const res = await fetch(urlToggle, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
          body: new URLSearchParams({ _token: csrf, opsi_id: opsiId, konteks_id: konteksId, active: active }),
        });
        const data = await res.json();
        if (!data.ok) throw new Error('Save gagal');
        setStatus(`Tersimpan (${data.action} opsi=${opsiId} konteks=${konteksId}).`, 'success');
        // Update data attribute for filter
        updateRowKonteksData(opsiId, konteksId, active === 1);
        applyFilter();
      } catch (err) {
        setStatus('ERROR: ' + err.message, 'danger');
        e.target.checked = !e.target.checked;
      } finally { e.target.disabled = false; }
    });
  });

  // ===== AJAX: sync kategori (Select2 change) =====
  $('.kategori-multi').on('change', async function () {
    const opsiId = $(this).data('opsi-id');
    const katIds = $(this).val() || [];
    setStatus('Menyimpan kategori...', 'info');
    try {
      const formData = new URLSearchParams();
      formData.append('_token', csrf);
      formData.append('opsi_id', opsiId);
      katIds.forEach(k => formData.append('kategori_ids[]', k));
      const res = await fetch(urlSync, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        body: formData,
      });
      const data = await res.json();
      if (!data.ok) throw new Error('Sync gagal');
      setStatus(`Kategori opsi=${opsiId} → ${data.count} kategori.`, 'success');
      // Update row data-kategori-ids for filter
      $(`.opsi-row[data-opsi-id="${opsiId}"]`).attr('data-kategori-ids', katIds.join(','));
      applyFilter();
    } catch (err) {
      setStatus('ERROR: ' + err.message, 'danger');
    }
  });

  // ===== FILTER LOGIC (client-side) =====
  const filterSearch  = document.getElementById('filter-search');
  const filterOrphan  = document.getElementById('filter-orphan');
  const $filterKat    = $('#filter-kategori');
  const konteksBtns   = document.querySelectorAll('.filter-konteks-btn');
  const activeKonteks = new Set();

  filterSearch.addEventListener('input', applyFilter);
  filterOrphan.addEventListener('change', applyFilter);
  $filterKat.on('change', applyFilter);
  konteksBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.konteks;
      if (activeKonteks.has(id)) {
        activeKonteks.delete(id);
        btn.classList.remove('active');
      } else {
        activeKonteks.add(id);
        btn.classList.add('active');
      }
      applyFilter();
    });
  });

  document.getElementById('btn-reset-filter').addEventListener('click', () => {
    filterSearch.value = '';
    filterOrphan.checked = false;
    $filterKat.val(null).trigger('change');
    activeKonteks.clear();
    konteksBtns.forEach(b => b.classList.remove('active'));
    applyFilter();
  });

  function applyFilter() {
    const search    = (filterSearch.value || '').toLowerCase().trim();
    const orphan    = filterOrphan.checked;
    const filterKat = ($filterKat.val() || []).map(String);

    let visible = 0;
    document.querySelectorAll('.opsi-row').forEach(row => {
      const desc  = row.dataset.deskripsi;
      const kats  = (row.dataset.kategoriIds || '').split(',').filter(Boolean);
      const ktxs  = (row.dataset.konteksIds  || '').split(',').filter(Boolean);

      let match = true;
      if (search && !desc.includes(search)) match = false;
      if (orphan && kats.length > 0) match = false;
      if (filterKat.length > 0 && !filterKat.some(k => kats.includes(k))) match = false;
      if (activeKonteks.size > 0 && ![...activeKonteks].every(k => ktxs.includes(k))) match = false;

      row.classList.toggle('hidden-filter', !match);
      if (match) visible++;
    });
    visibleCt.textContent = `${visible} dari ${totalOpsi} opsi`;
  }

  function updateRowKonteksData(opsiId, konteksId, isAttached) {
    const row = document.querySelector(`.opsi-row[data-opsi-id="${opsiId}"]`);
    if (!row) return;
    const ktxs = new Set((row.dataset.konteksIds || '').split(',').filter(Boolean));
    if (isAttached) ktxs.add(String(konteksId)); else ktxs.delete(String(konteksId));
    row.dataset.konteksIds = [...ktxs].join(',');
  }

  function setStatus(text, type) {
    status.textContent = text;
    status.className = 'small text-' + (type === 'info' ? 'info' : (type === 'danger' ? 'danger' : 'success'));
  }

  // ===== MODAL HANDLERS =====
  async function submitModalForm(formId, errorElId, url) {
    const form = document.getElementById(formId);
    const errEl = document.getElementById(errorElId);
    errEl.textContent = '';
    const data = new FormData(form);
    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
        body: data,
      });
      if (!res.ok) {
        const err = await res.json().catch(() => ({}));
        const msg = err.error || err.message || ('HTTP ' + res.status);
        if (err.errors) {
          errEl.textContent = Object.values(err.errors).flat().join(' · ');
        } else {
          errEl.textContent = msg;
        }
        return;
      }
      // Success → reload page
      window.location.reload();
    } catch (e) {
      errEl.textContent = 'Network error: ' + e.message;
    }
  }

  document.getElementById('form-add-opsi').addEventListener('submit', (e) => {
    e.preventDefault();
    submitModalForm('form-add-opsi', 'opsi-modal-error', '{{ route('master.opsi-mapping.quick-add-opsi') }}');
  });
  document.getElementById('form-add-kategori').addEventListener('submit', (e) => {
    e.preventDefault();
    submitModalForm('form-add-kategori', 'kategori-modal-error', '{{ route('master.kategori.store') }}');
  });
  document.getElementById('form-add-konteks').addEventListener('submit', (e) => {
    e.preventDefault();
    submitModalForm('form-add-konteks', 'konteks-modal-error', '{{ route('master.konteks.store') }}');
  });
});
</script>
@endsection
