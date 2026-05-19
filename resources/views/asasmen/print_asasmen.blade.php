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
        Print Basic
      </title>
    </head>


@section('content')
   <center><h2 style="padding-left:10px;">Detail Assessment</h2> </center>
                     <p class="garise"></p>
<body>
  <table>
    @foreach($mains as $detail)
    <tr>
      <td style="padding-left:10px; font-size 100px">Code &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{   $detail->Tr_Review_EmpPeriod_Code_h }} </td>
      <td>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{date_format(date_create($detail->created_at),"d-m-Y") }} </td>
    </tr>

    <tr>
      <td style="padding-left:10px; font-size 100px">Employee&nbsp;&nbsp;&nbsp; : {{   $detail->Ms_Emp_Code }}</td>
      <td>Employee Div. &nbsp;&nbsp;: {{   $detail->Ms_Emp_Div }}</td>
    </tr>
    <tr>
      <td style="padding-left:10px; font-size 100px">Periode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{   $detail->Ms_Periode }}</td>
    </tr>
  </table>
  @endforeach
  <center><h2 style="padding-left:10px;">Rating</h2> </center>
  <div class="p-3">
    @foreach($heading as $row)
    <h3 style="font-weight: bold; font-style: italic;">Rating By : <em style="color: rgb(0, 0, 255);">{{ $row->Ms_Reviewer_Code }}</em></h3>
    <div class="row">
    </div>
    <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label purple-label">1.Trust&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <div class="col-sm-10">
          @for($i = -2; $i <= 3; $i++)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($row->Trust_value == $i){ echo "checked";}else{ echo "disabled='disabled'";} ?> />
            <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
          </div>
          @endfor
        </div>
      </div>
      <div>
        <table>
          <tr>
            <td style="padding-left:10px; font-size 100px">Komentar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{   $row->trust_comment }} </td>
          </tr>
          <tr>
            <td style="padding-left:10px; font-size 100px">Saran&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{   $row->trust_suggestion }}</td>
          </tr>
          <tr>
            <td style="padding-left:10px; font-size 100px">Penilaian Plus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{   $row->TrustHigh }}</td>
          </tr>
          <tr>
            <td style="padding-left:10px; font-size 100px">Penilaian Minus&nbsp;&nbsp;: {{   $row->TrustLow }}</td>
          </tr>
        </table>
      </div>

    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">2.Drive&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <div class="col-sm-10">
        @for($i = -2; $i <= 3; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($row->drive_value == $i){ echo "checked";}else{ echo "disabled='disabled'";} ?> />
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
    </div>
    <div>
      <table>
        <tr>
          <td style="padding-left:10px; font-size 100px">Komentar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{   $row->drive_comment }} </td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Saran&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{   $row->drive_suggestion }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Plus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{   $row->DriveHigh }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Minus&nbsp;&nbsp;: {{   $row->DriveLow }}</td>
        </tr>
      </table>
    </div>

    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">3.Initiative&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <div class="col-sm-10">
        @for($i = -2; $i <= 3; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($row->inisiative_value == $i){ echo "checked";}else{ echo "disabled='disabled'";} ?> />
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
    </div>
    <div>
      <table>
        <tr>
          <td style="padding-left:10px; font-size 100px">Komentar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{   $row->inisiatif_comment }} </td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Saran&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{   $row->inisiative_suggestion }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Plus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{   $row->InisiativeHigh }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Minus&nbsp;&nbsp;: {{   $row->InisitativeLow }}</td>
        </tr>
      </table>
    </div>

    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">4.Reliable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <div class="col-sm-10">
        @for($i = -2; $i <= 3; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($row->Reliable_value == $i){ echo "checked";}else{ echo "disabled='disabled'";} ?> />
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
    </div>
    <div>
      <table>
        <tr>
          <td style="padding-left:10px; font-size 100px">Komentar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{   $row->reliable_comment }} </td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Saran&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{   $row->Reliable_suggestion }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Plus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{   $row->ReliableHigh }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Minus&nbsp;&nbsp;: {{   $row->ReliableLow }}</td>
        </tr>
      </table>
    </div>

    <div class="mb-3 row">
      <label for="inputPassword" class="col-sm-2 col-form-label purple-label">5.Result&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <div class="col-sm-10">
        @for($i = -2; $i <= 3; $i++)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" value="{{ $i }}"  data-type="trust" <?php if($row->result == $i){ echo "checked";}else{ echo "disabled='disabled'";} ?> />
          <label class="form-check-label" for="inlineRadio1">{{ $i }}</label>
        </div>
        @endfor
      </div>
    </div>
    <div>
      <table>
        <tr>
          <td style="padding-left:10px; font-size 100px">Komentar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{   $row->result_comment }} </td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Saran&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{   $row->result_suggestion }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Plus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{   $row->ResultHigh }}</td>
        </tr>
        <tr>
          <td style="padding-left:10px; font-size 100px">Penilaian Minus&nbsp;&nbsp;: {{   $row->ResultLow }}</td>
        </tr>
      </table>
    </div>

      <div class="mb-3 row">
        <table>
          <tr>
            <td style="padding-left:10px; font-size 100px; font-weight: bold; font-style: italic; ">Total Nilai &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: {{ $row->Trust_value+$row->drive_value+$row->inisiative_value+$row->Reliable_value+$row->result }} </td>
          </tr>
        </table>
      </div>
    @endforeach

  </table>
  <br><center><h2>Tugas</h2></center>
  <div class="accordion-body">
    <div class="content je">
      <div class="pure-g ">
        <div class="pure-u-1-24 ">
          @foreach ($tugas as $key => $task)
          <div class="input-row row">
              <!-- First row -->
              <div class="col-md-6">
                  <label style="color: rgb(0, 0, 255);" class="bold-italic" for="type">({{ $key + 1 }}).Tugas</label>
                  <input class="form-control" type="text" value="{{ $task->TaskDesc }}" style="color: rgb(0, 0, 255);" readonly>
              </div>
              <div class="col-md-3" >
                  <label class="bold-italic" for="type">Date</label>
                  <input class="form-control" type="date" value="{{ $task->DateTask }}" readonly>
              </div>
              <div class="col-md-3">
                  <label class="bold-italic" for="type">Reviewer</label>
                  <input class="form-control" type="text" value="{{ $task->Ms_Reviewer_Code }}" readonly>
              </div>
              <!-- Second row -->
              <div class="col-md-6">
                  <label class="bold-italic" for="resultHigh">ResultPlus</label>
                  <input class="form-control" type="text" value="{{ $task->ResultHigh }}" readonly>
              </div>
              <div class="col-md-6">
                  <label class="bold-italic" for="resultLow">ResultMinus</label>
                  <input class="form-control" type="text" value="{{ $task->ResultLow }}" readonly>
              </div>

              <!-- Third row -->
              <div class="col-md-6">
                  <label class="bold-italic" for="resultDesc">Komentar </label>
                  <input class="form-control" type="text" value="{{ $task->ResultDesc }}" readonly>
              </div>
              <div class="col-md-6">
                  <label class="bold-italic" for="suggest">Suggest</label>
                  <input class="form-control" type="text" value="{{ $task->Suggest_BOD }}" readonly>
              </div>

              <!-- Fourth row -->
              <div class="col-md-1">
                  <label class="bold-italic" for="resultDesc">Quality: </label>
                  <input class="form-control" type="text" value="{{ $task->Quality }}" readonly style="color:{{ $task->Quality <= 0 ? 'red' : 'green' }}">
              </div>
              <div class="col-md-1">
                  <label class="bold-italic" for="suggest">Solutif:</label>
                  <input class="form-control" type="text" value="{{ $task->Solutif }}" readonly style="color:{{ $task->Solutif <= 0 ? 'red' : 'green' }}">
              </div>
              <div class="col-md-1">
                  <label class="bold-italic" for="suggest">Inisiatif:</label>
                  <input class="form-control" type="text" value="{{ $task->Inisiatif }}" readonly style="color:{{ $task->Inisiatif <= 0 ? 'red' : 'green' }}">
              </div>
              <div class="col-md-1">
                  <label class="bold-italic" for="suggest">Tuntas:</label>
                  <input class="form-control" type="text" value="{{ $task->Tuntas }}" readonly style="color:{{ $task->Tuntas <= 0 ? 'red' : 'green' }}">
              </div>
            <!--  <div class="col-md-1">-->
            <!--    <label class="bold-italic" for="suggest">Kualitas:</label>-->
            <!--    <input class="form-control" type="text" value="{{ $task->Kualitas }}" readonly style="color:{{ $task->Kualitas <= 0 ? 'red' : 'green' }}">-->
            <!--</div>-->
            <div class="col-md-1">
              <label class="bold-italic" for="suggest">Kecepatan:</label>
              <input class="form-control" type="text" value="{{ $task->Kecepatan }}" readonly style="color:{{ $task->Kecepatan <= 0 ? 'red' : 'green' }}">
            </div>
            <div class="col-md-1">
                <label class="bold-italic" for="suggest">Update:</label>
                <input class="form-control" type="text" value="{{ $task->Update }}" readonly style="color:{{ $task->Update <= 0 ? 'red' : 'green' }}">
            </div>
            <div class="col-md-1">
              <label class="bold-italic" for="suggest">Hasil:</label>
              <input class="form-control" type="text" value="{{ $task->Hasil }}" readonly style="color:{{ $task->Hasil <= 0 ? 'red' : 'green' }}">
            </div>
            <div class="col-md-1">
              <label class="bold-italic" for="suggest">Konsisten:</label>
                  <input class="form-control" type="text" value="{{ $task->Konsisten }}" readonly style="color:{{ $task->Konsisten <= 0 ? 'red' : 'green' }}">
                </div>
                <div class="col-md-1">
                  <label class="bold-italic" for="suggest">Tanggap:</label>
                  <input class="form-control" type="text" value="{{ $task->Tanggap }}" readonly style="color:{{ $task->Tanggap <= 0 ? 'red' : 'green' }}">
                </div>
                <div class="col-md-2">
                  <label class="bold-italic" for="status">Status:</label>
                  <input class="form-control" type="text" value="{{ $task->Ms_Task_Status }}" readonly>
                </div>
                <hr style="border: 1px solid rgb(0, 0, 255); margin: 10px 0;">
          </div>
  @endforeach



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
