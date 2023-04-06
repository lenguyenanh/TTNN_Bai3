<?php
    class User {
        private $db;

        public function __construct() {
            require_once 'config.php';
            $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        public function authenticate($users) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $stmt->bind_param("ss", $users['username'], $users['password']);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            if($result) {
                return array('status' => 'success', 'user' => $result);
            } else {
                return array('status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng');
            }
        }
    }