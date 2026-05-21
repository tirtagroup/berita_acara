@extends('layouts/layoutMaster')

@section('title', 'Mapping Opsi × Konteks')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span><span class="text-muted fw-light">Master /</span> Mapping Opsi × Konteks</span>
    <a href="{{ route('master.mapping.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bx bx-grid-alt"></i> Mapping Konteks × Kategori
    </a>
  </h4>

  <div class="alert alert-info small">
    <strong>Tag opsi langsung ke konteks.</strong>
    Wizard akan menampilkan opsi hanya bila konteks yang dipilih user match dengan tag di sini.
    1 opsi bisa di-tag ke multiple konteks (mis. "Alat rusak" bisa untuk LAKA + FNB + OP_HR).
    <span class="badge bg-success ms-1">☑</span> = aktif (opsi muncul di konteks ini).
    Klik checkbox untuk auto-save.
  </div>

  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-bordered table-sm align-middle mb-0">
        <thead class="table-light sticky-top" style="z-index:5">
          <tr>
            <th style="min-width:280px">Opsi (deskripsi)</th>
            <th style="min-width:200px">Parent kategori</th>
            @foreach ($konteksList as $k)
              <th class="text-center" style="min-width:120px">
                {{ $k->kode }}<br>
                <small class="text-muted fw-normal">{{ $k->nama }}</small>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @forelse ($opsi as $o)
            @php $taggedKonteks = $mappings->get($o->id, []); @endphp
            <tr>
              <td><strong>{{ $o->deskripsi }}</strong></td>
              <td>
                @forelse ($o->kategoris as $kat)
                  <span class="badge bg-label-secondary small">{{ $kat->kode }}</span>
                @empty
                  <small class="text-muted">— orphan —</small>
                @endforelse
              </td>
              @foreach ($konteksList as $k)
                <td class="text-center">
                  <div class="form-check d-inline-block">
                    <input type="checkbox" class="form-check-input opsi-konteks-toggle"
                           data-opsi="{{ $o->id }}"
                           data-konteks="{{ $k->id }}"
                           {{ in_array($k->id, $taggedKonteks) ? 'checked' : '' }}>
                  </div>
                </td>
              @endforeach
            </tr>
          @empty
            <tr>
              <td colspan="{{ 2 + $konteksList->count() }}" class="text-center text-muted py-4">
                Belum ada opsi aktif. Buat dulu di <a href="{{ route('master.opsi.index') }}">Master Opsi Global</a>.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
      <span id="save-status" class="text-muted small">Perubahan disimpan otomatis saat checkbox di-toggle.</span>
      <small class="text-muted">{{ $opsi->count() }} opsi × {{ $konteksList->count() }} konteks</small>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const csrf   = '{{ csrf_token() }}';
  const url    = '{{ route('master.opsi-mapping.update') }}';
  const status = document.getElementById('save-status');

  document.querySelectorAll('.opsi-konteks-toggle').forEach(cb => {
    cb.addEventListener('change', async (e) => {
      const opsiId    = e.target.dataset.opsi;
      const konteksId = e.target.dataset.konteks;
      const active    = e.target.checked ? 1 : 0;

      status.textContent = 'Menyimpan...';
      status.className = 'text-info small';
      e.target.disabled = true;

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
            opsi_id: opsiId,
            konteks_id: konteksId,
            active: active,
          }),
        });
        const data = await res.json();
        if (data.ok) {
          status.textContent = 'Tersimpan (' + data.action + ' opsi=' + opsiId + ' konteks=' + konteksId + ').';
          status.className = 'text-success small';
        } else {
          throw new Error('Gagal simpan');
        }
      } catch (err) {
        status.textContent = 'ERROR: ' + err.message;
        status.className = 'text-danger small';
        e.target.checked = !e.target.checked; // revert
      } finally {
        e.target.disabled = false;
      }
    });
  });
});
</script>
@endsection
