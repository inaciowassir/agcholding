{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Divisões</a></li>
	  <li class="breadcrumb-item active">salvar</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body mb-3">
                <h5 class="card-title">Salvar Divisão</h5>
                <form name="" action="" id="branchForm" method="POST">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <div class="col-sm-10">
                        <div class="form-floating mb-3">
                          <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Informe a Divisao" 
                          value="{% if(!empty($branch[$key]['name'])): %} {{ trim($branch[$key]['name']) }} {% endif %}">
                          <label for="floatingInput">Divisão</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select class="form-select" aria-label="Seleccionar Entidade" id="mainEntity" name="mainEntity">
                                <option selected disabled>Seleccionar entidade</option>
                                {% foreach($entities as $index=> $entity): %} 
                                    <option data-mainentityuuid="{{ $index}}" value="{{ $entity['name'] }}"
                                        {% if(trim($entity['name']) == trim($branch[$key]['mainEntity'])): %}
                                            {{ ' selected ' }}
                                        {% endif; %}
                                    > {{ $entity['name'] }} </option>
                                {% endforeach; %}
                            </select>
                            <label for="main_entity">Seleccionar entidade</label>
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
    $("#branchForm").submit(function(e) {
        e.preventDefault();
        
        let mainEntityUuid = $("#mainEntity").find("option:selected").data("mainentityuuid");
        
        let data = $(this).serialize() + "&mainEntityUuid=" + mainEntityUuid;
        let submitBtn = $("#submit");
        
        console.log(data);
        
        $.ajax({
            url: "{{ route('institution/branches/save') }}",
            method: "POST",
            dataType: "JSON",
            data: data,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Divisão",
                      text: "Divisão salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('institution/branches') }}";
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