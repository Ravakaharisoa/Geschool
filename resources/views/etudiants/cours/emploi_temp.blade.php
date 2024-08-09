@extends('layouts.app_page')
@section('contents')
@inject('cour_annuel', 'App\Models\Cour')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp; Emploi du temps de la classe <strong></strong></h2>
	</div>
    <hr>
</div>
<div class="row py-3 mx-1">
    @if (count($cours)>0)
<div class="table-responsive">
    <table class="table table-bordered emploi_temps">
        <thead class="text-center">
            <tr>
                <th>Heures</th>
                @foreach ($jours as $jour)
                <th><span class="{{day_color($jour->jour)}} text-center">{{ucfirst($jour->jour)}}</span></th>
                @endforeach
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($heures as $heure)
                <tr>
                    <td>{{heure_format($heure->heure_debut,'H').'h'.heure_format($heure->heure_debut,'i')}}&nbsp;-&nbsp;{{heure_format($heure->heure_fin,'H').'h'.heure_format($heure->heure_fin,'i')}}</td>
                    @foreach ($jours as $day)
                    <td>
                        {{$cour_annuel->cours_matiere($classe->id,$day->jour,$heure->heure_debut,$heure->heure_fin,$anne_id)}}
                        <br>{{$cour_annuel->cours_professeur($classe->id,$day->jour,$heure->heure_debut,$heure->heure_fin,$anne_id)}}
                    </td>
                    @endforeach

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <div class="w-75 mx-3 m-auto">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>Aucun cour disponible</strong>
            <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
        </div>
    </div>
@endif
</div>
@endsection
