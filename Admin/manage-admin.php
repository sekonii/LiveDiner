<?php
include ('partials/menu.php');
?>
    <!-- Main content starts -->
    <div class="main-content">
        <div class="wrapper">
        <h1>Manage Admin</h1><br><br><br>

        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        <?php
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        ?>
        <?php
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <?php
        if(isset($_SESSION['user-not-found'])){
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        ?>
        <?php
        if(isset($_SESSION['incorrect'])){
            echo $_SESSION['incorrect'];
            unset($_SESSION['incorrect']);
        }
        ?>
        <?php
        if(isset($_SESSION['password'])){
            echo $_SESSION['password'];
            unset($_SESSION['password']);
        }
        ?><br><br><br>

    <a href="add-admin.php" class="btn btn-primary">Add Admin</a><br><br><br>

        <table class="table tbl-full">
            <tr>
                <th>S/N</th>
                <th>Fullname</th>
                <th>Username</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>

            <?php 
            
            $sql = "SELECT * FROM tbl_admin";
            $res = mysqli_query($conn, $sql);

            if($res == TRUE){
                $count = mysqli_num_rows($res);

                $sn=1;

                if($count>0){
                    while($rows = mysqli_fetch_assoc($res)){

                    $id=$rows['id'];
                    $fullname=$rows['fullname'];
                    $username=$rows['username'];
                    $password=$rows['password'];

                    ?>

                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $fullname; ?></td>
                    <td><?php echo $username; ?></td>
                    <td><?php echo $password; ?></td>
                    <td>
                    <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn btn-secondary">Change password</a>
                    <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn btn-primary">Update</a>
                    <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>

                    <?php

                    }
                }else{
                    
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