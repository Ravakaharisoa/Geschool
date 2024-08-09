@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp; Statistique du paiement de scolarité</h2>
	</div>
    <hr>
</div>
<div class="row mx-3">
    <div class="col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center px-3">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-danger bubble-shadow-small">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers w-100 text-right">
                            <p class="card-category">TOTAL DU JOUR</p>
                            <h4 class="card-title">{{nombre_format($totalJour)}} AR</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center px-3">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers w-100 text-right">
                            <p class="card-category">TOTAL A PAYER</p>
                            <h4 class="card-title">{{nombre_format($total)}} AR</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center px-3">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers w-100 text-right">
                            <p class="card-category">TOTAL PAYEE</p>
                            <h4 class="card-title">{{nombre_format($totalPaye)}} AR</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center px-3">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-warning bubble-shadow-small">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="col col-stats ml-3 ml-sm-0">
                        <div class="numbers w-100 text-right">
                            <p class="card-category">RESTE A PAYER</p>
                            <h4 class="card-title">{{nombre_format($restePaye)}} AR</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
