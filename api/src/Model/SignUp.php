<?php
namespace App\Model;

use PDO;
class SignUp {
    private PDO $conn;
    private $table = 'user';

    public $id;
    public $email;
    public $password;
    public $verification_code;

    public function __construct($db) {
        $this->conn = $db->connect();
    }
    
    public function testFunction() {
        return [$this->password, $this->email];
    }

    public function create(): string|false
    {
        $query = 'INSERT INTO ' . $this->table . '(email, password, verification_code) VALUES (:email, :password, :verification_code)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':verification_code', $this->verification_code, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }
    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }
}