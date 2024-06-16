<?php
class SignUp {
    private $conn;
    private $table = 'user';

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function AuthTest() {
        return "test";
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readSingle() {
        $query = 'SELECT * FROM ' . $this->table . 'WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        // SYNTAX ERROR FOR QUERY
        $query = 'INSERT INTO ' . $this->table . '(username, password) VALUE (username = :username, password = :password)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET username = :username, password = :password WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}