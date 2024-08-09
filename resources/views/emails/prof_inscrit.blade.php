<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="{{asset('assets/css/email.css')}}">
</head>
<body>
    <div class="col-md-9 m-auto">
        <div class="card card-invoice">
            <div class="card-body">
                <div class="row">
                    <p>Bonjour {{$data['sexe']." ".$data['name']}},</p>
                    <p><strong>Félicitations!</strong>votre compte est activé. <br></p>
                    <p>Vous pouvez maintenant accéder à l'application<strong><a href="{{url('http://localhost:8000/')}}">Ge-School</a></strong> </p>
                    <p>Etant que professeur de <strong>Ge-School</strong>, vous pouvez vous connecter en tant que: <br>
                        - Nom: <b>{{$data['name']}} </b><br>
                        - Adresse email: <b>{{$data['email']}}</b> <br>
                        - Mot de passe : <b>{{$data['password']}}</b>
                    </p>

                    <p>Vos informations sont modifiable dans votre profile !<br><br>
                        Merci d'avoir utilisé <a href="{{url('http://localhost:8000/')}}">Ge-School</a>
                    </p>
                    <p>
                        Cordialement,
                    </p>
                    <p>
                        L’équipe du <strong>Ge-School</strong> <br>
                        {{$data['directeur']->name}}
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
