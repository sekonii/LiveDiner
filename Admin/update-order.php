<?php
include ('partials/menu.php');
?>
    <div class="main-content">
        <div class="container">
           <h1>Update Food</h1><br><br><br>
           <?php
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }
            ?><br><br>

           <?php

$id=$_GET['id'];

$sql = "SELECT * FROM tbl_order WHERE id=$id";

$res = mysqli_query($conn, $sql);

if($res == TRUE){
    $count = mysqli_num_rows($res);
    if($count==1)
    {
        $rows = mysqli_fetch_assoc($res);

        $id = $rows['id'];
        $food = $rows['food'];
        $price = $rows['price'];
        $qty = $rows['qty'];
        $total = $rows['total'];
        $status = $rows['status'];
        $customer_name = $rows['customer_name'];
        $customer_contact = $rows['customer_contact'];
        $customer_email = $rows['customer_email'];
        $customer_address = $rows['customer_address'];

    }
}else{
    $_SESSION['no-category'] = "<div class='error'>Order not found.</div>";
    header("location:" .SITEURL. "admin/manage-order.php");
}
?>

<form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Meal </td>
                        <td><b><?php echo $food; ?></b></td>
                    </tr>
                    <tr>
                        <td>Price </td>
                        <td><b><?php echo $price; ?></b></td>
                    </tr>
                    <tr>
                        <td>qty </td>
                        <td>
                            <input type="number" name="qty"  value="<?php echo $qty; ?>">
                        </td>
                    </tr>
                    <td>Status </td>
                        <td>
                            <select name="status">
                                <option <?php if($status=="Ordered"){echo "selected";}?> value="Ordered">Ordered</option>
                                <option <?php if($status=="On Delivery"){echo "selected";}?> value="On Delivery">On Delivery</option>
                                <option <?php if($status=="Delivered"){echo "selected";}?> value="Delivered">Delivered</option>
                                <option <?php if($status=="Cancelled"){echo "selected";}?> value="Cancelled">Cancelled</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Customer Name </td>
                        <td>
                            <input type="text" name="customer_name"  value="<?php echo $customer_name; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Customer Contact </td>
                        <td>
                            <input type="text" name="customer_contact"  value="<?php echo $customer_contact; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Customer Email </td>
                        <td>
                            <input type="text" name="customer_email"  value="<?php echo $customer_email; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Customer Address </td>
                        <td>
                            <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <button type="submit" name="submit" value="Update Food" class="btn-primary"> Update Food</button>
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

if (isset($_POST['submit'])) {
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $qty = mysqli_real_escape_string($conn, $_POST['qty']);
  $total = $price * $qty;
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $name = mysqli_real_escape_string($conn, $_POST['customer_name']);
  $contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
  $email = mysqli_real_escape_string($conn, $_POST['customer_email']);
  $address = mysqli_real_escape_string($conn, $_POST['customer_address']);

  $query2 = "UPDATE tbl_order SET 
          qty = $qty,
          status = '$status',
          total = $total,
          customer_name = '$name',
          customer_contact = '$contact',
          customer_email = '$email',
          customer_address = '$address'
        WHERE
          id = $id";

  if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
    $_SESSION['order-update'] = '<div class="success">ORDER UPDATE SUCCESSFULY</div>';
    header('location:' . SITEURL . 'admin/manage-order.php');
  } else {
    $_SESSION['order-update'] = '<div class="error">FAILED TO UPDATE ORDER</div>';
    header('location:' . SITEURL . 'admin/manage-order.php');
  }
}

?>