<?php include('sessionconflict.php')  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Application Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
      <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
    ></script>
    <script src="main-script.js"></script>
    <style>
      .offcanvas-body {
        margin-bottom: 30px !important;
      }

      .text-box{

        min-height:2em;
      
      }
      .form-check-input{
        font-size: 1.3em;
      }
      .form-check-label{
        font-size: 1.2em;
      }
      #offcanvasNavbarLabel{
        font-size: 2em;
        
      }
      .space{
        display: block;
        margin-bottom: 10px;
        font-size: 1.3em;
      }
      .dropdown-item.selected {
        background-color: #e9ecef;
        font-weight: bold;
        }

        .delete-column,
        .sticky-id,
        .sticky-name {
          position: sticky;
          z-index: 2;
        }

        @media (max-width: 1440px) {
          .delete-column {
            left: 0;

          }

          .sticky-id {
            left: 6.7rem;
          }

          .sticky-name {
            left: 8.1rem;
            font-weight: 700;
          }
        }

        @media (max-width: 767px) {
          .delete-column,
          .sticky-id,
          .sticky-name {
            left: unset; 
          }

          .delete-column {
            left:0;
          }

          .sticky-id {
            left: 3.55rem; 
          }

          .sticky-name {
            left: 5rem; 
            font-weight: 700;
          }
        }

        #header {
          margin-top: 4.5rem;
        }
        .score {
          text-align: right;
        }

        .invisible {
          opacity: 0;
          pointer-events:none;
        }

        .hide{
          display: none;
        }
      .applicant-sex {
        text-transform: capitalize;
      }
      table {
        border: 2px solid ;
      }
      @media(min-width:1441px){
        .container{
          min-width: 90%;
        }
      }

   
    </style>

  </head>
 <body id="page-top">
    <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
       <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3">
                    <img src="image/DICT-logo.png" alt="DICTlogo" style="max-width: 4rem; min-width: 5px" />
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


      <!-- Divider -->
      <hr class="sidebar-divider my-0" />

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ">
        <a class="nav-link" href="index.php">
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="table-history.php">
          <span>History</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item active">
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

      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>
    
<?php


