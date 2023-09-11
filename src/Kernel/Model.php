<?php

// Définit le namespace de la classe Model.
namespace Digi\Keha\Kernel;

// Déclaration de la classe Model.
class Model
{

    // Méthode privée qui obtient le nom de l'entité (probablement le nom de la table) à partir du nom complet de la classe.
    private static function getEntityName()
    {
        // Récupère le nom complet de la classe.
        $classname = static::class;

        // Divise le nom complet de la classe à chaque '\'.
        $tab = explode('\\', $classname);

        // Récupère le dernier élément du tableau (qui devrait être le nom de la classe lui-même).
        $entity = $tab[count($tab) - 1];

        // Renvoie le nom de la classe.
        return $entity;
    }

    // Méthode privée qui renvoie le nom complet de la classe.
    private static function getClassName()
    {
        return static::class;
    }

    // Méthode privée qui exécute une requête SQL et renvoie les résultats sous forme d'instances de la classe actuelle.
    protected static function Execute($sql)
    {
        // Exécute la requête SQL.
        $pdostatement = Db::getInstance()->query($sql);

        // Renvoie le résultat de la requête sous forme d'instances de la classe actuelle.
        return $pdostatement->fetchAll(\PDO::FETCH_CLASS, self::getClassName());
    }
    protected static function ExecForMember($sql)
    {
        // Exécute la requête SQL.
        $pdostatement = Db::getInstance()->query($sql);

        // Renvoie le résultat de la requête sous forme d'instances de la classe actuelle.
        return $pdostatement->fetchAll(\PDO::FETCH_DEFAULT);
    }

    // Récupère tous les enregistrements de la table actuelle.
    public static function getAll()
    {
        // Construit la requête SQL.
        $sql = "select * from " . self::getEntityName();

        // Exécute la requête et renvoie les résultats.
        return self::Execute($sql);
    }

    // Récupère un enregistrement par son ID.
    public static function getById(int $id)
    {
        // Construit la requête SQL.
        $sql = "select * from " . self::getEntityName() . " where id=$id";

        // Exécute la requête et renvoie le premier résultat.
        $result = self::Execute($sql);
        return $result[0];
    }

    // Récupère des enregistrements basés sur des attributs donnés (clé-valeur).
    private static function getByAttribute(array $attributes)
    {

        // Débute la construction de la requête SQL.
        $sql = "select * from " . self::getEntityName() . " where ";

        $i = 0;

        // Ajoute chaque attribut à la requête SQL.
        foreach ($attributes as $key => $value) {
            if ($i !== 0) {
                $sql .= " AND"; // Ajoute 'AND' si ce n'est pas le premier attribut.
            }
            $sql .= " $key='" . $value . "'";
            $i++;
        }

        // Renvoie la requête SQL complète.
        return $sql;
    }

    // Récupère un enregistrement unique basé sur des attributs donnés.
    public static function getUniqueByAttribute(array $attributes)
    {
        // Construit la requête SQL en utilisant la méthode précédente.
        $sql = self::getByAttribute($attributes);

        // Exécute la requête et renvoie le premier résultat.
        $result = self::Execute($sql);
        return $result[0];
    }

    // Récupère tous les enregistrements basés sur des attributs donnés.
    public static function getAllByAttributes(array $attributes)
    {
        // Construit la requête SQL.
        $sql = self::getByAttribute($attributes);
        // Exécute la requête et renvoie tous les résultats.
        $result = self::Execute($sql);
        return $result;
    }

    public static function getAllProject(){
        $sql1 =" SELECT 
        projet.id AS projet_id,
        projet.titre AS projet_titre,
        projet.description AS projet_description,
        utilisateur.id AS utilisateur_id,
        utilisateur.nom,
        utilisateur.prenom,
        utilisateur.email
    FROM projet
    LEFT JOIN userproject ON projet.id = userproject.id_project
    LEFT JOIN utilisateur ON userproject.id_utlstr = utilisateur.id
    ORDER BY projet.id, utilisateur.id ";

    $result = self::ExecForMember($sql1);
    return $result;
    }

