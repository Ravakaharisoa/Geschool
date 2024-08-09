@inject('note_eleve', 'App\Models\Note')
<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-start px-2 mx-3">
            <a href="{{route('etudiant.notes.download',[$eleve->id,$module->id])}}" class="btn btn-danger btn-sm" title="Télécharger">
                Imprimer
            </a>
        </div>
        <hr>
        @if (count($matieres)>0)
            <div class="table-responsive">
                <table class="table table-bordered emploi_temps">
                    <thead class="text-center">
                        <tr>
                            <th>MATIERES</th>
                            @if (count($types)>0)
                                @foreach ($types as $type)
                                    <th><span class="text-center">{{strtoupper($type->type)}}</span></th>
                                @endforeach
                            @endif
                            <th>COEFFICIENT</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($matieres as $matiere)
                            <tr>
                                <td>{{$matiere->matiere}}</td>
                                @if (count($types)>0)
                                    @foreach ($types as $exam)
                                        <td>{{($note_eleve->note_eleve($matiere->id,$exam->id,$module->id,$eleve->id))}}</td>
                                    @endforeach
                                @endif
                                <td>{{($note_eleve->coefficient_note($matiere->id,$module->id,$eleve->id))}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="text-center">
                        <tr>
                            <td>TOTAL DE NOTE</td>
                            @if (count($types)>0)
                                @foreach ($types as $exams)
                                    <td>{{$note_eleve->somme_note($eleve->id,$module->id,$exams->id)}}</td>
                                @endforeach
                            @endif
                            <td>{{$note_eleve->somme_coeff($eleve->id,$module->id)}}</td>
                        </tr>
                        <tr>
                            <td>MOYENNE</td>
                            @if (count($types)>0)
                                @php
                                    $coeff =$note_eleve->somme_coeff($eleve->id,$module->id);
                                @endphp
                                @foreach ($types as $examem)
                                    <td>
                                        @if ($note_eleve->somme_note($eleve->id,$module->id,$examem->id)!=0)
                                            {{$note_eleve->somme_note($eleve->id,$module->id,$examem->id)/$coeff}}
                                        @endif
                                    </td>
                                @endforeach
                            @endif
                            <td><span class="exam fw-bold text-danger">/20</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="w-75 mx-3">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <strong>Aucune note disponible</strong>
                    <button type="button" class="close mt--2 mr-2" data-dismiss="alert">&times;</button>
                </div>
            </div>
        @endif
    </div>
</div>

