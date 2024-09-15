{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Simulador</a></li>
	  <li class="breadcrumb-item"><a href="#">Parametros</a></li>
	  <li class="breadcrumb-item active">salvar</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
            {% if(!empty($message)): %}
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            {% endif; %}            
          <div class="card">
            <div class="card-body mb-3">
                <h5 class="card-title">Parametros do simulador</h5>
                <form name="" id="parameterForm" method="POST">
                	<input type="hidden" name="key" value="{{ $key }}">
                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="minAllowedLoan" class="form-label">Emprestimo minimo</label>
                            <div class="input-group">
                                <input type="text" name="minAllowedLoan" class="form-control" id="floatingInput" placeholder="0.00" 
                                value="{% if(!empty($parameter[$key]['minAllowedLoan'])): %} {{ trim($parameter[$key]['minAllowedLoan']) }} {% endif %}">
                                <span class="input-group-text">MZN</span>
                            </div>
                        </div>
                        
                        <div class="mb-3 col-lg-6">
                            <label for="maxEffortRate" class="form-label">Taxa de esforço maximo</label>
                            <div class="input-group">
                                <input type="text" name="maxEffortRate" class="form-control" id="floatingInput" placeholder="0.00%" 
                                value="{% if(!empty($parameter[$key]['maxEffortRate'])): %} {{ trim($parameter[$key]['maxEffortRate']) }} {% endif %}">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
						<div class="mb-3 col-lg-6">
							<label for="minSimulatorLoanTerm" class="form-label">Periodo minimo</label>
							<div class="input-group">
								<input type="text" name="minSimulatorLoanTerm" value="{% if(!empty($parameter[$key]['minSimulatorLoanTerm'])): %} {{ trim($parameter[$key]['minSimulatorLoanTerm']) }} {% endif %}" class="form-control" placeholder="0">
								<span class="input-group-text">Meses</span>
							</div>
						</div>
										
						<div class="mb-3 col-lg-6">
							<label for="maxSimulatorLoanTerm" class="form-label">Periodo maximo</label>
							<div class="input-group">
								<input type="text" name="maxSimulatorLoanTerm" value="{% if(!empty($parameter[$key]['maxSimulatorLoanTerm'])): %} {{ trim($parameter[$key]['maxSimulatorLoanTerm']) }} {% endif %}" class="form-control"  class="form-control" placeholder="0">
								<span class="input-group-text">Meses</span>
							</div>
						</div>
                        
						<div class="my-4 d-flex align-items-center justify-content-between border-bottom">
							<div>
								Adicionar campos de taxa de juros por periodos
							</div>
							<button id="addLoanFieldBtn" class="btn btn-primary">Adicionar campos</button>
						</div>
						
						<div id="loanFieldsContainer" class="">
						{% if(!empty($parameter[$key]["interestRates"])): %}
							{% foreach($parameter[$key]["interestRates"] as $rates): %}
								<div class="row border-bottom my-2">
									<div class="mb-3 col-lg-4">
										<label for="minLoanTerm" class="form-label">Periodo minimo</label>
										<div class="input-group">
											<input type="text" name="minLoanTerm[]" value="{% if(!empty($rates['minLoanTerm'])): %} {{ trim($rates['minLoanTerm']) }} {% endif %}" class="form-control" placeholder="0">
											<span class="input-group-text">Meses</span>
										</div>
									</div>
													
									<div class="mb-3 col-lg-4">
										<label for="" class="form-label">Periodo maximo</label>
										<div class="input-group">
											<input type="text" name="maxLoanTerm[]" value="{% if(!empty($rates['maxLoanTerm'])): %} {{ trim($rates['maxLoanTerm']) }} {% endif %}"  class="form-control" placeholder="0">
											<span class="input-group-text">Meses</span>
										</div>
									</div>
													
									<div class="mb-3 col-lg-4">
										<label for="" class="form-label">Taxa de juros aplicada</label>
										<div class="input-group">
											<input type="text" name="interestRateApplied[]" value="{% if(!empty($rates['interestRateApplied'])): %} {{ trim($rates['interestRateApplied']) }} {% endif %}"  class="form-control" placeholder="0.00%">
											<span class="input-group-text">%</span>
										</div>
									</div>
								</div>
							{% endforeach; %}
						{% endif; %}
						</div>
                        
                        <div class="form-floating col-md-12">
                          <input type="submit" value="Salvar" class="btn btn-success" id="submit">
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</div><!-- End Page Title -->


<script>
$(document).ready(function() {
	$("#addLoanFieldBtn").click(function(e) {
		e.preventDefault();
		
		let htmlFields = `
		<div class="row border-bottom my-2">
			<div class="mb-3 col-lg-4">
				<label for="minLoanPeriod" class="form-label">Periodo minimo</label>
				<div class="input-group">
					<input type="text" name="minLoanTerm[]" class="form-control" placeholder="0">
					<span class="input-group-text">Meses</span>
				</div>
			</div>
							
			<div class="mb-3 col-lg-4">
				<label for="" class="form-label">Periodo maximo</label>
				<div class="input-group">
					<input type="text" name="maxLoanTerm[]" class="form-control" placeholder="0">
					<span class="input-group-text">Meses</span>
				</div>
			</div>
							
			<div class="mb-3 col-lg-4">
				<label for="" class="form-label">Taxa de juros aplicada</label>
				<div class="input-group">
					<input type="text" name="interestRateApplied[]" class="form-control" placeholder="0.00%">
					<span class="input-group-text">%</span>
				</div>
			</div>
		</div>`;
		
		$("#loanFieldsContainer").append(htmlFields);
	})
	
    $("#parameterForm").submit(function(e) {
        e.preventDefault();
        let data = $(this).serialize();
        let submitBtn = $("#submit");
        
        console.log(data);
        
        $.ajax({
            url: "{{ route('simulator/parameters/save') }}",
            method: "POST",
            dataType: "JSON",
            data: data,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Parametros",
                      text: "Parametros salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	submitBtn.prop('disabled', false).val("Salvar");
						location.reload();
                    });
                }
            },
            error: function(error) {
                Swal.fire({
                          title: "Oops...",
                          text: "Ocorreu um erro. " + error,
                          icon: "error"
                        });
                	submitBtn.prop('disabled', false).val("Salvar");
                  console.error(error);
                }
        });
        
        return false;
    })
});
</script>

{% endblock %}