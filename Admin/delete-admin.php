<?php 

include ('../config/constant.php');

    // Get admin id to be deleted
    $id = $_GET['id'];

    // Create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    // execute the query
    $res = mysqli_query($conn, $sql);
    // Redirect to manage admin page with success/error message
    if($res == TRUE){
        // echo "Admin deleted";
        $_SESSION['delete'] = "<div class='success'>Admin deleted Successfully.</div>";
        header("location:" .SITEURL. "admin/manage-admin.php");

    }else{
        // echo "Admin failed to delete";
        $_SESSION['delete'] = "<div class='error'>Failed to delete Admin, Try again later.</div>";
        header("location:" .SITEURL. "admin/manage-admin.php");
    }

?>