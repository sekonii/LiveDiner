<?php
include ('partials/menu.php');
?>


    <!-- Food search -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for meal..." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <?php
        if(isset($_SESSION['order'])){
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }

    if(isset($_SESSION['add'])){
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    ?>
    <!-- Food search ends -->

    <!-- Explore food -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore meals</h2>

            <?php

            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);
            if($count>0){
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>

            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
            <div class="box-3 float-container">
                <?php
                if($image_name==""){
                    echo "<div class='error'>image not available</div>";
                }else{
                    ?>
                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="image" style="Height: 350px;" class="img-responsive img-curve">
                    
                    <?php
                }
                ?>
                <h3 class="float-text text-white"><?php echo $title?></h3>
            </div>
            </a>
                    <?php
                }

            }else{
                echo "<div class='error'>Category Not Available</div>";
            }
            
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Explore food ends -->

    <!-- Menu -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

                <?php

                    $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured = 'Yes' LIMIT 6";

                    $res2 = mysqli_query($conn, $sql2);

                    $count = mysqli_num_rows($res2);
                    if($count>0){
                        while($row = mysqli_fetch_assoc($res2)){
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

            }else{
                echo "<div class='error'>Food Not Available</div>";
            }
            
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Menu ends -->


    <?php
include ('partials/footer.php');
?>
