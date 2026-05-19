@extends('layouts/layoutMaster')

@section('title', 'Horizontal Layouts - Forms')

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
<!-- Custom Script for DataTables and other dependencies -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection

<title>
    Check Temuan
</title>

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Checking Kejadian-Temuan</h4>

<div class="row">
  <!-- Kolom Kiri - Detail Kejadian -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">x</button>
          <strong>{{ $message }}</strong>
        </div>
        @endif

        <form action="/detail_check_temuan/{{$main_ba->Tr_BA_Main_Code }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">
            <input type="hidden" value="{{$main_ba->Tr_BA_Main_Code }}" class="form-control" required readonly />

            <!-- Bagian kolom detail kejadian -->
            <div class="col-md-4">
              <label class="form-label fw-bold">Date Input</label>
              <input type="text" value="{{$main_ba->created_at->format('d_m-Y') }}" class="form-control" readonly />
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Date Peristiwa</label>
              <input type="text" value="{{$main_ba->Date_BA }}" class="form-control" readonly />
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Company</label>
              <input type="text" value="{{$main_ba->rec_comcode }}" class="form-control" readonly />
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Lokasi</label>
              <input type="text" value="{{$main_ba->rec_areacode }}" class="form-control" readonly />
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold" for="collapsible-phone">Pelapor</label>
              <input type="text" value="{{$main_ba->Ms_Emp_Code }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold" for="collapsible-phone">Divisi Pelapor</label>
              <input type="text" value="{{$main_ba->Ms_Emp_Div }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold" for="collapsible-phone">Pelaku</label>
              <input type="text" value="{{$main_ba->Ms_Emp_Code }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold" for="collapsible-phone">Divisi Pelaku</label>
              <input type="text" value="{{$main_ba->Ms_Emp_Div }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold" for="collapsible-phone">Kategori</label>
              <input type="text" value="{{$main_ba->Ms_BA_type_Code }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold" for="collapsible-phone">Kasus</label>
              <input type="text" value="{{$main_ba->Ms_Kasus }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold" for="collapsible-phone">Detail Kasus</label>
              <input type="text" value="{{$main_ba->MS_Detail_Kasus }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <div class="col-md-12">
              <label class="form-label fw-bold" for="collapsible-phone">Note</label>
              <input type="text" value="{{$main_ba->BA_Desc }}" id="collapsible-fullname" class="form-control" readonly/>
            </div>
            <!-- Add more fields as needed following the same pattern -->

            <center>
              <h3>Kronologi</h3>
            </center>
            <table class="table table-bordered mt-4">
              <thead>
                <tr>
                  <td>{{$ba_kronologi->kronlogi}}</td>
                </tr>
              </thead>
            </table>

            <br>
            <center>
              <h3>Dokumen</h3>
            </center>
            <table class="table table-bordered mt-4">
              <thead>
                <tr>
                  <th>Dokumen Pendukung</th>
                  <th>Dokumen Pendukung</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    @if($dok1 == '')
                    <img width="100" height="130" src="{{ asset('nophoto.png') }}">
                    @else
                    <img width="250" height="130" src="{{ asset($dok1->file_path) }}">
                    @endif
                  </td>
                  <td>
                    @if($dok2 == '')
                    <img width="100" height="130" src="{{ asset('nophoto.png') }}">
                    @else
                    <img width="250" height="130" src="{{ asset($dok2->file_path2) }}">
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan - Komentar -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h5>Komentar</h5>
      </div>
      <div class="card-body">
        <!-- Loop untuk menampilkan komentar yang sudah ada -->

        <div class="chat-container" id="chat-container">
          <!-- Pesan akan muncul di sini -->
      </div>

        <!-- Form untuk menambah komentar baru -->
        {{--  <form action="/detail_check_temuan/{{$main_ba->Tr_BA_Main_Code}}" method="POST">  --}}
          {{--  @csrf  --}}
          <div class="mb-3">
            <label for="comment" class="form-label">Tambahkan Komentar:</label>
            <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
          </div>
          <button class="btn btn-warning" id="save_n">kirim</button>
          {{--  <button type="submit" class="btn btn-primary">Kirim</button>  --}}
        {{--  </form>  --}}
      </div>
    </div>
  </div>


