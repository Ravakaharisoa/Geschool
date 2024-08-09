@extends('layouts.app_page')
@section('contents')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold"><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp; Liste des paiements de transports scolaires</h2>
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
					<th>N°</th>
                    <th>Mois</th>
					<th>Montant</th>
                    <th>Date de paiement</th>
				</tr>
			</thead>
			<tbody class="text-center">
                @if (count($transports)>0)
                    @foreach ($transports as $transport)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ucfirst(date_formate($transport->mois,'M Y'))}}</td>
                            <td>{{nombre_format($transport->montant)}} AR</td>
                            <td>{{date_formate($transport->date_payement,'d M Y')}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Vous n'avez pas encore payé des transports</td>
                    </tr>
                @endif

            </tbody>
		</table>

	</div>
@endsection
