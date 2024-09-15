<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class UserModel extends FirebaseModel {
	private $table = "admin_users/users";
	
	public function filterUser($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getUserByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function users() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveUser($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeUser($key) {
	    return $this->remove($this->table, $key);
	}
	
	public function getUserPasswordByKey($key) {
	    return $this->getValueByKey("admin_users/password", $key);
	}
	
	public function saveUserPassword($data, $key = null) {
		return $this->save("admin_users/password", $data, $key);		
	}
	
	public function saveDataAccessAuthorization($data, $key = null) {
		return $this->save("admin_users/institution_data_access_authorization", $data, $key);		
	}
	
	public function getUserDataAccessAuthorizationByKey($key) {
	    return $this->getValueByKey("admin_users/institution_data_access_authorization", $key);
	}
}