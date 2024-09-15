<?php

namespace sprint\http\controllers;

use \sprint\http\core\Controller;
use \sprint\srequest\SRequest;
use \sprint\sresponse\SResponse;

class LoanController extends Controller{
    
    use \sprint\http\controllers\LoanStatusTemplate;
    
	private $loanModel;
	private $rejectionReasonModel;
	private $documentTermsAndContionModel;
	private $documentKYCModel;
	private $customerDocumentModel;
	private $data = [];
	
	public function __construct() {
		$this->viewsPath 	= "views/layouts/Loans/";
		
		$this->loanModel 	= new \sprint\models\LoanModel();
		$this->rejectionReasonModel= new \sprint\models\RejectionReasonModel();
		$this->documentTermsAndContionModel= new \sprint\models\DocumentTermsAndContionModel();
		$this->documentKYCModel= new \sprint\models\DocumentKYCModel();
		$this->customerDocumentModel = new \sprint\models\CustomerDocumentModel();
	}
	
	public function index($status = null) {
		$this->data["loans"] = $this->loanModel->filter("approvalStatus", strtoupper($status));
		$employerKey = array_keys($this->data["loans"]);
		
		if(!empty($employerKey)) {
			$key = $employerKey[0];
			$this->data["employer"] = $this->loanModel->getEmployerByKey($key)[$key];		
		}
		$this->data["status"] = $this->loanStatus($status);	
		$this->data["statusColor"] = $this->loanStatusColor($status);	
		
		return $this->view("Index", $this->data);
	}
	
	public function details($key = null) {
	    if(!is_null($key)) {	
			//configured KYC documents and rejections reasons in the admin painel
	        $this->data["KYCDocuments"] = $this->documentKYCModel->documents();
			$this->data["rejectionReasons"] = $this->rejectionReasonModel->rejectionReasons();			
			
			//All loan's employeer documents submitted by employeer app
			$this->data["key"] = $key;
	        $this->data["loan"] = $this->loanModel->getLoanByKey($key);
	        $this->data["employer"] = $this->loanModel->getEmployerByKey($key);		
			$this->data["customerContractualDocument"] = $this->customerDocumentModel->getCustomerContractualDocumentByKey($key);			
			$this->data["customerKYCDocuments"] = $this->customerDocumentModel->getCustomerKYCDocumentByKey($key);	
			
			$customerKYCDocuments = $this->data["customerKYCDocuments"][$key];
			$customerContractualDocument = $this->data["customerContractualDocument"][$key];
			
			//To allow the approval loan action be available the employeer must had sumitted all KYC's documents, contractual document and it must had been approved by the direct employeer's manager, accepted the terms and conditions and the loan approval status/approved by needs to be empty			
			//First lets check if the user submitted all KYC's documents
			//We do that by compare all configured KYC document types with the sumbitted KYC document types by employeer to check if there is any document missing
			$customerKYCDocumentsDocumentTypes = array_column($customerKYCDocuments, "documentType");	
			$KYCDocumentsDocumentTypes = array_column($this->data["KYCDocuments"], "name");
			
			
			//The array_diff method helps us to get the diference between the submitted KYC documents by the employeer and the configured in the painel by admin
			$this->data["customerMissingKYCDocuments"] = array_diff($KYCDocumentsDocumentTypes, $customerKYCDocumentsDocumentTypes);
			
			//Pending kyc documents
			$this->data["pendingKYCDocuments"] = array_filter($customerKYCDocuments, function($v, $k){
				return $v["approvalStatus"] === "PENDING" && empty($v["rejectedBy"])&& empty($v["approvedBy"]);
			}, ARRAY_FILTER_USE_BOTH);
			
			//Rejected kyc documents
			$this->data["rejectedKYCDocuments"] = array_filter($customerKYCDocuments, function($v, $k){
				return $v["approvalStatus"] === "REJECTED" && !empty($v["rejectedBy"]);
			}, ARRAY_FILTER_USE_BOTH);
			
			//Approved kyc documents
			$this->data["approvedKYCDocuments"] = array_filter($customerKYCDocuments, function($v, $k){
				return $v["approvalStatus"] === "APPROVED" && !empty($v["approvedBy"]);
			}, ARRAY_FILTER_USE_BOTH);	
			
			//If the employeer pass this conditions means that all KYC's documents are provided
			$this->data["isAllKYCDocumentsSubmitted"] = !empty($KYCDocumentsDocumentTypes) 
			&& !empty($customerKYCDocumentsDocumentTypes) 
			&& empty($this->data["customerMissingKYCDocuments"]); 
			
			
			//Now let's check if the contractual document was submitted and approved by the direct manager
			//If the employeer pass this conditions means that the contractual submitted is valid and approved
			$this->data["isContractualDocumentValid"] = !empty($customerContractualDocument) 
			&& $customerContractualDocument["approvalStatus"] === "APPROVED" 
			&& !empty($customerContractualDocument["approvedBy"]);
			
			//Get customer's installments by key
			$this->data["instalments"] = $this->loanModel->getInstallmentsByKey($key)[$key];
			
			$status = $this->data["loan"][$key]['approvalStatus'];
			$this->data["status"] = $this->loanStatus($status);
			$this->data["statusColor"] = $this->loanStatusColor($status);
	    }
		return $this->view("Details", $this->data);
	}
	
