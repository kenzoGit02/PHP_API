<?php

namespace App\Controller;

use App\Model\Auth;
use App\Services\Token;
use App\Traits\Emailer;
use App\Traits\Response;
use App\Traits\Validation;

class AuthController
{
    use Response;
    use Validation;
    use Emailer;

    private $key = "CI6IkpXVCJ9";
    private $Auth;

    public function __construct(private $db)
    {
        $this->Auth = new Auth($db);
    }

    public function loginUser(): array
    {
        $request = (array) json_decode(file_get_contents('php://input'), true);

        $this->Auth->email = $request["email"];

        if (!$Auth = $this->Auth->read()) return $this->loginFailed();

        if (!password_verify($request['password'], $Auth["password"])) return $this->loginFailed();

        $id = $Auth["id"];
        $verification_code = $Auth["verification_code"];
        $not_verified = !$Auth["is_verified"];

        if ($not_verified) {
            $this->createEmail(to: $request["email"], verification_code: $verification_code);
            return $this->emailSent();
        }

        $token = Token::generateJWTToken($id);

        if (!$token) return $this->JWTError();

        return $this->loginSuccess($token);
    }

    public function verifyEmail(): array
    {
        $request = (array) json_decode(file_get_contents('php://input'), true);

        $this->Auth->email = $request['email'];

        $Auth = $this->Auth->read();

        if ($Auth["is_verified"]) return $this->alreadyVerified();

        if (!($Auth['verification_code'] === $request['verification_code'])) return $this->verificationFailed();

        if (!$this->Auth->emailToVerified()) return $this->verificationFailed();

        $token = Token::generateJWTToken($Auth['id']);

        if (!$token) return $this->JWTError();

        return $this->verificationSuccess($token);
    }

    public function checkAuth()
    {
        return "Work in progress";
    }

    public function signUp(): array
    {
        $request = (array) json_decode(file_get_contents('php://input'), true);

        if (!$this->validateInput($request)) $this->unprocessableEntityResponse();

        $this->Auth->email = $request['email'];

        $this->Auth->password = password_hash($request['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        $verification_code = mt_rand(100000, 999999);

        $this->Auth->verification_code = $verification_code;

        /**
         * Check if input email already exist
         */
        if ($this->Auth->read()) return $this->emailExist();

        $userId = $this->Auth->create();

        if (!$userId) return $this->createErrorResponse();

        if ($this->createEmail(to: $request["email"], verification_code: $verification_code)) return $this->emailSent();
    }
}
