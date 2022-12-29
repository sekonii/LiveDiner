<?php
include ('partials/menu.php');
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php $search = mysqli_real_escape_string($conn, $_POST['search']); ?>
            <h2>meals on Your Search <a href="#"><?php echo $search?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu</h2>
            <?php

            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);
            if($count>0){
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $description = $row['description'];
        ?>
        <div class="food-menu-box">
            <div class="food-menu-img">
            <?php
            if($image_name==""){
                echo "<div class='error'>image not available</div>";
            }else{
                ?>
            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve" style="height: 150px;">
                
                <?php
            }
            ?>
            </div>

            <div class="food-menu-desc">
                <h4><?php echo $title?></h4>
                <p class="food-price"><?php echo $price?></p>
                <p class="food-detail"><?php echo $description?></p>
                <br>

                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
            </div>
        </div>

        <?php
            }

        }
        else{
            echo "<div class='error'>Food Not Available</div>";
        }
        
        ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php
include ('partials/footer.php');
?>