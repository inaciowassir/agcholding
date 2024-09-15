<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class EntityEmployerModel extends FirebaseModel {
	private $table = "configurations/employers_branches";
	
	public function filterEmployerEntity($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getEmployerEntityByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function employersEntity() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveEmployerEntity($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeEmployerEntity($key) {
	    return $this->remove($this->table, $key);
	}
}