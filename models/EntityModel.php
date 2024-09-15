<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class EntityModel extends FirebaseModel {
	private $table = "configurations/entities";
	
	public function filterEntity($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getEntityByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function entities() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveEntity($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeEntity($key) {
	    return $this->remove($this->table, $key);
	}
}