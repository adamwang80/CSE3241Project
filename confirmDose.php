<?php

    $patient_id = $_POST['patient_id'];
    $tracking_number = $_POST['tracking_number'];

    include("conn.php");
    mysqli_query($conn,"update SCHEDULE set Status='Dosed' where Patient_Id=$patient_id");
?>