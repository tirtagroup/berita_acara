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
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Approval Manager Finance</h4>

<div class="card-body">
  @if (count($errors) > 0)
  <div class="alert alert-danger">analuost
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

  <form  action="/detail_validasi3/{{$main_ba->Tr_BA_Main_Code }}" method="post" enctype="multipart/form-data">
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
                <label class="form-label" for="collapsible-fullname">Code</label>
                <input type="text" value="{{$main_ba->Tr_BA_Main_Code }}" id="collapsible-fullname" class="form-control" required readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Date Input</label>
                <input type="text" value="{{$main_ba->created_at->format('d_m-Y') }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Date Peristiwa</label>
                <input type="text" value="{{$main_ba->Date_BA }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Company</label>
                <input type="text" value="{{$main_ba->rec_comcode }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                <input type="text" value="{{$main_ba->rec_areacode }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Operator</label>
                <input type="text" value="{{$main_ba->Ms_Emp_Code }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Divisi</label>
                <input type="text" value="{{$main_ba->Ms_Emp_Div }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Kategori</label>
                <input type="text" value="{{$main_ba->Ms_BA_type_Code }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Kasus</label>
                <input type="text" value="{{$main_ba->Ms_Kasus }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Detail Kasus</label>
                <input type="text" value="{{$main_ba->MS_Detail_Kasus }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
              <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Note</label>
                <input type="text" value="{{$main_ba->BA_Desc }}" id="collapsible-fullname" class="form-control" readonly/>
              </div>
               <center>
                  <h3>
                    kronologi
                  </h3>
               </center>
               <table class="table table-bordered mt-4" >
                    <!--<div style="padding-left:10px; text-align: justify;" id="outputText">{{$ba_kronologi->kronlogi}}</div>-->
                        <thead>
                                        <tr>
                                            <td>{{$ba_kronologi->kronlogi}}</td>
                                        </tr>
                        </thead>
                </table>

                 <br>
                  <center>
                    <h3>
                        Dokumen
                    </h3>
                  </center>
                 <br>
                    <table class="table table-bordered mt-4" >
                        <thead>
                            <tr>
                              <tr>
                                <th >Dokumen Pendukung</th>
                                <th>Dokumen Pendukung</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
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
                  <br>
                  <center>
                    <h3>
                        Detail Kode Transaksi
                    </h3>
                  </center>
                  <br>
                      <table class="table table-bordered mt-4" >
                          <thead>
                              <tr>
                                <tr>
                                  <th>Code Doc.</th>
                                  <th>Field Salah</th>
                                  <th>Value Salah</th>
                                  <th>Field Benar</th>
                                  <th>Value Benar</th>
                              </tr>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($detail as $row)
                                  <tr>
                                    <td>{{$row->code_doc }}</td>
                                    <td>{{$row->field_salah }}</td>
                                    <td>{{$row->value_salah }}</td>
                                    <td>{{$row->field_benar }}</td>
                                    <td>{{$row->value_benar }}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                    <br>
                  <center>
                    <h3>
                        Tracking Approval
                    </h3>
                  </center>
                  <br>
                    <table class="table table-bordered mt-4" >
                        <thead>
                            <tr>
                              <tr>
                                <th width="3%">Tracking</th>
                                <th width="12%">Approved By</th>
                                <th width="15%">Divisi</th>
                                <th width="70%">Note</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>

                              @foreach($tracking as $row)
                                  <tr>
                                    <td>{{$row->approval_ba_tracking }}</td>
                                    <td>{{$row->pic }}</td>
                                    <td>{{$row->approval_ba_desc }}</td>
                                    <td>{{$row->note }}</td>
                                  </tr>
                              @endforeach

                        </tbody>
                    </table>
                  <br>
            </div>
        </div>
    </div>
</div>





<div class="accordion" id="collapsibleSection">
  <div class="card accordion-item">
    <h2 class="accordion-header" id="headingDeliveryOptions">
      <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">Isi Pesan Approval Disini</button>
    </h2>
    <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection">
    <form>
      <form  action="/report" method="post" enctype="multipart/form-data">
    @csrf
    <div class="accordion-body">
            <div class="content je">
              <div class="pure-g ">
                <div class="pure-u-1-24 ">
                </div>
                <div class="pure-u-11-12">
            <div class="">
              <div class="pure-g">
                <div class="pure-u-1-2">

        <div class="container">
          <div class="col-md-12">
            <label class="form-label" for="collapsible-fullname">Approve By</label>
            <input type="text" name="username3" value="{{$user->username }}" id="collapsible-fullname" class="form-control" readonly required/>
          </div>
          <div class="col-md-12">
            <label class="form-label" for="collapsible-fullname">Note</label>
            <input type="text" name="note3" placeholder="Enter Note" id="collapsible-fullname" class="form-control"/>
          </div>
        </div>

          <br>
            <div class="col-md-6">
            <br>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<div class="mt-1">
  <!--<button type="submit" class="btn btn-success me-sm-3 me-1">Approve</button>-->
  <!--<button type="reset" class="btn btn-danger me-sm-3 me-1">Deny-></button>-->
   <button type="submit" class="btn btn-success me-sm-3 me-1" name="keputusan" value="setuju">Approve</button>
  <button type="submit" class="btn btn-danger me-sm-3 me-1" name="keputusan" value="tidak_setuju">Deny-></button>
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
