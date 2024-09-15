{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Emprestimos</a></li>
			<li class="breadcrumb-item"><a href="#">Aprovação de documentos</a></li>
			<li class="breadcrumb-item active">{{ $document['documentType'] }}</li>
		</ol>
	</nav>
  
	<section class="section profile">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header my-2">
						{%
							if( 
								$document['approvalStatus'] === "PENDING"
							): 
						
						%}
						  <button type="button" class="btn btn-success j_approve_document">Aprovar</button>
						  <button type="button" class="btn btn-danger j_reject_document">Rejeitar</button>
					  {% endif; %}
					</div>
					<div class="card-body">
						<iframe src="{{ $document['downloadUrl'] }}" width="100%" height="900px"></iframe>
					</div>
				</div>	
			</div>	
		</div>	
	</section>	
</div>

<div class="modal fade" id="rejectDocumentForm" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Motivo de rejeição do documento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          	<form id="documentRejectionReason" method="POST">
          		<input type="hidden" name="nodeKey" value="{{ $key }}">
          		<select class="js-multiselect-input-field" name="reasons[]" multiple style="width: 100%">
    				{% foreach($rejectionReasons as $rejectionReason): %}
						{% if($document['documentType'] === "Contracto mutuo"): %}
							{% if($rejectionReason['type'] == "Contracto"): %}
								<option value="{{ $rejectionReason['reason'] }}">{{ $rejectionReason["reason"] }}</option>
							{% endif; %}
						{% else: %}	
							{% if($rejectionReason['type'] == "Documento"): %}
								<option value="{{ $rejectionReason['reason'] }}">{{ $rejectionReason["reason"] }}</option>
							{% endif; %}
    					{% endif; %}
    				{% endforeach; %}
    			  </select>
          	</form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="button" class="btn btn-secondary" id="approveDocumentButton" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" id="rejectDocumentButton">Salvar</button>
        </div>
      </div>
    </div>
</div><!-- End Modal-->

<script>
$(document).ready(function() {
        
    let currentSelectedDocumentButton; 
	
	$(".j_reject_document").click(function(e) { 
		e.preventDefault();
		
		currentSelectedDocumentButton = $(this);
		currentSelectedDocumentButton.toggleClass("disabled").html("Por favor aguarde....");
		
		Swal.fire({
		  title: "Rejeitar documento",
		  text: "Deseja realmente rejeitar este documento?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, rejeitar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	$("#rejectDocumentForm").modal("show");
		  } else {
		    currentSelectedDocumentButton.toggleClass("disabled").html("Rejeitar");
		  }
		});
				
	}); 
	
	$("#rejectDocumentForm").on('hide.bs.modal', function (e) {
		currentSelectedDocumentButton.toggleClass("disabled").html("Rejeitar");
   	 });
	
	$("#rejectDocumentButton").on("click", function(e) {
		e.preventDefault();
		
		let submitBtn = $(this);		
		let reasons = $("#documentRejectionReason select").val();
		
		executeApprovalAction(
			submitBtn,
			"{{ route('loans/documents/actions/reject') }}", 
			reasons, 
			"Rejeitar", 
			"Documento rejeitado com sucesso", "Erro ao rejeitar documento"
		);
	});
	
	$(".j_approve_document").click(function(e) { 
		e.preventDefault();
		
		currentSelectedDocumentButton = $(this);
		currentSelectedDocumentButton.toggleClass("disabled").html("Por favor aguarde....");
		
		Swal.fire({
		  title: "Aprovar documento",
		  text: "Deseja realmente aprovar este documento?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, aprovar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	executeApprovalAction(
				$("#approveDocumentButton"),
				"{{ route('loans/documents/actions/approve') }}", 
				null, 
				"Aprovar", 
				"Documento aprovado com sucesso", "Erro ao aprovar documento"
			);
		  } else {
		    currentSelectedDocumentButton.toggleClass("disabled").html("Aprovar");
		  }
		});
				
	});
	
	function executeApprovalAction(submitBtn, url, reasons, buttonText, successText, errorText) {
		$.ajax({
			url: url,
			method: "POST",
			dataType: "JSON",
			data: {
				nodeKey: "{{ $index }}",
				parentNodeKey: "{{ $key }}",
				documentType: "{{ $document['documentType'] }}",
				reasons: reasons
			},
			beforeSend: function() {
				submitBtn.toggleClass('disabled').text("Por favor aguarde...");
			},
			success: function(response, status){
				if (response.status == "success" && status == "success") {
					Swal.fire({
					  title: successText,
					  icon: "success"
					}).then(()=>{
						$("#rejectDocumentForm").modal("hide");						
						$(location).attr("href", "{{ route('loans/details/') }}/{{ $key }}");
					});
				}
			},
			complete: function() {
				submitBtn.toggleClass('disabled').text(buttonText);
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