<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AGC - Painel administrativo</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo asset('img/favicon.png') ?>" rel="icon">
  <link href="<?php echo asset('img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?php echo asset('vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
  <link href="<?php echo asset('vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
  <link href="<?php echo asset('vendor/quill/quill.snow.css') ?>" rel="stylesheet">
  <link href="<?php echo asset('vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
  <link href="<?php echo asset('vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo asset('css/style.css') ?>" rel="stylesheet">
  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        $data = \sprint\ssession\SSession::get("loggedUser");
        $session_key = array_key_first($data);
        extract(reset($data), EXTR_PREFIX_ALL, "session");
    ?>
    
    <style>
    	p, div, a, span, li, ol, ul, td, th, label, input, h1, h2, h3, h4, h5, h6 {
    	  font-family: "Montserrat", sans-serif!important;
    	  font-optical-sizing: auto!important;
    	}
    	/* The Modal */
        .local-modal {
          display: block;
          position: fixed;
          z-index: 1000;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0,0,0,0.5);
        }
        
        /* Modal Content */
        .local-modal-content {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          background-color: #fff;
          padding: 20px;
          border-radius: 10px;
        }
        
        /* Loader */
        .local-loader {
          border: 16px solid #f3f3f3;
          border-top: 16px solid #3498db;
          border-radius: 50%;
          width: 80px;
          height: 80px;
          animation: spin 2s linear infinite;
          margin: 0 auto;
        }
        
        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

    </style>
    
  <!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    
    <div id="loadingModal" class="local-modal">
      <div class="local-modal-content">
        <div class="local-loader"></div>
      </div>
    </div>

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?php echo route("") ?>" class="logo d-flex align-items-center">
        <img src="<?php echo asset('img/logo.png') ?>" alt="">
        <div class="d-none d-lg-block">
            <div class="d-flex flex-column">
                <span style="font-size: 18px">Mobloan</span>
                <span style="font-size: 14px; font-weight: 500" class="text-muted"><small>Seu emprestimo parceiro</small></span>
            </div>
        </div>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://i2.wp.com/futureiot.tech/wp-content/themes/jnews-child/avatar.png?ssl=1" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $session_full_name ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="">
            <li class="dropdown-header">
              <h6><?php echo $session_email ?></h6>
              <span><?php echo $session_role ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo route('users/save/'. $session_key) ?>">
                <i class="bi bi-person"></i>
                <span>Meu perfil</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Precisa de ajuda?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo route('auth/logout') ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sair</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?php echo route("") ?>">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

	  <!-- <li class="nav-heading">Emprestimos</li> -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Emprestimos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo route('loans/pending') ?>">
              <i class="bi bi-circle"></i><span>Pendentes</span>
            </a>
          </li>
          <li>
            <a href="<?php echo route('loans/awaiting_disbursement') ?>">
              <i class="bi bi-circle"></i><span>Aguarda desembolso</span>
            </a>
          </li>          </li>
          <li>
            <a href="<?php echo route('loans/disbursed') ?>">
              <i class="bi bi-circle"></i><span>Desembolsados</span>
            </a>
          </li>

          <li>
            <a href="<?php echo route('loans/cancelled') ?>">
              <i class="bi bi-circle"></i><span>Cancelados</span>
            </a>
          </li>
          <li>
            <a href="<?php echo route('loans/rejected') ?>">
              <i class="bi bi-circle"></i><span>Rejeitados</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->
	  
      <li class="nav-heading">CONFIGURAÇÕES</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo route('users') ?>">
          <i class="bi bi-person"></i>
          <span>Utilizadores</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo route('roles') ?>">
          <i class="bi bi-question-circle"></i>
          <span>Perfis</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

	<li class="nav-heading">ADMINISTRAÇÃO</li>
      <!-- <li class="nav-heading">Emprestimos</li> -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#instituition-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Instituições</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="instituition-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo route('institution/entities') ?>">
              <i class="bi bi-circle"></i><span>Entidades</span>
            </a>
          </li>
          <li>
            <a href="<?php echo route('institution/branches') ?>">
              <i class="bi bi-circle"></i><span>Divisões</span>
            </a>
          </li>
          <li>
            <a href="<?php echo route('institution/entity_employers') ?>">
              <i class="bi bi-circle"></i><span>Entidade empregadora</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#documents-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Documentos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="documents-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo route('documents/terms_and_conditions') ?>">
              <i class="bi bi-circle"></i><span>Termos e condições</span>
            </a>
          </li> 
          <li>
            <a href="<?php echo route('documents/kyc') ?>">
              <i class="bi bi-circle"></i><span>KYC</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#simulator-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Simulador</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="simulator-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo route('simulator/parameters') ?>">
              <i class="bi bi-circle"></i><span>Parametros</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo route('rejection_reasons') ?>">
          <i class="bi bi-file-earmark"></i>
          <span>Motivos de rejeição</span>
        </a>
      </li><!-- End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
	
