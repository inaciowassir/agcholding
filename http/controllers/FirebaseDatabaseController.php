<?php
namespace sprint\http\controllers;

use sprint\http\core\Controller;

class FirebaseDatabaseController extends Controller{
	private $userModel;
	
	public function __construct() {
		$this->userModel = new \sprint\models\UserModel();
	}
	
	public function readAllEmployeesUsers() {
		$this->userModel->readAllEmployeesUsers();
	}
	
}