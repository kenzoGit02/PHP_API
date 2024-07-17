<?php

namespace api\src\controller;

require_once '../vendor/autoload.php';

use api\src\model\SignUp;
use api\src\trait\Emailer;
use api\src\trait\Response;
use api\src\trait\Validation;

class SignUpController
{
    use Response;
    use Validation;
    use Emailer;

    private $key = "CI6IkpXVCJ9";
    private $SignUp;

    public function __construct(private $db)
    {
        $this->SignUp = new SignUp($db);
    }

    public function test(): void
    {
        echo json_encode([$this->db, $this->SignUp]);
        exit("exit");
    }

    public function signUp(): array
    {
        $request = (array) json_decode(file_get_contents('php://input'), true);

        if(!$this->validateInput($request)){

            $this->unprocessableEntityResponse();

        }

        $this->SignUp->email = $request['email'];

        $hashed = password_hash($request['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        $this->SignUp->password = $hashed;
        
        $verification_code = mt_rand(100000, 999999);
        $this->SignUp->verification_code = $verification_code;

        if($this->SignUp->read()){

            return $this->emailExist();

        }

        $userId = $this->SignUp->create();

        if (!$userId){

            return $this->createErrorResponse();

        }
        
        $this->createEmail(to: $request["email"], verification_code: $verification_code);
        return $this->emailSent();
    }
}