@extends('layouts.app_page')
@section('contents')
    <div class="align-items-left align-items-md-center pt-3 pb-4">
		<div>
			<h2 class="pb-2 fw-bold"><i class="fas fa-calendar-minus"></i>&nbsp;&nbsp; Historique d'abscence</h2>
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
                    <th>Jour</th>
                    <th>Date d'abscence</th>
					<th>Motif</th>
                    <th>Billet d'entrée</th>
                    <th>Pièce justificative</th>
				</tr>
			</thead>
			<tbody class="text-center">
                @if (count($abscences)>0)
                    @foreach ($abscences as $abscence)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ucfirst(date_formate($abscence->date_abscence,'l'))}}</td>
                            <td>{{date_formate($abscence->date_absence,'d M Y')}}</td>
                            <td>{{$abscence->motif}}</td>
                            <td>
                                @if ($abscence->billet_entrer!=null)
                                    <a href="{{asset('assets/documents/Buillets_entree/'.$abscence->billet_entrer)}}"></a>
                                @endif
                            </td>
                            <td>
                                @if ($abscence->piece_justification!=null)
                                    <a href="{{asset('assets/documents/justification/'.$abscence->piece_justification)}}"></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">Vous êtes toujours présent(e)</td>
                    </tr>
                @endif

            </tbody>
		</table>

	</div>
@endsection
