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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Report</span> Asasmen</h4>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="panel-body table-responsive no-padding">
                                @php
                                    $dataarray = array();
                                    $dataarrayname = array();
                                    $dataarraygran = array();
                                    $nama = "";
                                    $grandtotal = 0;
                                    foreach ($employee as $row) {

                                        if (in_array($row->rec_usercreated,  $dataarrayname)){
                                        }else{
                                            $dataarrayname[] = $row->rec_usercreated;
                                        }

                                            $nama = $row->emp_name;

                                        $total1 = $row->Trust_value + $row->drive_value + $row->inisiative_value + $row->Reliable_value + $row->reslut;
                                                       $total2 = $row->mengarahkan_value + $row->problem_solving_value + $row->planning_value + $row->analisa_value + $row->kualitas_komunikasi_value;
                                                       $total3 = $row->absensi_value + $row->report_value + $row->kerajinan_value;
                                       
                                                       if($total1 != 0){
                                                            $total = $total1;
                                                        }
                                                        if($total2 != 0){
                                                            $total = $total2;
                                                        }
                                                        if($total3 != 0){
                                                            $total = $total3;
                                                        }
                                            $dataarray[$row->rec_usercreated][$row->Ms_type_asses][] = $total;
                                            $dataarraygran[$row->rec_usercreated][] = $total;        

                                       
                                    }    
                                    

                                 
                                     
                                
                                @endphp



                                <table class="table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Asesor</th>
                                            <th>Basic 1</th>
                                            <th>Basic 2</th>                                            
                                            <th>Leadership 1</th>
                                            <th>Leadership 2</th>
                                            <th>Discipline 1</th>
                                            <th>Discipline 2</th>                                            
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @for($i = 0 ; $i < count($dataarrayname); $i++)
                                            <tr>
                                                <td>
                                                    {{ $nama }}
                                                </td>                                                  
                                                <td>
                                                    {{ $dataarrayname[$i] }}
                                                </td>  
                                                <td>
                                                    {{ isset($dataarray[$dataarrayname[$i]]["Basic 1"][0]) ? $dataarray[$dataarrayname[$i]]["Basic 1"][0] : '0' }}
                                                </td> 
                                                <td>
                                                    {{ isset($dataarray[$dataarrayname[$i]]["Basic 2"][0]) ? $dataarray[$dataarrayname[$i]]["Basic 2"][0] : '0' }}
                                                </td> 
                                                <td>
                                                    {{ isset($dataarray[$dataarrayname[$i]]["Leadership 1"][0]) ? $dataarray[$dataarrayname[$i]]["Leadership 1"][0] : '0'; }}
                                                </td> 
                                                <td>
                                                    {{ isset($dataarray[$dataarrayname[$i]]["Leadership 2"][0]) ? $dataarray[$dataarrayname[$i]]["Leadership 2"][0] : '0' }}
                                                </td>                                                
                                                <td>
                                                    {{ isset($dataarray[$dataarrayname[$i]]["Discipline 1"][0]) ? $dataarray[$dataarrayname[$i]]["Discipline 1"][0] : '0' }}
                                                </td>        
                                                <td>
                                                    {{ isset($dataarray[$dataarrayname[$i]]["Discipline 2"][0]) ? $dataarray[$dataarrayname[$i]]["Discipline 2"][0] : '0' }}
                                                </td>                                                
                                                <td>
                                                    @php
                                                        $nilaitotal = 0;
                                                        for($j = 0 ; $j < count($dataarraygran[$dataarrayname[$i]]); $j++){
                                                            $nilaitotal += $dataarraygran[$dataarrayname[$i]][$j];
                                                        }
                                                        echo "<b>".$nilaitotal."</b>";
                                                    @endphp
                                                    
                                                </td>
                                            </tr>
                                            @endfor
                                    </tbody>        
                                </table>


                                <!-- Sisipkan script JavaScript untuk filter di sini -->

                                <!--
                                sum(hasil.Trust_value + hasil.drive_value + hasil.inisiative_value + hasil.Reliable_value + hasil.reslut ) as sumbasic,
                                sum(advance.mengarahkan_value + advance.problem_solving_value + advance.planning_value + advance.analisa_value + advance.kualitas_komunikasi_value ) as sumadvance,
                                sum(discipline.absensi_value + discipline.report_value + discipline.kerajinan_value) as sumdiscipline,
                                discipline.absensi_value,-->
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