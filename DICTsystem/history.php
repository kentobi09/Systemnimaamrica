<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>History Log</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <style>
        h2 {
            font-size: 3em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 2px solid;
        }

        table,
        th,
        td {
            border: none;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .opacity {
            font-weight: bolder;
        }

        .bold {
            font-weight: 600;
            text-transform: uppercase;
        }

        .bold-name {
            font-weight: bold;
        }

        @media(min-width:1441px) {
            .container {
                max-width: 90%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar topbar mb-2 static-top">
        <div class="container-fluid">
            <h1>History Logs</h1>

            <div class="container d-flex justify-content-center">
                <div class="container px-0 mx-0">
                    <div class="table-responsive">
                        <table class="table table-hover border-0">
                            <thead>
                                <tr class="table-primary">
                                    <th></th>
                                    <th>Admin ID</th>
                                    <th>Admin Name</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>Time Modified</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $date = new DateTime($row["date"]);
                                        $formattedDate = $date->format('Y-m-d');
                                        $formattedTime = $date->format('h:i A');

                                        echo "<tr>";
                                        echo "<td>";
                                        if ($row['action_done'] == 'Added') {
                                            echo '<i class="bi bi-plus-lg opacity"></i>';
                                        } else if ($row['action_done'] == 'Deleted') {
                                            echo '<i class="bi bi-trash opacity"></i>';
                                        } else if ($row['action_done'] == 'Updated') {
                                            echo '<i class="bi bi-pencil-square text-black opacity"></i>';
                                        }
                                        echo '</td>';
                                        echo "<td>" . $row["admin_id"] . "</td>";
                                        echo "<td class='bold-name'>" . $row["admin_name"] . "</td>";
                                        echo "<td class='fw-normal'><span class='bold'>" . $row["action_done"] . "</span> applicant record for " . $row["applicant_name"] . "</td>";
                                        echo "<td>" . $formattedDate . "</td>";
                                        echo "<td>" . $formattedTime . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" <?php echo ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Previous</a>
                            </li>
                            <?php
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo '<li class="page-item ' . (($page == $i) ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                            ?>
                            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>" <?php echo ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
    $conn->close();
    ?>
</body>

</html>