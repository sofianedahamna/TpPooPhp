<?php

namespace Megan\TpGestionProjet\entities;

class Prioriter {
    private $id_prio;
    private $prioriter;

    public function __construct($id_prio, $prioriter) {
        $this->id_prio = $id_prio;
        $this->prioriter = $prioriter;
    }

	/**
	 * @return mixed
	 */
	public function getId_prio() {
		return $this->id_prio;
	}
	
	/**
	 * @param mixed $id_prio 
	 * @return self
	 */
	public function setId_prio($id_prio): self {
		$this->id_prio = $id_prio;
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