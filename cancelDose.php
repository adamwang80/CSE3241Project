<?php

    $patient_id = $_POST['patient_id'];
    $tracking_number = $_POST['tracking_number'];

    include("conn.php");
    mysqli_query($conn,"call return_dose(".$patient_id.",".$tracking_number.")");
?>