	public function contractualApproval($key) {
		$this->data["key"] = $key;
		$this->data["index"] = null;
		$this->data["rejectionReasons"] = $this->rejectionReasonModel->rejectionReasons();		
		$this->data["document"] = $this->customerDocumentModel->getCustomerContractualDocumentByKey($key)[$key];
		
		$this->data["document"] = array_merge($this->data["document"], ["documentType" => "Contracto mutuo"]);
		
		return $this->view("Actions", $this->data);
	}
	
	public function kycApproval($key, $index) {
		$this->data["key"] = $key;
		$this->data["index"] = $index;
		$this->data["rejectionReasons"] = $this->rejectionReasonModel->rejectionReasons();
		$this->data["document"] = $this->customerDocumentModel->singleCustomerKYCDocument($key, $index)[$index];
		
		return $this->view("Actions", $this->data);
	}
	
	public function loanApprovalAction($action = null) {
		if(!is_null($action)) {
		    $body = SRequest::body();
		    $nodeKey = $body["nodeKey"];
		    $status = $body["currentStatus"];
		    $rejectionReasons = "";
		    $rejectedBy = "";
		    $approvedBy = "";
		    $updatedBy = "";
		    $millisecondsSinceEpoch = round(microtime(true) * 1000);
			
	        $loan = $this->loanModel->getLoanByKey($nodeKey)[$nodeKey];
		    
    		$data = \sprint\ssession\SSession::get("loggedUser");
            $session_key = array_key_first($data);
            extract(reset($data), EXTR_PREFIX_ALL, "session");		    
			
			$rejectionReason = !empty($body["reasons"]) ? implode(", ", $body["reasons"]) : "";

			if($action == "approve") {
				$status = "AWAITING_DISBURSEMENT";
				$approvedBy = $session_full_name;
			} else if($action == "reject") {
				$status = "REJECTED";
				$rejectedBy = $session_full_name;
			}else if($action == "awaiting_disbursement") {
				$status = "DISBURSED";
				$approvedBy = $session_full_name;
			}			
			
			$reasonsResult = $this->loanModel->updateLoanColumn($nodeKey, "rejectionReason", $rejectionReason);
    		$rejectedByResult = $this->loanModel->updateLoanColumn($nodeKey, "rejectedBy", $rejectedBy);
    		$approvedByResult = $this->loanModel->updateLoanColumn($nodeKey, "approvedBy", $approvedBy);
    		$updatedByResult = $this->loanModel->updateLoanColumn($nodeKey, "updatedBy", $session_full_name);
			$updatedAt = $this->loanModel->updateLoanColumn($nodeKey, "updatedAt", $millisecondsSinceEpoch);
			$result = $this->loanModel->approvalAction($nodeKey, $status);
			    
		    if($result && $reasonsResult && $rejectedByResult && $approvedByResult && $updatedByResult && $updatedAt) {
				if($action == "awaiting_disbursement") {
					$this->generateInstallments($nodeKey, $loan["loanTerms"], $loan["monthlyInstallment"]);
				}
		        echo json_encode(array("status" => "success"));
		    } else {
		        echo json_encode(array("status" => "failed"));
		    }
		}
	}
	
