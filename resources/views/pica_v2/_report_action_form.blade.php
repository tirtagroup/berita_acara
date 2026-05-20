{{-- Reusable form untuk D (corrective) atau E (preventive) action rows --}}
<form method="POST" action="{{ route('pica-v2.report.actions', ['kode' => $kode]) }}">
  @csrf
  <input type="hidden" name="tipe" value="{{ $tipe }}">

  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div>
        <strong>{{ $label }}</strong>
        <small class="text-muted">{{ $desc }}</small>
      </div>
      @if (!$isReadOnly)
        <button type="button" class="btn btn-sm btn-outline-primary btn-add-action" data-tipe="{{ $tipe }}">
          <i class="bx bx-plus"></i> Tambah row
        </button>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead class="table-light">
            <tr>
              <th width="40">#</th>
              <th width="30%">Deskripsi</th>
              <th width="180">PIC</th>
              <th width="130">Deadline</th>
              <th width="130">Status</th>
              <th>Notes</th>
              <th width="50"></th>
            </tr>
          </thead>
          <tbody id="actions-body-{{ $tipe }}">
            @forelse ($actions as $i => $a)
              <tr class="action-row">
                <td class="text-center">{{ $i + 1 }}</td>
                <td>
                  <textarea name="actions[{{ $i }}][deskripsi]" rows="2" maxlength="1000"
                    class="form-control form-control-sm"
                    {{ $isReadOnly ? 'readonly' : '' }}>{{ $a->deskripsi }}</textarea>
                </td>
                <td>
                  <select name="actions[{{ $i }}][pic_user_id]" class="form-select form-select-sm action-pic-select"
                    {{ $isReadOnly ? 'disabled' : '' }} style="width:100%">
                    <option value=""></option>
                    @if ($a->pic_user_id)
                      <option value="{{ $a->pic_user_id }}" selected>
                        {{ $a->pic_username }} — {{ $a->pic_name }}
                      </option>
                    @endif
                  </select>
                </td>
                <td>
                  <input type="date" name="actions[{{ $i }}][deadline]" class="form-control form-control-sm"
                    value="{{ $a->deadline }}" {{ $isReadOnly ? 'readonly' : '' }}>
                </td>
                <td>
                  <select name="actions[{{ $i }}][status]" class="form-select form-select-sm"
                    {{ $isReadOnly ? 'disabled' : '' }}>
                    @foreach (['pending'=>'Pending','in_progress'=>'In Progress','done'=>'Done','cancelled'=>'Cancelled'] as $v => $l)
                      <option value="{{ $v }}" {{ $a->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                  </select>
                </td>
                <td>
                  <input type="text" name="actions[{{ $i }}][notes]" class="form-control form-control-sm"
                    value="{{ $a->notes }}" maxlength="1000" {{ $isReadOnly ? 'readonly' : '' }}>
                </td>
                <td>
                  @if (!$isReadOnly)
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-action"><i class="bx bx-trash"></i></button>
                  @endif
                </td>
              </tr>
            @empty
              <tr class="text-muted text-center"><td colspan="7" class="py-3">Belum ada action — klik "Tambah row".</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if (!$isReadOnly)
        <div class="d-flex justify-content-end">
          <button class="btn btn-primary"><i class="bx bx-save"></i> Simpan {{ $tipe }}</button>
        </div>
      @endif
    </div>
  </div>
</form>
