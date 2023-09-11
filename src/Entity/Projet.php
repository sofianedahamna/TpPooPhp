<?php

namespace Digi\Keha\Entity;
use Digi\Keha\Kernel\Model;


class Projet extends Model {
    private $id;
    private $titre;
    private $description;
    private $administrateur; // Un objet Utilisateur qui est l'administrateur du projet
    private $taches = array(); // Un tableau pour stocker les tâches associées à ce projet
    private  $membres = array(); // Un tableau pour stocker les utilisateurs membres de ce projet


    public function ajouterTache($tache) {
        $this->taches[] = $tache;
    }

	public function ajouterMembre($utilisateur) {
		$this->membres[] = $utilisateur;
	}
	

	/**
	 * @return mixed
	 */
	public function getid() {
		return $this->id;
	}

	/**
	 * @param mixed $id 
	 * @return self
	 */
	public function setid($id): self {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTitre() {
		return $this->titre;
	}

	/**
	 * @param mixed $titre 
	 * @return self
	 */
	public function setTitre($titre): self {
		$this->titre = $titre;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description 
	 * @return self
	 */
	public function setDescription($description): self {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAdministrateur() {
		return $this->administrateur;
	}

	/**
	 * @param mixed $administrateur 
	 * @return self
	 */
	public static function setAdministrateur($administrateur): self {
		self::$administrateur = $administrateur;
		return $administrateur;
	}

	/**
	 * @return mixed
	 */
	public function getMembres() {
		$sql = "SELECT nom, prenom, email
		FROM utilisateur
		INNER JOIN userproject ON utilisateur.id = userproject.id_utlstr 
		INNER JOIN projet ON userproject.id_project = projet.id;";
	
		$result = Model::Execute($sql);
		foreach ($result as $key => $value) {
			$utilisateur = $value;
			$this->ajouterMembre($utilisateur);
		}
		 
		return $this->membres;
	}
	

	public static function getAdmin() {
		$sql = "SELECT nom,prenom,email
		FROM utilisateur
		INNER JOIN projet ON utilisateur.id = projet.id_utlstr";

		$result = Model::ExecForMember($sql);
		foreach ($result as $key => $value) {
			$utilisateur = $value;
			self::setAdministrateur($utilisateur);
		}
		 
		return self::$administrateur;
	}

	/**
	 * @param mixed $membres 
	 * @return self
	 */
	public function setMembres($membres): self {
		$this->membres = $membres;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTaches() {
		return $this->taches;
	}

	/**
	 * @param mixed $taches 
	 * @return self
	 */
	public function setTaches($taches): self {
		$this->taches = $taches;
		return $this;
	}
}