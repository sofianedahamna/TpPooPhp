<?php

namespace Digi\Keha\Controller;
use Digi\Keha\Kernel\Views;
use Digi\Keha\Kernel\AbstractController;
use Digi\Keha\Entity\Utilisateur;
class Inscription extends AbstractController{

    public function index()
    {
        $view = new Views();
        $view->setHtml('inscription.html');
        $view->render([
            'flash' => $this->getFlashMessage(),
            'var' => 'je suis une variable',
        ]);
    }

     // Méthode pour créer un nouvel enregistrement
     public function createUser()
     {
          // Récupère les valeurs des données POST 
          $nom = $_POST['nom'];
          $prenom = $_POST['prenom'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $passwordhashed =  password_hash($password,PASSWORD_DEFAULT);
          $allFieldsAreSet = isset($nom, $prenom, $email, $password);
        
 
         if ($allFieldsAreSet) {
            
             $datas = ["nom" => $nom, "prenom" => $prenom, "email" => $email,"password" => $passwordhashed];
             $result = Utilisateur::insert($datas);
             if ($result) {
                 $this->setFlashMessage("L'enregistrement est bien ajouté", "success");
                 $this->updatePage();
             }
         } else {
             $this->setFlashMessage("L'enregistrement n'est pas bon", 'error');
             $this->index();
         }
     }
     public function updatePage()
    {
            $view = new Views();
            $view->setHtml('Connexion.html');
            $view->render([
                'flash' => $this->getFlashMessage(),
            ]);
        
    }
}