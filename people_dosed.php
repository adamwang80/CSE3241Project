<?php
    include("conn.php"); //connection to database
    $sql = "SELECT P.First_Name, P.Middle_Name, P.Last_Name, S.Tracking_Number, S.Arrival_Date, B.Manufacturer FROM SCHEDULE AS S, DOSES AS D, BATCHES AS B, PATIENTS AS P WHERE P.Patient_Id = S.Patient_Id AND S.Status = 'Dosed' AND S.Tracking_Number = D.Tracking_Number AND D.Batch_id = B.Batch_id";
    $query = mysqli_query($conn, $sql);
    echo "<table style= \"BORDER-COLLAPSE: collapse\" borderColor=\"#111111\" cellSpacing=\"0\" cellPadding=\"2\" border=\"1\">";
    echo "  <tr>";
    echo "      <td> Patient Name </td>";
    echo "      <td> Vaccine Tracking Number </td>";
    echo "      <td> Manufacturer  </td> ";
    echo "      <td> Arrival Date  </td> ";
    echo "  </tr>";
    while($row = mysqli_fetch_assoc($query)){
        echo "  <tr>";
        echo "      <td> ".$row['First_Name']." ".$row['Middle_Name']." ".$row['Last_Name']." </td>";
        echo "      <td> ".$row['Tracking_Number']." </td>";
        echo "      <td> ".$row['Manufacturer']." </td>";
        echo "      <td> ".$row['Arrival_Date']." </td>";
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
</body>
</html>
