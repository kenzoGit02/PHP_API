<?php
namespace api\src\model;
use PDO;
class User {
    private PDO $conn;
    private $table = 'user';

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db->connect();
    }

    public function select() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    
    public function selectSingle() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function insert() {
        // SYNTAX ERROR FOR QUERY
        $query = 'INSERT INTO ' . $this->table . '(username, password) VALUES (username = :username, password = :password)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

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