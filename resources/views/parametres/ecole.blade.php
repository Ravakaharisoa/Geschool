@extends('layouts.app_page')
@section('contents')
	<div class="align-items-left d-flex justify-content-between align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold">Modifier nom école</h2>
		</div>
		<div>
			<a href="{{route('new_ecole')}}" id="add-ecole" class="btn btn-outline-primary"><i class="fas fa-plus mr-2"></i> Modifier nom école</a>
		</div>
	</div>
    @if(session()->has('success'))
        <div class="alert alert-success text-success text-center">
            <button type="button" class="close text-success" data-dismiss="alert">&times;</button>
            <b class="text-center">{{session()->get('success')}}</b>
        </div>
    @endif
	<div class="align-items-left align-items-md-center pt-2 pb-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped listeEcole">
                <thead class="text-center bg-primary text-white">
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Slogan</th>
                        <th>Date ouverture</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($ecoles)>0)
                        @foreach ($ecoles as $ecole)
                            <tr>
                                <td><img src="{{asset('assets/img/ecoles/'.$ecole->logo)}}" alt=""></td>
                                <td>{{$ecole->nom}}</td>
                                <td>{{$ecole->slogan}}</td>
                                <td>{{date_formate($ecole->date_ouverture,'d F Y')}}</td>
                                <td>
                                    <a href="{{route('edit_ecole',$ecole->id)}}" class="text-primary modif_ecole" title="Modifier nom école"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="text-danger suppr_ecole ml-2" id="{{$ecole->id}}" title="Supprimer école"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Aucune donnée disponible</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
	</div>
@endsection
