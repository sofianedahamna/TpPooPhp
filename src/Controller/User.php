<?php

namespace Digi\Keha\Controller;

// Importation des classes nécessaires
use Digi\Keha\Entity\Utilisateur;
use Digi\Keha\Kernel\AbstractController;
use Digi\Keha\Kernel\Views;
use Digi\Keha\Entity\Projet;
use Digi\Keha\Entity\UserProject;
use Digi\Keha\Entity\Prioriter;
use Digi\Keha\Entity\CycleVie;
use Digi\Keha\Entity\Tache;
use Digi\Keha\Kernel\Security;

/**
 * Contrôleur pour la gestion des utilisateurs
 */
class User extends AbstractController {

    /**
     * Affiche la liste des utilisateurs et des informations associées.
     */
    public function index()
    {
        // Initialisation des objets nécessaires
        $view = new Views();
        $user = Utilisateur::getAll();
        $projet = new Projet();
        $projet->getMembres();

        // Configuration de la vue
        $view->setHtml('User/compte.php');

        // Récupération des données
        $projects = Projet::getAllByAttributes(['id_utlstr' => $_SESSION['id']]);
        $testProjet = Projet::getAllProject();
        $cycleDeVie = CycleVie::getAll();
        $prioriter = Prioriter::getAll();

        // Affichage de la vue avec les données récupérées
        $view->render(
            [
                'flash' => $this->getFlashMessage(),
                'projects' => $projects,
                "projet" => $projet,
                "user" => $user,
                "test" => $testProjet,
                "Cycle" => $cycleDeVie,
                "Prioriter" => $prioriter
            ]
        );
    }

    /**
     * Crée un nouvel utilisateur avec les données POST fournies.
     */
    public function createUser()
    {
        // Récupération des données POST
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $allFieldsAreSet = isset($nom, $prenom, $email, $password);

        // Si toutes les données sont définies, insère le nouvel utilisateur
        if ($allFieldsAreSet) {
            $datas = ["nom" => $nom, "prenom" => $prenom, "email" => $email, "password" => $password];
            $result = Utilisateur::insert($datas);
            if ($result) {
                $this->setFlashMessage("L'enregistrement est bien ajouté", "success");
                $this->index();
            }
        } else {
            $this->setFlashMessage("L'enregistrement n'est pas bon", 'error');
            $this->index();
        }
    }

    /**
     * Met à jour un projet avec les données POST fournies.
     */
    public function updateProject()
    {
        if (isset($_POST["titre"]) && isset($_POST["description"])) {
            $titre = $_POST["titre"];
            $description = $_POST["description"];
            $id = $_GET["id"];
            intval($id);
            $datas = ["titre" => $titre, "description" => $description];
            $project = Projet::update($id, $datas);
            echo json_encode($project);
        }
    }

    /**
     * Supprime un projet basé sur l'ID fourni en POST.
     */
    public function delete()
    {
        if (isset($_POST['id_project'])) {
            $id = $_POST['id_project'];
            intval($id);
            $result = Projet::delete($id);
            echo json_encode($result);
        } else {
            echo "Erreur lors de la suppresion";
        }
    }

    /**
     * Ajoute une tâche avec les données POST fournies.
     */
    public function addTask()
    {
        if (isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["id_cycle"]) && isset($_POST["id_prio"]) && isset($_POST["id_utlstr"]) && isset($_POST["id_project"])) {
            $datas = [
                "titre" => $_POST["titre"],
                "description" => $_POST["description"],
                "id_cycle" => $_POST["id_cycle"],
                "id_prio" => $_POST["id_prio"],
                "id_project" => $_POST["id_project"],
                "id_utlstr" => $_POST["id_utlstr"]
            ];
            $task = Tache::insert($datas);
            echo json_encode($task);
        }
    }

    /**
     * Ajoute un utilisateur à un projet avec les données POST fournies.
     */
    public function addUserToProject()
    {
        if (isset($_POST["id_utlstr"]) && isset($_POST["id_project"])) {
            $datas = ["id_utlstr" => $_POST["id_utlstr"], "id_project" => $_POST["id_project"]];
            $userProject = UserProject::insertIntoAssociateTable($datas);
            echo json_encode($userProject);
        }
    }

    /**
     * Crée un nouveau projet avec les données POST fournies.
     */
    public function createProjet()
    {
        if (isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["id_utlstr"])) {
            $datas = [
                "titre" => $_POST["titre"],
                "description" => $_POST["description"],
                "id_utlstr" => $_POST["id_utlstr"]
            ];
            $nouveauProjet = Projet::insert($datas);
            echo json_encode($nouveauProjet);
        }
    }

    /**
     * Met à jour une tâche avec les données POST fournies.
     */
    public function updateTask()
    {
        if (isset($_POST["id_cycle"]) && isset($_POST["id_tache"])) {
            $datas = ["id_cycle" => $_POST["id_cycle"]];
            $updateTaskStatus = Tache::update($_POST["id_tache"], $datas);
            echo json_encode($updateTaskStatus);
        }
    }

    /**
     * Déconnecte l'utilisateur et redirige vers l'accueil.
     */
    public function Logout()
    {
        session_start();
        Security::logout();
        $accueil = new Index();
        $accueil->index();
    }
}
