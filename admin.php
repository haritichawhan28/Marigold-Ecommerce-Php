
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MARIGOLD IMG UPLOAD</title>
  <link rel="stylesheet" href="app.css">
</head>

<body>
  <div class="container-custom">
    <h3>Upload Product</h3>

    <form action="home.php" method="post" enctype="multipart/form-data">
        <input type="file" name="Media" accept="image/*"><br>
        Price: <input type="text" name="name"><br>
        <input type="submit" value="Upload"><br>
     
    </form>


</body>
</html>
