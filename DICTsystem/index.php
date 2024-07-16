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
  
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<!-- ... body content ... -->

<!-- At the end of the body, replace the existing scripts with: -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
<script>
  $(document).ready(function() {
    // Initialize date pickers
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    $('#resultTabs a').on('click', function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

    // Update content when switching to Hands-On Results tab
    $('#hands-on-tab').on('shown.bs.tab', function (e) {
      $('#hands-on-results .card:eq(1) .h5').text('<?php echo htmlspecialchars($passed_handson_count); ?>');
      // Update other values as needed
    });

    $('#dateRangeForm').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        url: 'fetch-dashboard.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          updateDashboard(response);
        },
        error: function(xhr, status, error) {
          console.error("An error occurred: " + error);
        }
      });
    });
  });

  function updateDashboard(data) {
    // Update the dashboard elements
    $('#diagnostic-results .card:eq(0) .h5').text(data.total_count);
    $('#diagnostic-results .card:eq(1) .h5').text(data.passed_count);
    $('#diagnostic-results .card:eq(2) .h5').text(data.failed_count);
    $('#diagnostic-results .card:eq(3) .h5').text(data.pending_count);

    $('#hands-on-results .card:eq(0) .h5').text(data.total_count);
    $('#hands-on-results .card:eq(1) .h5').html(data.passed_handson_count);
    $('#hands-on-results .card:eq(2) .h5').text(data.failed_handson_count);
    $('#hands-on-results .card:eq(3) .h5').text(data.pending_handson_count);
  }
</script>

</head>

<body id="page-top">
  <?php include('fetch-dashboard.php');?>
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
            <a class="nav-link active" id="diagnostic-tab" data-bs-toggle="tab" href="#diagnostic-results">Diagnostic Results</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="hands-on-tab" data-bs-toggle="tab" href="#hands-on-results">Hands-On Results</a>
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
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Earnings Overview
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                      aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Revenue Sources
                  </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                      aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>
                  </div>
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
    <!-- Bootstrap core JavaScript-->

</body>

</html>