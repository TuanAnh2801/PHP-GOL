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
    <h2 class="mt-3">Create Product</h2>

    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" name="name">

    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Price</label>
        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Price" name="price">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Description</label>
        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Description" name="description">
    </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Avatar</label>
            <input type="file" class="form-control" id="avatar" placeholder="Description" name="avatar">
        </div>
    <button type="submit" class="btn btn-primary " >Create now</button>
    </div>
</form>
</body>
</html>
