<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8">
    <style>
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        a,a:hover{
            text-decoration: none;
            color: #fff !important;
        }
        .btn-success {
            background: #31CE36 !important;
            border-color: #31CE36 !important;

        }

        .btn-success:hover, .btn-success:focus, .btn-success:disabled {
            background: #31CE36 !important;
            border-color: #31CE36 !important;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="col-md-9 m-auto">
        <div class="card card-invoice">
            <div class="card-body">
                <div class="row">
                    <p>Bonjour {{userFullName()}},</p>
                    <p>Nous devons vérifier votre adresse e-mail avant que vous puissiez accéder à l'application.<strong>Ge-School</a></strong> </p>
                    <p>Tout d’abord, vous devez compléter votre inscription en cliquant sur le bouton ci-dessous :</p>
                        <a class="btn btn-success" href="{{ $action }}">Vérifier email</a>.
                    <p>Ce lien permettra de vérifier votre adresse e-mail, et vous serez alors officiellement membre de la communauté <b>Ge-School</b><br><br>
                        A bientôt !
                    </p>
                    <p>
                        Cordialement,L’équipe du <strong>Ge-School</strong>
                    </p>
                    <br><br>
                    <em>Si vous ne parvenez pas à cliquer sur le bouton "Vérifier l'adresse e-mail", copiez et collez l'URL ci-dessous dans votre navigateur Web :</em>
                    <p>{{$action}}</p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
