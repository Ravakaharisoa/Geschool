<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between px-2 mx-3">
            <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES DES PAIEMENTS DE : <b>
                @if ($eleve!="")
                    {{$eleve->nom ?$eleve->nom:""}} &nbsp;{{$eleve->prenom ?$eleve->prenom:""}}
                @endif
            </b></h5>
            @if ($eleve!="")
                <button class="btn btn-success btn-sm payer_scolarite" id="{{$eleve->id}}"><i class="fas fa-hand-holding-usd"></i>&nbsp;&nbsp;Payer</button>
            @endif
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered w-75 m-auto">
                <thead class="text-center">
                    <tr>
                        <th>N°</th>
                        <th>DATE PAIE.</th>
                        <th>MONTANT</th>
                    </tr>
                </thead>
                <tbody class="text-center" id="liste_paie">
                    @if (count($paiements)>0)
                        @foreach ($paiements as $paie)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{date_formate($paie->date_paie,"d M Y")}}</td>
                                <td class="text-right">{{nombre_format($paie->montant_paye)}} AR</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Aucun paiement effectué</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right">Total payée</td>
                        <td class="text-right"><b>{{nombre_format($totalPaye)}}</b> AR</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Total à payer</td>
                        <td class="text-right">{{nombre_format($total)}} AR</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">Reste à payer</td>
                        <td class="text-right"><b>{{nombre_format($restepaye)}} </b>AR</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
