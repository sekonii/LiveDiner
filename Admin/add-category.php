<?php
include ('partials/menu.php');
?>
    <div class="main-content">
        <div class="container">
           <h1>Add Category</h1><br><br><br>

           <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset ($_SESSION['add']);
        }
        ?>
        <?php
     if(isset($_SESSION['upload'])){
         echo $_SESSION['upload'];
         unset ($_SESSION['upload']);
     }
     ?><br><br>

           <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image </td>
                        <td>
                            <input style="border-bottom: none;" type="file" name="image"> 
                        </td>
                    </tr>

                    <tr>
                        <td>Featured </td>
                        <td>
                            <input style="width: 8%;" type="radio" name="featured" value="yes"> Yes  
                            <input style="width: 8%;" type="radio" name="featured" value="no"> No  
                        </td>
                    </tr>

                    <tr>
                        <td>Active </td>
                        <td>
                            <input style="width: 8%;" type="radio" name="active" value="yes"> Yes  
                            <input style="width: 8%;" type="radio" name="active" value="no"> No
                    </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <button type="submit" name="submit" value="Add Category" class="btn-primary"> Add Category</button>
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
    $title = $_POST['title'];

    if(isset($_POST['featured'])){
        
    $featured = $_POST['featured'];
    }else{
        $featured = "no";
    }
    if(isset($_POST['active'])){

    $active = $_POST['active'];
    }else{
        $active = "no";
    }


    // print_r($_FILES['image']);

    // die();

    if(isset($_FILES['image']['name']))
    {
        $image_name = $_FILES['image']['name'];

        if($image_name != ""){

        

        $ext = end(explode('.', $image_name));

        $image_name = "category_".rand(000, 999).'.'.$ext;

        $source_path = $_FILES['image']['tmp_name'];

        $destination_path = "../images/category/".$image_name;

        $upload = move_uploaded_file($source_path, $destination_path);

        if($upload == FALSE){
            $_SESSION['upload'] = "<div class='error'>Failed to add Image, Try again.</div>";
            header("location:" .SITEURL. "admin/add-category.php");
            die();
        }
    }

        }else{
            $image_name = "";
        }


    $sql = "INSERT INTO tbl_category SET 
    title = '$title',
    image_name = '$image_name',
    featured = '$featured',
    active = '$active'
    ";

    $res = mysqli_query($conn, $sql);

    if($res == TRUE){
        $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
            header("location:" .SITEURL. "admin/manage-category.php");
    }else{
        $_SESSION['add'] = "<div class='error'>Failed to add Category, Try again later.</div>";
            header("location:" .SITEURL. "admin/add-category.php");
    }
}
?>