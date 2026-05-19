<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <center>
      <title>PICAPA ( Problem Identification, Corrective Action $ Preventive Action)</title>
    </center>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Inisialisasi Select2 -->
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih salah satu",
                allowClear: true
            });
        });
    </script>

    <script>
      function confirmSubmit() {
        Swal.fire({
          title: 'Apakah Anda yakin?'
          , text: 'Anda akan menyimpan data import ini, dan menyatakan data tersebut adalah orderan yang valid.'
          , icon: 'warning'
          , showCancelButton: true
          , confirmButtonText: 'Ya, Simpan'
          , cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            // Tampilkan loading Swal
            Swal.fire({
              title: 'Uploading Data...',
              text: 'Please wait while we process the file.',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });
            // Kirim form langsung setelah loading muncul
            // document.getElementById('import-form').submit();
          }
        });
      }
    </script>

    <script>
      $(document).ready(function() {
        $('#myTable, #myTable2, #myTable3').DataTable({
          "ordering": false,
          "searching": true,
          "paging": true,
          "lengthChange": false
        });
      });

      function addRow() {
        var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
        var rowCount = table.rows.length + 1; // Hitung jumlah baris untuk auto-number

        var newRow = table.insertRow();
        newRow.innerHTML = `
          <td>${rowCount}</td>
          <td><input type="text" class="form-control" name="pertanyaan[]" placeholder="Isi Pertanyaan.."</td>
          <td><input type="text" class="form-control" name="jawaban[]" placeholder="Isi Jawaban.."></td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Hapus</button></td>
        `;
      }

      function deleteRow(button) {
        var row = button.closest('tr');
        row.remove();

        // Perbarui nomor urut setelah penghapusan
        var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
          rows[i].cells[0].innerText = i + 1;
        }
      }

      function addRow2() {
        var table = document.getElementById("myTable2").getElementsByTagName('tbody')[0];
        var rowCount = table.rows.length + 1; // Hitung jumlah baris untuk auto-number

        var newRow = table.insertRow();
        newRow.innerHTML = `
          <td >${rowCount}</td>
          <td style="width: 1000px;"><input type="text" class="form-control" name="actions[]" placeholder="Tindakan-Tindakan Yang Akan Dikoreksi.." ></td>
          <td style="width: 100px;"><input type="date" class="form-control" name="kapan_dilakukan[]" ></td>
          <td style="font-size: 10px;"><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow2(this)">Hapus</button></td>
        `;
      }

      function deleteRow2(button) {
        var row = button.closest('tr');
        row.remove();

        // Perbarui nomor urut setelah penghapusan
        var table = document.getElementById("myTable2").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
          rows[i].cells[0].innerText = i + 1;
        }
      }

      function addRow3() {
        var table = document.getElementById("myTable3").getElementsByTagName('tbody')[0];
        var rowCount = table.rows.length + 1; // Hitung jumlah baris untuk auto-number

        var newRow = table.insertRow();
        newRow.innerHTML = `
          <td >${rowCount}</td>
          <td style="width: 1000px;"><input type="text" class="form-control" name="koreksi[]" placeholder="Langka-Langkah Pencegahan.." ></td>
          <td style="font-size: 10px;"><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow3(this)">Hapus</button></td>
        `;
      }

      function deleteRow3(button) {
        var row = button.closest('tr');
        row.remove();

        // Perbarui nomor urut setelah penghapusan
        var table = document.getElementById("myTable3").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
          rows[i].cells[0].innerText = i + 1;
        }
      }
    </script>

    <style>
          .form-container
          {
              border: 1px solid rgb(207, 207, 207);
              padding: 20px;
              border-radius: 10px;
              background-color: #f9f9f9;
          }
          .form-text
          {
              {{--  font-weight: bold;  --}}
              font-style: italic;
          }
          h2
          {
            text-align: center;
          }
          .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px) !important; /* Sama dengan form-control Bootstrap */
            padding: 0.375rem 0.75rem; /* Padding yang sama dengan input */
            border: 1px solid #ced4da; /* Menyesuaikan border */
            border-radius: 0.375rem; /* Border radius sesuai Bootstrap */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
          display: flex;
          align-items: left;
          justify-content: left;
          height: 100%;
          padding: 0;
          text-align: center;
              }


                .select2-container--default .select2-selection--single .select2-selection__arrow {
                    height: calc(2.25rem + 2px) !important; /* Menyesuaikan tinggi panah dropdown */
                }
                hr {
                  border-top: 2px solid #007bff; /* Warna biru */
                  margin-top: 20px;
                  margin-bottom: 20px;
              }
              thead {
                background-color: #6f42c1;
                color: white;
            }
            tbody tr:hover {
              background-color: #f1f1f1; /* Warna abu-abu muda */
          }
          table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(odd) {
          background-color: #f8f9fa; /* Warna abu-abu muda */
        }
        tbody tr:nth-child(even) {
          background-color: #ffffff; /* Warna putih */
        }
        .btn-danger {
          transition: 0.3s;
        }
        .btn-danger:hover {
          background-color: red;
          transform: scale(1.1);
        }


    </style>

