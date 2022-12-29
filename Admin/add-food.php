<?php
include ('partials/menu.php');
?>

<div class="main-content">
  <div class="wrapper">

    <h1>Add Food</h1>
    <br><br>
    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
      <tr>
            <td>Title </td>
            <td>
                <input type="text" name="title" placeholder="Food Title">
            </td>
        </tr>

        <tr>
            <td>Description </td>
            <td>
                <input type="text" name="description" placeholder="Description">
            </td>
        </tr>

        <tr>
            <td>Price </td>
            <td>
                <input type="text" name="price" placeholder="Item Price">
            </td>
        </tr>

        <tr>
            <td>Select Image </td>
            <td>
                <input style="border-bottom: none;" type="file" name="image"> 
            </td>
        </tr>

        <tr>
          <td>Category</td>
          <td>
            <select name="category">
              <?php displayCategories($conn); ?>
            </select>
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
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="submit" value="Update Food" class="btn-primary"> Update Food</button>
            </td>
        </tr>
      </table>
    </form>

    <?php
    if (isset($_POST['submit'])) {
      #get the inputs data
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $desc = mysqli_real_escape_string($conn, $_POST['description']);
      $price = mysqli_real_escape_string($conn, $_POST['price']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);
      $categoryId = getCategoryID($category, $conn);
      $feature = mysqli_real_escape_string($conn, $_POST['feature']);
      $active = mysqli_real_escape_string($conn, $_POST['active']);
      $image_name = imgFunction($conn);

      #add the inputs data in our database
      addDataInDatabase($title, $desc, $price, $image_name, $categoryId, $feature, $active, $conn);
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

    #for image inputs
    #check if there has a image
    function imgFunction($conn) {
      if (isset($_FILES['image']['name'])) {
        #get the image name
        $image_name = mysqli_real_escape_string($conn, $_FILES['image']['name']);

        // check wether there hava an image
        if ($image_name != "") {
          #rename the image
          # 1. get the extension name of the image
          $ext = explode('.', $image_name);
          $ext = '.' . end($ext);

          # 2. generate the image name with random number
          $imgNewName = 'Food_' . rand(000, 999) . $ext;

          #upload the image in to our file folder
          # 1. get the source path
          $sourcePath = $_FILES['image']['tmp_name'];

          # 2. get the desitnation path
          $destinationPath = '../images/food/' . $imgNewName;
          # 3. upload the image
          if (!move_uploaded_file($sourcePath, $destinationPath)) {
            $_SESSION['img-upload'] = "<div class='error'>SOMETHING WENT WRONG</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
            die();
          }
          return $imgNewName;
        }

        return "Image is not currently available";
      }
    }

    function addDataInDatabase($title, $desc, $price, $image_name, $category, $feature, $active, $conn) {
      # create a query to select a table in our database and update the database;
      $query = "INSERT INTO tbl_food(title, description, price, image_name, category_Id, featured, active)
                  VALUE('$title', '$desc', '$price', '$image_name', '$category', '$feature', '$active')";

      if (mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        $_SESSION['add'] = "<div class='success'>FOOD ADDED SUCCESSFULY</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
      } else {
        $_SESSION['add'] = "<div class='success'>FAILED TO ADD IMAGE</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
      }
    }
    ?>
  </div>
</div>

<?php
include ('partials/footer.php');
?>