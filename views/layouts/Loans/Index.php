{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Emprestimos</a></li>
	  <li class="breadcrumb-item active">{{ $status }}</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
    			<table class="table table-sm table-striped custom-data-table">
                    <thead>
                      <tr>
                        <th scope="col" width="25%">Funcionario</th>
                        <th scope="col" width="15%">Prestações</th>
                        <th scope="col" width="10%">Periodo</th>
                        <th scope="col" width="15%">Taxa de esforço</th>
                        <th scope="col" width="15%">Emprestimo</th>
                        <th scope="col" width="15%">Desembolso</th>
                        <th scope="col">Acção</th>
                      </tr>
                    </thead>
                    <tbody>
			{% foreach($loans as $key => $loan): %}
			  <tr>
				<td>{{ $employer['fullName'] }}</td>
				<td>{{ number_format($loan['monthlyInstallment'], 2) }}</td>
				<td>{{ $loan['loanTerms'] }} meses</td>
				<td>{{ number_format($loan['effortRate'], 2) }} %</td>
				<td>{{ number_format($loan['requestedAmount'], 2) }}</td>
				<td>{{ number_format($loan['totalDisbursement'], 2) }}</td>
				<td>
				    <a href="{{ route('loans/details/'. $key) }}" class="btn btn-primary btn-small"><i class="bi bi-eye"></i></a>
				</td>
			  </tr>
			{% endforeach; %}
                    </tbody>
                  </table>
                  <!-- End Default Table Example -->
            </div>
          </div>
        </div>
      </div>
    </section>
</div><!-- End Page Title -->

{% endblock %}