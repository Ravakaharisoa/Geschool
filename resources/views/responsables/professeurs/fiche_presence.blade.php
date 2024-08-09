@extends('layouts.app_page')
@section('contents')
<div class="align-items-left align-items-md-center pt-2 pb-2">
    <div>
        <h2 class="pb-2 fw-bold"><i class="fas fa-users"></i>&nbsp;&nbsp; Fiche des présences des professeurs</h2>
    </div>
    <hr>
</div>
<div class="row my-1 mx-1">
    <form id="form-ajout-presence" class="d-flex w-100">
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Professeur</label>
                <select class="form-control select2_classe" name="professeur_name" id="professeur_name">
                    <option value="" hidden selected></option>
                    @if (count($profs)>0)
                        @foreach ($profs as $prof)
                            <option value="{{$prof->id}}">{{$prof->nom}}&nbsp;{{$prof->prenom}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Date</label>
                <input type="date" class="form-control" name="date_pres" id="date_pres">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Heure d'arrivée</label>
                <input type="time" class="form-control" name="time_pres_arrive" id="time_pres_arrive">
            </div>
        </div>
        <div class="col-md-3 mt-3">
            <div class="mt-3">
                <button class="btn btn-success my-1"><i class="fas fa-check"></i>&nbsp; Enregistrer</button>
            </div>
        </div>
    </form>
</div>
<hr class="my-2">
@if (count($fiches)>0)
<div class="row mx-2 my-3 justify-content-end">
    <div class="col-md-4">
        <div class="form-group">
            <input type="search" class="form-control search_table" placeholder="Recherche...">
        </div>
    </div>
</div>
<div class="row mx-2 mt-3">
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
                @foreach ($fiches as $fiche)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$fiche->enseignant->nom}} &nbsp;{{$fiche->enseignant->prenom}}</td>
                        <td>{{date_formate($fiche->date_presence,"d M Y")}}</td>
                        <td>{{ucfirst(date_formate($fiche->date_presence,"l"))}}</td>
                        <td>{{heure_format($fiche->debut,"H")}}h{{heure_format($fiche->debut,"i")}}</td>
                        <td class="text-danger">{{$fiche->status==1?"Présent(e)":"Absente"}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
@push('scripts')
    <script src="{{asset('assets/js/page/resp.js')}}"></script>
@endpush
