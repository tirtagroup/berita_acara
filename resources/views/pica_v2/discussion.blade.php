@extends('layouts/layoutMaster')

@section('title', 'PICA Discussion — ' . $pica->Tr_Pica_Emp_h_Code)

@section('content')
@php
  $status = $pica->Status_PICA ?? '—';
  $statusColor = [
    'DRAFT'           => 'secondary',
    'PREPARING'       => 'info',
    'MEETING'         => 'warning',
    'ACTION_PLANNING' => 'primary',
    'CLOSED'          => 'success',
    'Belum Closing'   => 'dark',
  ][$status] ?? 'secondary';

  $canAddQ      = $isPic || $isDewan;
  $isPreparing  = $status === 'PREPARING';
  $isMeeting    = $status === 'MEETING';
  $isLocked     = in_array($status, ['ACTION_PLANNING', 'CLOSED']);
  $canAddQNow   = $canAddQ && in_array($status, ['PREPARING', 'MEETING']);

  // Group participants per role
  $picList    = $participants->where('role', 'pic')->values();
  $dewanList  = $participants->where('role', 'dewan')->values();

  // Pernyataan signed?
  $pernyataanSigned = !empty($pica->pernyataan_signed_at);
  $pernyataanText   = $pica->pernyataan_pelaku ?: $pernyataanDefault;

  // Gate check for MEETING → ACTION_PLANNING
  $hasilFilled   = !empty(trim($pica->hasil_meeting_pic ?? ''));
  $allWajibFinal = $totalWajib === 0 || $terisiWajib >= $totalWajib;
  $canFinishMeeting = $isMeeting && $isPic && $hasilFilled && $allWajibFinal && $pernyataanSigned;
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">PICA /</span> Discussion
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

  {{-- ============ HEADER CARD ============ --}}
  <div class="card mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
        <div>
          <h5 class="mb-1">
            <i class="bx bx-clipboard"></i> {{ $pica->Tr_Pica_Emp_h_Code }}
            <span class="badge bg-label-{{ $statusColor }} ms-2">{{ $status }}</span>
            @if ($pernyataanSigned)
              <span class="badge bg-success ms-1" title="Pernyataan pelaku ditandatangani">
                <i class="bx bx-check-shield"></i> Signed
              </span>
            @endif
          </h5>
          <small class="text-muted">
            Dibuat oleh <b>{{ $pica->User_Created }}</b>
            · {{ \Carbon\Carbon::parse($pica->Date_PICA)->format('d M Y') }}
            @if ($baInduk)
              · BA induk:
              <a href="{{ route('berita-acara-v2.show') }}?kode={{ $baInduk->Tr_BA_Main_Code }}">
                {{ $baInduk->Tr_BA_Main_Code }}
              </a>
            @endif
            @if ($pica->meeting_started_at)
              · Meeting started {{ \Carbon\Carbon::parse($pica->meeting_started_at)->format('d M Y H:i') }}
            @endif
          </small>
        </div>

        {{-- Phase action buttons --}}
        <div class="d-flex gap-2 flex-wrap">
          @if (in_array($status, ['ACTION_PLANNING', 'CLOSED']))
            <a href="{{ route('pica-v2.report', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}" class="btn btn-sm btn-primary">
              <i class="bx bx-file"></i> Buka Report
            </a>
          @endif

          @if ($isPreparing && $isPic)
            <form method="POST" action="{{ route('pica-v2.phase.toggle', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}"
                  onsubmit="return confirm('Mulai meeting PICA sekarang? Pelaku akan bisa jawab pertanyaan + tanda tangan pernyataan.');">
              @csrf
              <input type="hidden" name="target" value="MEETING">
              <button class="btn btn-warning btn-sm">
                <i class="bx bx-play-circle"></i> Mulai Meeting PICA
              </button>
            </form>
          @endif

          @if ($isMeeting && $isPic)
            <form method="POST" action="{{ route('pica-v2.phase.toggle', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}"
                  onsubmit="return confirm('Batalkan meeting & kembali ke PREPARING? Catatan meeting akan tetap tersimpan.');">
              @csrf
              <input type="hidden" name="target" value="BACK_TO_PREPARING">
              <button class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Batalkan Meeting
              </button>
            </form>
            <form method="POST" action="{{ route('pica-v2.phase.toggle', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}"
                  onsubmit="return confirm('Selesai meeting & lanjut ke Action Planning?');">
              @csrf
              <input type="hidden" name="target" value="ACTION_PLANNING">
              <button class="btn btn-success btn-sm" {{ !$canFinishMeeting ? 'disabled' : '' }}
                      title="{{ $canFinishMeeting ? 'Selesai meeting → Action Planning' : 'Belum siap: cek gate di bawah' }}">
                <i class="bx bx-check-double"></i> Selesai Meeting →
              </button>
            </form>
          @endif
        </div>
      </div>

      <div class="row g-2 small mt-1">
        <div class="col-md-3"><strong>Pelaku:</strong>
          {{ $pelakuEmp->emp_name ?? $pica->Emp_Code }}
          <small class="text-muted">({{ $pica->Emp_Code }})</small>
        </div>
        <div class="col-md-3"><strong>PIC:</strong>
          {{ $picList->first()->name ?? $picList->first()->username ?? '—' }}
        </div>
        <div class="col-md-6"><strong>Dewan:</strong>
          @if ($dewanList->isEmpty())
            <em class="text-muted">—</em>
          @else
            {{ $dewanList->pluck('name')->filter()->join(', ') ?: $dewanList->pluck('username')->join(', ') }}
          @endif
        </div>
        @if (!empty($kategoriPica))
          <div class="col-md-12"><strong>Kategori:</strong>
            @foreach ($kategoriPica as $kat)
              <span class="badge bg-label-info">{{ $kat }}</span>
            @endforeach
          </div>
        @endif
        @if ($pica->Problem_Note)
          <div class="col-12">
            <strong>Problem note:</strong>
            <div class="bg-light p-2 rounded">{{ $pica->Problem_Note }}</div>
          </div>
        @endif
      </div>

      {{-- Progress wajib_jawab + gate check (saat MEETING) --}}
      @if ($isMeeting)
        <hr>
        <div class="row g-2 small">
          <div class="col-md-4">
            <strong>Gate "Selesai Meeting":</strong>
          </div>
          <div class="col-md-8">
            <ul class="list-unstyled mb-0 small">
              <li>
                <i class="bx bx-{{ $allWajibFinal ? 'check text-success' : 'x text-danger' }}"></i>
                Pelaku jawab semua wajib_jawab ({{ $terisiWajib }}/{{ $totalWajib }})
              </li>
              <li>
                <i class="bx bx-{{ $hasilFilled ? 'check text-success' : 'x text-danger' }}"></i>
                Hasil Meeting (PIC) terisi
              </li>
              <li>
                <i class="bx bx-{{ $pernyataanSigned ? 'check text-success' : 'x text-danger' }}"></i>
                Pernyataan pelaku ditandatangani
              </li>
            </ul>
          </div>
        </div>
      @endif
    </div>
  </div>

  {{-- ============ FASE INFO BANNER ============ --}}
  @if ($isPreparing)
    <div class="alert alert-info">
      <i class="bx bx-info-circle"></i>
      <strong>Fase 1: PERSIAPAN.</strong>
      PIC + Dewan siapkan agenda pembahasan & list pertanyaan. Pelaku boleh kasih komentar awal.
      Saat siap → PIC klik <em>Mulai Meeting PICA</em>.
    </div>
  @elseif ($isMeeting)
    <div class="alert alert-warning">
      <i class="bx bx-time"></i>
      <strong>Fase 2: MEETING BERLANGSUNG.</strong>
      PIC catat hasil meeting · Pelaku jawab pertanyaan + buat pernyataan formal · Setelah lengkap PIC klik <em>Selesai Meeting</em>.
    </div>
  @elseif ($isLocked)
    <div class="alert alert-secondary">
      <i class="bx bx-lock-alt"></i>
      <strong>Status {{ $status }} — Read-only.</strong> Lihat report di tombol "Buka Report".
    </div>
  @endif

  {{-- ============ PREPARING — Kronologi BA + Agenda ============ --}}
  @if ($isPreparing || $isMeeting)
    <div class="row g-3 mb-3">
      {{-- Kronologi dari BA induk (read-only) --}}
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header py-2">
            <strong><i class="bx bx-history"></i> Kronologi Kejadian</strong>
            <small class="text-muted d-block">
              @if ($baInduk)
                Dari BA induk · read-only
              @else
                BA induk tidak terlink — konteks dari Problem Note di header
              @endif
            </small>
          </div>
          <div class="card-body" style="max-height: 280px; overflow-y: auto">
            @if ($baKronologi->isNotEmpty())
              <ol class="mb-0 small">
                @foreach ($baKronologi as $kr)
                  <li>{{ $kr->detail }}</li>
                @endforeach
              </ol>
            @else
              <p class="text-muted small mb-0">Tidak ada kronologi detail dari BA induk.</p>
            @endif
          </div>
        </div>
      </div>

      {{-- Agenda Pembahasan (PIC + Dewan edit) --}}
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header py-2">
            <strong><i class="bx bx-list-ul"></i> Agenda Pembahasan</strong>
            <small class="text-muted d-block">PIC + Dewan: bullet list topik yang akan dibahas saat meeting.</small>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('pica-v2.agenda.save', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}">
              @csrf
              <textarea name="agenda_pembahasan" class="form-control form-control-sm" rows="8"
                placeholder="- Bahas penyebab langsung&#10;- Klarifikasi kronologi dgn pelaku&#10;- Diskusi corrective action&#10;..."
                {{ !($isPic || $isDewan) ? 'readonly' : '' }}>{{ $pica->agenda_pembahasan }}</textarea>
              @if ($isPic || $isDewan)
                <button class="btn btn-sm btn-primary mt-2" type="submit">
                  <i class="bx bx-save"></i> Simpan Agenda
                </button>
              @endif
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- ============ MEETING TABS (saat MEETING) ============ --}}
  @if ($isMeeting)
    <ul class="nav nav-pills mb-3" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-qa">
        <i class="bx bx-question-mark"></i> Q&A Forum
      </a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-catatan">
        <i class="bx bx-edit"></i> Catatan Meeting
      </a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-pernyataan">
        <i class="bx bx-check-shield"></i> Pernyataan Pelaku
        @if ($pernyataanSigned)<span class="badge bg-success ms-1">signed</span>@endif
      </a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="tab-qa">
        @include('pica_v2._discussion_questions')
      </div>

      <div class="tab-pane fade" id="tab-catatan">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header py-2">
                <strong><i class="bx bx-user-pin"></i> Hasil Meeting (PIC)</strong>
                <small class="text-muted d-block">{{ $isPic ? 'Catat hasil pembahasan, kesimpulan, keputusan kelompok.' : 'PIC only — read-only untuk yang lain.' }}</small>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('pica-v2.hasil.save', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}">
                  @csrf
                  <textarea name="hasil_meeting_pic" class="form-control" rows="14"
                    placeholder="- Diskusi poin 1...&#10;- Pelaku menjelaskan...&#10;- Kesimpulan...&#10;- Tindakan disepakati..."
                    {{ !$isPic ? 'readonly' : '' }}>{{ $pica->hasil_meeting_pic }}</textarea>
                  @if ($isPic)
                    <button class="btn btn-sm btn-primary mt-2" type="submit">
                      <i class="bx bx-save"></i> Simpan Hasil
                    </button>
                  @endif
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header py-2">
                <strong><i class="bx bx-user-voice"></i> Catatan Pelaku</strong>
                <small class="text-muted d-block">{{ $isPelaku ? 'Catatan independen Anda — perspektif sendiri.' : 'Pelaku only — read-only untuk yang lain.' }}</small>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('pica-v2.catatan.save', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}">
                  @csrf
                  <textarea name="catatan_pelaku" class="form-control" rows="14"
                    placeholder="Catatan pelaku..."
                    {{ !$isPelaku ? 'readonly' : '' }}>{{ $pica->catatan_pelaku }}</textarea>
                  @if ($isPelaku)
                    <button class="btn btn-sm btn-primary mt-2" type="submit">
                      <i class="bx bx-save"></i> Simpan Catatan
                    </button>
                  @endif
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="tab-pernyataan">
        <div class="card">
          <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <div>
              <strong><i class="bx bx-check-shield"></i> Pernyataan Formal Pelaku</strong>
              <small class="text-muted d-block">
                @if ($pernyataanSigned)
                  Ditandatangani oleh <b>{{ $pica->pernyataan_signed_by }}</b>
                  pada {{ \Carbon\Carbon::parse($pica->pernyataan_signed_at)->format('d M Y H:i') }}
                @else
                  Pelaku: edit draft, lalu klik "Tanda Tangan" untuk kunci.
                @endif
              </small>
            </div>
            @if ($pernyataanSigned && $isPic)
              <form method="POST" action="{{ route('pica-v2.pernyataan.unsign', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}"
                    onsubmit="return confirm('Batalkan signature pernyataan? Pelaku bisa edit ulang.');">
                @csrf
                <button class="btn btn-sm btn-outline-warning" title="Unlock (PIC only)">
                  <i class="bx bx-lock-open"></i> Unlock
                </button>
              </form>
            @endif
          </div>
          <div class="card-body">
            {{-- Form 1: Save draft (textarea pernyataan) --}}
            <form method="POST" action="{{ route('pica-v2.pernyataan.save', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}">
              @csrf
              <textarea name="pernyataan_pelaku" class="form-control"
                rows="16" style="font-family: ui-monospace,Menlo,monospace; font-size: .9em"
                {{ !$isPelaku || $pernyataanSigned ? 'readonly' : '' }}>{{ $pernyataanText }}</textarea>

              @if ($isPelaku && !$pernyataanSigned)
                <button class="btn btn-sm btn-outline-primary mt-2" type="submit">
                  <i class="bx bx-save"></i> Simpan Draft
                </button>
              @endif
            </form>

            {{-- Form 2: Sign (separate form, separate action) --}}
            @if ($isPelaku && !$pernyataanSigned)
              <form method="POST" action="{{ route('pica-v2.pernyataan.sign', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}"
                    onsubmit="return confirm('Tandatangani pernyataan? Setelah signed, tidak bisa di-edit lagi (kecuali PIC unlock).');"
                    class="d-inline">
                @csrf
                <button class="btn btn-sm btn-success mt-2" type="submit">
                  <i class="bx bx-check-circle"></i> Tanda Tangan Pernyataan
                </button>
              </form>
            @elseif ($pernyataanSigned)
              <div class="alert alert-success small mb-0 mt-2">
                <i class="bx bx-lock"></i> Pernyataan terkunci setelah ditandatangani.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  @else
    {{-- Non-MEETING: tampilkan Q&A langsung (tanpa tabs) --}}
    @include('pica_v2._discussion_questions')
  @endif

</div>

<style>
  .btn-xs {
    --bs-btn-padding-y: 0.15rem;
    --bs-btn-padding-x: 0.4rem;
    --bs-btn-font-size: 0.7rem;
  }
</style>
@endsection
