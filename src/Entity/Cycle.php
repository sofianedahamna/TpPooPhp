<?php

namespace Megan\TpGestionProjet\entities;

class CycleVie {
    private $id_cycle;
    private $status;

    public function __construct($id_cycle, $status) {
        $this->id_cycle = $id_cycle;
        $this->status = $status;
    }

	/**
	 * @return mixed
	 */
	public function getId_cycle() {
		return $this->id_cycle;
	}
	
	/**
	 * @param mixed $id_cycle 
	 * @return self
	 */
	public function setId_cycle($id_cycle): self {
		$this->id_cycle = $id_cycle;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * @param mixed $status 
	 * @return self
	 */
	public function setStatus($status): self {
		$this->status = $status;
		return $this;
	}
}