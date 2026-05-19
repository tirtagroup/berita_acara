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
    <title>Master Type</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<title>
    Add Edit Master Type
  </title>
</head>
<body>

<div class="container mt-2">

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
          <h2>Master Type</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add +</button></div>
        <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Code</th>
                  <th scope="col">Description</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $tipe)
                <tr>
                    <td>{{ $tipe->id }}</td>
                    <td>{{ $tipe->type_code}}</td>
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
                  <input type="text" class="form-control" id="user_created" name="user_created"  value="{{$user->name  }}" maxlength="50" placeholder="Auto Number" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Type Code</label>
                <div class="col-sm-12">
                  {{--  <input type="text" class="form-control" id="type_code" name="type_code" >  --}}
                  <input type="text" class="form-control" id="type_code" name="type_code"  value="{{$tipe->id +1  }}" maxlength="50" placeholder="Auto Number" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Type Desc</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="description" name="description"  value="" required="">
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
       $('#ajaxBookModel').html("Add Master Type");
       $('#ajax-book-model').modal('show');
    });

    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-type') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Type");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#type_code').val(res.type_code);
              $('#description').val(res.description);
              $('user_created').val(res.user_created);
           }
        });
    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-type') }}",
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
          var type_code   = $("#type_code").val();
          var description = $("#description").val();
          var user_created = $("#user_created").val();

          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-type') }}",
            data: {
              id:id,
              type_code:type_code,
              description:description,
              user_created:user_created,
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
