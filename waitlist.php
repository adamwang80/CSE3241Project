<?php
    include("conn.php"); //connection to database
    $sql = "SELECT First_Name, Middle_Name, Last_Name, Age, Earliest_Arrival_Date FROM PATIENTS WHERE PATIENTS.Patient_Id NOT IN (SELECT Patient_Id FROM SCHEDULE)";
    $query = mysqli_query($conn, $sql);
    echo "<table style= \"BORDER-COLLAPSE: collapse\" borderColor=\"#111111\" cellSpacing=\"0\" cellPadding=\"2\" border=\"1\">";
    echo "  <tr>";
    echo "      <td> Name </td>";
    echo "      <td> Age </td>";
    echo "      <td> Earliest Arrival Date </td> ";
    echo "  </tr>";
    while($row = mysqli_fetch_assoc($query)){
        echo "  <tr>";
        echo "      <td> ".$row['First_Name']." ".$row['Middle_Name']." ".$row['Last_Name']." </td>";
        echo "      <td> ".$row['Age']." </td>";
        echo "      <td> ".$row['Earliest_Arrival_Date']." </td>";
        echo "  </tr>";
    }
    echo "</table>"
?>


<html lang="en">
<meta charset="UTF-8">
<meta name="Author" content="Kangxuan Ye">
<head>
    <title>Inventory</title>
</head>

<body>
    <h2> Successfully jumped </h2>
        <table>
        <tr>
            <td><a href="admin.php">Return</a></td>
            <td><a href="inventory.php">Inventory</a></td>
            <td><a href="people_dosed.php">People Dosed</a></td>
            <td><a href="waitlist.php">Waitlist</a></td>
        </tr>
    </table>
</body>
</html>