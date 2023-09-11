// Lorsque le document est complètement chargé
$(document).ready(function () {

    $("form").submit(function(e) {
        var isValid = true;
    
        // Vérifier chaque champ input dans ce formulaire particulier
        $(this).find('input, select').each(function() {
            // Si le champ est vide
            if ($(this).val() === "") {
                isValid = false; // Marquer comme non valide
            }
        });
    
        $(this).data('isValid', isValid); // Stocker la validité avec le formulaire
    
        // Si le formulaire n'est pas valide
        if (!isValid) {
            e.preventDefault(); // Empêcher la soumission du formulaire
            alert("Veuillez remplir tous les champs!");
        }
    });
    

    // Gère l'événement de soumission du formulaire de mise à jour du projet
    $("[id^='update']").submit(function (e) {
        if ($(this).data('isValid') !== true) {
            return; // Quitter si le formulaire n'est pas valide
        }
        e.preventDefault();                      
        updateProject(e.target);                
    });

    // Gère l'événement de soumission du formulaire d'ajout d'un utilisateur
    $("#adduser").submit(function (e) {
        if ($(this).data('isValid') !== true) {
            return; // Quitter si le formulaire n'est pas valide
        }
        e.preventDefault();                      // Empêche la soumission par défaut du formulaire
        addUser(e.target);                      // Appelle la fonction d'ajout d'utilisateur
    });

    // Gère l'événement de soumission du formulaire de suppression d'un projet
    $("[id^='delete']").submit(function (e) {
        e.preventDefault();                      // Empêche la soumission par défaut du formulaire
        deleteProject(e.target);                // Appelle la fonction de suppression du projet
    });

    // Gère l'événement de soumission du formulaire de création d'un projet
    $("#CreateProjet").submit(function (e) {
        if ($(this).data('isValid') !== true) {
            return; // Quitter si le formulaire n'est pas valide
        }
        e.preventDefault();                      // Empêche la soumission par défaut du formulaire
        createProjet(e.target);                 // Appelle la fonction de création du projet
    });

    // Gère l'événement de soumission du formulaire de création d'une tâche
    $("#addtask").submit(function (e) {
        if ($(this).data('isValid') !== true) {
            return; // Quitter si le formulaire n'est pas valide
        }
        e.preventDefault();                      // Empêche la soumission par défaut du formulaire
        createTask(e.target);                   // Appelle la fonction de création de tâche
    });

    // Gère l'événement de soumission du formulaire de suppression d'un projet
    $("[id^='updatetask']").submit(function (e) {
        e.preventDefault();                      // Empêche la soumission par défaut du formulaire
        updateTask(e.target);                // Appelle la fonction de MAJ du status de la tache
    });


    // Gère le clic sur le bouton de création de projet
    $("#btn_create_projet").click(function (e) {
        e.preventDefault();
        display_create_projet();                // Appelle la fonction d'affichage du formulaire de création de projet
    });

    // Configuration des options pour les requêtes AJAX
    var ajaxOptions = {
        method: "POST",                         // Méthode HTTP utilisée
        cache: false,                           // Désactive le cache
        async: true,                            // Exécution asynchrone
        timeout: 3000,                          // Temps d'attente maximum de 3 secondes
        dataType: "json",                       // Type de données attendues en réponse
        processData: false,                     // N'effectue pas de traitement sur les données
        contentType: false                      // N'utilise pas de type de contenu par défaut
    };

    // Fonction de mise à jour du projet
    function updateProject(form) {
        var url = $(form).attr("action");       // Récupère l'URL d'action du formulaire
        var formData = new FormData(form);      // Crée les données du formulaire pour la requête AJAX
        ajaxOptions.data = formData;            // Attribue les données du formulaire aux options AJAX
        ajaxOptions.url = url;                  // Attribue l'URL aux options AJAX

        $.ajax(ajaxOptions)                     // Effectue une requête AJAX avec les options spécifiées
            .done(function (clbck) {           // En cas de succès
                if (clbck.err_flag) {          // Si une erreur est retournée
                    alert(clbck.err_msg);      // Affiche le message d'erreur
                } else {                       // Sinon
                    display_panel_flw("Votre projet est maintenant à jour.");  // Affiche un message de confirmation
                }
            })
            .fail(function (e) {               // En cas d'échec
                console.log(e.responseText);   // Affiche l'erreur dans la console
                alert("Error!");               // Affiche une alerte d'erreur
            });
    }
    function addUser(form) {
        var url = $(form).attr("action");   // Récupération de l'URL d'action du formulaire
        var formData = new FormData(form);
        console.log(formData); // Création des données du formulaire pour la requête AJAX
        ajaxOptions.data = formData;       // Assignation des données du formulaire aux options AJAX
        ajaxOptions.url = url;             // Assignation de l'URL aux options AJAX

        $.ajax(ajaxOptions)                // Effectuer une requête AJAX avec les options définies
            .done(function (clbck) {      // Traitement à effectuer si la requête réussit
                if (clbck.err_flag) {     // Si le serveur renvoie une erreur
                    alert(clbck.err_msg); // Afficher le message d'erreur
                } else {                  // Sinon
                    display_panel_flw("Utilisateur Ajouter comme membre de votre projet.");  // Afficher une fenêtre d'information avec le message de réussite
                }
            })
            .fail(function (e) {          // Traitement à effectuer si la requête échoue
                console.log(e.responseText);      // Afficher l'erreur dans la console
                alert("Error!");          // Afficher une alerte d'erreur
            });
    }

    function deleteProject(form) {
        console.log("ligne 90");
        var url = $(form).attr("action");   // Récupération de l'URL d'action du formulaire
        var formData = new FormData(form);  // Création des données du formulaire pour la requête AJAX
        ajaxOptions.data = formData;       // Assignation des données du formulaire aux options AJAX
        ajaxOptions.url = url;             // Assignation de l'URL aux options AJAX

        $.ajax(ajaxOptions)                // Effectuer une requête AJAX avec les options définies
            .done(function (clbck) {      // Traitement à effectuer si la requête réussit
                if (clbck.err_flag) {     // Si le serveur renvoie une erreur
                    alert(clbck.err_msg); // Afficher le message d'erreur
                } else {                  // Sinon
                    display_panel_flw("Votre projet a bien été supprimé.");  // Afficher une fenêtre d'information avec le message de réussite
                }
            })
            .fail(function (e) {          // Traitement à effectuer si la requête échoue
                console.log(e.responseText);      // Afficher l'erreur dans la console
                alert("Error!");          // Afficher une alerte d'erreur
            });
    }

    function createProjet(form) {
        var url = $(form).attr("action");   // Récupération de l'URL d'action du formulaire
        var formData = new FormData(form);  // Création des données du formulaire pour la requête AJAX
        ajaxOptions.data = formData;       // Assignation des données du formulaire aux options AJAX
        ajaxOptions.url = url;             // Assignation de l'URL aux options AJAX

        $.ajax(ajaxOptions)                // Effectuer une requête AJAX avec les options définies
            .done(function (clbck) {      // Traitement à effectuer si la requête réussit
                if (clbck.err_flag) {     // Si le serveur renvoie une erreur
                    alert(clbck.err_msg); // Afficher le message d'erreur
                } else {                  // Sinon
                    display_panel_flw("Nouveau projet ajouté avec succès.");  // Afficher une fenêtre d'information avec le message de réussite
                }
            })
            .fail(function (e) {          // Traitement à effectuer si la requête échoue
                console.log(e.responseText);      // Afficher l'erreur dans la console
                alert("Error!");          // Afficher une alerte d'erreur
            });
    }

    function createTask(form) {
        var url = $(form).attr("action");   // Récupération de l'URL d'action du formulaire
        var formData = new FormData(form);  // Création des données du formulaire pour la requête AJAX
        ajaxOptions.data = formData;       // Assignation des données du formulaire aux options AJAX
        ajaxOptions.url = url;             // Assignation de l'URL aux options AJAX

        $.ajax(ajaxOptions)                // Effectuer une requête AJAX avec les options définies
            .done(function (clbck) {      // Traitement à effectuer si la requête réussit
                if (clbck.err_flag) {     // Si le serveur renvoie une erreur
                    alert(clbck.err_msg); // Afficher le message d'erreur
                } else {                  // Sinon
                    display_panel_flw("Votre Tache a été ajouter.");  // Afficher une fenêtre d'information avec le message de réussite
                }
            })
            .fail(function (e) {          // Traitement à effectuer si la requête échoue
                alert("Error!");          // Afficher une alerte d'erreur
            });
    }


    // Fonction qui affiche une fenêtre d'information avec un message
    function display_panel_flw(message) {
        swal({
            title: "Succès!",
            text: message,
            icon: "success",
            button: "OK",
            closeOnClickOutside: false,       // Empêche la fermeture en cliquant à l'extérieur
            closeOnEsc: false                 // Empêche la fermeture avec la touche 'Échap'
        }).then((value) => {
            if (value) {
                location.reload();             // Recharge la page
            }
        });
    }

    // Gère l'ouverture de la fenêtre modale d'ajout d'utilisateur
    $('#AddUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);    // Récupère le bouton qui a déclenché la modal
        var projectId = button.data('id');      // Récupère l'ID du projet à partir de l'attribut data-id
        var modal = $(this);
        modal.find('input[name="id_project"]').val(projectId);  // Attribue cet ID au champ approprié de la modal
    });

    // Gère l'ouverture de la fenêtre modale d'ajout de tâche
    $('#addTaskModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);    // Récupère le bouton qui a déclenché la modal
        var projectId = button.data('id');      // Récupère l'ID du projet à partir de l'attribut data-id
        var modal = $(this);
        modal.find('input[name="id_project"]').val(projectId);  // Attribue cet ID au champ approprié de la modal
    });

     // Gère l'ouverture de la fenêtre modale modification du status de tâche
     $('#updateTaskModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);    // Récupère le bouton qui a déclenché la modal
        var projectId = button.data('id');      // Récupère l'ID du projet à partir de l'attribut data-id
        var modal = $(this);
        modal.find('input[name="id_tache"]').val(projectId);  // Attribue cet ID au champ approprié de la modal
    });
   
        $('#updateTaskModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Bouton qui déclenché la modal
            var taskId = button.data('task-id'); // Extrait l'info depuis l'attribut data-task-id 
    
            // Mettez à jour le champ caché avec l'ID de la tâche
            $(this).find('input[name="id_tache"]').val(taskId);
            
            // Mettez à jour l'ID du formulaire (si nécessaire)
            $(this).find('form').attr('id', 'updatetask' + taskId);
        });
    
    // Fonction qui affiche ou masque le formulaire de création de projet en fonction de son état actuel
    function display_create_projet() {
        $("#ctn_create_projet").toggle();
    }

});