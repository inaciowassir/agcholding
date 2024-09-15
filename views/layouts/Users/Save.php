{% extends views/layouts/Default.php %}

{% block content %}


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Utilizadores</a></li>
	  <li class="breadcrumb-item active">listar</li>
	</ol>
  </nav>
  
  <section class="section profile">
  <div class="row">
	<div class="col-xl-8">

	  <div class="card">
		<div class="card-body pt-3">
		  <!-- Bordered Tabs -->
		  <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

			<li class="nav-item" role="presentation">
			  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" role="tab" tabindex="-1">Dados do utilizador</button>
			</li>

			<li class="nav-item" role="presentation">
			  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="true" role="tab">Palavra-Passe</button>
			</li>

			<li class="nav-item" role="presentation">
			  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#data-access-authorization" aria-selected="true" role="tab">Visibilidade de dados</button>
			</li>

		  </ul>
		  <div class="tab-content pt-2">
			<div class="tab-pane fade profile-edit pt-3 active show" id="profile-edit" role="tabpanel">
			  <!-- Profile Edit Form -->
			  <form name="" action="" method="POST" id="userForm">
                	<input type="hidden" name="key" value="{{ $key }}">
                    <div class="col-sm-10">                    
                        <div class="form-floating mb-3">
                          <input type="text" name="full_name" class="form-control" id="floatingInputFullName" placeholder="Informe Nome completo" 
                          value="{% if(!empty($user[$key]['full_name'])): %} {{ trim($user[$key]['full_name']) }} {% endif %}">
                          <label for="floatingInputFullName">Nome completo</label>
                        </div>
                                            
                        <div class="form-floating mb-3">
                          <input type="text" name="mobile_number" class="form-control" id="floatingInputTelephone" placeholder="Informe Numero de telefone" 
                          value="{% if(!empty($user[$key]['mobile_number'])): %} {{ trim($user[$key]['mobile_number']) }} {% endif %}">
                          <label for="floatingInputTelephone">Numero de telefone</label>
                        </div>
             
                        <div class="form-floating mb-3">
                          <input type="text" name="email" class="form-control" id="floatingInputEmail" placeholder="Informe Email" 
                          value="{% if(!empty($user[$key]['email'])): %} {{ trim($user[$key]['email']) }} {% endif %}">
                          <label for="floatingInputEmail">Email</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                          <input type="text" name="username" class="form-control" id="floatingInputUsername" placeholder="Informe Utilizador" 
                          value="{% if(!empty($user[$key]['username'])): %} {{ trim($user[$key]['username']) }} {% endif %}">
                          <label for="floatingInputUsername">Utilizador</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingInputRole" aria-label="Seleccionar Perfil" name="role">
                                <option selected disabled>Seleccionar Perfil</option>
                                {% foreach($roles as $index => $role): %} 
                                    <option value="{{ $role['role'] }}"
                                        {% if(!empty($user[$key]['role']) && $role['role'] == $user[$key]['role']): %}
                                            {{ 'selected' }}
                                        {% endif; %}
                                    > {{ $role['role'] }} 
                                   </option>
                                {% endforeach; %}
                            </select>
                            <label for="floatingInputRole">Seleccionar Perfil</label>
                        </div>
                        
                        <div class="text-center">
                          <input type="submit" value="Salvar" class="btn btn-success" id="submit">
                        </div>
                    </div>
                </form><!-- End Profile Edit Form -->
			</div>

			<div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
				<!-- Change Password Form -->
				<form id="userPasswordForm" method="POST">
					<input type="hidden" name="key" value="{{ $key }}">
					<div class="row mb-3">
						<label for="password" class="col-md-4 col-lg-3 col-form-label">Palavra-Passe</label>
						<div class="col-md-8 col-lg-9">
							<input name="password" type="password" class="form-control" id="password">
						</div>
					</div>
					<div class="row mb-3">
						<label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Confirmar Palavra-Passe</label>
						<div class="col-md-8 col-lg-9">
							<input name="confirmPassword" type="password" class="form-control" id="confirmPassword">
						</div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success" id="submitUserPassword">Salvar</button>
					</div>
				</form><!-- End Change Password Form -->
			</div>
			
			<div class="tab-pane fade pt-3" id="data-access-authorization" role="tabpanel">
				<!-- Data Access Authorization Form -->
				<form id="dataAccessAuthorizationForm" method="POST">
					<input type="hidden" name="key" value="{{ $key }}">
					<div class="col-md-12 col-lg-12 mb-3">
					  <select class="js-multiselect-input-field" name="instituition[]" multiple style="width: 100%">
						{% foreach($employersEntity as $employerEntity): %}
							<option {% if(in_array($employerEntity["name"], $authorizedInstitutions[$key]["authorized_institution"])): %} {{ "selected" }} {% endif; %}>{{ $employerEntity["name"] }}						</option>
						{% endforeach; %}
					  </select>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-success" id="submitDataAccessAuthorizationForm">Salvar</button>
					</div>
				</form><!-- End Change Password Form -->
			</div>
		  </div><!-- End Bordered Tabs -->
		</div>
	  </div>

	</div>
  </div>
