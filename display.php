<?php

include 'config.php';
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
                        <a href="register.php" class="sidebar-link">Register</a>
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
            <div>
                <h1>
                    User Management
                </h1>
            </div>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Sl no.</th>
                        <th scope="col">User</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Password</th>
                        <th scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM crud";
                    $result = mysqli_query($conn, $sql);
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $user_type = $row['user_type'];
                            $name = $row['name'];
                            $email = $row['email'];
                            $mobile = $row['mobile'];
                            $password = $row['password'];

                            echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>$user_type</td>";
                            echo "<td>$name</td>";
                            echo "<td>$email</td>";
                            echo "<td>$mobile</td>";
                            echo "<td>$password</td>";
                            echo '<td>
                                    <a href="update_user.php?updateid=' . $id . '" class="btn btn-info btn-sm">Update</a>
                                    <a href="delete_user.php?deleteid=' . $id . '" class="btn btn-danger btn-sm">Delete</a>
                                  </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="mb-2">
                <a href="register.php" class="btn btn-warning" role="button">Create account</a>

            </div>
        </div>

    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>