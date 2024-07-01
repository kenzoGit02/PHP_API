<?php

namespace api\src\model;

use PDO;
class Login {
    private PDO $conn;
    private $table = 'user';

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db->connect();
    }
    
    public function AuthTest() {
        return "test";
    }
    
    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE username = :username';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);

        // echo json_encode($query);
        // exit;

        $stmt->execute();
        $result = $stmt->fetch();
        // echo json_encode($result);
        // exit;
        return $result;
    }
}