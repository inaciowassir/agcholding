{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Entidades</a></li>
	  <li class="breadcrumb-item active">salvar</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body mb-3">
                <h5 class="card-title">Salvar entidade</h5>
                <form name="" action="" id="entityForm" method="POST">
                        
                        <input type="hidden" name="key" value="{{ $key }}">
                    <div class="col-sm-10">
                        <div class="form-floating mb-3">
                          <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Informe entidade" 
                          value="{% if(!empty($entity[$key]['name'])): %} {{ trim($entity[$key]['name']) }} {% endif %}">
                          <label for="floatingInput">Entidade</label>
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
    $("#entityForm").submit(function(e) {
        e.preventDefault();
        let entityData = $(this).serialize();
        let submitBtn = $("#submit");
       
        
        $.ajax({
            url: "{{ route('institution/entities/save') }}",
            method: "POST",
            dataType: "JSON",
            data: entityData,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Entidade",
                      text: "Entidade salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('institution/entities') }}";
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