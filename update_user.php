<?php

include 'config.php';
$id=$_GET['updateid'];
$sql="Select * from crud where id=$id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$user_type=$row['user_type'];
$name=$row['name'];
$email=$row['email'];
$mobile=$row['mobile'];
$password=$row['password'];

if (isset($_POST['submit'])){
    $user_type=$_POST['user_type'];
    $name= $_POST['name'];
    $email= $_POST['email'];
    $mobile= $_POST['mobile'];
    $password= $_POST['password'];

    // Remove single quotes from 'crud'
    $sql = "UPDATE crud SET id=$id, user_type='$user_type',name='$name', email='$email', mobile='$mobile', password='$password'where id=$id";
    $result=mysqli_query($conn,$sql);
    if ($result){
        //echo 'Data updated successfully';
        header('location:display.php');
    } else {
        die(mysqli_error($conn));
    }
}

?>

<!doctype html>
<html lang="ar">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

    <title>Crud</title>
</head>

<body>
    <div class="container mt-5 ">
        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Enter your Name" name="name" value=<?php echo $name;?>>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control"  placeholder="Enter your email" name="email" value=<?php echo $email;?>>

            </div>
            <div class="form-group">
                <label>Mobile</label>
                <input type="text" class="form-control" placeholder="Enter your phone number" name="mobile" value=<?php echo $mobile;?>>

            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="password" value=<?php echo $password;?>>
            </div>
            <div class="form-group">
                <label>User Type</label>
                <select name="user_type" class="form-control">
                        <option value="Employee">Employee</option>
                        <option value="Admin">Admin</option>
                    </select>
            </div>
            

            <button type="submit" class="btn btn-primary my-3" name="submit">Update</button>
        </form>


    </div>


</body>

</html>