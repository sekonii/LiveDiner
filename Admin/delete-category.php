<?php 

include ('../config/constant.php');

    // Get categoty id to be deleted
    if(isset($_GET['id']) && isset($_GET['image_name'])){

        $id = $_GET['id'];
        $image_name = $_GET['image_name']; 
        
        if($image_name != ""){

            $path = "../images/category/".$image_name;

            $remove = unlink($path);

            if($remove == FALSE){
                $_SESSION['upload'] = "<div class='error'>Failed to remove image</div>";
                header("location:" .SITEURL. "admin/manage-category.php");
                die();
            }
        }
        
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        // execute the query
        $res = mysqli_query($conn, $sql);
        // Redirect to manage category page with success/error message
        if($res == TRUE){
            // echo "category deleted";
            $_SESSION['delete'] = "<div class='success'>category deleted Successfully.</div>";
            header("location:" .SITEURL. "admin/manage-category.php");
    
        }else{
                // echo "category failed to delete";
                $_SESSION['delete'] = "<div class='error'>Failed to delete category, Try again later.</div>";
                header("location:" .SITEURL. "admin/manage-category.php");
            }
        
    }else{
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized access</div>";
        header("location:" .SITEURL. "admin/manage-category.php");
    }



?>