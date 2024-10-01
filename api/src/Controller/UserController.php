<?php

namespace App\Controller;

// require_once __DIR__ . '/../model/User.php';

use App\Model\User;
use App\Services\AuthChecker;
use App\Traits\Response;
use App\Traits\Validation;

class UserController{

    use Response;
    use Validation;

    private $User;
    
    public function __construct(private $db) 
    {

        $this->User = new User($db);

    }
    
    public function index()
    {
        AuthChecker::authenticate();

        $UserData = $this->User->selectAll();

        if(!$UserData){
            return $this->notFoundResponse();
        }

        return $this->okResponse($UserData);
    }

    public function show($request)
    {
        AuthChecker::authenticate();

        $this->User->id = $request['id'];

        $UserData = $this->User->select();

        if(!$UserData){
            return $this->notFoundResponse();
        }

        return $this->okResponse($UserData);
    }

    public function create() 
    {
        // $input = (array) json_decode(file_get_contents('php://input'), true);
        // if (!$this->validateUser($input)) {
        //     return $this->unprocessableEntityResponse();
        // }

        // $this->user->username = $input['username'];
        // $this->user->password = $input['password'];

        // if ($this->user->create()) {
        //     return $this->createdResponse();
        // }

        // return $this->unprocessableEntityResponse();
    }

    public function update($request) 
    {

        AuthChecker::authenticate();

        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->User->id = $request['id'];
        $this->User->username = $input['username'];
        $this->User->password = $input['password'];

        if ($this->User->update()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }

    public function delete($request) 
    {

        AuthChecker::authenticate();

        $this->User->id = $request['id'];
        
        if ($this->User->delete()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }
}
