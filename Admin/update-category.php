<?php
include ('partials/menu.php');
?>
    <div class="main-content">
        <div class="container">
           <h1>Update Category</h1><br><br><br>
           <?php
            if(isset($_SESSION['no-category'])){
                echo $_SESSION['no-category'];
                unset ($_SESSION['no-category']);
            }
            ?><br><br>

           <?php

$id=$_GET['id'];

$sql = "SELECT * FROM tbl_category WHERE id=$id";

$res = mysqli_query($conn, $sql);

if($res == TRUE){
    $count = mysqli_num_rows($res);
    if($count==1)
    {
        $rows = mysqli_fetch_assoc($res);

        $id = $rows['id'];
        $title = $rows['title'];
        $current_image = $rows['image_name'];
        $featured = $rows['featured'];
        $active = $rows['active'];

    }
}else{
    $_SESSION['no-category'] = "<div class='error'>Category not found.</div>";
    header("location:" .SITEURL. "admin/manage-category.php");
}
?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title </td>
                <td>
                    <input type="text" name="title" placeholder="Category Title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image </td>
                <td>
                    <?php 
                    if($current_image != ""){
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px" alt="">
                        <?php
                    }else{
                        echo "<div class='error'>Image not found</div>";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image </td>
                <td>
                    <input style="border-bottom: none;" type="file" name="image"> 
                </td>
            </tr>

            <tr>
                <td>Featured </td>
                <td>
                    <input style="width: 8%;" <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes 

                    <input style="width: 8%;" <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No  
                </td>
            </tr>

            <tr>
                <td>Active </td>
                <td>
                    <input style="width: 8%;" <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes 

                    <input style="width: 8%;" <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No"> No
            </td>
            </tr>
            <tr>
                <td colspan="2">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <button type="submit" name="submit" value="Add Category" class="btn-primary"> Update Category</button>
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
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

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

        if($current_image != ""){
            $remove_path = "../images/category/".$current_image;
            $remove = unlink($remove_path);
        }


        if($remove == FALSE){
            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
            header("location:" .SITEURL. "admin/manage-category.php");
            die();
        }

    }else{
        $image_name = $current_image;
    }

        }else{
            $image_name = $current_image;
        }


// save data to database
$sql2 = "UPDATE tbl_category SET 
    title = '$title',
    image_name = '$image_name',
    featured = '$featured',
    active = '$active'
    WHERE id='$id'
    ";

$res = mysqli_query($conn, $sql2);

if($res == TRUE){
    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
    header("location:" .SITEURL. "admin/manage-category.php");
}else{
    $_SESSION['update'] = "<div class='error'>Failed to update Category, Try again later.</div>";
    header("location:" .SITEURL. "admin/manage-category.php");
}
}
?>