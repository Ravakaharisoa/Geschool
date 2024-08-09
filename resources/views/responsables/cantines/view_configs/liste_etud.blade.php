<div class="col-md-12 mx-1 my-3 pt-1">
    <div class="border border-dark w-100 p-3">
        <div class="row justify-content-between px-2 mx-3">
            <h5><i class="far fa-bell"></i>&nbsp;&nbsp;LISTES DES PAIEMENTS DE : <b>
                @if ($eleve!="")
                    {{$eleve->nom ?$eleve->nom:""}} &nbsp;{{$eleve->prenom ?$eleve->prenom:""}}
                @endif
            </b></h5>
            @if ($eleve!="")
                <button class="btn btn-success btn-sm payer_cantine" id="{{$eleve->id}}"><i class="fas fa-hand-holding-usd"></i>&nbsp;&nbsp;Payer</button>
            @endif
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>N°</th>
                        <th>JOURS</th>
                        <th>MONTANT</th>
                        <th>DATE PAIE.</th>
                    </tr>
                </thead>
                <tbody class="text-center" id="liste_paie">
                    @if (count($paiements)>0)
                        @foreach ($paiements as $paie)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{date_formate($paie->date_cantine,"D,d M Y")}}</td>
                                <td>{{nombre_format($paie->montant)}} AR</td>
                                <td>{{date_formate($paie->date_paye,"d M Y")}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Aucun paiement effectué</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
