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
$date_received = '';
$supplier = '';
$total_price = '';
$remarks = '';
if (isset($_POST['submit'])) {
    // Retrieve values from the form
    $trx_id = $_POST['trx_id'];
    $item_id = $_POST['item_id'];
    $item_description = $_POST['item_description'];
    $item_quantity = $_POST['item_quantity'];
    $unit_price = $_POST['unit_price'];
    $date_received = $_POST['date_received'];
    $supplier = $_POST['supplier'];
    $total_price = $_POST['total_price'];
    $remarks = $_POST['remarks'];

    // Get the highest SN value from the inbound table
    $query = "SELECT MAX(SN) AS max_sn FROM inbound";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $next_sn = $row['max_sn'] + 1; // Calculate the next SN value

    // Construct the SQL INSERT query with the calculated SN
    $sql = "INSERT INTO inbound (SN, trx_id,item_id, item_description, item_quantity, unit_price, date_received, supplier, total_price, remarks,updated_by) 
            VALUES ('$next_sn', '$trx_id','$item_id', '$item_description', '$item_quantity', '$unit_price', '$date_received', '$supplier', '$total_price', '$remarks', '$userName')";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to a success page or back to the form
        header('location: inbound_updater.php');
        exit;
    } else {
        // Handle the case where insertion failed
        echo "Error inserting record: " . mysqli_error($conn);
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

    <title>Create Inbound</title>
</head>

<body>
    <div class="container mt-5">
        <form method="post">
            <div class="form-group">
            <div class="form-group">
                <label>Transaction ID</label>
                <input type="text" class="form-control" placeholder="Enter transaction ID" name="trx_id" value="<?php echo $trx_id; ?>">
            </div>
                <label>Item ID</label>
                <input type="text" class="form-control" placeholder="Enter item ID" name="item_id">
            </div>
            <div class="form-group">
                <label>Item Description</label>
                <input type="text" class="form-control" placeholder="Enter item description" name="item_description">
            </div>
            <div class="form-group">
                <label>Item Quantity</label>
                <input type="text" class="form-control" placeholder="Enter item quantity" name="item_quantity">
            </div>
            <div class="form-group">
                <label>Unit Price</label>
                <input type="text" class="form-control" placeholder="Enter unit price" name="unit_price">
            </div>
            <div class="form-group">
                <label>Date Received</label>
                <input type="text" class="form-control" placeholder="Enter date received" name="date_received">
            </div>
            <div class="form-group">
                <label>Supplier</label>
                <input type="text" class="form-control" placeholder="Enter supplier" name="supplier">
            </div>
            <div class="form-group">
                <label>Total Price</label>
                <input type="text" class="form-control" placeholder="Enter total price" name="total_price">
            </div>
            <div class="form-group">
                <label>Remarks</label>
                <input type="text" class="form-control" placeholder="Enter remarks" name="remarks">
            </div>
            <button type="submit" class="btn btn-primary my-3" name="submit">Create</button>
        </form>
    </div>
</body>

</html>
