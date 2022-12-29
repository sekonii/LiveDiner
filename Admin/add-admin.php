<?php
include ('partials/menu.php');
?>
    <div class="main-content">
        <div class="container">
           <h1>Add Admin</h1><br><br><br>

           <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset ($_SESSION['add']);
        }
        ?><br><br>

           <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Fullname </td>
                        <td><input type="text" name="fullname" placeholder="Enter fullname"></td>
                    </tr>
                    <tr>
                        <td>Username </td>
                        <td><input type="text" name="username" placeholder="Enter username"></td>
                    </tr>
                    <tr>
                        <td>Password </td>
                        <td><input type="password" name="password" placeholder="Enter password"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <button type="submit" name="submit" value="Add Admin" class="btn-primary"> Add Admin</button>
                        </td>
                    </tr>
                    
                </table>
           </form>
        </div>
    </div>

<?php
include ('partials/footer.php');
?>

<?php
// save to database
// check submit button
if(isset($_POST['submit'])){
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);


// save data to database
$sql = "INSERT INTO tbl_admin SET 
    fullname = '$fullname',
    username = '$username',
    password = '$password'
";

$res = mysqli_query($conn, $sql);

if($res == TRUE){
    $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
        header("location:" .SITEURL. "admin/manage-admin.php");
}else{
    $_SESSION['add'] = "<div class='error'>Failed to add Admin, Try again later.</div>";
        header("location:" .SITEURL. "admin/add-admin.php");
}
}
?>