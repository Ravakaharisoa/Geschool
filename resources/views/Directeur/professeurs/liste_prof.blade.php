@extends('layouts.app_page')
@section('contents')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold"><i class="fas fa-users"></i>&nbsp;&nbsp; Liste des professeurs disponibles</h2>
		</div>
        <hr>
	</div>
	<div class="align-items-left align-items-md-center pt-2 pb-2">
		<table class="table table-bordered table-striped ">
			<thead class="text-center bg-primary text-white">
				<tr>
					<th colspan="2">Responsable</th>
					<th>Date d'embauche</th>
                    <th>Contact</th>
                    <th>Status</th>
                    @can('isDirecteur')
                    <th></th>
                    @endcan
				</tr>
			</thead>
			<tbody class="text-center">
                @if (count($professeurs)>0)
                    @foreach ($professeurs as $prof)
                        <tr>
                            <td>
                                @if ($prof->image !=null)
                                    <img src="{{asset('assets/img/users/'.$prof->image)}}" alt="" srcset="">
                                @else
                                    <img src="{{asset('assets/img/defaultuser.png')}}" alt="" srcset="">
                                @endif
                            </td>
                            <td>{{$prof->nom." ".$prof->prenom}}<br>{{$prof->matricule}}</td>
                            <td>{{date_formate($prof->date_embauche,"d M Y")}}</td>
                            <td>{{$prof->email}}<br>{{ $prof->contact1 }}&nbsp;{{$prof->contact2 != null ? $prof->contact2:""}}</td>
                            <td>
                                @if ($prof->actif==0)
                                    <span class="badge bg-gray">Inactive</span>
                                @else
                                    <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                            @can('isDirecteur')
                                <td>
                                    @if ($prof->actif==0)
                                        <a href="#" title="Restaurer professeur" class="text-primary restaure_professeur ml-2" id="{{$prof->id}}"><i class="fas fa-reply"></i></a>
                                    @else
                                        <a href="#" title="Supprimer professeur" class="text-danger delete_professeur ml-2" id="{{$prof->id}}"><i class="fas fa-trash-alt"></i></a>
                                    @endif
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                @else
                    @can('isDirecteur')
                        <tr>
                            <td colspan="7">Aucun responsable disponible</td>
                        </tr>
                    @endcan
                    @canany(['isResponsable','isProfesseur'])
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
    <script src="{{asset('assets/js/page/main.js')}}"></script>
@endpush
