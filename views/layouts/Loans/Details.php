{% extends views/layouts/Default.php %}

{% block content %}

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Emprestimos</a></li>
	  <li class="breadcrumb-item active">{{ $status }}</li>
	</ol>
  </nav>
  
  <section class="section profile">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class="mb-3 list-group">
                  <h5 class="card-title pb-0">Dados do funcionario</h5>
                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Nome completo</strong></div>
                    <div class="col-lg-9 col-md-8"><small>{{ $employer[$key]['fullName'] }}</small></div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Entidade empregadora e Cargo</strong></div>
                    <div class="col-lg-9 col-md-8">
						<small>{{ $employer[$key]['employerEntity'] }}, {{ $employer[$key]['office'] }}</small>
					</div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Contacto</strong></div>
                    <div class="col-lg-9 col-md-8"><small>{{ $employer[$key]['phoneNumber'] }}</small></div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Rendimento mensal</strong></div>
                    <div class="col-lg-9 col-md-8"><small>{{ number_format($employer[$key]['netMonthlyIncome'], 2) }}</small></div>
                  </div>
                </div>
                <section>        
                    <h5 class="card-title pb-0">Contracto mutuo</h5>
                    {% if(!empty($customerContractualDocument)): %}
	                <div class="row">
						{% 
							$document = $customerContractualDocument[$key];
							
							$doc_createdAt = $document['createdAt'] / 1000;
							$date = new \DateTime();
							$date->setTimestamp($doc_createdAt);
							$formattedDate = $date->format('d/m/Y');
	                   %}
	                    <div class="col-lg-6">	                 
							<div class="card mb-3" style="max-width: 540px;">
							  <div class="row g-0">
								<div class="col-md-12">
									<div class="card-header d-flex justify-content-between align-items-center">
										<span class="">
											{{ $document["fileName"] }}
											{% if($document["approvedBy"] == "" && $document["rejectedBy"] != ""): %}
												<button class="btn btn-outline" data-toggle="popover" title="Motivos da rejeição: {{ $document['rejectionReasons'] }}"><i class="bi bi-question-circle"></i></button>
											{% endif; %}
										</span>
										
										{% if($document["approvedBy"] == "" && $document["rejectedBy"] == ""): %}
											<span class="badge bg-warning text-color-wite">
												Pendente
											</span>
										{% endif; %}
										
										{% if($document["approvedBy"] != "" && $document["rejectedBy"] == ""): %}
											<span class="badge bg-success text-color-wite">
												Aprovado
											</span>
										{% endif; %}
										
										{% if($document["approvedBy"] == "" && $document["rejectedBy"] != ""): %}
											<span class="badge bg-danger text-color-wite">
												Rejeitado
											</span>
										{% endif; %}
									</div>
								  <div class="card-body">
									<div class="card-text my-0">
										<div class="d-flex justify-content-between my-0">
											<p><small class="">Submetido em {{ $formattedDate }}</small></p>
											<p><small class="">{{ bytesToSize($document["fileSize"]) }}</small></p>
										</div>
									</div>
								  </div>
									<div class="card-footer">
										<a href="{{ route('/loans/details/'. $key . '/actions/contractual-document/') }}" class="btn btn-sm btn-outline-secondary">Ver documento</a>
									</div>
								</div>
							  </div>
							</div>
	                    </div>
	                </div>
	                {% else: %}
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> Nenhum documento contractual apresentado
                        </div>
	                {% endif; %}
                </section>
                
                <section>                
                    <h5 class="card-title pb-0">Documentos Pessoais (KYC)
                    	{% if(!empty($customerMissingKYCDocuments)): %}
                        	<button class="btn btn-outline" data-toggle="popover" title="Documentos pessoais em falta: {{ implode(', ', $customerMissingKYCDocuments) }}"><i class="bi bi-question-circle"></i></button>
                        {% endif; %}
                    </h5>
                    {% if(!empty($customerKYCDocuments)): %}
	                <div class="row">
	                {% foreach($customerKYCDocuments[$key] as $index => $document): %}	
	                	{%
							$doc_createdAt = $document['createdAt'] / 1000;
							$date = new \DateTime();
							$date->setTimestamp($doc_createdAt);
							$formattedDate = $date->format('d/m/Y');
							
							$approvalKYCStatus = '';
							
							$pendingKYCDocumentsKeys = array_keys($pendingKYCDocuments);
							if(in_array($index, $pendingKYCDocumentsKeys)) {
								$approvalKYCStatus = '<span class="badge bg-warning text-color-wite">
                				        		Pendente
                				        	</span>';
							}
							
							$rejectedKYCDocumentsKeys = array_keys($rejectedKYCDocuments);
							if(in_array($index, $rejectedKYCDocumentsKeys)) {
								$approvalKYCStatus = '
											<span>
												<button class="btn btn-outline" data-toggle="popover" title="Motivos da rejeição: '. $document['rejectionReason'] .'"><i class="bi bi-question-circle"></i></button>
											</span>
											<span class="badge bg-danger text-color-wite">
                				        		Rejeitado
                				        	</span>';
							}
							
							$approvedKYCDocumentsKeys = array_keys($approvedKYCDocuments);							
							if(in_array($index, $approvedKYCDocumentsKeys)) {
								$approvalKYCStatus = '<span class="badge bg-success text-color-wite">
                				        		Aprovado
                				        	</span>';
							}
						%}
	                    <div class="col-lg-6">	                 
		                    <div class="card mb-3" style="max-width: 540px;">
            				  <div class="row g-0">
            				    <div class="col-md-12">
            				        <div class="card-header d-flex justify-content-between align-items-center"> 
										{{ $document["documentType"] }}
            				        	{{ $approvalKYCStatus }}
            				        </div>
            				      <div class="card-body">
            				        <div class="card-text my-0">
            				        	<div class="d-flex justify-content-between my-0">
											<p><small class="">Submetido em {{ $formattedDate }}</small></p>
											<p><small class="">{{ bytesToSize($document["fileSize"]) }}</small></p>
										</div>
            				        </div>
            				      </div>
            				        <div class="card-footer">
            				        	<a href="{{ route('/loans/details/'. $key . '/actions/kyc-document/'.$index) }}" class="btn btn-sm btn-outline-secondary">Ver documento</a>
            				        </div>
            				    </div>
            				  </div>
            				</div>
	                    </div>
	                    {% endforeach; %}  
	                </div>
	                {% else: %}
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> Nenhum documento pessoal apresentado
                        </div>
	                {% endif; %}
                </section>                
                
                <div class="table-responsive">
                    <h5 class="card-title pb-0">
                    	Dados do emprestimo
                    	{% 
							if(
								(!empty($pendingKYCDocuments) || !empty($rejectedKYCDocuments)) 
								&& empty($loan[$key]['rejectionReason'])
							): 
						%} 
    	                        <button class="btn btn-outline" data-toggle="popover" title="Aguarda aprovação de todos documentos submetidos pelo funcionario"><i class="bi bi-question-circle"></i></button>
                        {% endif; %}
                    </h5>
                    {%
						if(
							!empty($pendingKYCDocuments) 
							|| !empty($rejectedKYCDocuments)
							|| !$isAllKYCDocumentsSubmitted
							|| !$isContractualDocumentValid
						): 
					%} 
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> A acção aprovar fica disponivel somente quando todos documentos forem subemtidos pelo funcionario e aprovados no processo de aprovação
                        </div>
                    {% endif; %}
                    
                    {% 
						if(
							$loan[$key]['approvalStatus'] === 'REJECTED' 
							&& !empty($loan[$key]['rejectedBy']) 
							&& !empty($loan[$key]['rejectionReason'])
						): 
					
					%}
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> Este emprestimo foi rejeitado, pelos motivos:
                            {% $reasons =  explode(",", $loan[$key]['rejectionReason']); %}
                            
                            <ul class="list-group list-group-numbered">
                                {% foreach($reasons as $reason): %}
                                    <li class="list-group-item">{{ $reason }}</li>
                                {% endforeach; %}
                            </ul>
                        </div>
                    {% endif; %}
                    <div class="badge {{ $statusColor }}"> {{ $status }}  </div>
        			<table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th scope="col" width="15%">Prestações</th>
                            <th scope="col" width="10%">Periodo</th>
                            <th scope="col" width="15%">Taxa de esforço</th>
                            <th scope="col" width="15%">Taxa de juros aplicada</th>
                            <th scope="col" width="15%">Emprestimo</th>
                            <th scope="col" width="15%">Desembolso</th>
                            <th scope="col" width="15%">Submetido em</th>
                          </tr>
                        </thead>
                        <tbody>                            
                            {%
                                $loanCreatedAt = $loan[$key]['createdAt'] / 1000;
                                $date = new \DateTime();
                                $date->setTimestamp($loanCreatedAt);
                                $formattedDate = $date->format('d/m/Y');
                            %}
            			  <tr>
            				<td>{{ number_format($loan[$key]['monthlyInstallment'], 2) }}</td>
            				<td>{{ $loan[$key]['loanTerms'] }} meses</td>
            				<td>{{ number_format($loan[$key]['effortRate'], 2) }} %</td>
            				<td>{{ number_format($loan[$key]['interestRate'], 2) }} %</td>
            				<td>{{ number_format($loan[$key]['requestedAmount'], 2) }}</td>
            				<td>{{ number_format($loan[$key]['totalDisbursement'], 2) }}</td>
            				<td>{{ $formattedDate }}</td>
            			  </tr>
                        </tbody>
                      </table>
                  </div>
                  <!-- End Default Table Example -->
                  {% if($loan[$key]['approvalStatus'] === 'PENDING'): %}
				  
                    <button type="button" class="btn btn-success j_approve_loan 
						{% if(
							!empty($pendingKYCDocuments) 
							|| !empty($rejectedKYCDocuments) 
							|| !$isAllKYCDocumentsSubmitted 
							|| !$isContractualDocumentValid
							): 
						%} 
							{{ 'disabled' }}
						{% endif; %}
					">Aprovar</button>
					
					
                    <button type="button" class="btn btn-danger j_reject_loan">Rejeitar</button>
                  {% endif; %}
                  
                  {% if($loan[$key]['approvalStatus'] === 'AWAITING_DISBURSEMENT'): %}
                    <button type="button" class="btn btn-success j_approve_disbursement_loan">Desembolsar</button>
                  {% endif; %}
				  
				{% if(!empty($instalments)): %}
				<div class="table-responsive">
                    <h5 class="card-title pb-0">Prestações mensais</h5>
        			<table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th scope="col" width="20%">Prestações</th>
                            <th scope="col" width="10%">Mês</th>
                            <th scope="col" width="20%">Por desembolsar</th>
                            <th scope="col" width="20%">Periodo de inicio</th>
                            <th scope="col" width="20%">Periodo de fim</th>
                            <th scope="col" width="10%">Estado</th>
                          </tr>
                        </thead>
                        <tbody>                            
                            {%
								$totalDisbursement = $loan[$key]['totalDisbursement'];
								$totalAcumulativeInstallment = 0;
								
								foreach($instalments as $index => $installment):
								
								$status = $installment["paymentStatus"] === "PENDING" 
								? '<span class="badge bg-warning">Pendente</span>' 
								: '<span class="badge bg-success">Amortizado</span>';
                            %}
							  <tr>
								<td>{{ number_format($installment['installment'], 2) }}</td>
								<td>Mês {{ $index + 1 }}</td>
								<td>{{ number_format($totalDisbursement - $totalAcumulativeInstallment, 2) }}</td>
								<td>{{ date("d/m/Y", strtotime($installment["startAt"])) }}</td>
								<td>{{ date("d/m/Y", strtotime($installment["overdueAt"])) }}</td>
								<td>{{ $status }}</td>
							  </tr>
							{% 
								$totalAcumulativeInstallment += $installment['installment'];
								endforeach; 
							%}
                        </tbody>
                      </table>
                  </div>
				{% endif; %}
            </div>
          </div>
        </div>
      </div>
    </section>
