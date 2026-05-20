@extends('layouts/layoutMaster')

@section('title', 'Input PICA (v2 — Wizard)')

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

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">PICA /</span> Input Baru (Wizard)
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

  <form id="pica-wizard-form" method="POST" action="{{ route('pica-v2.store') }}">
    @csrf

    <div class="bs-stepper wizard-numbered">
      <div class="bs-stepper-header">
        <div class="step" data-target="#pica-step-konteks">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">1</span>
            <span class="bs-stepper-label">Konteks</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#pica-step-balink">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">2</span>
            <span class="bs-stepper-label">BA Link</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#pica-step-data">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">3</span>
            <span class="bs-stepper-label">Data Umum</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#pica-step-participants">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">4</span>
            <span class="bs-stepper-label">Participants</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#pica-step-questions">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">5</span>
            <span class="bs-stepper-label">Setup Q</span>
          </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#pica-step-review">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">6</span>
            <span class="bs-stepper-label">Review</span>
          </button>
        </div>
      </div>

      <div class="bs-stepper-content">

        {{-- ============ STEP 1: BU/KONTEKS ============ --}}
        <div id="pica-step-konteks" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Pilih Konteks PICA</h5>
            <small>Konteks PICA — boleh standalone atau tindak-lanjut BA.</small>
          </div>
          <div class="row g-3">
            @foreach ($konteksList as $k)
              <div class="col-md-4">
                <label class="card text-center p-4 h-100 konteks-card" style="cursor:pointer">
                  <input type="radio" name="konteks_kode" value="{{ $k->kode }}" class="d-none konteks-radio" required>
                  <h3 class="mb-1">{{ $k->kode }}</h3>
                  <h6 class="text-muted">{{ $k->nama }}</h6>
                  <small class="text-muted">{{ $k->deskripsi }}</small>
                </label>
              </div>
            @endforeach
          </div>
          <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary btn-next" disabled>Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 2: BA LINK ============ --}}
        <div id="pica-step-balink" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Link BA (opsional)</h5>
            <small>Pilih BA induk bila PICA ini tindak-lanjut dari BA. Kosongkan bila PICA standalone.</small>
          </div>
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label">BA Code</label>
              <select name="ba_link_code" id="ba-link-select" class="form-select" style="width:100%">
                <option value=""></option>
                @if (!empty($baCodePrefill))
                  <option value="{{ $baCodePrefill }}" selected>{{ $baCodePrefill }}</option>
                @endif
              </select>
              <small class="text-muted">Cari minimal 3 karakter (kode BA). Boleh dikosongkan.</small>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 3: DATA UMUM ============ --}}
        <div id="pica-step-data" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Data Umum</h5>
            <small>Pelaku, kapan terjadi, lokasi, deskripsi masalah, dan kategori PICA.</small>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Pelaku (subject) <span class="text-danger">*</span></label>
              <select name="pelaku_emp_code" id="pelaku-select" class="form-select" required style="width:100%"></select>
              <small class="text-muted">Cari minimal 2 karakter (nama atau kode karyawan).</small>
            </div>
            <div class="col-md-3">
              <label class="form-label">Tanggal PICA <span class="text-danger">*</span></label>
              <input type="date" name="tanggal" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Kapan terjadi</label>
              <input type="date" name="kapan_terjadi" class="form-control">
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
            <div class="col-md-3">
              <label class="form-label">Status kejadian</label>
              <select name="pernah_kejadian" class="form-select">
                <option value="">— Pilih —</option>
                <option value="pertama">Pertama kali</option>
                <option value="berulang">Berulang</option>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Problem note / Deskripsi singkat <span class="text-danger">*</span></label>
              <textarea name="problem_note" class="form-control" rows="3" maxlength="500" required
                placeholder="Deskripsi singkat masalah yang akan dianalisis..."></textarea>
              <small class="text-muted">Max 500 karakter. Detail akan didiskusikan lebih dalam di forum.</small>
            </div>

            <div class="col-12">
              <hr>
              <label class="form-label mb-2">Kategori PICA (multi-select)</label>
              <small class="text-muted d-block mb-2">Pilih satu atau lebih kategori yang relevan. Boleh kosong bila tidak ada kategori cocok.</small>

              @if ($kategoriList->isEmpty())
                <div class="alert alert-warning small mb-0">
                  Belum ada master kategori PICA. <a href="{{ route('master.pica.kategori.index') }}">Kelola di Admin Master &raquo;</a>
                </div>
              @else
                <div class="row g-2">
                  @foreach ($kategoriList as $kat)
                    <div class="col-md-4">
                      <label class="border rounded p-2 d-flex gap-2 h-100" style="cursor:pointer">
                        <input type="checkbox" name="kategori_ids[]" value="{{ $kat->id }}" class="form-check-input mt-1">
                        <span>
                          <strong>{{ $kat->nama }}</strong>
                          @if ($kat->deskripsi)
                            <br><small class="text-muted">{{ $kat->deskripsi }}</small>
                          @endif
                        </span>
                      </label>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 4: PARTICIPANTS ============ --}}
        <div id="pica-step-participants" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Participants</h5>
            <small>PIC otomatis = Anda (creator). Pilih anggota Dewan yang terlibat.</small>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">PIC (auto)</label>
              <input type="text" class="form-control"
                value="{{ auth()->user()->name ?? auth()->user()->username ?? '—' }} (Anda)"
                readonly>
              <small class="text-muted">PIC = creator wizard. Tidak bisa diubah.</small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Pelaku (auto dari step 3)</label>
              <input type="text" class="form-control" id="rv-pelaku-mini" value="—" readonly>
            </div>

            <div class="col-12">
              <label class="form-label">Anggota Dewan <span class="text-danger">*</span></label>
              <select name="dewan_user_ids[]" id="dewan-select" class="form-select" multiple required style="width:100%"></select>
              <small class="text-muted">Pilih minimal 1 user. Cari minimal 2 karakter (username atau nama).</small>
            </div>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 5: SETUP Q (PERTANYAAN) ============ --}}
        <div id="pica-step-questions" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Setup Pertanyaan &amp; Pernyataan</h5>
            <small>3 sumber: <b>Wajib Universal</b> (otomatis), <b>Bantuan</b> (pilih), <b>Bebas</b> (custom).</small>
          </div>

          {{-- A. Wajib Universal (locked, auto-include) --}}
          <h6 class="mt-2 mb-2">
            <span class="badge bg-label-danger me-1">WAJIB UNIVERSAL</span>
            <small class="text-muted">Auto-include di semua PICA — tidak bisa diubah.</small>
          </h6>
          <div class="border rounded p-2 mb-4" style="background:#fff7f7">
            @if ($wajibList->isEmpty())
              <div class="text-muted small">Tidak ada master pertanyaan wajib_universal aktif.</div>
            @else
              <ol class="mb-0 small">
                @foreach ($wajibList as $w)
                  <li>
                    <strong>[{{ strtoupper($w->tipe) }}]</strong>
                    {{ $w->pertanyaan }}
                  </li>
                @endforeach
              </ol>
            @endif
          </div>

          {{-- B. Bantuan (checklist) --}}
          <h6 class="mt-2 mb-2">
            <span class="badge bg-label-info me-1">BANTUAN</span>
            <small class="text-muted">Pilih pertanyaan tambahan dari library. Centang "wajib jawab" bila pelaku harus menjawabnya sebelum close.</small>
          </h6>

          @if ($bantuanList->isEmpty())
            <div class="alert alert-warning small">
              Belum ada master pertanyaan scope=bantuan. <a href="{{ route('master.pica.pertanyaan.index') }}">Kelola di Admin Master &raquo;</a>
            </div>
          @else
            <div class="table-responsive border rounded mb-4" style="max-height:480px; overflow:auto">
              <table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-light sticky-top">
                  <tr>
                    <th width="40">Pakai</th>
                    <th width="100">Tipe</th>
                    <th>Pertanyaan</th>
                    <th width="100">Wajib jawab</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($bantuanList as $b)
                    <tr>
                      <td>
                        <input type="checkbox" name="bantuan_ids[]" value="{{ $b->id }}"
                               class="form-check-input bantuan-pick"
                               data-id="{{ $b->id }}">
                      </td>
                      <td>
                        <span class="badge bg-label-{{ $b->tipe === 'pernyataan' ? 'warning' : 'primary' }}">
                          {{ $b->tipe }}
                        </span>
                      </td>
                      <td>{{ $b->pertanyaan }}</td>
                      <td>
                        <input type="checkbox" name="bantuan_wajib_ids[]" value="{{ $b->id }}"
                               class="form-check-input bantuan-wajib"
                               data-id="{{ $b->id }}"
                               disabled>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif

          {{-- C. Bebas (dynamic) --}}
          <h6 class="mt-2 mb-2">
            <span class="badge bg-label-secondary me-1">BEBAS</span>
            <small class="text-muted">Pertanyaan/pernyataan custom yang tidak ada di master. Bisa ditambah lagi nanti di forum diskusi.</small>
          </h6>

          <div id="bebas-list">
            <div class="bebas-item border rounded p-2 mb-2">
              <div class="row g-2">
                <div class="col-md-2">
                  <select name="bebas[0][tipe]" class="form-select form-select-sm">
                    <option value="pertanyaan">Pertanyaan</option>
                    <option value="pernyataan">Pernyataan</option>
                  </select>
                </div>
                <div class="col-md-8">
                  <input type="text" name="bebas[0][pertanyaan]" class="form-control form-control-sm"
                         maxlength="1000" placeholder="Tulis pertanyaan/pernyataan...">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                  <label class="form-check-label small" title="Wajib dijawab pelaku">
                    <input type="checkbox" name="bebas[0][wajib_jawab]" value="1" class="form-check-input">
                    Wajib
                  </label>
                </div>
                <div class="col-md-1 d-flex align-items-center">
                  <button type="button" class="btn btn-sm btn-outline-danger btn-remove-bebas" title="Hapus">
                    <i class="bx bx-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-bebas">
            <i class="bx bx-plus"></i> Tambah pertanyaan bebas
          </button>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="button" class="btn btn-primary btn-next">Lanjut <i class="bx bx-chevron-right"></i></button>
          </div>
        </div>

        {{-- ============ STEP 6: REVIEW ============ --}}
        <div id="pica-step-review" class="content">
          <div class="content-header mb-3">
            <h5 class="mb-0">Review &amp; Submit</h5>
            <small>Cek semua data sebelum submit. Klik step di header untuk kembali edit. Setelah submit, PICA masuk status <code>WAITING_PELAKU</code>.</small>
          </div>
          <div class="card">
            <div class="card-body">
              <dl class="row mb-0">
                <dt class="col-sm-3">Creator (PIC)</dt>
                <dd class="col-sm-9">
                  <strong>{{ auth()->user()->name ?? auth()->user()->username ?? '—' }}</strong>
                  <small class="text-muted">(otomatis = Anda)</small>
                </dd>
                <dt class="col-sm-3">Konteks</dt><dd class="col-sm-9" id="rv-konteks">—</dd>
                <dt class="col-sm-3">BA Link</dt><dd class="col-sm-9" id="rv-balink">—</dd>
                <dt class="col-sm-3">Pelaku</dt><dd class="col-sm-9" id="rv-pelaku">—</dd>
                <dt class="col-sm-3">Tanggal PICA</dt><dd class="col-sm-9" id="rv-tanggal">—</dd>
                <dt class="col-sm-3">Kapan terjadi</dt><dd class="col-sm-9" id="rv-kapan">—</dd>
                <dt class="col-sm-3">Lokasi / Cabang</dt><dd class="col-sm-9" id="rv-lokasi">—</dd>
                <dt class="col-sm-3">Status kejadian</dt><dd class="col-sm-9" id="rv-pernah">—</dd>
                <dt class="col-sm-3">Problem note</dt><dd class="col-sm-9" id="rv-problem">—</dd>
                <dt class="col-sm-3">Kategori PICA</dt><dd class="col-sm-9" id="rv-kategori">—</dd>
                <dt class="col-sm-3">Dewan</dt><dd class="col-sm-9" id="rv-dewan">—</dd>
                <dt class="col-sm-3">Pertanyaan</dt>
                <dd class="col-sm-9">
                  <span id="rv-q-summary">—</span>
                  <small class="text-muted d-block" id="rv-q-detail"></small>
                </dd>
              </dl>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-outline-secondary btn-prev"><i class="bx bx-chevron-left"></i> Kembali</button>
            <button type="submit" class="btn btn-success">
              <i class="bx bx-check-circle"></i> Submit PICA
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const stepper = new Stepper(document.querySelector('.bs-stepper'), { linear: false });
  const form = document.getElementById('pica-wizard-form');

  // ===== Select2 init =====
  if (typeof $.fn.select2 !== 'undefined') {
    $('.select2').select2({ width: '100%' });

    // Pelaku — reuse /api/employees/search (master_employees)
    $('#pelaku-select').select2({
      width: '100%',
      placeholder: 'Cari nama atau kode karyawan...',
      minimumInputLength: 2,
      ajax: {
        url: '/api/employees/search',
        dataType: 'json',
        delay: 300,
        data: params => ({ q: params.term }),
        processResults: data => data,
        cache: true,
      },
    });

    // BA Link — searchBa endpoint
    $('#ba-link-select').select2({
      width: '100%',
      placeholder: 'Cari kode BA (opsional)...',
      allowClear: true,
      minimumInputLength: 3,
      ajax: {
        url: '{{ route("pica-v2.search-ba") }}',
        dataType: 'json',
        delay: 300,
        data: params => ({ q: params.term }),
        processResults: data => data,
        cache: true,
      },
    });

    // Dewan — searchUsers endpoint
    $('#dewan-select').select2({
      width: '100%',
      placeholder: 'Cari username atau nama user...',
      minimumInputLength: 2,
      ajax: {
        url: '{{ route("pica-v2.search-users") }}',
        dataType: 'json',
        delay: 300,
        data: params => ({ q: params.term }),
        processResults: data => data,
        cache: true,
      },
    });
  }

  // ===== Konteks radio card =====
  document.querySelectorAll('.konteks-card').forEach(card => {
    card.addEventListener('click', function() {
      document.querySelectorAll('.konteks-card').forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');
      this.querySelector('.konteks-radio').checked = true;
      document.querySelector('#pica-step-konteks .btn-next').disabled = false;
    });
  });

  // ===== Bantuan: enable "wajib_jawab" checkbox only when "pakai" is checked =====
  document.querySelectorAll('.bantuan-pick').forEach(cb => {
    cb.addEventListener('change', function() {
      const id = this.dataset.id;
      const wajib = document.querySelector(`.bantuan-wajib[data-id="${id}"]`);
      if (wajib) {
        wajib.disabled = !this.checked;
        if (!this.checked) wajib.checked = false;
      }
    });
  });

  // ===== Bebas: dynamic add/remove =====
  let bebasIdx = 1;
  document.getElementById('btn-add-bebas').addEventListener('click', function() {
    const row = document.createElement('div');
    row.className = 'bebas-item border rounded p-2 mb-2';
    row.innerHTML = `
      <div class="row g-2">
        <div class="col-md-2">
          <select name="bebas[${bebasIdx}][tipe]" class="form-select form-select-sm">
            <option value="pertanyaan">Pertanyaan</option>
            <option value="pernyataan">Pernyataan</option>
          </select>
        </div>
        <div class="col-md-8">
          <input type="text" name="bebas[${bebasIdx}][pertanyaan]" class="form-control form-control-sm"
                 maxlength="1000" placeholder="Tulis pertanyaan/pernyataan...">
        </div>
        <div class="col-md-1 d-flex align-items-center">
          <label class="form-check-label small" title="Wajib dijawab pelaku">
            <input type="checkbox" name="bebas[${bebasIdx}][wajib_jawab]" value="1" class="form-check-input">
            Wajib
          </label>
        </div>
        <div class="col-md-1 d-flex align-items-center">
          <button type="button" class="btn btn-sm btn-outline-danger btn-remove-bebas" title="Hapus">
            <i class="bx bx-trash"></i>
          </button>
        </div>
      </div>`;
    document.getElementById('bebas-list').appendChild(row);
    bebasIdx++;
  });
  document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove-bebas')) {
      const items = document.querySelectorAll('.bebas-item');
      if (items.length <= 1) {
        // Empty the only row instead of removing
        e.target.closest('.bebas-item').querySelector('input[type="text"]').value = '';
        return;
      }
      e.target.closest('.bebas-item').remove();
    }
  });

  // ===== Step navigation =====
  document.querySelectorAll('.btn-next').forEach(b => b.addEventListener('click', () => stepper.next()));
  document.querySelectorAll('.btn-prev').forEach(b => b.addEventListener('click', () => stepper.previous()));

  // ===== Mini pelaku display di step 4 =====
  $('#pelaku-select').on('change', function () {
    const sel = $(this).select2('data')[0];
    document.getElementById('rv-pelaku-mini').value = sel ? sel.text : '—';
  });

  // ===== Build review on step 6 =====
  document.querySelector('[data-target="#pica-step-review"] .step-trigger')?.addEventListener('click', buildReview);
  document.querySelectorAll('#pica-step-questions .btn-next').forEach(b => b.addEventListener('click', buildReview));

  function buildReview() {
    const f = form;
    const konteksRadio = f.querySelector('.konteks-radio:checked');
    document.getElementById('rv-konteks').textContent = konteksRadio ? konteksRadio.value : '—';

    const balink = $('#ba-link-select').select2('data')[0];
    document.getElementById('rv-balink').textContent = balink && balink.id ? balink.text : '— (standalone)';

    const pelaku = $('#pelaku-select').select2('data')[0];
    document.getElementById('rv-pelaku').textContent = pelaku ? pelaku.text : '—';

    document.getElementById('rv-tanggal').textContent = f.tanggal.value || '—';
    document.getElementById('rv-kapan').textContent   = f.kapan_terjadi.value || '—';

    const lokSel = f.lokasi_code.options[f.lokasi_code.selectedIndex]?.text;
    const compSel = f.company_code.options[f.company_code.selectedIndex]?.text;
    document.getElementById('rv-lokasi').textContent =
      [lokSel, compSel].filter(x => x && !x.includes('Pilih')).join(' · ') || '—';

    document.getElementById('rv-pernah').textContent =
      f.pernah_kejadian.value || '—';

    document.getElementById('rv-problem').textContent = f.problem_note.value || '—';

    const katChecks = Array.from(f.querySelectorAll('input[name="kategori_ids[]"]:checked'));
    document.getElementById('rv-kategori').textContent =
      katChecks.length === 0
        ? '— (tidak ada kategori)'
        : katChecks.map(c => c.closest('label').querySelector('strong').textContent).join(', ');

    const dewanData = $('#dewan-select').select2('data');
    document.getElementById('rv-dewan').textContent =
      dewanData.length === 0 ? '—' : dewanData.map(d => d.text).join(', ');

    // Pertanyaan summary
    const wajibUniv = {{ $wajibList->count() }};
    const bantuanPicked = f.querySelectorAll('input[name="bantuan_ids[]"]:checked').length;
    const bantuanWajib  = f.querySelectorAll('input[name="bantuan_wajib_ids[]"]:checked').length;
    const bebasFilled = Array.from(f.querySelectorAll('.bebas-item'))
      .filter(item => (item.querySelector('input[type="text"]').value || '').trim() !== '').length;
    const bebasWajib = Array.from(f.querySelectorAll('.bebas-item'))
      .filter(item => {
        const txt = (item.querySelector('input[type="text"]').value || '').trim();
        const wj  = item.querySelector('input[type="checkbox"][name*="wajib_jawab"]').checked;
        return txt !== '' && wj;
      }).length;
    const total = wajibUniv + bantuanPicked + bebasFilled;
    const wajibTotal = wajibUniv + bantuanWajib + bebasWajib;
    document.getElementById('rv-q-summary').textContent =
      `${total} item total · ${wajibTotal} wajib jawab`;
    document.getElementById('rv-q-detail').textContent =
      `Wajib universal ${wajibUniv} · Bantuan dipilih ${bantuanPicked} (${bantuanWajib} wajib) · Bebas ${bebasFilled} (${bebasWajib} wajib)`;
  }
});
</script>
@endsection
