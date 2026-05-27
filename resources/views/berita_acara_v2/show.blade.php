@extends('layouts/layoutMaster')

@section('title', 'Detail BA — ' . $ba->Tr_BA_Main_Code)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {!! session('success') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('warning'))
    <div class="alert alert-warning alert-dismissible">
      {!! session('warning') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Berita Acara /</span> Detail
      <br><code class="fs-6">{{ $ba->Tr_BA_Main_Code }}</code>
      @if (!empty($ba->edit_allowed))
        <span class="badge bg-label-warning ms-2" title="Creator boleh edit BA ini"><i class="bx bx-edit"></i> Edit terbuka</span>
      @endif
    </h4>
    <div class="d-flex gap-2 flex-wrap">
      @include('components._help_button', ['slug' => 'ba-edit'])
      @if (!empty($canEdit))
        <a href="{{ route('berita-acara-v2.edit', ['kode' => $ba->Tr_BA_Main_Code]) }}" class="btn btn-warning">
          <i class="bx bx-edit"></i> Edit BA
        </a>
      @endif
      <a href="{{ route('berita-acara-v2.print', ['kode' => $ba->Tr_BA_Main_Code]) }}" class="btn btn-outline-primary"
         target="_blank" title="Download PDF BA">
        <i class="bx bx-printer"></i> Print PDF
      </a>
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalShareWa"
              title="Kirim BA ke WhatsApp group">
        <i class="bx bxl-whatsapp"></i> Share ke WA
      </button>
      @if (!empty($isAdmin))
        <form method="POST" action="{{ route('berita-acara-v2.toggle-edit', ['kode' => $ba->Tr_BA_Main_Code]) }}"
              onsubmit="return confirm('{{ $ba->edit_allowed ? 'Kunci kembali (creator tidak boleh edit)?' : 'Izinkan creator edit BA ini?' }}');">
          @csrf
          <button class="btn btn-outline-{{ $ba->edit_allowed ? 'danger' : 'primary' }}" type="submit"
                  title="Toggle apakah creator BA boleh edit">
            <i class="bx bx-{{ $ba->edit_allowed ? 'lock' : 'lock-open' }}"></i>
            {{ $ba->edit_allowed ? 'Kunci edit' : 'Buka edit untuk creator' }}
          </button>
        </form>
      @endif
      <a href="{{ route('berita-acara-v2.dashboard') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Dashboard
      </a>
    </div>
  </div>

  {{-- ============ MODAL: Share ke WhatsApp ============ --}}
  <div class="modal fade" id="modalShareWa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form method="POST" action="{{ route('berita-acara-v2.share-wa', ['kode' => $ba->Tr_BA_Main_Code]) }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bx bxl-whatsapp text-success"></i> Share BA ke WhatsApp</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="small text-muted">
              BA akan di-generate jadi PDF, di-upload ke storage publik, lalu dikirim via WhatsApp dengan
              link ke PDF + link ke halaman BA detail.
            </p>

            <div class="mb-3">
              <label class="form-label">Nomor tujuan / Group ID</label>
              <input type="text" name="to_number" class="form-control"
                     placeholder="628123456789 (kosongkan = pakai WA_QONTAK_NUMBERS default)">
              <small class="form-text text-muted">
                Format: 62 + nomor tanpa awalan 0. Untuk multi-tujuan default, kosongkan field ini.
              </small>
            </div>

            <div class="alert alert-info py-2 mb-0 small">
              <strong>Yang akan terkirim:</strong>
              <ul class="mb-0 mt-1">
                <li>Kode BA: <code>{{ $ba->Tr_BA_Main_Code }}</code></li>
                <li>Tanggal: {{ \Carbon\Carbon::parse($ba->Date_BA)->format('d M Y') }}</li>
                <li>Pelapor + Karyawan + Konteks + Lokasi + Deskripsi + Kategori + Kronologi</li>
                <li>📎 Link PDF (download)</li>
                <li>🔗 Link halaman detail BA</li>
              </ul>
            </div>

            @php
              $waToken = config('services.wa_qontak.token');
            @endphp
            @if (empty($waToken))
              <div class="alert alert-warning py-2 mb-0 mt-2 small">
                <i class="bx bx-error"></i> <strong>Catatan:</strong>
                <code>WA_QONTAK_TOKEN</code> belum diset di <code>.env</code>.
                PDF akan tetap di-generate, tapi WA TIDAK akan terkirim
                (silent skip). Setup credentials dulu via Mekari Qontak dashboard.
              </div>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">
              <i class="bx bxl-whatsapp"></i> Kirim
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    {{-- Data Umum --}}
    <div class="col-lg-8">
      <div class="card mb-3">
        <div class="card-header"><h5 class="card-title m-0">Data Umum</h5></div>
        <div class="card-body">
          <dl class="row mb-0">
            <dt class="col-sm-3">Konteks</dt>
            <dd class="col-sm-9"><span class="badge bg-label-primary">{{ $ba->Ms_BA_type_Code }}</span></dd>

            <dt class="col-sm-3">Tanggal BA</dt>
            <dd class="col-sm-9">{{ $ba->Date_BA }}</dd>

            <dt class="col-sm-3">Pelaku</dt>
            <dd class="col-sm-9">
              @if ($ba->emp_name)
                <strong>{{ $ba->emp_name }}</strong> <small class="text-muted">({{ $ba->Ms_Emp_Code }})</small>
              @else
                <code>{{ $ba->Ms_Emp_Code }}</code>
              @endif
              <a href="{{ route('berita-acara-v2.list', ['emp_code' => $ba->Ms_Emp_Code]) }}" class="btn btn-sm btn-link">
                Lihat semua BA pelaku ini →
              </a>
            </dd>

            <dt class="col-sm-3">Divisi Pelaku</dt>
            <dd class="col-sm-9">{{ $ba->Ms_Emp_Div ?: '—' }}</dd>

            <dt class="col-sm-3">Pelapor</dt>
            <dd class="col-sm-9">
              {{ $ba->Ms_Pelapor_Code }}
              <a href="{{ route('berita-acara-v2.list', ['pelapor' => $ba->Ms_Pelapor_Code]) }}" class="btn btn-sm btn-link">
                Lihat semua BA pelapor ini →
              </a>
            </dd>

            <dt class="col-sm-3">Cabang</dt>
            <dd class="col-sm-9">{{ $ba->company_name ?: $ba->rec_comcode ?: '—' }}</dd>

            <dt class="col-sm-3">Lokasi</dt>
            <dd class="col-sm-9">{{ $ba->lokasi_name ?: $ba->rec_areacode ?: '—' }}</dd>

            <dt class="col-sm-3">Deskripsi</dt>
            <dd class="col-sm-9">{{ $ba->BA_Desc }}</dd>

            <dt class="col-sm-3">Dibuat</dt>
            <dd class="col-sm-9"><small>{{ $ba->rec_datecreated }} oleh {{ $ba->rec_usercreated }}</small></dd>
          </dl>
        </div>
      </div>

      {{-- Kategori --}}
      <div class="card mb-3">
        <div class="card-header"><h5 class="card-title m-0">Kategori ({{ $kategoris->count() }})</h5></div>
        <div class="card-body">
          @forelse ($kategoris as $k)
            <div class="mb-2">
              <span class="badge bg-label-primary me-1">{{ $k->kategori_nama ?? $k->kategori_kode }}</span>
              @if ($k->opsi_deskripsi)
                <small class="text-muted">→ {{ $k->opsi_deskripsi }}</small>
              @endif
            </div>
          @empty
            <p class="text-muted small mb-0">Tidak ada kategori (BA legacy mungkin pakai Cek* flags di header).</p>
          @endforelse
        </div>
      </div>

      {{-- Kronologi --}}
      @if ($kronologi->count() > 0)
        <div class="card mb-3">
          <div class="card-header"><h5 class="card-title m-0">Kronologi ({{ $kronologi->count() }})</h5></div>
          <div class="card-body">
            <ol class="mb-0">
              @foreach ($kronologi as $k)
                <li class="mb-2">{{ $k->kronlogi }}</li>
              @endforeach
            </ol>
          </div>
        </div>
      @endif

      {{-- Revisi (jika konteks REVISI) --}}
      @if ($requestRevisi)
        <div class="card mb-3 border-warning">
          <div class="card-header bg-warning bg-opacity-10">
            <h5 class="card-title m-0">Detail Revisi</h5>
            <small class="text-muted">Kode Request: <code>{{ $requestRevisi->tr_ba_request_revisi_code }}</code></small>
          </div>
          <div class="card-body">
            <p><strong>Alasan:</strong> {{ $requestRevisi->note }}</p>
            @if ($revisiDetail->count() > 0)
              <h6 class="mt-3">Field yang Direvisi:</h6>
              <table class="table table-sm table-bordered">
                <thead>
                  <tr>
                    <th>Field Salah</th>
                    <th>Value Salah</th>
                    <th>Field Benar</th>
                    <th>Value Benar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($revisiDetail as $d)
                    <tr>
                      <td>{{ $d->field_salah }}</td>
                      <td><code>{{ $d->value_salah }}</code></td>
                      <td>{{ $d->field_benar }}</td>
                      <td><code class="text-success">{{ $d->value_benar }}</code></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
            @if ($revisiApproval)
              <h6 class="mt-3">Workflow Approval:</h6>
              <ul class="list-unstyled small">
                <li>Koord: {{ $revisiApproval->Cek_Koor_Approval ? '✓ ' . $revisiApproval->Koor_Code : '⏳ menunggu' }}</li>
                <li>SPV: {{ $revisiApproval->Cek_Spv_Approval ? '✓ ' . $revisiApproval->Spv_Code : '⏳ menunggu' }}</li>
                <li>HR: {{ $revisiApproval->Cek_HR_Approval ? '✓ ' . $revisiApproval->HR_Code : '⏳ menunggu' }}</li>
                <li>BOD: {{ $revisiApproval->CeK_Bod_Approval ? '✓ ' . $revisiApproval->Bod_Code : '⏳ menunggu' }}</li>
              </ul>
            @endif
          </div>
        </div>
      @endif
    </div>

    {{-- Sidebar: Cek* flags legacy --}}
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header"><h6 class="card-title m-0">Cek* Flags (legacy)</h6></div>
        <div class="card-body">
          @php
            $flags = [
              'CekPelanggaran', 'CekKerusakan', 'CekFraud', 'CekRevisi', 'CekDisiplin',
              'CekSalahIsi', 'CekNoClosing', 'CekLaka', 'CekPembelian', 'CekKehilangan', 'CekPerubahanSOP'
            ];
            $activeFlags = array_filter($flags, fn($f) => !empty($ba->$f));
          @endphp
          @if ($activeFlags)
            @foreach ($activeFlags as $f)
              <span class="badge bg-label-warning me-1 mb-1">{{ str_replace('Cek', '', $f) }}</span>
            @endforeach
          @else
            <small class="text-muted">Tidak ada flag aktif (kemungkinan BA dibuat via wizard v2).</small>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- ============ PICA TERKAIT (Fase 6 — BA↔PICA integration) ============ --}}
  @php
    $statusColor = [
      'DRAFT'           => 'secondary',
      'PREPARING'       => 'info',
      'MEETING'         => 'warning',
      'FINALIZED'       => 'primary',
      'DONE'            => 'success',
    ];
  @endphp
  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0">
        <i class="bx bx-clipboard"></i> PICA Terkait
        @if ($picaList->isNotEmpty())
          <span class="badge bg-label-primary ms-1">{{ $picaList->count() }}</span>
        @endif
      </h5>
      <a href="{{ route('pica-v2.create', ['ba_code' => $ba->Tr_BA_Main_Code]) }}"
         class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i> Buat PICA dari BA ini
      </a>
    </div>
    <div class="card-body p-0">
      @if ($picaList->isEmpty())
        <div class="text-center text-muted py-4">
          <i class="bx bx-info-circle"></i>
          Belum ada PICA yang link ke BA ini. Klik tombol di atas untuk buat PICA tindak-lanjut.
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-sm table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Kode PICA</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Pelaku</th>
                <th>Problem</th>
                <th width="120">Progress</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($picaList as $p)
                <tr>
                  <td>
                    <a href="{{ route('pica-v2.discussion', ['kode' => $p->Tr_Pica_Emp_h_Code]) }}">
                      <code>{{ $p->Tr_Pica_Emp_h_Code }}</code>
                    </a>
                  </td>
                  <td><small>{{ \Carbon\Carbon::parse($p->Date_PICA)->format('d M Y') }}</small></td>
                  <td>
                    <span class="badge bg-label-{{ $statusColor[$p->Status_PICA] ?? 'secondary' }}">
                      {{ $p->Status_PICA }}
                    </span>
                  </td>
                  <td>
                    {{ $p->emp_name ?? $p->Emp_Code }}
                    <small class="text-muted">({{ $p->Emp_Code }})</small>
                  </td>
                  <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($p->Problem_Note, 60) }}</small></td>
                  <td>
                    @if ($p->progress['total'] > 0)
                      <small>{{ $p->progress['terisi'] }}/{{ $p->progress['total'] }}</small>
                      <div class="progress" style="height:5px">
                        <div class="progress-bar bg-{{ $p->progress['terisi'] >= $p->progress['total'] ? 'success' : 'warning' }}"
                             style="width: {{ $p->progress['total'] ? ($p->progress['terisi'] / $p->progress['total'] * 100) : 0 }}%"></div>
                      </div>
                    @else
                      <small class="text-muted">—</small>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

</div>
@endsection
