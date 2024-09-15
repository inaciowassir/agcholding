<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class RoleModel extends FirebaseModel {
	private $table = "configurations/roles";
	
	public function filterRole($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getRoleByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function roles() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveRole($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeRole($key) {
	    return $this->remove($this->table, $key);
	}
}