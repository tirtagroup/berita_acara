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

@if (session('success'))
<div class="alert alert-primary">
  {{ session('success') }}
</div>
@endif

@endsection


{{--  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css"/>
    <title>Berita Acara</title>

    <style>
        /* CSS untuk border seluruh form */
        .form-container {
            border: 2px solid #ced4da;
            border-radius: 8px;
            padding: 30px;
            background-color: #f8f9fa;
            margin-top: 20px;
        }
        .form-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .select2-selection__rendered {
            line-height: calc(2.25rem + 2px);
        }
        .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
    </style>
</head>
<body>
    <div id="card" class="container">
        <center>
            <div class="logo">
                <img src="https://reportstaff.tirta-group.com/upload/logohgs.jpg" style="width:100px;height:70px;">
            </div>
        </center>
        <center><p>* Harap lengkapi semua data (lokasi, pelapor, divisi, pelaku, dan lain-lain)!</p></center>

        <!-- Mulai form container -->
        <div class="form-container">
            <div class="form-title">Form Berita Acara</div>
            <form action="/berita_acara_all" method="post" enctype="multipart/form-data">
              <div class="row">
                  <input type="hidden" name="Tr_BA_Code" class="form-control" readonly>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Tanggal Input</label>
                          <input type="text" name="rec_datecreated" class="form-control" value="2024-11-01" readonly>
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Tanggal Peristiwa * <em><strong>( wajib di isi )</strong></em></label>
                          <input type="date" name="Date_BA" class="form-control" required>
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Company</label>
                          <select class="form-control" name="Company_Code" required>
                             @foreach ($company as $pt)
                                <option value="{{$pt->description}}">
                                    {{$pt->description}}
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Lokasi</label>
                          <select class="form-control" name="Location_Code" required>
                            @foreach ($lokasi as $branch)
                                <option value="{{$branch->lokasi_desc}}">
                                    {{$branch->lokasi_desc}}
                            @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Pelapor</label>
                          <input type="text" name="BA_Admin" id="" class="form-control" value="{{$user->username}}" readonly>
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Divisi Pelapor</label>
                          <input type="text" name="Admin_Div" id="" class="form-control" value="{{$user->sub_divisi}}" readonly required>
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Pelaku <em><strong>( Isi nama pelaku atau yang bersangkutan )</strong></em></label>
                          <select name="User_Code" id="single" class="form-control" required>
                                @foreach ($users as $pelakunya)
                                  <option value="{{$pelakunya->emp_id}}">
                                  {{$pelakunya->emp_id}}
                                  </option>
                                @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-12 col-md-6">
                      <div class="form-group">
                          <label for="">Divisi Pelaku</label>
                          <select name="Division_Code" id="single3" class="form-control" required>
                            <option value="" style="weight:50px">Pilih Divisi Pelaku</option>
                            <option value="Approval_External" style="weight:50px">Approval_External</option>
                            <option value="Approval_internal" style="weight:50px">Approval_internal</option>
                            <option value="Account Renable" style="weight:50px">Account Renable</option>
                            <option value="Audit" style="weight:50px">Audit</option>
                            <option value="Business Development" style="weight:50px">Business Development</option>
                            <option value="Cashier" style="weight:50px">Cashier</option>
                            <option value="Checker Plant" style="weight:50px">Checker Plant</option>
                            <!--<option value="Coordinator" style="weight:50px">Coordinator</option>-->
                            <option value="Data Entry" style="weight:50px">Data Entry</option>
                            <option value="Direktur" style="weight:50px">Direktur</option>
                            <option value="Dispatcher" style="weight:50px">Dispatcher</option>
                            <option value="Driver" style="weight:50px">Driver</option>
                            <option value="General Manager" style="weight:50px">General Manager</option>
                            <option value="Gudang" style="weight:50px">Gudang</option>
                            <option value="helper" style="weight:50px">helper</option>
                            <option value="HR" style="weight:50px">HR</option>
                            <option value="IT Support" style="weight:50px">IT Support</option>
                            <option value="IT Jaringan" style="weight:50px">IT Jaringan</option>
                            <option value="Junior Mekanik" style="weight:50px">Junior Mekanik</option>
                            <option value="Kepala Gudang" style="weight:50px">Kepala Gudang</option>
                            <option value="Magang" style="weight:50px">Magang</option>
                            <option value="Manager" style="weight:50px">Manager</option>
                            <option value="Manager Finance" style="weight:50px">Manager Finance</option>
                            <option value="Mechanic" style="weight:50px">Mechanic</option>
                            <option value="Mechanic Group" style="weight:50px">Mechanic Group</option>
                            <option value="Mechanic Supervisor" style="weight:50px">Mechanic Supervisor</option>
                            <option value="Motoris" style="weight:50px">Motoris</option>
                            <option value="Operasional" style="weight:50px">Operasional</option>
                            <option value="Petrolman" style="weight:50px">Petrolman</option>
                            <option value="Pic Project" style="weight:50px">Pic Project</option>
                            <option value="IT Programmer" style="weight:50px">IT Programmer</option>
                            <option value="Purchasing" style="weight:50px">Purchasing</option>
                            <option value="Quality Control" style="weight:50px">Quality Control</option>
                            <option value="Sales" style="weight:50px">Sales</option>
                            <option value="Sales Taking Order" style="weight:50px">Sales Taking Order</option>
                            <option value="Security" style="weight:50px">Security</option>
                            <option value="Senior Mekanik" style="weight:50px">Senior Mekanik</option>
                            <option value="Service Officer" style="weight:50px">Service Officer</option>
                            <option value="Staff Finance" style="weight:50px">Staff Finance</option>
                            <option value="Staff Ga" style="weight:50px">Staff Ga</option>
                            <option value="Staff Senior Petrolman" style="weight:50px">Staff Senior Petrolman</option>
                            <!--<option value="Supervisor" style="weight:50px">Supervisor</option>-->
                            <option value="Supervisor Fleet" style="weight:50px">Supervisor Fleet</option>
                            <!--<option value="Umum" style="weight:50px">Umum</option>-->
                            <option value="SO Fleet" style="weight:50px">SO Fleet</option>
                            <option value="Petrollman" style="weight:50px">Petrollman</option>
                            <option value="Service Officer" style="weight:50px">Service Officer</option>
                            <option value="Koord. Service Officer" style="weight:50px">Koord. Service Officer</option>
                            <option value="Staff" style="weight:50px">Staff</option>
                            <option value="Leader" style="weight:50px">Leader</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label for="">Kasus</label>
                        <select name="ms_kasus[]" id="kasus" multiple class="form-control" required>
                            <option value="Fraud" data-group="1">Fraud</option>
                            <option value="Tidak Fraud" data-group="1">Tidak Fraud</option>
                            <option value="Pelanggaran SOP" data-group="2" disabled>Pelanggaran SOP</option>
                            <option value="Perubahan SOP" data-group="2" disabled>Perubahan SOP</option>
                            <option value="Salah Isi" data-group="3" disabled>Salah Isi</option>
                            <option value="Indisiplinier" data-group="3" disabled>Indisiplinier</option>
                            <option value="Laka" data-group="3" disabled>Laka</option>
                            <option value="Kerusakan" data-group="3" disabled>Kerusakan</option>
                            <option value="Tolak Tugas" data-group="3" disabled>Tolak Tugas</option>
                            <option value="Barang Hilang" data-group="3" disabled>Barang Hilang</option>
                            <option value="Ketinggian Solar" data-group="3" disabled>Ketinggian Solar</option>
                            <option value="Lain-Lain" data-group="3" disabled>Lain-Lain</option>
                            @foreach ($ms_kasus as $case)
                                <option value="{{$case->description}}" data-group="4" disabled>{{$case->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-12 col-md-12">
                      <div class="form-group">
                          <label for="">Kronologi: <em><strong>( terangkan kronologi kejadian )</strong></em></label>
                          <textarea cols="135" rows="10" name="kronlogi" class="form-control" required></textarea>
                      </div>
                  </div>
              </div>
            </div>
            </div>
              <center>
                  <label for="">Dokumen Pendukung</label>
                  <div class="form-group">
                      <input type="file" name="file_path" id="file" />
                  </div>
              </center>
              <center>
                  <label for="">Dokumen Pendukung Tambahan</label>
                  <div class="form-group">
                      <input type="file" name="file_path2" id="file2" />
                  </div>
              </center>
              <center>
                  <button class="btn btn-success" type="submit" name="send">Submit</button>
              </center>

      </div>
  </div>
</form>
        </div>
        <!-- Akhir form container -->

    </div>  --}}

    {{--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
      $(document).ready(function() {
          // Inisialisasi Select2
          $('#kasus').select2({
              placeholder: 'Pilih Beberapa Kasus',
              allowClear: true
          });

          // Event ketika opsi dipilih
          $('#kasus').on('change', function() {
              var selectedValues = $(this).val();

              // Loop setiap opsi
              $('#kasus option').each(function() {
                  var group = $(this).data('group');

                  // Jika opsi yang dipilih berada dalam suatu group, nonaktifkan seluruh opsi dalam group itu
                  selectedValues.forEach(function(val) {
                      var selectedGroup = $('#kasus option[value="' + val + '"]').data('group');
                      if (group === selectedGroup) {
                          $('#kasus option[data-group="' + selectedGroup + '"]').prop('disabled', true);
                      }
                  });
              });

              // Aktifkan opsi di kelompok berikutnya setelah opsi dari kelompok tertentu dipilih
              selectedValues.forEach(function(val) {
                  var group = $('#kasus option[value="' + val + '"]').data('group');
                  $('#kasus option[data-group="' + (group + 1) + '"]').prop('disabled', false);
              });

              // Refresh Select2 untuk memperbarui tampilan
              $('#kasus').select2('destroy').select2({
                  placeholder: 'Pilih Beberapa Kasus',
                  allowClear: true
              });
          });
      });
  </script>



    <script>
        $(document).ready(function() {
            $('#single, #single3').select2({
                placeholder: 'Pilih Divisi Pelaku',
                allowClear: true
            });
        });
    </script>
    <script>
      $(document).ready(function() {
          // Initialize Select2 with placeholder
          $('#single').select2({
              placeholder: 'Pilih Pelaku',
              allowClear: true
          });

          $('#single3').select2({
              placeholder: 'Pilih Divisi Pelaku',
              allowClear: true
          });

          $('#kasus').select2({
              placeholder: 'Pilih Beberapa Kasus',
              allowClear: true
          });

          $('#deskripsi').select2({
              placeholder: 'Pilih Deskripsi Kasus',
              allowClear: true
          });

          // Fungsi untuk reset select
          function resetSelect() {
              $('#single').val(null).trigger('change');
              $('#single3').val(null).trigger('change');
              $('#kasus').val(null).trigger('change');
              $('#deskripsi').val(null).trigger('change');
          }

          // Reset saat halaman di-refresh
          resetSelect();
      });
  </script>

</body>
</html>  --}}
