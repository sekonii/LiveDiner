<?php 

include ('../config/constant.php');

    // Get Food id to be deleted
    if(isset($_GET['id']) && isset($_GET['image_name'])){

        $id = $_GET['id'];
        $image_name = $_GET['image_name']; 
        
        if($image_name != ""){

            $path = "../images/food/".$image_name;

            $remove = unlink($path);

            if($remove == FALSE){
                $_SESSION['upload'] = "<div class='error'>Failed to remove image</div>";
                header("location:" .SITEURL. "admin/manage-food.php");
                die();
            }
        }
        
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        // execute the query
        $res = mysqli_query($conn, $sql);
        // Redirect to manage Food page with success/error message
        if($res == TRUE){
            // echo "Food deleted";
            $_SESSION['delete'] = "<div class='success'>Food deleted Successfully.</div>";
            header("location:" .SITEURL. "admin/manage-food.php");
    
        }else{
                // echo "Food failed to delete";
                $_SESSION['delete'] = "<div class='error'>Failed to delete Food, Try again later.</div>";
                header("location:" .SITEURL. "admin/manage-food.php");
            }
        
    }else{
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized access</div>";
        header("location:" .SITEURL. "admin/manage-food.php");
    }



?>