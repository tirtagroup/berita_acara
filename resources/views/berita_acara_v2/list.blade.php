@extends('layouts/layoutMaster')

@section('title', 'List BA (filtered)')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Berita Acara /</span> List
  </h4>

  @if (count($filterInfo) > 0)
    <div class="alert alert-info d-flex justify-content-between align-items-center">
      <div>
        <strong>Filter aktif:</strong>
        @foreach ($filterInfo as $info)
          <span class="badge bg-label-primary me-1">{{ $info }}</span>
        @endforeach
      </div>
      <a href="{{ route('berita-acara-v2.list') }}" class="btn btn-sm btn-outline-secondary">Clear Filter</a>
    </div>
  @endif

  {{-- Filter Form --}}
  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="{{ route('berita-acara-v2.list') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
          <label class="form-label">Pelaku (Emp Code)</label>
          <input type="text" name="emp_code" class="form-control" value="{{ $request->emp_code }}" placeholder="EMP00123">
        </div>
        <div class="col-md-3">
          <label class="form-label">Pelapor</label>
          <input type="text" name="pelapor" class="form-control" value="{{ $request->pelapor }}" placeholder="username">
        </div>
        <div class="col-md-2">
          <label class="form-label">Konteks</label>
          <select name="konteks" class="form-select">
            <option value="">— Semua —</option>
            <option value="LAKA"   {{ $request->konteks === 'LAKA' ? 'selected' : '' }}>LAKA</option>
            <option value="FNB"    {{ $request->konteks === 'FNB' ? 'selected' : '' }}>FNB</option>
            <option value="OP_HR"  {{ $request->konteks === 'OP_HR' ? 'selected' : '' }}>OP_HR</option>
            <option value="REVISI" {{ $request->konteks === 'REVISI' ? 'selected' : '' }}>REVISI</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Tgl Awal</label>
          <input type="date" name="tgl_awal" class="form-control" value="{{ $request->tgl_awal }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Tgl Akhir</label>
          <input type="date" name="tgl_akhir" class="form-control" value="{{ $request->tgl_akhir }}">
        </div>
        <div class="col-md-4">
          <label class="form-label">Kategori</label>
          <select name="kategori_id" class="form-select select2">
            <option value="">— Semua kategori —</option>
            @foreach ($kategoriList as $k)
              <option value="{{ $k->id }}" {{ $request->kategori_id == $k->id ? 'selected' : '' }}>
                {{ $k->nama }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-5">
          <label class="form-label">Opsi (cari deskripsi)</label>
          <select name="opsi_id" id="opsi-filter" class="form-select" style="width:100%">
            @if ($selectedOpsi)
              <option value="{{ $selectedOpsi->id }}" selected>{{ $selectedOpsi->deskripsi }}</option>
            @endif
          </select>
        </div>
        <div class="col-md-1">
          <label class="form-label">Per pg</label>
          <select name="per_page" class="form-select">
            <option value="10"  {{ $perPage == 10  ? 'selected' : '' }}>10</option>
            <option value="20"  {{ $perPage == 20  ? 'selected' : '' }}>20</option>
            <option value="50"  {{ $perPage == 50  ? 'selected' : '' }}>50</option>
            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100"><i class="bx bx-filter"></i> Filter</button>
        </div>
        <div class="col-12">
          <a href="{{ route('berita-acara-v2.list') }}" class="btn btn-sm btn-outline-secondary">Reset semua filter</a>
        </div>
      </form>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({ width: '100%' });
            $('#opsi-filter').select2({
              width: '100%',
              placeholder: 'Cari opsi (min 2 huruf)...',
              allowClear: true,
              minimumInputLength: 2,
              ajax: {
                url: '/api/opsi/search',
                dataType: 'json',
                delay: 300,
                data: function (params) { return { q: params.term }; },
                processResults: function (data) { return data; },
                cache: true,
              },
            });
          }
        });
      </script>
    </div>
  </div>

  {{-- Result --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0">Daftar BA ({{ $bas->total() }} total)</h5>
      <a href="{{ route('berita-acara-v2.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bx bx-arrow-back"></i> Dashboard
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover">
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
          @forelse ($bas as $r)
            <tr>
              <td><small>{{ $r->Date_BA }}</small></td>
              <td>
                <a href="{{ route('berita-acara-v2.show', ['kode' => $r->kode]) }}">
                  <code class="small">{{ $r->kode }}</code>
                </a>
              </td>
              <td>
                <a href="{{ route('berita-acara-v2.list', ['pelapor' => $r->pelapor]) }}" class="text-decoration-none">
                  <small>{{ $r->pelapor }}</small>
                </a>
              </td>
              <td>
                <a href="{{ route('berita-acara-v2.list', ['emp_code' => $r->emp_code]) }}" class="text-decoration-none">
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
              <td><small>{{ \Illuminate\Support\Str::limit($r->deskripsi, 80) }}</small></td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">
                Tidak ada BA yang match filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $bas->links() }}
    </div>
  </div>

</div>
@endsection
