@inject('transport', 'App\Models\Transport')

<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between px-2 mx-3">
            <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES DE PAIEMENT DU TRANSPORT PAR LA CLASSE:
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
                        <th>LIBELLE</th>
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
                                <td>{{ date_formate($debut, 'M Y')}}</td>
                                <td>
                                    {{nombre_format($transport->sum_transport_par_eleve($eleve->id,$debut))}} AR
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
