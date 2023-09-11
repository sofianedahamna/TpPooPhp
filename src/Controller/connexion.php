<?php

namespace Digi\Keha\Controller;

use Digi\Keha\Kernel\Security;
use Digi\Keha\Entity\Utilisateur;
use Digi\Keha\Kernel\Views;
use Digi\Keha\Kernel\AbstractController;


class Connexion extends AbstractController {

    public function index()
    {
        $view = new Views();
        $view->setHtml('Connexion.html');
        if(!$this->connect()) {
            $view->render([
                'flash' => $this->getFlashMessage(),
                'var' => 'je suis une variable',
            ]);
        } else {
            $redirect = new User();
            $redirect->index();
        }
        
    }

    private function Connect(){
        if (isset($_POST['email'])  && isset($_POST['password'])) {
            $user = Utilisateur::getUniqueByAttribute(['email' => $_POST['email']]);
            if (Security::login($user->getPassword(),$_POST['password'],$user->getId())) {
                $this->setFlashMessage('Super, tu es connecté','success');
                return true;
            }
            else $this->setFlashMessage("Erreur identification","error");
        }
        return false;
    }    
}