<?php

// Déclaration du namespace et importation des dépendances
namespace Digi\Keha\Controller;
use Digi\Keha\Kernel\Views;
use Digi\Keha\Kernel\AbstractController;
use Digi\Keha\Entity\Utilisateur;

// Définition de la classe Inscription qui étend AbstractController
class Inscription extends AbstractController{

    // Méthode pour afficher la page d'inscription
    public function index()
    {
        // Création d'une nouvelle vue
        $view = new Views();
        
        // Définition du fichier HTML pour la vue
        $view->setHtml('inscription.html');
        
        // Rendu de la vue avec des variables
        $view->render([
            'flash' => $this->getFlashMessage(),
            'var' => 'je suis une variable',
        ]);
    }

    // Méthode pour créer un nouvel utilisateur
    public function createUser()
    {
         // Récupération des valeurs des données POST 
         $nom = $_POST['nom'];
         $prenom = $_POST['prenom'];
         $email = $_POST['email'];
         
         // Hachage du mot de passe pour une meilleure sécurité
         $passwordhashed =  password_hash($_POST['password'],PASSWORD_DEFAULT);
         
         // Vérification que tous les champs sont remplis
         $allFieldsAreSet = isset($nom, $prenom, $email, $passwordhashed);
       
         if ($allFieldsAreSet) {
             // Construction du tableau de données
             $datas = ["nom" => $nom, "prenom" => $prenom, "email" => $email,"password" => $passwordhashed];
             
             // Insertion du nouvel utilisateur dans la base de données
             $result = Utilisateur::insert($datas);
             
             if ($result) {
                 // Message de succès si l'enregistrement s'est bien passé
                 $this->setFlashMessage("L'enregistrement est bien ajouté", "success");
                 
                 // Redirection vers la page de connexion
                 $this->updatePage();
             }
         } else {
             // Message d'erreur si les données ne sont pas correctes
             $this->setFlashMessage("L'enregistrement n'est pas bon", 'error');
             
             // Redirection vers la page d'inscription
             $this->index();
         }
    }

    // Méthode pour afficher la page de connexion
    public function updatePage()
    {
            // Création d'une nouvelle vue
            $view = new Views();
            
            // Définition du fichier HTML pour la vue
            $view->setHtml('Connexion.html');
            
            // Rendu de la vue avec une variable
            $view->render([
                'flash' => $this->getFlashMessage(),
            ]);
    }
}
