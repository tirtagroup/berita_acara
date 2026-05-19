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
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>



<div class="container">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span>Weekly History</h4>
   <li class="nav-item dropdown">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Periode
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="list_report_all_history_new_perday">Daily</a>
              <a class="dropdown-item" href="list_report_all_history_new_weekly">Weekly</a>
              <a class="dropdown-item" href="list_report_all_history_new_monthly">Monthly</a>
          </div>
</div>
    <hr>
    <h4>Week 1</h4>
<div class="row">
        <div class="panel panel-primary filterable">
            <table class="table" id="dataTable">
                <thead>
                  <tr >
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      <th>Interview</th>
                      <th>Masuk</th>
                  </tr>
              </thead>
              <thead>
                <tr class="filters">
                </tr>
            </thead>
                <tbody>
                  @foreach($week1 as $row)
                  <tr>

                    <td>{{$row->lowongan}}</td>
                    <td>{{$row->total_lamar}}</td>
                    <td>{{$row->total_cv_masuk}}</td>
                    <td>{{$row->total_panggil}}</td>
                    <td>{{$row->total_lolos_call}}</td>
                    <td>{{$row->total_interview}}</td>
                    <td>{{$row->total_lolos_training}}</td>
                  </tr>
                @endforeach
                </tbody>
            </table>
          </div>
        </div>
<br>
<h4>Week 2</h4>
<div class="row">
  <div class="panel panel-primary filterable">
      <table class="table" id="dataTable2">
          <thead>
            <tr >
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      <th>Interview</th>
                      <th>Masuk</th>
            </tr>
        </thead>
        <thead>
          <tr class="filters">
          </tr>
      </thead>
          <tbody>
            @foreach($week2 as $row)
            <tr>
              <td>{{$row->lowongan}}</td>
              <td>{{$row->total_lamar}}</td>
              <td>{{$row->total_cv_masuk}}</td>
              <td>{{$row->total_panggil}}</td>
              <td>{{$row->total_lolos_call}}</td>
              <td>{{$row->total_interview}}</td>
              <td>{{$row->total_lolos_training}}</td>
            </tr>
          @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <br>
  <h4>Week 3</h4>
<div class="row">
  <div class="panel panel-primary filterable">
      <table class="table" id="dataTable3">
          <thead>
            <tr >
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      <th>Interview</th>
                      <th>Masuk</th>
            </tr>
        </thead>
        <thead>
          <tr class="filters">
          </tr>
      </thead>
          <tbody>
            @foreach($week3 as $row)
            <tr>

              <td>{{$row->lowongan}}</td>
              <td>{{$row->total_lamar}}</td>
              <td>{{$row->total_cv_masuk}}</td>
              <td>{{$row->total_panggil}}</td>
              <td>{{$row->total_lolos_call}}</td>
              <td>{{$row->total_interview}}</td>
              <td>{{$row->total_lolos_training}}</td>
            </tr>
          @endforeach
          </tbody>
      </table>
    </div>
  </div>
  <br>
  <h4>Week 4</h4>
  <div class="row">
    <div class="panel panel-primary filterable">
        <table class="table" id="dataTable4">
            <thead>
              <tr >
                        <th>Posisi</th>
                        <th>Open</th>
                        <th>CV In </th>
                        <th>Call</th>
                        <th>Call OK</th>
                        <th>Interview</th>
                        <th>Masuk</th>
              </tr>
          </thead>
          <thead>
            <tr class="filters">
            </tr>
        </thead>
            <tbody>
              @foreach($week4 as $row)
              <tr>

                <td>{{$row->lowongan}}</td>
                <td>{{$row->total_lamar}}</td>
                <td>{{$row->total_cv_masuk}}</td>
                <td>{{$row->total_panggil}}</td>
                <td>{{$row->total_lolos_call}}</td>
                <td>{{$row->total_interview}}</td>
                <td>{{$row->total_lolos_training}}</td>
              </tr>
            @endforeach
            </tbody>
        </table>
      </div>
    </div>
  <br>
  <h4>Week 5</h4>
