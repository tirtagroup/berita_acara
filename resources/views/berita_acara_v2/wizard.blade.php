@extends('layouts/layoutMaster')

@section('title', 'Input Berita Acara (v2 — Wizard)')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span><span class="text-muted fw-light">Berita Acara /</span> Input Baru (Wizard)</span>
    @include('components._help_button', ['slug' => 'ba-create'])
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {!! session('success') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Ada error saat submit:</strong>
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form id="wizard-form" method="POST" action="{{ route('berita-acara-v2.store') }}">
    @csrf

    <div class="bs-stepper wizard-numbered">
      <div class="bs-stepper-header">
        <div class="step" data-target="#step-konteks">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">1</span>
            <span class="bs-stepper-label">Konteks</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#step-data">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">2</span>
            <span class="bs-stepper-label">Data Umum</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#step-kategori">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">3</span>
            <span class="bs-stepper-label">Kategori Umum</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#step-fnb">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">4</span>
            <span class="bs-stepper-label">FnB</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#step-kronologi">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">5</span>
            <span class="bs-stepper-label">LAKA</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#step-revisi">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">6</span>
            <span class="bs-stepper-label">Salah Admin / Revisi</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#step-review">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">7</span>
            <span class="bs-stepper-label">Review</span>
          </button>
        </div>
      </div>

      <div class="bs-stepper-content">

        {{-- ============ STEP 1: Konteks============ --}}
        <div id="step-konteks" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Pilih Konteks</h5>
            <small>Konteks menentukan kategori mana yang tersedia di step 3.</small>
          </div>
          <div class="row g-3">
            @foreach ($konteksList as $bu)
              <div class="col-md-4">
                <label class="card text-center p-4 h-100 konteks-card" style="cursor:pointer">
                  <input type="radio" name="konteks_kode" value="{{ $bu->kode }}" class="d-none konteks-radio" required>
                  <h3 class="mb-1">{{ $bu->kode }}</h3>
                  <h6 class="text-muted">{{ $bu->nama }}</h6>
                  <small class="text-muted">{{ $bu->deskripsi }}</small>
                </label>
              </div>
            @endforeach
          </div>
          <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary btn-next" disabled>Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 2: DATA UMUM ============ --}}
        <div id="step-data" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Data Umum</h5>
          </div>
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label">Tanggal kejadian <span class="text-danger">*</span></label>
              <input type="date" name="tanggal" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Lokasi</label>
              <select name="lokasi_code" class="form-select select2">
                <option value="">— Pilih lokasi —</option>
                @foreach ($lokasi as $l)
                  <option value="{{ $l->lokasi_code }}">{{ $l->lokasi_desc }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-5">
              <label class="form-label">Cabang / Company</label>
              <select name="company_code" class="form-select select2">
                <option value="">— Pilih cabang —</option>
                @foreach ($company as $c)
                  <option value="{{ $c->company_code }}">{{ $c->description }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Karyawan subject <span class="text-danger">*</span></label>
              <select name="emp_code" id="emp-select" class="form-select" required style="width:100%"></select>
              <small class="text-muted">Cari minimal 2 karakter (nama atau kode karyawan).</small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Divisi</label>
              <select name="emp_div" id="emp-div-select" class="form-select select2">
                <option value="">— Pilih divisi (auto-fill saat karyawan dipilih) —</option>
                @foreach ($divisi as $d)
                  <option value="{{ $d->subbdiv_code }}">{{ $d->subbdiv_desc }} ({{ $d->subbdiv_code }})</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Ms Kasus (legacy)</label>
              <select name="ms_kasus" id="ms-kasus-select" class="form-select" style="width:100%"></select>
              <small class="text-muted">Cari minimal 2 huruf (kode atau deskripsi). Opsional — untuk kompat data legacy.</small>
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi singkat <span class="text-danger">*</span></label>
              <textarea name="deskripsi" class="form-control" rows="3" maxlength="500" required></textarea>
            </div>
            
            <div class="col-12">
              <label class="form-label">Temuan / Issues (Opsional)</label>
              <textarea name="ba_temuan" class="form-control" rows="3" maxlength="2000" placeholder="Apa yang ditemukan dari investigasi..."></textarea>
              <small class="text-muted">Detail temuan/masalah yang ditemukan. Opsional.</small>
            </div>

            <div class="col-12">
              <label class="form-label">Rekomendasi / Action Items (Opsional)</label>
              <textarea name="ba_rekomendasi" class="form-control" rows="3" maxlength="2000" placeholder="Apa yang perlu dilakukan..."></textarea>
              <small class="text-muted">Rekomendasi atau tindakan lanjutan yang disarankan. Opsional.</small>
            </div>

            {{-- Kronologi (pindah dari step LAKA — wajib untuk semua BA) --}}
            <div class="col-12">
              <hr>
              <label class="form-label">Kronologi kejadian <span class="text-danger">*</span></label>
              <small class="text-muted d-block mb-2">Detail kronologi (urutan kejadian). Bisa tambah lebih dari 1 baris untuk multi-step.</small>
              <div id="kronologi-list">
                <div class="kronologi-item mb-2">
                  <textarea name="kronologi[]" class="form-control" rows="3" placeholder="Detail kronologi kejadian..." required></textarea>
                </div>
              </div>
              <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-kronologi">
                <i class="bx bx-plus"></i> Tambah baris kronologi
              </button>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 3: KATEGORI UMUM ============ --}}
        <div id="step-kategori" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Kategori Umum (multi-select)</h5>
            <small>Pilih kategori yang relevan dengan kasus. Semua opsional — manager pilih sesuai kebutuhan.</small>
          </div>

          <div id="kategori-umum-container">
            <div id="kategori-empty" class="text-center text-muted py-4">Pilih Konteksdulu di step 1.</div>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 4: FnB ============ --}}
        <div id="step-fnb" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Kategori FnB</h5>
            <small>Kategori khusus FnB. Step ini skip otomatis bila Konteksbukan FnB.</small>
          </div>
          <div id="kategori-fnb-container">
            <div class="text-muted small">Tidak ada kategori FnB untuk Konteksyang dipilih.</div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 5: LAKA (kategori only) ============ --}}
        <div id="step-kronologi" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Kategori LAKA</h5>
            <small>Kategori khusus LAKA. Step ini skip otomatis bila Konteksbukan LAKA.</small>
          </div>

          <div id="kategori-laka-container">
            <div class="text-muted small">Tidak ada kategori LAKA untuk Konteksyang dipilih.</div>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 6: SALAH ADMIN / REVISI ============ --}}
        <div id="step-revisi" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Salah Admin / Permintaan Revisi</h5>
            <small>Detail revisi data/dokumen. Step ini skip otomatis bila Konteksbukan REVISI.</small>
          </div>

          <h6 class="mb-2">Kategori</h6>
          <div id="kategori-revisi-container" class="mb-4">
            <div class="text-muted small">Tidak ada kategori untuk Konteksyang dipilih.</div>
          </div>

          <hr>
          <h6 class="mb-2">Referensi Dokumen</h6>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Code Transaction / Dokumen <span class="text-danger">*</span></label>
              <input type="text" name="code_dokumen" class="form-control" placeholder="mis. INV-2026-001, BA-XXX, dll." maxlength="100">
              <small class="text-muted">Kode/nomor dokumen atau transaksi yang akan direvisi.</small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Alasan Revisi</label>
              <textarea name="alasan_revisi" class="form-control" rows="2" maxlength="1000" placeholder="Mengapa perlu revisi..."></textarea>
            </div>
          </div>

          <hr>
          <h6 class="mb-2">Detail Field yang Direvisi</h6>
          <small class="text-muted d-block mb-2">Isi minimal 1 baris field salah → field benar. Klik "+ Tambah baris" untuk lebih dari 1.</small>
          <div class="table-responsive">
            <table class="table table-sm align-middle" id="revisi-detail-table">
              <thead class="table-light">
                <tr>
                  <th>Field Salah</th>
                  <th>Value Salah</th>
                  <th>Field Benar</th>
                  <th>Value Benar</th>
                  <th width="50"></th>
                </tr>
              </thead>
              <tbody id="revisi-detail-rows">
                <tr class="revisi-detail-row">
                  <td><input type="text" name="revisi_detail[0][field_salah]" class="form-control form-control-sm" maxlength="50" placeholder="nama_field"></td>
                  <td><input type="text" name="revisi_detail[0][value_salah]" class="form-control form-control-sm" maxlength="50" placeholder="value lama"></td>
                  <td><input type="text" name="revisi_detail[0][field_benar]" class="form-control form-control-sm" maxlength="50" placeholder="nama_field"></td>
                  <td><input type="text" name="revisi_detail[0][value_benar]" class="form-control form-control-sm" maxlength="50" placeholder="value baru"></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-revisi-detail">
            <i class="bx bx-plus"></i> Tambah baris detail
          </button>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 7: REVIEW ============ --}}
        <div id="step-review" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Review &amp; Submit</h5>
            <small>Cek semua data sebelum submit. Klik step di header untuk kembali edit.</small>
          </div>
          <div class="card">
            <div class="card-body">
              <dl class="row mb-0">
                <dt class="col-sm-3">Pelapor</dt>
                <dd class="col-sm-9">
                  <strong>{{ auth()->user()->name ?? auth()->user()->username ?? '—' }}</strong>
                  @if (auth()->user()?->ms_company || auth()->user()?->ms_divisi)
                    <small class="text-muted">
                      ({{ auth()->user()->ms_company ?? '' }}{{ auth()->user()->ms_divisi ? ' · ' . auth()->user()->ms_divisi : '' }})
                    </small>
                  @endif
                </dd>
                <dt class="col-sm-3">Konteks</dt><dd class="col-sm-9" id="rv-konteks">—</dd>
                <dt class="col-sm-3">Tanggal</dt><dd class="col-sm-9" id="rv-tanggal">—</dd>
                <dt class="col-sm-3">Lokasi</dt><dd class="col-sm-9" id="rv-lokasi">—</dd>
                <dt class="col-sm-3">Cabang</dt><dd class="col-sm-9" id="rv-company">—</dd>
                <dt class="col-sm-3">Subject (Emp)</dt><dd class="col-sm-9" id="rv-emp">—</dd>
                <dt class="col-sm-3">Divisi</dt><dd class="col-sm-9" id="rv-div">—</dd>
                <dt class="col-sm-3">Deskripsi</dt><dd class="col-sm-9" id="rv-deskripsi">—</dd>
                <dt class="col-sm-3">Temuan</dt><dd class="col-sm-9"><pre id="rv-temuan" style="white-space: pre-wrap;">—</pre></dd>
                <dt class="col-sm-3">Rekomendasi</dt><dd class="col-sm-9"><pre id="rv-rekomendasi" style="white-space: pre-wrap;">—</pre></dd>
                <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9" id="rv-kategori">—</dd>
                <dt class="col-sm-3">Kronologi</dt><dd class="col-sm-9"><pre id="rv-kronologi" style="white-space: pre-wrap;">—</pre></dd>
              </dl>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="submit" class="btn btn-success">
              <i class="bx bx-check-circle"></i> Submit BA
            </button>
          </div>
        </div>

      </div>
    </div>
  </form>