?>
    <?php include_once ('first-connection.php'); ?>
    <?php include ('fetch-scores.php'); ?>
    <?php include ('filter-search.php'); ?>
    <?php include ('addmodal.php'); ?>
    <?php include ('dispaymodal.php'); ?>
    <?php include ('editmodal.php'); ?>
    <?php include ('deletemodal.php'); ?>
    <?php include ('insert.php'); ?>

   
     <!-- All the Filters are applied here in the nav bar-->
    <nav class="navbar topbar mb-2 static-top">
        <div class="container-fluid">
           <h1>Applicant Records</h1>
          <a class="navbar-brand" href="#"></a>
            <div class = "d-flex align-items-start">
              <h5 class="me-3 mb-0" id="offcanvasNavbarLabel">Filters</h5>
              <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar"
                aria-label="Toggle navigation"
              >
              
              <i class="bi bi-funnel h3"></i>
              </button>
            </div>
          <div
            class="offcanvas offcanvas-end"
            tabindex="-1"
            id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel"
          >
            <div class="offcanvas-header mt-3">
              <button type="button" class="btn btn-success" id="clearAllBtn">Clear All</button>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
              ></button>
            </div>
            <div class="offcanvas-body">
            <form id="nameFilterForm" action="" method="GET">
              <div class="mb-3">
                <span class="fw-bold space">Name</span>
                <div class="form-check form-switch ms-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDesc" name="sortName" value="desc" <?php echo isset($_GET['sortName']) && $_GET['sortName'] === 'desc' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="flexSwitchCheckDesc">Sort Name (Z to A) <i class="bi bi-arrow-down"></i></label>
                </div>
                <div class="form-check form-switch ms-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckAsc" name="sortName" value="asc" <?php echo isset($_GET['sortName']) && $_GET['sortName'] === 'asc' ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="flexSwitchCheckAsc">Sort Name (A to Z) <i class="bi bi-arrow-up"></i></label>
                </div>
              </div>
            </form>

              <form id="idFilterForm" action="" method="GET">
                  <div class="mb-3">
                    <span class="fw-bold space ms-1">ID</span>
                    <div class="form-check form-switch ms-3">
                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckOldest" name="sortID" value="oldest" <?php echo isset($_GET['sortID']) && $_GET['sortID'] === 'oldest' ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="flexSwitchCheckOldest">Oldest ID <i class="bi bi-arrow-down"></i></label>
                    </div>
                  </div>
              </form>

            <span class = "d-block fw-bold space">Date of Examination</span>
            <input class="text-box mb-3 border border-2 rounded"  type="text" name="datefilter_examination" value="" autocomplete="off" />

            <span class = "d-block fw-bold space">Date of Notification</span>
            <input  class="text-box border border-2 rounded"  type="text" name="datefilter_notification" value="" autocomplete="off" />

            <span class= "d-block fw-bold space mt-3" >Status</span>
              <form id="statusForm">
                  <div class="form-check ms-2 mb-3">
                      <input class="form-check-input" type="checkbox" value="Passed" id="flexCheckPassed" name="status[]"
                            <?php echo (isset($_GET['status']) && in_array('Passed', $_GET['status'])) ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="flexCheckPassed">
                          Passed
                      </label>
                  </div>

                  <div class="form-check ms-2 mb-3">
                      <input class="form-check-input" type="checkbox" value="Failed" id="flexCheckFailed" name="status[]"
                            <?php echo (isset($_GET['status']) && in_array('Failed', $_GET['status'])) ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="flexCheckFailed">
                          Failed
                      </label>
                  </div>

                  <div class="form-check ms-2 mb-3">
                      <input class="form-check-input" type="checkbox" value="Pending" id="flexCheckPending" name="status[]"
                            <?php echo (isset($_GET['status']) && in_array('Pending', $_GET['status'])) ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="flexCheckPending">
                          Pending
                      </label>
                  </div>
              </form>

              <span class ="space"style="display:block;"><b>Exam Venue </b></span>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary dropdown-toggle" id="examVenueDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Select an Exam Venue
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item">hall-a</a></li>
                        <li><a class="dropdown-item">hall-b</a></li>
                        <li><a class="dropdown-item">hall-c</a></li>
                        <li><a class="dropdown-item">hall-d</a></li>
                        <li><a class="dropdown-item">hall-e</a></li>
                        <li><a class="dropdown-item">hall-f</a></li>
                    </ul>
                </div>


            </div>
          </div>
        </div>
      </nav>

    <div class="container my-3 px-0">
      <div class="d-flex justify-content-between my-4">
        <form class="d-flex" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
              <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <div >
          <button  data-toggle="modal" data-target="#addApplicantModal" type="button" class="btn btn-primary mx-1" ><i class="bi bi-plus-lg"></i></button>
        </div>
      </div>
    </div>
    <div class="container px-0">
    <ul class="nav nav-tabs" id="examTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="diagnostic-table-tab" data-toggle="tab" href="#diagnostic-table" role="tab" aria-controls="diagnostic-table" aria-selected="true">Diagnostic Table</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="hands-on-table-tab" data-toggle="tab" href="#hands-on-table" role="tab" aria-controls="hands-on-table" aria-selected="false">Hands-on Table</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="scoreTabsContent">
        <!-- Diagnostic Score Tab -->
        <div class="tab-pane fade show active" id="diagnostic-table" role="tabpanel" aria-labelledby="diagnostic-table-tab">
            <?php include('tables/table1.php'); ?>
        <!-- Hands-on Score Tab -->
        <div class="tab-pane fade" id="hands-on-table" role="tabpanel" aria-labelledby="hands-on-table-tab">
            <?php include('tables/table2.php'); ?>
        </div>
    </div>
</div>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-md-center">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page <= 1 ? '#' : '?' . http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page >= $total_pages ? '#' : '?' . http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

  </body>
</html>

      <!-- <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/sb-admin-2.min.js"></script>               -->
