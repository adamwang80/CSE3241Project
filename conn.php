<?php
    $conn = @mysqli_connect('127.0.0.1','root','root','BUR');
    if (!$conn){
        die('Cannot connect'.mysqli_connect_error());
    }
    echo "Connection successful";
?>
