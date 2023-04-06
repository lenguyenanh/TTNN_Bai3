<?php
    session_start();
    session_unset();
    session_destroy();
    // Xóa phiên đăng nhập của người dùng
    unset($_SESSION['user']);
    
    // Chuyển hướng về trang đăng nhập
    header("Location: /views/login.php");
?>
