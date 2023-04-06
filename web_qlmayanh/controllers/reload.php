<?php
session_start();

if(isset($_POST['reload'])){
    // Unset tất cả các session ngoại trừ $_SESSION['user']
    foreach ($_SESSION as $key => $value) {
        if ($key !== 'user') {
            unset($_SESSION[$key]);      
        }
    }
}
?>
