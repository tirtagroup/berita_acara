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
                <input type="text" value="{{$detail->Ms_User_Code }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Divisi</label>
                <input type="text" value="{{$detail->ms_divisi }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Type Report</label>
                <input type="text" value="Closing" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                <input type="text" value="{{$detail->ms_lokasi }}" id="collapsible-fullname" class="form-control" readonly/>
                </div>
            </div>
        </div>

        <br>
        <table class="table table-bordered" id="journal-entrees">
            <thead>
              <tr>
                <th>
                  Total Open / Plan
                </th>
                <th>
                  Total Call
                </th>
                <th>
                  Total Interview
                </th>
                <th>
                  Total OK Interview
                </th>
            </tr>

            </thead>

            <tbody>
              <tr>
                <td>{{$detail->total_open }}</td>
                <td>{{$detail->total_panggil}}</td>
                <td>{{$detail->total_interview}}</td>
                <td>{{$detail->total_interview_diterima}}</td>
              </tr>
            </tbody>
        </table>

    </div>
</div>


@endsection
