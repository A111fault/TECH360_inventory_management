<?php

session_start();
include 'config.php';
$userName = $_SESSION['user_name'];

// Check if 'SN' is set in the URL
if(isset($_GET['SN'])) {
    $SN = $_GET['SN'];
    
    // Sanitize the input
    $SN = mysqli_real_escape_string($conn, $SN);
    
    // Assuming 'SN' is actually the primary identifier
    $sql = "SELECT * FROM outbound WHERE SN = $SN"; // Changed 'id' to 'SN'
    $result = mysqli_query($conn, $sql);
    
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $trx_id = $row['trx_id'];
        $item_id = $row['item_id'];
        $item_description = $row['item_description'];
        $item_quantity = $row['item_quantity'];
        $unit_price = $row['unit_price'];
        $date_shipped = $row['date_shipped'];
        $department = $row['department'];
        $destination = $row['destination'];
        $total_price = $row['total_price'];
        $remarks = $row['remarks'];
    } else {
        // Handle if no record found
        echo "No record found for SN: $SN";
        exit;
    }
} else {
    // Handle if 'SN' is not set
    echo "No SN specified";
    exit;
}
if (isset($_POST['submit'])) {
    // Update values from the forms
    $SN = $_POST['SN'];
    $trx_id = $row['trx_id'];
    $item_id = $_POST['item_id'];
    $item_description = $_POST['item_description'];
    $item_quantity = $_POST['item_quantity'];
    $unit_price = $_POST['unit_price'];
    $date_shipped = $_POST['date_shipped'];
    $department = $_POST['department'];
    $destination = $_POST['destination']; // Corrected to retrieve the updated value from the form
    $total_price = $_POST['total_price'];
    $remarks = $_POST['remarks'];

    // Construct and execute the update query
    $sql = "UPDATE outbound SET trx_id='$trx_id',item_id='$item_id', item_description='$item_description', item_quantity='$item_quantity', unit_price='$unit_price', date_shipped='$date_shipped', department='$department', destination='$destination', total_price='$total_price', remarks='$remarks', updated_by='$userName' WHERE SN=$SN";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        header('location:outbound_updater.php');
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
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

    <title>Update/Edit</title>
</head>

<body>
    <div class="container mt-5 ">
    <h3>Edit this row</h3>
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
