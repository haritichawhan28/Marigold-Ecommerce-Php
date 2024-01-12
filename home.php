<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>MARIGOLD</title>
 </head>
 <body>


<! <?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
}else{
     header("Location: index.php");
     exit();
}
?> >

<?php
session_start();

// Check if product is coming or not
if (isset($_GET['pro_id'])) {

  $proid = $_GET['pro_id'];

  // If session cart is not empty
  if (!empty($_SESSION['cart'])) {

    // Using "array_column() function" we get the product id existing in session cart array
    $acol = array_column($_SESSION['cart'], 'pro_id');

    // now we compare whther id already exist with "in_array() function"
    if (in_array($proid, $acol)) {

      // Updating quantity if item already exist
      $_SESSION['cart'][$proid]['qty'] += 1;
    } else {
      // If item doesn't exist in session cart array, we add a new item
      $item = [
        'pro_id' => $_GET['pro_id'],
        'qty' => 1
      ];

      $_SESSION['cart'][$proid] = $item;
    }
  } else {
    // If cart is completely empty, then store item in session cart
    $item = [
      'pro_id' => $_GET['pro_id'],
      'qty' => 1
    ];

    $_SESSION['cart'][$proid] = $item;
  }
}

?>

<?php include 'header.php'; ?>

<div class="container">
 
  <div class="row">

    <div class="col-md-4">
      <div class="card" style="width: 18rem;">
        <img src="img/product1.jpeg" class="card-img-top">

        <div class="card-body">
          <h5 class="card-title">Marigold</h5>
          <p class="card-text">15Rs/- </p>
          <a href="home.php?pro_id=Marigold" class="btn btn-success">Add to Cart</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card" style="width: 18rem;">
        <img src="img/product1.jpeg" class="card-img-top">

        <div class="card-body">
          <h5 class="card-title">Marigold</h5>
          <p class="card-text">15Rs/- </p>
          <a href="home.php?pro_id=Marigold1" class="btn btn-success">Add to Cart</a>
        </div>
      </div>
    </div>


    <div class="col-md-4">
      <div class="card" style="width: 18rem;">
        <img src="img/product4.jpeg" class="card-img-top">

        <div class="card-body">
          <h5 class="card-title">Marigold</h5>
          <p class="card-text">20Rs/- </p>
          <a href="home.php?pro_id=Marigold2" class="btn btn-success">Add to Cart</a>
        </div>
      </div>
    </div>

  </div>



<?php 
require("db_conn.php"); // Get config file
// Check for successful image upload
if (isset($_FILES["Media"]) && $_FILES["Media"]["error"] == 0) {

    // Get uploaded image content
    $uploadedImageContent = file_get_contents($_FILES['Media']['tmp_name']);
    $name =$_REQUEST['name'];
    // Prepare SQL query to insert image
    $insertImageStmt = mysqli_prepare($conn, "INSERT INTO tbl_media(Media, price) VALUES(?, $name)");

    if($insertImageStmt === false) {
        // SQL prep failed
        $message = "SQL prep failed: " . mysqli_error($conn);
    } else {
        // Bind image content to SQL query
        mysqli_stmt_bind_param($insertImageStmt, 's', $uploadedImageContent);
        
        // Execute SQL query
        if (mysqli_stmt_execute($insertImageStmt)) {
            // Upload successful
           
            $message ="/-Rs";
        } else {
            // Upload failed
            $message = "Upload failed: " . mysqli_stmt_error($insertImageStmt);
        }
    }
}
?>


<?php
    // Fetch latest uploaded image
    $result = mysqli_query($conn, "SELECT MediaID, Media, price FROM tbl_media ORDER BY MediaID DESC LIMIT 1");
   
    if ($result && mysqli_num_rows($result) > 0) {
        // Extract image data if exists
     
        $imageRow = mysqli_fetch_assoc($result);
        
        // Display the image
        echo '<img src="data:image/jpeg;base64,' . base64_encode($imageRow['Media']) . '" alt="Uploaded Image">';
       
        echo "<br>";
        echo "<a href='home.php?pro_id=Marigold '>Add to cart</a>";
        echo "<br>";

      // Delete the image from the database
      //  $deleteResult = mysqli_query($conn, "DELETE FROM tbl_media WHERE MediaID = " . $imageRow['MediaID']);

    }

    $sql = "select * from tbl_media"; 
    $pr = ($conn->query($sql)); 
    //declare array to store the data of database 
    $row = [3];  
  
    if ($pr->num_rows > 0)  
    { 
        // fetch all data from db into array  
        $row = $pr->fetch_all(MYSQLI_ASSOC);   
    } 
  
    if(!empty($row)) 
    foreach($row as $rows) 
   {  
    echo $rows['price']; 
   }

    // Output message if exists
    echo isset($message) ? "$message" : '';

    // Close the DB connection
    mysqli_close($conn);
    ?>
</div>


<?php include 'footer.php'; ?>

 </body>
 </html>





 