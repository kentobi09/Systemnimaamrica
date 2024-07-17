  <?php include('fetch-dashboard.php');
  include('display-bar.php');
  $initial_passed = isset($passed_count) ? $passed_count : 0;
  $initial_failed = isset($failed_count) ? $failed_count : 0;
  $initial_pending = isset($pending_count) ? $pending_count : 0;
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />


  <title>Dashboard</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
   <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
  <!-- JS for Pie Chart-->
  <script>

    var initialData = {
      passed: <?php echo json_encode($passed_count); ?>,
      failed: <?php echo json_encode($failed_count); ?>,
      pending: <?php echo json_encode($pending_count); ?>
    };

    window.dashboardData = {
      passed_count: <?php echo json_encode($passed_count); ?>,
      failed_count: <?php echo json_encode($failed_count); ?>,
      pending_count: <?php echo json_encode($pending_count); ?>,
      passed_handson_count: <?php echo json_encode($passed_handson_count); ?>,
      failed_handson_count: <?php echo json_encode($failed_handson_count); ?>,
      pending_handson_count: <?php echo json_encode($pending_handson_count); ?>,
      total_count: <?php echo json_encode($total_count); ?>
    };
    
    
    $(document).ready(function() {
        
      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
      });

      
      $('#resultTabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
      });

      
      $('#resultTabs a').on('shown.bs.tab', function(e) {
        var activeTabId = $(e.target).attr('id');
        updateCardsByTab(activeTabId);
        updatePieChartByTab(activeTabId);
      });

      
      $('#dateRangeForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: 'fetch-dashboard.php',
          method: 'POST',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            window.dashboardData = response;
            updateDashboard(response);
            updatePieChartByTab($('#resultTabs .active').attr('id'));
            logDashboardData();
          },
          error: function(xhr, status, error) {
            console.error("An error occurred: " + error);
          }
        });
      });;

      
      
      var ctx = document.getElementById("myPieChart");
      if (ctx) {
        window.myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: ["Passed", "Failed", "Pending"],
            datasets: [{
              data: [<?php echo $passed_count; ?>, <?php echo $failed_count; ?>, <?php echo $pending_count; ?>],
              backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e'],
              hoverBackgroundColor: ['#17a673', '#c23616', '#dda20a'],
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              enabled: false
            },
            legend: {
              display: false
            },
            plugins: {
              datalabels: {
                formatter: (value, ctx) => {
                  let sum = 0;
                  let dataArr = ctx.chart.data.datasets[0].data;
                  dataArr.map(data => {
                    sum += data;
                  });
                  let percentage = (value*100 / sum).toFixed(1)+"%";
                  return percentage;
                },
                color: '#fff',
                font: {
                  weight: 'bold',
                  size: 12,
                }
              }
            }
          },
        });
        console.log("Chart initialized with data:", [<?php echo $passed_count; ?>, <?php echo $failed_count; ?>, <?php echo $pending_count; ?>]);
      } else {
        console.error("Canvas element 'myPieChart' not found");
      }

      var initialPassed = <?php echo json_encode($initial_passed); ?>;
      var initialFailed = <?php echo json_encode($initial_failed); ?>;
      var initialPending = <?php echo json_encode($initial_pending); ?>;
      updatePieChart(<?php echo $initial_passed; ?>, <?php echo $initial_failed; ?>, <?php echo $initial_pending; ?>);
      updatePieChartByTab($('#resultTabs .active').attr('id'));
      logDashboardData();
    });


    function updateDashboard(data) {
      window.dashboardData = data;
      var activeTabId = $('#resultTabs .active').attr('id');
      updateCardsByTab(activeTabId);
      updatePieChartByTab(activeTabId);
    }
    function updateCardsByTab(activeTabId) {
      if (!window.dashboardData) return;

      var data = window.dashboardData;
      var totalCount = data.total_count;

      if (activeTabId === 'diagnostic-tab') {
        updateCards('diagnostic-results', totalCount, data.passed_count, data.failed_count, data.pending_count);
        updatePieChart(data.passed_count, data.failed_count, data.pending_count);
      } else if (activeTabId === 'hands-on-tab') {
        updateCards('hands-on-results', totalCount, data.passed_handson_count, data.failed_handson_count, data.pending_handson_count);
        updatePieChart(data.passed_handson_count, data.failed_handson_count, data.pending_handson_count);
      }
    }

    function updateCards(containerId, total, passed, failed, pending) {
      var container = $('#' + containerId);
      container.find('.card:eq(0) .h5').text(total);
      container.find('.card:eq(1) .h5').text(passed);
      container.find('.card:eq(2) .h5').text(failed);
      container.find('.card:eq(3) .h5').text(pending);
    }

    function updatePieChart(passed, failed, pending) {
      if (window.myPieChart) {
        console.log("Updating pie chart with raw data:", [passed, failed, pending]);
        
        
        passed = Number(passed) || 0;
        failed = Number(failed) || 0;
        pending = Number(pending) || 0;

       
        var total = passed + failed + pending;
        
        if (total === 0) {
          console.warn("Total is zero, cannot calculate percentages");
          return;
        }

        
        window.myPieChart.data.datasets[0].data = [passed, failed, pending];
        window.myPieChart.options.plugins.datalabels.formatter = (value, ctx) => {
          let sum = 0;
          let dataArr = ctx.chart.data.datasets[0].data;
          dataArr.map(data => {
            sum += data;
          });
          let percentage = ((value / sum) * 100).toFixed(1) + "%";
          return percentage;
        };
        window.myPieChart.update();

        
        updateLegend(passed, failed, pending);

        console.log("Updated pie chart with data:", [passed, failed, pending]);
      } else {
        console.error("Pie chart not initialized");
      }
    }

    function updatePieChartByTab(activeTabId) {
      if (!window.dashboardData) return;

      var data = window.dashboardData;

      if (activeTabId === 'diagnostic-tab') {
        updatePieChart(data.passed_count, data.failed_count, data.pending_count);
      } else if (activeTabId === 'hands-on-tab') {
        updatePieChart(data.passed_handson_count, data.failed_handson_count, data.pending_handson_count);
      }
    }
    
    function updateLegend(passed, failed, pending) {
      var total = passed + failed + pending;
      if (total === 0) {
        $('#passed-legend').text('Passed (0%)');
        $('#failed-legend').text('Failed (0%)');
        $('#pending-legend').text('Pending (0%)');
        return;
      }
      
      var passedPercentage = ((passed / total) * 100).toFixed(1);
      var failedPercentage = ((failed / total) * 100).toFixed(1);
      var pendingPercentage = ((pending / total) * 100).toFixed(1);

      $('#passed-legend').text('Passed (' + passedPercentage + '%)');
      $('#failed-legend').text('Failed (' + failedPercentage + '%)');
      $('#pending-legend').text('Pending (' + pendingPercentage + '%)');
    }

    function logDashboardData() {
    console.log("Current dashboard data:", window.dashboardData);
    }
 
  </script>

  <!-- JS for Bar Chart-->
    <script>
        var barChartData = <?php echo $json_data; ?>;
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById("myBarChart").getContext('2d');
            var myBarChart;

            function createInitialBarChart(data) {
                var initialData = {
                    labels: data.map(item => item.province),
                    datasets: [{
                        label: "Passers",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: data.map(item => item.passer_count),
                    }]
                };

                myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: initialData,
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 5
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: Math.max(...data.map(item => item.passer_count)) || 10,
                                    maxTicksLimit: 5,
                                    padding: 10,
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ': ' + tooltipItem.yLabel;
                                }
                            }
                        },
                    }
                });
            }
            createInitialBarChart(barChartData);
        });
    </script>

  
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-text mx-3">
          <img src="image/DICT-logo.png" alt="DICTlogo" style="max-width: 4rem; min-width: 1rem" />
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0" />
      <!-- Nav Item - Dashboard -->
      <li class="nav-item active dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span>Admin</span></a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="table-history.php">
          <span>History</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="table-records.php">
          <span>Tables</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block" />

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar bg-body-tertiary topbar mb-2 static-top">
          <div class="container-fluid">
            <h1 class="dashboard-title">Hello Admin</h1>
            <a class="navbar-brand" href="#"></a>
              <form id="dateRangeForm" method="POST">
                  <div class="input-group mb-3">
                      <input type="text" class="form-control datepicker" id="start_date" name="start_date" placeholder="Start Date" readonly>
                      <input type="text" class="form-control datepicker" id="end_date" name="end_date" placeholder="End Date" readonly>
                      <button class="btn btn-primary" type="submit">Apply Filter</button>
                  </div>
              </form>
          </div>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <ul class="nav nav-tabs" id="resultTabs">
            <li class="nav-item">
              <a class="nav-link active" id="diagnostic-tab" data-toggle="tab" href="#diagnostic-results">Diagnostic Results</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="hands-on-tab" data-toggle="tab" href="#hands-on-results">Hands-On Results</a>
            </li>
          </ul>


    <div class="tab-content">
        <div class="tab-pane fade show active" id="diagnostic-results" role="tabpanel" aria-labelledby="diagnostic-tab">
              <div class = "row">
                  <!--Total Applicants -->
                  <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Applicants
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $total_count; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>

                  <!-- Passed Applicants Card -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-success shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                          Passed Applicants
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php echo htmlspecialchars($passed_count); ?>
                                      </div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Failed Applicants Card -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-danger shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                          Failed Applicants
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php echo htmlspecialchars($failed_count); ?>
                                      </div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Pending Applicants Card -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-warning shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                          Pending Applicants
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php echo htmlspecialchars($pending_count); ?>
                                      </div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-clock fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="tab-pane fade" id="hands-on-results" role="tabpanel" aria-labelledby="hands-on-tab">
              <div class = "row">
                  <!--Total Applicants -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Applicants
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $total_count; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  <!-- Passed Applicants Card -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-success shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                          Passed Applicants
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php echo htmlspecialchars($passed_handson_count); ?>
                                      </div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>


                  <!-- Failed Applicants Card -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-danger shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                          Failed Applicants
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php echo htmlspecialchars($failed_handson_count); ?>
                                      </div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Pending Applicants Card -->
                  <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-warning shadow h-100 py-2">
                          <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                  <div class="col mr-2">
                                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                          Pending Applicants
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php echo htmlspecialchars($pending_handson_count); ?>
                                      </div>
                                  </div>
                                  <div class="col-auto">
                                      <i class="fas fa-clock fa-2x text-gray-300"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


          <!-- Content Row -->
          <div class="row">

            <!-- Pie Chart -->
          <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                  Applicant Status Distribution
                </h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                  <canvas id="myPieChart"></canvas>
                </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> <span id="passed-legend">Passed</span>
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-danger"></i> <span id="failed-legend">Failed</span>
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-warning"></i> <span id="pending-legend">Pending</span>
                    </span>
                  </div>
              </div>
            </div>
          </div>
            <!-- Bar Chart -->
            <div class="col-xl-8 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top 5 Provinces with Most Passers</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <?php include ('logoutmodal.php'); ?>

</body>

</html>