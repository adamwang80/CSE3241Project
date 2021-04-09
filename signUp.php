<?php
    session_start();
    include("conn.php");
    $username = isset($_POST['username']) ? $_POST['username'] : '' ;
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '' ;
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '' ;
    $mname = isset($_POST['mname']) ? $_POST['mname'] : '' ;
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '' ;
    $age = $_POST['age'];
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $arrival_date = isset($_POST['arrival_date']) ? $_POST['arrival_date'] : '';
    $priority = isset($_POST['priority']) ? $_POST['priority'] : 3;
    $ealiest_date = isset($_POST['earliest_date']) ? $_POST['earliest_date'] : '';

    if(isset($_POST['signUp'])){
        $sql = "INSERT INTO PATIENTS(First_Name, Middle_Name, Last_Name, Age, Phone_Number, Priority, Earliest_Arrival_Data) VALUES ('$fname', '$mname', '$lname', '$age', '$phone_number', '$priority', '$ealiest_date')";
        mysqli_query($conn, $sql);
        echo "Successfully insert value in patients table.";
        $sql = "SELECT Patient_Id FROM PATIENTS WHERE First_Name = '$fname' AND Middle_Name = '$mname' AND Last_Name = '$lname' AND Age = '$age' AND Phone_Number = '$phone_number' AND Priority = '$priority' AND Earliest_Arrival_Data = '$ealiest_date'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $patient_id = $row['Patient_Id'];
        $sql = "INSERT INTO ACCOUNTS(Username, Password, Patient_Id) VALUES ('$username', '$password2', '$patient_id')";
        mysqli_query($conn, $sql);
        echo "Successfully insert value in patients table.";
    } else {
        echo "Failed.";
    }
?>

<html lang="en">
<meta charset="UTF-8">
<meta name="Author" content="Kangxuan Ye">
<head>
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign up your account in BUR</h2>
    <form action="" method="post" name="registration_form">
        <table>
            <tr>
                <td>Username: </td>
                <td><input type="username" name="username"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password1"></td>
            </tr>
            <tr>
                <td>Confirm password: </td>
                <td><input type="password" name="password2"></td>
            </tr>
            <tr>
                <td>First name: </td>
                <td><input type="text" name="fname"></td>
            </tr>
            <tr>
                <td>Middle name: </td>
                <td><input type="text" name="mname"></td>
            </tr>
            <tr>
                <td>Last name: </td>
                <td><input type="text" name="lname"></td>
            </tr>
            <tr>
                <td>Age: </td>
                <td><input type="number" name="age"></td>
            </tr>
            <tr>
                <td>Phone number: </td>
                <td><input type="text" name="phone_number"></td>
            </tr>
            <tr>
                <td>Priority: </td>
                <td><input type="number" name="priority"></td>
            </tr>
            <tr>
                <td>Earliest arrival date: </td>
                <td><input type="date" name="earliest_date"></td>
            </tr>
            <tr>
                <td><input type="submit" name="signUp" value="Sign Up"></td>
                <td><a href="login.php">Login</a></td>
            </tr>
            <tr>
                <td><a href="index.php">Return to Homepage</a></td>
            </tr>
        </table>
    </form>
</body>
</html>