{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Motivo de rejeição</a></li>
	  <li class="breadcrumb-item active">Salvar</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body mb-3">
                <h5 class="card-title">Salvar Motivo de rejeição</h5>
                <form name="" action="" method="POST" id="userForm">
                    <div class="col-sm-10">
                        <div class="form-floating mb-3">
                          <input type="text" name="reason" class="form-control" id="floatingInput" placeholder="Informe Motivo de rejeição" 
                          value="{% if(!empty($rejectionReason)): %}{{ trim($rejectionReason[$key]['reason']) }}{% endif %}">
                          <label for="floatingInput">Motivo de rejeição</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="Seleccionar tipo" name="type">
                                <option selected disabled>Seleccionar tipo</option>
                                <option value="Documento"
                                {% if(!empty($rejectionReason) && $rejectionReason[$key]['type'] == 'Documento'): %} {{ ' selected ' }} {% endif %}
                                >Documento</option>
                                <option value="Contracto"
                                {% if(!empty($rejectionReason) && $rejectionReason[$key]['type'] == 'Contracto'): %} {{ ' selected ' }} {% endif %}
                                >Contracto mutuo</option>
                                <option value="Emprestimo"
                                {% if(!empty($rejectionReason) && $rejectionReason[$key]['type'] == 'Emprestimo'): %} {{ ' selected ' }} {% endif %}
                                >Emprestimo</option>
                            </select>
                            <label for="floatingSelect">Seleccionar tipo</label>
                        </div>
                        
                        <input type="hidden" name="key" value="{{ $key }}">
                        
                        <div class="form-floating mb-3">
                          <input type="submit" value="Salvar" class="btn btn-success"id="submit">
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
    $("#userForm").submit(function(e) {
        e.preventDefault();
        let userData = $(this).serialize();
        let submitBtn = $("#submit");
        
        console.log(userData);
        
        $.ajax({
            url: "{{ route('rejection_reasons/save') }}",
            method: "POST",
            dataType: "JSON",
            data: userData,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Motivo de rejeição",
                      text: "Motivo de rejeição salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('rejection_reasons') }}";
                    });
                }
              // Handle the success response
              console.log(response);
            },
            error: function(error){
            
            Swal.fire({
                      title: "Oops...",
                      text: "Ocorreu um erro. " + error,
                      icon: "error"
                    });
            	submitBtn.prop('disabled', false).val("Salvar");
              // Handle the error response
              console.error(error);
            }
        });
        
        return false;
    })
});
</script>

{% endblock %}