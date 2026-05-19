<!DOCTYPE html>
<html lang="en">

  @extends('layouts/layoutMaster')

  @section('title', ' Horizontal Layouts - Forms')

  @section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

  @endsection

  @section('vendor-script')
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

  @endsection

  @section('page-script')
  <script src="{{asset('assets/js/form-layouts.js')}}"></script>
  <script src="{{asset('assets/js/tables-datatables-basic.js')}}"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

  @endsection


  @section('content')
<head>
    <meta charset="UTF-8">
    <title>Master Kasus BA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<title>
  Master Kasus BA
  </title>
</head>
<body>

<div class="container mt-2">

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
          <h2>Master Kasus Berita Acara</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add +</button></div>
        <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Type</th>
                  <th scope="col">Code</th>
                  <th scope="col">Kasus</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $tipe)
                <tr>
                    <td>{{ $tipe->id }}</td>
                    <td>{{ $tipe->ms_type}}</td>
                    <td>{{ $tipe->ms_jenis_ba_code}}</td>
                    <td>{{ $tipe->description }}</td>
                    <td>
                       <a href="javascript:void(0)" class="btn btn-warning edit" data-id="{{ $tipe->id }}">&nbsp; Edit  &nbsp;</a>
                      <a href="javascript:void(0)" class="btn btn-danger delete" data-id="{{ $tipe->id }}">Delete</a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
             {{--  {!! $data->links() !!}  --}}
        </div>
    </div>
</div>

<!-- boostrap model -->
    <div class="modal fade" id="ajax-book-model" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxBookModel"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST">
              <input type="hidden" name="id" id="id">

              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Operator</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="rec_usercreated" name="rec_usercreated"  value="{{$user->name  }}" maxlength="50" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Type</label>
                <div class="col-sm-12">
                  <select class="form-control" name="ms_type" id="ms_type" >
                    <option value="Berita Acara">Berita Acara</option>
                    <option value="Request">Request</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Code</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="ms_jenis_ba_code" name="ms_jenis_ba_code"  value="{{$tipe->id +1  }}" maxlength="50" placeholder="Auto Number" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Nama Kasus</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="description" name="description" required>
                </div>
              </div>
              <div class="col-sm-offset-4 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->
<script type="text/javascript">
 $(document).ready(function($){

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addNewBook').click(function () {
       $('#addEditBookForm').trigger("reset");
       $('#ajaxBookModel').html("Add Kasus BA");
       $('#ajax-book-model').modal('show');
    });

    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-kasus') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Type");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#type_code').val(res.type_code);
              $('#ms_jenis_ba_code').val(res.ms_jenis_ba_code);
              $('#description').val(res.description);
              $('#rec_usercreated').val(res.rec_usercreated);
           }
        });
    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-kasus') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){

              window.location.reload();
           }
        });
       }

    });

    $('body').on('click', '#btn-save', function (event) {

          var id = $("#id").val();
          var ms_type   = $("#ms_type").val();
          var ms_jenis_ba_code   = $("#ms_jenis_ba_code").val();
          var description = $("#description").val();
          var rec_usercreated = $("#rec_usercreated").val();

          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-kasus') }}",
            data: {
              id:id,
              ms_type:ms_type,
              ms_jenis_ba_code:ms_jenis_ba_code,
              description:description,
              rec_usercreated:rec_usercreated,
            },
            dataType: 'json',
            success: function(res){
             window.location.reload();
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
           }
        });

    });

});
</script>
</body>
</html>

@endsection
