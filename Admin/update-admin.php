<?php
include ('partials/menu.php');
?>
     <div class="main-content">
        <div class="wrapper">
           <h1>Update Admin</h1><br><br><br>

        <?php

            $id=$_GET['id'];

            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            $res = mysqli_query($conn, $sql);

            if($res == TRUE){
                $count = mysqli_num_rows($res);
                if($count==1)
                {
                    $rows = mysqli_fetch_assoc($res);

                    $id=$rows['id'];
                    $fullname=$rows['fullname'];
                    $username=$rows['username'];
                }
            }else{
                header("location:" .SITEURL. "admin/manage-admin.php");
            }
        ?>

           <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Fullname  </td>
                        <td><input type="text" name="fullname" value="<?php echo $fullname; ?>"></td>
                    </tr>
                    <tr>
                        <td>Username  </td>
                        <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" name="submit" value="Update Admin" class="btn-primary">Update Admin</button>
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
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];


// save data to database
$sql = "UPDATE tbl_admin SET 
    fullname = '$fullname',
    username = '$username'
    WHERE id='$id'
";

$res = mysqli_query($conn, $sql);

if($res == TRUE){
    $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
    header("location:" .SITEURL. "admin/manage-admin.php");
}else{
    $_SESSION['update'] = "<div class='error'>Failed to update Admin, Try again later.</div>";
    header("location:" .SITEURL. "admin/manage-admin.php");
}
}
?>