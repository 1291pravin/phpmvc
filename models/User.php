<?php

require_once __DIR__ . './../helpers/EncyptDescryptHelper.php';

class User extends Model {

    public static $table = "user";
    public $username;
    public $password;
    public $email;
    public $contact;
    public $date_created;
    public $date_modified;

    public function rules() {
        return [
            'required' => [['username', 'password', 'email', 'contact']],
            'min' => [['username', 'password'], 5],
            'mobile' => [['contact']],
            'email' => [['email']],
            'unique' => [['username', 'email']]
        ];
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function encypt() {
        $this->username = EncyptDescryptHelper::encypt($this->username);
        $this->password = EncyptDescryptHelper::encypt($this->password);
        $this->email = EncyptDescryptHelper::encypt($this->email);
        $this->contact = EncyptDescryptHelper::encypt($this->contact);
    }

    public function decrypt() {
        $this->username = EncyptDescryptHelper::decrypt($this->username);
        $this->password = EncyptDescryptHelper::decrypt($this->password);
        $this->email = EncyptDescryptHelper::decrypt($this->email);
        $this->contact = EncyptDescryptHelper::decrypt($this->contact);
    }
    
    public function format() {
        unset($this->date_created);
        unset($this->date_modified);
        unset($this->password);
        
        
    }

}

?>