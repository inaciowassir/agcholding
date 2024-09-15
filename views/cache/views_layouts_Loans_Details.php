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
	

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Emprestimos</a></li>
	  <li class="breadcrumb-item active"><?php echo $status ?></li>
	</ol>
  </nav>
  
  <section class="section profile">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class="mb-3 list-group">
                  <h5 class="card-title pb-0">Dados do funcionario</h5>
                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Nome completo</strong></div>
                    <div class="col-lg-9 col-md-8"><small><?php echo $employer[$key]['fullName'] ?></small></div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Entidade empregadora e Cargo</strong></div>
                    <div class="col-lg-9 col-md-8">
						<small><?php echo $employer[$key]['employerEntity'] ?>, <?php echo $employer[$key]['office'] ?></small>
					</div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Contacto</strong></div>
                    <div class="col-lg-9 col-md-8"><small><?php echo $employer[$key]['phoneNumber'] ?></small></div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="col-lg-3 col-md-8 label"><strong>Rendimento mensal</strong></div>
                    <div class="col-lg-9 col-md-8"><small><?php echo number_format($employer[$key]['netMonthlyIncome'], 2) ?></small></div>
                  </div>
                </div>
                <section>        
                    <h5 class="card-title pb-0">Contracto mutuo</h5>
                    <?php if(!empty($customerContractualDocument)): ?>
	                <div class="row">
						<?php $document = $customerContractualDocument[$key];
							
							$doc_createdAt = $document['createdAt'] / 1000;
							$date = new \DateTime();
							$date->setTimestamp($doc_createdAt);
							$formattedDate = $date->format('d/m/Y'); ?>
	                    <div class="col-lg-6">	                 
							<div class="card mb-3" style="max-width: 540px;">
							  <div class="row g-0">
								<div class="col-md-12">
									<div class="card-header d-flex justify-content-between align-items-center">
										<span class="">
											<?php echo $document["fileName"] ?>
											<?php if($document["approvedBy"] == "" && $document["rejectedBy"] != ""): ?>
												<button class="btn btn-outline" data-toggle="popover" title="Motivos da rejeição: <?php echo $document['rejectionReasons'] ?>"><i class="bi bi-question-circle"></i></button>
											<?php endif; ?>
										</span>
										
										<?php if($document["approvedBy"] == "" && $document["rejectedBy"] == ""): ?>
											<span class="badge bg-warning text-color-wite">
												Pendente
											</span>
										<?php endif; ?>
										
										<?php if($document["approvedBy"] != "" && $document["rejectedBy"] == ""): ?>
											<span class="badge bg-success text-color-wite">
												Aprovado
											</span>
										<?php endif; ?>
										
										<?php if($document["approvedBy"] == "" && $document["rejectedBy"] != ""): ?>
											<span class="badge bg-danger text-color-wite">
												Rejeitado
											</span>
										<?php endif; ?>
									</div>
								  <div class="card-body">
									<div class="card-text my-0">
										<div class="d-flex justify-content-between my-0">
											<p><small class="">Submetido em <?php echo $formattedDate ?></small></p>
											<p><small class=""><?php echo bytesToSize($document["fileSize"]) ?></small></p>
										</div>
									</div>
								  </div>
									<div class="card-footer">
										<a href="<?php echo route('/loans/details/'. $key . '/actions/contractual-document/') ?>" class="btn btn-sm btn-outline-secondary">Ver documento</a>
									</div>
								</div>
							  </div>
							</div>
	                    </div>
	                </div>
	                <?php else: ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> Nenhum documento contractual apresentado
                        </div>
	                <?php endif; ?>
                </section>
                
                <section>                
                    <h5 class="card-title pb-0">Documentos Pessoais (KYC)
                    	<?php if(!empty($customerMissingKYCDocuments)): ?>
                        	<button class="btn btn-outline" data-toggle="popover" title="Documentos pessoais em falta: <?php echo implode(', ', $customerMissingKYCDocuments) ?>"><i class="bi bi-question-circle"></i></button>
                        <?php endif; ?>
                    </h5>
                    <?php if(!empty($customerKYCDocuments)): ?>
	                <div class="row">
	                <?php foreach($customerKYCDocuments[$key] as $index => $document): ?>	
	                	<?php $doc_createdAt = $document['createdAt'] / 1000;
							$date = new \DateTime();
							$date->setTimestamp($doc_createdAt);
							$formattedDate = $date->format('d/m/Y');
							
							$approvalKYCStatus = '';
							
							$pendingKYCDocumentsKeys = array_keys($pendingKYCDocuments);
							if(in_array($index, $pendingKYCDocumentsKeys)) {
								$approvalKYCStatus = '<span class="badge bg-warning text-color-wite">
                				        		Pendente
                				        	</span>';
							}
							
							$rejectedKYCDocumentsKeys = array_keys($rejectedKYCDocuments);
							if(in_array($index, $rejectedKYCDocumentsKeys)) {
								$approvalKYCStatus = '
											<span>
												<button class="btn btn-outline" data-toggle="popover" title="Motivos da rejeição: '. $document['rejectionReason'] .'"><i class="bi bi-question-circle"></i></button>
											</span>
											<span class="badge bg-danger text-color-wite">
                				        		Rejeitado
                				        	</span>';
							}
							
							$approvedKYCDocumentsKeys = array_keys($approvedKYCDocuments);							
							if(in_array($index, $approvedKYCDocumentsKeys)) {
								$approvalKYCStatus = '<span class="badge bg-success text-color-wite">
                				        		Aprovado
                				        	</span>';
							} ?>
	                    <div class="col-lg-6">	                 
		                    <div class="card mb-3" style="max-width: 540px;">
            				  <div class="row g-0">
            				    <div class="col-md-12">
            				        <div class="card-header d-flex justify-content-between align-items-center"> 
										<?php echo $document["documentType"] ?>
            				        	<?php echo $approvalKYCStatus ?>
            				        </div>
            				      <div class="card-body">
            				        <div class="card-text my-0">
            				        	<div class="d-flex justify-content-between my-0">
											<p><small class="">Submetido em <?php echo $formattedDate ?></small></p>
											<p><small class=""><?php echo bytesToSize($document["fileSize"]) ?></small></p>
										</div>
            				        </div>
            				      </div>
            				        <div class="card-footer">
            				        	<a href="<?php echo route('/loans/details/'. $key . '/actions/kyc-document/'.$index) ?>" class="btn btn-sm btn-outline-secondary">Ver documento</a>
            				        </div>
            				    </div>
            				  </div>
            				</div>
	                    </div>
	                    <?php endforeach; ?>  
	                </div>
	                <?php else: ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> Nenhum documento pessoal apresentado
                        </div>
	                <?php endif; ?>
                </section>                
                
                <div class="table-responsive">
                    <h5 class="card-title pb-0">
                    	Dados do emprestimo
                    	<?php if(
								(!empty($pendingKYCDocuments) || !empty($rejectedKYCDocuments)) 
								&& empty($loan[$key]['rejectionReason'])
							): ?> 
    	                        <button class="btn btn-outline" data-toggle="popover" title="Aguarda aprovação de todos documentos submetidos pelo funcionario"><i class="bi bi-question-circle"></i></button>
                        <?php endif; ?>
                    </h5>
                    <?php if(
							!empty($pendingKYCDocuments) 
							|| !empty($rejectedKYCDocuments)
							|| !$isAllKYCDocumentsSubmitted
							|| !$isContractualDocumentValid
						): ?> 
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> A acção aprovar fica disponivel somente quando todos documentos forem subemtidos pelo funcionario e aprovados no processo de aprovação
                        </div>
                    <?php endif; ?>
                    
                    <?php if(
							$loan[$key]['approvalStatus'] === 'REJECTED' 
							&& !empty($loan[$key]['rejectedBy']) 
							&& !empty($loan[$key]['rejectionReason'])
						): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> Este emprestimo foi rejeitado, pelos motivos:
                            <?php $reasons =  explode(",", $loan[$key]['rejectionReason']); ?>
                            
                            <ul class="list-group list-group-numbered">
                                <?php foreach($reasons as $reason): ?>
                                    <li class="list-group-item"><?php echo $reason ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="badge <?php echo $statusColor ?>"> <?php echo $status ?>  </div>
        			<table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th scope="col" width="15%">Prestações</th>
                            <th scope="col" width="10%">Periodo</th>
                            <th scope="col" width="15%">Taxa de esforço</th>
                            <th scope="col" width="15%">Taxa de juros aplicada</th>
                            <th scope="col" width="15%">Emprestimo</th>
                            <th scope="col" width="15%">Desembolso</th>
                            <th scope="col" width="15%">Submetido em</th>
                          </tr>
                        </thead>
                        <tbody>                            
                            <?php $loanCreatedAt = $loan[$key]['createdAt'] / 1000;
                                $date = new \DateTime();
                                $date->setTimestamp($loanCreatedAt);
                                $formattedDate = $date->format('d/m/Y'); ?>
            			  <tr>
            				<td><?php echo number_format($loan[$key]['monthlyInstallment'], 2) ?></td>
            				<td><?php echo $loan[$key]['loanTerms'] ?> meses</td>
            				<td><?php echo number_format($loan[$key]['effortRate'], 2) ?> %</td>
            				<td><?php echo number_format($loan[$key]['interestRate'], 2) ?> %</td>
            				<td><?php echo number_format($loan[$key]['requestedAmount'], 2) ?></td>
            				<td><?php echo number_format($loan[$key]['totalDisbursement'], 2) ?></td>
            				<td><?php echo $formattedDate ?></td>
            			  </tr>
                        </tbody>
                      </table>
                  </div>
                  <!-- End Default Table Example -->
                  <?php if($loan[$key]['approvalStatus'] === 'PENDING'): ?>
				  
                    <button type="button" class="btn btn-success j_approve_loan 
						<?php if(
							!empty($pendingKYCDocuments) 
							|| !empty($rejectedKYCDocuments) 
							|| !$isAllKYCDocumentsSubmitted 
							|| !$isContractualDocumentValid
							): ?> 
							<?php echo 'disabled' ?>
						<?php endif; ?>
					">Aprovar</button>
					
					
                    <button type="button" class="btn btn-danger j_reject_loan">Rejeitar</button>
                  <?php endif; ?>
                  
                  <?php if($loan[$key]['approvalStatus'] === 'AWAITING_DISBURSEMENT'): ?>
                    <button type="button" class="btn btn-success j_approve_disbursement_loan">Desembolsar</button>
                  <?php endif; ?>
				  
				<?php if(!empty($instalments)): ?>
				<div class="table-responsive">
                    <h5 class="card-title pb-0">Prestações mensais</h5>
        			<table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th scope="col" width="20%">Prestações</th>
                            <th scope="col" width="10%">Mês</th>
                            <th scope="col" width="20%">Por desembolsar</th>
                            <th scope="col" width="20%">Periodo de inicio</th>
                            <th scope="col" width="20%">Periodo de fim</th>
                            <th scope="col" width="10%">Estado</th>
                          </tr>
                        </thead>
                        <tbody>                            
                            <?php $totalDisbursement = $loan[$key]['totalDisbursement'];
								$totalAcumulativeInstallment = 0;
								
								foreach($instalments as $index => $installment):
								
								$status = $installment["paymentStatus"] === "PENDING" 
								? '<span class="badge bg-warning">Pendente</span>' 
								: '<span class="badge bg-success">Amortizado</span>'; ?>
							  <tr>
								<td><?php echo number_format($installment['installment'], 2) ?></td>
								<td>Mês <?php echo $index + 1 ?></td>
								<td><?php echo number_format($totalDisbursement - $totalAcumulativeInstallment, 2) ?></td>
								<td><?php echo date("d/m/Y", strtotime($installment["startAt"])) ?></td>
								<td><?php echo date("d/m/Y", strtotime($installment["overdueAt"])) ?></td>
								<td><?php echo $status ?></td>
							  </tr>
							<?php $totalAcumulativeInstallment += $installment['installment'];
								endforeach; ?>
                        </tbody>
                      </table>
                  </div>
				<?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
