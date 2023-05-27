<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title></title>
</head>
<body>
<div class="container mt-3">
    <h2>List Product</h2>
    <h3><?php   if (isset($message)){?>
         <?php   echo $message;?>


      <?php }?></h3>
    <div class="text-right "><a href="/product/add" class="btn btn-success">Create</a></div>
    <div class="row mt-3">
        <table class="table ">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Avatar</th>
                <th scope="col">Desciption</th>



            </tr>

            </thead>
            <tbody>
            <?php
            foreach ($productInfo as $key => $product){
                $url ="/product/edit?id=" . $product['id'];
                $urlDelete = "/product/delete?id=" .$product['id'];
            ?>
            <tr>
                <td> <?php echo $product['id'] ?></td>
                <td> <?php echo $product['name'] ?></td>
                <td> <?php echo $product['price'] ?></td>
                <td><img style="width: 50px" src=" /../uploads/<?php echo $product['avatar'] ?>" alt=""></td>
                <td> <?php echo $product['description'] ?></td>
                <td>
                    <div>
                        <a href= "<?php echo $url ?>" class="btn btn-success" ><i class="fas fa-edit"></i></a>
                    </div>
                </td>
                <td>
                    <div>
                        <a  href="<?php echo $urlDelete ?>" class="btn btn-success" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                </td>
                <?php } ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>