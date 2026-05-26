@extends('layouts/layoutMaster')

@section('title', 'Mapping Konteks × Kategori')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span><span class="text-muted fw-light">Master /</span> Mapping Konteks × Kategori</span>
    @include('components._help_button', ['slug' => 'master-mapping'])
  </h4>

  <div class="alert alert-info">
    <strong>Cara pakai:</strong> Centang kotak untuk membuat kategori tersedia di konteks itu (form BA akan tampilkan kategori sebagai opsi). Uncheck untuk menghilangkan dari konteks itu.
    <br><small class="text-muted">Semua kategori yang muncul di form BA bersifat <em>opsional</em> — manager pilih manual sesuai kasus. Kalau perlu enforce "wajib pilih kategori X", tambah validasi bisnis di app layer.</small>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th>Kategori</th>
            @foreach ($konteksList as $k)
              <th class="text-center" style="min-width:120px">
                {{ $k->nama }}<br>
                <small class="text-muted">{{ $k->kode }}</small>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($kategori as $kat)
            <tr>
              <td>
                <strong>{{ $kat->nama }}</strong><br>
                <code class="small">{{ $kat->kode }}</code>
              </td>
              @foreach ($konteksList as $k)
                @php
                  $aktif = $mappings->has("{$k->id}_{$kat->id}");
                @endphp
                <td class="text-center">
                  <div class="form-check d-inline-block">
                    <input type="checkbox"
                           class="form-check-input mapping-toggle"
                           data-konteks="{{ $k->id }}"
                           data-kat="{{ $kat->id }}"
                           {{ $aktif ? 'checked' : '' }}>
                  </div>
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <span id="save-status" class="text-muted">Perubahan disimpan otomatis saat checkbox di-toggle.</span>
      <a href="{{ route('master.kategori.index') }}" class="btn btn-link float-end">← Kembali ke daftar kategori</a>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const csrf = '{{ csrf_token() }}';
    const url  = '{{ route('master.mapping.update') }}';
    const status = document.getElementById('save-status');

    document.querySelectorAll('.mapping-toggle').forEach(cb => {
      cb.addEventListener('change', async (e) => {
        const konteksId = e.target.dataset.konteks;
        const katId     = e.target.dataset.kat;
        const aktif     = e.target.checked ? '1' : '0';
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
              konteks_id: konteksId,
              kategori_id: katId,
              aktif: aktif,
            }),
          });
          const data = await res.json();
          if (data.ok) {
            status.textContent = 'Tersimpan (' + data.action + ' Konteks=' + konteksId + ' Kat=' + katId + ').';
            status.className = 'text-success';
            e.target.parentElement.classList.add('border-success');
            setTimeout(() => e.target.parentElement.classList.remove('border-success'), 1500);
          } else {
            throw new Error('Gagal simpan');
          }
        } catch (err) {
          status.textContent = 'ERROR: ' + err.message;
          status.className = 'text-danger';
          // Rollback checkbox state on error
          e.target.checked = !e.target.checked;
        }
      });
    });
  });
</script>
@endsection
