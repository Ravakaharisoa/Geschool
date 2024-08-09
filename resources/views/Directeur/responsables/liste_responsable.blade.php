@extends('layouts.app_page')
@section('contents')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold"><i class="fas fa-user-friends"></i>&nbsp;&nbsp; Liste des responsables disponibles</h2>
		</div>
        <hr>
	</div>
	<div class="align-items-left align-items-md-center pt-2 pb-2">
		<table class="table table-bordered table-striped ">
			<thead class="text-center bg-primary text-white">
				<tr>
					<th colspan="2">Responsable</th>
					<th>Date d'embauche</th>
					<th>Email</th>
                    <th>Contact</th>
                    <th>Status</th>
                    @can('isDirecteur')
                    <th></th>
                    @endcan
				</tr>
			</thead>
			<tbody class="text-center">
                @if (count($responsables)>0)
                    @foreach ($responsables as $resp)
                        @can('isDirecteur')
                            <tr>
                                <td><img src="{{ $resp->photo != null?asset('assets/img/users/'.$resp->photo):asset('assets/img/defaultuser.png')}}" alt=""></td>
                                <td>{{ucwords($resp->nom) ." ".ucwords($resp->prenom)}}</td>
                                <td>{{date_formate($resp->date_embauche,"d F Y")}}</td>
                                <td>{{$resp->email}}</td>
                                <td>{{$resp->contact_prim}}<br>{{$resp->contact_seco != null? $resp->contact_seco:""}}</td>
                                <td>
                                    @if ($resp->actif==1)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="text-danger suppr_resp" id="{{$resp->id}}"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endcan
                        @canany(['isResponsable', 'isEtudiant', 'isProfesseur'])
                            <tr>
                                <td><img src="{{$resp->photo != null?asset('assets/img/users/'.$resp->photo):asset('assets/img/defaultuser.png')}}" alt=""></td>
                                <td>{{ucwords($resp->nom) ." ".ucwords($resp->prenom)}}</td>
                                <td>{{date_formate($resp->date_embauche,"d F Y")}}</td>
                                <td>{{$resp->email}}</td>
                                <td>{{$resp->contact_prim}}<br>{{$resp->contact_seco != null? $resp->contact_seco:""}}</td>
                                <td>
                                    @if ($resp->actif==1)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                            </tr>
                        @endcanany
                    @endforeach
                @else
                    @can('isDirecteur')
                        <tr>
                            <td colspan="7">Aucun responsable disponible</td>
                        </tr>
                    @endcan
                    @canany(['isResponsable', 'isEtudiant', 'isProfesseur'])
                        <tr>
                            <td colspan="6">Aucun responsable disponible</td>
                        </tr>
                    @endcanany
                @endif

            </tbody>
		</table>

	</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/page/resp.js')}}"></script>
@endpush
