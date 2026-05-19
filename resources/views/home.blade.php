
@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Daily')

@section('vendor-style')

@endsection

@section('vendor-script')

@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.js" ></script>
<title>Home</title>

<script>

var labels = [@foreach($total_ba_daily_by_location as $wine) @php echo "'".$wine->rec_areacode."'"."," @endphp @endforeach];

var values = [@foreach($total_ba_daily_by_location as $wine) @php echo $wine->total_ba.","; @endphp @endforeach];
var chartEl = document.getElementById("pie-chart");
chartEl.height = 500;

const bgcolor = [];
  for(i = 0; i < labels.length; i++){
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      bgcolor.push("rgb(" + r + "," + g + "," + b + ")");
  };

var dnct1 = document.getElementById('pie-chart');
var myChart1 = new Chart(dnct1, {
  type: 'pie',
  data: {
    labels: labels,
    datasets: [{
      label: labels,
      data: values,
      borderWidth: 0,
      hoverOffset: 5,
      backgroundColor: bgcolor,
      cutout: 0
    }]
  },
  options: {
    layout: {
      padding: {
        bottom: 25
      }
    },
    plugins: {
      tooltip: {
        enabled: true,
        callbacks: {
          footer: (ttItem) => {
            let sum = 0;
            let dataArr = ttItem[0].dataset.data;
            dataArr.map(data => {
              sum += Number(data);
            });

            let percentage = (ttItem[0].parsed * 100 / sum).toFixed(2) + '%';
            return `Percentage of data: ${percentage}`;
          }
        }
      },
      /** Imported from a question linked above. 
          Apparently Works for ChartJS V2 **/
      datalabels: {
        formatter: (value, dnct1) => {
          let sum = 0;
          let dataArr = dnct1.chart.data.datasets[0].data;
          dataArr.map(data => {
            sum += Number(data);
          });

          let percentage = (value * 100 / sum).toFixed(2) + '%';
          return percentage;
        },
        color: '#fff',
      }
    }
  },
  plugins: [ChartDataLabels]
});  
</script>
<script>
  // var labels = chartData.map(function(item) {
  //     return item.Ms_Emp_Div;
  // });

  // var values = chartData.map(function(item) {
  //     return item.total_ba;
  // });
  var labels = ['',@foreach($total_ba_daily_by_div as $wine) @if($wine->Ms_Emp_Div == '') @php echo "'"."Driver"."'"."," @endphp @else @php echo "'".$wine->Ms_Emp_Div."'"."," @endphp @endif @endforeach];

  var values = [0,@foreach($total_ba_daily_by_div as $wine) @php echo $wine->total_ba.","; @endphp @endforeach];

  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: labels,
          datasets: [{
              label: '',
              data: values,
              backgroundColor: ['red', 'blue', 'green', 'orange', 'purple'],
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1
          }]
      },
      options: {
          plugins: {
              datalabels: {
                  anchor: 'end',
                  align: 'top',
                  formatter: function(value, context) {
                      return value;
                  },
                  color: 'red', // Ubah warna teks label di atas titik
                  font: {
                      weight: 'bold', // Atur teks tebal
                      size: 14 // Atur ukuran teks
                  }
              }
          },
          scales: {
               x: {
                  ticks: {
                      color: 'black', // Ubah warna label sumbu X
                      font: {
                          weight: 'bold', // Atur teks label sumbu X menjadi tebal
                          size: 15 // Atur ukuran teks label sumbu X
                      }
                  }
              },
              y: {
                  beginAtZero: true
              }

          }
      }
  });
</script>

@endsection

@section('content')

<div class="dropdown">
  <button class="dropbtn">Filter Period</button>
  <div class="dropdown-content">
    <a href="/home">Daily</a>
    <a href="/dashboard_weekly">Weekly</a>
    <a href="/dashboard_monthly">Monthly</a>
  </div>
</div>

<center>
  <h5 class="m-0 me-2">Daily BA By Divisi</h5>
</center>
<center>
<span>
  <canvas id="myChart" width="400" height="100"></canvas>
  {{--  <canvas id="myCharts" style="width:50%;max-width:300px"></canvas>  --}}
