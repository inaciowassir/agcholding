<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class EntityController extends Controller{
	private $entityModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Entities/";
		$this->entityModel = new \sprint\models\EntityModel();
	}
	public function index() {
		$this->data["entities"] = $this->entityModel->entities();
		return $this->view("Index", $this->data);
	}
	
	public function create() {
		$key = $this->entityModel->create();
		echo !is_null($key) || !empty($key) ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
	
	public function save($key = null) {
	    if(SRequest::isGet()) {
	    	if(is_null($key)) SResponse::redirect("institution/entities");
            	$this->data["key"] = $key;
            	$this->data["entity"] = $this->entityModel->getEntityByKey($key);
	        return $this->view("Save", $this->data);
	    }
	    
	    if(SRequest::isPost()) {
	        $body = SRequest::body();
	        
		    $entity = array(
		        "name"  => trim($body['name'])
	            );
	            
	            $data = $this->entityModel->saveEntity($entity, $body['key']);
	            
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
		$result = $this->entityModel->removeEntity($key);
		
		echo $result == true ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
}