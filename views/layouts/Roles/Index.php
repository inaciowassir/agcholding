{% extends views/layouts/Default.php %}

{% block content %}
<div class="pagetitle">
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="#">Perfis</a></li>
	  <li class="breadcrumb-item active">listar</li>
	</ol>
  </nav>
  
  <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class="my-3">
                <a href="javascript:void(0)" 
	                data-href="{{ route('roles/save') }}" 
	                data-create="{{ route('roles/create') }}" 
	                data-waitmessage="Por favor aguarde..."
	                data-failedmessage="Ocorreu um erro..."                	
                	class="btn btn-success j_create_db_record">Novo perfil</a>
                </div>
    			<table class="table table-sm table-striped custom-data-table">
                    <thead>
                      <tr>
                        <th scope="col" width="30%">Perfil</th>
                        <th scope="col" width="30%">Aplicação</th>
                        <th scope="col" width="30%">Previlegios</th>
                        <th scope="col">Acção</th>
                      </tr>
                    </thead>
                    <tbody>
						{% if(!empty($roles)): %}
							{% foreach($roles as $key => $role): %}
								  <tr>
									<td width="25%"><strong>{{ $role['role'] }}</strong></td>
									<td width="30%" class="small">{{ implode(", ", $role['application_access']) }}</td>
									<td width="30%" class="small">{{ implode(", ", $role['privileges']) }}</td>
									<td style="width: 150px;">
										<a href="{{ route('roles/save/'. $key) }}" class="btn btn-primary btn-small"><i class="bi bi-pencil-square"></i></a>
										<a href="javascript:void(0)"  data-href="{{ route('roles/remove') }}" data-isTable="true" data-key="{{ $key }}" class="btn btn-danger btn-small j_remove_record"><i class="bi bi-trash"></i></a>
									</td>
								  </tr>
							{% endforeach; %}
						{% endif; %}
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