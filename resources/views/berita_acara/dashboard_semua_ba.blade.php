@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />

<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<!-- Row Group CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')}}">
<!-- Form Validation -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>

<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

<!-- Form Validation -->
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script type="text/javascript">

// datatable (jquery)
$(function () {
  var dt_basic_table = $('.datatables-basic');

  // DataTable with buttons
  // --------------------------------------------------------------------

  if (dt_basic_table.length) {
    dt_basic = dt_basic_table.DataTable({
      order: [[1, 'desc']],
      dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',      
      displayLength: 5,
      lengthMenu: [5, 25, 50, 75, 100],
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-primary dropdown-toggle me-2',
          text: '<i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
          buttons: [
            {
              extend: 'csv',
              text: '<i class="bx bx-file me-1" ></i>Csv',
              className: 'dropdown-item'
            },
            {
              extend: 'excel',
              text: '<i class="bx bxs-file-export me-1"></i>Excel',
              className: 'dropdown-item'
            },
            {
              extend: 'pdf',
              text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
              className: 'dropdown-item'
            },
            {
              extend: 'copy',
              text: '<i class="bx bx-copy me-1" ></i>Copy',
              className: 'dropdown-item'
            }
          ]
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['full_name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
  }

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
  



</script>


@endsection


@section('content')



<div class="row">
  <div class="col-xl">
    <div class="card mb-1">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">BA Pelaku</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">  
          <table id = "apiTable" class="datatables-basic">
            <thead>
                <tr>
                  <th>Pelaku </th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelaku as $row)
                <tr>
                  <td>{{$row->Ms_Emp_Code}}</td>
                  <td>{{$row->total}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->Ms_Emp_Code}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl">
    <div class="card mb-1">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">BA Pelapor</h5>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">  
          <table id = "apiTable" class="datatables-basic">
            <thead>
                <tr>
                  <th>Pelapor </th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelapor as $row)
                <tr>
                  <td>{{$row->Ms_Pelapor_Code}}</td>
                  <td>{{$row->total}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->Ms_Pelapor_Code}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div> 
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl">
    <div class="card mb-1">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">BA Kasus</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">  
          <table id = "apiTable" class="datatables-basic">
                  <thead>
                      <tr>
                        <th>Kasus </th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($kasus as $row)
                      <tr>
                        <td>{{$row->Ms_Kasus}}</td>
                        <td>{{$row->total}}</td>
                        <td>
                          <button type="button" class="btn btn-light">
                            <a href="/detail_pelaku/{{$row->Ms_Kasus}}"class="btn btn-outline-success">View</a>
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
          </table>
        </div> 
      </div>
    </div>
  </div>
  <div class="col-xl">
    <div class="card mb-1">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">BA Detail kasus</h5>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">  
          <table id = "apiTable" class="datatables-basic">
            <thead>
                <tr>
                  <th>Detail Kasus </th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detail_kasus as $row)
                <tr>
                  <td>{{$row->MS_Detail_Kasus}}</td>
                  <td>{{$row->total}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->MS_Detail_Kasus}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div> 
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl">
    <div class="card mb-1">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">BA Divisi</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">  
          <table id = "apiTable" class="datatables-basic">
            <thead>
                <tr>
                  <th>Divisi </th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devisi as $row)
                <tr>
                  <td>{{$row->Ms_Emp_Div}}</td>
                  <td>{{$row->total}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->Ms_Emp_Div}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl">
    <div class="card mb-1">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">BA Kategori</h5>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">  
          <table id = "apiTable" class="datatables-basic">
            <thead>
                <tr>
                  <th>Kategori </th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori as $row)
                <tr>
                  
                  <td>kerusakan</td>
                  <td>{{$row->kerusakan}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/kerusakan"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>revisi</td>
                  <td>{{$row->revisi}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/revisi"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>disiplin</td>
                  <td>{{$row->disiplin}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->disiplin}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>salahisi</td>
                  <td>{{$row->salahisi}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->salahisi}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>  
                <tr>
                  <td>noclosing</td>
                  <td>{{$row->noclosing}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->noclosing}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>            
                <tr>
                  <td>laka</td>
                  <td>{{$row->laka}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->laka}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr> 
                <tr>
                  <td>pembelian</td>
                  <td>{{$row->pembelian}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->pembelian}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>             
                <tr>
                  <td>kehilangan</td>
                  <td>{{$row->kehilangan}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->kehilangan}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr>             
                <tr>
                  <td>perubahansop</td>
                  <td>{{$row->perubahansop}}</td>
                  <td>
                    <button type="button" class="btn btn-light">
                      <a href="/detail_pelaku/{{$row->perubahansop}}"class="btn btn-outline-success">View</a>
                    </button>
                  </td>
                </tr> 
              @endforeach
            </tbody>
          </table>
        </div> 
      </div>
    </div>
  </div>
</div>

</hr>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<style>
    .select-container {
        display: flex;
        gap: 10px; /* Jarak antara kedua dropdown */
        align-items: center;
    }

    .form-control {
        width: 400px; /* Sesuaikan lebar dropdown sesuai kebutuhan */
    }
</style>

@endsection
