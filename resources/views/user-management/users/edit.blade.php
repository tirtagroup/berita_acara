@extends('layouts/layoutMaster')

@section('title', 'Edit User — ' . $user->name)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <h4 class="fw-bold py-3 mb-3">
    <span class="text-muted fw-light">User Management / Users /</span> Edit
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">User Info <small class="text-muted">(read-only)</small></h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-3"><small class="text-muted">ID</small></div>
            <div class="col-md-9"><code>{{ $user->id }}</code></div>

            <div class="col-md-3"><small class="text-muted">Nama</small></div>
            <div class="col-md-9"><strong>{{ $user->name ?: '(no name)' }}</strong></div>

            <div class="col-md-3"><small class="text-muted">Username</small></div>
            <div class="col-md-9"><small>{{ $user->username ?: '—' }}</small></div>

            <div class="col-md-3"><small class="text-muted">Email</small></div>
            <div class="col-md-9"><small>{{ $user->email ?: '—' }}</small></div>

            <div class="col-md-3"><small class="text-muted">Phone</small></div>
            <div class="col-md-9"><small>{{ $user->phone ?: '—' }}</small></div>

            <div class="col-md-3"><small class="text-muted">Company</small></div>
            <div class="col-md-9"><small>{{ $user->ms_company ?: '—' }}</small></div>

            <div class="col-md-3"><small class="text-muted">Branch</small></div>
            <div class="col-md-9"><small>{{ $user->ms_branch ?: '—' }}</small></div>

            <div class="col-md-3"><small class="text-muted">Divisi / Subdiv</small></div>
            <div class="col-md-9"><small>{{ $user->ms_divisi ?: '—' }} / {{ $user->sub_divisi ?: '—' }}</small></div>

            <div class="col-md-3"><small class="text-muted">Role (legacy)</small></div>
            <div class="col-md-9"><small class="text-muted">{{ $user->role ?: '—' }}</small></div>

            <div class="col-md-3"><small class="text-muted">Email verified</small></div>
            <div class="col-md-9">
              @if ($user->email_verified_at)
                <small class="text-success">{{ $user->email_verified_at }}</small>
              @else
                <small class="text-warning">— belum verified —</small>
              @endif
            </div>

            <div class="col-md-3"><small class="text-muted">Created</small></div>
            <div class="col-md-9"><small>{{ $user->created_at }}</small></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Assignment</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('user-management.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">User Level</label>
              <select name="level_id" class="form-select">
                <option value="">— tanpa level —</option>
                @foreach ($levels as $lv)
                  <option value="{{ $lv->id }}" {{ $user->level_id == $lv->id ? 'selected' : '' }}>
                    {{ $lv->nama }} ({{ $lv->kode }}){{ $lv->is_super ? ' — SUPER' : '' }}
                  </option>
                @endforeach
              </select>
              <small class="form-text text-muted">
                User level menentukan akses panel via Permission Matrix.
                <a href="{{ route('master.permission-matrix.index') }}">Lihat matrix</a>.
              </small>
            </div>

            <div class="mb-3 form-check form-switch">
              <input type="hidden" name="activate" value="0">
              <input class="form-check-input" type="checkbox" name="activate" value="1"
                     id="activate" {{ $user->activate ? 'checked' : '' }}>
              <label class="form-check-label" for="activate">Aktif</label>
              <div><small class="text-muted">User nonaktif tidak bisa login.</small></div>
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('user-management.users.index') }}" class="btn btn-outline-secondary">
                ← Kembali
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="alert alert-warning small mt-3">
        <strong>Tidak bisa di-edit di sini:</strong>
        password, email, nama, username. Itu via self-service user atau IT admin (security policy).
      </div>
    </div>
  </div>
</div>
@endsection
