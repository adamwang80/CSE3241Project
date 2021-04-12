<?php
    include("conn.php"); //connection to database
    $sql = "SELECT Manufacturer AS Manufacturer, SUM(Quantity_Of_Doses) AS Total_Received, SUM(Quantity_Of_Available) AS Total_Available, SUM(Quantity_Of_Dosed) AS Total_Distributed, SUM(Quantity_Of_Expired) AS Total_Expired FROM BATCHES GROUP BY Manufacturer";
    $query = mysqli_query($conn, $sql);
    echo "<table style= \"BORDER-COLLAPSE: collapse\" borderColor=\"#111111\" cellSpacing=\"0\" cellPadding=\"2\" border=\"1\">";
    echo "  <tr>";
    echo "      <td> Manufacturer </td>";
    echo "      <td> Total received vaccines </td>";
    echo "      <td> Total available vaccines  </td> ";
    echo "      <td> Total distributed vaccines  </td> ";
    echo "      <td> Total expired vaccines  </td> ";
    echo "  </tr>";
    while($row = mysqli_fetch_assoc($query)){
        echo "  <tr>";
        echo "      <td> ".$row['Manufacturer']." </td>";
        echo "      <td> ".$row['Total_Received']." </td>";
        echo "      <td> ".$row['Total_Available']." </td>";
        echo "      <td> ".$row['Total_Distributed']." </td>";
        echo "      <td> ".$row['Total_Expired']." </td>";
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
