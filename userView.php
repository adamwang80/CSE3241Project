<?php
    session_start();
    include("conn.php"); //connection to database
    echo $_SESSION['username'];
    $sql = "Select S.Patient_Id, S.Tracking_Number, S.Status, S.Arrival_Date, B.Manufacturer FROM SCHEDULE AS S, ACCOUNTS AS A, BATCHES AS B, DOSES AS D WHERE A.Username = '".$_SESSION['username']."' AND S.Patient_Id = A.Patient_Id AND D.Tracking_Number = S.Tracking_Number AND D.Batch_id = B.Batch_id";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        echo "<table id=\"personal_schedule\" style= \"BORDER-COLLAPSE: collapse\" borderColor=\"#111111\" cellSpacing=\"0\" cellPadding=\"2\" border=\"1\">";
        echo "  <tr>";
        echo "      <td> Vaccine Tracking Number </td>";
        echo "      <td> Status </td> ";
        echo "      <td> (Estimated) Arrival Date </td> ";
        echo "      <td> Brand </td> ";
        echo "  </tr>";
        while($row = mysqli_fetch_assoc($query)){

            echo "  <tr id=\"".$row['Patient_Id']."\">";
            echo "      <td> ".$row['Tracking_Number']." </td>";
            echo "      <td> ".$row['Status']." </td>";
            echo "      <td> ".$row['Arrival_Date']." </td>";
            echo "      <td> ".$row['Manufacturer']." </td>";
            if($row['Status'] == 'Scheduled'){
                echo "      <td> <button type=\"button\" name=\"cancel_dose\" id=\"".$row['Patient_Id']."-".$row['Tracking_Number']."\" onclick=\"cancel_dose(this.id)\"> Cancel Schedule </button> </td> ";
            }
            echo "  </tr>";
        }
        echo "</table>";
    } else {
        echo "You have not make an appointment yet!";
    }

?>


<html lang="en">
<meta charset="UTF-8">
<meta name="Author" content="Kangxuan Ye">
<head>
    <title>Admin</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    function cancel_dose(id){

        arr = id.split('-');
        patient_id = arr[0];

        $.ajax({
            url: "cancelDose.php",
            type:"post",
            data:{ patient_id: arr[0],
                   tracking_number: arr[1]
                },


        success: function(result){
            $('table#schedule tr#'+patient_id).remove();
            alert('Patient\'s schedule has been successfully cancelled.');
            location.reload();
            }
        });
    }
</script>
<body>
    <h2> Successfully jumped to userView </h2>
    <table>
        <tr>
            <td><a href="index.php">Return to Homepage</a></td>
        </tr>
    </table>
</body>
</html>