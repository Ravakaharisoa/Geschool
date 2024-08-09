@extends('layouts.app_page')
@section('contents')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold"><i class="fas fa-users"></i>&nbsp;&nbsp; Liste des camarades de classe de {{$classe}}</h2>
		</div>
        <hr>
	</div>
    <div class=" row my-2 align-items-center justify-content-end mx-1">
        <div class="col-md-3">
            <input type="search" name="search_table" class="form-control search_table" placeholder="Recherche ...">
        </div>
    </div>
	<div class="align-items-left align-items-md-center pt-2 pb-2">
		<table class="table table-bordered table-striped ">
			<thead class="text-center bg-primary text-white">
				<tr>
					<th></th>
                    <th>Matricule</th>
					<th>Nom et Prénom(s)</th>
                    <th>Sexe</th>
                    <th>Nationalité</th>
                    <th>Email</th>
                    <th>Status</th>
				</tr>
			</thead>
			<tbody class="text-center">
                @if (count($eleves)>0)
                    @foreach ($eleves as $etud)
                        <tr>
                            <td>
                                @if ($etud->photo !=null)
                                    <img src="{{asset('assets/img/users/'.$etud->photo)}}" alt="" srcset="">
                                @else
                                    <img src="{{asset('assets/img/defaultuser.png')}}" alt="" srcset="">
                                @endif
                            </td>
                            <td>{{$etud->matricule}}</td>
                            <td>{{$etud->nom." ".$etud->prenom}}</td>
                            <td>{{sexeEtudiant($etud->sexe)}}</td>
                            <td>{{$etud->nationalite}}</td>
                            <td>{{$etud->email}}</td>
                            <td>
                                @if ($etud->actif==0)
                                    <span class="badge bg-gray">Inactive</span>
                                @else
                                    <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Aucun étudaiant disponible</td>
                    </tr>
                @endif

            </tbody>
		</table>

	</div>
@endsection
