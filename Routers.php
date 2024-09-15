<?php
namespace sprint;

use sprint\sroute\SRoute;
use sprint\http\controllers\AdministratorController;
use sprint\http\controllers\UserController;
use sprint\http\controllers\RoleController;
use sprint\http\controllers\LoanController;
use sprint\http\controllers\EntityController;
use sprint\http\controllers\BranchController;
use sprint\http\controllers\EntityEmployerController;
use sprint\http\controllers\DocumentApplicationController;
use sprint\http\controllers\DocumentTermsAndConditionController;
use sprint\http\controllers\DocumentKYCController;
use sprint\http\controllers\SimulatorController;
use sprint\http\controllers\RejectionReasonController;
use sprint\http\controllers\AuthenticationController;


SRoute::get("/auth", [AuthenticationController::class, "index"]);
SRoute::post("/auth/authorize", [AuthenticationController::class, "authorize"]);
SRoute::get("/auth/logout", [AuthenticationController::class, "logout"]);


SRoute::group(array(
	"middleware" 	=> array(
		[AuthenticationController::class, "checkSession"]
	),
), function()
{
	SRoute::get("/", [AdministratorController::class, "index"]);
	SRoute::get("/loans/details/{key}", [LoanController::class, "details"]);
	
	SRoute::get("/loans/details/{key}/actions/contractual-document", [LoanController::class, "contractualApproval"]);
	
	SRoute::get("/loans/details/{key}/actions/kyc-document/{index}", [LoanController::class, "kycApproval"]);
	
	
	SRoute::post("/loans/documents/actions/{status}", [LoanController::class, "documentApprovalAction"]);
	SRoute::post("/loans/actions/{status}", [LoanController::class, "loanApprovalAction"]);
	SRoute::get("/loans/{status}", [LoanController::class, "index"]);
	
	SRoute::get("/users", [UserController::class, "index"]);
	SRoute::get("/users/create", [UserController::class, "create"]);
	SRoute::get("/users/save/{key}?", [UserController::class, "save"]);
	SRoute::post("/users/save", [UserController::class, "save"]);
	SRoute::post("/users/saveUserPassword", [UserController::class, "saveUserPassword"]);
	SRoute::post("/users/saveDataAccessAuthorization", [UserController::class, "saveDataAccessAuthorization"]);
	SRoute::post("/users/remove", [UserController::class, "remove"]);
	
	SRoute::get("/roles", [RoleController::class, "index"]);
	SRoute::get("/roles/create", [RoleController::class, "create"]);
	SRoute::get("/roles/save/{key}?", [RoleController::class, "save"]);
	SRoute::post("/roles/save", [RoleController::class, "save"]);
	SRoute::post("/roles/remove", [RoleController::class, "remove"]);
	
	SRoute::get("/institution/entities", [EntityController::class, "index"]);
	SRoute::get("/institution/entities/create", [EntityController::class, "create"]);
	SRoute::get("/institution/entities/save/{key}?", [EntityController::class, "save"]);
	SRoute::post("/institution/entities/save", [EntityController::class, "save"]);
	SRoute::post("/institution/entities/remove", [EntityController::class, "remove"]);
	
	SRoute::get("/institution/branches", [BranchController::class, "index"]);
	SRoute::get("/institution/branches/create", [BranchController::class, "create"]);
	SRoute::get("/institution/branches/save/{key}?", [BranchController::class, "save"]);
	SRoute::post("/institution/branches/save", [BranchController::class, "save"]);
	SRoute::post("/institution/branches/remove", [BranchController::class, "remove"]);	
	
	SRoute::get("/institution/entity_employers", [EntityEmployerController::class, "index"]);
	SRoute::get("/institution/entity_employers/create", [EntityEmployerController::class, "create"]);
	SRoute::get("/institution/entity_employers/save/{key}?", [EntityEmployerController::class, "save"]);
	SRoute::post("/institution/entity_employers/save", [EntityEmployerController::class, "save"]);
	SRoute::post("/institution/entity_employers/remove", [EntityEmployerController::class, "remove"]);
		
	SRoute::get("/documents/applications", [DocumentApplicationController::class, "index"]);
	SRoute::get("/documents/applications/create", [DocumentApplicationController::class, "create"]);
	SRoute::get("/documents/applications/save/{key}?", [DocumentApplicationController::class, "save"]);
	SRoute::post("/documents/applications/save", [DocumentApplicationController::class, "save"]);
	SRoute::post("/documents/applications/remove", [DocumentApplicationController::class, "remove"]);	
		
	SRoute::get("/documents/terms_and_conditions", [DocumentTermsAndConditionController::class, "index"]);
	SRoute::get("/documents/terms_and_conditions/create", [DocumentTermsAndConditionController::class, "create"]);
	SRoute::get("/documents/terms_and_conditions/save/{key}?", [DocumentTermsAndConditionController::class, "save"]);
	SRoute::post("/documents/terms_and_conditions/save", [DocumentTermsAndConditionController::class, "save"]);
	SRoute::post("/documents/terms_and_conditions/remove", [DocumentTermsAndConditionController::class, "remove"]);	
	
	SRoute::get("/documents/kyc", [DocumentKYCController::class, "index"]);
	SRoute::get("/documents/kyc/create", [DocumentKYCController::class, "create"]);
	SRoute::get("/documents/kyc/save/{key}?", [DocumentKYCController::class, "save"]);
	SRoute::post("/documents/kyc/save", [DocumentKYCController::class, "save"]);
	SRoute::post("/documents/kyc/remove", [DocumentKYCController::class, "remove"]);	
	
	SRoute::get("/simulator/parameters", [SimulatorController::class, "save"]);
	SRoute::post("/simulator/parameters/save", [SimulatorController::class, "save"]);	
	
	SRoute::get("/rejection_reasons", [RejectionReasonController::class, "index"]);
	SRoute::get("/rejection_reasons/create", [RejectionReasonController::class, "create"]);
	SRoute::get("/rejection_reasons/save/{key}?", [RejectionReasonController::class, "save"]);
	SRoute::post("/rejection_reasons/save", [RejectionReasonController::class, "save"]);
	SRoute::post("/rejection_reasons/remove", [RejectionReasonController::class, "remove"]);
});

SRoute::run();