</span>
</center>
<br>
<div class="row">
  <div class="col-lg-4 col-md-4 order-1">
    <center>
    <h4 class="m-0 me-2" style="background-color: #5f4bdd; color: #fff; padding: 10px; text-align: center;">Daily Top 10 PIC </h4>
    </center>
    <br>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-12 mb-12">
        <div class="card">
          <div class="card-body">

            <div class="card-title d-flex align-items-start justify-content-between">
              {{--  <div class="dropdown">
                <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                  <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                  <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                  <a class="dropdown-item" href="javascript:void(0);">6 Month</a>
                  <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
                </div>
              </div>  --}}
            </div>
             <br><br>
            @foreach ($total_ba_bypic as $by_pic)
            <!--<span class="fw-semibold d-block mb-1"><a  href="/detail_pelaku/{{$by_pic->Ms_Emp_Code}}">{{ $by_pic->Ms_Emp_Code }}</a><small class="text-success fw-semibold">{{ $by_pic->Ms_Emp_Div }}</small></span>-->
            <!--<h4 class="card-title mb-2">{{ $by_pic->total_ba }}</h4>-->
                 @if($by_pic->Ms_Emp_Code == "")
                <span class="fw-semibold d-block mb-1">
                 Laka <small class="text-danger fw-semibold">({{  $by_pic->total_ba }})</small></span>
                <h6 class="card-title mb-2">{{ $by_pic->Ms_Emp_Div }}</h6>                
                 @else
            <span class="fw-semibold d-block mb-1"><a  href="/detail_pelaku/{{$by_pic->Ms_Emp_Code}}" target="blank">{{ $by_pic->Ms_Emp_Code }}</a><small class="text-danger fw-semibold">({{  $by_pic->total_ba }})</small></span>
            <h6 class="card-title mb-2">{{ $by_pic->Ms_Emp_Div }}</h6>
                 @endif  
            @endforeach
          </div>
        </div>
      </div>

      {{--  <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
            </div>
            <span>TES</span>
            <h3 class="card-title text-nowrap mb-1">TES</h3>
            <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> TES</small>
          </div>
        </div>
      </div>  --}}
    </div>
  </div>
  <!-- Total Revenue -->
  <!--/ Total Revenue -->
      <!-- </div>
