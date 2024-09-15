<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class RejectionReasonModel extends FirebaseModel {
	private $table = "configurations/rejection_reasons";
	
	public function filterRejectionReason($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getRejectionReasonByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function rejectionReasons() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveRejectionReason($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeRejectionReason($key) {
	    return $this->remove($this->table, $key);
	}
}