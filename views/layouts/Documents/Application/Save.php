{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Documentos</a></li>
	  <li class="breadcrumb-item">Contractual</li>
	  <li class="breadcrumb-item active">Salvar</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body mb-3">
            {% if(!isset($document[$key]["download_url"]) && empty($document[$key])): %}
                <h5 class="card-title">Salvar documento</h5>
                <form name="" action="" id="applicationForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="key" value="{{ $key }}" id="key">
                    <div class="col-sm-10">
                        <div class="form-floating mb-3">
                          <input type="text" name="name" class="form-control" id="name" placeholder="Informe nome" 
                          value="{% if(!empty($document[$key]['name'])): %} {{ trim($document[$key]['name']) }} {% endif %}">
                          <label for="name">Nome</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                          <input class="form-control" type="file" id="pdfFile" name="pdfFile" accept=".pdf" required>
                          <label for="pdfFile">Anexar documento</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                          <input type="submit" value="Salvar" class="btn btn-success" id="submit">
                        </div>
                    </div>
                </form>
                {% else: %}
                    <div class="d-flex justify-content-between align-items-center py-2">
                       <h5 class="card-title">{{ $document[$key]['name'] }}</h5>
                       <a a href="javascript:void(0)"  data-href="{{ route('documents/applications/remove') }}" data-isTable="false" data-key="{{ $key }}" class="btn btn-danger btn-small j_remove_record">Remover</a>
                    </div>
                    <iframe src="{{ $document[$key]["download_url"] }}" width="100%" height="600px"></iframe>
                {% endif; %}
            </div>
          </div>
        </div>
      </div>
    </section>
</div><!-- End Page Title -->


<script>
$(document).ready(function() {
    $("#applicationForm").submit(function(e) {
        e.preventDefault();
        
        let submitBtn = $("#submit");
        
        let formData = new FormData();
        var file = $('#pdfFile')[0].files[0];
        formData.append("pdfFile", file);
        formData.append("name", $("#name").val());
        formData.append("key", $("#key").val());
        
        console.log(formData);
        
        $.ajax({
            url: "{{ route('documents/applications/save') }}",
            method: "POST",
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                submitBtn.prop('disabled', true).val("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Documento contractual",
                      text: "Documento contractual salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('documents/applications') }}";
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