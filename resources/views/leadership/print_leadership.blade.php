<html>

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="{{ asset('upload/favicon.ico') }}">
    <title>
        Print BA
      </title>
    </head>


@section('content')
   <center><h2 style="padding-left:10px;">Detail Assasment</h2> </center>
                     <p class="garise"></p>
<body>
  <table>
    @foreach($details as $detail)



    <tr>
      <td style="padding-left:10px; font-size 100px">Code &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{   $detail->Tr_Emp_Asses_Code }} </td>
      <td>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{date_format(date_create($detail->created_at),"d-m-Y") }} </td>
    </tr>
    <tr>
      <td style="padding-left:10px; font-size 100px">Assesor &nbsp; &nbsp; &nbsp;&nbsp;: {{   $detail->rec_usercreated }}</td>
      <td>Divisi Assesor&nbsp;&nbsp;&nbsp;&nbsp;: {{ $detail->ms_divisi }}</td>
    </tr>
    <tr>
      <td style="padding-left:10px; font-size 100px">Employee&nbsp;&nbsp;&nbsp; : {{   $detail->Ms_emp_code }}</td>
      <td>Divisi Employee : {{   $detail->Ms_Emp_Div }}</td>
    </tr>
    <tr>
      <td style="padding-left:10px; font-size 100px">Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{   $detail->Ms_type_asses }}</td>
      <td>Jabatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{   $detail->Ms_record_asses }}</td>
    </tr>
  </table>
<br><br>
  <center><h2 style="padding-left:10px;">Rating</h2> </center>

  <table id="tabelMenarik">
    <tr>
      <td>Mengarahkan</td>
      <td>
        <label style="font-size: 10px;">
            <input type="input" class="form-control" name="result" readonly value="{{ $detail->mengarahkan_value }}">
        </label>
      </td>
      <td>
        <input type="text" class="form-control"  name="result_comment" style="width: 800px; height: 40px;" readonly value="{{ $detail->mengarahkan_comment  }}">
      </td>
  </tr>
  <tr>
      <td>Problem Solve</td>
      <td>
        <label style="font-size: 10px;">
            <input type="input" class="form-control" name="result" readonly value="{{ $detail->problem_solving_value }}">
        </label>
      </td>
      <td>
        <input type="text" class="form-control"  name="result_comment" style="width: 800px; height: 40px;" readonly value="{{ $detail->problem_solving_comment  }}">
      </td>
  </tr>
  <tr>
      <td>Planing</td>
      <td>
        <label style="font-size: 10px;">
          <input type="input" class="form-control" name="result" readonly value="{{ $detail->planning_value }}">
        </label>
      </td>
      <td>
        <input type="text" class="form-control" name="result_comment" style="width: 800px; height: 40px;" readonly value="{{ $detail->planning_comment  }}">
      </td>
  </tr>
  <tr>
      <td> Analisa</td>
      <td>
        <label style="font-size: 10px;">
          <input type="input" class="form-control" name="result" readonly value="{{ $detail->analisa_value }}">
        </label>
    </td>
    <td>
      <input type="text" class="form-control"  name="result_comment" style="width: 800px; height: 40px;" readonly value="{{ $detail->analisa_comment  }}">
    </td>
  </tr>
  <tr>
      <td>Kualitas komunikasi</td>
  <td>
            <label style="font-size: 10px;">
              <input type="input" class="form-control" name="result" readonly value="{{ $detail->kualitas_komunikasi_value }}">
            </label>
  </td>
  <td>
    <input type="text" class="form-control"  name="result_comment" style="width: 800px; height: 40px;" readonly value="{{ $detail->kualitas_komunikasi_comment  }}">
  </td>
  </tr>
  <tr>
    <td>Total Nilai</td>
    <td>
      <label style="font-size: 10px; background-color:white !important;">
        <input type="input" class="form-control" name="result" readonly value="{{ $detail->mengarahkan_value + $detail->problem_solving_value + $detail->planning_value + $detail->analisa_value + $detail->kualitas_komunikasi_value }}">
      </label>
    </td>
    <td>
    </td>
  </tr>


    @endforeach
  </table>
  <br><br>
  <center><h2 style="padding-left:10px;">Notes</h2> </center>


  @php
  $i = 1;
  @endphp
  <table >
    @foreach($notes as $row)

     <tr>
      <td>
        
      </td>      
        <td>PESAN</td>
        <td><input type="text" class="form-control" style="width: 800px; height: 40px;" readonly value="{{ $row->note}}">
        </td>
    </tr>
    @endforeach
  </table>


<style>
  table, th, td
  {
      border: 0px solid black;
  }

  table
  {
          width: 100%;
  }
  p.garise
  {
          border-style: solid;
          border-width: 1px;

  }
  td, th, textarea,thead, tbody
  {
   font-size: 25px;
  }
  tab
  {
    display: inline-block;
      margin-left: 20px;
  }
  textarea
  {
    border: none;
    outline: none;
  }
  outputText
  {
    width: auto;
    max-width: 100%;
    word-wrap: break-word;
    text-align: justify;
  }
  div
  {
   font-size: 25px;
   text-align: justify;
  }

  </style>

  <div>
    <p><button onclick="window.print()" type="button" class="btn btn-default btn-sm">
      {{--  <span class="glyphicon glyphicon-print"></span> Print  --}}
      {{-- <a href="/bkbbtb_manual/print_bkb/{{$row->bkb_code_main}}"class="btn btn-outline-success" >Print</a> --}}
    </button>
    </p>
  </div>


</body>
</html>
