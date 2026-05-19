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
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Memo Security</h4>
<form  action="/report_memo" method="post" enctype="multipart/form-data">
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
                <input type="text" name="Ms_ReportType_Code" id="collapsible-fullname" class="form-control" value="Memo" readonly />
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
              <div class="col-md-12">
                <label class="form-label" for="collapsible-fullname">Memo</label>
                <!-- <input type="textarea" name="Ms_User_Code" id="collapsible-fullname" class="form-control" placeholder="Operator" required/> -->
                <textarea class="form-control" name="Memo" id="exampleFormControlTextarea1" rows="6" required></textarea >
              </div>
            </div>
        </div>
    </div>
</div>  
    
              <div class="mt-1">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
              </div>           
          </div>
         </div>
        </div>
       </div>
    </div>
  </div>
</div>	


    <script>

        function newRow() {
          var tr_s = "<tr name='entree-row' class='entree-row '>";
          var tr_btn_s = "<tr class='button-row'>";
          var tr_e = "</tr>";
          var account_in_s = '<td> <select name ="Ms_Media_Code[]" class="form-control"> <option value = "Jobstreet">Jobstreet</option><option value = "LinkIdn">LinkIdn</option><option value = "Jobs ID">Jobs ID</option><option value = "Sosial Media">Sosial Media</option><option value = "Olx">Olx</option> </td>';
          var select_account = $("#select_account").html();
          var row_insert = $("#row_insert").html();
          var select_account_e = '</select></td>';
          var debit_in = '<td><select name = "MS_Jabatan_Code[]" class="form-control" ><option value="Gudang" style="weight:50px">Gudang </option><option value="Sales" style="weight:50px">Sales</option><option value="Dispatcher" style="weight:50px">Dispatcher</option>  ></td>';
          var credit_in = '<td><select name = "Ms_Perusahaan_Code[]"class="form-control"><option value="Bukalapak" style="weight:50px">Bukalapak</option> <option value="PT. HGS" style="weight:50px">PT. Handal Guna Sarana </option> <option value="PT. TGU" style="weight:50px">PT. Tirta Gracia Utama</option><option value="PT. TGF" style="weight:50px">PT. Tirta Gracia Fiesta</option></td>';
          var memo_in = '<td><input type="text" name="Qty[]" placeholder="Enter Jumlah" class="form-control" /> ';
          var add_button = '<td style="text-align:center;" colspan="5"><button onClick="newRow();" class="pure-button  new-row-btn " style="display:inline-block;text-align:center;">Add New <i style="color:white;"class="fa fa-plus" aria-hidden="true"></i></button></td>';
          var remove_button = '';
          ///removes row with add button/// 
          $(".button-row").remove();
          ///adds row with inputs and last row with add button///
          $(".row-body").append(tr_s+account_in_s+select_account+select_account_e+debit_in+credit_in+memo_in+remove_button+tr_e+tr_btn_s+add_button+tr_e);
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
              border-bottom: solid;
              border-width: 1px;
              border-color: #909090;
            }

            .new-row-btn,.new-row-btn:hover {
              width:900px;
              border:none;
              background:none;
              font-weight:bold;
            }

            /* #main {
              width: 60%;
              margin: 5%;
            } */
      </style>



@endsection
