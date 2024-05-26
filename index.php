<?php

// Connect to the database
$con = mysqli_connect('localhost', 'root', '', 'experiment');

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Function to insert or update data in the summary table
function insertOrUpdateSummaryData($con, $trx_id, $item_id, $item_description, $item_quantity, $date_received, $date_shipped, $remarks, $updated_by)
{
    // Check if the data already exists in the summary table
    $checkQuery = "SELECT * FROM summary WHERE trx_id = '$trx_id'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // If no existing row, insert new data
        $insertQuery = "INSERT INTO summary (trx_id, item_id, item_description, item_quantity, date_received, date_shipped, remarks, updated_by) VALUES 
        ('$trx_id', '$item_id', '$item_description', '$item_quantity', '$date_received', '$date_shipped', '$remarks', '$updated_by')";
        $result = mysqli_query($con, $insertQuery);
        if (!$result) {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // If the row exists, update the data
        $existingRow = mysqli_fetch_assoc($checkResult);
        
        // Determine which fields to update (only update if the new value is not null)
        $updateFields = [];
        if (!is_null($item_id)) $updateFields[] = "item_id = '$item_id'";
        if (!is_null($item_description)) $updateFields[] = "item_description = '$item_description'";
        if (!is_null($item_quantity)) $updateFields[] = "item_quantity = '$item_quantity'";
        if (!is_null($date_received)) $updateFields[] = "date_received = '$date_received'";
        if (!is_null($date_shipped)) $updateFields[] = "date_shipped = '$date_shipped'";
        if (!is_null($remarks)) $updateFields[] = "remarks = '$remarks'";
        if (!is_null($updated_by)) $updateFields[] = "updated_by = '$updated_by'";

        if (count($updateFields) > 0) {
            $updateQuery = "UPDATE summary SET " . implode(', ', $updateFields) . " WHERE trx_id = '$trx_id'";
            $result = mysqli_query($con, $updateQuery);
            if (!$result) {
                echo "Error: " . mysqli_error($con);
            }
        }
    }
}

// Retrieve data from the inbound table
$inboundQuery = "SELECT trx_id, item_id, item_description, item_quantity, date_received, remarks, updated_by FROM inbound";
$inboundResult = mysqli_query($con, $inboundQuery);

// Insert inbound data into the summary table
while ($row = mysqli_fetch_assoc($inboundResult)) {
    insertOrUpdateSummaryData($con, $row['trx_id'], $row['item_id'], $row['item_description'], $row['item_quantity'], $row['date_received'], NULL, $row['remarks'], $row['updated_by']);
}

// Retrieve data from the outbound table
$outboundQuery = "SELECT trx_id, item_id, item_description, item_quantity, NULL AS date_received, date_shipped, remarks, updated_by FROM outbound";
$outboundResult = mysqli_query($con, $outboundQuery);

// Insert outbound data into the summary table
while ($row = mysqli_fetch_assoc($outboundResult)) {
    insertOrUpdateSummaryData($con, $row['trx_id'], $row['item_id'], $row['item_description'], $row['item_quantity'], NULL, $row['date_shipped'], $row['remarks'], $row['updated_by']);
}