<div class="pagetitle">
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Emprestimos</a></li>
			<li class="breadcrumb-item"><a href="#">Aprovação de documentos</a></li>
			<li class="breadcrumb-item active"><?php echo $document['documentType'] ?></li>
		</ol>
	</nav>
  
	<section class="section profile">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header my-2">
						<?php if( 
								$document['approvalStatus'] === "PENDING"
							): ?>
						  <button type="button" class="btn btn-success j_approve_document">Aprovar</button>
						  <button type="button" class="btn btn-danger j_reject_document">Rejeitar</button>
					  <?php endif; ?>
					</div>
					<div class="card-body">
						<iframe src="<?php echo $document['downloadUrl'] ?>" width="100%" height="900px"></iframe>
					</div>
				</div>	
			</div>	
		</div>	
	</section>	
</div>

<div class="modal fade" id="rejectDocumentForm" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Motivo de rejeição do documento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          	<form id="documentRejectionReason" method="POST">
          		<input type="hidden" name="nodeKey" value="<?php echo $key ?>">
          		<select class="js-multiselect-input-field" name="reasons[]" multiple style="width: 100%">
    				<?php foreach($rejectionReasons as $rejectionReason): ?>
						<?php if($document['documentType'] === "Contracto mutuo"): ?>
							<?php if($rejectionReason['type'] == "Contracto"): ?>
								<option value="<?php echo $rejectionReason['reason'] ?>"><?php echo $rejectionReason["reason"] ?></option>
							<?php endif; ?>
						<?php else: ?>	
							<?php if($rejectionReason['type'] == "Documento"): ?>
								<option value="<?php echo $rejectionReason['reason'] ?>"><?php echo $rejectionReason["reason"] ?></option>
							<?php endif; ?>
    					<?php endif; ?>
    				<?php endforeach; ?>
    			  </select>
          	</form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="button" class="btn btn-secondary" id="approveDocumentButton" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" id="rejectDocumentButton">Salvar</button>
        </div>
      </div>
    </div>
</div><!-- End Modal-->

