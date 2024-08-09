@inject('classe','App\Models\Classe' )
<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between mx-1">
            <div class="">
                <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES D'ABSCENCES DES ELEVES</h5>
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
                        <th>NOMS et PRENOMS</th>
                        <th>MATRICULE</th>
                        <th>CLASSE</th>
                        <th>DATE ABS.</th>
                        <th>HEURE ABS</th>
                        <th>MOTIFS</th>
                        <th>COURS</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($abscences)>0)
                        @foreach ($abscences as $abscence)
                            <tr>
                                <td>{{$indice++}}</td>
                                <td>{{$abscence->etudiant->nom}} &nbsp;{{$abscence->etudiant->prenom}}</td>
                                <td>{{$abscence->etudiant->matricule}}</td>
                                <td>{{$classe->classe_name($abscence->etudiant->classe_id)}}</td>
                                <td>{{date_formate($abscence->date_absence,"l d M Y")}}</td>
                                <td>{{heure_format($abscence->cour->heure_debut,'H').'h'.heure_format($abscence->cour->heure_debut,'i')}}&nbsp;à&nbsp;{{heure_format($abscence->cour->heure_fin,'H').'h'.heure_format($abscence->cour->heure_fin,'i')}}</td>
                                <td>{{$abscence->motif}}</td>
                                <td>{{$classe->matiere_name($abscence->cour->matiere_id)}}</td>
                                <td><a href="#" id="{{$abscence->id}}" class="btn btn-primary btn-sm motif_abs" title="Ajouter motif d'abscence" disabled><i class="fas fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="9">Aucun élève inscrit abscent </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