</div><!-- End Page Title -->

<div class="modal fade" id="rejectLoanForm" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Motivo de rejeição do emprestimo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          	<form id="loanRejectionReason" method="POST">
          		<select class="js-multiselect-input-field" name="reasons[]" multiple style="width: 100%">
    				<?php foreach($rejectionReasons as $rejectionReason): ?>
    				    <?php if($rejectionReason['type'] == "Emprestimo"): ?>
    					    <option value="<?php echo $rejectionReason['reason'] ?>"><?php echo $rejectionReason["reason"] ?></option>
    					<?php endif; ?>
    				<?php endforeach; ?>
    			  </select>
          	</form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" id="rejectLoanButton">Salvar</button>
        </div>
      </div>
    </div>
</div><!-- End Modal-->

<style>
.card{
	box-shadow: 0px 0 7px rgba(1, 41, 112, 0.1);
	border-radius: 20px;
}
</style>
<script>
$(document).ready(function() {
    let currentSelectLoanButton;
        
	$(".j_reject_loan").click(function(e) { 
		e.preventDefault();
		
		currentSelectLoanButton= $(this);
		currentSelectLoanButton.toggleClass("disabled").html("Por favor aguarde....");
		
		Swal.fire({
		  title: "Rejeitar emprestimo",
		  text: "Deseja realmente rejeitar este emprestimo?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, rejeitar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	$("#rejectLoanForm").modal("show");
		  } else {
		      currentSelectLoanButton.toggleClass("disabled").html("Rejeitar");
		  }
		});
				
	}); 
	
	$("#rejectLoanForm").on('hide.bs.modal', function (e) {
		currentSelectLoanButton.toggleClass("disabled").html("Rejeitar");
   	 });
	
	$(".j_approve_loan").click(function(e) { 
		e.preventDefault();
		
		let $this = $(this);
		$this.addClass("disabled").html("Aprovar");
		
		Swal.fire({
		  title: "Aprovar emprestimo",
		  text: "Deseja realmente aprovar este emprestimo?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, aprovar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	executeApprovalAction(
				$this,
				"<?php echo route('loans/actions/approve') ?>",
				"AWAITING_DISBURSEMENT",
				null,
				"Aprovar", 
				"Emprestimo aprovado com sucesso", 
				"Erro ao aprovar emprestimo"			
			);
		  } else {
		    $this.removeClass("disabled").html("Aprovar");
		  }
		});
				
	});
	
	$(".j_approve_disbursement_loan").click(function(e) { 
		e.preventDefault();
		
		let $this = $(this);
		$this.addClass("disabled").html("Desembolsar");
		
		Swal.fire({
		  title: "Desembolsar emprestimo",
		  text: "Deseja realmente desembolsar este emprestimo?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Sim, desembolsar!",
		  cancelButtonText: "Não",
		}).then((result) => {
		  if (result.isConfirmed) {		  
		  	executeApprovalAction(
				$this,
				"<?php echo route('loans/actions/awaiting_disbursement') ?>",
				"AWAITING_DISBURSEMENT",
				null,
				"Desembolsar", 
				"Emprestimo desembolsado com sucesso", 
				"Erro ao desembolsar emprestimo"			
			);
		  } else {
		    $this.removeClass("disabled").html("Desembolsar");
		  }
		});
				
	});  
	
	$("#rejectLoanButton").on("click", function(e) {
		e.preventDefault();
		
		let submitBtn = $(this);		
		let reasons = $("#loanRejectionReason select").val();
		
		executeApprovalAction(
			submitBtn,
			"<?php echo route('loans/actions/reject') ?>",
			"REJECTED",
			reasons,
			"Rejeitar", 
			"Emprestimo rejeitado com sucesso", 
			"Erro ao rejeitar emprestimo"			
		);
	}); 
	
	function executeApprovalAction(submitBtn, url, status, reasons, buttonText, successText, errorText) {
		$.ajax({
			url: url,
			method: "POST",
			dataType: "JSON",
			data: {
				nodeKey: "<?php echo $key ?>",
				currentStatus: status,
				reasons: reasons,
			},
			beforeSend: function() {
				submitBtn.addClass('disabled').text("Por favor aguarde...");
			},
			success: function(response, status){
				if (response.status == "success" && status == "success") {
					Swal.fire({
					  title: successText,
					  icon: "success"
					}).then(()=>{
						$("#rejectLoanForm").modal("hide");						
						location.reload();
					});
				}
			},
			complete: function() {
				submitBtn.remove('disabled').text(buttonText);
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

