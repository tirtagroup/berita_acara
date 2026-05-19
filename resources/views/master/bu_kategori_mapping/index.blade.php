@extends('layouts/layoutMaster')

@section('title', 'Mapping BU × Kategori')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master /</span> Mapping Business Unit × Kategori
  </h4>

  <div class="alert alert-info">
    <strong>Keterangan level:</strong>
    <span class="badge bg-danger">Wajib</span> auto-check di form BA dan tidak bisa di-uncheck.
    <span class="badge bg-warning text-dark">Disarankan</span> ditonjolkan di form, tapi user boleh skip.
    <span class="badge bg-secondary">Opsional</span> tersedia tapi tidak ditonjolkan.
    <span class="badge bg-light text-dark">— (None)</span> tidak relevan, hide dari form.
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th>Kategori</th>
            @foreach ($businessUnits as $bu)
              <th class="text-center" style="min-width:140px">
                {{ $bu->nama }}<br>
                <small class="text-muted">{{ $bu->kode }}</small>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($kategori as $k)
            <tr>
              <td>
                <strong>{{ $k->nama }}</strong><br>
                <code class="small">{{ $k->kode }}</code>
              </td>
              @foreach ($businessUnits as $bu)
                @php
                  $m = $mappings->get("{$bu->id}_{$k->id}");
                  $level = $m?->level ?? 'none';
                @endphp
                <td class="text-center">
                  <select class="form-select form-select-sm mapping-level"
                          data-bu="{{ $bu->id }}"
                          data-kat="{{ $k->id }}">
                    <option value="none"       {{ $level === 'none'       ? 'selected' : '' }}>—</option>
                    <option value="wajib"      {{ $level === 'wajib'      ? 'selected' : '' }}>Wajib</option>
                    <option value="disarankan" {{ $level === 'disarankan' ? 'selected' : '' }}>Disarankan</option>
                    <option value="opsional"   {{ $level === 'opsional'   ? 'selected' : '' }}>Opsional</option>
                  </select>
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <span id="save-status" class="text-muted">Perubahan disimpan otomatis saat dropdown diubah.</span>
      <a href="{{ route('master.kategori.index') }}" class="btn btn-link float-end">← Kembali ke daftar kategori</a>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const csrf = '{{ csrf_token() }}';
    const url  = '{{ route('master.mapping.update') }}';
    const status = document.getElementById('save-status');

    document.querySelectorAll('.mapping-level').forEach(sel => {
      sel.addEventListener('change', async (e) => {
        const buId  = e.target.dataset.bu;
        const katId = e.target.dataset.kat;
        const level = e.target.value;
        status.textContent = 'Menyimpan...';
        status.className = 'text-info';

        try {
          const res = await fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
              'X-CSRF-TOKEN': csrf,
              'Accept': 'application/json',
            },
            body: new URLSearchParams({
              _token: csrf,
              bu_id: buId,
              kategori_id: katId,
              level: level,
            }),
          });
          const data = await res.json();
          if (data.ok) {
            status.textContent = 'Tersimpan (' + data.action + ' BU=' + buId + ' Kat=' + katId + ').';
            status.className = 'text-success';
            e.target.classList.add('border-success');
            setTimeout(() => e.target.classList.remove('border-success'), 1500);
          } else {
            throw new Error('Gagal simpan');
          }
        } catch (err) {
          status.textContent = 'ERROR: ' + err.message;
          status.className = 'text-danger';
        }
      });
    });
  });
</script>
@endsection
