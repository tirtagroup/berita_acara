@extends('layouts/layoutMaster')

@section('title', ' Horizontal Layouts - Forms')

@section('newtheme')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"defer></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"defer></script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" defer ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer ></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" defer ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" defer ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" defer ></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js" defer ></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js" defer ></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js" defer ></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" defer ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer ></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" defer ></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js" defer ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"  ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js" defer ></script>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js" defer ></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js" defer ></script>



    <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css"
  integrity="sha512-1k7mWiTNoyx2XtmI96o+hdjP8nn0f3Z2N4oF/9ZZRgijyV4omsKOXEnqL1gKQNPy2MTSP9rIEWGcH/CInulptA=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>

<!-- ✅ load jQuery ✅ -->
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous" defer
></script>

<!-- ✅ load DataTables ✅ -->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
  integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer" defer
></script>
@endsection

  <title>
    Asasmen Nilai
  </title>

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Report</span> Assessment</h4>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="panel-body table-responsive no-padding">
                                <!--<div class="col-lg-3 col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <div class="input-group date">
                                                <input type="date" id="start_date" name="start_date" class="form-control pull-right">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <label>End Date:</label>
                                                <div class="input-group date">
                                                           <input type="date" id="end_date" name="end_date" class="form-control pull-right">
                                                        </div>
                                                    </div>
                                                </div>
                                <div class="col-lg-3 col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <label>Nama Pelaku:</label>
                                                <div class="input-group date">
                                                    <div>

                                                        </div>
                                                            <select name="pelaku" id="pelaku" class="form-control">
                                                            <option value="">---Pelaku---</option>
                                                            @foreach ($dataemp['data'] as $emp)
                                                            <option value='{{$emp->User_Code}}'>{{$emp->User_Code}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-xs-6">
                                            <div class="form-group">
                                                <label></label>

                                                 <div class="input-group date">
                                                    <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="text" id="refresh" class="btn btn-warning">Refresh</button>
                                                </div>
                                            </div>
                                        </div>

                                                <table class="table table-striped table-bordered data-table" id="DataAttendance" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <td>Date Input</td>
                                                            <td>Date Peristiwa</td>
                                                            <td>Company</td>
                                                            <td>Lokasi</td>
                                                            <td>User Input</td>
                                                            <td>Pelaku</td>
                                                            <td>Divisi Pelaku</td>
                                                            <td>Kasus</td>
                                                            <td>Type Kasus</td>
                                                            <td>Kronologi</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>-->

                                <table class="table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Empolyee</th>
                                            <th>Assessor</th>
                                            <th>Division</th>
                                            <th>Nilai</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <th>Empolyee</th>
                                            <th>Assessor</th>
                                            <th>Division</th>
                                            <th>Score</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            //Function to sort array by key
                                            function sort_array_by_key($array, $sort_key){
                                                $key_array = array_column($array, $sort_key);
                                                array_multisort($key_array, SORT_DESC, $array); //or SORT_ASC
                                                return $array;
                                            }
                                            $arraydata = array();
                                            foreach($employee as $row){
                                                $tanggal = date_format(date_create($row->created_at),"Y-m-d");
                                                $arraydata[] = array(
                                                                    "Tanggal"  => $tanggal,
                                                                    "Empolyee" => $row->emp_name,
                                                                    "Emp_code" => $row->Tr_Emp_Asses_Code,
                                                                    "Divisi"   => $row->Ms_Emp_Div,
                                                                    "Assesor"  => $row->rec_usercreated,
                                                                    "Nilai"    => $row->sumbesic + $row->sumadvance + $row->sumdiscipline,
                                                            );
                                            }
                                            $sorted = sort_array_by_key($arraydata, 'Nilai');
                                        @endphp

                                        @foreach($sorted as $row)
                                            <tr>
                                                <td>{{ $row["Tanggal"] }}</td>
                                                <td>{{ $row["Empolyee"] }}</td>
                                                <td>{{ $row["Assesor"] }}</td>
                                                <td>{{ $row["Divisi"] }}</td>
                                                <td>{{ $row["Nilai"] }}</td>
                                                <td><a href='/report_asesmen_pot/{{ $row["Emp_code"] }}' class='btn btn-outline-success' target='_blank'>View</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <!-- Sisipkan script JavaScript untuk filter di sini -->

                                <script>
                                    $(document).ready(function() {
                                    $('#myTable').DataTable({dom: 'Bfrtip',
                                    buttons: [
                                            {
                                                extend: 'excelHtml5',
                                                title: 'NILAI ASSESOR',
                                                text: 'Export to Excel',
                                                exportOptions: {
                                                    columns: [ 0, 1, 2, 3, 4 ],
                                                    format: {
                                                    header: function(content, index) {
                                                      if(index === 0){
                                                        return index === 0 ? "TANGGAL" : content;
                                                      } else if(index === 1){
                                                        return index === 1 ? "EMPLOYEE" : content;
                                                      } else if(index === 2){
                                                        return index === 2 ? "ASSESOR" : content;
                                                      } else if(index === 3){
                                                        return index === 3 ? "DIVISI" : content;
                                                      } else if(index === 4){
                                                        return index === 4 ? "NILAI" : content;
                                                      } else{
                                                        return content;
                                                      }
                                                    },
                                                    body: function(data, column, row, node) {
                                                       return data;
                                                    }
                                                    }
                                                }
                                            },
                                        ],
                                        "ordering": false,
                                        initComplete: function () {
                                            this.api().columns([0,1,2,3,4]).every( function (d) {//THis is used for specific column
                                                var column = this;
                                                var theadname = $('#myTable th').eq([d]).text();
                                                var select = $('<select  class="form-control"><option value="">'+theadname+': All</option></select>')
                                                .appendTo($(column.header()).empty())
                                                        .on('change', function () {
                                                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                                                        });

                                                    column
                                                        .data()
                                                        .unique()
                                                        .sort()
                                                        .each(function (d, j) {
                                                            select.append('<option value="' + d + '">' + d + '</option>');
                                                        });

                                                    $(column.footer()).empty();
                                                } );
                                            }
                                        } );
                                    } );
                                </script>

                                    </div>
                            </div>
                        </div>
                    </div>
                <!-- form view -->

                <!-- /form view -->
                </div>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer ></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" ></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" defer ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" defer ></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js" defer ></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript" defer></script>
    <link href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/start/jquery-ui.css" rel="stylesheet"  />




@endsection
