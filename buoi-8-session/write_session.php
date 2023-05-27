<?php
// 1. Tạo 1 file định danh bạn là ai trên server
// 2. Tạo cookie với tên PHPSESSID
// 3. Client và server đã biết nhau
session_start();
$_SESSION['name']  = 'anh';
echo session_save_path();
