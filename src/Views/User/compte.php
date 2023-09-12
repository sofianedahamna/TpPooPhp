<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des projets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="src\assets\css\compte.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src\assets\js\compte.js"></script>
</head>

<body>
    
    <div class="container">
        <h2>Liste des projets</h2>
        <button class="btn btn-info w-25 my-2" id="btn_create_projet">Creation de projet</button>
          <a href="index.php?controller=user&method=logout" class="btn btn-info w-25 my-2">Me deconnecter</a>
            <?php
                // Initialisation des tableaux pour les projets
                $projetsAdmin = [];
                $projetsMembre = [];

                foreach ($test as $element) {
                    $id = $element["projet_id"];
                   
                    // Vérifie si l'utilisateur est administrateur pour le projet actuel
                    $estAdmin = isset($element["id_utlstr"]) && $_SESSION["id"] == $element["id_utlstr"];
                    $estMembre = !empty($element["utilisateur_id"]) && $_SESSION["id"] == $element["utilisateur_id"];
                    
                    if (!$estAdmin && !$estMembre) {
                        // Si l'utilisateur n'est ni admin ni membre de ce projet, on saute ce projet
                        continue;
                    }
                    

                    // Détermine quel tableau utiliser en fonction du statut d'administrateur
                    if ($estAdmin) {
                        $tableauCible = &$projetsAdmin;
                    } else {
                        $tableauCible = &$projetsMembre;
                    }

                    // Si ce projet n'a pas encore été traité, on l'initialise dans le tableau cible
                    if (!isset($tableauCible[$id])) {
                        $tableauCible[$id] = [
                            'projet_id' => $element["projet_id"],
                            'projet_titre' => $element["projet_titre"],
                            'projet_description' => $element["projet_description"],
                            'members' => [], // Initialisation d'un tableau vide pour les membres
                            'tasks' => []    // Initialisation d'un tableau vide pour les tâches
                        ];
                    }

                    // Si l'élément actuel a un utilisateur associé
                    if ($element["utilisateur_id"] !== null) {
                        $tableauCible[$id]['members'][] = [
                            'nom' => $element["nom"],
                            'prenom' => $element["prenom"],
                            'email' => $element["email"]
                        ];
                    }

                    // Si l'élément actuel a une tâche associée
                    if ($element["tache_id"] !== null) {
                        $tableauCible[$id]['tasks'][] = [
                            'tache_id' => $element["tache_id"],
                            'tache_titre' => $element["tache_titre"],
                            'tache_description' => $element["tache_description"],
                            'tache_id_cycle'=>$element["tache_id_cycle"]
                        ];
                    }
                }

                // Fonction pour afficher les projets
                function afficherProjets($projets, $isAdmin)
                {
                    if (empty($projets)) {
                        echo "<p>Vous n'avez aucun projets.</p>";
                        return;
                    }

                    echo "<table class='table table-bordered table-striped'>"; // Commencez votre tableau HTML ici
    
                    // Ajout du thead
                    echo "<thead class='table-dark'>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Membre</th>
                                <th>Tache</th>
                                <th>Actions</th>
                            </tr>
                          </thead>";
                

                    foreach ($projets as $project) {
                        //var_dump($projets);
                        $displayedMembers = [];
                        $displayedTasks = [];

                        echo "<tr>";

                        // Affichage des informations du projet
                        echo "<td>" . $project["projet_titre"] . "</td>";
                        echo "<td>" . $project["projet_description"] . "</td>";

                        // Membres du projet
                        echo "<td>";
                        foreach ($project["members"] as $member) {
                            $uniqueMemberKey = $member["nom"] . $member["prenom"] . $member["email"];
                            if (isset($displayedMembers[$uniqueMemberKey])) continue;

                            $displayedMembers[$uniqueMemberKey] = true;
                            echo "Nom : " . $member["nom"] . " ";
                            echo "Prenom : " . $member["prenom"] . " ";
                            echo "Email : " . $member["email"] . "<br>";
                        }
                        if (empty($displayedMembers)) {
                            echo "<p>Ce projet ne contient pas de membre</p>";
                        }
                        echo "</td>";

                        // Tâches du projet
                        echo "<td>";

                        
                        
                        foreach ($project["tasks"] as $task) {
                            //var_dump($project);

                            $uniqueTaskKey = $task["tache_titre"] . $task["tache_description"];
                            if (isset($displayedTasks[$uniqueTaskKey])) continue;

                            $displayedTasks[$uniqueTaskKey] = true;
                            echo "Titre de la tâche : " . $task["tache_titre"] . "<br>";
                            echo "Description de la tâche : " . $task["tache_description"] . "<br>";
                            $statusMapping = [
                                1 => 'en cours',
                                2 => 'non débuté',
                                3 => 'terminé'
                            ];
                            
                            if (isset($statusMapping[$task["tache_id_cycle"]])) {
                                echo "status de la tache : " . $statusMapping[$task["tache_id_cycle"]] ."<br>";
                            } else {
                                echo "status de la tache inconnu<br>";
                            }
                        }
                        if (empty($displayedTasks)) {
                            echo "<p>Ce projet n'a pas de tâche associée</p>";
                        }
                        echo "</td>";

                        // Boutons d'actions
                        echo "<td>";
                        if ($isAdmin) {
                            echo "<button type='button' class='btn btn-danger mx-2 my-2' data-bs-toggle='modal' data-bs-target='#deleteModal" . $project["projet_id"] . "'>Supprimer</button>";
                            echo "<button type='button' class='btn btn-info mx-2 my-2' data-bs-toggle='modal' data-bs-target='#updateModal" . $project["projet_id"] . "'>Mettre à jour</button>";
                            echo "<button type='button' class='btn btn-success mx-2 my-2' data-id='" . $project["projet_id"] . "' data-bs-toggle='modal' data-bs-target='#AddUserModal'>Ajouter un user</button>";
                            echo "<button type='button' class='btn btn-success mx-2 my-2' data-bs-toggle='modal' data-id='" . $project["projet_id"] . "' data-bs-target='#addTaskModal'>Ajouter une tache</button>";
                        } else {
                            $processedTasks = [];  // Pour suivre les tâches que nous avons déjà affichées

                            foreach($project["tasks"] as $task) {
                                // Si la tache_id est déjà traitée, continuez avec la prochaine tâche
                                if(isset($processedTasks[$task["tache_id"]])) {
                                    continue;
                                }
                            
                                $buttonId = '#updateTaskModal' . $task["tache_id"];
                               // echo "<button type='button' class='btn btn-info mx-2 my-2' data-bs-toggle='modal' data-task-id='{$buttonId}' data-bs-target='#updateTaskModal'>Mettre à jour</button>";
                                echo "<button type='button' class='btn btn-info mx-2 my-2' data-bs-toggle='modal' data-bs-target='#updateTaskModal' data-task-id='". $task["tache_id"]."'>Mettre à jour</button>";

                                
                                // Marquez cette tache_id comme traitée
                                $processedTasks[$task["tache_id"]] = true;
                            }
                            
                        
                        }
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>"; // Terminez votre tableau HTML ici
                }

                // Affichage
                echo "<h2>Projets dont je suis administrateur</h2>";
                afficherProjets($projetsAdmin, true);

                echo "<h2>Projets dont je suis membre</h2>";
                afficherProjets($projetsMembre, false);
                ?>

          

        <!-- Modals delete-->
        <?php foreach ($projects as $element) : ?>
            <div class="modal fade" id="deleteModal<?php echo $element["id"]; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Supprimer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir supprimer cet élément?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <form id="delete<?php echo $element["id"]; ?>" action='index.php?controller=user&method=delete' method="post">
                                <input type="hidden" name="id_project" value="<?php echo $element["id"]; ?>">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php foreach ($projects as $element) : ?>
            <!-- Modals update for each project-->
            <div class="modal fade" id="updateModal<?php echo $element["id"]; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Mettre a jour le projet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="update<?php echo $element["id"]; ?>" action='index.php?controller=user&method=updateProject&id=<?php echo $element["id"]; ?>' method="post">
                                <label for="titre">Titre</label>
                                <input type="text" name="titre" id="titre" class="form-control" value="<?php  $element["titre"]; ?>" required>
                                <label for="description">Description</label>
                                <input type="text" name="description" id="description" class="form-control" value="<?php echo $element["description"]; ?>" required>
                                <button type="submit" class="btn btn-success my-2" data-bs-dismiss="modal">mettre a jour</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- Modals add user -->
        <div class="modal fade" id="AddUserModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php ?>
                        <form id="adduser" action='index.php?controller=user&method=addUserToProject' method="post">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" name="id_utlstr" aria-label="Floating label select example">
                                    <option value="" selected>Choisir un utilisateur</option>
                                    <?php foreach ($user as $element) : ?>
                                        <?php
                                        // Si l'id de l'élément en cours correspond à l'id de l'utilisateur connecté, on continue à la prochaine itération
                                        if ($element->getId() == $_SESSION["id"]) {
                                            continue;
                                        }
                                        ?>
                                        <option value="<?php echo $element->getId(); ?>"><?php echo $element->getNom(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="floatingSelect">Choisir un utilisateur</label>
                                <button type="submit" class="btn btn-success my-2">Ajouter l'utilisateur</button>
                            </div>
                            <!-- champ caché pour l'ID du projet recuperer avec jquery pour le placer dynamiquement dans value-->
                            <input type="hidden" name="id_project" value="">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals addTaskModal-->
        <div class="modal fade" id="addTaskModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une tache au projet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?controller=user&method=addTask" method="post" id="addtask">
                            <label for="titre">Titre</label>
                            <input type="text" name="titre" id="" class="form-control" required>
                            <label for="description">Description</label>
                            <input type="text" name="description" id="" class="form-control" required>
                            <div class="form-floating">
                                <select name="id_cycle" class="form-select my-2" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Selectionner le cycle</option>
                                    <?php foreach ($Cycle as $element) : ?>
                                        <option value="<?php echo $element->getId_cycle(); ?>"><?php echo $element->getStatus(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="floatingSelect">Faite votre choix</label>
                            </div>
                            <div class="form-floating">
                                <select name="id_prio" class="form-select my-2" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Selectionner la prioriter de la tache</option>
                                    <?php foreach ($Prioriter as $element) : ?>
                                        <option value="<?php echo $element->getId_prio(); ?>"><?php echo $element->getPrioriter(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="floatingSelect">Faite votre choix</label>
                            </div>
                            <div class="form-floating">
                                <select name="id_utlstr" class="form-select my-2" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Selectionner l'utilisateur associer a cette tache</option>
                                    <?php foreach ($user as $element) : ?>
                                        <?php
                                        if ($element->getId() === $_SESSION["id"]) {
                                            continue;
                                        }
                                        ?>
                                        <option value="<?php echo $element->getId(); ?>"><?php echo $element->getNom(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="floatingSelect">Faite votre choix</label>
                            </div>
                            <input type="hidden" name="id_project" value="">
                            <button type="submit" class="btn btn-success my-2">Ajouter une tache</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals updateTaskModal-->
        <div class="modal fade" id="updateTaskModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une tache au projet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?controller=user&method=updateTask" method="post" id="updatetask">
                            <div class="form-floating">
                                <select name="id_cycle" class="form-select my-2" id="floatingSelect" aria-label="Floating label select example">
                                    <option selected>Selectionner le cycle</option>
                                    <?php foreach ($Cycle as $element) : ?>
                                        <option value="<?php echo $element->getId_cycle(); ?>"><?php echo $element->getStatus(); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="floatingSelect">Faite votre choix</label>
                            </div>
                            <input type="hidden" name="id_tache" value="">
                            <button type="submit" class="btn btn-success my-2">Ajouter une tache</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form New projet-->
        <div id="ctn_create_projet">
            <form action='index.php?controller=user&method=createProjet' method="post" id="CreateProjet">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control" required>

                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" required>

                <input type="hidden" name="id_utlstr" value='<?php echo $_SESSION['id']; ?>'>
                <button type="submit" class="btn btn-success my-2">Creer</button>
            </form>
        </div>
    </div>
</body>
</html>