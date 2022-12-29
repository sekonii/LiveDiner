<?php
include ('../config/constant.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naija Bowl - Naija No 1 online restaurant</title>
    <link href="../images/logo.png" rel="icon">

    <link rel="stylesheet" href="../css/admin.css">
</head>

<body style="background-color: rgb(255, 240, 213);">
    <div class="login">
        
        <img src="../images/logo.png" alt="logo" style="width: 200px; height: 100px; padding-left: 35%;"><br><br><br>

        <h1 class="text-center">Admin Login</h1><br>

        <?php
        if(isset($_SESSION['login'])){
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <?php
        if(isset($_SESSION['no-login'])){
            echo $_SESSION['no-login'];
            unset($_SESSION['no-login']);
        }
        ?><br><br>

        <form action="" method="POST" style="margin-left: 20%;">
        Username <br><br>
        <input type="text" name="username"><br><br>

        Password <br><br>
        <input type="password" name="password"><br><br><br><br>

        <button type="submit" name="submit" class="btn-primary"> Login</button>
        </form><br><br><br>

        <p class="text-center">Created by - <a href="">Wave</a></p>
    </div>
    
</body>
</html>

<?php
// check submit button
if(isset($_POST['submit'])){
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = mysqli_real_escape_string($conn, md5($_POST['password']));

// check login info
$sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

$res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);
    if($count==1)
    {
        $rows = mysqli_fetch_assoc($res);

        $id=$rows['id'];
        $username=$rows['username'];
        $password=$rows['password'];
        $_SESSION['login'] = "<div class='success'>Login Successfull!</div>";
        $_SESSION['user'] =  $username;

        header("location:" .SITEURL. "admin/");
    }else{
        $_SESSION['login'] = "<div class='error'>Incorrect Username or Password!</div>";
        header("location:" .SITEURL. "admin/login.php");
    }

}
?>