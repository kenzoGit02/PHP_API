<?php
class SignUp {
    private PDO $conn;
    private $table = 'user';

    public $id;
    public $username;
    public $password;

    public function __construct(Database $db) {
        $this->conn = $db->connect();
    }
    
    public function SignUpTest() {
        return $this->password;
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
    
    public function create(): int|false 
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