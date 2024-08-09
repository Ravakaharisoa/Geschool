@inject('note_eleve', 'App\Models\Note')
<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between px-2 mx-3">
            <h5><i class="far fa-bell"></i>&nbsp;&nbsp; Détail de note de : <b>{{ $eleve->nom }} &nbsp;{{$eleve->prenom}}</b>&nbsp; classe de : {{$eleve->classe_annuel->nom_classe}}
            </h5>
        </div>
        <hr>
        @if (count($matieres)>0)
            <div class="table-responsive">
                <table class="table table-bordered emploi_temps">
                    <thead class="text-center">
                        <tr>
                            <th>MATIERES</th>
                            @if (count($modules)>0)
                                @foreach ($modules as $module)
                                    <th data="{{$module->id}}">
                                        <p>{{$module->trimestre}}</p>
                                        <hr>
                                        <p class="d-flex justify-content-between">
                                            @foreach ($types as $type)
                                                <span class="text-center mx-3">{{strtoupper($type->type)}}</span>
                                            @endforeach
                                            <span class="text-center">COEFF.</span>
                                        </p>
                                    </th>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($matieres as $matiere)
                            <tr>
                                <td>{{$matiere->matiere}}</td>
                                @if (count($modules)>0)
                                    @foreach ($modules as $module_value)
                                    <td>
                                        <p class="d-flex justify-content-between p-0 m-0">
                                            @foreach ($types as $exam)
                                                <span class="exam fw-bold">
                                                    {{($note_eleve->note_eleve($matiere->id,$exam->id,$module_value->id,$eleve->id))}}
                                                </span>
                                            @endforeach
                                            <span class="exam fw-bold">{{($note_eleve->coefficient_note($matiere->id,$module_value->id,$eleve->id))}}</span>
                                        <p>
                                    </td>
                                    @endforeach
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="text-center">
                        <tr>
                            <td>TOTAL DE NOTE</td>
                            @if (count($modules)>0)
                                @foreach ($modules as $value)
                                    <td>
                                        <p class="d-flex justify-content-between p-0 m-0">
                                            @foreach ($types as $exams)
                                                <span class="exam fw-bold">
                                                    {{$note_eleve->somme_note($eleve->id,$value->id,$exams->id)}}
                                                </span>
                                            @endforeach
                                            <span class="exam fw-bold">{{$note_eleve->somme_coeff($eleve->id,$value->id)}}</span>
                                        <p>
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td>MOYENNE</td>
                            @if (count($modules)>0)
                                @foreach ($modules as $values)
                                    <td>
                                        <p class="d-flex justify-content-between p-0 m-0">
                                            @php
                                                $coeff =$note_eleve->somme_coeff($eleve->id,$values->id);
                                            @endphp
                                            @foreach ($types as $examem)
                                                <span class="exam fw-bold">
                                                    @if ($note_eleve->somme_note($eleve->id,$values->id,$examem->id)!=0)
                                                        {{$note_eleve->somme_note($eleve->id,$values->id,$examem->id)/$coeff}}
                                                    @endif
                                                </span>
                                            @endforeach
                                            <span class="exam fw-bold text-danger">/20</span>
                                        <p>
                                    </td>
                                @endforeach
                            @endif
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

