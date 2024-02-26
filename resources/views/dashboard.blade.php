@extends('layouts/layoutMaster')

@section('title', 'OB Dashboard')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/apex-charts/apexcharts.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendors/js/charts/apexcharts.min.js',
    ])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-ecommerce-dashboard.js'])
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="resources/assets/vendor/js/charts/apexcharts.min.js"></script>
  <script src="resources/assets/vendor/libs/apex-charts/apexcharts.js"></script>

@endsection

@section('content')
  <div class="row">
    <!-- View sales -->
    <div class="col-xl-4 mb-4 col-lg-5 col-12">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-7" style="color: rgba(17,36,65,0.93)">
            <div class="card-body text-nowrap">
              <h5 class="card-title mb-0">Welcome To OB Dashboard! </h5>
              <p class="mb-2">Total Booking Counts</p>
              <h6 class="mb-1" >{{$allBookings}}</h6>
              <a href="{{route('bookings.index')}}" class="btn btn-primary">View All</a>
            </div>
          </div>
          <div class="col-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="{{ asset('assets/img/img_2.png')}}" height="140"  width="120px" alt="bookings">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Statistics -->
    <div class="col-xl-8 mb-4 col-lg-7 col-12">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between mb-3">
            <h5 class="card-title mb-0">Statistics</h5>
{{--            <small class="text-muted">This Month Records</small>--}}
          </div>
        </div>
        <div class="card-body">
          <div class="row gy-3">
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-building ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0">{{number_format($allStations)}}</h5>
                  <small>Stations</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-list ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0">{{number_format($allOffendersCount)}}</h5>
                  <small>Offenders Recorded</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-tags ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0">{{number_format($allOffendedCount)}}</h5>
                  <small>Offended Recorded</small>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="d-flex align-items-center">
                <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-users ti-sm"></i></div>
                <div class="card-info">
                  <h5 class="mb-0">{{number_format($allActiveUsers)}}</h5>
                  <small>Active Users</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <section id="chartjs-chart">
      <div class="row">
        <!-- Horizontal Bar Chart Start -->
        <div class="col-xl-6 col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
              <div class="header-left">
                <p class="card-subtitle text-muted mb-25">{!! ucwords("Monthly Offenders by Gender") !!}</p>
{{--                <h4 class="card-title">{!! ucwords("Monthly Visits by Gender") !!}</h4>--}}
              </div>
            </div>
            <div class="card-body">here
              <canvas id="monthly-offenders" class="chartjs" data-height="400"></canvas>
            </div>
            <div class="header-right d-flex align-items-center pl-2">
              <div class="d-flex align-items-center">
                <span class="bullet bullet-primary"></span>
                <h6 class="mb-0 ml-50">{{ $maleMonthlyOffenderCount }} MALE</h6>
              </div>
              <div class="d-flex align-items-center ml-75">
                <span class="bullet bullet-danger"></span>
                <h6 class="mb-0 ml-50">{{ $femaleMonthlyOffenderCount }} FEMALE</h6>
              </div>
            </div>
          </div>
        </div>
        <script>
          $(document).ready(function() {
            var BarChart = {!! $BarChart !!};
            console.log("bar chart");
            console.log(BarChart);
            var ctx = document.getElementById('monthly-offenders').getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'bar',
              data: BarChart,
              options: {
                responsive:true,
                title:'MONTHLY OFFENDER',
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                },
                barThickness: 10
              }
            });
          });
        </script>
        <!-- Horizontal Bar Chart End -->
        <div class="col-xl-6 col-12 my-2">
          <div class="card">
            <div class="card-header">
              <p class="card-subtitle text-muted mb-25">{!! ucwords("Monthly Offenders by Age") !!}</p>
{{--              <h4 class="card-title">{!! ucwords("Monthly Offenders by AGE") !!}</h4>--}}
            </div>
            <div class="card-body">
              <canvas id="monthly-visitors-by-age1" height="274"></canvas>
            </div>
          </div>
        </div>
        <script>
          $(document).ready(function() {
            var monthlyData = {
              labels: {!! json_encode($labelschart) !!},
              datasets: [
                {
                  data: {!! json_encode($datachart) !!},
                  backgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56",
                    "#1ABC9C",
                    "#F1C40F",
                    "#9B59B6",
                    "#E74C3C",
                    "#2ECC71",
                    "#34495E",
                    "#3498DB"
                  ]
                }]
            };

            var ctx = document.getElementById('monthly-offenders-by-age1').getContext('2d');
            var myPieChart = new Chart(ctx, {
              type: 'pie',
              data: monthlyData,
              options: {
                responsive: true,
                maintainAspectRatio: false,
              }
            });
          });
        </script>

      </div>

      <div class="row">
        <div class="col-xl-6 col-6">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
              <div class="header-left">
                <p class="card-subtitle text-muted mb-25">Yearly bookings for {!! now()->year !!}</p>
              </div>
            </div>
            <div class="card-body">
              <canvas id="yearly-visitors" class="chartjs" data-height="600"></canvas>
            </div>
          </div>
        </div>

        <script>
          $(document).ready(function() {
            var yearlyData = {!! $yearlyData !!};
            var ctx = document.getElementById('yearly-bookings').getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: yearlyData.labels,
                datasets: [{
                  label: 'Offenders',
                  data: yearlyData.data,
                  fill: false,
                  borderWidth: 1,
                  borderColor: '#007bff',
                  tension: 0.1
                }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                }
              }
            }); });
        </script>
        <div class="col-xl-6 col-12">
          <div class="card">
            <div class="card-header">
              Visitors Chart
            </div>
            <div class="card-body">
              <canvas id="visitorChart" data-height="500"></canvas>
            </div>
          </div>
          <p class="card-text mb-0 pl-4 pb-5">TOTAL OFFENDERS RECORDED : {{ $allOffendersCount }}</p>
          <script>
            $(document).ready(function() {
              var chartData = <?php echo json_encode($chartDataL); ?>;
              var ctx = document.getElementById('visitorChart').getContext('2d');
              var chart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
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
        </div>
      </div>
    </section>
  <div class="my-5">
    <div>
      Stations List
    </div>
  <livewire:tables.stations/>
  </div>
  <hr/>
  <div class="my-5">
  <div>
    Officers List
  </div>
  <livewire:tables.officers/>
  </div>
  <div class="my-5">
    <div>
      Offenders List
    </div>
  <livewire:tables.offenders/>
  </div>
  <hr/>
  <div class="my-5">
    <div>
      Offended List
    </div>
  <livewire:tables.offendeds/>
  </div>

@endsection
