{% extends views/layouts/Default.php %}

{% block content %}
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
				  <h6>{{ count($pendingLoans) }}</h6>
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
				  <h6>{{ count($awaitingDisbursimentLoans) }}</h6>
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
				  <h6>{{ count($disbursedLoans) }}</h6>
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
				  <h6>{{ count($cancelledLoans) }}</h6>
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
				  <h6>{{ count($rejectedLoans) }}</h6>
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
{% endblock %}