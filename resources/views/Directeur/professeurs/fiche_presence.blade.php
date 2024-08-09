@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-3 pb-4">
    <div>
        <h2 class="pb-2 fw-bold"><i class="fas fa-users"></i>&nbsp;&nbsp; Fiche des présences des professeurs</h2>
    </div>
    <hr>
</div>
<div class="row my-1 mx-1 justify-content-end">
    <div class="col-md-4">
        <input type="search" class="form-control search_table" placeholder="Recherche....">
    </div>
</div>
<div class="row mx-2 my-2">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="text-center bg-primary text-white">
                <tr>
                    <th>N°</th>
                    <th>Nom et Prénom(s)</th>
                    <th>Date</th>
                    <th>Jours</th>
                    <th>Heures</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @if (count($fiches)>0)
                    @foreach ($fiches as $fiche)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$fiche->enseignant->nom}}&nbsp;{{$fiche->enseignant->prenom}}</td>
                            <td>{{date_formate($fiche->date_presence,"d M Y")}}</td>
                            <td>{{ucfirst(date_formate($fiche->date_presence,"l"))}}</td>
                            <td>{{heure_format($fiche->debut,"H")}}h{{heure_format($fiche->debut,"i")}}</td>
                            @if ($fiche->status==1)
                                <td class="text-success">Présent(e)</td>
                            @else
                                <td class="text-danger">Absente</td> 
                            @endif
                            
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
