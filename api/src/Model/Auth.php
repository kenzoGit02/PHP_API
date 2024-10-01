<?php

namespace App\Model;

use PDO;

class Auth
{
    private PDO $conn;
    private $table = 'user';

    public $id;
    public $email;
    public $password;
    public $verification_code;

    public function __construct($db)
    {
        $this->conn = $db->connect();
    }

    public function AuthTest()
    {
        return "test";
    }

    public function read()
    {
        $query = "SELECT * FROM  $this->table WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch();

        return $result;
    }

    public function emailToVerified()
    {
        $query = "UPDATE $this->table SET is_verified = 1 WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function create()
    {
        // $query = "INSERT INTO $this->table (email, password, verification_code) VALUES (:email, :password, :verification_code)'";
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
}