<!-- DataTables Script Initialization -->
{{--  <script>
  $(document).ready(function() {
    $('#dataTable').DataTable({
      dom: 'Bfrtip',
      buttons: ['excel']
    });
  });
</script>  --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    const urlPath = window.location.pathname;
    const segments = urlPath.split('/');
    const kode = segments.pop();
    const decodedKode = decodeURIComponent(kode);

    console.log(decodedKode);
    load_note();
    function load_note() {

      const currentUser = '{{ $user}}';
      const code = $('#kode_ba').text();
      $.ajax({
          url: '/priority-note',
          method: 'GET',
          data: { code: decodedKode },
          success: function(response) {
              const chatContainer = $('#chat-container');
              chatContainer.empty();

              response.forEach(function(item) {
                  const isSent = item.created_by === currentUser;
                  const chatBubble = $('<div>').addClass('chat-bubble').addClass(isSent ? 'sent' : 'received');
                  const chatSender = $('<div>').addClass('chat-sender').text(item.Ms_User);
                  chatBubble.append(chatSender);
                  chatBubble.append($('<div>').text(item.Comment));

                  const chatTime = $('<div>').addClass('chat-time').text(
                      new Date(item.created_at).toLocaleString('id-ID', {
                          weekday: 'long',
                          year: 'numeric',
                          month: 'long',
                          day: 'numeric',
                          hour: '2-digit',
                          minute: '2-digit',
                          hour12: false
                      })
                  );
                  chatBubble.append(chatTime);
                  chatContainer.append(chatBubble);
              });
          }
      });
    }
    $("#save_n").click(function() {
        // s_prioritas
        // var status = $('input[name="prioritas"]:checked').val();
        var note = $('#comment').val();

        Swal.fire({
            title: 'Konfirmasi Transaksi?',
            text: "Konfirmasi perubahan prioritas?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loadingOverlay').show();
                $.ajax({
                    type: "POST",
                    url: '/add_prioritas_note',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        // status: status,
                        kode_ba: decodedKode,
                        note: note,
                        prioritas: $('#prioritas').text()
                    },
                    success: function(response) {
                        load_note();
                        $('#comment').val('');
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data telah berhasil dikirim',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                            willClose: () => {

                            }
                        });
                    },
                    error: function(xhr) {
                        $('#loadingOverlay').hide();
                        let errorMessage =
                            'Terjadi kesalahan saat mengirim data';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            errorMessage = '';
                            for (let field in errors) {
                                errorMessage += errors[field].join('\n') + '\n';
                            }
                        }

                        Swal.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error'
                        });
                        console.log("Error mengirim data", xhr);
                    }
                });
            }
        });
    });
  });
</script>
<style>
  /* Styling untuk chat bubble */
  .chat-container {
      display: flex;
      flex-direction: column;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: rgba(131, 149, 167, 0.4); /* Transparansi lebih tinggi */
      /* background-image: url('https://img.freepik.com/free-photo/old-fashioned-squared-shapes-texture_1194-5666.jpg?t=st=1730282158~exp=1730285758~hmac=72a1098afd7da6958548b247b2a4048740caa7b1a798db73418e19b92972aee3&w=740'); */
      background-repeat: repeat;
      background-size: cover;
      background-position: center;
      background-blend-mode: overlay;
      border-radius: 18px;
      overflow-y: auto;
      height: 400px;
      position: relative;
  }

  .chat-bubble {
      padding: 10px 15px;
      border-radius: 15px;
      margin: 5px 0;
      max-width: 90%;
  }

  .chat-bubble.sent {
      background-color: #f6faff;
      align-self: flex-end;
      color: #333;
  }

  .chat-bubble.received {
      background-color: #74b9ff;
      align-self: flex-start;
      color: rgb(246, 246, 246);
  }

  .chat-time,
  .chat-sender {
      font-size: 0.8em;
      color: rgb(79, 80, 83);
  }

  .chat-sender {
      font-weight: bold;
      margin-bottom: 5px;
  }

  .chat-time {
      text-align: right;
  }

  /* Styling untuk gambar di sudut kanan atas */
</style>
@endsection
