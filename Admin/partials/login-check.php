<?php
    if(!isset($_SESSION['user'])){
        $_SESSION['no-login'] = "<div class='error'>Please login to access the admin panel</div>";
        header("location:" .SITEURL. "admin/login.php");
    }
    ?>