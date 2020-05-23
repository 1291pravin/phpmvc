<?php

require_once __DIR__ . './../models/User.php';

class UserController extends Controller {

    function register() {
        $user = new User();
        $user->username = $this->input['username'];
        $user->setPassword($this->input['password']);
        $user->email = $this->input['email'];
        $user->contact = $this->input['contact'];
        $user->date_created = date('Y-m-d H:i:s');
        $user->date_modified = date('Y-m-d H:i:s');
        $user->encypt();
        if ($user->validate() && $user->hasError()) {
            $this->_sendResponse($user->getError(), 400);
        }

        $user->save();
        $user->decrypt();
        $user->format();
        $this->_sendResponse($user);
    }

    function login() {
        $username = EncyptDescryptHelper::encypt($this->input['username']);
        $password = EncyptDescryptHelper::encypt($this->input['password']);
        $user = User::findOne(['username' => $username]);
        if ($user) {
            $user->decrypt();

            if ($user->password === $this->input['password']) {
                $user->format();
                $this->_sendResponse($user);
            }
        }
        $this->_sendResponse(['username' => ['Invalid UserName Or Password']], 400);
    }

    function profile($id) {
        $user = User::findOne(['id' => $id]);
        if ($user) {
            $user->decrypt();
            $user->format();
            $this->_sendResponse($user);
        } else {
            $this->_sendResponse(['id' => 'User does not exists'], 404);
        }
    }
    
    public function index() {
        
    }

}

?>