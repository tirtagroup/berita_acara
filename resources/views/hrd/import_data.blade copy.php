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
<head>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Import Data</h4>
<form  action="/import_data" method="post" enctype="multipart/form-data">
<link rel="icon" type="image/x-icon" href="{{ asset('upload/favicon.ico') }}" />
<title>
    Import Data
  </title>
</head>

<body>
  @if(session('success'))
      <div>{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div>{{ session('error') }}</div>
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
                <center>
                  <label for="" >upload doc. </label>
                      <br>
                      <div class="form-group">
                          {{--  <input type="file" name="file" id="file" onchange="return validasiEkstensi2()">  --}}
                          <input type="file" name="file" required>
                      </div>
                      <div id="feedback2">
              </center>
            <br>
           <center>

             {{--  <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">User</label>
                <input type="text" name="Ms_User_Code" id="collapsible-fullname" class="form-control" placeholder="Operator" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Divisi</label>
                <select name = "ms_divisi" class="form-control" >
                    <option value="GA" style="weight:50px">GA</option>
                    <option value="Security" style="weight:50px">Security</option>
                    <option value="HRD" style="weight:50px">HRD</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-fullname">Type Report</label>
                <input type="text" name="Ms_ReportType_Code" id="collapsible-fullname" class="form-control" value="Temuan" readonly />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="collapsible-phone">Lokasi</label>
                <select name = 'ms_lokasi'class="form-control">
                    <option value="Pusat" style="weight:50px">Pusat   </option>
                    <option value="Subang" style="weight:50px">Subang </option>
                    <option value="Ciherang" style="weight:50px">Ciherang</option>
                    <option value="Sentul" style="weight:50px">Sentul</option>
                  </select>
                </div>
            </div>  --}}
        </div>
    </div>
</div>

</body>

      <div class="mt-1">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
      </div>
   </div>
</div>


<script>
  function validasiEkstensi2(){
      var inputFile = document.getElementById('file');
      var pathFile = inputFile.value;
      var ekstensiOk = /(\.xlsx|\.xls)$/i;
      if(!ekstensiOk.exec(pathFile)){
          alert('Silakan upload file dengan ekstensi .xlsx / .xls(Excel)');
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
