<?php
    session_start();
    include("conn.php"); //connection to database
    $postUsername = isset($_POST['username']) ? $_POST['username'] : '' ;
    $postPassword = isset($_POST['password']) ? $_POST['password'] : '' ;
    $sql = "SELECT Username, Password FROM ACCOUNTS WHERE Username = '$postUsername'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    echo $row;
    $username = $row['Username'];
    $password = $row['Password'];
    echo $username;
    echo $password;
    $url = "userView.php";
    if(isset($_POST['login'])){
        if($username == $postUsername && $password == $postPassword){
            $_SESSION['username'] = $username;
            echo "<script>alert('Log in successfully!');</script>";
            echo "<script language='javascript' type ='text/javascript'>";  
            echo " window.location.href='$url'";  
            echo "</script>";  
        } else {
            echo "<script>alert('Username or password incorrect!'); history.go(-1)</script>";
        }
    }



?>




<html lang="en">
<meta charset="UTF-8">
<meta name="Author" content="Kangxuan Ye">
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" name="login_form">
        <table>
            <tr>
                <td>Username: </td>
                <td><input type="username" name="username"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td><input type="submit" name="login" value="Login"></td>
                <td><a href="signUp.php">Sign Up</a></td>
            </tr>
            <tr>
                <td><a href="index.php">Return Homepage</a></td>
            </tr>
        </table>
    </form>
</body>
</html>