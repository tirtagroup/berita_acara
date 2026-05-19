<!DOCTYPE html>
<html lang="en">

@extends('layouts/layoutMaster')

@section('title', 'Horizontal Layouts - Forms')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
@endsection

@section('content')
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 card-header text-center font-weight-bold">
            <h2>Master Kasus Berita Acara</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2">
            <button type="button" id="addNewBook" class="btn btn-success">Add +</button>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Code</th>
                        <th scope="col">Detail_Desc</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $tipe)
                    <tr>
                        <td>{{ $tipe->id }}</td>
                        <td>{{ $tipe->Ms_Kasus_Detail_Code }}</td>
                        <td>{{ $tipe->Detail_Desc }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-warning edit" data-id="{{ $tipe->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger delete" data-id="{{ $tipe->id }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="ajax-book-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addEditBookForm" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="rec_usercreated">Operator</label>
                        <input type="text" class="form-control" id="rec_usercreated" name="rec_usercreated" value="{{$user->name}}" maxlength="50" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ms_jenis_ba_code">Code</label>
                        <input type="text" class="form-control" id="ms_jenis_ba_code" name="ms_jenis_ba_code" placeholder="Auto Number" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kasus">Nama Kasus</label>
                        <div id="kasus-container"></div>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Kasus</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Isi Detail Kasus.." required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Bootstrap Modal -->

@section('page-script')
<script src="{{ asset('assets/js/form-layouts.js') }}"></script>
<script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    loadCheckboxes();

    // Setup CSRF token untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addNewBook').click(function () {
        $('#addEditBookForm').trigger("reset");
        $('#ajaxBookModel').html("Add Kasus BA");
        $('#ajax-book-model').modal('show');
        loadCheckboxes(); // Memuat checkbox saat modal dibuka
    });

    $('body').on('click', '.edit', function () {
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "{{ url('edit-kasus') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                $('#ajaxBookModel').html("Edit Kasus BA");
                $('#ajax-book-model').modal('show');
                $('#id').val(res.id);
                $('#ms_jenis_ba_code').val(res.ms_jenis_ba_code);
                $('#description').val(res.description);
                $('#rec_usercreated').val(res.rec_usercreated);

                // Set nilai checkbox
                $('input[name="ms_kasus[]"]').each(function() {
                    $(this).prop('checked', res.ms_kasus.includes($(this).val()));
                });
            }
        });
    });

    $('body').on('click', '.delete', function () {
        if (confirm("Delete Record?")) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ url('delete-kasus') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    window.location.reload();
                }
            });
        }
    });

    $('body').on('submit', '#addEditBookForm', function (event) {
        event.preventDefault();
        var id = $("#id").val();
        var ms_jenis_ba_code = $("#ms_jenis_ba_code").val();
        var description = $("#description").val();
        var rec_usercreated = $("#rec_usercreated").val();
        var ms_kasus = $('input[name="ms_kasus[]"]:checked').map(function() {
            return $(this).val();
        }).get(); // Ambil nilai dari checkbox yang terpilih

        $("#btn-save").html('Please Wait...').attr("disabled", true);

        $.ajax({
            type: "POST",
            url: "{{ url('add-update-kasus') }}",
            data: {
                id: id,
                ms_kasus: ms_kasus,
                ms_jenis_ba_code: ms_jenis_ba_code,
                description: description,
                rec_usercreated: rec_usercreated,
            },
            dataType: 'json',
            success: function(res) {
                window.location.reload();
            },
            error: function(xhr) {
                console.error(xhr);
                $("#btn-save").html('Submit').attr("disabled", false);
            }
        });
    });

    function loadCheckboxes() {
        const cases = [
            { value: "Fraud", text: "Fraud" },
            { value: "Tidak Fraud", text: "Tidak Fraud" },
            { value: "Pelanggaran SOP", text: "Pelanggaran SOP" },
            { value: "Perubahan SOP", text: "Perubahan SOP" },
            { value: "Salah Isi", text: "Salah Isi" },
            { value: "Indisiplinier", text: "Indisiplinier" },
            { value: "Laka", text: "Laka" },
            { value: "Kerusakan", text: "Kerusakan" },
            { value: "Tolak Tugas", text: "Tolak Tugas" },
            { value: "Barang Hilang", text: "Barang Hilang" },
            { value: "Ketinggian Solar", text: "Ketinggian Solar" },
            { value: "Lain-Lain", text: "Lain-Lain" },
            @foreach ($ms_kasus as $case)
            { value: "{{$case->description}}", text: "{{$case->description}}", disabled: true },
            @endforeach
        ];

        let checkboxHtml = '';
        cases.forEach(function(caseItem) {
            checkboxHtml += `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ms_kasus[]" value="${caseItem.value}" id="${caseItem.value}" ${caseItem.disabled ? 'disabled' : ''}>
                    <label class="form-check-label" for="${caseItem.value}">
                        ${caseItem.text}
                    </label>
                </div>
            `;
        });
        $('#kasus-container').html(checkboxHtml);
    }
});
</script>
@endsection
@endsection

</html>
