@extends('layouts.app_page')

@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold">Tableau de Bord</h2>
	</div>
    <hr>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="text-center">
            <div class="card-title">Statistique de Scolarité</div>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-6">
        <div class="">
            <div class="alert alert-danger" role="alert">

            </div>
        </div>
    </div> --}}
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>
    <script>
         $(document).ready(function() {
            var Apayer =  <?php echo json_encode($Apayer); ?>;
            var payer =  <?php echo json_encode($payer); ?>;
            var reste =  <?php echo json_encode($reste); ?>;
            var couleurs = <?php echo json_encode($colors); ?>;
            var color =[];
            var valeur = [Apayer,payer,reste];
            var theme=['Total à payer','Total payé','Reste à payer'];
            $.each(couleurs, function(i, val) {
                color[i] = [val];
            });
            var doughnutChart = document.getElementById('doughnutChart').getContext('2d');
            var myDoughnutChart = new Chart(doughnutChart, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: valeur,
                        backgroundColor: color
                    }],

                    labels: theme
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend : {
                        position: 'bottom'
                    },
                    layout: {
                        padding: {
                            left: 20,
                            right: 20,
                            top: 20,
                            bottom: 20
                        }
                    }
                }
            });
        });
    </script>
@endpush
