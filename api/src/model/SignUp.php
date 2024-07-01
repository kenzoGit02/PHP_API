<?php

namespace api\src\model;

use PDO;
class SignUp {
    private PDO $conn;
    private $table = 'user';

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db->connect();
    }
    
    public function testFunction() {
        return [$this->password, $this->username];
    }

    public function create(): string|false
    {
        $query = 'INSERT INTO ' . $this->table . '(username, password) VALUES (:username, :password)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }
    public function read() {
        $query = 'SELECT username FROM ' . $this->table . ' WHERE username = :username';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }
}