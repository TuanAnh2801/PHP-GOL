<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <title></title>
</head>
<body>
<form method="post" action="" enctype="multipart/form-data">
    <div class="container col-md-6">
        <h2 class="mt-3">Edit Product</h2>

        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name"
                   value="<?php
                   echo isset($_POST['name']) ? $_POST['name'] : $products[0]['name'] ?>"
                   class="form-control" id="title"/>

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Price</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Price" name="price"
                   value="<?php
                   echo isset($_POST['price']) ? $_POST['price'] : $products[0]['price'];
                   ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Description</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Description"
                   name="description"
                   value="<?php echo isset($_POST['description']) ? $_POST['description'] : $products[0]['description'] ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Avatar</label>
            <input type="file" class="form-control" id="exampleInputPassword1" placeholder="Description" name="avatar"
                   value="">
            <?php if (!empty($products[0]['avatar'])) : ?>
                <img height="80px" src="uploads/<?php echo $products[0]['description'] ?>">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary ">Edit now</button>
    </div>
</form>
</body>
</html>
