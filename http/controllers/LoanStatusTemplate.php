<?php
namespace sprint\http\controllers;

trait LoanStatusTemplate{
    public function loanStatus($status) {
		$loanstatus = [
			"PENDING" => "Pendente",
			"APPROVED" => "Aprovado",
			"DISBURSED" => "Desembolsado",
			"AWAITING_DISBURSEMENT" => "Aguarda desembolso",
			"CANCELLED" => "Cancelado",
			"REJECTED" => "Rejeitado"
		];
		
		return $loanstatus[strtoupper($status)];
	}
	
	public function loanStatusColor($status) {
		$loanstatus = [
			"PENDING" => "bg-warning text-dark",
			"APPROVED" => "bg-info text-dark",
			"DISBURSED" => "bg-success",
			"AWAITING_DISBURSEMENT" => "bg-info text-dark",
			"CANCELLED" => "bg-danger",
			"REJECTED" => "bg-danger"
		];
		
		return $loanstatus[strtoupper($status)];
	}
}