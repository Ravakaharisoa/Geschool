@extends('layouts.app_page')
@section('contents')
	<div class="align-items-left d-flex align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold">Liste des matières disponibles</h2>
		</div>
	</div>
	<div class="align-items-left align-items-md-center pt-2 pb-2">
		<table class="table table-bordered table-striped w-75" id="listeMatiere">
			<thead class="text-center bg-primary text-white">
				<tr>
					<th>N°</th>
					<th>Matières</th>
				</tr>
			</thead>
			<tbody class="text-center">
                @if (count($matieres)>0)
                    @foreach ($matieres as $matiere)
                        <tr>
                            <td>{{$indice++}}</td>
                            <td>{{$matiere->matiere}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">Aucune matière disponible</td>
                    </tr>
                @endif
			</tbody>
		</table>

	</div>
@endsection
