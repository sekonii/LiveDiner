<?php include ('partials/menu.php'); ?>

<div class="main-content">
        <div class="wrapper">
           <h1>Change Password</h1><br><br><br>

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
                        <td>Curent Password  </td>
                        <td><input type="password" name="current_password" placeholder="Old Password"></td>
                    </tr>
                    <tr>
                        <td>New Password  </td>
                        <td><input type="password" name="new_password" placeholder="New Password"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password  </td>
                        <td><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" name="submit" value="hange Password" class="btn-primary">Update Admin</button>
                        </td>
                    </tr>
                    
                </table>
           </form>
        </div>
    </div>

<?php include ('partials/footer.php'); ?>


<?php
// check submit button
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);


    $sql = "SELECT * FROM tbl_admin Where id=$id AND password='$current_password'";

    $res = mysqli_query($conn, $sql);
    if($res == TRUE){

        $count = mysqli_num_rows($res);
        if($count==1){
            if($new_password==$confirm_password){
                $sql2 = "UPDATE tbl_admin SET 
                password = '$new_password'
                WHERE id='$id'
            ";

            $res2 = mysqli_query($conn, $sql2);
            if($res2 == TRUE){
                $_SESSION['password'] = "<div class='success'>Password Updated Successfully.</div>";
            }else{
                $_SESSION['password'] = "<div class='error'>Failed to update password, Try again later.</div>";
                header("location:" .SITEURL. "admin/manage-admin.php");
            }   
                
            }else{
                $_SESSION['incorrect'] = "<div class='error'>Incorrect Password</div>";
                header("location:" .SITEURL. "admin/update-password.php");
            }
        }else{
            
        }
    }else{
        $_SESSION['user-not-found'] = "<div class='error'>Admin not found</div>";
        header("location:" .SITEURL. "admin/manage-admin.php");
    }
}
?>