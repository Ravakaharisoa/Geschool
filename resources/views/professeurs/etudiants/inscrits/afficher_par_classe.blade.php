
<div class="col-md-12 mx-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between mx-1">
            <div class="">
                <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES DES ELEVES DE LA CLASSE : <b>{{$classe}}</b></h5>
            </div>
            <div class="col-md-3">
                <input type="search" name="search_table" class="form-control search_table" placeholder="Recherche ...">
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>N°</th>
                        <th>NOMS</th>
                        <th>PRENOMS</th>
                        <th>SEXE</th>
                        <th>MATRICULE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($eleves)>0)
                        @foreach ($eleves as $eleve)
                            <tr>
                                <td>{{$indice++}}</td>
                                <td>{{$eleve->nom}}</td>
                                <td>{{$eleve->prenom}}</td>
                                <td>{{$eleve->sexe=="fille"?"Fille":"Garçon"}}</td>
                                <td>{{$eleve->matricule}}</td>
                                <td>
                                    <a href="{{route('prof.eleves.details_etudiant',$eleve->id)}}" class="text-primary" title="Détails"><i class="far fa-eye"></i></a>
                                    <a href="#" id="{{$eleve->id}}" class="text-success ajouter_note mx-1" title="Ajouter notes"><i class="fas fa-pen"></i></a>
                                    <a href="#" id="{{$eleve->id}}" class="text-danger notif_abs mx-1" title="Notifier une abscence"><i class="fas fa-user-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="9">Aucun élève inscrit</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
