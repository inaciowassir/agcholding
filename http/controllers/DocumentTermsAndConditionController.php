<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class DocumentTermsAndConditionController extends Controller{
	private $documentTermsAndContionModel;
	private $storage;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Documents/TermsAndCondition/";
		$this->documentTermsAndContionModel= new \sprint\models\DocumentTermsAndContionModel();
	}
	
	public function index() {
		$this->data["documents"] = $this->documentTermsAndContionModel->documents();
		return $this->view("Index", $this->data);
	}
	
	public function create()
	{
		$key = $this->documentTermsAndContionModel->create();
		echo !is_null($key) || !empty($key)
		    ? json_encode(["status" => "success", "key" => $key])
		    : json_encode(["status" => "failed"]);
	}
	
	public function save($key = null)
	{
		if (SRequest::isGet()) {
		    if (is_null($key)) {
		        SResponse::redirect("documents/terms_and_conditions");
		    }
		
		    $this->data["key"] = $key;
		    $this->data["document"] = $this->documentTermsAndContionModel->getTermsAndContionByKey($key);
		    return $this->view("Save", $this->data);
		}
		
		if (SRequest::isPost()) {
		    $body = SRequest::body();
		    $docUploaded = $this->documentTermsAndContionModel->upload($_FILES['pdfFile']);	        
	            $date = date("d-m-Y");
	        
	            if(!empty($docUploaded)) {	
			    $termsAndConditions = array(
				        "name"  => trim($body['name']),
				        "download_url" => trim($docUploaded["download_url"]),
		                    	"file_size" => trim($docUploaded["file_size"]),
		                    	"created_at" => $date,
		                    	"updated_at" => $date,
		                    	"status" => "active"
		            	);
			
			    $data = $this->documentTermsAndContionModel->saveTermsAndContion($termsAndConditions, $body["key"]);
			
			    if ($data == true) {
			        echo json_encode([
			            "status" => "success",
			        ]);
			    } else {
			        echo json_encode([
			            "status" => "failed",
			        ]);
			    }
	            }
		}
	}
	
	public function remove()
	{
		$result = $this->documentTermsAndContionModel->removeTermsAndContion();		
		echo $result == true
		    ? json_encode(["status" => "success"])
		    : json_encode(["status" => "failed"]);
	}
}