</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-4">PICAPA ( Problem Identification, Corrective Action & Preventive Action)</h2>
        <div class="form-container">
          <form action="/save_pica" method="post" enctype="multipart/form-data">
            @csrf
                <h4>1. Problem Identification</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor BA</label>
                          <select class="form-control select2" name="no_ba" required>
                            <option value="">-- pilih code BA --</option>
                              @foreach ($tr_ba as $kodeba)
                                  <option value="{{$kodeba->Tr_BA_Main_Code}}">
                                      {{$kodeba->Tr_BA_Main_Code}}
                              @endforeach
                          </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <select class="form-control select2" name="Company_Code" required>
                          <option value="">-- pilih company --</option>
                            @foreach ($company as $pt)
                                <option value="{{$pt->description}}">
                                    {{$pt->description}}
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Lokasi</label>
                        <select class="form-control select2" name="Location_Code" required>
                          <option value="">-- pilih lokasi --</option>
                            @foreach ($lokasi as $branch)
                                <option value="{{$branch->lokasi_desc}}">
                                    {{$branch->lokasi_desc}}
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Operator</label>
                          <input type="text" name="siapa_salah" id="" class="form-control" value="{{$user->username}}" readonly>
                        <small class="form-text">*Individu atau tim yang bertanggung jawab</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kapan Terjadi</label>
                          <input type="date" class="form-control" name="kapan_terjadi">
                        <small class="form-text">*Waktu kejadian</small>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Apakah Sudah Pernah Kejadian</label>
                      <select class="form-select select2" name="pernah_kejadian">
                          <option value="">Pilih</option>
                          <option value="Sudah Pernah">Sudah Pernah</option>
                          <option value="Pertama">Pertama Kali</option>
                      </select>
                      <small class="form-text">*Pilih jika kejadian ini sudah pernah terjadi sebelumnya</small>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Problem/Note</label>
                      <textarea class="form-control" name="problem_note" required></textarea>
                      <small class="form-text">*Isi dengan catatan dari masalah atau kejadian tersebut</small>
                  </div>
                  </div>
                  <h4>Tabel Untuk Isi Pertanyaan</h4>
                      <div id="dynamic-container">
                        <div class="card-body">
                          <table class="table table-bordered table-hover" id="myTable">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Pertanyaan</th>
                                <th>Jawaban</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td><input type="text" class="form-control" placeholder="Contoh : Apa Yang Menyebabkan Kejadian ?" readonly></td>
                                <td><input type="text" class="form-control" placeholder="Contoh : Karena Driver Mengantuk" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Hapus</button></td>
                              </tr>
                            </tbody>
                          </table>
                          <button type="button" class="btn btn-primary btn-sm" onclick="addRow()"><i class="fa fa-plus"></i>Tambah Baris</button>
                        </div>
                      </div>

                <h4>2. Corrective Action</h4>
                <div id="dynamic-container">
                  <div class="card-body">
                    <table class="table table-bordered table-hover" id="myTable2">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Apa Yang Akan Dikoreksi</th>
                          <th>Kapan Koreksinya</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addRow2()"><i class="fa fa-plus"></i>Tambah Baris</button>
                  </div>
                </div>

                <h4>3. Preventive Action</h4>
                <div class="mb-3">
                  <div id="dynamic-container">
                    <div class="card-body">
                      <table class="table table-bordered table-hover" id="myTable3">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Tindakan Pencegahanya Apa</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                      <button type="button" class="btn btn-primary btn-sm" onclick="addRow3()"><i class="fa fa-plus"></i>Tambah Baris</button>
                    </div>
                  </div>
                </div>
                <button type="submit" onclick="confirmSubmit()"  class="btn btn-info"><i class="fa-regular fa-bookmark"></i> Submit</button>
            </form>
        </div>
    </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
