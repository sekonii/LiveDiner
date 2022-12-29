<?php 

include ('../config/constant.php');

    // Get order id to be deleted
    $id = $_GET['id'];

    // Create sql query to delete order
    $sql = "DELETE FROM tbl_order WHERE id=$id";

    // execute the query
    $res = mysqli_query($conn, $sql);
    // Redirect to manage Order page with success/error message
    if($res == TRUE){
        // echo "Order deleted";
        $_SESSION['delete'] = "<div class='success'>Order deleted Successfully.</div>";
        header("location:" .SITEURL. "admin/manage-order.php");

    }else{
        // echo "Order failed to delete";
        $_SESSION['delete'] = "<div class='error'>Failed to delete Order, Try again later.</div>";
        header("location:" .SITEURL. "admin/manage-order.php");
    }

?>