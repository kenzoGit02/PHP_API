<?php
class User {
    private $conn;
    private $table = 'posts';

    public $id;
    public $title;
    public $body;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT id, title, body FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readSingle() {
        $query = 'SELECT id, title, body FROM ' . $this->table . 'WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET title = :title, body = :body WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
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