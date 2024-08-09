<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
    body {
      font-size: 14px;
      letter-spacing: 0.05em;
      color: #2A2F5B;
      -moz-osx-font-smoothing: grayscale;
      -webkit-font-smoothing: antialiased;
      font-family: 'Lato', sans-serif;
      padding-top: 20px;
      margin: 0;
    }

    #page {
      width: 30%;
      display: flex;
      flex-wrap: wrap;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      margin: auto;
      padding: 15px 10px;
      border: 1px solid #ebebeb;
    }
    .fw-bold {
      font-weight: 700;
    }

    .m-1 {
      margin: .25rem !important
    }

    .mt-3,
    .my-3 {
      margin-top: 1rem !important
    }

    .pt-2,
    .py-2 {
      padding-top: .5rem !important
    }

    #page .info {
      width: 90%;
      text-align: start;
      padding: 15px;
      margin: auto;
    }

    .text-center {
      text-align: center;
    }

    hr {
      border: 0;
      border-top: 1px solid rgba(0, 0, 0, .1);
    }
  </style>
</head>

    <body>
    <section id="page">
        <div class="info">
        <h4 class="text-center fw-bold">BILLET D'AUTORISATION D'ENTREE EN CLASSE</h4>
        <p>L'élève, Nom : {{ $eleve->nom }}</p>
        <p>Prénom(s) : {{ $eleve->prenom }}</p>
        <p>Classe de : {{ $classe }}</p>
        <p>est autorisé(e) à regagner sa classe après passage du responsable.</p>
        <p>Le {{ date_formate($date,"d/m/Y") }} à {{ date_formate($date,"H") }}h{{ date_formate($date,"i") }}</p>
        <p>Signature</p><br>{{$resp->nom}}&nbsp;{{$resp->prenom}}</p>
        </div>
    </section>
    </body>

</html>
