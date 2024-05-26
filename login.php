<?php

include 'config.php';
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_users = mysqli_query($conn, "SELECT * FROM `crud` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {

        $row = mysqli_fetch_assoc($select_users);
        $_SESSION['user_name'] = $row['name'];
        
        if ($row['user_type'] == 'Admin') {

            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:index.php');
        } elseif ($row['user_type'] == 'Employee') {

            $_SESSION['emp_name'] = $row['name'];
            $_SESSION['emp_email'] = $row['email'];
            $_SESSION['emp_id'] = $row['id'];
            $success_message = 'Logged in successfully!';
            header('location:index.php');
        }
    } else {
        $error_message = 'Incorrect email or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('assets/pexels-uva-rova-323133.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.6);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: rgba(255, 255, 255, 0.7); /* Transparent white */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        p a {
            color: #007bff;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }

        .alert {
            display: flex;
            align-items: center;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .alert i {
            margin-right: 10px;
        }

        .alert-primary {
            background-color: #d1ecf1;
            color: #0dcaf0;
        }

        .alert-success {
            background-color: #d4edda;
            color: #198754;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #ffc107;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #dc3545;
        }
    </style>
</head>

<body>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <?php echo $error_message; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle"></i>
            <div>
                <?php echo $success_message; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8"> <!-- Adjusted column width -->
                <form action="" method="post">
                    <h3>Login Now</h3>
                    <div class="form-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                    </div>
                    <input type="submit" name="submit" value="Login Now" class="btn btn-primary">
                    <p>Don't have an account? Contact Admin!</a></p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

