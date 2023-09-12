Requete sql de jointure de la fonction 

$sql1 ="
    SELECT 
        projet.id AS projet_id,              -- Sélectionne l'ID du projet et le renomme comme "projet_id" pour éviter les conflits
        projet.titre AS projet_titre,        -- Sélectionne le titre du projet et le renomme "projet_titre"
        projet.description AS projet_description,  -- Pareil pour la description du projet
        utilisateur.id AS utilisateur_id,    -- Sélectionne l'ID de l'utilisateur et le renomme "utilisateur_id"
        projet.id_utlstr,                    -- Sélectionne l'ID de l'utilisateur qui est le gestionnaire/administrateur du projet
        utilisateur.nom,                     -- Sélectionne le nom de l'utilisateur
        utilisateur.prenom,                  -- Sélectionne le prénom de l'utilisateur
        utilisateur.email,                   -- Sélectionne l'email de l'utilisateur
        tache.id AS tache_id,                -- Sélectionne l'ID de la tâche et le renomme "tache_id"
        tache.titre AS tache_titre,          -- Sélectionne le titre de la tâche et le renomme "tache_titre"
        tache.description AS tache_description,  -- Pareil pour la description de la tâche
        tache.id_cycle AS tache_id_cycle,        -- Sélectionne l'ID du cycle de la tâche
        tache.id_prio AS tache_id_prio,          -- Sélectionne l'ID de la priorité de la tâche
        tache.id_utlstr AS tache_id_utlstr      -- Sélectionne l'ID de l'utilisateur assigné à la tâche
    FROM projet                               -- La table principale d'où proviennent les informations est "projet"
    LEFT JOIN userproject ON projet.id = userproject.id_project  -- Relie la table "projet" à la table "userproject" par leur ID respectif
    LEFT JOIN utilisateur ON userproject.id_utlstr = utilisateur.id  -- Relie la table "userproject" à la table "utilisateur" par l'ID utilisateur
    LEFT JOIN tache ON projet.id = tache.id_project   -- Relie la table "projet" à la table "tache" par l'ID du projet
    ORDER BY projet.id, utilisateur.id, tache.id   -- Trie les résultats par ID de projet, puis par ID d'utilisateur, puis par ID de tâche
    ";
