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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Berita Acara Laka</h4>

<form  action="/berita_acara_laka" method="post" enctype="multipart/form-data">

  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

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
              <label class="form-label" for="collapsible-phone">Code</label>
                <input type="text" name="Tr_BA_Code" id="collapsible-fullname" class="form-control" placeholder="Auto Number" required readonly/>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="collapsible-phone">Date BA</label>
                <input type="date" name="Date_BA" id="collapsible-fullname" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required/>
            </div>
             <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Admin</label>
                  <input type="text" name="BA_Admin" id="" class="form-control" value={{$user->username}} readonly>
                {{--  <input type="text" name="BA_Admin" id="collapsible-fullname" class="form-control" placeholder="Admin" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Admin Divisi</label>
                  <select name = "Admin_Div" class="form-control" >
                    @foreach ($divisi as $divisies)
                        <option value="{{$divisies->subbdiv_desc}}">
                            {{$divisies->subbdiv_desc}}
                    @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Type Laka</label>
                <select name ="type_laka" class="form-control">
                  <option value = "Tunggal">Tunggal</option>
                  <option value = "Ada Korban">Ada Korban</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Fatality</label>
                <select name = 'fatality'class="form-control">
                  <option value="Iya" style="weight:50px">Iya</option>
                  <option value="Tidak" style="weight:50px">Tidak</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Pool</label>
                  <select class="form-control" name="pool" >
                    @foreach ($lokasi as $branch)
                        <option value="{{$branch->lokasi_desc}}">
                            {{$branch->lokasi_desc}}
                    @endforeach
                  </select>
                {{--  <input type="text" name="pool" id="collapsible-fullname" class="form-control" placeholder="Pool" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Dispatcher</label>
                  <select name = "dispatcher" class="form-control">
                    @foreach ($employee as $pegawai)
                        <option value="{{$pegawai->emp_name}}">
                            {{$pegawai->emp_name}}
                    @endforeach
                  </select>
                  {{--  <input type="text" name="dispatcher" id="collapsible-fullname" class="form-control" placeholder="" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">SPK</label>
                <input type="text" name="spk" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Nomor Truck</label>
                <input type="text" name="no_armada" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Jam Keluar</label>
                <input type="text" name="jam_keluar" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Tanggal Kejadian</label>
                <input type="date" name="date_laka" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Jam Kejadian</label>
                <input type="text" name="jam_kejadian" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi Kejadian</label>
                <input type="text" name="lokasi_kejadian" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Rallying</label>
                <input type="text" name="rallying" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Speed</label>
                <input type="text" name="speed" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">In Pool</label>
                <input type="text" name="in_pool" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Out Pool</label>
                <input type="text" name="out_pool" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Jalur/Rute</label>
                <input type="text" name="rute" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Bengkel Terakhir</label>
                <input type="text" name="bengkel_terakhir" id="collapsible-fullname" class="form-control" placeholder="" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Kategori</label>
                <input type="text" name="Category_Code" id="collapsible-fullname" class="form-control" value="Laka" required readonly/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Company Code</label>
                  <select name = "Company_Code" class="form-control" >
                    @foreach ($company as $pt)
                        <option value="{{$pt->description}}">
                            {{$pt->description}}
                    @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi Input</label>
                  <select class="form-control" name="Location_Code" >
                    @foreach ($lokasi as $branch)
                        <option value="{{$branch->lokasi_desc}}">
                            {{$branch->lokasi_desc}}
                    @endforeach
                  </select>
                  {{--  <input type="text" name="Location_Code" id="collapsible-fullname" class="form-control" placeholder="Lokasi" required/>  --}}
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">BA Type</label>
                <select name = 'BA_Type_Code'class="form-control">
                  <option value="Gudang" style="weight:50px">Gudang</option>
                  <option value="Bengkel" style="weight:50px">Bengkel </option>
                  <option value="Dispatcher" style="weight:50px">Dispatcher</option>
                  <option value="Kasir" style="weight:50px">Kasir</option>
                  <option value="Finance" style="weight:50px">Finance </option>
                  <option value="Purchasing" style="weight:50px">Purchasing</option>
                  <option value="GA" style="weight:50px">GA</option>
                  <option value="Security" style="weight:50px">Security</option>
                  </select>
              </div>
              {{--  <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Mengetahui 1</label>
                  <input type="text" name="mengetahui1" id="collapsible-fullname" class="form-control" placeholder="Lokasi" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Mengetahui 2</label>
                  <input type="text" name="mengetahui2" id="collapsible-fullname" class="form-control" placeholder="Lokasi" required/>
              </div>  --}}
              <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Note</label>
                  <input type="text" name="BA_Note" id="collapsible-fullname" class="form-control" placeholder="Lokasi" required/>
              </div>
              {{--  <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">BA Number</label>
                <input type="number"  readonly=readonly id="" class="form-control" value="{{ $ba_main->id }}"  >
              </div>  --}}
              <div class="col-md-12">
                <label class="form-label" for="collapsible-phone">Kronologi</label>
                <div class="form-group">
                  <textarea  cols="135" rows="10" name="kronlogi" required></textarea>
              </div>
              </div>
            </div>
        </div>
    </div>
</div>
    <!-- <div class="accordion" id="collapsibleSection">
      <div class="card accordion-item">
        <h2 class="accordion-header" id="headingDeliveryOptions">
          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryOptions" aria-expanded="false" aria-controls="collapseDeliveryOptions">Temuan</button>
        </h2>
        <div id="collapseDeliveryOptions" class="accordion-collapse collapse" aria-labelledby="headingDeliveryOptions" data-bs-parent="#collapsibleSection"> -->
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

                    <table class="table table-bordered" id="journal-entrees">
                          <thead>
                            <tr>
                              <th>Driver / Helper</th>
                              <th>Nama</th>
                              <th>Usia</th>
                              <th>Penguji</th>
                              <th>Average Income</th>
                              <th>Istirahat Terakhir</th>
                            </tr>
                          </thead>
                          <tbody class="row-body">
                          <tr class='entree-row'>
                            <td>
                              <select name ="posisi[]" class="form-control">
                                <option value = "Driver">Driver</option>
                                <option value = "Helper">Helper</option>
                              </select>
                            </td>
                            <td>
                                 <select name = "nama[]" class="form-control" >
                                          @foreach ($users as $pelakunya)
                                              <option value="{{$pelakunya->username}}">
                                                  {{$pelakunya->username}}
                                          @endforeach
                                 </select>
                                <!--<input name="nama[]" class="form-control"  type="text"   required/>-->
                            </td>
                            <td>
                                <input  name="usia[]" class="form-control"  type="text"   required/>
                            </td>
                            <td>
                              <input  name="penguji[]" class="form-control"  type="text"   required/>
                            </td>
                            <td>
                              <input  name="avg_income[]" class="form-control"  type="text"   required/>
                            </td>
                            <td>
                              <input  name="istirahat_last[]" class="form-control"  type="text"   required/>
                            </td>
                          </tr>
                          <tr class="button-row">
                            <td style="text-align:center; border-top:solid; border-width:1px;border-color:gray;" colspan="6"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- </div>
      </div>
    </div>	 -->

      <div class="mt-1">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
      </div>
   </div>
</div>


    <script>

        function newRow() {
          var tr_s = "<tr name='entree-row' class='entree-row '>";
          var tr_btn_s = "<tr class='button-row'>";
          var tr_e = "</tr>";
          var account_in_s = '<td><select name ="posisi[]" class="form-control"><option value = "Driver">Driver</option> <option value = "Helper">Helper</option> </select></td> ';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var debit_in = '<td><input   onkeyUp="update_in(\'debit_in\');" name="nama[]" class="form-control"  type="text"  ></td>';
          var credit_in = '<td><input  onkeyUp="update_in(\'credit_in\');" name="usia[]" class="form-control"  type="text"  ></td>';
          var t1 = '<td><input name="penguji[]" class="form-control"  type="text"   required/></td> ';
          var t2 = '<td><input name="avg_income[]" class="form-control"  type="text"   required/></td> ';
          var t3 = '<td><input name="istirahat_last[]" class="form-control"  type="text"   required/></td> ';
          var add_button = '<td style="text-align:center;" colspan="6"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button///
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+account_in_s+select_account+select_account_e+debit_in+credit_in+t1+t2+t3+remove_button+tr_e+tr_btn_s+add_button+tr_e);
          ///enables focus highlight on new rows///
          inputhighlight();
        };

    </script>

      <style>

            .je tr.button-row, .je tr.button-row button {
              background: #1f8dd6;
              color:white;
              font-size:100%;
            }

            .je .button-td {
              text-align: center;
              border: solid;
              border-width: 1px;
              border-color: gray;
            }

            .je table thead {
              /* border-bottom: solid; */
              /* border-width: 1px; */
              /* border-color: #909090; */
            }

            .new-row-btn,.new-row-btn:hover {
              width:900px;
              border:none;
              background:none;
              font-weight:bold;
            }
      </style>



@endsection
