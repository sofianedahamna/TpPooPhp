<?php

namespace Digi\Keha\Entity;
use Digi\Keha\Kernel\Model;
class CycleVie extends Model{
    private $id_cycle;
    private $status;

   
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