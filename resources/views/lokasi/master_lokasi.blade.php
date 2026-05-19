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
    <title>Master Lokasi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<title>
    Add Edit Lokasi
  </title>
</head>
<body>

<div class="container mt-2">

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
          <h2>Master Lokasi</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>
        <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Lokasi Code</th>
                  <th scope="col">Lokasi Desc</th>
                  <th scope="col">Kota</th>
                  <th scope="col">No Hp</th>
                  <th scope="col">Area Code</th>
                  <th scope="col">Company Code</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->lokasi_code }}</td>
                    <td>{{ $asset->lokasi_desc }}</td>
                    <td>{{ $asset->lokasi_kota }}</td>
                    <td>{{ $asset->no_hp }}</td>
                    <td>{{ $asset->area_code }}</td>
                    <td>{{ $asset->company_code }}</td>
                    <td>
                       <a href="javascript:void(0)" class="btn btn-warning edit" data-id="{{ $asset->id }}">Edit   </a>
                      <a href="javascript:void(0)" class="btn btn-danger delete" data-id="{{ $asset->id }}">Delete</a>
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

              {{--  <div class="form-group">
                <label class="col-sm-4 control-label">User</label>
                <div class="col-sm-12">  --}}
                  <input type="hidden" class="form-control" id="user_created" name="user_created"  value="{{ $user->name }}" required="" readonly>
                {{--  </div>
              </div>  --}}
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Lokasi Code</label>
                <div class="col-sm-12">
                  {{--  <input type="text" class="form-control" id="lokasi_code" name="lokasi_code"  value="" required="" >  --}}
                  <input type="text" name="lokasi_code" id="lokasi_code" class="form-control" readonly  value={{$lokasi['lokasi_code']}}>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Lokasi Desc</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="lokasi_desc" name="lokasi_desc"  value="" maxlength="50" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Kota / Kabupaten</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="lokasi_kota" name="lokasi_kota"  value="" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">No hp</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="no_hp" name="no_hp"  value="" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Area Code</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="area_code" name="area_code"  value="" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Company Code</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="company_code" name="company_code"  value="" required="">
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
       $('#ajaxBookModel').html("Add Detail Master Asset");
       $('#ajax-book-model').modal('show');
    });

    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-lokasi') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Detail Asset");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#lokasi_code').val(res.lokasi_code);
              $('#lokasi_desc').val(res.lokasi_desc);
              $('#lokasi_kota').val(res.lokasi_kota);
              $('#no_hp').val(res.no_hp);
              $('#area_code').val(res.area_code);
              $('#company_code').val(res.company_code);
           }
        });

    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-lokasi') }}",
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
          var lokasi_code = $("#lokasi_code").val();
          var lokasi_desc = $("#lokasi_desc").val();
          var lokasi_kota = $("#lokasi_kota").val();
          var no_hp = $("#no_hp").val();
          var area_code = $("#area_code").val();
          var company_code = $("#company_code").val();

          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-lokasi') }}",
            data: {
              id:id,
              lokasi_code:lokasi_code,
              lokasi_desc:lokasi_desc,
              lokasi_kota:lokasi_kota,
              no_hp:no_hp,
              area_code:area_code,
              company_code:company_code,
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
