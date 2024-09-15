<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class AuthenticationController extends Controller{

	private $authenticationModel;

	public function __construct() {
		$this->viewsPath 	= "views/layouts/";
		$this->authenticationModel = new \sprint\models\AuthenticationModel();
	}

	public function index() {
		return $this->view("Authentication/Index");
	}

	public function authorize() {
		$body = SRequest::body();
	
		$snapshot = $this->authenticationModel->auth($body["email"]);
		
		if($snapshot->exists()) {
			$result = $snapshot->getValue();
			$user = reset($result);
			$key = array_key_first($result);
			
			$passwordResult = $this->authenticationModel->authPasswordByKey($key);
			$hashedPassword = reset($passwordResult);
			
			if(password_verify(trim($body["password"]), $hashedPassword["password"])) {
				SSession::set("loggedUser", $result);
			
				echo json_encode(array(
					"status" => "success",
				));
			} else {
				echo json_encode(array("status" => "failed"));
			}
		} else {
			echo json_encode(array("status" => "unauthorized"));
		}
	}
	
	public function checkSession(){
		$data = SSession::get("loggedUser");
		if(empty($data)) {
			SResponse::redirect("auth");
		}
	}
	
	public function logout() {
		SSession::remove("loggedUser");		
		$this->checkSession();
	}
}