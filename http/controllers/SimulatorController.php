<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;
use \sprint\ssession\SSession;

class SimulatorController extends Controller{
	private $simulatorModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Simulator/";
		$this->simulatorModel = new \sprint\models\SimulatorModel();
	}
	
	public function save($key = null)
    {
        if (SRequest::isGet()) {
            $response = $this->simulatorModel->parameters();
            
            if(empty($response) || is_null($response)) {
                $this->data["key"] = $this->simulatorModel->create();
            }
			
			if(!empty($response)) {
				foreach($response as $key => $value) {
					$this->data["key"] = $key;
				}				
			}
	        
    	    $this->data["parameter"] = $response;
	        return $this->view("Parameters", $this->data);
        }

        if (SRequest::isPost()) {
            $body = SRequest::body();
			$interestRates = [];
			
			foreach($body["interestRateApplied"] as $key => $rates) {
				if(!empty($body["minLoanTerm"][$key]) && !empty($body["maxLoanTerm"][$key]) && !empty($body["interestRateApplied"][$key])) {
					array_push($interestRates, [
						"minLoanTerm" => $body["minLoanTerm"][$key],
						"maxLoanTerm" => $body["maxLoanTerm"][$key],
						"interestRateApplied" => $body["interestRateApplied"][$key]
					]);					
				}
			}
			
	        $parameter = array(
                "minAllowedLoan"              => trim($body['minAllowedLoan']),
                "maxEffortRate"               => trim($body['maxEffortRate']),
                "minSimulatorLoanTerm"      => trim($body['minSimulatorLoanTerm']),
                "maxSimulatorLoanTerm"      => trim($body['maxSimulatorLoanTerm']),
                "interestRates"      		  => $interestRates,
            );

            $data = $this->simulatorModel->saveParameter($parameter, $body["key"]);

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