<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class DocumentKYCModel extends FirebaseModel {
	private $table = "configurations/documents/kyc";
	
	public function filterKYC($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getKYCByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function documents() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveKYC($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeKYC($key) {
	    return $this->remove($this->table, $key);
	}
}	