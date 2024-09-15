<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;

class BranchController extends Controller{
	private $branchModel;
	private $entityModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Branches/";
		$this->branchModel = new \sprint\models\BranchModel();
		$this->entityModel = new \sprint\models\EntityModel();
	}
	public function index() {
		$this->data["branches"] = $this->branchModel->branches();
		return $this->view("Index", $this->data);
	}
	
	public function create() {
		$key = $this->branchModel->create();
		echo !is_null($key) || !empty($key) ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
	
	public function save($key = null) {
	    if(SRequest::isGet()) {
	    	if(is_null($key)) SResponse::redirect("institution/branches");
	    	
            $this->data["key"] = $key;
	        $this->data["branch"] = $this->branchModel->getBranchByKey($key);
	       	$this->data["entities"] = $this->entityModel->entities();
	       	
	        return $this->view("Save", $this->data);
	    }
	    
	    if(SRequest::isPost()) {
	        $body = SRequest::body();
	        
	    $branch = array(
	        "name"  => trim($body['name']),
	        "mainEntity"  => trim($body['mainEntity']),
	        "mainEntityUuid"  => trim($body['mainEntityUuid']),
            );
            
            $data = $this->branchModel->saveBranch($branch, $body['key']);
            
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
		$result = $this->branchModel->removeBranch($key);
		
		echo $result == true ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
}