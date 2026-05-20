@extends('layouts/layoutMaster')

@section('title', 'PICA Report — ' . $pica->Tr_Pica_Emp_h_Code)

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
@php
  $kode = $pica->Tr_Pica_Emp_h_Code;
  $isClosed = $pica->Status_PICA === 'CLOSED';
  $isReadOnly = $isClosed || $isPelaku; // Pelaku read-only
  $canEditG = $isPic && !$isReadOnly;   // Section G hanya PIC
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span>
      <span class="text-muted fw-light">PICA / Report /</span>
      {{ $kode }}
      <span class="badge bg-label-{{ $isClosed ? 'success' : 'primary' }} ms-2">{{ $pica->Status_PICA }}</span>
    </span>
    <a href="{{ route('pica-v2.discussion', ['kode' => $kode]) }}" class="btn btn-sm btn-outline-secondary">
      <i class="bx bx-chat"></i> Lihat Discussion
    </a>
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  @if ($isReadOnly && !$isClosed)
    <div class="alert alert-info">
      <i class="bx bx-info-circle"></i> Anda dalam mode read-only.
    </div>
  @endif

  {{-- ============ TAB NAV ============ --}}
  <ul class="nav nav-pills flex-wrap mb-3" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#sec-a">A. Identifikasi</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sec-b">B. 4M+1E</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sec-c">C. 5 Why</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sec-d">D. Corrective</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sec-e">E. Preventive</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sec-f">F. Verifikasi</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sec-g">G. Closure</a></li>
  </ul>

  <div class="tab-content">

    {{-- ============ SECTION A (5W+2H) + B (4M+1E) + F (Verifikasi) + G (Closure) ============ --}}
    <form method="POST" action="{{ route('pica-v2.report.save', ['kode' => $kode]) }}">
      @csrf

      {{-- SECTION A --}}
      <div class="tab-pane fade show active" id="sec-a">
        <div class="card mb-3">
          <div class="card-header">
            <strong>A. Identifikasi Masalah (5W + 2H)</strong>
            <small class="text-muted">Auto-populate dari jawaban final pelaku saat report pertama dibuat.</small>
          </div>
          <div class="card-body row g-3">
            @foreach ([
              'section_a_what'     => ['What (apa kejadian)?', 4],
              'section_a_when'     => ['When (kapan)?', 3],
              'section_a_where'    => ['Where (di mana)?', 3],
              'section_a_who'      => ['Who (siapa terlibat)?', 3],
              'section_a_why_awal' => ['Why awal (mengapa ini masalah & dampak)?', 4],
              'section_a_how'      => ['How (bagaimana kronologi)?', 4],
              'section_a_howmuch'  => ['How much (skala kerugian/dampak)?', 3],
            ] as $col => [$label, $rows])
              <div class="col-md-6">
                <label class="form-label">{{ $label }}</label>
                <textarea name="{{ $col }}" class="form-control" rows="{{ $rows }}"
                  {{ $isReadOnly ? 'readonly' : '' }}>{{ $report->$col }}</textarea>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- SECTION B --}}
      <div class="tab-pane fade" id="sec-b">
        <div class="card mb-3">
          <div class="card-header">
            <strong>B. Analisa Penyebab (4M + 1E)</strong>
            <small class="text-muted">Narasi per faktor: Man, Machine, Material, Method, Environment.</small>
          </div>
          <div class="card-body row g-3">
            @foreach ([
              'section_b_man'         => 'Man (manusia — kompetensi, fisik/mental, disiplin)',
              'section_b_machine'     => 'Machine (kendaraan / alat — kondisi, service, APD)',
              'section_b_material'    => 'Material (bahan / muatan — standar, packing, cacat)',
              'section_b_method'      => 'Method (SOP — tersedia, dipahami, diikuti)',
              'section_b_environment' => 'Environment (lingkungan — cuaca, lokasi, tekanan)',
            ] as $col => $label)
              <div class="col-md-6">
                <label class="form-label">{{ $label }}</label>
                <textarea name="{{ $col }}" class="form-control" rows="4"
                  {{ $isReadOnly ? 'readonly' : '' }}>{{ $report->$col }}</textarea>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- SECTION F --}}
      <div class="tab-pane fade" id="sec-f">
        <div class="card mb-3">
          <div class="card-header"><strong>F. Verifikasi & Monitoring</strong></div>
          <div class="card-body row g-3">
            <div class="col-md-6">
              <label class="form-label">KPI / Indikator keberhasilan</label>
              <textarea name="section_f_kpi" class="form-control" rows="3"
                {{ $isReadOnly ? 'readonly' : '' }}>{{ $report->section_f_kpi }}</textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jadwal review (mis. 1 minggu / 1 bulan / 3 bulan)</label>
              <input type="text" name="section_f_review_schedule" class="form-control" maxlength="255"
                value="{{ $report->section_f_review_schedule }}" {{ $isReadOnly ? 'readonly' : '' }}>
            </div>
            <div class="col-12">
              <label class="form-label">Audit / Verifikasi result</label>
              <textarea name="section_f_audit_result" class="form-control" rows="3"
                {{ $isReadOnly ? 'readonly' : '' }}>{{ $report->section_f_audit_result }}</textarea>
            </div>
          </div>
        </div>
      </div>

      {{-- SECTION G --}}
      <div class="tab-pane fade" id="sec-g">
        <div class="card mb-3">
          <div class="card-header">
            <strong>G. Closure & Lesson Learned</strong>
            <small class="text-muted">Hanya PIC yang boleh isi section G.</small>
          </div>
          <div class="card-body row g-3">
            <div class="col-md-6">
              <label class="form-label">Approver (User)</label>
              <select name="section_g_approver_id" id="approver-select" class="form-select"
                {{ !$canEditG ? 'disabled' : '' }} style="width:100%">
                <option value=""></option>
                @if ($approver)
                  <option value="{{ $approver->id }}" selected>
                    {{ $approver->username }} — {{ $approver->name }}
                  </option>
                @endif
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Tanggal Closure</label>
              <input type="date" name="section_g_closure_date" class="form-control"
                value="{{ $report->section_g_closure_date }}" {{ !$canEditG ? 'readonly' : '' }}>
            </div>
            <div class="col-md-3">
              <label class="form-label">Path dokumentasi</label>
              <input type="text" name="section_g_dokumentasi_path" class="form-control" maxlength="500"
                value="{{ $report->section_g_dokumentasi_path }}" {{ !$canEditG ? 'readonly' : '' }}
                placeholder="mis. \\\\server\\dok\\PICA\\...">
            </div>
            <div class="col-12">
              <label class="form-label">Pelajaran yang diambil</label>
              <textarea name="section_g_pelajaran" class="form-control" rows="4"
                {{ !$canEditG ? 'readonly' : '' }}>{{ $report->section_g_pelajaran }}</textarea>
            </div>
          </div>
        </div>
      </div>

      {{-- SECTION C — 5 WHY rows (di dalam form? Tidak — pakai form terpisah. Lihat di bawah.) --}}
      {{-- Submit button untuk A, B, F, G --}}
      @if (!$isReadOnly)
        <div class="d-flex justify-content-end mb-4 sticky-save"
             id="save-bar-abfg" style="position: sticky; bottom: 0; background: #fff; padding: .5rem 0; border-top: 1px solid #eee; z-index: 10;">
          <button class="btn btn-primary" type="submit">
            <i class="bx bx-save"></i> Simpan section A/B/F/G
          </button>
        </div>
      @endif
    </form>

    {{-- SECTION C — 5 WHY (form terpisah) --}}
    <div class="tab-pane fade" id="sec-c">
      <form method="POST" action="{{ route('pica-v2.report.whys', ['kode' => $kode]) }}">
        @csrf
        <div class="card mb-3">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
              <strong>C. 5 Why Root Cause Analysis</strong>
              <small class="text-muted">Tiap row 1 level Why. Boleh kurang/lebih dari 5.</small>
            </div>
            @if (!$isReadOnly)
              <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-why">
                <i class="bx bx-plus"></i> Tambah Why
              </button>
            @endif
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm align-middle">
                <thead class="table-light">
                  <tr>
                    <th width="60">Level</th>
                    <th>Pertanyaan (Mengapa ...?)</th>
                    <th>Jawaban (Karena ...)</th>
                    <th width="50"></th>
                  </tr>
                </thead>
                <tbody id="whys-body">
                  @forelse ($whys as $i => $w)
                    <tr class="why-row">
                      <td class="text-center"><span class="why-level">{{ $i + 1 }}</span></td>
                      <td>
                        <input type="text" name="whys[{{ $i }}][pertanyaan]" maxlength="500"
                          class="form-control form-control-sm" value="{{ $w->pertanyaan }}"
                          {{ $isReadOnly ? 'readonly' : '' }}>
                      </td>
                      <td>
                        <textarea name="whys[{{ $i }}][jawaban]" maxlength="1000" rows="2"
                          class="form-control form-control-sm"
                          {{ $isReadOnly ? 'readonly' : '' }}>{{ $w->jawaban }}</textarea>
                      </td>
                      <td>
                        @if (!$isReadOnly)
                          <button type="button" class="btn btn-sm btn-outline-danger btn-remove-why"><i class="bx bx-trash"></i></button>
                        @endif
                      </td>
                    </tr>
                  @empty
                    @if (!$isReadOnly)
                      @for ($i = 0; $i < 5; $i++)
                        <tr class="why-row">
                          <td class="text-center"><span class="why-level">{{ $i + 1 }}</span></td>
                          <td><input type="text" name="whys[{{ $i }}][pertanyaan]" maxlength="500" class="form-control form-control-sm" placeholder="Mengapa ...?"></td>
                          <td><textarea name="whys[{{ $i }}][jawaban]" maxlength="1000" rows="2" class="form-control form-control-sm" placeholder="Karena ..."></textarea></td>
                          <td><button type="button" class="btn btn-sm btn-outline-danger btn-remove-why"><i class="bx bx-trash"></i></button></td>
                        </tr>
                      @endfor
                    @endif
                  @endforelse
                </tbody>
              </table>
            </div>
            @if (!$isReadOnly)
              <div class="d-flex justify-content-end">
                <button class="btn btn-primary"><i class="bx bx-save"></i> Simpan 5 Why</button>
              </div>
            @endif
          </div>
        </div>
      </form>
    </div>

    {{-- SECTION D — CORRECTIVE --}}
    <div class="tab-pane fade" id="sec-d">
      @include('pica_v2._report_action_form', [
        'kode' => $kode, 'tipe' => 'corrective', 'label' => 'D. Corrective Action',
        'desc' => 'Tindakan korektif (untuk menangani masalah yang sudah terjadi).',
        'actions' => $correctives, 'isReadOnly' => $isReadOnly,
      ])
    </div>

    {{-- SECTION E — PREVENTIVE --}}
    <div class="tab-pane fade" id="sec-e">
      @include('pica_v2._report_action_form', [
        'kode' => $kode, 'tipe' => 'preventive', 'label' => 'E. Preventive Action',
        'desc' => 'Tindakan pencegahan (untuk mencegah kejadian berulang).',
        'actions' => $preventives, 'isReadOnly' => $isReadOnly,
      ])
    </div>

  </div>

  {{-- ============ CLOSE PICA ============ --}}
  @if ($isPic && $pica->Status_PICA === 'ACTION_PLANNING')
    <div class="card border-success mt-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <strong>Tutup PICA → CLOSED</strong>
          <small class="d-block text-muted">
            Gate: minimal 1 corrective + 1 preventive action + Section G closure_date harus diisi.
          </small>
        </div>
        <form method="POST" action="{{ route('pica-v2.report.close', ['kode' => $kode]) }}"
              onsubmit="return confirm('Tutup PICA permanen? Setelah CLOSED, report tidak bisa diubah lagi.');">
          @csrf
          <button class="btn btn-success">
            <i class="bx bx-check-double"></i> Tutup PICA
          </button>
        </form>
      </div>
    </div>
  @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Approver Select2 (search users)
  if (typeof $.fn.select2 !== 'undefined') {
    $('#approver-select').select2({
      width: '100%',
      placeholder: 'Cari user approver...',
      allowClear: true,
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

    // Init Select2 untuk PIC action picker yang sudah ada (rendered server-side)
    $('.action-pic-select').each(function () {
      $(this).select2({
        width: '100%',
        placeholder: 'Pilih PIC action...',
        allowClear: true,
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
    });
  }

  // 5-Why dynamic add/remove
  let whyIdx = document.querySelectorAll('#whys-body .why-row').length;
  document.getElementById('btn-add-why')?.addEventListener('click', function () {
    const tr = document.createElement('tr');
    tr.className = 'why-row';
    tr.innerHTML = `
      <td class="text-center"><span class="why-level">${whyIdx + 1}</span></td>
      <td><input type="text" name="whys[${whyIdx}][pertanyaan]" maxlength="500" class="form-control form-control-sm" placeholder="Mengapa ...?"></td>
      <td><textarea name="whys[${whyIdx}][jawaban]" maxlength="1000" rows="2" class="form-control form-control-sm" placeholder="Karena ..."></textarea></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger btn-remove-why"><i class="bx bx-trash"></i></button></td>`;
    document.getElementById('whys-body').appendChild(tr);
    whyIdx++;
  });
  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-remove-why')) {
      e.target.closest('tr').remove();
      // Renumber levels
      document.querySelectorAll('#whys-body .why-level').forEach((el, i) => el.textContent = i + 1);
    }
  });

  // Action rows dynamic add/remove
  document.querySelectorAll('.btn-add-action').forEach(btn => {
    btn.addEventListener('click', function () {
      const tipe = this.dataset.tipe;
      const tbody = document.getElementById(`actions-body-${tipe}`);
      const idx = tbody.querySelectorAll('tr.action-row').length;
      const tr = document.createElement('tr');
      tr.className = 'action-row';
      tr.innerHTML = `
        <td class="text-center">${idx + 1}</td>
        <td><textarea name="actions[${idx}][deskripsi]" rows="2" class="form-control form-control-sm" placeholder="Deskripsi action..." maxlength="1000"></textarea></td>
        <td><select name="actions[${idx}][pic_user_id]" class="form-select form-select-sm action-pic-select-new" style="width:100%"></select></td>
        <td><input type="date" name="actions[${idx}][deadline]" class="form-control form-control-sm"></td>
        <td>
          <select name="actions[${idx}][status]" class="form-select form-select-sm">
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </td>
        <td><input type="text" name="actions[${idx}][notes]" class="form-control form-control-sm" placeholder="Notes..." maxlength="1000"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger btn-remove-action"><i class="bx bx-trash"></i></button></td>`;
      tbody.appendChild(tr);

      // Init Select2 on new row's PIC select
      if (typeof $.fn.select2 !== 'undefined') {
        $(tr).find('.action-pic-select-new').select2({
          width: '100%',
          placeholder: 'Cari PIC...',
          allowClear: true,
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
    });
  });
  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-remove-action')) {
      e.target.closest('tr').remove();
    }
  });
});
</script>
@endsection
