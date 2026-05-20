@extends('layouts/layoutMaster')

@section('title', 'Detail BA — ' . $ba->Tr_BA_Main_Code)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <div class="d-flex justify-content-between align-items-start mb-3">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Berita Acara /</span> Detail
      <br><code class="fs-6">{{ $ba->Tr_BA_Main_Code }}</code>
    </h4>
    <div>
      <a href="{{ route('berita-acara-v2.dashboard') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Dashboard
      </a>
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
      'WAITING_PELAKU'  => 'warning',
      'ACTION_PLANNING' => 'primary',
      'CLOSED'          => 'success',
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
