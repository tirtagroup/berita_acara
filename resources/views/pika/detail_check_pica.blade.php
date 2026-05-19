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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Checking PICA</h4>

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

        <form action="/detail_check_temuan/{{$main_pica->Tr_PICA_Emp_h_Code }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row g-3">
            <input type="hidden" value="{{$main_pica->Tr_PICA_Emp_h_Code }}" class="form-control" required readonly />
            {{--  <div class="col-md-6">
                <h4><strong>1. Form PICA</strong></h4>
            </div>  --}}
            <div class="col-md-6 status-kejadian">
                <strong>Status Kejadian : <em>{{$main_pica->Status_PICA}}</em></strong>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">No BA</label>
                        <input type="text" value="{{$main_pica->NoBA }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Company</label>
                      <input type="text" value="{{$main_pica->Ms_Company }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Lokasi</label>
                     <input type="text" value="{{$main_pica->Ms_Location }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">User Input</label>
                      <input type="text" value="{{$main_pica->Emp_Code }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal PICA</label>
                      <input type="text" value="{{date_format(date_create($main_pica->created_at),"d/m/Y") }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Apakah Sudah Pernah Terjadi ?</label>
                    <input type="text" value="{{$main_pica->Apakah_Sudah_Pernah_Kejadian }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
                <div class="col-md-12">
                  <label class="form-label">Problem - Note</label>
                    <textarea class="form-control" readonly>{{$main_pica->Problem_Note }}</textarea>
              </div>
            </div>
            <h4>
              A. Problem Identification
            </h4>
            <table class="table table-striped table-bordered table-hover" id="myTable">
              <thead>
                <tr>
                  <th style="font-size: 10px;">Pertanyaan</th>
                  <th style="font-size: 10px;">Jawaban</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pertanyaan as $rowa)
                    <tr>
                      <td>{{$rowa->Tr_Pertanyaan }}</td>
                      <td>{{$rowa->Tr_Jawaban }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>

            <h4>B. Corrective Action</h4>

            <table class="table table-striped table-bordered table-hover" id="myTable">
              <thead>
                <tr>
                  <th style="font-size: 10px;">Tindakan Koreksi</th>
                  <th style="font-size: 10px;">Kapan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($action as $tes)
                    <tr>
                      <td>{{$tes->ApaYangAkanDilakukan }}</td>
                      <td>{{date_format(date_create($tes->Kapan),"d/m/Y") }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>

            <h4>C. Preventive Action</h4>

            <table class="table table-striped table-bordered table-hover" id="myTable">
              <thead>
                <tr>
                  <th style="font-size: 10px;">Tindakan Pencegahan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($preventive as $tesa)
                    <tr>
                      <td>{{$tesa->Tr_Preventive }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>

            <!-- Add more fields as needed following the same pattern -->
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
  .status-kejadian {
    background-color: #f0e80f; /* Ganti dengan warna yang kamu inginkan */
    padding: 20px;
    border-radius: 5px; /* Agar sudutnya lebih halus */
    font-weight: bold; /* Agar teks tetap tebal */
    font-style: italic; /* Agar teks miring */

    /* Menggunakan Flexbox untuk memusatkan konten */
    display: flex;
    justify-content: center;  /* Memusatkan secara horizontal */
    align-items: center;      /* Memusatkan secara vertikal */
    height: 60px;             /* Tinggi elemen agar terlihat lebih jelas */
    text-align: center;       /* Memastikan teks berada di tengah */
}

table {
  font-size: 10px;
}

th, td {
  padding: 5px !important;
  text-align: center;
  vertical-align: middle;
}

thead {
  background-color: #f0e80f;
  color: white;
}

tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

tbody tr:hover {
  background-color: #dcdcdc;
}


  /* Styling untuk gambar di sudut kanan atas */
</style>
@endsection
