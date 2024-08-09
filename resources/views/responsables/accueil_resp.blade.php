@extends('layouts.app_page')

@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold">Tableau de Bord</h2>
	</div>
    <hr>
</div>
<div class="row align-items-center mx-1">
    <div class="dashboard-resp">
        <div class="card p-3 card-dash">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stamp stamp-md bg-success mr-3">
                    <i class="fas fa-users"></i>
                </span>
                <div class="text-right">
                    <h5 class="mb-1"><b><a href="#">{{$etud}}</a></b></h5>
                    <small class="text-muted">{{$etud>1?"Inscrits":"Inscrit"}}</small>
                </div>
            </div>
        </div>
        <div class="card p-3 card-dash">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stamp stamp-md bg-info mr-3">
                    <i class="fas fa-male"></i>
                </span>
                <div class="text-right">
                    <h5 class="mb-1"><b><a href="#">{{$garcon}}</a></b></h5>
                    <small class="text-muted">{{$garcon>1?"Garçons":"Garçon"}}</small>
                </div>
            </div>
        </div>
        <div class="card p-3 card-dash">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stamp stamp-md bg-danger mr-3">
                    <i class="fas fa-female"></i>
                </span>
                <div class="text-right">
                    <h5 class="mb-1"><b><a href="#">{{$fille}}</a></b></h5>
                    <small class="text-muted">{{$fille>1?"Filles":"Fille"}}</small>
                </div>
            </div>
        </div>
        <div class="card p-3 card-dash">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stamp stamp-md bg-primary mr-3">
                    <i class="fas fa-user-friends"></i>
                </span>
                <div class="text-right">
                    <h5 class="mb-1"><b><a href="#">{{$prof}}</a></b></h5>
                    <small class="text-muted">{{$prof>1?'Professeurs':'Professeur'}}</small>
                </div>
            </div>
        </div>
        <div class="card p-3 card-dash">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stamp stamp-md bg-warning mr-3">
                    <i class="fas fa-tablet"></i>
                </span>
                <div class="text-right">
                    <h5 class="mb-1"><b><a href="#">{{$classe}}</a></b></h5>
                    <small class="text-muted">{{$classe>1?"Classes":"Classe"}}</small>
                </div>
            </div>
        </div>
        <div class="card p-3 card-dash">
            <div class="d-flex justify-content-between align-items-center">
                <span class="stamp stamp-md bg-secondary mr-3">
                    <i class="fas fa-user-minus"></i>
                </span>
                <div class="text-right">
                    <h5 class="mb-1"><b><a href="#">{{$abscences}}</a></b></h5>
                    <small class="text-muted">Abscences</small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-2 mx-1">
    <div class="border border-dark w-100 p-3">
        <div class="pl-2">
            <h5><i class="far fa-bell"></i>&nbsp;&nbsp;10 DERNIERS ELEVES INSCRITS</h5>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>NOMS</th>
                        <th>PRENOMS</th>
                        <th>MATRICULE</th>
                        <th>SEXE</th>
                        <th>DATE NAI.</th>
                        <th>CLASSE</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($inscrits)>0)
                        @foreach ($inscrits as $eleve)
                            <tr>
                                <td>{{$indice++}}</td>
                                <td>{{$eleve->nom}}</td>
                                <td>{{$eleve->prenom}}</td>
                                <td>{{$eleve->matricule}}</td>
                                <td>{{$eleve->sexe}}</td>
                                <td>{{$eleve->date_naissance}}</td>
                                <td>{{$eleve->classe_annuel->nom_classe}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
