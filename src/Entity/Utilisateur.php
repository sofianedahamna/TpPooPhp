<?php
namespace Digi\Keha\Entity;
use Digi\Keha\Kernel\Model;

/**
 * Classe représentant un utilisateur du système de gestion de projet.
 */
class Utilisateur extends Model{

    // Attributs privés pour stocker les détails de l'utilisateur et ses projets.
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $password;  
    private $projets = array();

    /**
     * Ajoute un projet à la liste des projets de l'utilisateur.
     *
     * @param mixed $projet - Projet à ajouter.
     */
    public function ajouterProjet($projet) {
        $this->projets[] = $projet;
    }

    // ... Des getters et setters pour récupérer et définir les propriétés de l'utilisateur ...

    /**
     * Vérifie si le mot de passe fourni correspond au hash stocké.
     *
     * @param string $password - Mot de passe en clair à vérifier.
     * @return bool - True si le mot de passe est correct, sinon false.
     */
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password);
    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     *
     * @param string $password - Nouveau mot de passe en clair.
     * @return self
     */
    public function setPassword(string $password): self {
        $this->password = password_hash($password,  PASSWORD_BCRYPT);
        return $this;
    }
   /**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}
    
    public function getProjets() {
        return $this->projets;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;
        return $this;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