<script>
$(document).ready(function() {
        
    let currentSelectedDocumentButton; 
	
	$(".j_reject_document").click(function(e) { 
		e.preventDefault();
		
		currentSelectedDocumentButton = $(this);
		currentSelectedDocumentButton.toggleClass("disabled").html("Por favor aguarde....");
		
		Swal.fire({
		  title: "Rejeitar documento",
		  text: "Deseja realmente rejeitar este documento?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, rejeitar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	$("#rejectDocumentForm").modal("show");
		  } else {
		    currentSelectedDocumentButton.toggleClass("disabled").html("Rejeitar");
		  }
		});
				
	}); 
	
	$("#rejectDocumentForm").on('hide.bs.modal', function (e) {
		currentSelectedDocumentButton.toggleClass("disabled").html("Rejeitar");
   	 });
	
	$("#rejectDocumentButton").on("click", function(e) {
		e.preventDefault();
		
		let submitBtn = $(this);		
		let reasons = $("#documentRejectionReason select").val();
		
		executeApprovalAction(
			submitBtn,
			"<?php echo route('loans/documents/actions/reject') ?>", 
			reasons, 
			"Rejeitar", 
			"Documento rejeitado com sucesso", "Erro ao rejeitar documento"
		);
	});
	
	$(".j_approve_document").click(function(e) { 
		e.preventDefault();
		
		currentSelectedDocumentButton = $(this);
		currentSelectedDocumentButton.toggleClass("disabled").html("Por favor aguarde....");
		
		Swal.fire({
		  title: "Aprovar documento",
		  text: "Deseja realmente aprovar este documento?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, aprovar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	executeApprovalAction(
				$("#approveDocumentButton"),
				"<?php echo route('loans/documents/actions/approve') ?>", 
				null, 
				"Aprovar", 
				"Documento aprovado com sucesso", "Erro ao aprovar documento"
			);
		  } else {
		    currentSelectedDocumentButton.toggleClass("disabled").html("Aprovar");
		  }
		});
				
	});
	
	function executeApprovalAction(submitBtn, url, reasons, buttonText, successText, errorText) {
		$.ajax({
			url: url,
			method: "POST",
			dataType: "JSON",
			data: {
				nodeKey: "<?php echo $index ?>",
				parentNodeKey: "<?php echo $key ?>",
				documentType: "<?php echo $document['documentType'] ?>",
				reasons: reasons
			},
			beforeSend: function() {
				submitBtn.toggleClass('disabled').text("Por favor aguarde...");
			},
			success: function(response, status){
				if (response.status == "success" && status == "success") {
					Swal.fire({
					  title: successText,
					  icon: "success"
					}).then(()=>{
						$("#rejectDocumentForm").modal("hide");						
						$(location).attr("href", "<?php echo route('loans/details/') ?>/<?php echo $key ?>");
					});
				}
			},
			complete: function() {
				submitBtn.toggleClass('disabled').text(buttonText);
			},
			error: function(error){
				Swal.fire({
				  title: errorText,
				  icon: "error"
				});
			}
		});
	}
});
</script>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Groupo AGC</span></strong>. Todos direitos reservados
    </div>
    <div class="credits">
      Desenvolvido por <a href="#">fulldomain</a>
    </div>
  </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
    

  <!-- Vendor JS Files -->
  <script src="<?php echo asset('vendor/apexcharts/apexcharts.min.js') ?>"></script>
  <script src="<?php echo asset('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?php echo asset('vendor/chart.js/chart.umd.js') ?>"></script>
  <script src="<?php echo asset('vendor/echarts/echarts.min.js') ?>"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo asset('vendor/php-email-form/validate.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo asset('js/main.js') ?>"></script>
  
  <script>
        // Hide modal when the window finishes loading
        window.addEventListener('load', function() {
            document.getElementById('loadingModal').style.display = 'none';
        });
  
  
       $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
      let table = new DataTable('.custom-data-table');
      
      $(".j_create_db_record").click(function(e) {
        e.preventDefault();
        $this = $(this);
        
        let url = $this.data("create");
        let href = $this.data("href");
        let waitMessage = $this.data("waitmessage");
        let failedMessage = $this.data("failedmessage");
        
        $.ajax(
            {
                url: url,
                method: "GET",
                dataType: "JSON",
                beforeSend: function() {
                	$this.toggleClass("disabled").html(waitMessage);
                },
                success: function(response, status){
                    if(response.status == "success" && status == "success") {
                    	let redirectTo =  href + "/" + response.key;                    	
                        window.location.href = redirectTo;
                    }
                },
                error: function(){
                	Swal.fire({
			  icon: "error",
			  title: "Oops...",
			  text: failedMessage,
			});
                }
            }
        )
    });
    
    $(document).on("click",".j_remove_record",function(e) {
    	e.preventDefault();
        $this = $(this);
        
        let url = $this.data("href");
        let isTable = $this.data("isTable");
    	
    	Swal.fire({
	  title: "Remover registo",
	  text: "Deseja realmente remover o registo seleccionado?",
	  icon: "warning",
	  showCancelButton: true,
	  confirmButtonColor: "#3085d6",
	  cancelButtonColor: "#d33",
	  confirmButtonText: "Sim, remover!",
	  cancelButtonText: "Não",
	}).then((result) => {
	  if (result.isConfirmed) {
	  	$.ajax({
	  		url: url,
	  		method: "POST",
	  		dataType: "JSON",
	  		data: {
	  			node: $this.data("key"),
	  		},
	  		success: function(response, status) {
	  			if(response.status == "success" && status == "success")
	  			{
				    Swal.fire({
				      title: "Remover registo",
				      text: "Registo removido com sucesso",
				      icon: "success"
				    }).then((result) => {
				    	if(isTable == "true") {
					    	var row = $this.closest('tr');
						var rowData = table.row(row).data();
						var recordId = rowData[0];
						
						table.row(row).remove().draw();
				    		
				    	}else {
				    		location.reload();				    		
				    	}
				    });
		                }
	  		},
	  		error: function() {
	  			
	  		}
	  		
	  	});
	  }
	});
    	
    });
 });

  </script>

</body>

</html>

