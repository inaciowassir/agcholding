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
  <h1>Dashboard</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Home</a></li>
	  <li class="breadcrumb-item active">Dashboard</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">
	<!-- Left side columns -->
	<div class="col-lg-12">
	  <div class="row">
		<!-- Sales Card -->
		<div class="col-xxl-4 col-md-4">
		  <div class="card info-card">
			<div class="card-body">
			  <h5 class="card-title">Pendentes</h5>

			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
				  <i class="bi bi-info-circle"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo count($pendingLoans) ?></h6>
				</div>
			  </div>
			</div>
		  </div>
		</div><!-- End Sales Card -->

		<!-- Revenue Card -->
		<div class="col-xxl-4 col-md-4">
		  <div class="card info-card">

			<div class="card-body">
			  <h5 class="card-title">Aguardam desembolso</h5>

			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info text-white">
				  <i class="bi bi-info-circle"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo count($awaitingDisbursimentLoans) ?></h6>
				</div>
			  </div>
			</div>

		  </div>
		</div><!-- End Revenue Card -->

		<!-- Revenue Card -->
		<div class="col-xxl-4 col-md-4">
		  <div class="card info-card">
			<div class="card-body">
			  <h5 class="card-title">Desembolsados</h5>

			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
				  <i class="bi bi-info-circle"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo count($disbursedLoans) ?></h6>
				</div>
			  </div>
			</div>

		  </div>
		</div><!-- End Revenue Card -->

	  </div>
	</div><!-- End Left side columns -->
	
	
	<!-- Left side columns -->
	<div class="col-lg-12">
	  <div class="row">
		<!-- Sales Card -->

		<!-- Revenue Card -->
		<div class="col-xxl-4 col-md-6">
		  <div class="card info-card">

			<div class="card-body">
			  <h5 class="card-title">Cancelados</h5>

			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
				  <i class="bi bi-info-circle"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo count($cancelledLoans) ?></h6>
				</div>
			  </div>
			</div>

		  </div>
		</div><!-- End Revenue Card -->

		<!-- Revenue Card -->
		<div class="col-xxl-4 col-md-6">
		  <div class="card info-card">
			<div class="card-body">
			  <h5 class="card-title">Rejeitados</h5>

			  <div class="d-flex align-items-center">
				<div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
				  <i class="bi bi-info-circle"></i>
				</div>
				<div class="ps-3">
				  <h6><?php echo count($rejectedLoans) ?></h6>
				</div>
			  </div>
			</div>

		  </div>
		</div><!-- End Revenue Card -->

	  </div>
	</div><!-- End Left side columns -->
	
	<div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Emprestimos Solicitados vs Desembolsados</h5>

              <!-- Column Chart -->
              <div id="columnChart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#columnChart"), {
                    series: [{
                      name: 'Solicitado',
                      data: [0, 0, 0, 0, 0, 0, 0, 0, 0]
                    }, {
                      name: 'Desembolsado',
                      data: [0, 0, 0, 0, 0, 0, 0, 0, 0]
                    }],
                    chart: {
                      type: 'bar',
                      height: 350
                    },
                    plotOptions: {
                      bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                      },
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      show: true,
                      width: 2,
                      colors: ['transparent']
                    },
                    xaxis: {
                      categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    },
                    fill: {
                      opacity: 1
                    },
                  }).render();
                });
              </script>
              <!-- End Column Chart -->

            </div>
          </div>
        </div>
  </div>
</section>

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

