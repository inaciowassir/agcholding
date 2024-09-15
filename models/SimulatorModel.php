<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class SimulatorModel extends FirebaseModel {
	private $table = "configurations/simulator/parameters";
	
	public function filterParameter($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getParameterByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function parameters() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveParameter($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeParameter($key) {
	    return $this->remove($this->table, $key);
	}
}