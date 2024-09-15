<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AGC - Painel administrativo</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('img/favicon.png') }}" rel="icon">
  <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">

  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">

                <div class="card-body">

                  <div class="d-flex justify-content-center py-4">
                    <a href="javascript:void(0)" class="logo d-flex flex-column align-items-center w-auto">
                      <img src="{{ asset('img/logo2.jpg') }}" alt="" style="max-height: 150px;">
                      <span style="font-size: 18px; font-weight: 500" class="text-muted"><small>Seu emprestimo parceiro</small></span>
                    </a>
                  </div><!-- End Logo -->

                  <form class="row g-3 needs-validation" novalidate id="userForm">

                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <input type="text" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Informe seu email</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Senha</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Informe sua senha</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" id="submit">Entrar</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script>
$(document).ready(function() {
    $("#userForm").submit(function(e) {
        e.preventDefault();
        let userData = $(this).serialize();
        let submitBtn = $("#submit");
        
        $.ajax({
            url: "{{ route('auth/authorize') }}",
            method: "POST",
            dataType: "JSON",
            data: userData,
            beforeSend: function() {
                submitBtn.prop('disabled', true).html("Por favor aguarde...");
            },
            success: function(response, status){
                if (response.status == "success" && status == "success") {
                    Swal.fire({
                      title: "Autenticação",
                      text: "Utilizador autenticado com sucesso",
                      icon: "success"
                    }).then(function(){
                    	window.location.href = "{{ route('/') }}";
                    });
                } else if(response.status == "failed"){
                	Swal.fire({
	                      	title: "Autenticação",
	                      	text: "Erro ao autenticar. verifique suas credencias",
	                      	icon: "error"
                    	});
                    	
                    	submitBtn.prop('disabled', false).html("Entrar");
                } else if(response.status == "unauthorized") {
                	Swal.fire({
	                      	title: "Autenticação",
	                      	text: "Utilizador não autorizado",
	                      	icon: "error"
                    	});
                    	
                    	submitBtn.prop('disabled', false).html("Entrar");
                }
              // Handle the success response
              console.log(response);
            },
            error: function(error){
            
            Swal.fire({
                      title: "Autenticação",
                      text: "Ocorreu um erro. " + error,
                      icon: "error"
                    });
            	submitBtn.prop('disabled', false).html("Entrar");
              // Handle the error response
              console.error(error);
            }
        });
        
        return false;
    })
});
</script>
  
</body>

</html>