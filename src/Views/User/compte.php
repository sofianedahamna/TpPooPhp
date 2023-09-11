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
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Membre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 1. Transformer le tableau pour regrouper par projet_id

                // Initialisation d'un tableau pour regrouper les projets par leur ID.
                $groupedProjects = [];

                // Parcourir le tableau $test pour chaque élément
                foreach ($test as $element) {
                    // Récupération de l'ID du projet courant
                    $id = $element["projet_id"];

                    // Si ce projet n'a pas encore été traité, on l'initialise dans $groupedProjects
                    if (!isset($groupedProjects[$id])) {
                        $groupedProjects[$id] = [
                            'projet_id' => $element["projet_id"],
                            'projet_titre' => $element["projet_titre"],
                            'projet_description' => $element["projet_description"],
                            'members' => [] // Initialisation d'un tableau vide pour les membres du projet
                        ];
                    }

                    // Si l'élément courant a un utilisateur (membre) associé, on l'ajoute au tableau des membres du projet correspondant
                    if ($element["utilisateur_id"] !== null) {
                        $groupedProjects[$id]['members'][] = [
                            'nom' => $element["nom"],
                            'prenom' => $element["prenom"],
                            'email' => $element["email"]
                        ];
                    }
                }

                // 2. Affichez chaque projet et ses membres

                // Parcourir le tableau $groupedProjects pour afficher chaque projet et ses membres
                foreach ($groupedProjects as $project) {
                    // Début d'une nouvelle ligne pour le projet courant
                    echo "<tr>";

                    // Affichage des informations du projet
                   
                    echo "<td>" . $project["projet_titre"] . "</td>";
                    echo "<td>" . $project["projet_description"] . "</td>";

                    echo "<td>";
                    // Vérification si le projet a des membres associés
                    if (count($project["members"]) > 0) {
                        // Parcourir et afficher chaque membre du projet
                        foreach ($project["members"] as $member) {
                            echo "Nom : ".$member["nom"] . " ";
                            echo  "Prenom : ".$member["prenom"] . " ";
                            echo "Email : ".$member["email"] . "<br>"; // Nouvelle ligne après chaque membre
                        }
                    } else {
                        // Affichage d'un message si le projet n'a pas de membres associés
                        echo "<p>Ce projet ne contient pas de membre</p>";
                    }
                    echo "</td>";

                    // Affichage des boutons d'actions pour le projet courant
                    echo "<td>";
                    echo "<button type='button' class='btn btn-danger mx-2 my-2' data-bs-toggle='modal' data-bs-target='#deleteModal" . $project["projet_id"] . "'>Supprimer</button>";
                    echo "<button  type='button' class='btn btn-info mx-2 my-2' data-bs-toggle='modal'  data-bs-target='#updateModal" . $project["projet_id"] . "'>Mettre à jour</button>";
                    echo "<button type='button' class='btn btn-success mx-2 my-2' data-id='" . $project["projet_id"] . "' data-bs-toggle='modal' data-bs-target='#AddUserModal'>Ajouter un user</button>";
                    echo "<button type='button' class='btn btn-success mx-2 my-2' data-bs-toggle='modal' data-bs-target='#addTaskModal'>Ajouter une tache</button>";
                    echo "</td>";

                    // Fin de la ligne pour le projet courant
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Modals delete-->
    <?php foreach ($projects as $element) : ?>
    <div class="modal fade" id="deleteModal<?php echo $element->getid(); ?>" tabindex="-1">
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
                    <form id="delete" action='index.php?controller=user&method=delete' method="post">
                        <input type="hidden" name="id_project" value="<?php echo $element->getid(); ?>">
                        <button type="submit" class="btn btn-danger" >Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php foreach ($projects as $element) : ?>
        <!-- Modals update for each project-->
        <div class="modal fade" id="updateModal<?php echo $element->getid(); ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mettre a jour le projet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="update<?php echo $element->getid(); ?>" action='index.php?controller=user&method=updateProject&id=<?php echo $element->getid(); ?>' method="post">
                            <label for="titre">Titre</label>
                            <input type="text" name="titre" id="titre" class="form-control" value="<?php echo $element->getTitre(); ?>">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" value="<?php echo $element->getDescription(); ?>">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">mettre a jour</button>
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
                            <button type="submit" class="btn btn-success">Ajouter l'utilisateur</button>
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
                    <form action="" method="post">
                        <label for="">Titre</label>
                        <input type="text" name="" id="" class="form-control">
                        <label for="">Description</label>
                        <input type="text" name="" id="" class="form-control">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <label for="floatingSelect">Works with selects</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <label for="floatingSelect">Works with selects</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href='index.php?controller=user&method=addTask' class="btn btn-success">Ajouter une tache</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Form New projet-->
    <div id="ctn_create_projet">
        <form action='index.php?controller=user&method=createProjet' method="post" id="CreateProjet" class="">
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>

            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control" required>

            <input type="hidden" name="id_utlstr" value='<?php echo $_SESSION['id']; ?>'>
            <button type="submit">Creer</button>
        </form>
    </div>
</body>

</html>