function buildDateRangeQuery($startDate, $endDate)
{
    $sql = " AND date_received BETWEEN '$startDate' AND '$endDate'";
    return $sql;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECH360 DashBoard</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-world"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="index.php">TECH360</a>
                </div>
            </div>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#inb" aria-expanded="false" aria-controls="inb">
                    <i class="lni lni-inbox"></i>
                    <span>Inbound Inventory</span>
                </a>
                <ul id="inb" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="inbound.php" class="sidebar-link">Search Inbound Inventory</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="inbound_updater.php" class="sidebar-link">Update Inbound Inventory</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#outb" aria-expanded="false" aria-controls="outb">
                    <i class="lni lni-indent-decrease"></i>
                    <span>Outbound Inventory</span>
                </a>
                <ul id="outb" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="outbound.php" class="sidebar-link">Search Outbound Inventory</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="outbound_updater.php" class="sidebar-link">Update Outbound Inventory</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#user" aria-expanded="false" aria-controls="user">
                    <i class="lni lni-user"></i>
                    <span>User</span>
                </a>
                <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="display.php" class="sidebar-link">User Management</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="register.php" class="sidebar-link">Register User</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#exit" aria-expanded="false" aria-controls="exit">
                    <i class="lni lni-exit"></i>
                    <span>Exit</span>
                </a>
                <ul id="exit" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="logout.php" class="sidebar-link">Logout</a>
                    </li>
                </ul>
            </li>
        </aside>
        <div class="main p-3">
            <div class="text-center p-2 bg-info bg-opacity-10 border border-info border-start rounded-start rounded-end">
                <h1>
                    TECH360 DashBoard
                </h1>

            </div>
            <br>
            <h1 class="mb-4">Summary Table</h1>
            <form method="post" class="mb-3">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm mb-3" name="trx_id" placeholder="Transaction ID">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm mb-3" name="item_id" placeholder="Item ID">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm mb-3" name="item_description" placeholder="Item Description">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control form-control-sm mb-3" name="date_received_from" placeholder="Date Received">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control form-control-sm mb-3" name="date_received_to" placeholder="Date Shipped">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button type="submit" name="submit" class="btn btn-secondary">Search</button>
                        <button type="submit" name="reset" class="btn btn-danger">Reset</button>
                    </div>
                </div>
            </form>

            <div class="container my-1 mx-1 table-container">
                <table class="table table-bordered border-primary table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>SN</th>
                            <th>Transaction ID</th>
                            <th>Item ID</th>
                            <th>Item Description</th>
                            <th>Item Quantity</th>
                            <th>Date Received</th>
                            <th>Date Shipped</th>
                            <th>Remarks</th>
                            <th>Updated By</th>
                            <th>Updated Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Connect to the database
                        $con = mysqli_connect('localhost', 'root', '', 'experiment');

                        // Check connection
                        if (mysqli_connect_errno()) {
                            echo "Failed to connect to MySQL: " . mysqli_connect_error();
                            exit();
                        }

                        // Number of records per page
                        $records_per_page = 10;

                        // Determine current page number
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Calculate the starting record for the current page
                        $start_from = ($current_page - 1) * $records_per_page;

                        // Build SQL query based on search criteria
                        $sql = "SELECT * FROM `summary` WHERE 1=1";
                        if (isset($_POST['submit'])) {
                            $trx_id = $_POST['trx_id'];
                            $item_id = $_POST['item_id'];
                            $item_description = $_POST['item_description'];
                            $date_received_from = isset($_POST['date_received_from']) ? $_POST['date_received_from'] : '';
                            $date_received_to = isset($_POST['date_received_to']) ? $_POST['date_received_to'] : '';

                            if (!empty($trx_id)) {
                                $sql .= " AND trx_id LIKE '%$trx_id%'";
                            }
                            if (!empty($item_id)) {
                                $sql .= " AND item_id LIKE '%$item_id%'";
                            }
                            if (!empty($item_description)) {
                                $sql .= " AND item_description LIKE '%$item_description%'";
                            }
                            // Check if both start and end dates are provided
                            if (!empty($date_received_from) && !empty($date_received_to)) {
                                // Call the function to build the date range query
                                $sql .= buildDateRangeQuery($date_received_from, $date_received_to);
                            } elseif (!empty($date_received_from)) {
                                // Only start date is provided
                                $sql .= " AND date_received >= '$date_received_from'";
                            } elseif (!empty($date_received_to)) {
                                // Only end date is provided
                                $sql .= " AND date_received <= '$date_received_to'";
                            }
                        }

                        // Append pagination
                        $sql .= " LIMIT $start_from, $records_per_page";

                        // Execute SQL query
                        $result = mysqli_query($con, $sql);

                        // Display data
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['SN'] . "</td>";
                            echo "<td>" . $row['trx_id'] . "</td>";
                            echo "<td>" . $row['item_id'] . "</td>";
                            echo "<td>" . $row['item_description'] . "</td>";
                            echo "<td>" . $row['item_quantity'] . "</td>";
                            echo "<td>" . $row['date_received'] . "</td>";
                            echo "<td>" . $row['date_shipped'] . "</td>";
                            echo "<td>" . $row['remarks'] . "</td>";
                            echo "<td>" . $row['updated_by'] . "</td>";
                            echo "<td>" . $row['updated_time'] . "</td>";
                            echo "</tr>";
                        }

                        // Close the database connection
                        mysqli_close($con);
                        ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php
                        // Determine total number of pages
                        $con = mysqli_connect('localhost', 'root', '', 'experiment');
                        $total_records_sql = "SELECT COUNT(*) AS total_records FROM `summary`";
                        $result = mysqli_query($con, $total_records_sql);
                        $total_records = mysqli_fetch_assoc($result)['total_records'];
                        $total_pages = ceil($total_records / $records_per_page);

                        // Display pagination links
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<li class='page-item " . ($current_page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>
