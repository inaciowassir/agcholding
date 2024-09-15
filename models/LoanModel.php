<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class LoanModel extends FirebaseModel {
	private $table = "loans";
	private $tableInstallments = "installments";
	private $tableEmployers = "users";
	
	public function getAllLoans() {
	    return $this->select($this->table)->results();
	}
	
	public function filter($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getLoanByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function getEmployerByKey($key) {
	    return $this->getValueByKey($this->tableEmployers, $key);
	}
	
	public function getInstallmentsByKey($key) {
	    return $this->getValueByKey($this->tableInstallments, $key);
	}
	
	public function approvalAction($key, $status) {
	    return $this->updateColumn($this->table, $key, "approvalStatus", $status);
	}
	
	public function updateLoanColumn($key, $column, $value) {
	    return $this->updateColumn($this->table, $key, $column, $value);
	}
	
	public function saveMonthlyInstallments($data, $key = null) {
		return $this->save($this->tableInstallments, $data, $key);		
	}
}