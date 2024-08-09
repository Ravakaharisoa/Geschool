@extends('layouts.app_page')

@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold">Tableau de Bord</h2>
	</div>
    <hr>
</div>
<div class="row">
	<div class="col-sm-6 col-lg-3">
		<div class="card p-3">
			<div class="d-flex justify-content-between align-items-center">
				<span class="stamp stamp-md bg-danger mr-3">
					<i class="fa fa-dollar-sign"></i>
				</span>
				<div class="text-right">
					<h5 class="mb-1"><b><a href="#">{{nombre_format($scolarite)}} AR</a></b></h5>
					<small class="text-muted">Total Scolarité</small>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3">
		<div class="card p-3">
			<div class="d-flex justify-content-between align-items-center">
				<span class="stamp stamp-md bg-success mr-3">
					<i class="fas fa-users"></i>
				</span>
				<div class="text-right">
					<h5 class="mb-1"><b><a href="#">{{$prof}} </a></b></h5>
					<small class="text-muted">{{$prof<2? "Professeur":"Professeurs"}}</small>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3">
		<div class="card p-3">
			<div class="d-flex justify-content-between align-items-center">
				<span class="stamp stamp-md bg-primary mr-3">
					<i class="fas fa-clipboard-list"></i>
				</span>
				<div class="text-right">
					<h5 class="mb-1"><b><a href="#">{{$classe}}</a></b></h5>
					<small class="text-muted">{{$classe<2?"Classe":"Classes"}}</small>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3">
		<div class="card p-3">
			<div class="d-flex justify-content-between align-items-center">
				<span class="stamp stamp-md bg-warning mr-3">
					<i class="fas fa-user-friends"></i>
				</span>
				<div class="text-right">
					<h5 class="mb-1"><b><a href="#">{{$resp}}</a></b></h5>
					<small class="text-muted">{{$resp<2? "Responsable":"Responsables"}}</small>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6 col-lg-3">
		<div class="card p-3">
			<div class="d-flex justify-content-between align-items-center">
				<span class="stamp stamp-md bg-secondary mr-3">
					<i class="fas fa-dollar-sign"></i>
				</span>
				<div class="text-right">
					<h5 class="mb-1"><b><a href="#">{{nombre_format($cantine)}} AR</a></b></h5>
					<small class="text-muted">Total Cantine</small>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3">
		<div class="card p-3">
			<div class="d-flex justify-content-between align-items-center">
				<span class="stamp stamp-md bg-info mr-3">
					<i class="fas fa-dollar-sign"></i>
				</span>
				<div class="text-right">
					<h5 class="mb-1"><b><a href="#">{{nombre_format($transport)}} AR</a></b></h5>
					<small class="text-muted">Total Transport</small>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="row my-4 justify-content-center">
    <div class="w-100">
        <div id="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var barChart = document.getElementById('barChart').getContext('2d');
            var annees =  <?php echo json_encode($anneSco); ?>;
            var nbrEtud =  <?php echo json_encode($nbrEtud); ?>;
            var myBarChart = new Chart(barChart, {
                type: 'bar',
                data: {
                    labels: annees,
                    datasets : [{
                        label: "Elèves inscrits",
                        backgroundColor: 'rgb(23, 125, 255)',
                        borderColor: 'rgb(23, 125, 255)',
                        data: nbrEtud,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    },
                }
            });
        });
    </script>
@endpush
