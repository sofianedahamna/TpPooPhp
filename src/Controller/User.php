<?php

namespace Digi\Keha\Controller;
use Digi\Keha\Entity\Utilisateur;
use Digi\Keha\Kernel\AbstractController;
use Digi\Keha\Kernel\Views;
use Digi\Keha\Entity\Projet;
use Digi\Keha\Entity\UserProject;
use Digi\Keha\Entity\Prioriter;
use Digi\Keha\Entity\CycleVie;
use Digi\Keha\Entity\Tache;

class User extends AbstractController {

    /**
     * Affiche la liste des utilisateurs
     */
    public function index()
    {
        
        $view = new Views();
        $user = Utilisateur::getAll();
        $projet = new Projet();
        $projet->getMembres();
        $view->setHtml('User/compte.php');
        $projects = Projet::getAllByAttributes(['id_utlstr' => $_SESSION['id']]); 
        $testProjet = Projet::getAllProject();
        $cycleDeVie = CycleVie::getAll();
        $prioriter = Prioriter::getAll();
        $view->render(
            [
                'flash' => $this->getFlashMessage(),
                'projects' => $projects,
                "projet"=>$projet,
                "user"=>$user,
                "test"=>$testProjet,
                "Cycle"=>$cycleDeVie,
                "Prioriter"=>$prioriter
            ]
            );
    }
    // Méthode pour créer un nouvel enregistrement
    public function createUser()
    {
         // Récupère les valeurs des données POST 
         $nom = $_POST['nom'];
         $prenom = $_POST['prenom'];
         $email = $_POST['email'];
         $password = $_POST['password'];

        $allFieldsAreSet = isset($nom, $prenom, $email, $password);
       

        if ($allFieldsAreSet) {
           
            $datas = ["nom" => $nom, "prenom" => $prenom, "email" => $email,"password" => $password ];
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

    public function updateProject()
    {
        if (isset($_POST["titre"]) && isset($_POST["description"])) {
            $titre = $_POST["titre"];
            $description = $_POST["description"];
            $id= $_GET["id"];
            intval($id);
            $datas = ["titre" => $titre , "description" => $description];
            $project = Projet::update($id , $datas);
            json_encode($project);
            echo json_encode($project);
        }
    }

    // Méthode pour supprimer un enregistrement
    public function delete()
    {
        
        if (isset($_POST['id_project'])) {
            $id = $_POST['id_project'];
            intval($id);
            $result = Projet::delete($id);
            json_encode($result);
            echo json_encode($result);
        } else {
            echo "Erreur lors de la suppresion";
        }

    }
    public function addTask()
    {
        if (isset($_POST["titre"]) && isset($_POST["description"] )  && isset($_POST["id_cycle"]) && isset($_POST["id_prio"]) && isset($_POST["id_utlstr"] )  && isset($_POST["id_project"])) {
           $titre = $_POST["titre"];
           $description = $_POST["description"] ;
           $id_cycle = $_POST["id_cycle"];
           $id_prio = $_POST["id_prio"];
           $id_utlstr = $_POST["id_utlstr"];
           $id_project = $_POST["id_project"];
           $datas = ["titre" => $titre, "description" => $description, "id_cycle" => $id_cycle,"id_prio" => $id_prio,"id_project"=> $id_project,"id_utlstr"=> $id_utlstr];
           $task = Tache::insert($datas);
           json_encode( $task);
           echo json_encode( $task);
        } 
    }

    public function addUserToProject()
    {   
        if (isset($_POST["id_utlstr"]) && isset($_POST["id_project"])) {
           
           $userId =$_POST["id_utlstr"];
           $projectId = $_POST["id_project"];
           $datas =["id_utlstr" => $userId,"id_project" => $projectId];
           $userProject = UserProject::insertIntoAssociateTable($datas);
           
            json_encode($userProject);
            echo json_encode($userProject);
        }
    }

    public function createProjet(){

        if (isset($_POST["titre"]) && isset($_POST["description"]) && isset($_POST["id_utlstr"])) {
            $id = $_POST["id_utlstr"];
            intval($id);
            $titre = $_POST["titre"];
            $description = $_POST["description"];

           $datas = ["titre" => $titre , "description" => $description,"id_utlstr"=>$id];

           $nouveauProjet = Projet::insert($datas);
           json_encode($nouveauProjet);
           echo json_encode($nouveauProjet);
        }
    }

    public function updateTask(){
        
        if (isset($_POST["id_cycle"]) && isset($_POST["id_tache"])) {
            $id_cycle = $_POST["id_cycle"];
            $id = $_POST["id_tache"];
            intval($id);
            $datas = ["id_cycle" => $id_cycle];
            $updateTaskStatus = Tache::update($id , $datas);
            json_encode($updateTaskStatus);
            echo json_encode($updateTaskStatus);
        }
    }
}