<div class="row">
  <!-- Order Statistics -->
  <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
    <center>
    <h4 class="m-0 me-2" style="background-color: #5f4bdd; color: #fff; padding: 10px; text-align: center;">Daily BA By Category</h4>
    </center>
    <br>
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div class="card-title mb-0">
        </div>
        <div class="dropdown">
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column align-items-center gap-1">
            <h5 class="text-warning fw-semibold">Total BA Today = {{ $total_semua_ba }}</h5>
          </div>
          <div id=""></div>
        </div>
        <ul class="p-0 m-0">
           <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">BA Pelanggaran SOP</h6>
              </div>
              <div class="user-progress">
                @foreach ($itung_ba as $ba_pelanggaran)
                <small class="fw-semibold"><a class="underlineHover" href="/viewkategoriday/pelanggaran">{{ $ba_pelanggaran->total_ba_pelanggaran_sop }}</a></small>
                @endforeach
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">BA Perubahan SOP</h6>
              </div>
              <div class="user-progress">
                @foreach ($itung_ba as $ba_pelanggaran)
                <small class="fw-semibold"><a class="underlineHover" href="/viewkategoriday/perubahan">{{ $ba_pelanggaran->total_ba_perubahan_sop }}</a></small>
                @endforeach
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Kehilangan Dan Kerusakan</h6>
              </div>
              <div class="user-progress">
                @foreach ($itung_ba as $ba_pelanggaran)
                <small class="fw-semibold"><a class="underlineHover" href="/viewkategoriday/kehilangankerusakan">{{ $ba_pelanggaran->total_ba_kehilangan_kerusakan_aset }}</a></small>
                @endforeach
              </div>
            </div>
          </li>
           <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Pembelian Barang</h6>
              </div>
              <div class="user-progress">
                @foreach ($itung_ba as $ba_pelanggaran)
                <small class="fw-semibold"><a class="underlineHover" href="/viewkategoriday/pembelian">{{ $ba_pelanggaran->total_ba_pembelian }}</a></small>
                @endforeach
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">BA Laka</h6>
              </div>
              <div class="user-progress">
                @foreach ($itung_ba as $ba_pelanggaran)
                <small class="fw-semibold"><a class="underlineHover" href="/viewkategoriday/laka">{{ $ba_pelanggaran->total_ba_laka }}</a></small>
                @endforeach
              </div>
            </div>
          </li>
          {{--  <h1>Request Revisi</h1>  --}}
          {{--  <h5 class="text-warning fw-semibold">Request Revisi</h5>  --}}

          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">BA Revisi</h6>
              </div>
              <div class="user-progress">
                @foreach ($itung_ba as $ba_pelanggaran)
                <small class="fw-semibold"><a class="underlineHover" href="/viewkategoriday/revisi">{{ $ba_pelanggaran->total_ba_kesalahan_revisi }}</a></small>
                @endforeach
              </div>
            </div>
          </li>
          {{-- <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Kesalahan Sistem</h6>
              </div>
              <div class="user-progress">
                @foreach ($itung_ba as $ba_pelanggaran)
                <small class="fw-semibold">{{ $ba_pelanggaran->total_ba_kesalahan_sistem }}</small>
                @endforeach
              </div>
            </div>
          </li> --}}
          <!--<li class="d-flex mb-4 pb-1">-->
          <!--  <div class="avatar flex-shrink-0 me-3">-->
          <!--    <span class="avatar-initial rounded bg-label-primary"><i class='fa fa-book'></i></span>-->
          <!--  </div>-->
          <!--  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">-->
          <!--    <div class="me-2">-->
          <!--      <h6 class="mb-0">Temuan</h6>-->
          <!--    </div>-->
          <!--    <div class="user-progress">-->
          <!--      @foreach ($itung_ba as $ba_pelanggaran)-->
          <!--      <small class="fw-semibold">{{ $ba_pelanggaran->total_ba_kesalahan_sistem }}</small>-->
          <!--      @endforeach-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</li>-->
        </ul>
      </div>
    </div>
  </div>


  <!--/ Order Statistics -->

  <!-- Expense Overview -->
  <div class="col-md-6 col-lg-4 order-1 mb-4">
    <center>
    <h4 class="m-0 me-2" style="background-color: #5f4bdd; color: #fff; padding: 10px; text-align: center;">Daily BA By Location</h4>
    </center>
    <br>
    <div class="card">
      <canvas id="pie-chart" style="margin: 0 auto;"></canvas>
    </div>
  </div>
</div>

<style>
  /* Style tombol utama by Mas Malven*/
    .dropbtn {
    background-color: #5f4bdd;
    color: white;
    padding: 10px;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

/* Warna background dari tombol utama ketika isi konten dropdown ditampilkan */
.dropdown:hover .dropbtn {
    background-color: #14ac41;
}

/* Isi dari <div> - Diperlukan untuk memposisikan isi konten dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Isi konten dropdown (disembunyikan) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #2f303f;
    min-width: 100px;
    box-shadow: 0px 6px 14px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Link di dalam menu dropdown */
.dropdown-content a {
    color:#fff;
    padding: 10px 14px;
    text-decoration: none;
    display: block;
}

/* Warna link di dalam dropdown ketika disorot */
.dropdown-content a:hover {
 background-color:#14ac41;
 color: #fff !important;
}

/* Tampilkan isi konten dopdown ketika disorot */
.dropdown:hover .dropdown-content {
    display: block;
}
.google-visualization-tooltip {
  max-height: 200px; /* Sesuaikan tinggi maksimum legenda sesuai kebutuhan */
  overflow-y: auto; /* Munculkan scrollbar jika terlalu panjang */
  white-space: normal; /* Memastikan tampilan vertikal */
}



</style>


@endsection
