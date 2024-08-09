@inject('scolarite','App\Models\Scolarite')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>classe de {{$classe->nom_classe}}</title>
    <style>
        body {
            font-size: 13px;
            letter-spacing: 0.05em;
            color: #2A2F5B;
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            font-family: 'Lato', sans-serif;
            padding: 0;
            margin: 0;
        }
        #page{
            width: 90%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin: auto;
            /* padding: px; */
        }
        .text-center{
            text-align: center;
        }
        .flex-column{
            display: flex;
            flex-direction: column;
        }
        .fw-bold{
            font-weight: 700;
        }
        .m-1 {
            margin: .25rem !important
        }
        .mt-3, .my-3 {
            margin-top: 1rem !important
        }
        .pt-2, .py-2 {
            padding-top: .5rem !important
        }
        .d-flex{
            display: flex;
            flex-direction: row;
        }
        .align-items-center {
            -ms-flex-align: center !important;
            align-items: center !important
        }
        #page .info{
            width: 100%;
        }
        hr {
            border: 0;
            border-top: 1px solid rgba(0,0,0,.1);
        }
        .table-responsive {
            width: 100% !important;
            margin: auto;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            vertical-align: middle;
        }

        .table>tbody>tr>td, .table>tbody>tr>th {
            padding: 3px;
        }

        .table>tfoot>tr>td, .table>tfoot>tr>th {
            padding: 3px;
        }

        .table thead th {
            border-bottom-width: 2px;
            font-weight: 600;
        }

        .table td, .table th {
            font-size: .9rem;
            border-top-width: 0px;
            border-bottom: 1px solid;
            border-color: #ebedf2 !important;
            padding: 0 15px !important;
            height: 30px;
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
    @can('isResponsable')
    <section id="page">
        <div class="info">
            <h4>ANNEE SCOLAIRE : {{$anne->annee_sco}}</h4>
            <h3 class="text-center">LISTE DES ELEVES DE LA CLASSE : {{$classe->nom_classe}}</h3>
        </div>
        <hr>
        <div class="info mt-3">
            <div class="table-responsive mt-3">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>NOMS et PRENOMS</th>
                            <th>SEXE</th>
                            <th>DATE DE NAIS.</th>
                            <th>MATRICULE</th>
                            <th>MALADIE</th>
                            <th>DATE D'INSCR.</th>
                            <th>CONTACT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($eleves)>0)
                            @foreach ($eleves as $eleve)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$eleve->nom}} &nbsp; {{$eleve->prenom}}</td>
                                    <td>{{$eleve->sexe=="fille"?"Fille":"Garçon"}}</td>
                                    <td>{{date_formate($eleve->date_naissance,"d/m/Y")}}</td>
                                    <td>{{$eleve->matricule}}</td>
                                    <td>{{ $eleve->maladie == 'rien' || $eleve->maladie == null ? '-' : $eleve->maladie }}</td>
                                    <td>{{date_formate($eleve->date_inscription,"d/m/Y")}}</td>
                                    <td>{{$eleve->contact_prim}}{{$eleve->contact_seco!=null?"<br>".$eleve->contact_seco:""}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Aucun élève disponible</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endcan
    @can('isDirecteur')
    <section id="page">
        <div class="info">
            <h4>ANNEE SCOLAIRE : {{$anne->annee_sco}}</h4>
            <h3 class="text-center">LISTE DES ELEVES DE LA CLASSE : {{$classe->nom_classe}}</h3>
        </div>
        <hr>
        <div class="info mt-3">
            <div class="table-responsive mt-3">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>MATRICULE</th>
                            <th>NOMS et PRENOMS</th>
                            <th>SEXE</th>
                            <th>TOTAL A PAYER</th>
                            <th>TOTAL PAYE</th>
                            <th>RESTE A PAYER</th>
                            <th>CONTACT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($eleves)>0)
                            @foreach ($eleves as $eleve)
                                <tr>
                                    <td>{{$eleve->matricule}}</td>
                                    <td>{{$eleve->nom}} &nbsp; {{$eleve->prenom}}</td>
                                    <td>{{$eleve->sexe=="fille"?"F":"G"}}</td>                                    
                                    <td>{{nombre_format($eleve->classe_annuel->montant_total)}} AR</td>
                                    <td>{{nombre_format($scolarite->total_scolarite($eleve->id))}} AR</td>
                                    <td>{{nombre_format($eleve->classe_annuel->montant_total-$scolarite->total_scolarite($eleve->id))}} AR</td>
                                    <td>{{$eleve->contact_prim}}{{$eleve->contact_seco!=null?"<br>".$eleve->contact_seco:""}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Aucun élève disponible</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endcan
</body>
</html>
