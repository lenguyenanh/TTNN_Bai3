<?php
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'ql_mayanh');
    define('DB_USER', 'root');
    define('DB_PASS', '123456');

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