    // Vérifie le mot de passe pour un email donné.
    public static function VerifyPass(string $email)
    {
        // Construit la requête SQL.
        $sql = "select * from " . self::getEntityName() . " where email = '$email'";

        // Exécute la requête et renvoie le premier résultat.
        $result = self::Execute($sql);
        return $result[0];
    }

    // Insère un nouvel enregistrement.
    /**
     * Insère des données dans la table de l'entité actuelle.
     *
     * @param array $datas Les données à insérer dans la table.
     * @return int Retourne le nombre de lignes insérées.
     */
    public static function insert(array $datas)
    {
        // Débute la construction de la requête SQL. 
        // Le nom de l'entité (table) est récupéré via la fonction getEntityName().
        // On présume ici que la première colonne est une clé primaire auto-incrémentée, d'où la valeur NULL.
        $sql = "insert into " . self::getEntityName() . " values (NULL,";
       

        $count = count($datas); // Compte le nombre de données à insérer.
        $i = 1; // Initialise le compteur pour suivre le nombre de données déjà ajoutées à la requête.

        // Boucle à travers chaque donnée à insérer.
        foreach ($datas as $data) {
            // Si la donnée actuelle n'est pas la dernière, ajoute une virgule après.
            if ($i < $count) {
                $sql .= "'$data',";
            } else {
                // Si c'est la dernière donnée, n'ajoute pas de virgule après.
                $sql .= "'$data'";
            }
            $i++; // Incrémente le compteur.       
        }

        // Termine la construction de la requête SQL.
        $sql .= ")";
        var_dump($sql);
        // Exécute la requête en utilisant l'instance de la base de données 
        // et renvoie le nombre de lignes insérées.
        return Db::getInstance()->exec($sql);
    }

    /**
     * Insère des données dans la table de l'entité actuelle.
     *
     * @param array $datas Les données à insérer dans la table.
     * @return int Retourne le nombre de lignes insérées.
     */
    public static function insertIntoAssociateTable(array $datas)
    {
        // Débute la construction de la requête SQL. 
        // Le nom de l'entité (table) est récupéré via la fonction getEntityName().
        // On présume ici que la première colonne est une clé primaire auto-incrémentée, d'où la valeur NULL.
        $sql = "insert into " . self::getEntityName() . " values (";
        //var_dump($sql); // Affiche la partie initiale de la requête SQL pour des raisons de débogage.

        $count = count($datas); // Compte le nombre de données à insérer.
        $i = 1; // Initialise le compteur pour suivre le nombre de données déjà ajoutées à la requête.

        // Boucle à travers chaque donnée à insérer.
        foreach ($datas as $data) {
            // Si la donnée actuelle n'est pas la dernière, ajoute une virgule après.
            if ($i < $count) {
                $sql .= "'$data',";
            } else {
                // Si c'est la dernière donnée, n'ajoute pas de virgule après.
                $sql .= "'$data'";
            }
            $i++; // Incrémente le compteur.       
        }

        // Termine la construction de la requête SQL.
        $sql .= ")";

        // Exécute la requête en utilisant l'instance de la base de données 
        // et renvoie le nombre de lignes insérées.
        return Db::getInstance()->exec($sql);
    }



    // Supprime un enregistrement par son ID.
    public static function delete(int $id)
    {
        // Construit la requête SQL.
        $sql = "delete from " . self::getEntityName() . " where id=$id";

        // Exécute la requête et renvoie le résultat.
        return Db::getInstance()->exec($sql);
    }

    // Met à jour un enregistrement par son ID avec de nouvelles données.
    public static function update(int $id, array $datas)
    {
        // Débute la construction de la requête SQL.
        $sql = "update " . self::getEntityName() . " set ";
        $count = count($datas);
        $i = 1;

        // Ajoute chaque paire clé-valeur à la requête SQL.
        foreach ($datas as $key => $value) {
            if ($i < $count) {
                $sql .= "$key='$value',";
            } else {
                $sql .= "$key='$value'";
            }
            $i++;
        }

        // Ajoute la clause WHERE pour spécifier l'ID.
        $sql .= " where id=$id";

        // Exécute la requête et renvoie le résultat.
        return Db::getInstance()->exec($sql);
    }
}
