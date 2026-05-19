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
          <h2>Master Detail Kasus Berita Acara</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add +</button></div>
        <div class="col-md-12">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Ms Head Code</th>
                  <th scope="col">Code</th>
                  <th scope="col">Detail Kasus</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $tipe)
                <tr>
                    <td>{{ $tipe->id }}</td>
                    <td>{{ $tipe->ms_kasus_head1}}</td>
                    <td>{{ $tipe->ms_kasus_code}}</td>
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
                <label for="name" class="col-sm-4 control-label">Ms Head Code</label>
                <div class="col-sm-12">
                  <select class="form-control" name="ms_kasus_head1" id="ms_kasus_head1" >
                    <option value="03">BA Penghapusan</option>
                    <option value="18">Cancel Barang</option>
                    <option value="21">Edit Picking Otomatis</option>
                    <option value="15">Indispliner Absensi Driver</option>
                    <option value="12">Kehilangan Dokumen</option>
                    <option value="07">Kerusakan Armada</option>
                    <option value="23">Kerusakan Properti</option>
                    <option value="06">Kesalahan Sistem</option>
                    <option value="20">Maintenance</option>
                    <option value="03">Orderan Fiktif </option>
                    <option value="04">Pelanggaran SOP Mitra</option>
                    <option value="05">Pelanggaran SOP Staff</option>
                    <option value="29">Pembayaran Sewa</option>
                    <option value="14">Penambahan Asset</option>
                    <option value="16">Penambahan Titik Kordinasi</option>
                    <option value="25">Pengajuan Toko Bisa Order Kembali</option>
                    <option value="27">Pengisian Pulsa OM</option>
                    <option value="31">Pengisian Solar Tidak Sesuai SOP</option>
                    <option value="13">Perbaikan Asset</option>
                    <option value="26">PKWT Tidak Sesuai Jadwal</option>
                    <option value="01">Salah isi Dokumen</option>
                    <option value="28">Setoran Tidak Di Setorkan</option>
                    <option value="19">Staff Keluar</option>
                    <option value="24">Staff Masuk</option>
                    <option value="17">Temuan Produk NED</option>
                    <option value="30">Tidak Ada Struk</option>
                    <option value="22">Tilangan</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Code</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="ms_kasus_code" name="ms_kasus_code"  value="{{$tipe->id +1  }}" maxlength="50" placeholder="Auto Number" readonly>
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
       $('#ajaxBookModel').html("Add Detail Kasus BA");
       $('#ajax-book-model').modal('show');
    });

    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-detail_kasus_ba') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Type");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#ms_kasus_code').val(res.ms_kasus_code);
              $('#ms_kasus_head1').val(res.ms_kasus_head1);
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
            url: "{{ url('delete-detail_kasus_ba') }}",
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
          var ms_kasus_code   = $("#ms_kasus_code").val();
          var ms_kasus_head1   = $("#ms_kasus_head1").val();
          var description = $("#description").val();
          var rec_usercreated = $("#rec_usercreated").val();

          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-detail_kasus_ba') }}",
            data: {
              id:id,
              ms_kasus_code:ms_kasus_code,
              ms_kasus_head1:ms_kasus_head1,
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