</div><!-- End Page Title -->

<div class="modal fade" id="rejectLoanForm" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Motivo de rejeição do emprestimo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          	<form id="loanRejectionReason" method="POST">
          		<select class="js-multiselect-input-field" name="reasons[]" multiple style="width: 100%">
    				{% foreach($rejectionReasons as $rejectionReason): %}
    				    {% if($rejectionReason['type'] == "Emprestimo"): %}
    					    <option value="{{ $rejectionReason['reason'] }}">{{ $rejectionReason["reason"] }}</option>
    					{% endif; %}
    				{% endforeach; %}
    			  </select>
          	</form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" id="rejectLoanButton">Salvar</button>
        </div>
      </div>
    </div>
</div><!-- End Modal-->

<style>
.card{
	box-shadow: 0px 0 7px rgba(1, 41, 112, 0.1);
	border-radius: 20px;
}
</style>
<script>
$(document).ready(function() {
    let currentSelectLoanButton;
        
	$(".j_reject_loan").click(function(e) { 
		e.preventDefault();
		
		currentSelectLoanButton= $(this);
		currentSelectLoanButton.toggleClass("disabled").html("Por favor aguarde....");
		
		Swal.fire({
		  title: "Rejeitar emprestimo",
		  text: "Deseja realmente rejeitar este emprestimo?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, rejeitar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	$("#rejectLoanForm").modal("show");
		  } else {
		      currentSelectLoanButton.toggleClass("disabled").html("Rejeitar");
		  }
		});
				
	}); 
	
	$("#rejectLoanForm").on('hide.bs.modal', function (e) {
		currentSelectLoanButton.toggleClass("disabled").html("Rejeitar");
   	 });
	
	$(".j_approve_loan").click(function(e) { 
		e.preventDefault();
		
		let $this = $(this);
		$this.addClass("disabled").html("Aprovar");
		
		Swal.fire({
		  title: "Aprovar emprestimo",
		  text: "Deseja realmente aprovar este emprestimo?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, aprovar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	executeApprovalAction(
				$this,
				"{{ route('loans/actions/approve') }}",
				"AWAITING_DISBURSEMENT",
				null,
				"Aprovar", 
				"Emprestimo aprovado com sucesso", 
				"Erro ao aprovar emprestimo"			
			);
		  } else {
		    $this.removeClass("disabled").html("Aprovar");
		  }
		});
				
	});
	
	$(".j_approve_disbursement_loan").click(function(e) { 
		e.preventDefault();
		
		let $this = $(this);
		$this.addClass("disabled").html("Desembolsar");
		
		Swal.fire({
		  title: "Desembolsar emprestimo",
		  text: "Deseja realmente desembolsar este emprestimo?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, desembolsar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	executeApprovalAction(
				$this,
				"{{ route('loans/actions/awaiting_disbursement') }}",
				"AWAITING_DISBURSEMENT",
				null,
				"Desembolsar", 
				"Emprestimo desembolsado com sucesso", 
				"Erro ao desembolsar emprestimo"			
			);
		  } else {
		    $this.removeClass("disabled").html("Desembolsar");
		  }
		});
				
	});  
	
	$("#rejectLoanButton").on("click", function(e) {
		e.preventDefault();
		
		let submitBtn = $(this);		
		let reasons = $("#loanRejectionReason select").val();
		
		executeApprovalAction(
			submitBtn,
			"{{ route('loans/actions/reject') }}",
			"REJECTED",
			reasons,
			"Rejeitar", 
			"Emprestimo rejeitado com sucesso", 
			"Erro ao rejeitar emprestimo"			
		);
	}); 
	
	function executeApprovalAction(submitBtn, url, status, reasons, buttonText, successText, errorText) {
		$.ajax({
			url: url,
			method: "POST",
			dataType: "JSON",
			data: {
				nodeKey: "{{ $key }}",
				currentStatus: status,
				reasons: reasons,
			},
			beforeSend: function() {
				submitBtn.addClass('disabled').text("Por favor aguarde...");
			},
			success: function(response, status){
				if (response.status == "success" && status == "success") {
					Swal.fire({
					  title: successText,
					  icon: "success"
					}).then(()=>{
						$("#rejectLoanForm").modal("hide");						
						location.reload();
					});
				}
			},
			complete: function() {
				submitBtn.remove('disabled').text(buttonText);
			},
			error: function(error){
				Swal.fire({
				  title: errorText,
				  icon: "error"
				});
			}
		});
	}
});
</script>

{% endblock %}