</section>
</div><!-- End Page Title -->

<script>
$(document).ready(function() {
 $('.js-multiselect-input-field').select2(
 {
	placeholder: 'Seleccionar as instituições',
	width: 'resolve',
	theme: "classic"
});
 
    $("#userForm").submit(function(e) {
        e.preventDefault();
        let userData = $(this).serialize();
        let submitBtn = $("#submit");
        
        console.log(userData);
        
        $.ajax({
            url: "{{ route('users/save') }}",
            method: "POST",
            dataType: "JSON",
            data: userData,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Utilizador",
                      text: "Utilizador salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	submitBtn.prop('disabled', false).val("Salvar");
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
    });
    
    $("#userPasswordForm").submit(function(e) {
        e.preventDefault();
        let userData = $(this).serialize();
        let submitBtn = $("#submitUserPassword");
        
        let confirmPassword = $("#confirmPassword");
        let password = $("#password");
        
        if(confirmPassword.val() == "" || password.val() == "") {
        	Swal.fire({
                      text: "Os campos s達o obrigatorios",
                      icon: "warning"
                    });
        	return false;
        }
        
        if(confirmPassword.val() !== password.val()) {
        	Swal.fire({
                      text: "As passwords n達o conferem",
                      icon: "warning"
                    });
        	return false;
        }
        
        $.ajax({
            url: "{{ route('users/saveUserPassword') }}",
            method: "POST",
            dataType: "JSON",
            data: userData,
            beforeSend: function() {
                submitBtn.prop('disabled', true).html("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Palavra-Passe",
                      text: "Palavra-Passe salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	submitBtn.prop('disabled', false).html("Salvar");
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
            	submitBtn.prop('disabled', false).html("Salvar");
              // Handle the error response
              console.error(error);
            }
        });
        
        return false;
    }); 
    
    $("#dataAccessAuthorizationForm").submit(function(e) {
        e.preventDefault();
        let userData = $(this).serialize();
        let submitBtn = $("#submitDataAccessAuthorizationForm");
        
        console.log(userData);
        
        $.ajax({
            url: "{{ route('users/saveDataAccessAuthorization') }}",
            method: "POST",
            dataType: "JSON",
            data: userData,
            beforeSend: function() {
                submitBtn.prop('disabled', true).html("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Instituições autorizadas",
                      text: "Instituições autorizadas salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	submitBtn.prop('disabled', false).html("Salvar");
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
            	submitBtn.prop('disabled', false).html("Salvar");
              // Handle the error response
              console.error(error);
            }
        });
        
        return false;
    });   
});
</script>

{% endblock %}