<?php
include ('partials/menu.php');
?>
    <!-- Main content starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Food</h1><br><br><br>

<a href="add-food.php" class="btn btn-primary">Add Food</a><br><br><br>
<?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset ($_SESSION['add']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset ($_SESSION['delete']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset ($_SESSION['upload']);
        }
        if(isset($_SESSION['unauthorized'])){
            echo $_SESSION['unauthorized'];
            unset ($_SESSION['unauthorized']);
        }
        if(isset($_SESSION['no-food'])){
            echo $_SESSION['no-food'];
            unset ($_SESSION['no-food']);
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset ($_SESSION['update']);
        }
        
        ?>

    <table class="tbl-full">
        <tr>
            <th>S/N</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Category_id</th>
            <th>Featured</th>
            <th>Active</th>
            <th></th>
        </tr>

        <?php 
            
            $sql = "SELECT * FROM tbl_food";
            $res = mysqli_query($conn, $sql);

            if($res == TRUE){
                $count = mysqli_num_rows($res);

                $sn=1;

                if($count>0){
                    while($rows = mysqli_fetch_assoc($res)){

                    $id = $rows['id'];
                    $title = $rows['title'];
                    $description = $rows['description'];
                    $image_name = $rows['image_name'];
                    $price = $rows['price'];
                    $category_id = $rows['category_id'];
                    $featured = $rows['featured'];
                    $active = $rows['active'];
                    ?>

        <tr>
            <td><?php echo $sn++; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php echo $description; ?></td>
            <td><?php echo $price; ?></td>
            <td>
                <?php
                if($image_name != ""){
                    ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="50px" alt="">
                    <?php
                }else{
                    echo "<div class='error'>Image Unavailable.</div>";
                }

                ?>
            </td>
            <td><?php echo $category_id; ?></td>
            <td><?php echo $featured; ?></td>
            <td><?php echo $active; ?></td>
            <td>
            <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>" class="btn btn-secondary">Update</a>
            <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>

        <?php

        }
        }else{
            ?>

            <tr>
                <td colspan="6"><div class="error">No Food Added</div></td>
            </tr>

            <?php
        }
        }

        ?>
    </table>


        </div>
        <div class="clearfix"></div>
    </div>
    <!-- Main content ends -->

    <?php
include ('partials/footer.php');
?>