	public function documentApprovalAction($action = null) {
	    if(!is_null($action)) {
	        if(!is_null($action)) {
    		    $body = SRequest::body();
    		    $parentNodeKey = $body["parentNodeKey"];
    		    $nodeKey = $body["nodeKey"];
    		    $documentType = $body["documentType"];
				
    		    $rejectionReason = !empty($body["reasons"]) ? implode(", ", $body["reasons"]) : "";
    		    $status = "REJECTED";
    		    
    		    $rejectedBy = "";
    		    $approvedBy = "";
    		    $updatedBy = "";
    		    $millisecondsSinceEpoch = round(microtime(true) * 1000);
    		    
    		    $reasonsResult = false;
    		    $rejectedByResult = false;
    		    $approvedByResult = false;
    		    $updatedByResult = false;
    		    $updatedAt = false;
    		    
        		$data = \sprint\ssession\SSession::get("loggedUser");
                $session_key = array_key_first($data);
                extract(reset($data), EXTR_PREFIX_ALL, "session");
    		    
    		    if($action == "approve") {
    			    $status = "APPROVED";
    			    $approvedBy = $session_full_name;
    			} else if($action == "reject") {
    			    $status = "REJECTED";
    			    $rejectedBy = $session_full_name;
    			}
    		    
    			if($documentType !== "Contracto mutuo") {    			    
    			    $result = $this->customerDocumentModel->updateCustomerKYCDocumentColumn($parentNodeKey, $nodeKey, "approvalStatus", $status);
					
    			    $reasonsResult = $this->customerDocumentModel->updateCustomerKYCDocumentColumn($parentNodeKey, $nodeKey, "rejectionReason", $rejectionReason);
					
        		    $rejectedByResult = $this->customerDocumentModel->updateCustomerKYCDocumentColumn($parentNodeKey, $nodeKey, "rejectedBy", $rejectedBy);
					
            		$approvedByResult = $this->customerDocumentModel->updateCustomerKYCDocumentColumn($parentNodeKey, $nodeKey, "approvedBy", $approvedBy);
					
            		$updatedByResult = $this->customerDocumentModel->updateCustomerKYCDocumentColumn($parentNodeKey, $nodeKey, "updatedBy", $session_full_name);
					
        			$updatedAt = $this->customerDocumentModel->updateCustomerKYCDocumentColumn($parentNodeKey, $nodeKey, "updatedAt", $millisecondsSinceEpoch);
    			} else {
					$result = $this->customerDocumentModel->updateCustomerContractualDocumentColumn($parentNodeKey, "approvalStatus", $status);
					
    			    $reasonsResult = $this->customerDocumentModel->updateCustomerContractualDocumentColumn($parentNodeKey, "rejectionReason", $rejectionReason);
					
        		    $rejectedByResult = $this->customerDocumentModel->updateCustomerContractualDocumentColumn($parentNodeKey, "rejectedBy", $rejectedBy);
					
            		$approvedByResult = $this->customerDocumentModel->updateCustomerContractualDocumentColumn($parentNodeKey, "approvedBy", $approvedBy);
					
            		$updatedByResult = $this->customerDocumentModel->updateCustomerContractualDocumentColumn($parentNodeKey, "updatedBy", $session_full_name);
					
        			$updatedAt = $this->customerDocumentModel->updateCustomerContractualDocumentColumn($parentNodeKey, "updatedAt", $millisecondsSinceEpoch);
				}
    			
    			if($result && $reasonsResult && $rejectedByResult && $approvedByResult && $updatedByResult && $updatedAt) {
    		        echo json_encode(array("status" => "success"));
    		    } else {
    		        echo json_encode(array("status" => "failed"));
    		    }
    			
    		}
	    }
	}
	
	private function generateInstallments($key, $loanTermMonths, $installmentAmount) {
        $startDate = date("Y-m-d");
		$startDateTime = new \DateTime($startDate);
		
		$installments = array_reduce(
			range(1, $loanTermMonths), 
			function($carry, $month) use ($startDate, $startDateTime, $installmentAmount) {
				$previousInstallment = end($carry);
				
				$currentStartDate = $month === 1 
					? clone $startDateTime 
					: new \DateTime($previousInstallment['overdueAt']);
				
				$dueDate = clone $currentStartDate;
				$dueDate->modify('+1 month');
				
				$carry[] = [
					'startAt' 		=> $currentStartDate->format('Y-m-d'),
					'overdueAt' 	=> $dueDate->format('Y-m-d'),
					'installment' 	=> $installmentAmount,
					"createdAt"		=> $startDate,
					"updatedAt"		=> $startDate,
					"updatedBy"		=> "",
					"paymentStatus"		=> "PENDING",
				];

				return $carry;
			},
			[]
		);
    
        $this->loanModel->saveMonthlyInstallments($installments, $key);
    }
}