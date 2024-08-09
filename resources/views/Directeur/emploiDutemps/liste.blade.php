@extends('layouts.app_page')
@section('contents')
@inject('cour_annuel', 'App\Models\Cour')
<div class="align-items-left align-items-md-center pt-3 pb-4">
	<div>
		<h2 class="pb-2 fw-bold"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp; Liste des emploi du temps des élèves</h2>
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
                @if (count($classes)>0)
                    @foreach ($classes as $classe)
                        <th data="{{$classe->id}}">
                            <p>{{$classe->nom_classe}}</p>
                            <hr>
                            <p class="d-flex justify-content-between">
                                @foreach ($jours as $jour)
                                <span class="{{day_color($jour->jour)}} text-center">{{long_chaine($jour->jour)}}</span>
                                @endforeach
                            </p>
                        </th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($heures as $heure)
                <tr>
                    <td>{{heure_format($heure->heure_debut,'H').'h'.heure_format($heure->heure_debut,'i')}}&nbsp;-&nbsp;{{heure_format($heure->heure_fin,'H').'h'.heure_format($heure->heure_fin,'i')}}</td>
                    @if (count($classes)>0)
                        @foreach ($classes as $class_value)
                        <td>
                            <p class="d-flex justify-content-between p-0 m-0">
                                @foreach ($jours as $day)
                                <span class="jours fw-bold">
                                    {{$cour_annuel->cours_matiere($class_value->id,$day->jour,$heure->heure_debut,$heure->heure_fin,$anne_id)}}
                                    <br>{{$cour_annuel->cours_professeur($class_value->id,$day->jour,$heure->heure_debut,$heure->heure_fin,$anne_id)}}
                                </span>
                                @endforeach
                            <p>
                        </td>
                        @endforeach
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <div class="w-75 mx-3">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>Aucun cour disponible</strong>
            <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
        </div>
    </div>
@endif
</div>
@endsection
