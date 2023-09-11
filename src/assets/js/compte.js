$(document).ready(function () { // Lorsque le document est complètement chargé


    // Événement de soumission du formulaire de mise a jour du projet
        $("[id^='update']").submit(function (e) {
            e.preventDefault();                      // Empêcher la soumission par défaut du formulaire
            updateProject(e.target);                // Appeler la fonction update du projet
        });

        // Événement de soumission du formulaire d'ajout d'un user  
        $("#adduser").submit(function (e) {
            e.preventDefault();                      // Empêcher la soumission par défaut du formulaire
            addUser(e.target);                // Appeler la fonction adduser du projet
        });

        // Événement de soumission du formulaire de suppresion d'un projet
        $("#delete").submit(function (e) {
            e.preventDefault();                      // Empêcher le rechargement de la page 
            deleteProject(e.target);                // Appeler la fonction delete du projet
        });

        // Événement de soumission du formulaire de creation de projet
        $("#CreateProjet").submit(function (e) {
            e.preventDefault();                      // Empêcher la soumission par défaut du formulaire
            createProjet(e.target);                // Appeler la fonction creation du projet
        });


        $("#btn_create_projet").click(function(e) {
            e.preventDefault();
            display_create_projet();
        });

        

          // Configuration des options pour les requêtes AJAX
          var ajaxOptions = {
            method: "POST",          // Méthode HTTP utilisée
            cache: false,            // Désactiver le cache
            async: true,             // Exécution asynchrone
            timeout: 3000,           // Temps d'attente maximum de 3 secondes
            dataType: "json",        // Type de données attendues en réponse
            processData: false,      // Ne pas traiter les données
            contentType: false       // Ne pas définir de type de contenu par défaut
        };

        function updateProject(form) {
            var url = $(form).attr("action");   // Récupération de l'URL d'action du formulaire
            var formData = new FormData(form);  // Création des données du formulaire pour la requête AJAX
            ajaxOptions.data = formData;       // Assignation des données du formulaire aux options AJAX
            ajaxOptions.url = url;             // Assignation de l'URL aux options AJAX
        
            $.ajax(ajaxOptions)                // Effectuer une requête AJAX avec les options définies
                .done(function (clbck) {      // Traitement à effectuer si la requête réussit
                    if (clbck.err_flag) {     // Si le serveur renvoie une erreur
                        alert(clbck.err_msg); // Afficher le message d'erreur
                    } else {                  // Sinon
                        display_panel_flw("Votre projet est maintenant à jour.");  // Afficher une fenêtre d'information avec le message de réussite
                    }
                })
                .fail(function (e) {          // Traitement à effectuer si la requête échoue
                    console.log(e.responseText);      // Afficher l'erreur dans la console
                    alert("Error!");          // Afficher une alerte d'erreur
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



        function display_panel_flw(message){
            swal({
                title: "Succès!",
                text: message,
                icon: "success",
                button: "OK"
            }).then((value) => {   // Quand l'utilisateur clique sur le bouton
                if (value) {
                    location.reload();  // Rafraîchir la page
                }
            });
        }
        

        $('#AddUserModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché la modal
            var projectId = button.data('id'); // Récupère l'ID du projet à partir de l'attribut data-id
            console.log(projectId);
            var modal = $(this);
            console.log(modal);
            modal.find('input[name="id_project"]').val(projectId);
        });

        
       
    
        function display_create_projet() {
            $("#ctn_create_projet").css("display", "block");
        }
     })
        