<?php
namespace App\Model;

use PDO;
class Login {
    private PDO $conn;
    private $table = 'user';

    public $id;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db->connect();
    }
    
    public function AuthTest() {
        return "test";
    }
    
    public function read() 
    {
        $query = "SELECT * FROM  $this->table WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

        // echo json_encode($query);
        // exit;

        $stmt->execute();
        $result = $stmt->fetch();
        // echo json_encode($result);
        // exit;
        return $result;
    }
    public function emailIsVerified()
    {
        $query = "UPDATE $this->table SET is_verified = 1 WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}