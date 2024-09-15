<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;

class AdministratorController extends Controller{
	private $loanModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/";
		$this->loanModel = new \sprint\models\LoanModel();
	}
	
	public function index() {
	    $this->data["loans"] = $this->loanModel->getAllLoans();
	    
	    $this->data["pendingLoans"] = array_filter($this->data["loans"], function($v) {
	        return $v["approvalStatus"] == "PENDING";
	    });
	    
	    $this->data["awaitingDisbursimentLoans"] = array_filter($this->data["loans"], function($v) {
	        return $v["approvalStatus"] == "AWAITING_DISBURSIMENT";
	    });
	    
	    $this->data["disbursedLoans"] = array_filter($this->data["loans"], function($v) {
	        return $v["approvalStatus"] == "DISBURSED";
	    });
	    
	    $this->data["rejectedLoans"] = array_filter($this->data["loans"], function($v) {
	        return $v["approvalStatus"] == "REJECTED";
	    });
	    
	    $this->data["cancelledLoans"] = array_filter($this->data["loans"], function($v) {
	        return $v["approvalStatus"] == "CANCELLED";
	    });
	    
	    
		return $this->view("Home/Index", $this->data);
	}
	
}