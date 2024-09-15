{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Entidades empregadora</a></li>
	  <li class="breadcrumb-item active">listar</li>
	</ol> 
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body mb-3">
                <h5 class="card-title">Salvar entidade empregadora</h5>
                <form name="" action="" method="POST" id="employerEntityForm">                        
                        <input type="hidden" name="key" value="{{ $key }}">
                    <div class="col-sm-10">
                        <div class="form-floating mb-3">
                          <input type="text" name="name" class="form-control" id="name" placeholder="Informe entidade empregadora" 
                          value="{% if(!empty($employerEntity[$key]['name'])): %} {{ trim($employerEntity[$key]['name']) }} {% endif %}">
                          <label for="name">Entidade empregadora</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select class="form-select" id="branchEntity" aria-label="Seleccionar divisão" name="branchEntity">
                                <option selected disabled>Seleccionar divisão</option>
                                {% foreach($branches as $index => $branch): %} 
                                    <option value="{{ $branch['name'] }}" data-branchentityuuid="{{ $index }}"
                                        {% if($branch['name'] == $employerEntity[$key]['branchEntity']): %}
                                            {{ 'selected' }}
                                        {% endif; %}
                                    > {{ $branch['name'] }} </option>
                                {% endforeach; %}
                            </select>
                            <label for="branchEntity">Seleccionar divisão </label>
                        </div>
                        
                        <div class="form-floating">
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
    $("#employerEntityForm").submit(function(e) {
        e.preventDefault();
        
        let branchEntityUuid = $("#branchEntity").find("option:selected").data("branchentityuuid");
        
        let data = $(this).serialize() + "&branchEntityUuid=" + branchEntityUuid;
        let submitBtn = $("#submit");
        console.log(data);
        
        $.ajax({
            url: "{{ route('institution/entity_employers/save') }}",
            method: "POST",
            dataType: "JSON",
            data: data,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Entitdade empregadora",
                      text: "Entidade empregadora salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('institution/entity_employers') }}";
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