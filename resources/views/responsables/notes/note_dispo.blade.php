@inject('note','App\Models\Note')

<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between px-2 mx-3">
            <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES DES NOTES DES ELEVES EN CLASSE DE  : <b>{{$classe->nom_classe}}</b></h5>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered w-100 emploi_temps">
                <thead class="text-center">
                    <tr>
                        <th>ELEVES | MATIERES</th>
                        @if (count($matieres)>0)
                            @foreach ($matieres as $matiere)
                                <th>
                                    <p>{{$matiere->abreviation}}</p>
                                    <hr>
                                    <p class="d-flex justify-content-between">
                                        @if (count($types)>0)
                                            @foreach ($types as $type)
                                                <span>{{$type->type}}</span>
                                            @endforeach
                                        @endif
                                    </p>
                                </th>
                            @endforeach
                        @endif
                        <th>TOTAL</th>
                        <th>MOYENNE</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($eleves)>0)
                        @foreach ($eleves as $eleve)
                            <tr>
                                <td>{{$eleve->matricule}} | {{$eleve->nom}}&nbsp;{{$eleve->prenom}}</td>
                                @if (count($matieres)>0)
                                    @foreach ($matieres as $mat)
                                        <td>
                                            <p class="d-flex justify-content-between p-0 m-0">
                                                @if (count($types)>0)
                                                    @foreach ($types as $typ)
                                                        <span class="exam">{{$note->note_eleve($mat->id,$typ->id,$module_id,$eleve->id)}}</span>
                                                    @endforeach
                                                @endif
                                            </p>
                                        </td>
                                    @endforeach
                                @endif
                                <td>{{$note->total_note($eleve->id,$module_id)}}</td>
                                <td>{{$note->total_note($eleve->id,$module_id)!=null? $note->total_note($eleve->id,$module_id)/$note->somme_coeff($eleve->id,$module_id):""}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Aucun élève inscrit</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
