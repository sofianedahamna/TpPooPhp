<?php

namespace Digi\Keha\Entity;
use Digi\Keha\Kernel\Model;

class Tache extends Model{
    private $id_task;
    private $titre;
    private $description;
    private $cycleVie; // Un objet CycleVie qui représente l'état de la tâche
    private $prioriter; // Un objet Prioriter qui représente la priorité de la tâche
	/**
	 * @return mixed
	 */
	public function getId_task() {
		return $this->id_task;
	}

	/**
	 * @param mixed $id_task 
	 * @return self
	 */
	public function setId_task($id_task): self {
		$this->id_task = $id_task;
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
	public function getCycleVie() {
		return $this->cycleVie;
	}

	/**
	 * @param mixed $cycleVie 
	 * @return self
	 */
	public function setCycleVie($cycleVie): self {
		$this->cycleVie = $cycleVie;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPrioriter() {
		return $this->prioriter;
	}

	/**
	 * @param mixed $prioriter 
	 * @return self
	 */
	public function setPrioriter($prioriter): self {
		$this->prioriter = $prioriter;
		return $this;
	}
}