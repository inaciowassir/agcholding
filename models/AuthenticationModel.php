<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class AuthenticationModel extends FirebaseModel {
    private $table = "admin_users/users";

    
    public function auth($email) {
    	return $this->filterSnapshotByColumn($this->table, "email", $email);    	
    }
    
    public function authPasswordByKey($key) {
    	return $this->getValueByKey("admin_users/password", $key);   	
    }
}