</div>

<style>
  .konteks-card { transition: all .15s; border: 2px solid transparent; }
  .konteks-card:hover { background: #f5f5f5; }
  .konteks-card.selected { border-color: #696cff; background: #eef0ff; }
  .kategori-block { border: 1px solid #ddd; border-radius: 6px; padding: 12px; margin-bottom: 10px; border-left: 4px solid #adb5bd; }
  .kategori-block.selected { border-left-color: #696cff; background: #f5f6ff; }
  .step.step-skipped { opacity: 0.4; }
  .step.step-skipped .bs-stepper-label::after {
    content: " (skip)";
    font-size: .75em;
    color: #888;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const stepper = new Stepper(document.querySelector('.bs-stepper'), { linear: false });
  const form = document.getElementById('wizard-form');

  // Init Select2
  if (typeof $.fn.select2 !== 'undefined') {
    $('.select2').select2({ width: '100%' });

    // Karyawan picker — AJAX search ke master_employees
    $('#emp-select').select2({
      width: '100%',
      placeholder: 'Cari nama atau kode karyawan...',
      minimumInputLength: 2,
      ajax: {
        url: '/api/employees/search',
        dataType: 'json',
        delay: 300,
        data: function (params) {
          return { q: params.term };
        },
        processResults: function (data) {
          return data;
        },
        cache: true,
      },
    });

    // Auto-fill divisi saat karyawan dipilih
    $('#emp-select').on('select2:select', function (e) {
      const divisiCode = e.params.data.divisi;
      if (divisiCode) {
        $('#emp-div-select').val(divisiCode).trigger('change');
      }
    });

    // Ms Kasus picker — AJAX search
    $('#ms-kasus-select').select2({
      width: '100%',
      placeholder: 'Cari kode atau deskripsi kasus...',
      allowClear: true,
      minimumInputLength: 2,
      ajax: {
        url: '/api/kasus/search',
        dataType: 'json',
        delay: 300,
        data: function (params) { return { q: params.term }; },
        processResults: function (data) { return data; },
        cache: true,
      },
    });
  }

  // ===== Konteksradio card =====
  document.querySelectorAll('.konteks-card').forEach(card => {
    card.addEventListener('click', function() {
      document.querySelectorAll('.konteks-card').forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');
      this.querySelector('.konteks-radio').checked = true;
      // enable Next button on step 1
      document.querySelector('#step-konteks .btn-next').disabled = false;
      // reload kategori for selected Konteks
      loadKategoriForKonteks(this.querySelector('.konteks-radio').value);
    });
  });

  // ===== Load kategori based on Konteks=====
  function loadKategoriForKonteks(konteksKode) {
    const umumCont   = document.getElementById('kategori-umum-container');
    const fnbCont    = document.getElementById('kategori-fnb-container');
    const lakaCont   = document.getElementById('kategori-laka-container');
    const revisiCont = document.getElementById('kategori-revisi-container');
    umumCont.innerHTML   = '<div id="kategori-empty" class="text-center text-muted py-4">Loading...</div>';
    fnbCont.innerHTML    = '';
    lakaCont.innerHTML   = '';
    revisiCont.innerHTML = '';

    fetch(`/api/konteks/${encodeURIComponent(konteksKode)}/kategori`)
      .then(r => r.json())
      .then(data => {
        const rows = data.kategori || [];

        // Route kategori berdasarkan Konteksyang dipilih:
        //   - Step 4 (FnB)    hanya bila Konteks= FNB
        //   - Step 5 (LAKA)   hanya bila Konteks= LAKA
        //   - Step 6 (REVISI) hanya bila Konteks= REVISI
        //   - Kategori domain ≠ Kontekscurrent → fallback ke step 3 (Umum)
        const buckets = { FNB: [], UMUM: [], LAKA: [], REVISI: [] };
        rows.forEach((k, idx) => {
          let bucket = 'UMUM';
          if (k.domain === 'FNB'    && konteksKode === 'FNB')    bucket = 'FNB';
          else if (k.domain === 'LAKA'   && konteksKode === 'LAKA')   bucket = 'LAKA';
          else if (k.domain === 'REVISI' && konteksKode === 'REVISI') bucket = 'REVISI';
          else bucket = 'UMUM';
          buckets[bucket].push({ ...k, _idx: idx });
        });

        // Render UMUM ke step 3 — flat list
        umumCont.innerHTML = '';
        if (buckets.UMUM.length === 0) {
          umumCont.innerHTML = '<div class="text-muted py-3">Tidak ada kategori Umum untuk Konteksini.</div>';
        } else {
          buckets.UMUM.forEach(k => renderKategoriBlock(umumCont, k, k._idx));
        }

        // Render FNB ke step 4
        if (buckets.FNB.length === 0) {
          fnbCont.innerHTML = '<div class="text-muted small py-3">Tidak ada kategori FnB untuk Konteksini.</div>';
        } else {
          buckets.FNB.forEach(k => renderKategoriBlock(fnbCont, k, k._idx));
        }

        // Render LAKA ke step 5
        if (buckets.LAKA.length === 0) {
          lakaCont.innerHTML = '<div class="text-muted small py-3">Tidak ada kategori LAKA untuk Konteksini.</div>';
        } else {
          buckets.LAKA.forEach(k => renderKategoriBlock(lakaCont, k, k._idx));
        }

        // Render REVISI ke step 6
        if (buckets.REVISI.length === 0) {
          revisiCont.innerHTML = '<div class="text-muted small py-3">Tidak ada kategori Revisi untuk Konteksini.</div>';
        } else {
          buckets.REVISI.forEach(k => renderKategoriBlock(revisiCont, k, k._idx));
        }

        refreshSkipIndicators();
      });
  }

  // ===== Render 1 kategori block ke container =====
  // Post-ADR-008: semua kategori opsional. Tidak ada auto-check / locked / badge level.
  function renderKategoriBlock(container, k, idx) {
    const block = document.createElement('div');
    block.className = 'kategori-block';
    block.dataset.kategoriId = k.id;
    block.dataset.kategoriKode = k.kode;
    block.dataset.kategoriNama = k.nama;
    block.innerHTML = `
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-check-label mb-0">
          <input type="checkbox" class="form-check-input kategori-check"
                 data-id="${k.id}" data-nama="${k.nama}">
          <strong>${k.nama}</strong> <code class="small">${k.kode}</code>
        </label>
      </div>
      <div class="opsi-container mt-2">
        <small class="text-muted">Loading opsi...</small>
      </div>
      <input type="hidden" name="kategori[${idx}][id]" value="" class="kategori-hidden-id">
    `;
    container.appendChild(block);

    // Load opsi untuk semua kategori (tampil ready meskipun belum dicentang).
    loadOpsiForKategori(block, k.id, idx);

    const cb = block.querySelector('.kategori-check');
    const hiddenId = block.querySelector('.kategori-hidden-id');

    cb.addEventListener('change', function() {
      // Toggle hidden id; opsi tetap visible tapi tidak ikut submit kalau kategori unchecked
      hiddenId.value = this.checked ? k.id : '';
      block.classList.toggle('selected', this.checked);
    });

    // Bila user klik opsi tanpa kategori dichek, auto-check kategori (UX shortcut)
    block.addEventListener('change', function(e) {
      if (e.target.classList.contains('opsi-check') && e.target.checked && !cb.checked) {
        cb.checked = true;
        hiddenId.value = k.id;
        block.classList.add('selected');
      }
    });
  }

  function loadOpsiForKategori(block, kategoriId, idx) {
    const cont = block.querySelector('.opsi-container');
    const konteksKode = document.querySelector('.konteks-radio:checked')?.value || '';
    const url = `/api/kategori/${kategoriId}/opsi` + (konteksKode ? `?bu=${encodeURIComponent(konteksKode)}` : '');
    fetch(url)
      .then(r => r.json())
      .then(opsi => {
        if (!opsi || opsi.length === 0) {
          cont.innerHTML = '<small class="text-muted">Belum ada opsi untuk kategori ini.</small>';
          return;
        }
        // Render button group (multi-toggle). Tiap button = 1 checkbox tersembunyi.
        cont.innerHTML = `
          <label class="form-label small mb-1">Pilih opsi (boleh lebih dari 1):</label>
          <div class="d-flex flex-wrap gap-1 opsi-btn-group" data-idx="${idx}">
            ${opsi.map(o => `
              <input type="checkbox" class="btn-check opsi-check"
                     name="kategori[${idx}][opsi][]"
                     value="${o.opsi_id}"
                     id="opsi-${idx}-${o.opsi_id}"
                     autocomplete="off">
              <label class="btn btn-sm btn-outline-primary opsi-label"
                     for="opsi-${idx}-${o.opsi_id}"
                     title="${o.deskripsi}">
                <code class="me-1">${o.kode}</code>${o.deskripsi}
              </label>
            `).join('')}
          </div>
        `;
      });
  }

  // ===== Bersihkan kategori kosong sebelum submit =====
  form.addEventListener('submit', function(e) {
    document.querySelectorAll('.kategori-block').forEach(block => {
      const hiddenId = block.querySelector('.kategori-hidden-id');
      if (!hiddenId.value) {
        // Disable hidden id agar tidak ikut tersubmit
        hiddenId.disabled = true;
        // Disable juga semua opsi checkbox di block ini
        block.querySelectorAll('.opsi-check').forEach(c => c.disabled = true);
      }
    });
  });

  // ===== Helper: cek apakah container punya kategori block =====
  function containerHasKategori(selector) {
    const cont = document.querySelector(selector);
    return cont && cont.querySelector('.kategori-block') !== null;
  }
  function hasFnbAvailable()    { return containerHasKategori('#kategori-fnb-container'); }
  function hasLakaAvailable()   { return containerHasKategori('#kategori-laka-container'); }
  function hasRevisiAvailable() { return containerHasKategori('#kategori-revisi-container'); }

  function isLakaPenyebabChecked() {
    return Array.from(document.querySelectorAll('#kategori-laka-container .kategori-check:checked'))
                .some(cb => /LAKA_PENYEBAB/i.test(cb.closest('.kategori-block').dataset.kategoriKode));
  }

  // ===== Update visual indicator step yang di-skip =====
  function refreshSkipIndicators() {
    const stepFnb    = document.querySelector('.step[data-target="#step-fnb"]');
    const stepKrono  = document.querySelector('.step[data-target="#step-kronologi"]');
    const stepRevisi = document.querySelector('.step[data-target="#step-revisi"]');
    if (stepFnb)    stepFnb.classList.toggle('step-skipped',    !hasFnbAvailable());
    if (stepKrono)  stepKrono.classList.toggle('step-skipped',  !hasLakaAvailable());
    if (stepRevisi) stepRevisi.classList.toggle('step-skipped', !hasRevisiAvailable());
  }
  // Keep backward-compat alias (dipakai di old code)
  function refreshKronologiSkipIndicator() { refreshSkipIndicators(); }

  // ===== Step order & navigation helper =====
  // Step numbers (1-indexed sesuai bs-stepper.to()):
  //   1 = Konteks, 2 = Data, 3 = Kategori Umum, 4 = FnB, 5 = LAKA & Kronologi, 6 = Review
  const STEP_ID_TO_NUM = {
    'step-konteks':         1,
    'step-data':       2,
    'step-kategori':   3,
    'step-fnb':        4,
    'step-kronologi':  5,
    'step-revisi':     6,
    'step-review':     7,
  };
  const REVIEW_STEP = 7;

  function getNextActiveStep(current) {
    let n = current + 1;
    while (n <= REVIEW_STEP) {
      if (n === 4 && !hasFnbAvailable())    { n++; continue; }
      if (n === 5 && !hasLakaAvailable())   { n++; continue; }
      if (n === 6 && !hasRevisiAvailable()) { n++; continue; }
      return n;
    }
    return REVIEW_STEP;
  }
  function getPrevActiveStep(current) {
    let n = current - 1;
    while (n >= 1) {
      if (n === 4 && !hasFnbAvailable())    { n--; continue; }
      if (n === 5 && !hasLakaAvailable())   { n--; continue; }
      if (n === 6 && !hasRevisiAvailable()) { n--; continue; }
      return n;
    }
    return 1;
  }

  document.querySelectorAll('.btn-next').forEach(btn => {
    btn.addEventListener('click', () => {
      if (!validateCurrentStep()) return;
      const activeId = document.querySelector('.bs-stepper-content .content.active').id;
      const curNum = STEP_ID_TO_NUM[activeId];
      const nextNum = getNextActiveStep(curNum);
      stepper.to(nextNum);
      if (nextNum === REVIEW_STEP) renderReview();
    });
  });
  document.querySelectorAll('.btn-prev').forEach(btn => {
    btn.addEventListener('click', () => {
      const activeId = document.querySelector('.bs-stepper-content .content.active').id;
      const curNum = STEP_ID_TO_NUM[activeId];
      const prevNum = getPrevActiveStep(curNum);
      stepper.to(prevNum);
    });
  });

  // Update indicator setiap perubahan kategori checkbox
  document.addEventListener('change', function(e) {
    if (e.target.classList.contains('kategori-check')) {
      refreshSkipIndicators();
    }
  });

  // Initial state: step FnB & LAKA dimmed sampai Konteksdipilih & kategori ter-load
  refreshSkipIndicators();

  function validateCurrentStep() {
    const active = document.querySelector('.bs-stepper-content .content.active');
    if (!active) return true;
    if (active.id === 'step-konteks') {
      if (!document.querySelector('.konteks-radio:checked')) {
        alert('Pilih Konteks dulu.');
        return false;
      }
    }
    if (active.id === 'step-data') {
      const required = ['tanggal', 'emp_code', 'deskripsi'];
      for (const name of required) {
        const el = document.querySelector(`[name="${name}"]`);
        if (!el || !el.value.trim()) {
          alert(`Field "${name}" wajib diisi.`);
          el?.focus();
          return false;
        }
      }
      // Kronologi minimal 1 baris ber-isi
      const krono = document.querySelectorAll('[name="kronologi[]"]');
      const hasContent = Array.from(krono).some(t => t.value.trim().length > 0);
      if (!hasContent) {
        alert('Kronologi kejadian wajib diisi minimal 1 baris.');
        krono[0]?.focus();
        return false;
      }
    }
    if (active.id === 'step-kategori') {
      const checked = document.querySelectorAll('.kategori-check:checked');
      if (checked.length === 0) {
        alert('Pilih minimal 1 kategori.');
        return false;
      }
    }
    return true;
  }

  // ===== Revisi detail: tambah baris =====
  let revisiRowIdx = 1;
  document.getElementById('btn-add-revisi-detail')?.addEventListener('click', function() {
    const tbody = document.getElementById('revisi-detail-rows');
    const tr = document.createElement('tr');
    tr.className = 'revisi-detail-row';
    tr.innerHTML = `
      <td><input type="text" name="revisi_detail[${revisiRowIdx}][field_salah]" class="form-control form-control-sm" maxlength="50" placeholder="nama_field"></td>
      <td><input type="text" name="revisi_detail[${revisiRowIdx}][value_salah]" class="form-control form-control-sm" maxlength="50" placeholder="value lama"></td>
      <td><input type="text" name="revisi_detail[${revisiRowIdx}][field_benar]" class="form-control form-control-sm" maxlength="50" placeholder="nama_field"></td>
      <td><input type="text" name="revisi_detail[${revisiRowIdx}][value_benar]" class="form-control form-control-sm" maxlength="50" placeholder="value baru"></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger btn-remove-revisi-row"><i class="bx bx-x"></i></button></td>
    `;
    tbody.appendChild(tr);
    tr.querySelector('.btn-remove-revisi-row').addEventListener('click', () => tr.remove());
    revisiRowIdx++;
  });

  // ===== Kronologi: tambah baris =====
  document.getElementById('btn-add-kronologi').addEventListener('click', function() {
    const div = document.createElement('div');
    div.className = 'kronologi-item mb-2';
    div.innerHTML = '<textarea name="kronologi[]" class="form-control" rows="3" placeholder="Detail kronologi kejadian..."></textarea>';
    document.getElementById('kronologi-list').appendChild(div);
  });

  // ===== Render review step =====
  function renderReview() {
    document.getElementById('rv-konteks').textContent = document.querySelector('.konteks-radio:checked')?.value || '—';
    document.getElementById('rv-tanggal').textContent = document.querySelector('[name="tanggal"]').value;
    document.getElementById('rv-lokasi').textContent = $('[name="lokasi_code"]').find(':selected').text() || '—';
    document.getElementById('rv-company').textContent = $('[name="company_code"]').find(':selected').text() || '—';
    document.getElementById('rv-emp').textContent = document.querySelector('[name="emp_code"]').value;
    document.getElementById('rv-div').textContent = document.querySelector('[name="emp_div"]').value || '—';
    document.getElementById('rv-deskripsi').textContent = document.querySelector('[name="deskripsi"]').value;
    document.getElementById('rv-temuan').textContent = document.querySelector('[name="ba_temuan"]').value || '(tidak diisi)';
    document.getElementById('rv-rekomendasi').textContent = document.querySelector('[name="ba_rekomendasi"]').value || '(tidak diisi)';

    const katList = Array.from(document.querySelectorAll('.kategori-check:checked')).map(cb => {
      const block = cb.closest('.kategori-block');
      const opsiChecked = block.querySelectorAll('.opsi-check:checked');
      let opsiTeks;
      if (opsiChecked.length === 0) {
        opsiTeks = '<em class="text-muted">(tidak pilih opsi)</em>';
      } else {
        opsiTeks = Array.from(opsiChecked).map(o => {
          const lab = block.querySelector(`label[for="${o.id}"]`);
          return `<span class="badge bg-label-primary me-1">${lab ? lab.innerText.trim() : o.value}</span>`;
        }).join('');
      }
      return `<li><strong>${block.dataset.kategoriNama}</strong> → ${opsiTeks}</li>`;
    });
    document.getElementById('rv-kategori').innerHTML = katList.length ? `<ul class="mb-0">${katList.join('')}</ul>` : '—';

    const krono = Array.from(document.querySelectorAll('[name="kronologi[]"]'))
                      .map(t => t.value.trim()).filter(Boolean);
    document.getElementById('rv-kronologi').textContent = krono.length
      ? krono.map((k, i) => `${i + 1}. ${k}`).join('\n')
      : '(tidak diisi)';
  }
});
</script>
@endsection
