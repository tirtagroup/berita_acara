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
{{--  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">  --}}
{{--  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">  --}}
{{--  <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">  --}}
{{--  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>  --}}
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

{{--  @section('content')  --}}
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Detail Report</h4>
<form  action="/report" method="post" enctype="multipart/form-data">
@csrf
<div class="row">
  <div class="col">
    <div class="nav-align-top mb-3">
      <ul class="nav nav-tabs" role="tablist">
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
          <div class="row g-3">
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User</label>
                <input type="text" value="{{$main->Ms_User_Code }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Divisi</label>
                <input type="text" value="{{$main->ms_divisi }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Type Report</label>
                <input type="text" value="{{$main->Ms_ReportType_Code }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                <input type="text" value="{{$main->ms_lokasi }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
            </div>
        </div>

        <br>
        <table class="table table-bordered" id="dataTable">
            <thead>
                @if($main->Ms_ReportType_Code == 'Opening Lowongan')
                    <tr>
                        <th>Media</th>
                        <th>Perusahaan</th>
                        <th>Posisi</th>
                        <th>Jumlah</th>
                    </tr>
                @elseif($main->Ms_ReportType_Code == 'Call')
                    <tr>
                      <th>Media</th>
                      <th>Kandidat</th>
                      <th>Posisi</th>
                      <th>Telepon</th>
                      <th>Status</th>
                    </tr>
                @elseif($main->Ms_ReportType_Code == 'Interview')
                    <tr>
                      <th>Company</th>
                      <th>Media</th>
                      <th>Yang Interview</th>
                      <th>Kandidat</th>
                      <th>Posisi</th>
                      <th>Telepon</th>
                      <th>Hasil Interview</th>
                      <th>Note</th>
                  </tr>
                  @endif
            </thead>

            <tbody>
            @foreach($detail as $row)
                @if($main->Ms_ReportType_Code == 'Opening Lowongan')
                        <tr>
                            <td>{{$row->Ms_Media_Code }}</td>
                            <td>{{$row->Ms_Perusahaan_Code }}</td>
                            <td>{{$row->MS_Jabatan_Code }}</td>
                            <td>{{$row->Qty }}</td>
                        </tr>
                @elseif($main->Ms_ReportType_Code == 'Call')
                        <tr>
                            <td>{{$row->Ms_Media_Code }}</td>
                            <td>{{$row->Nama_kandidat }}</td>
                            <td>{{$row->NamaLowongan }}</td>
                            <td>{{$row->Telepon }}</td>
                            <td>{{$row->Ms_Status }}</td>
                        </tr>
                @elseif($main->Ms_ReportType_Code == 'Interview')
                        <tr>
                            <td>{{$row->Ms_Perusahaan_Code }}</td>
                            <td>{{$row->Ms_Media_Code }}</td>
                            <td>{{$row->userinterview }}</td>
                            <td>{{$row->NamaCandidate }}</td>
                            <td>{{$row->NamaLowongan }}</td>
                            <td>{{$row->Telepon }}</td>
                            <td>{{$row->hasil_interview }}</td>
                            <td>{{$row->note }}</td>
                        </tr>
                @endif
            @endforeach
            </tbody>
        </table>

    </div>
</div>


<script>
  $(document).ready(function() {
      $('#dataTable').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'excel'
          ]
      } );
  } );
  </script>




@endsection
