{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Documentos</a></li>
	  <li class="breadcrumb-item active">Termos e condições</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
               {% if(!isset($documents["download_url"]) && empty($documents)): %}
                    <h5 class="card-title">Termos e condições</h5>
                    <form name="" action="" id="termsAndConditionForm" method="POST" enctype="multipart/form-data">
                        <div class="col-sm-10">
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
                       <h5 class="card-title">Termos e condições</h5>
                       <a a href="javascript:void(0)"  data-href="{{ route('documents/terms_and_conditions/remove') }}" data-isTable="false" data-key="" class="btn btn-danger btn-small j_remove_record">Remover</a>
                    </div>
                    <iframe src="{{ $documents["download_url"] }}" width="100%" height="600px"></iframe>
                {% endif; %}
            </div>
          </div>
        </div>
      </div>
    </section>
</div><!-- End Page Title -->

<script>
$(document).ready(function() {
    $("#termsAndConditionForm").submit(function(e) {
        e.preventDefault();
        
        let submitBtn = $("#submit");
        
        let formData = new FormData();
        var file = $('#pdfFile')[0].files[0];
        formData.append("pdfFile", file);
        
        console.log(formData);
        
        $.ajax({
            url: "{{ route('documents/terms_and_conditions/save') }}",
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
                      title: "Termos e condições",
                      text: "Termos e condições salvo com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('documents/terms_and_conditions') }}";
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