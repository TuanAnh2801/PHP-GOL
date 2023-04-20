<?php //require (__DIR__ .'/index.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Homework</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data"
<div style="width: 100px; height: auto" class="form-group">
    <label>Chọn ảnh nào</label>
    <input type="file" name="avatar" id="avatar">
    <img src="#" style="display: none" width="100" height="100" id="img">
    <input type="submit" name="submit" id="submit" value="Upload">
</div>
<?php include 'avatar.php';?>
</form>
</body>
</html>
<?php
require(__DIR__ . '/uploads.php');
$avatar = new uploads();
$avatar->connectData();
$avatar->avatar();


?>