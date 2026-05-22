{{-- ============ PERTANYAAN LIST + ADD NEW ============
    Variables available (from discussion.blade.php):
    - $pica, $pertanyaanList, $jawabanByQ
    - $isPic, $isDewan, $isPelaku, $isMeeting, $isLocked, $canAddQNow
--}}
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
                {{-- Set final button (pelaku only, MEETING, own answer) --}}
                @if ($isMeeting && $isPelaku && !$isFinalRow && $j->user_id == auth()->id())
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
    Belum ada pertanyaan. {{ $canAddQNow ? 'Silakan tambah pertanyaan di bawah.' : '' }}
  </div>
@endforelse

{{-- ============ ADD PERTANYAAN BARU ============ --}}
@if ($canAddQNow)
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
