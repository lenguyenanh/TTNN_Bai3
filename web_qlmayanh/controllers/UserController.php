<?php
require_once '../models/User.php';

class UserController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login()
    {
        $users = array(
            'username' => $_POST['username'],
            'password' => $_POST['password']
        );


        $user = new User();
        $result = $user->authenticate($users);

        if ($result['status'] == 'success') {
            $_SESSION['username'] = $users['username'];
            $_SESSION['user'] = $result['user'];
            header("location: home.php");
        } else {
            $_SESSION['error'] = $result['message'];
        }
    }
}
