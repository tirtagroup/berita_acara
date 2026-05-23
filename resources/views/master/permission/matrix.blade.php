@extends('layouts/layoutMaster')

@section('title', 'Permission Matrix')

@section('content')
@php
  $modulColor = ['BA' => 'primary', 'PICA' => 'warning', 'MASTER' => 'info', 'HELP' => 'success', 'UMUM' => 'secondary'];
  $scopeColor = ['all' => 'success', 'own' => 'warning', 'participant' => 'info', 'division' => 'primary', 'none' => 'secondary'];
@endphp

<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span><span class="text-muted fw-light">Master /</span> Permission Matrix</span>
    <div class="d-flex gap-2">
      <a href="{{ route('master.user-level.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-user"></i> User Levels
      </a>
      <a href="{{ route('master.panel.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-window"></i> Panels
      </a>
    </div>
  </h4>

  <div class="alert alert-info small">
    Atur permission per <strong>level</strong>. Tiap row = panel, tiap col = action.
    Pilih dropdown scope: <span class="badge bg-success">all</span> bisa apa saja,
    <span class="badge bg-warning">own</span> hanya milik sendiri,
    <span class="badge bg-info">participant</span> hanya PICA yg dia ikut,
    <span class="badge bg-secondary">none</span> tidak boleh action ini.
    <strong>Auto-save</strong> saat dropdown diubah.
  </div>

  {{-- Level selector --}}
  <div class="card mb-3">
    <div class="card-body py-2">
      <form method="GET" class="d-flex gap-2 align-items-end">
        <div class="flex-grow-1">
          <label class="form-label small mb-1">Pilih User Level untuk di-edit:</label>
          <select name="level_id" class="form-select" onchange="this.form.submit()">
            @foreach ($levels as $l)
              <option value="{{ $l->id }}" {{ $levelId == $l->id ? 'selected' : '' }}>
                {{ $l->kode }} — {{ $l->nama }}
                @if ($l->is_super) [SUPER] @endif
              </option>
            @endforeach
          </select>
        </div>
        <div>
          @if ($currentLevel && $currentLevel->is_super)
            <span class="badge bg-danger fs-6">SUPER ADMIN — bypass semua check</span>
          @endif
        </div>
      </form>
    </div>
  </div>

  @if (!$currentLevel)
    <div class="alert alert-warning">Pilih level dulu.</div>
  @else

  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-bordered table-sm align-middle mb-0">
        <thead class="table-light sticky-top" style="z-index:5">
          <tr>
            <th style="min-width:220px">Panel</th>
            <th style="min-width:80px">Modul</th>
            @foreach ($actions as $a)
              <th class="text-center" style="min-width:110px">
                {{ ucfirst($a->kode) }}
                <i class="bx bx-info-circle text-muted small" title="{{ $a->deskripsi }}"></i>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @php $currentModul = null; @endphp
          @foreach ($panels as $p)
            @if ($currentModul !== $p->modul)
              @php $currentModul = $p->modul; @endphp
              <tr class="table-light">
                <td colspan="{{ 2 + $actions->count() }}" class="fw-bold">
                  <span class="badge bg-{{ $modulColor[$p->modul] ?? 'secondary' }} me-1">{{ $p->modul }}</span>
                  Modul {{ $p->modul }}
                </td>
              </tr>
            @endif

            @php
              $availableScopes = $p->scopable && !empty($p->supported_scopes)
                ? array_merge($p->supported_scopes, ['none'])
                : ['all', 'none'];
            @endphp

            <tr>
              <td>
                @if ($p->icon)<i class="bx {{ $p->icon }} text-muted small me-1"></i>@endif
                <strong>{{ $p->nama }}</strong><br>
                <small><code>{{ $p->kode }}</code></small>
                @if ($p->url)
                  <br><small class="text-muted">{{ $p->url }}</small>
                @endif
              </td>
              <td>
                <span class="badge bg-label-{{ $modulColor[$p->modul] ?? 'secondary' }}">{{ $p->modul }}</span>
                @if ($p->scopable)
                  <br><small class="badge bg-info small">scopable</small>
                @endif
              </td>
              @foreach ($actions as $a)
                @php
                  $key = "{$p->id}_{$a->id}";
                  $perm = $perms[$key] ?? null;
                  $currentScope = $perm ? $perm->scope : 'none';
                @endphp
                <td class="text-center">
                  <select class="form-select form-select-sm perm-cell"
                          data-panel="{{ $p->id }}"
                          data-action="{{ $a->id }}"
                          style="min-width:90px">
                    @foreach ($availableScopes as $scope)
                      <option value="{{ $scope }}" {{ $currentScope === $scope ? 'selected' : '' }}>
                        {{ $scope }}
                      </option>
                    @endforeach
                  </select>
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
      <span id="save-status" class="text-muted small">Auto-save saat dropdown diubah.</span>
      <small class="text-muted">{{ $panels->count() }} panel × {{ $actions->count() }} action</small>
    </div>
  </div>
  @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const csrf      = '{{ csrf_token() }}';
  const url       = '{{ route('master.permission-matrix.update') }}';
  const levelId   = {{ $levelId ?? 0 }};
  const statusEl  = document.getElementById('save-status');

  document.querySelectorAll('.perm-cell').forEach(sel => {
    sel.addEventListener('change', async (e) => {
      const panelId  = e.target.dataset.panel;
      const actionId = e.target.dataset.action;
      const scope    = e.target.value;

      statusEl.textContent = 'Menyimpan...';
      statusEl.className = 'small text-info';
      e.target.disabled = true;

      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
          body: new URLSearchParams({ _token: csrf, level_id: levelId, panel_id: panelId, action_id: actionId, scope: scope }),
        });
        const data = await res.json();
        if (!data.ok) throw new Error('Save gagal');
        statusEl.textContent = `Tersimpan (${data.action} scope=${scope})`;
        statusEl.className = 'small text-success';
      } catch (err) {
        statusEl.textContent = 'ERROR: ' + err.message;
        statusEl.className = 'small text-danger';
      } finally {
        e.target.disabled = false;
      }
    });
  });
});
</script>
@endsection
