<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
    <script src="main-script.js"></script>
    <style>
        .hide{
            display:none ;
        }
    </style>
<body>
<?php include('filter-search.php'); ?>
<?php include('fetch-scores.php'); ?>

    <!-- All the Filters are applied here in the nav bar-->
    <nav class="navbar bg-body-tertiary fixed-top ">
        <div class="container-fluid">
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
            <form id="nameFilterForm" class = "hide" action="" method="GET">
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

              <form id="idFilterForm" class = "hide" action="" method="GET">
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

      <br>
      <br>
      <br>
      <p>
    Passed: <?php echo $statusCounts['passed_count']; ?> |
    Failed: <?php echo $statusCounts['failed_count']; ?> |
    Pending: <?php echo $statusCounts['pending_count']; ?>
</p>

<p>
  Hands-on Exam Takers : <?php echo isset($applicants_with_handson) ? $applicants_with_handson : 'Not set'; ?>
</p>
<p>
  Diagnostic Exam Takers : <?php echo $statusCounts['passed_count'] + $statusCounts['failed_count']+$statusCounts['pending_count'];?>
</p>
</body>
</html>