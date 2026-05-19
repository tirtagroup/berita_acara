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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection



@section('content')
<head>
    <meta charset="UTF-8">
    <title>Disiplin 3</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<title>
    Disiplin 3
  </title>
</head>
<body>

<div class="container mt-2">

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
          <h2>History Disiplin 2</h2>
        </div>
        <div class="col-md-12">
            <table id="dataTable4" class="display" style="width:100%">
              <thead>
                <tr>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Code</th>
                  <th scope="col">Periode</th>
                  <th scope="col">Last User Assas</th>
                  <th scope="col">Divisi</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($code_main as $tipe)
                <tr>
                    <td>{{ date_format(date_create($tipe->tanggal_1),"d/m/Y")}}</td>
                    <td>{{ $tipe->Tr_Job_Assesment_all_code }} </td>
                    <td>{{ $tipe->Ass_periode}}</td>
                    <td>{{ $tipe->Atasan_Code}}</td>
                    <td>{{ $tipe->ms_divisi}}</td>
                    <td>
                      <a href="/asasmen/detail_employee_disiplin3/{{ $tipe->Tr_Job_Assesment_all_code }}" class="btn btn-warning edit" data-id="{{ $tipe->Tr_Job_Assesment_all_code }}">Proccess</a>
                    </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Tanggal</th>
                  <th>Code</th>
                  <th>Periode</th>
                  <th>Last User Assas</th>
                  <th>Divisi</th>
                </tr>
            </tfoot>
            </table>
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
              {{--  <input type="hidden" class="form-control" id="user_created" name="user_created"  value="{{$user->name  }}" maxlength="50" placeholder="Auto Number" readonly>  --}}

              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">No. Report</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nomor_Report" name="nomor_Report" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">No. Polisi</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Pemilik</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="pemilik" name="pemilik"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Jenis</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="jenis" name="jenis"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Model</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="model" name="model"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Tahun</label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" id="tahun" name="tahun"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">No. Rangka</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">No. Mesin</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Warna TNKB</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="warna_tnkb" name="warna_tnkb"  value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label">Awal Masa Berlaku</label>
                <div class="col-sm-12">
                  <input type="date" class="form-control" id="awal_masa_berlaku" name="awal_masa_berlaku"  value="" required>
                  {{--  <input type="date" class="form-control" id="akhir_masa_berlaku" name="akhir_masa_berlaku"  value="" required>  --}}
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label">Akhir Masa Berlaku</label>
                <div class="col-sm-12">
                  {{--  <input type="date" class="form-control" id="awal_masa_berlaku" name="awal_masa_berlaku"  value="" required> Sampai  --}}
                  <input type="date" class="form-control" id="akhir_masa_berlaku" name="akhir_masa_berlaku"  value="" required>
                </div>
              </div>

              <center>
                <label for="" >Foto Report</label>
                        <br>
                        <div class="form-group">
                            <input  type="file" name="file_path" id="file" onchange="return validasiEkstensi()" >
                        </div>
                        <div id="feedback">
                </center>
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
       $('#ajaxBookModel').html("Add Master Report");
       $('#ajax-book-model').modal('show');
    });

    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-Report') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxBookModel').html("Edit Report");
              $('#ajax-book-model').modal('show');
              $('#id').val(res.id);
              $('#nomor_Report').val(res.nomor_Report);
              $('#nomor_polisi').val(res.nomor_polisi);
              $('#pemilik').val(res.pemilik);
              $('#jenis').val(res.jenis);
              $('#model').val(res.model);
              $('#tahun').val(res.tahun);
              $('#nomor_rangka').val(res.nomor_rangka);
              $('#nomor_mesin').val(res.nomor_mesin);
              $('#warna_tnkb').val(res.warna_tnkb);
              $('#file_path').val(res.file_path);
              $('#awal_masa_berlaku').val(res.awal_masa_berlaku);
              $('#akhir_masa_berlaku').val(res.akhir_masa_berlaku);
              $('#user_created').val(res.user_created);
              $('#created_at').val(res.created_at);
           }
        });
    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-Report') }}",
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
          var nomor_Report   = $("#nomor_Report").val();
          var nomor_polisi = $("#nomor_polisi").val();
          var pemilik = $("#pemilik").val();
          var jenis   = $("#jenis").val();
          var model = $("#model").val();
          var tahun = $("#tahun").val();
          var nomor_rangka   = $("#nomor_rangka").val();
          var nomor_mesin = $("#nomor_mesin").val();
          var warna_tnkb = $("#warna_tnkb").val();
          var awal_masa_berlaku   = $("#awal_masa_berlaku").val();
          var akhir_masa_berlaku = $("#akhir_masa_berlaku").val();
          var file_path = $("#file_path").val();
          var user_created = $("#user_created").val();
          var created_at = $("#created_at").val();

          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);

        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-Report') }}",
            data: {
              id:id,
              nomor_Report:nomor_Report,
              nomor_polisi:nomor_polisi,
              pemilik:pemilik,
              jenis:jenis,
              model:model,
              tahun:tahun,
              nomor_rangka:nomor_rangka,
              nomor_mesin:nomor_mesin,
              warna_tnkb:warna_tnkb,
              awal_masa_berlaku:awal_masa_berlaku,
              akhir_masa_berlaku:akhir_masa_berlaku,
              file_path:file_path,
              user_created:user_created,
              created_at:created_at,
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

<script>
  $(document).ready(function () {
    $('#dataTable4').DataTable({
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                });
        },
    });
});
</script>

<script>
  function validasiEkstensi(){
      var inputFile = document.getElementById('file');
      var pathFile = inputFile.value;
      var ekstensiOk = /(\.jpg|\.jpeg|\.png)$/i;
      if(!ekstensiOk.exec(pathFile)){
          alert('Silakan upload file dengan ekstensi .jpeg/.jpg/.png');
          inputFile.value = '';
          return false;
      }else{
          // Preview gambar
          if (inputFile.files && inputFile.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  document.getElementById('preview').innerHTML = '<img src="'+e.target.result+'" style="height:500px"/>';
              };
              reader.readAsDataURL(inputFile.files[0]);
          }
      }
  }
  </script>

@endsection
