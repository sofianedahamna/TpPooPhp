<?php

namespace Digi\Keha\Entity;
use Digi\Keha\Kernel\Model;

class UserProject  extends Model{
    private $utilisateur;
    private $projet;

    

	/**
	 * @return mixed
	 */
	public function getUtilisateur() {
		return $this->utilisateur;
	}
	
	/**
	 * @param mixed $utilisateur 
	 * @return self
	 */
	public function setUtilisateur($utilisateur): self {
		$this->utilisateur = $utilisateur;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getProjet() {
		return $this->projet;
	}
	
	/**
	 * @param mixed $projet 
	 * @return self
	 */
	public function setProjet($projet): self {
		$this->projet = $projet;
		return $this;
	}
}