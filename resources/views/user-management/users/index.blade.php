@extends('layouts/layoutMaster')

@section('title', 'User Management — Users')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3 d-flex justify-content-between align-items-center">
    <span><span class="text-muted fw-light">User Management /</span> Users</span>
    <div class="d-flex gap-2">
      <a href="{{ route('master.permission-matrix.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-grid-alt"></i> Permission Matrix
      </a>
      <a href="{{ route('master.user-level.index') }}" class="btn btn-sm btn-outline-info">
        <i class="bx bx-shield"></i> User Levels
      </a>
    </div>
  </h4>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Stat cards --}}
  <div class="row g-3 mb-3">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body p-3">
          <small class="text-muted">Total Users</small>
          <h4 class="mb-0 mt-1">{{ number_format($stats['total']) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-warning">
        <div class="card-body p-3">
          <small class="text-muted">Tanpa User Level <i class="bx bx-error text-warning"></i></small>
          <h4 class="mb-0 mt-1 text-warning">{{ number_format($stats['no_level']) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body p-3">
          <small class="text-muted">Nonaktif</small>
          <h4 class="mb-0 mt-1 text-muted">{{ number_format($stats['inactive']) }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Filter form --}}
  <div class="card mb-3">
    <div class="card-body py-3">
      <form method="GET" action="{{ route('user-management.users.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label small mb-1">Cari (nama / username / email)</label>
          <input type="text" name="q" value="{{ $search }}" class="form-control form-control-sm"
                 placeholder="ketik minimal 2 huruf...">
        </div>
        <div class="col-md-2">
          <label class="form-label small mb-1">Company</label>
          <select name="company" class="form-select form-select-sm">
            <option value="">— semua —</option>
            @foreach ($companies as $c)
              <option value="{{ $c }}" {{ $company === $c ? 'selected' : '' }}>{{ $c }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label small mb-1">Divisi</label>
          <select name="divisi" class="form-select form-select-sm">
            <option value="">— semua —</option>
            @foreach ($divisis as $d)
              <option value="{{ $d }}" {{ $divisi === $d ? 'selected' : '' }}>{{ $d }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label small mb-1">User Level</label>
          <select name="level_id" class="form-select form-select-sm">
            <option value="">— semua —</option>
            <option value="null" {{ $levelId === 'null' ? 'selected' : '' }}>(tidak ada level)</option>
            @foreach ($levels as $lv)
              <option value="{{ $lv->id }}" {{ (string) $levelId === (string) $lv->id ? 'selected' : '' }}>
                {{ $lv->nama }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1">
          <label class="form-label small mb-1">Status</label>
          <select name="aktif" class="form-select form-select-sm">
            <option value="" {{ $aktif === null ? 'selected' : '' }}>semua</option>
            <option value="1" {{ $aktif === '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $aktif === '0' ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>
        <div class="col-md-1 d-flex gap-1">
          <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-search"></i></button>
          <a href="{{ route('user-management.users.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>

  {{-- User list table --}}
  <div class="card">
    <div class="card-body table-responsive p-0">
      <table class="table table-sm align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th width="60">ID</th>
            <th>Nama / Username</th>
            <th>Email</th>
            <th>Company</th>
            <th>Divisi</th>
            <th>Role (legacy)</th>
            <th>User Level</th>
            <th width="80">Status</th>
            <th width="120">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $u)
            <tr>
              <td><small>{{ $u->id }}</small></td>
              <td>
                <strong>{{ $u->name ?: '(no name)' }}</strong>
                @if ($u->username && $u->username !== $u->name)
                  <br><small class="text-muted">@ {{ $u->username }}</small>
                @endif
              </td>
              <td><small>{{ $u->email }}</small></td>
              <td><small>{{ $u->ms_company ?: '—' }}</small></td>
              <td><small>{{ $u->ms_divisi ?: '—' }}</small></td>
              <td><small class="text-muted">{{ $u->role ?: '—' }}</small></td>
              <td>
                @if ($u->userLevel)
                  <span class="badge bg-label-primary">{{ $u->userLevel->nama }}</span>
                  @if ($u->userLevel->is_super)
                    <span class="badge bg-danger">SUPER</span>
                  @endif
                @else
                  <span class="badge bg-warning text-dark">tanpa level</span>
                @endif
              </td>
              <td>
                @if ($u->activate)
                  <span class="badge bg-success">Aktif</span>
                @else
                  <span class="badge bg-secondary">Nonaktif</span>
                @endif
              </td>
              <td>
                <a href="{{ route('user-management.users.edit', $u->id) }}"
                   class="btn btn-sm btn-outline-primary" title="Edit user-level + status">
                  <i class="bx bx-edit"></i>
                </a>
                <form action="{{ route('user-management.users.toggle-active', $u->id) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Toggle status user {{ $u->name }}?');">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-outline-warning"
                          title="Toggle active">
                    <i class="bx bx-power-off"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="text-center text-muted py-4">Tidak ada user yang match filter.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $users->links() }}
    </div>
  </div>

  <div class="alert alert-info small mt-3">
    <strong>Catatan:</strong>
    Edit di sini hanya untuk <code>user_level</code> + status <code>activate</code>.
    Reset password, ganti email, atau add user baru dilakukan via flow lain (self-service / IT admin / register form).
  </div>
</div>
@endsection
