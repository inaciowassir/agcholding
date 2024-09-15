<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class DocumentApplicationController extends Controller{
	private $documentApplicationModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Documents/Application/";
		$this->applicationDocumentModel = new \sprint\models\DocumentApplicationModel();
	}
	
	public function index() {
		$this->data["documents"] = $this->applicationDocumentModel->applicationDocuments();
		return $this->view("Index", $this->data);
	}
	
	public function create() {
		$key = $this->applicationDocumentModel->create();
		echo !is_null($key) || !empty($key) ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
	
	public function save($key = null) {
	    if(SRequest::isGet()) {
	    	if(is_null($key)) SResponse::redirect("documents/applications");
	
            	$this->data["key"] = $key;
            	$this->data["document"] = $this->applicationDocumentModel->getApplicationDocumentByKey($key);
	        return $this->view("Save", $this->data);
	    }
	    
	    if(SRequest::isPost()) {
	        $body = SRequest::body();	        
	        $docUploaded = $this->applicationDocumentModel->upload($_FILES['pdfFile']);	        
	        $date = date("d-m-Y");
	        
	        if(!empty($docUploaded)) {
	        	$applicationDocument = array(
			        "name"  => trim($body['name']),
			        "download_url" => trim($docUploaded["download_url"]),
	                    	"file_size" => trim($docUploaded["file_size"]),
	                    	"created_at" => $date,
	                    	"updated_at" => $date,
	                    	"status" => "active"
	            	);
	            
	            $data = $this->applicationDocumentModel->saveApplicationDocument($applicationDocument , $body['key']);
	            
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
	}
	
	
	public function remove() {
		$body = SRequest::body();
		$key = $body["node"];
		$result = $this->applicationDocumentModel->removeApplicationDocument($key);
		
		echo $result == true ? json_encode(array("status" => "success", "key" => $key)) : json_encode(array("status" => "failed"));
	}
}