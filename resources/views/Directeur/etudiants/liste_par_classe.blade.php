@inject('scolarite','App\Models\Scolarite')
<div class="col-md-12">
    <div class="ml-2">
        <a class="btn btn-danger" href="{{route('admin.eleves.imprimer_listes',$classe_id)}}"><i class="fas fa-print"></i>&nbsp;&nbsp;Imprimer</a>
    </div>
</div>
<div class="col-md-12 mx-1 my-3 pt-1">
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
                        <th>DATE INSC.</th>
                        <th>TOTAL A PAYER</th>
                        <th>TOTAL PAYE</th>
                        <th>RESTE A PAYER</th>
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
                                <td>{{date_formate($eleve->date_inscription,"d M Y")}}</td>
                                <td>{{nombre_format($eleve->classe_annuel->montant_total)}} AR</td>
                                <td>{{nombre_format($scolarite->total_scolarite($eleve->id))}} AR</td>
                                <td>{{nombre_format($eleve->classe_annuel->montant_total-$scolarite->total_scolarite($eleve->id))}} AR</td>
                                <td><a href="{{route('admin.eleves.admin.detail',$eleve->id)}}" class="text-primary">Détails</a></td>
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
