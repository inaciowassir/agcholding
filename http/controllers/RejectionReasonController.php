<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class RejectionReasonController extends Controller{
	private $rejectionReasonModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/RejectionReasons/";
		$this->rejectionReasonModel= new \sprint\models\RejectionReasonModel();
	}
	public function index() {
		$this->data["rejectionReasons"] = $this->rejectionReasonModel->rejectionReasons();
		return $this->view("Index", $this->data);
	}
	
	
	public function create() {
		$key = $this->rejectionReasonModel->create();
		echo !is_null($key) || !empty($key) ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
	
	
	public function save($key = null) {
	    if(SRequest::isGet()) {
	    	if(is_null($key)) SResponse::redirect("rejection_reasons");
	    	
            	$this->data["key"] = $key;
            	$this->data["rejectionReason"] = $this->rejectionReasonModel->getRejectionReasonByKey($key);
	        return $this->view("Save", $this->data);
	    }
	    
	    if(SRequest::isPost()) {
	        $body = SRequest::body();
	        
		   $rejectionReason = array(
	                "reason"  => trim($body['reason']),
	                "type"  => trim($body['type'])
	            );
	            
	            $data = $this->rejectionReasonModel->saveRejectionReason($rejectionReason , $body['key']);
	            
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
		$result = $this->rejectionReasonModel->removeRejectionReason($key);
		echo $result == true ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
}