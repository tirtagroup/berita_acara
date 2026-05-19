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
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<head>
<link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
<title>
    Monthly
  </title>
</head>


<div class="container">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Monthly History</h4>
   <li class="nav-item dropdown">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Periode
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="list_report_all_history_new_perday">Daily</a>
              <a class="dropdown-item" href="list_report_all_history_new_weekly">Weekly</a>
              <a class="dropdown-item" href="list_report_all_history_new_monthly">Monthly</a>
          </div>
</div>
    <hr>
    <h4>Januari</h4>
<div class="row">
        <div class="panel panel-primary filterable">
            <table class="table" id="dataTable">
                <thead>
                  <tr >
                      {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
                  </tr>
              </thead>
              <thead>
                <tr class="filters">
                </tr>
            </thead>
                <tbody>
                  @foreach($januari as $row)
                  <tr>

                    <td>{{$row->lowongan}}</td>
                    <td>{{$row->total_lamar}}</td>
                    <td>{{$row->total_cv_masuk}}</td>
                    <td>{{$row->total_panggil}}</td>
                    {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                    <td>{{$row->total_lolos_call}}</td>
                    <td>{{$row->total_interview}}</td>
                    {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                    <td>{{$row->total_lolos_training}}</td>


                    <!-- <td>
                      <button type="button" class="btn btn-light">
                        <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                      </button>
                    </td> -->
                  </tr>
                @endforeach
                </tbody>
            </table>
          </div>
        </div>

<br>
<h4>Februari</h4>
<div class="row">
  <div class="panel panel-primary filterable">
      <table class="table" id="dataTable2">
          <thead>
            <tr >
              {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
            </tr>
        </thead>
        <thead>
          <tr class="filters">
          </tr>
      </thead>
          <tbody>
            @foreach($februari as $row)
            <tr>
              <td>{{$row->lowongan}}</td>
              <td>{{$row->total_lamar}}</td>
              <td>{{$row->total_cv_masuk}}</td>
              <td>{{$row->total_panggil}}</td>
              {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
              <td>{{$row->total_lolos_call}}</td>
              <td>{{$row->total_interview}}</td>
              {{--  <td>{{$row->total_datang_interview}}</td>  --}}
              <td>{{$row->total_lolos_training}}</td>

              <!-- <td>
                <button type="button" class="btn btn-light">
                  <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                </button>
              </td> -->
            </tr>
          @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <br>
  <h4>Maret</h4>
<div class="row">
  <div class="panel panel-primary filterable">
      <table class="table" id="dataTable3">
          <thead>
            <tr >
                {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
            </tr>
        </thead>
        <thead>
          <tr class="filters">
          </tr>
      </thead>
          <tbody>
            @foreach($maret as $row)
            <tr>

              <td>{{$row->lowongan}}</td>
              <td>{{$row->total_lamar}}</td>
              <td>{{$row->total_cv_masuk}}</td>
              <td>{{$row->total_panggil}}</td>
              {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
              <td>{{$row->total_lolos_call}}</td>
              <td>{{$row->total_interview}}</td>
              {{--  <td>{{$row->total_datang_interview}}</td>  --}}
              <td>{{$row->total_lolos_training}}</td>

              <!-- <td>
                <button type="button" class="btn btn-light">
                  <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                </button>
              </td> -->
            </tr>
          @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <br>
<h4>April</h4>
<div class="row">
  <div class="panel panel-primary filterable">
      <table class="table" id="dataTable4">
          <thead>
            <tr >
                {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
            </tr>
        </thead>
        <thead>
          <tr class="filters">
          </tr>
      </thead>
          <tbody>
            @foreach($april as $row)
            <tr>
              <td>{{$row->lowongan}}</td>
              <td>{{$row->total_lamar}}</td>
              <td>{{$row->total_cv_masuk}}</td>
              <td>{{$row->total_panggil}}</td>
              {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
              <td>{{$row->total_lolos_call}}</td>
              <td>{{$row->total_interview}}</td>
              {{--  <td>{{$row->total_datang_interview}}</td>  --}}
              <td>{{$row->total_lolos_training}}</td>

              <!-- <td>
                <button type="button" class="btn btn-light">
                  <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                </button>
              </td> -->
            </tr>
          @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <br>
  <h4>Mei</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable5">
            <thead>
              <tr >
                  {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($mei as $row)
              <tr>

                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                <td>{{$row->total_lolos_training}}</td>

                <!-- <td>
                  <button type="button" class="btn btn-light">
                    <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                  </button>
                </td> -->
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>

    <br>
  <h4>Juni</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable6">
            <thead>
              <tr >
                 {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($juni as $row)
              <tr>

                {{--  <td>{{ date_format(date_create($row->year),"Y") }}</td>
                <td>{{$row->month}}</td>  --}}
                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                <td>{{$row->total_lolos_training}}</td>

                <!-- <td>
                  <button type="button" class="btn btn-light">
                    <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                  </button>
                </td> -->
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <br>
  <h4>Juli</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable7">
            <thead>
              <tr >
                 {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($juli as $row)
              <tr>

                {{--  <td>{{ date_format(date_create($row->year),"Y") }}</td>
                <td>{{$row->month}}</td>  --}}
                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                <td>{{$row->total_lolos_training}}</td>

                <!-- <td>
                  <button type="button" class="btn btn-light">
                    <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                  </button>
                </td> -->
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <br>
  <h4>Agustus</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable8">
            <thead>
              <tr >
                  {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($agustus as $row)
              <tr>

                {{--  <td>{{ date_format(date_create($row->year),"Y") }}</td>
                <td>{{$row->month}}</td>  --}}
                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                <td>{{$row->total_lolos_training}}</td>

                <!-- <td>
                  <button type="button" class="btn btn-light">
                    <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                  </button>
                </td> -->
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <h4>September</h4>
    <div class="row">
      <div class="panel panel-primary filterable">
          <table class="table" id="dataTable9">
              <thead>
                <tr >
                   {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
                </tr>
            </thead>
            <thead>
              <tr class="filters">
              </tr>
          </thead>
              <tbody>
                @foreach($september as $row)
                <tr>

                  {{--  <td>{{ date_format(date_create($row->year),"Y") }}</td>
                  <td>{{$row->month}}</td>  --}}
                  <td>{{$row->lowongan}}</td>
                  <td>{{$row->total_lamar}}</td>
                  <td>{{$row->total_cv_masuk}}</td>
                  <td>{{$row->total_panggil}}</td>
                  {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                  <td>{{$row->total_lolos_call}}</td>
                  <td>{{$row->total_interview}}</td>
                  {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                  <td>{{$row->total_lolos_training}}</td>

                  <!-- <td>
                    <button type="button" class="btn btn-light">
                      <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td> -->
                </tr>
              @endforeach
              </tbody>
          </table>
        </div>
      </div>
  <h4>Oktober</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable10">
            <thead>
              <tr >
                  {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($oktober as $row)
              <tr>

                {{--  <td>{{ date_format(date_create($row->year),"Y") }}</td>
                <td>{{$row->month}}</td>  --}}
                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                <td>{{$row->total_lolos_training}}</td>

                <!-- <td>
                  <button type="button" class="btn btn-light">
                    <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                  </button>
                </td> -->
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
<h4>November</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable11">
            <thead>
              <tr >
                 {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($november as $row)
              <tr>

                {{--  <td>{{ date_format(date_create($row->year),"Y") }}</td>
                <td>{{$row->month}}</td>  --}}
                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                <td>{{$row->total_lolos_training}}</td>

                <!-- <td>
                  <button type="button" class="btn btn-light">
                    <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                  </button>
                </td> -->
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
  <h4>Desember</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable12">
            <thead>
              <tr >
                  {{--  <th>Tahun</th>
                      <th>Bulan</th>  --}}
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      {{--  <th>Lolos Panggil </th>  --}}
                      <th>Interview</th>
                      {{--  <th>Datang Interview</th>  --}}
                      <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($desember as $row)
              <tr>

                {{--  <td>{{ date_format(date_create($row->year),"Y") }}</td>
                <td>{{$row->month}}</td>  --}}
                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                {{--  <td>{{$row->total_panggilan_terhubung}}</td>  --}}
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                {{--  <td>{{$row->total_datang_interview}}</td>  --}}
                <td>{{$row->total_lolos_training}}</td>

                <!-- <td>
                  <button type="button" class="btn btn-light">
                    <a href="/report/show_detail/{{$row->Tr_report_lowongan_code_h}}"class="btn btn-outline-success">View</a>
                  </button>
                </td> -->
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>



</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script>
  $(document).ready(function() {
      $('#dataTable2').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
      } );
  } );
  </script>

  <script>
    $(document).ready(function() {
        $('#dataTable3').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable4').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable5').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable6').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable7').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable8').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable9').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable10').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable11').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable12').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
  </script>

<script>
  $(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>

<style>
  .filterable {
    margin-top: 15px;
  }
  .filterable .panel-heading .pull-right {
      margin-top: -20px;
  }
  .filterable .filters input[disabled] {
      background-color: transparent;
      border: none;
      cursor: auto;
      box-shadow: none;
      padding: 0;
      height: auto;
  }
  .filterable .filters input[disabled]::-webkit-input-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]::-moz-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]:-ms-input-placeholder {
      color: #333;
  }
</style>

<script>
  $(document).ready(function() {
        $('#dataTable').DataTable();
  });
</script>

@endsection
