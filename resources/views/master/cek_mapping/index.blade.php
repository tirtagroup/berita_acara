@extends('layouts/layoutMaster')

@section('title', 'Mapping Flag Legacy Cek* → Kategori')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">Master /</span> Mapping Flag Legacy Cek* → Kategori
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="alert alert-info small">
    <strong>Apa ini?</strong> Tabel ini memetakan flag <code>CekPelanggaran</code>, <code>CekLaka</code>, dst di BA legacy
    (<code>Tr_Ba_Main_New.Cek*</code>) ke kategori v2. Dipakai oleh artisan command:
    <pre class="mt-2 mb-0">php artisan ba:migrate-cek-flags --dry-run    # preview
php artisan ba:migrate-cek-flags --force      # eksekusi insert ke tr_ba_kategori_d</pre>
  </div>

  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Legacy Flag</th>
            <th>Mapped Kategori</th>
            <th>Opsi Kode</th>
            <th>Active</th>
            <th>Notes</th>
            <th width="60"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mappings as $m)
            <form method="POST" action="{{ route('master.cek-mapping.update', $m->id) }}">
              @csrf @method('PUT')
              <tr>
                <td><code>{{ $m->legacy_flag }}</code></td>
                <td>
                  <select name="kategori_kode" class="form-select form-select-sm" required>
                    @foreach ($kategori as $kat)
                      <option value="{{ $kat->kode }}" {{ $m->kategori_kode === $kat->kode ? 'selected' : '' }}>
                        {{ $kat->kode }} — {{ $kat->nama }}
                      </option>
                    @endforeach
                  </select>
                </td>
                <td>
                  <input type="text" name="opsi_kode" class="form-control form-control-sm"
                         value="{{ $m->opsi_kode }}" maxlength="50" placeholder="opsi_kode opsional">
                </td>
                <td>
                  <div class="form-check form-switch">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" value="1" class="form-check-input" {{ $m->active ? 'checked' : '' }}>
                  </div>
                </td>
                <td>
                  <input type="text" name="notes" class="form-control form-control-sm"
                         value="{{ $m->notes }}" maxlength="1000" placeholder="catatan...">
                </td>
                <td>
                  <button class="btn btn-sm btn-primary" type="submit" title="Simpan">
                    <i class="bx bx-save"></i>
                  </button>
                </td>
              </tr>
            </form>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
