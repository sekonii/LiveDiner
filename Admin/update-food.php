<?php
include ('partials/menu.php');
?>
    <div class="main-content">
        <div class="container">
           <h1>Update Food</h1><br><br><br>
           <?php
           if(isset($_SESSION['no-food'])){
                echo $_SESSION['no-food'];
                unset ($_SESSION['no-food']);
            }
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }
            ?><br><br>

<?php
//get the food id in our url
$id = $_GET['id'];

//Create a query that will get the editing data to the database
$query = "SELECT * FROM tbl_food WHERE id = $id";

//execute the query to get the result from the database
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

//fetcht the result in the sqli query so the we can use data in our webpage
$food = mysqli_fetch_assoc($res);

// free the result from the query
mysqli_free_result($res);

// print_r($food);
// echo $food['title'];
?>

<form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                <tr>
          <td>Title: </td>
          <td><input type="text" name="title" placeholder="Title" value="<?php echo $food['title']; ?>" /></td>
        </tr>

        <tr>
          <td>Price: </td>
          <td><input type="number" name="price" placeholder="Price" value="<?php echo $food['price']; ?>" /></td>
        </tr>

        <tr>
          <td>Description: </td>
          <td><textarea name="description" placeholder='description...' cols="30" rows="5"><?php echo $food['description']; ?></textarea></td>
        </tr>

        <tr>
            <td>Current Image </td>
            <td>
        <?php 
            if($food != ""){
                ?>
                <img src="<?php echo SITEURL; ?>images/food/<?php echo $food['image_name']; ?>" width="100px" alt="">
                <?php
            }else{
                echo "<div class='error'>Image not found</div>";
            }
        ?>
            </td>
        </tr>

        <tr>
          <td>Image: </td>
          <td><input type="file" name="image" /></td>
        </tr>

        <tr>
          <td>Category</td>
          <td>
            <select name="category">
              <?php displayCategories($conn); ?>
            </select>
          </td>
        </tr>

        <!-- for radios inputs -->

        <tr>
            <td>Featured </td>
            <td>
                <input style="width: 8%;" <?php if($food['featured']=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes 

                <input style="width: 8%;" <?php if($food['featured']=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No  
            </td>
        </tr>

        <tr>
            <td>Active </td>
            <td>
                <input style="width: 8%;" <?php if($food['active'] == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes 

                <input style="width: 8%;" <?php if($food['active'] == "No"){echo "checked";} ?> type="radio" name="active" value="No"> No
        </td>
        </tr>
                    <tr>
                        <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $food['id']; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $food['current_image']; ?>">
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
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $categoryId = getCategoryID($category, $conn);
    $featured = mysqli_real_escape_string($conn, $_POST['featured']);
    $active = mysqli_real_escape_string($conn, $_POST['active']);
    $image_name = $food['image_name'];
    $newImg = editImage($image_name);
  
    //CREATE A QUERY THAT WILL UPDATE THE DATA BASE
    $query2 = "UPDATE tbl_food SET
                title = '$title',
                price = '$price',
                category_id = '$categoryId',
                description = '$description',
                image_name = '$newImg',
                featured = '$featured',
                active = '$active'
              WHERE 
                id = $id";
  
    if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
      $_SESSION['edit-food'] = "<div class=\"success\">SUCCESSFULY UPDATED FOOD</div>";
      header('location:' . SITEURL . 'admin/manage-food.php');
    }
  }
  
  function editImage($image_name) {
    if (isset($_FILES['image']['name'])) {
  
      $newImg = $_FILES['image']['name'];
      if ($newImg != '') {
        deleteCurrentImg($image_name);
        return uploadNewImg($newImg);
      } else {
        return $image_name;
      }
    }
  }
  
  function deleteCurrentImg($image_name) {
    $isImg = $image_name != 'Image is not currently available' && $image_name != '';
    if ($isImg) {
      $imgPath = '../images/food/' . $image_name;
      if (file_exists($imgPath)) {
        echo 'img-deleted';
        unlink($imgPath);
      }
    }
  }
  
  function uploadNewImg($newImg) {
    $ext = explode('.', $newImg);
    $ext = '.' . end($ext);
    $renameImg = 'Food_' . rand(000, 999) . $ext;
    $sourcePath = $_FILES['image']['tmp_name'];
    $destinationPath = '../images/food/' . $renameImg;
    move_uploaded_file($sourcePath, $destinationPath);
    return $renameImg;
  }
  
  # display the categories in the database
  function displayCategories($conn) {
    # create a query that will select all the name of 
    $query3 = "SELECT title FROM tbl_category";
  
    # execute the query
    $res = mysqli_query($conn, $query3) or die(mysqli_error($conn));
    # fetch the data from the result
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
  
    #free the result
    mysqli_free_result($res);
  
    foreach ($categories as $category) {
      $categ = $category['title'];
      echo "<option value='$categ'>$categ</option>";
    }
  }
  
  #get the category ID
  function getCategoryID($category, $conn) {
    #create a query that will get ourcategory id in our database
    $query4 = "SELECT id FROM tbl_category WHERE title = '$category'";
  
    #execute the query the and return the id of the categry
    $res = mysqli_query($conn, $query4) or die(mysqli_error($conn));
  
    #fetch the id from the result;
    $categoryId = mysqli_fetch_assoc($res);
  
    # free the result 
    mysqli_free_result($res);
  
    return $categoryId['id'];
  }
  ?>
