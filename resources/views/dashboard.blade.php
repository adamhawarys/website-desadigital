@extends('layout.master')

@section('content')
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <h5 class="mb-2">Pengajuan Layanan Surat</h5>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-envelope"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Pengajuan Surat</span>
                <span class="info-box-number">{{$totalPengajuan}}</span>
              </div>
              
            </div>
            
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="fas fa-envelope"></i></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Menunggu Diproses</span>
                <span class="info-box-number">{{$diproses}}</span>
              </div>
              
            </div>
            
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-envelope"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Disetujui</span>
                <span class="info-box-number">{{$disetujui}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="fas fa-envelope"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ditolak</span>
                <span class="info-box-number">{{$ditolak}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Small boxes (Stat box) -->
        <h5 class="mb-2">Pengaduan Masyarakat</h5>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-envelope"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Pengajuan Surat</span>
                <span class="info-box-number">{{$totalPengaduan}}</span>
              </div>
              
            </div>
            
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="fas fa-envelope"></i></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Menunggu Diproses</span>
                <span class="info-box-number">{{$aduanMenunggu}}</span>
              </div>
              
            </div>
            
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-envelope"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Diproses</span>
                <span class="info-box-number">{{$aduanDiproses}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="fas fa-envelope"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Selesai</span>
                <span class="info-box-number">{{$aduanSelesai}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          @if (auth()->user()->role == 'Admin')
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$users}}</h3>

                <p>Jumlah Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{ route('users.users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endif
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$jumlahDusun}}</h3>

                <p>Jumlah Dusun</p>
              </div>
              <div class="icon">
                <i class="fas fa-home"></i>
              </div>
              <a href="{{ route('statistik.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>2,979</h3>

                <p>Jumlah Kepala Keluarga</p>
              </div>
              <div class="icon">
                <i class="fas fa-address-card"></i>
              </div>
              <a href="{{ route('statistik.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> --}}
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-md-6">
             <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Jumlah Penduduk Berdasarkan Dusun</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-6">
            <!-- STACKED BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Jumlah Penduduk berdasarkan Usia</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-12">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Jumlah Penduduk berdasarkan Pendidikan</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="pendidikanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('js')
<!-- ChartJS -->
<script src="{{asset('adminlte3/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('adminlte3/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('adminlte3/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('adminlte3/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('adminlte3/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('adminlte3/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte3/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('adminlte3/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{asset('adminlte/dist/js/pages/dashboard.js')}}"></script> --}}
<script src="{{ asset('sa2/dist/sweetalert2.all.min.js') }}"></script>

<script>
$(function () {

  var labels = @json($labels);
  var lakiLaki = @json($jumlahLakiLaki);
  var perempuan = @json($jumlahPerempuan);

  var barChartData = {
    labels: labels,
    datasets: [
      {
        label: 'Laki-laki',
        backgroundColor: 'rgba(54, 162, 235, 0.9)',
        borderColor: 'rgba(54, 162, 235, 1)',
        data: lakiLaki
      },
      {
        label: 'Perempuan',
        backgroundColor: 'rgba(255, 99, 132, 0.9)',
        borderColor: 'rgba(255, 99, 132, 1)',
        data: perempuan
      }
    ]
  };

  var barChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  };

  var barChartCanvas = $('#barChart').get(0).getContext('2d');

  new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })

  var labels = [
  '0–15 Tahun',
  '15–30 Tahun',
  '31–60 Tahun',
  '61 Tahun ke atas'
];

var jumlahPenduduk = [2270, 2637, 4122, 852];
var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');

var stackedBarChartData = {
  labels: labels,
  datasets: [{
    label: 'Jumlah Penduduk',
    backgroundColor: '#28a745',
    data: jumlahPenduduk
  }]
};

var stackedBarChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    xAxes: [{
      stacked: true
    }],
    yAxes: [{
      stacked: true,
      ticks: {
        beginAtZero: true
      }
    }]
  }
};

new Chart(stackedBarChartCanvas, {
  type: 'bar',
  data: stackedBarChartData,
  options: stackedBarChartOptions
})

// ===============================
// Chart Jumlah Penduduk Pendidikan
// ===============================

var pendidikanLabels = [
  'Tidak Sekolah',
  'SD',
  'SMP',
  'SMA',
  'D1',
  'D2',
  'D3',
  'D4',
  'S1',
  'S2',
  'S3'
];

var pendidikanData = [
  1816,
  3168,
  1763,
  2706,
  4,
  0,
  1,
  4,
  23,
  3,
  0
];

var pendidikanCtx = $('#pendidikanChart').get(0).getContext('2d');

new Chart(pendidikanCtx, {
  type: 'bar',
  data: {
    labels: pendidikanLabels,
    datasets: [{
      label: 'Jumlah Penduduk',
      backgroundColor: '#17a2b8',
      borderColor: '#17a2b8',
      data: pendidikanData
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});



});
</script>





{{-- @session('success')
<script>
    Swal.fire({
    title: "Berhasil",
    text: "{{ session('success') }}",
    icon: "success"
  });
</script>
@endsession

@session('failed')
<script>
    Swal.fire({
    title: "Gagal",
    text: "{{ session('failed') }}",
    icon: "error"
  });
</script>
@endsession --}}


@endsection