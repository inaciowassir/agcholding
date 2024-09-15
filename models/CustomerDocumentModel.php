<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class CustomerDocumentModel extends FirebaseModel {
	private $tableKyc = "kyc/documents/";
	private $tableLoanContract = "loan_contracts/documents/";
	
	public function kycDocuments() {
		return $this->select($this->tableKyc)->results();		
	}
	
	public function getCustomerKYCDocumentByKey($key) {
	    return $this->getValueByKey($this->tableKyc, $key);
	}	
	
	public function singleCustomerKYCDocument($key, $index) {
	    return $this->getValueByKey($this->tableKyc . "/" . $key, $index);
	}
	
	public function getCustomerContractualDocumentByKey($key) {
	    return $this->getValueByKey($this->tableLoanContract, $key);
	}
	
	public function updateCustomerKYCDocumentColumn($key, $index, $column, $value) {
		return $this->updateColumn($this->tableKyc . "/" . $key, $index, $column, $value);
	}
	
	public function updateCustomerContractualDocumentColumn($key, $column, $value) {
		return $this->updateColumn($this->tableLoanContract, $key, $column, $value);
	}
}