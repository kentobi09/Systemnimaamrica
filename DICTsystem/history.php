<?php include('sessionconflict.php')  ?>
<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "applicant-records"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve history records
$sql = "SELECT * FROM history ORDER BY date DESC";
$result = $conn->query($sql);

// SQL queries to count different actions
$sqlAdded = "SELECT COUNT(*) as countAdded FROM history WHERE action_done LIKE '%Added%'";
$sqlDeleted = "SELECT COUNT(*) as countDeleted FROM history WHERE action_done LIKE '%Deleted%'";
$sqlUpdated = "SELECT COUNT(*) as countUpdated FROM history WHERE action_done LIKE '%Updated%'";

$resultAdded = $conn->query($sqlAdded);
$resultDeleted = $conn->query($sqlDeleted);
$resultUpdated = $conn->query($sqlUpdated);

$countAdded = $resultAdded->fetch_assoc()['countAdded'];
$countDeleted = $resultDeleted->fetch_assoc()['countDeleted'];
$countUpdated = $resultUpdated->fetch_assoc()['countUpdated'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>History Log</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <style>

        .card-container {
            display: flex;
            justify-content: center; /* Center cards horizontally */
            margin-top: 20px;
        }
        .card {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            width: 22%; /* Adjusted width */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Added margin bottom for spacing */
            margin-right: 20px; /* Space between cards */
        }
        .card:last-child {
            margin-right: 0; /* Remove margin-right from the last card */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
table {
    width: 100%;
    border-collapse: collapse; /* Ensure no spaces between cells */
    margin-top: 20px;
}

table,
th,
td {
    border: none; /* Remove borders from table, th, and td */
    padding: 8px;
    text-align: left;
    
}

th {
    background-color: #f2f2f2;
}


        .delete-column,
        .sticky-id,
        .sticky-name {
          position: sticky;
          z-index: 2;
        }

        @media (min-width: 768px) {
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

        @media (max-width: 767px) and (max-width:1440px) {
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
          max-width: 90%;
        }
      }

      .opacity{
        opacity: .5;

      }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-3">History Log</h2>
    
    <!-- Action Count Cards -->
    <div class="card-container">
        <div class="card bg-primary text-white">
            <h3>Added</h3>
            <p><?php echo $countAdded; ?></p>
        </div>
        <div class="card bg-danger text-white">
            <h3>Deleted</h3>
            <p><?php echo $countDeleted; ?></p>
        </div>
        <div class="card bg-secondary text-white">
            <h3>Updated</h3>
            <p><?php echo $countUpdated; ?></p>
        </div>
    </div>
    
    <!-- History Table -->
    <div class="container px-0">
    <div class="table-responsive">
        <table class="table table-hover border-0">
            <thead >
                <tr class="table-primary">
                    <th ></th>
                    <th>ID</th>
                    <th>Admin ID</th>
                    <th>Admin Name</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody class="border-0">
            <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $date = new DateTime($row["date"]);
                            $formattedDate = $date->format('Y-m-d h:i A');
                            
                            echo "<tr>";
                            echo "<td>";
                            if($row['action_done'] == 'Added'){
                                echo '<i class="bi bi-plus-lg opacity"></i>';
                            } else if($row['action_done'] == 'Deleted'){
                                echo '<i class="bi bi-trash opacity"></i>';
                            } else if($row['action_done'] == 'Updated'){
                                echo '<i class="bi bi-pencil-square text-black opacity"></i>';
                            }
                            echo '</td>';
                            echo "<td>".$row["id"]."</td>";
                            echo "<td>".$row["admin_id"]."</td>";
                            echo "<td><b>".$row["admin_name"]."</b></td>";
                            echo "<td>".$row["action_done"].' applicant record for '.$row["applicant_name"]."</td>";
                            echo "<td>".$formattedDate."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>

            </tbody>
        </table>
    </div>
</div>
            </div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
// Close connection
$conn->close();
?>
</body>
</html>