<div class="row">
  <div class="panel panel-primary filterable">
      <table class="table" id="dataTable5">
          <thead>
            <tr >
                      <th>Posisi</th>
                      <th>Open</th>
                      <th>CV In </th>
                      <th>Call</th>
                      <th>Call OK</th>
                      <th>Interview</th>
                      <th>Masuk</th>
            </tr>
        </thead>
        <thead>
          <tr class="filters">
          </tr>
      </thead>
          <tbody>
            @foreach($week5 as $row)
            <tr>

              <td>{{$row->lowongan}}</td>
              <td>{{$row->total_lamar}}</td>
              <td>{{$row->total_cv_masuk}}</td>
              <td>{{$row->total_panggil}}</td>
              <td>{{$row->total_lolos_call}}</td>
              <td>{{$row->total_interview}}</td>
              <td>{{$row->total_lolos_training}}</td>
            </tr>
          @endforeach
          </tbody>
      </table>
    </div>
  </div>

    <br>
    <h4>Week 6</h4>
    <div class="row">
      <div class="panel panel-primary filterable">
          <table class="table" id="dataTable6">
              <thead>
                <tr >
                          <th>Posisi</th>
                          <th>Open</th>
                          <th>CV In </th>
                          <th>Call</th>
                          <th>Call OK</th>
                          <th>Interview</th>
                          <th>Masuk</th>
                </tr>
            </thead>
            <thead>
              <tr class="filters">
              </tr>
          </thead>
              <tbody>
                @foreach($week6 as $row)
                <tr>

                  <td>{{$row->lowongan}}</td>
                  <td>{{$row->total_lamar}}</td>
                  <td>{{$row->total_cv_masuk}}</td>
                  <td>{{$row->total_panggil}}</td>
                  <td>{{$row->total_lolos_call}}</td>
                  <td>{{$row->total_interview}}</td>
                  <td>{{$row->total_lolos_training}}</td>
                </tr>
              @endforeach
              </tbody>
          </table>
        </div>
      </div>
    <br>
    <h4>Week 7</h4>
    <div class="row">
      <div class="panel panel-primary filterable">
          <table class="table" id="dataTable7">
              <thead>
                <tr >
                          <th>Posisi</th>
                          <th>Open</th>
                          <th>CV In </th>
                          <th>Call</th>
                          <th>Call OK</th>
                          <th>Interview</th>
                          <th>Masuk</th>
                </tr>
            </thead>
            <thead>
              <tr class="filters">
              </tr>
          </thead>
              <tbody>
                @foreach($week7 as $row)
                <tr>

                  <td>{{$row->lowongan}}</td>
                  <td>{{$row->total_lamar}}</td>
                  <td>{{$row->total_cv_masuk}}</td>
                  <td>{{$row->total_panggil}}</td>
                  <td>{{$row->total_lolos_call}}</td>
                  <td>{{$row->total_interview}}</td>
                  <td>{{$row->total_lolos_training}}</td>
                </tr>
              @endforeach
              </tbody>
          </table>
        </div>
      </div>
    <br>
    <h4>Week 8</h4>
    <div class="row">
      <div class="panel panel-primary filterable">
          <table class="table" id="dataTable8">
              <thead>
                <tr >
                          <th>Posisi</th>
                          <th>Open</th>
                          <th>CV In </th>
                          <th>Call</th>
                          <th>Call OK</th>
                          <th>Interview</th>
                          <th>Masuk</th>
                </tr>
            </thead>
            <thead>
              <tr class="filters">
              </tr>
          </thead>
              <tbody>
                @foreach($week8 as $row)
                <tr>

                  <td>{{$row->lowongan}}</td>
                  <td>{{$row->total_lamar}}</td>
                  <td>{{$row->total_cv_masuk}}</td>
                  <td>{{$row->total_panggil}}</td>
                  <td>{{$row->total_lolos_call}}</td>
                  <td>{{$row->total_interview}}</td>
                  <td>{{$row->total_lolos_training}}</td>
                </tr>
              @endforeach
              </tbody>
          </table>
        </div>
      </div>
      <br>
      <h4>Week 9</h4>
      <div class="row">
        <div class="panel panel-primary filterable">
            <table class="table" id="dataTable9">
                <thead>
                  <tr >
                            <th>Posisi</th>
                            <th>Open</th>
                            <th>CV In </th>
                            <th>Call</th>
                            <th>Call OK</th>
                            <th>Interview</th>
                            <th>Masuk</th>
                  </tr>
              </thead>
              <thead>
                <tr class="filters">
                </tr>
            </thead>
                <tbody>
                  @foreach($week9 as $row)
                  <tr>

                    <td>{{$row->lowongan}}</td>
                    <td>{{$row->total_lamar}}</td>
                    <td>{{$row->total_cv_masuk}}</td>
                    <td>{{$row->total_panggil}}</td>
                    <td>{{$row->total_lolos_call}}</td>
                    <td>{{$row->total_interview}}</td>
                    <td>{{$row->total_lolos_training}}</td>
                  </tr>
                @endforeach
                </tbody>
            </table>
          </div>
        </div>
        <br>
        <h4>Week 10</h4>
        <div class="row">
          <div class="panel panel-primary filterable">
              <table class="table" id="dataTable10">
                  <thead>
                    <tr >
                              <th>Posisi</th>
                              <th>Open</th>
                              <th>CV In </th>
                              <th>Call</th>
                              <th>Call OK</th>
                              <th>Interview</th>
                              <th>Masuk</th>
                    </tr>
                </thead>
                <thead>
                  <tr class="filters">
                  </tr>
              </thead>
                  <tbody>
                    @foreach($week10 as $row)
                    <tr>

                      <td>{{$row->lowongan}}</td>
                      <td>{{$row->total_lamar}}</td>
                      <td>{{$row->total_cv_masuk}}</td>
                      <td>{{$row->total_panggil}}</td>
                      <td>{{$row->total_lolos_call}}</td>
                      <td>{{$row->total_interview}}</td>
                      <td>{{$row->total_lolos_training}}</td>
                    </tr>
                  @endforeach
                  </tbody>
              </table>
            </div>
          </div>
          <br>
          <h4>Week 11</h4>
          <div class="row">
            <div class="panel panel-primary filterable">
                <table class="table" id="dataTable11">
                    <thead>
                      <tr >
                                <th>Posisi</th>
                                <th>Open</th>
                                <th>CV In </th>
                                <th>Call</th>
                                <th>Call OK</th>
                                <th>Interview</th>
                                <th>Masuk</th>
                      </tr>
                  </thead>
                  <thead>
                    <tr class="filters">
                    </tr>
                </thead>
                    <tbody>
                      @foreach($week11 as $row)
                      <tr>

                        <td>{{$row->lowongan}}</td>
                        <td>{{$row->total_lamar}}</td>
                        <td>{{$row->total_cv_masuk}}</td>
                        <td>{{$row->total_panggil}}</td>
                        <td>{{$row->total_lolos_call}}</td>
                        <td>{{$row->total_interview}}</td>
                        <td>{{$row->total_lolos_training}}</td>
                      </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
            </div>
            <br>
            <h4>Week 12</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable12">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week12 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 13</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable13">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week13 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 14</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable14">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week14 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 15</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable15">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week15 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 16</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable16">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week16 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 17</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable17">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week17 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 18</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable18">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week18 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 19</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable19">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week19 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 20</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable20">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week20 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 21</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable21">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week21 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 22</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable22">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week22 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 23</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable23">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week23 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 24</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable24">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week24 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 25</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable25">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week25 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 26</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable26">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week26 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 27</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable27">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week27 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 28</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable28">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week28 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 29</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable29">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week29 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 30</h4>
            <div class="row">
              <div class="panel panel-primary filterable">
                  <table class="table" id="dataTable30">
                      <thead>
                        <tr >
                                  <th>Posisi</th>
                                  <th>Open</th>
                                  <th>CV In </th>
                                  <th>Call</th>
                                  <th>Call OK</th>
                                  <th>Interview</th>
                                  <th>Masuk</th>
                        </tr>
                    </thead>
                    <thead>
                      <tr class="filters">
                      </tr>
                  </thead>
                      <tbody>
                        @foreach($week30 as $row)
                        <tr>

                          <td>{{$row->lowongan}}</td>
                          <td>{{$row->total_lamar}}</td>
                          <td>{{$row->total_cv_masuk}}</td>
                          <td>{{$row->total_panggil}}</td>
                          <td>{{$row->total_lolos_call}}</td>
                          <td>{{$row->total_interview}}</td>
                          <td>{{$row->total_lolos_training}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
              <br>
              <h4>Week 31</h4>
              <div class="row">
                <div class="panel panel-primary filterable">
                    <table class="table" id="dataTable31">
                        <thead>
                          <tr >
                                    <th>Posisi</th>
                                    <th>Open</th>
                                    <th>CV In </th>
                                    <th>Call</th>
                                    <th>Call OK</th>
                                    <th>Interview</th>
                                    <th>Masuk</th>
                          </tr>
                      </thead>
                      <thead>
                        <tr class="filters">
                        </tr>
                    </thead>
                        <tbody>
                          @foreach($week31 as $row)
                          <tr>

                            <td>{{$row->lowongan}}</td>
                            <td>{{$row->total_lamar}}</td>
                            <td>{{$row->total_cv_masuk}}</td>
                            <td>{{$row->total_panggil}}</td>
                            <td>{{$row->total_lolos_call}}</td>
                            <td>{{$row->total_interview}}</td>
                            <td>{{$row->total_lolos_training}}</td>
                          </tr>
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
                <br>
                <h4>Week 32</h4>
                <div class="row">
                  <div class="panel panel-primary filterable">
                      <table class="table" id="dataTable32">
                          <thead>
                            <tr >
                                      <th>Posisi</th>
                                      <th>Open</th>
                                      <th>CV In </th>
                                      <th>Call</th>
                                      <th>Call OK</th>
                                      <th>Interview</th>
                                      <th>Masuk</th>
                            </tr>
                        </thead>
                        <thead>
                          <tr class="filters">
                          </tr>
                      </thead>
                          <tbody>
                            @foreach($week32 as $row)
                            <tr>

                              <td>{{$row->lowongan}}</td>
                              <td>{{$row->total_lamar}}</td>
                              <td>{{$row->total_cv_masuk}}</td>
                              <td>{{$row->total_panggil}}</td>
                              <td>{{$row->total_lolos_call}}</td>
                              <td>{{$row->total_interview}}</td>
                              <td>{{$row->total_lolos_training}}</td>
                            </tr>
                          @endforeach
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <br>
                  <h4>Week 33</h4>
                  <div class="row">
                    <div class="panel panel-primary filterable">
                        <table class="table" id="dataTable33">
                            <thead>
                              <tr >
                                        <th>Posisi</th>
                                        <th>Open</th>
                                        <th>CV In </th>
                                        <th>Call</th>
                                        <th>Call OK</th>
                                        <th>Interview</th>
                                        <th>Masuk</th>
                              </tr>
                          </thead>
                          <thead>
                            <tr class="filters">
                            </tr>
                        </thead>
                            <tbody>
                              @foreach($week33 as $row)
                              <tr>

                                <td>{{$row->lowongan}}</td>
                                <td>{{$row->total_lamar}}</td>
                                <td>{{$row->total_cv_masuk}}</td>
                                <td>{{$row->total_panggil}}</td>
                                <td>{{$row->total_lolos_call}}</td>
                                <td>{{$row->total_interview}}</td>
                                <td>{{$row->total_lolos_training}}</td>
                              </tr>
                            @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <br>
                    <h4>Week 34</h4>
                    <div class="row">
                      <div class="panel panel-primary filterable">
                          <table class="table" id="dataTable34">
                              <thead>
                                <tr >
                                          <th>Posisi</th>
                                          <th>Open</th>
                                          <th>CV In </th>
                                          <th>Call</th>
                                          <th>Call OK</th>
                                          <th>Interview</th>
                                          <th>Masuk</th>
                                </tr>
                            </thead>
                            <thead>
                              <tr class="filters">
                              </tr>
                          </thead>
                              <tbody>
                                @foreach($week34 as $row)
                                <tr>

                                  <td>{{$row->lowongan}}</td>
                                  <td>{{$row->total_lamar}}</td>
                                  <td>{{$row->total_cv_masuk}}</td>
                                  <td>{{$row->total_panggil}}</td>
                                  <td>{{$row->total_lolos_call}}</td>
                                  <td>{{$row->total_interview}}</td>
                                  <td>{{$row->total_lolos_training}}</td>
                                </tr>
                              @endforeach
                              </tbody>
                          </table>
                        </div>
                      </div>
                      <br>
                      <h4>Week 35</h4>
                      <div class="row">
                        <div class="panel panel-primary filterable">
                            <table class="table" id="dataTable35">
                                <thead>
                                  <tr >
                                            <th>Posisi</th>
                                            <th>Open</th>
                                            <th>CV In </th>
                                            <th>Call</th>
                                            <th>Call OK</th>
                                            <th>Interview</th>
                                            <th>Masuk</th>
                                  </tr>
                              </thead>
                              <thead>
                                <tr class="filters">
                                </tr>
                            </thead>
                                <tbody>
                                  @foreach($week35 as $row)
                                  <tr>

                                    <td>{{$row->lowongan}}</td>
                                    <td>{{$row->total_lamar}}</td>
                                    <td>{{$row->total_cv_masuk}}</td>
                                    <td>{{$row->total_panggil}}</td>
                                    <td>{{$row->total_lolos_call}}</td>
                                    <td>{{$row->total_interview}}</td>
                                    <td>{{$row->total_lolos_training}}</td>
                                  </tr>
                                @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>
                        <br>
                        <h4>Week 36</h4>
                        <div class="row">
                          <div class="panel panel-primary filterable">
                              <table class="table" id="dataTable36">
                                  <thead>
                                    <tr >
                                              <th>Posisi</th>
                                              <th>Open</th>
                                              <th>CV In </th>
                                              <th>Call</th>
                                              <th>Call OK</th>
                                              <th>Interview</th>
                                              <th>Masuk</th>
                                    </tr>
                                </thead>
                                <thead>
                                  <tr class="filters">
                                  </tr>
                              </thead>
                                  <tbody>
                                    @foreach($week36 as $row)
                                    <tr>

                                      <td>{{$row->lowongan}}</td>
                                      <td>{{$row->total_lamar}}</td>
                                      <td>{{$row->total_cv_masuk}}</td>
                                      <td>{{$row->total_panggil}}</td>
                                      <td>{{$row->total_lolos_call}}</td>
                                      <td>{{$row->total_interview}}</td>
                                      <td>{{$row->total_lolos_training}}</td>
                                    </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                            </div>
                          </div>
                          <br>
                          <h4>Week 37</h4>
                          <div class="row">
                            <div class="panel panel-primary filterable">
                                <table class="table" id="dataTable37">
                                    <thead>
                                      <tr >
                                                <th>Posisi</th>
                                                <th>Open</th>
                                                <th>CV In </th>
                                                <th>Call</th>
                                                <th>Call OK</th>
                                                <th>Interview</th>
                                                <th>Masuk</th>
                                      </tr>
                                  </thead>
                                  <thead>
                                    <tr class="filters">
                                    </tr>
                                </thead>
                                    <tbody>
                                      @foreach($week37 as $row)
                                      <tr>

                                        <td>{{$row->lowongan}}</td>
                                        <td>{{$row->total_lamar}}</td>
                                        <td>{{$row->total_cv_masuk}}</td>
                                        <td>{{$row->total_panggil}}</td>
                                        <td>{{$row->total_lolos_call}}</td>
                                        <td>{{$row->total_interview}}</td>
                                        <td>{{$row->total_lolos_training}}</td>
                                      </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>
                            <br>
                            <h4>Week 38</h4>
                            <div class="row">
                              <div class="panel panel-primary filterable">
                                  <table class="table" id="dataTable38">
                                      <thead>
                                        <tr >
                                                  <th>Posisi</th>
                                                  <th>Open</th>
                                                  <th>CV In </th>
                                                  <th>Call</th>
                                                  <th>Call OK</th>
                                                  <th>Interview</th>
                                                  <th>Masuk</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                      <tr class="filters">
                                      </tr>
                                  </thead>
                                      <tbody>
                                        @foreach($week38 as $row)
                                        <tr>

                                          <td>{{$row->lowongan}}</td>
                                          <td>{{$row->total_lamar}}</td>
                                          <td>{{$row->total_cv_masuk}}</td>
                                          <td>{{$row->total_panggil}}</td>
                                          <td>{{$row->total_lolos_call}}</td>
                                          <td>{{$row->total_interview}}</td>
                                          <td>{{$row->total_lolos_training}}</td>
                                        </tr>
                                      @endforeach
                                      </tbody>
                                  </table>
                                </div>
                              </div>
                              <br>
                              <h4>Week 39</h4>
                              <div class="row">
                                <div class="panel panel-primary filterable">
                                    <table class="table" id="dataTable39">
                                        <thead>
                                          <tr >
                                                    <th>Posisi</th>
                                                    <th>Open</th>
                                                    <th>CV In </th>
                                                    <th>Call</th>
                                                    <th>Call OK</th>
                                                    <th>Interview</th>
                                                    <th>Masuk</th>
                                          </tr>
                                      </thead>
                                      <thead>
                                        <tr class="filters">
                                        </tr>
                                    </thead>
                                        <tbody>
                                          @foreach($week39 as $row)
                                          <tr>

                                            <td>{{$row->lowongan}}</td>
                                            <td>{{$row->total_lamar}}</td>
                                            <td>{{$row->total_cv_masuk}}</td>
                                            <td>{{$row->total_panggil}}</td>
                                            <td>{{$row->total_lolos_call}}</td>
                                            <td>{{$row->total_interview}}</td>
                                            <td>{{$row->total_lolos_training}}</td>
                                          </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                                <br>
                                <h4>Week 40</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable40">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week40 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 41</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable41">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week41 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 42</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable42">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week42 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 43</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable43">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week43 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 44</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable44">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week44 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 45</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable45">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week45 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 46</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable46">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week46 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 47</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable47">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week47 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 48</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable48">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week48 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 49</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable49">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week49 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 50</h4>
                                <div class="row">
                                  <div class="panel panel-primary filterable">
                                      <table class="table" id="dataTable50">
                                          <thead>
                                            <tr >
                                                      <th>Posisi</th>
                                                      <th>Open</th>
                                                      <th>CV In </th>
                                                      <th>Call</th>
                                                      <th>Call OK</th>
                                                      <th>Interview</th>
                                                      <th>Masuk</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                          <tr class="filters">
                                          </tr>
                                      </thead>
                                          <tbody>
                                            @foreach($week50 as $row)
                                            <tr>

                                              <td>{{$row->lowongan}}</td>
                                              <td>{{$row->total_lamar}}</td>
                                              <td>{{$row->total_cv_masuk}}</td>
                                              <td>{{$row->total_panggil}}</td>
                                              <td>{{$row->total_lolos_call}}</td>
                                              <td>{{$row->total_interview}}</td>
                                              <td>{{$row->total_lolos_training}}</td>
                                            </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <br>
                                  <h4>Week 51</h4>
                                  <div class="row">
                                    <div class="panel panel-primary filterable">
                                        <table class="table" id="dataTable51">
                                            <thead>
                                              <tr >
                                                        <th>Posisi</th>
                                                        <th>Open</th>
                                                        <th>CV In </th>
                                                        <th>Call</th>
                                                        <th>Call OK</th>
                                                        <th>Interview</th>
                                                        <th>Masuk</th>
                                              </tr>
                                          </thead>
                                          <thead>
                                            <tr class="filters">
                                            </tr>
                                        </thead>
                                            <tbody>
                                              @foreach($week51 as $row)
                                              <tr>

                                                <td>{{$row->lowongan}}</td>
                                                <td>{{$row->total_lamar}}</td>
                                                <td>{{$row->total_cv_masuk}}</td>
                                                <td>{{$row->total_panggil}}</td>
                                                <td>{{$row->total_lolos_call}}</td>
                                                <td>{{$row->total_interview}}</td>
                                                <td>{{$row->total_lolos_training}}</td>
                                              </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                      </div>
                                    </div>
                                    <br>
                                    <h4>Week 52</h4>
                                    <div class="row">
                                      <div class="panel panel-primary filterable">
                                          <table class="table" id="dataTable52">
                                              <thead>
                                                <tr >
                                                          <th>Posisi</th>
                                                          <th>Open</th>
                                                          <th>CV In </th>
                                                          <th>Call</th>
                                                          <th>Call OK</th>
                                                          <th>Interview</th>
                                                          <th>Masuk</th>
                                                </tr>
                                            </thead>
                                            <thead>
                                              <tr class="filters">
                                              </tr>
                                          </thead>
                                              <tbody>
                                                @foreach($week52 as $row)
                                                <tr>

                                                  <td>{{$row->lowongan}}</td>
                                                  <td>{{$row->total_lamar}}</td>
                                                  <td>{{$row->total_cv_masuk}}</td>
                                                  <td>{{$row->total_panggil}}</td>
                                                  <td>{{$row->total_lolos_call}}</td>
                                                  <td>{{$row->total_interview}}</td>
                                                  <td>{{$row->total_lolos_training}}</td>
                                                </tr>
                                              @endforeach
                                              </tbody>
                                          </table>
                                        </div>
                                      </div>
                                      <br>


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

<script>
  $(document).ready(function() {
      $('#dataTable2').DataTable( {
          dom: 'Bfrtip',
          buttons: [
            'excel'
          ]
      } );
  } );
  </script>

  <script>
    $(document).ready(function() {
        $('#dataTable3').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable4').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable5').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable6').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable7').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable8').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable9').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable10').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable11').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable12').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable13').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable14').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable15').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable16').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable17').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable18').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable19').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable20').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable21').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable22').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable23').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable24').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable25').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable26').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable27').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable28').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable29').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable30').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable31').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable32').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable33').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable34').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable35').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable36').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable37').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable38').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable39').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable40').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable41').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable42').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable43').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable44').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable45').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable46').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable47').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable48').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable49').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable50').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable51').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>
  <script>
    $(document).ready(function() {
        $('#dataTable52').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'excel'
            ]
        } );
    } );
  </script>

<script>

  $(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>

<style>
  .filterable {
    margin-top: 15px;
  }
  .filterable .panel-heading .pull-right {
      margin-top: -20px;
  }
  .filterable .filters input[disabled] {
      background-color: transparent;
      border: none;
      cursor: auto;
      box-shadow: none;
      padding: 0;
      height: auto;
  }
  .filterable .filters input[disabled]::-webkit-input-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]::-moz-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]:-ms-input-placeholder {
      color: #333;
  }
</style>

<script>
  $(document).ready(function() {
        $('#dataTable').DataTable();
  });
</script>

@endsection
