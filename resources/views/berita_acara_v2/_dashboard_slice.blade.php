{{-- Partial: 1 slice dashboard (Overview atau per-konteks)
     $slice = array hasil dashboardSlice() di controller
     $tabId = string ID untuk chart elements
     $showAll = bool true bila ini overview tab (tampil donut konteks)
     $buName = (optional) nama BU untuk per-konteks tab
--}}

{{-- Summary card --}}
<div class="row mb-3">
  <div class="col-md-3 col-sm-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary">
              <i class="bx bx-file"></i>
            </span>
          </div>
          <div>
            <small class="text-muted d-block">Total BA</small>
            <h5 class="mb-0">{{ number_format($slice['total']) }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if ($showAll)
    @foreach (['LAKA', 'FNB', 'OP_HR', 'REVISI'] as $kode)
      @php $cnt = ($slice['perKonteks'][$kode] ?? 0); @endphp
      <div class="col-md-2 col-sm-6 mb-3">
        <div class="card">
          <div class="card-body p-3">
            <small class="text-muted d-block">{{ $kode }}</small>
            <h5 class="mb-0">{{ number_format($cnt) }}</h5>
            <small class="text-muted">{{ $slice['total'] > 0 ? round($cnt / $slice['total'] * 100, 1) : 0 }}%</small>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="col-md-9">
      <div class="alert alert-light">
        <strong>{{ $buName ?? '' }}</strong> — menampilkan data BA dengan konteks ini saja.
      </div>
    </div>
  @endif
</div>

{{-- Charts --}}
<div class="row">
  @if ($showAll)
    <div class="col-lg-6 mb-3">
      <div class="card">
        <div class="card-header"><h5 class="card-title m-0">Distribusi per Konteks</h5></div>
        <div class="card-body">
          <div id="chart-konteks-{{ $tabId }}"></div>
        </div>
      </div>
    </div>
  @endif

  <div class="col-lg-{{ $showAll ? '6' : '12' }} mb-3">
    <div class="card">
      <div class="card-header"><h5 class="card-title m-0">Trend BA per Hari</h5></div>
      <div class="card-body">
        <div id="chart-trend-{{ $tabId }}"></div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mb-3">
    <div class="card">
      <div class="card-header"><h5 class="card-title m-0">Top 10 Kategori</h5></div>
      <div class="card-body">
        <div id="chart-kategori-{{ $tabId }}"></div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mb-3">
    <div class="card">
      <div class="card-header"><h5 class="card-title m-0">Top 10 Cabang</h5></div>
      <div class="card-body">
        <div id="chart-cabang-{{ $tabId }}"></div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 mb-3">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Top 10 Opsi (deskripsi)</h5>
        <small class="text-muted">Opsi yang paling sering muncul di BA pada rentang ini.</small>
      </div>
      <div class="card-body">
        <div id="chart-opsi-{{ $tabId }}"></div>
      </div>
    </div>
  </div>
</div>

{{-- Recent BA --}}
<div class="card mb-3">
  <div class="card-header"><h5 class="card-title m-0">BA Terbaru ({{ $slice['recent']->count() }})</h5></div>
  <div class="table-responsive">
    <table class="table table-sm table-hover">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Kode BA</th>
          <th>Pelapor</th>
          <th>Pelaku</th>
          <th>Konteks</th>
          <th>Deskripsi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($slice['recent'] as $r)
          <tr>
            <td><small>{{ $r->Date_BA }}</small></td>
            <td>
              <a href="{{ route('berita-acara-v2.show', ['kode' => $r->kode]) }}" title="Lihat detail BA">
                <code class="small">{{ $r->kode }}</code>
              </a>
            </td>
            <td>
              <a href="{{ route('berita-acara-v2.list', ['pelapor' => $r->pelapor]) }}"
                 class="text-decoration-none" title="List BA dari pelapor ini">
                <small>{{ $r->pelapor }}</small>
              </a>
            </td>
            <td>
              <a href="{{ route('berita-acara-v2.list', ['emp_code' => $r->emp_code]) }}"
                 class="text-decoration-none" title="List BA dari pelaku ini">
                <small>
                  @if ($r->emp_name)
                    <strong>{{ $r->emp_name }}</strong><br>
                    <span class="text-muted">{{ $r->emp_code }}</span>
                  @else
                    {{ $r->emp_code }}
                  @endif
                </small>
              </a>
            </td>
            <td><span class="badge bg-label-primary">{{ $r->konteks }}</span></td>
            <td><small>{{ \Illuminate\Support\Str::limit($r->deskripsi, 60) }}</small></td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada BA pada rentang tanggal ini.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
