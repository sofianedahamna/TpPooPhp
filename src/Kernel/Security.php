<?php

namespace Digi\Keha\Kernel;

class Security {

    static public function login($hashpassword,$password,$id)
    {
        $result = password_verify($password,$hashpassword);
        if ($result) {
             self::setSession($id);
            return true;
        }
        return false;
    }

    static public function setSession($id)
    {
       session_start();
        $_SESSION['id'] = $id;
    }

    static function logout(){
        session_destroy();
    } 
}