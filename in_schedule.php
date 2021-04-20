<?php

    function test($row){
        include("conn.php"); //connection to database
        $sql1 = "UPDATE SCHEDULE SET Status = 'Dosed' WHERE Tracking_Number = ".$row['Tracking_Number'];
        mysqli_query($conn, $sql1);
    }
    
    include("conn.php"); //connection to database
    $sql = "SELECT P.Patient_Id, P.First_Name, P.Middle_Name, P.Last_Name, P.Age, S.Tracking_Number, S.Status, S.Arrival_Date FROM SCHEDULE AS S, PATIENTS AS P WHERE S.Patient_Id = P.Patient_Id AND S.Status = 'Scheduled'";
    
    
    $query = mysqli_query($conn, $sql);
    echo "<table id=\"schedule\" style= \"BORDER-COLLAPSE: collapse\" borderColor=\"#111111\" cellSpacing=\"0\" cellPadding=\"2\" border=\"1\">";
    echo "  <tr>";
    echo "      <td> Name </td>";
    echo "      <td> Age </td>";
    echo "      <td> Vaccine Tracking Number </td>";
    echo "      <td> Status </td> ";
    echo "      <td> Estimate Arrival Date </td> ";
    echo "  </tr>";
    while($row = mysqli_fetch_assoc($query)){

        echo "  <tr id=\"".$row['Patient_Id']."\">";
        echo "      <td> ".$row['First_Name']." ".$row['Middle_Name']." ".$row['Last_Name']." </td>";
        echo "      <td> ".$row['Age']." </td>";
        echo "      <td> ".$row['Tracking_Number']." </td>";
        echo "      <td> ".$row['Status']." </td>";
        echo "      <td> ".$row['Arrival_Date']." </td>";
        echo "      <td> <button type=\"button\" name=\"dose_confirm\" id=\"".$row['Patient_Id']."-".$row['Tracking_Number']."\" onclick=\"dose_confirm(this.id)\"> Dose Confirm </button> </td> ";
        echo "  </tr>";
    }
    echo "</table>"
?>


<html lang="en">
<meta charset="UTF-8">
<meta name="Author" content="Kangxuan Ye">
<head>
    <title>In-schedule</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    function dose_confirm(id){

        arr = id.split('-');
        patient_id = arr[0];

        $.ajax({
            url: "confirmDose.php",
            type:"post",
            data:{ patient_id: arr[0],
                   tracking_number: arr[1]
                },


        success: function(result){
            $('table#schedule tr#'+patient_id).remove();
            alert('Patient\'s dose is confirmed. Congratulations and Thanks for your contribution.');
            }
        });
    }
</script>
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