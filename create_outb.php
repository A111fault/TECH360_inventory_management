<?php

session_start();
include 'config.php';
$userName=$_SESSION['user_name'];

  
// Initialize variables with default values or leave them empty
$SN = '';
$trx_id = '';
$item_id = '';
$item_description = '';
$item_quantity = '';
$unit_price = '';
$date_shipped = '';
$department = '';
$destination = '';
$total_price = '';
$remarks = '';

if (isset($_POST['submit'])) {
    // Retrieve values from the form
    $trx_id = $_POST['trx_id'];
    $item_id = $_POST['item_id'];
    $item_description = $_POST['item_description'];
    $item_quantity = $_POST['item_quantity'];
    $unit_price = $_POST['unit_price'];
    $date_shipped = $_POST['date_shipped'];
    $department = $_POST['department'];
    $destination = $_POST['destination'];
    $total_price = $_POST['total_price'];
    $remarks = $_POST['remarks'];

    // Get the highest SN value from the outbound table
    $query = "SELECT MAX(SN) AS max_sn FROM outbound";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $next_sn = $row['max_sn'] + 1; // Calculate the next SN value

    // Construct the SQL INSERT query with the calculated SN
    $sql = "INSERT INTO outbound (SN, trx_id,item_id, item_description, item_quantity, unit_price, date_shipped, department, destination, total_price, remarks, updated_by) 
            VALUES ('$next_sn', '$trx_id','$item_id', '$item_description', '$item_quantity', '$unit_price', '$date_shipped', '$department', '$destination', '$total_price', '$remarks','$userName')";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to a success page or back to the form
        header('location: outbound_updater.php');
        exit;
    } else {
        // Handle the case where insertion failed
        echo "Error inserting record: " . mysqli_error($conn);
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
                <label>SN</label>
                <input type="text" class="form-control" placeholder="Enter serial number" name="SN" value="<?php echo $SN; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Transaction ID</label>
                <input type="text" class="form-control" placeholder="Enter transaction ID" name="trx_id" value="<?php echo $trx_id; ?>">
            </div>
            <div class="form-group">
                <label>Item ID</label>
                <input type="text" class="form-control" placeholder="Enter item ID" name="item_id" value="<?php echo $item_id; ?>">
            </div>
            <div class="form-group">
                <label>Item Description</label>
                <input type="text" class="form-control" placeholder="Enter item description" name="item_description" value="<?php echo $item_description; ?>">
            </div>
            <div class="form-group">
                <label>Item Quantity</label>
                <input type="text" class="form-control" placeholder="Enter item quantity" name="item_quantity" value="<?php echo $item_quantity; ?>">
            </div>
            <div class="form-group">
                <label>Unit Price</label>
                <input type="text" class="form-control" placeholder="Enter unit price" name="unit_price" value="<?php echo $unit_price; ?>">
            </div>
            <div class="form-group">
                <label>Date Shipped</label>
                <input type="text" class="form-control" placeholder="Enter date shipped" name="date_shipped" value="<?php echo $date_shipped; ?>">
            </div>
            <div class="form-group">
                <label>Department</label>
                <input type="text" class="form-control" placeholder="Enter department" name="department" value="<?php echo $department; ?>">
            </div>
            <div class="form-group">
                <label>Destination</label>
                <input type="text" class="form-control" placeholder="Enter destination" name="destination" value="<?php echo $destination; ?>">
            </div>
            <div class="form-group">
                <label>Total Price</label>
                <input type="text" class="form-control" placeholder="Enter total price" name="total_price" value="<?php echo $total_price; ?>">
            </div>
            <div class="form-group">
                <label>Remarks</label>
                <input type="text" class="form-control" placeholder="Enter remarks" name="remarks" value="<?php echo $remarks; ?>">
            </div>
            <button type="submit" class="btn btn-primary my-3" name="submit">Update</button>
        </form>
    </div>
</body>

</html>
