<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class BranchModel extends FirebaseModel {
	private $table = "configurations/branches";
	
	public function filterBranch($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getBranchByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function branches() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveBranch($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeBranch($key) {
	    return $this->remove($this->table, $key);
	}
}