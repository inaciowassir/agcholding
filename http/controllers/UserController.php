<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;


class UserController extends Controller{
	private $loanModel;
	private $userModel;
	private $roleModel;
    	private $entityEmployerModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Users/";
		$this->userModel = new \sprint\models\UserModel();
		$this->roleModel = new \sprint\models\RoleModel();
        	$this->entityEmployerModel = new \sprint\models\EntityEmployerModel();
	}
	public function index() {
		$this->data["users"] = $this->userModel->users();
		return $this->view("Index", $this->data);
	}
	
	public function create() {
		$key = $this->userModel->create();
		echo !is_null($key) || !empty($key) ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
	
	public function save($key = null) {
	    if(SRequest::isGet()) {
	    	if(is_null($key)) SResponse::redirect("users");
	
            	$this->data["roles"] = $this->roleModel->roles();
            	$this->data["key"] = $key;
            	$this->data["user"] = $this->userModel->getUserByKey($key);    
            	$this->data["authorizedInstitutions"] = $this->userModel->getUserDataAccessAuthorizationByKey($key);        	
            	$this->data["employersEntity"] = $this->entityEmployerModel->employersEntity();
	        return $this->view("Save", $this->data);
	    }
	    
	    if(SRequest::isPost()) {
	        $body = SRequest::body();
	        
	   $user = array(
	        "full_name"  		=> trim($body['full_name']),
	        "mobile_number"  	=> trim($body['mobile_number']),
	        "email"  		=> trim($body['email']),
                "username"  		=> trim($body['username']),
                "role"      		=> trim($body['role'])
            );
            
            $data = $this->userModel->saveUser($user, $body['key']);
            
            if($data == true) {
                echo json_encode(
                    array(
                        "status" => "success",
                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "failed",
                    )
                );
            }
	    }
	}
	
	public function saveUserPassword() {
		if(SRequest::isPost()) {
			$body = SRequest::body();
			
			$password = array(
				"password"  => password_hash(trim($body['password']), PASSWORD_BCRYPT, ['cost' => 10]),
			);
			
			$data = $this->userModel->saveUserPassword($password, $body['key']);
			
			if($data == true) {
				echo json_encode(
				    array(
				        "status" => "success",
				    )
				);
			} else {
				echo json_encode(
				    array(
				        "status" => "failed",
				    )
				);
			}
		}
	}
	
	public function saveDataAccessAuthorization() {
		if(SRequest::isPost()) {
			$body = SRequest::body();
			
			$dataAccessAuthorization = array(				
                		"authorized_institution" => $body["instituition"],
			);
			
			$data = $this->userModel->saveDataAccessAuthorization($dataAccessAuthorization, $body['key']);
			
			if($data == true) {
				echo json_encode(
				    array(
				        "status" => "success",
				    )
				);
			} else {
				echo json_encode(
				    array(
				        "status" => "failed",
				    )
				);
			}
		}
	}
	
	
	public function remove() {
		$body = SRequest::body();
		$key = $body["node"];
		$result = $this->userModel->removeUser($key);
		
		echo $result == true ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
}