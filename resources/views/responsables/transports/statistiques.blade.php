@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp; Détails des paiements du transport scolaire</h2>
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
                            <h4 class="card-title">{{nombre_format($totalDay)}} AR</h4>
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
                            <p class="card-category">TOTAL DE LA SEMAINE</p>
                            <h4 class="card-title">{{nombre_format($totalweek)}} AR</h4>
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
                            <p class="card-category">PAIEMENT MENSUELLE</p>
                            <h4 class="card-title">{{nombre_format($totalMonths)}} AR</h4>
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
                            <p class="card-category">TOTAL DU MOIS</p>
                            <h4 class="card-title">{{nombre_format($totalMonth)}} AR</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-2 mx-3">
    <div class="alert alert-info alert-dismissible w-100" role="alert">
        <strong>Pour afficher les détails du transport payée, vous devez choisir les dates et la classe des élèves</strong>
        <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
    </div>
</div>
<div class="row my-2 mx-3">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Mois de :</label>
            <input type="month" name="mois_debut" class="form-control" id="mois_debuts">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Classe :</label>
            <select name="classe" id="classe" class="form-control">
                <option hidden selected>Choix</option>
                @if (count($classes)>0)
                    @foreach ($classes as $classe)
                        <option value="{{$classe->id}}">{{$classe->nom_classe}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <button class="btn btn-success mt-4 btn-block" id="affiche_details" >Afficher les détails</button>
        </div>
    </div>
</div>
<div class="row my-2 mx-3" id="liste_details_transport">

</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/page/paie.js')}}"></script>
@endpush
