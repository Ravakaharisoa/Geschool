@inject('cantine', 'App\Models\Cantine')

<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between px-2 mx-3">
            <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES DE LA CANTINE PAYEE PAR LA CLASSE:
                <b>{{ $classe }}</b>
            </h5>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>N°</th>
                        <th>MATRICULE</th>
                        <th>NOM et PRENOM(S)</th>
                        <th>JOUR PAYE</th>
                        <th>MONTANT</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($eleves) > 0)
                        @foreach ($eleves as $eleve)
                            <tr>
                                <td>{{ $indice++ }}</td>
                                <td>{{ $eleve->matricule }}</td>
                                <td>{{ $eleve->nom }}&nbsp;{{ $eleve->prenom }}</td>
                                <td>
                                    @foreach ($cantine->cantine_periode_eleve($eleve->id, $debut, $fin) as $value)
                                        {{ date_formate($value->date_cantine, 'D,d') . ',' }}
                                    @endforeach
                                </td>
                                <td>
                                    {{nombre_format($cantine->sum_cantine_par_eleve($eleve->id,$debut,$fin))}} AR
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">Aucun élève disponible</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
