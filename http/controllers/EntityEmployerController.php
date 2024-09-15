<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class EntityEmployerController extends Controller{
	private $entityEmployerModel;
	private $branchModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/EntityEmployers/";
		$this->entityEmployerModel = new \sprint\models\EntityEmployerModel();
		$this->branchModel = new \sprint\models\BranchModel();
	}
	public function index() {
		$this->data["employersEntity"] = $this->entityEmployerModel->employersEntity();
		return $this->view("Index", $this->data);
	}
	
	public function create() {
		$key = $this->branchModel->create();
		echo !is_null($key) || !empty($key) ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
	
	public function save($key = null) {
	    if(SRequest::isGet()) {
	    	if(is_null($key)) SResponse::redirect("institution/entity_employers");
	    	
            	$this->data["key"] = $key;
	        $this->data["employerEntity"] = $this->entityEmployerModel->getEmployerEntityByKey($key);
	       	$this->data["branches"] = $this->branchModel->branches();
	       	
	        return $this->view("Save", $this->data);
	    }
	    
	    if(SRequest::isPost()) {
	        $body = SRequest::body();
	        
	    $employerBranch = array(
	        "name"  => trim($body['name']),
	        "branchEntity"  => trim($body['branchEntity']),
	        "branchEntityUuid"  => trim($body['branchEntityUuid']),
            );
            
            $data = $this->entityEmployerModel->saveEmployerEntity($employerBranch, $body['key']);
            
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
		$result = $this->entityEmployerModel->removeEmployerEntity($key);
		
		echo $result == true ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}

}