<?php

// Déclaration du namespace et importation des classes nécessaires
namespace Digi\Keha\Controller;

use Digi\Keha\Kernel\Security;
use Digi\Keha\Entity\Utilisateur;
use Digi\Keha\Kernel\Views;
use Digi\Keha\Kernel\AbstractController;

// Définition de la classe Connexion qui étend AbstractController
class Connexion extends AbstractController {

    // Méthode pour afficher la page de connexion
    public function index()
    {
        // Création d'une nouvelle vue
        $view = new Views();

        // Définition du fichier HTML pour la vue
        $view->setHtml('Connexion.html');

        // Si l'utilisateur n'est pas connecté, il affiche la vue de connexion
        if(!$this->Connect()) {
            $view->render([
                'flash' => $this->getFlashMessage(),
                'var' => 'je suis une variable',
            ]);
        } else {
            // Sinon, redirige vers la page de l'utilisateur
            $redirect = new User();
            $redirect->index();
        }
    }

    // Méthode privée pour gérer la connexion
    private function Connect(){
        // Vérification de l'existence des données de connexion POST
        if (isset($_POST['email']) && isset($_POST['password'])) {

            // Récupération de l'utilisateur à partir de son email
            $user = Utilisateur::getUniqueByAttribute(['email' => $_POST['email']]);

            // Si les informations de connexion sont correctes
            if (Security::login($user->getPassword(), $_POST['password'], $user->getId())) {

                // Définit un message de succès
                $this->setFlashMessage('Super, tu es connecté', 'success');

                // Retourne vrai pour indiquer que la connexion a réussi
                return true;

            } else {
                // Sinon, définit un message d'erreur
                $this->setFlashMessage("Erreur identification", "error");
            }
        }

        // Retourne faux pour indiquer que la connexion a échoué
        return false;
    }    
}
