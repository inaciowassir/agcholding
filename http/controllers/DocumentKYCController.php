<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class DocumentKYCController extends Controller{
	private $documentKYCModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Documents/KYC/";
		$this->documentKYCModel= new \sprint\models\DocumentKYCModel();
	}
	
	public function index() {
		$this->data["documents"] = $this->documentKYCModel->documents();
		return $this->view("Index", $this->data);
	}
	
	public function create()
	{
		$key = $this->documentKYCModel->create();
		echo !is_null($key) || !empty($key)
		    ? json_encode(["status" => "success", "key" => $key])
		    : json_encode(["status" => "failed"]);
	}
	
	public function save($key = null)
	{
		if (SRequest::isGet()) {
		    if (is_null($key)) {
		        SResponse::redirect("documents/kyc");
		    }
		
		    $this->data["key"] = $key;
		    $this->data["document"] = $this->documentKYCModel->getKYCByKey($key);
		    return $this->view("Save", $this->data);
		}
		
		if (SRequest::isPost()) {
		    $body = SRequest::body();
		
		    $kyc= [
		        "name" => trim($body["name"]),
		    ];
		
		    $data = $this->documentKYCModel->saveKYC($kyc, $body["key"]);
		
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
	
	public function remove()
	{
		$body = SRequest::body();
		$key = $body["node"];
		$result = $this->documentKYCModel->removeKYC($key);
		
		echo $result == true
		    ? json_encode(["status" => "success", "key" => $key])
		    : json_encode(["status" => "failed"]);
	}
}