<?php

namespace App\Controller;

// require_once '../vendor/autoload.php';

use App\Model\Login;
use App\Services\Auth;
use App\Trait\Emailer;
use App\Trait\Response;

class LoginController
{
    use Emailer;
    use Response;

    private $Login;

    public function __construct(private $db)
    {
        $this->Login = new Login($db);
    }

    public function loginUser(): array
    {
        $request = (array) json_decode(file_get_contents('php://input'), true);

        $this->Login->email = $request["email"];

        if(!$Login = $this->Login->read()){

            return $this->loginFailed();

        }

        if(!password_verify($request['password'],$Login["password"])){

            return $this->loginFailed();

        }

        $id = $Login["id"];
        $verification_code = $Login["verification_code"];
        $not_verified = !$Login["is_verified"];

        if($not_verified){
                //this should be inside a try catch
            $this->createEmail(to: $request["email"], verification_code: $verification_code);
            return $this->emailSent();
        }
        
        $token = Auth::generateJWTToken($id);
        
        if(!$token){
            
            return $this->JWTError();

        }

        return $this->loginSuccess($token);

    }
    public function verifyEmail(): array
    {
        $request = (array) json_decode(file_get_contents('php://input'), true);

        $this->Login->email = $request['email'];

        $Login = $this->Login->read();

        if($Login["is_verified"]){
            return $this->alreadyVerified();
        }

        if(!($Login['verification_code'] === $request['verification_code'])){
            return $this->verificationFailed();
        }

        if(!$this->Login->emailIsVerified()){
            return $this->verificationFailed();
        }

        $token = Auth::generateJWTToken($Login['id']);

        if(!$token){
            
            return $this->JWTError();

        }
        return $this->verificationSuccess($token);

    }
    public function checkAuth()
    {
        return "hello";
    }


}