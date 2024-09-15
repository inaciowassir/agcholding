{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Utilizadores</a></li>
	  <li class="breadcrumb-item active">listar</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body mb-3">
                <h5 class="card-title">Salvar perfil</h5>
                <form name="" action="" method="POST" id="userForm">     
                        <input type="hidden" name="key" value="{{ $key }}">
                    <div class="col-sm-10">
                        <div class="form-floating mb-3">
                          <input type="text" name="role" class="form-control" id="floatingInput" placeholder="Informe Perfil" 
                          value="{% if(!empty($role[$key]['role'])): %} {{ trim($role[$key]['role']) }} {% endif %}">
                          <label for="floatingInput">Perfil</label>
                        </div>
                        
                        <h5 class="card-title">Previlegios</h5>
                        <div class="col-md-8 col-lg-9">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="approveKYC" name="privileges[]" value="Aprovar documentos pessoais"
                              {% if(in_array('Aprovar documentos pessoais', $role[$key]['privileges'])): %} {{ 'checked' }}  {% endif; %}
                              >
                              <label class="form-check-label" for="approveKYC">
                                Aprovar documentos pessoais
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="approveApplicationContractsAndTermsAndConditions" name="privileges[]" value="Aprovar contracto, termos e condições"
                              {% if(in_array('Aprovar contracto, termos e condições', $role[$key]['privileges'])): %} {{ 'checked' }}  {% endif; %}
                              >
                              <label class="form-check-label" for="approveApplicationContractsAndTermsAndConditions">
                                Aprovar contracto, termos e condições
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="approveLoans"  name="privileges[]" value="Aprovar emprestimos"
                              {% if(in_array('Aprovar emprestimos', $role[$key]['privileges'])): %} {{ 'checked' }}  {% endif; %}
                              >
                              <label class="form-check-label" for="approveLoans">
                                Aprovar emprestimos
                              </label>
                            </div>
                        </div>
                        
                        <h5 class="card-title">Acessos</h5>
                        <div class="col-md-8 col-lg-9">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="webAccess" name="application_access[]" value="Painel administrativo web"
                              {% if(in_array('Painel administrativo web', $role[$key]['application_access'])): %} {{ 'checked' }}  {% endif; %}
                              >
                              <label class="form-check-label" for="webAccess">
                                Painel administrativo web
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="mobileAuthorizersAccess" name="application_access[]" value="Aplicação móvel dos autorizadores"
                                {% if(in_array('Aplicação móvel dos autorizadores', $role[$key]['application_access'])): %} {{ 'checked' }}  {% endif; %}
                              >
                              <label class="form-check-label" for="mobileAuthorizersAccess">
                                Aplicação movel dos autorizadores
                              </label>
                            </div>
                        </div>
                        
                        <div class="text-center my-3">
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $("#userForm").submit(function(e) {
        e.preventDefault();
        let userData = $(this).serialize();
        let submitBtn = $("#submit");
        
        console.log(userData);
        
        $.ajax({
            url: "{{ route('roles/save') }}",
            method: "POST",
            dataType: "JSON",
            data: userData,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Perfil",
                      text: "Perfil salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('roles') }}";
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