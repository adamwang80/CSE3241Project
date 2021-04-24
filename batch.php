<?php
    session_start();
    include("conn.php");
    $batch_id = isset($_POST['batch_id']) ? $_POST['batch_id'] : '' ;
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '' ;
    $manufacturer = isset($_POST['manufacturer']) ? $_POST['manufacturer'] : '' ;
    $expire_date = isset($_POST['expire_date']) ? $_POST['expire_date'] : '' ;

    if(isset($_POST['batch'])){
        $sql = "INSERT INTO BATCHES (Batch_id, Quantity_Of_Doses, Manufacturer, Expire_Date, Quantity_Of_Available) VALUES ('$batch_id', '$quantity', '$manufacturer', '$expire_date', '$quantity')";
        mysqli_query($conn, $sql);
        echo "Successfully insert value in batches table.";
    } else {
        echo "Failed.";
    }
?>

<html lang="en">
<meta charset="UTF-8">
<meta name="Author" content="Andy Barbaro">
<head>
    <title>Batch Creation</title>
</head>
<body>
    <h2>Input Incoming Batch of Vaccines</h2>
    <form action="" method="post" name="batch_creation">
        <table>
            <tr>
                <td>Batch ID: </td>
                <td><input type="text" name="batch_id"></td>
            </tr>
            <tr>
                <td>Number of Doses: </td>
                <td><input type="number" name="quantity"></td>
            </tr>
            <tr>
                <td>Manufacturer: </td>
                <td><input type="text" name="manufacturer"></td>
            </tr>
            <tr>
                <td>Expiration Date: </td>
                <td><input type="date" name="expire_date"></td>
            </tr>
            <tr>
                <td><input type="submit" name="batch" value="Create Batch"></td>
            </tr>
            <tr>
                  <td><a href="admin.php">Return</a></td>
            </tr>
        </table>
    </form>
</body>
</html>
