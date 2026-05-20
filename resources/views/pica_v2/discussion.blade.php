@extends('layouts/layoutMaster')

@section('title', 'PICA Discussion — ' . $pica->Tr_Pica_Emp_h_Code)

@section('content')
@php
  $status = $pica->Status_PICA ?? '—';
  $statusColor = [
    'DRAFT'           => 'secondary',
    'PREPARING'       => 'info',
    'WAITING_PELAKU'  => 'warning',
    'ACTION_PLANNING' => 'primary',
    'CLOSED'          => 'success',
  ][$status] ?? 'secondary';

  $canAddQ      = $isPic || $isDewan;
  $canEditPhase = $isPic || $isPelaku;
  $isPreparing  = $status === 'PREPARING';
  $isAnswering  = $status === 'WAITING_PELAKU';
  $isLocked     = in_array($status, ['ACTION_PLANNING', 'CLOSED']);

  // Group participants per role
  $picList    = $participants->where('role', 'pic')->values();
  $dewanList  = $participants->where('role', 'dewan')->values();
  $pelakuList = $participants->where('role', 'pelaku')->values();
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
          </small>
        </div>

        {{-- Phase action buttons --}}
        <div class="d-flex gap-2 flex-wrap">
          @if (in_array($status, ['ACTION_PLANNING', 'CLOSED']))
            <a href="{{ route('pica-v2.report', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}" class="btn btn-sm btn-primary">
              <i class="bx bx-file"></i> Buka Report
            </a>
          @endif
          @if ($isPreparing && $canEditPhase)
            <form method="POST" action="{{ route('pica-v2.phase.toggle', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}"
                  onsubmit="return confirm('Kunci pertanyaan dan mulai fase pelaku menjawab?');">
              @csrf
              <input type="hidden" name="target" value="WAITING_PELAKU">
              <button class="btn btn-warning btn-sm">
                <i class="bx bx-lock"></i>
                {{ $isPic ? 'Lock & kirim ke pelaku' : 'Saya siap menjawab' }}
              </button>
            </form>
          @endif

          @if ($isAnswering && $isPic)
            <form method="POST" action="{{ route('pica-v2.phase.toggle', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}">
              @csrf
              <input type="hidden" name="target" value="BACK_TO_PREPARING">
              <button class="btn btn-outline-secondary btn-sm" title="Kembalikan ke fase persiapan">
                <i class="bx bx-arrow-back"></i> Balik ke PREPARING
              </button>
            </form>
            <form method="POST" action="{{ route('pica-v2.phase.toggle', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}"
                  onsubmit="return confirm('Lanjut ke Action Planning? Pastikan semua wajib_jawab sudah final.');">
              @csrf
              <input type="hidden" name="target" value="ACTION_PLANNING">
              <button class="btn btn-primary btn-sm" {{ $totalWajib > 0 && $terisiWajib < $totalWajib ? 'disabled' : '' }}>
                <i class="bx bx-right-arrow-alt"></i> Lanjut ke Action Plan
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

      {{-- Progress wajib_jawab --}}
      @if ($totalWajib > 0 && !$isPreparing)
        <hr>
        <div class="d-flex justify-content-between align-items-center">
          <small><strong>Progress wajib_jawab:</strong> {{ $terisiWajib }} / {{ $totalWajib }}</small>
          <div class="progress flex-grow-1 mx-3" style="height: 8px; max-width:400px">
            <div class="progress-bar bg-{{ $terisiWajib >= $totalWajib ? 'success' : 'warning' }}"
                 style="width: {{ $totalWajib ? ($terisiWajib / $totalWajib * 100) : 0 }}%"></div>
          </div>
          @if ($terisiWajib >= $totalWajib)
            <small class="text-success"><i class="bx bx-check-circle"></i> lengkap</small>
          @else
            <small class="text-muted">{{ $totalWajib - $terisiWajib }} lagi</small>
          @endif
        </div>
      @endif
    </div>
  </div>

  {{-- ============ FASE INFO BANNER ============ --}}
  @if ($isPreparing)
    <div class="alert alert-info">
      <i class="bx bx-info-circle"></i>
      <strong>Mode PREPARING.</strong>
      Dewan & PIC boleh tambah pertanyaan. Pelaku boleh kasih komentar tapi belum jawab final.
      Setelah dirasa cukup, PIC atau Pelaku klik tombol di atas untuk mulai fase pelaku menjawab.
    </div>
  @elseif ($isAnswering)
    <div class="alert alert-warning">
      <i class="bx bx-time"></i>
      <strong>Mode WAITING_PELAKU.</strong>
      Pelaku silakan jawab pertanyaan/pernyataan (terutama yang ditandai <span class="badge bg-danger">WAJIB</span>),
      lalu klik tombol "Tandai final" untuk menjadikan jawaban sebagai final.
    </div>
  @elseif ($isLocked)
    <div class="alert alert-secondary">
      <i class="bx bx-lock-alt"></i>
      <strong>Mode {{ $status }} — Read-only.</strong>
      Pertanyaan tidak bisa ditambah/diubah. Komentar masih boleh.
    </div>
  @endif

  {{-- ============ PERTANYAAN LIST ============ --}}
  @forelse ($pertanyaanList as $q)
    @php
      $jws = $jawabanByQ[$q->id] ?? collect();
      $finalJ = $jws->firstWhere('is_final', 1);
      $tipeColor = $q->tipe === 'pernyataan' ? 'warning' : 'primary';
      $source = is_null($q->pertanyaan_master_id) ? 'BEBAS' : 'MASTER';
    @endphp

    <div class="card mb-3" id="q-{{ $q->id }}">
      <div class="card-header d-flex justify-content-between align-items-start py-2 flex-wrap gap-2">
        <div>
          <span class="badge bg-label-{{ $tipeColor }}">{{ strtoupper($q->tipe) }}</span>
          @if ($q->wajib_jawab)
            <span class="badge bg-danger">WAJIB</span>
          @endif
          <span class="badge bg-label-secondary">{{ $source }}</span>
          @if ($finalJ)
            <span class="badge bg-success"><i class="bx bx-check"></i> FINAL</span>
          @endif
          <small class="text-muted ms-2">#{{ $q->urutan }}</small>
        </div>
        @if ($isPic && !$isLocked)
          <form method="POST" action="{{ route('pica-v2.pertanyaan.delete', ['kode' => $pica->Tr_Pica_Emp_h_Code, 'id' => $q->id]) }}"
                onsubmit="return confirm('Hapus pertanyaan ini?');">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger" title="Hapus (PIC only)">
              <i class="bx bx-trash"></i>
            </button>
          </form>
        @endif
      </div>
      <div class="card-body">
        <p class="mb-2"><strong>{{ $q->pertanyaan }}</strong></p>
        @if ($q->creator_username)
          <small class="text-muted d-block mb-3">
            Ditambah oleh <em>{{ $q->creator_name ?? $q->creator_username }}</em>
            · {{ \Carbon\Carbon::parse($q->created_at)->diffForHumans() }}
          </small>
        @endif

        {{-- Thread jawaban --}}
        @if ($jws->isNotEmpty())
          <div class="ms-3 ps-3 border-start">
            @foreach ($jws as $j)
              @php
                $isFinalRow = $j->is_final;
                $author = $j->name ?? $j->username ?? 'user#' . $j->user_id;
              @endphp
              <div class="mb-3 {{ $isFinalRow ? 'p-2 rounded bg-label-success' : '' }}">
                <div class="d-flex justify-content-between align-items-center">
                  <small>
                    @if ($isFinalRow)<i class="bx bx-star text-warning"></i> @endif
                    <strong>{{ $author }}</strong>
                    <span class="text-muted">· {{ \Carbon\Carbon::parse($j->created_at)->diffForHumans() }}</span>
                    @if ($isFinalRow)
                      <span class="badge bg-success ms-1">FINAL</span>
                    @endif
                  </small>
                  {{-- Set final button (pelaku only, WAITING_PELAKU, own answer) --}}
                  @if ($isAnswering && $isPelaku && !$isFinalRow && $j->user_id == auth()->id())
                    <form method="POST" action="{{ route('pica-v2.jawaban.final', ['kode' => $pica->Tr_Pica_Emp_h_Code, 'id' => $j->id]) }}"
                          onsubmit="return confirm('Tandai jawaban ini sebagai final? Jawaban final lain di pertanyaan ini akan di-unfinal.');">
                      @csrf @method('PATCH')
                      <button class="btn btn-xs btn-outline-success" title="Tandai sebagai jawaban final">
                        <i class="bx bx-check"></i> Tandai final
                      </button>
                    </form>
                  @endif
                </div>
                @if ($j->ack_status)
                  <div>
                    <span class="badge bg-label-{{ $j->ack_status === 'setuju' ? 'success' : 'danger' }}">
                      {{ $j->ack_status === 'setuju' ? 'Setuju' : 'Tidak Setuju' }}
                    </span>
                  </div>
                @endif
                @if ($j->jawaban)
                  <div class="mt-1" style="white-space: pre-line">{{ $j->jawaban }}</div>
                @endif
              </div>
            @endforeach
          </div>
        @endif

        {{-- Form add jawaban/komentar --}}
        @if (!$isLocked)
          <hr class="my-2">
          <form method="POST" action="{{ route('pica-v2.jawaban.add', ['kode' => $pica->Tr_Pica_Emp_h_Code, 'id' => $q->id]) }}">
            @csrf
            @if ($q->tipe === 'pernyataan')
              <div class="mb-2">
                <label class="form-label small mb-1">Sikap:</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="ack_status" id="ack-s-{{ $q->id }}" value="setuju">
                  <label class="form-check-label small" for="ack-s-{{ $q->id }}">Setuju</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="ack_status" id="ack-t-{{ $q->id }}" value="tidak_setuju">
                  <label class="form-check-label small" for="ack-t-{{ $q->id }}">Tidak Setuju</label>
                </div>
              </div>
            @endif
            <div class="d-flex gap-2">
              <textarea name="jawaban" class="form-control form-control-sm" rows="2"
                placeholder="{{ $q->tipe === 'pernyataan' ? 'Reasoning (opsional bila pilih sikap)...' : 'Tulis jawaban/komentar...' }}"></textarea>
              <button class="btn btn-sm btn-primary align-self-end" type="submit">
                <i class="bx bx-send"></i>
              </button>
            </div>
          </form>
        @endif
      </div>
    </div>
  @empty
    <div class="alert alert-warning">
      Belum ada pertanyaan. {{ $canAddQ ? 'Silakan tambah pertanyaan di bawah.' : '' }}
    </div>
  @endforelse

  {{-- ============ ADD PERTANYAAN BARU ============ --}}
  @if ($canAddQ && !$isLocked)
    <div class="card mb-3 border-primary">
      <div class="card-header py-2">
        <strong><i class="bx bx-plus-circle"></i> Tambah pertanyaan baru</strong>
        <small class="text-muted">
          @if ($isPic) (PIC bebas toggle wajib)
          @else (Dewan — default wajib off, PIC bisa override)
          @endif
        </small>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('pica-v2.pertanyaan.add', ['kode' => $pica->Tr_Pica_Emp_h_Code]) }}">
          @csrf
          <div class="row g-2">
            <div class="col-md-2">
              <select name="tipe" class="form-select form-select-sm">
                <option value="pertanyaan">Pertanyaan</option>
                <option value="pernyataan">Pernyataan</option>
              </select>
            </div>
            <div class="col-md-7">
              <input type="text" name="pertanyaan" class="form-control form-control-sm"
                maxlength="1000" placeholder="Tulis pertanyaan atau pernyataan..." required>
            </div>
            <div class="col-md-2 d-flex align-items-center">
              <label class="form-check-label small">
                <input type="checkbox" name="wajib_jawab" value="1" class="form-check-input">
                Wajib jawab
              </label>
            </div>
            <div class="col-md-1">
              <button class="btn btn-sm btn-primary w-100" type="submit">
                <i class="bx bx-plus"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
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
