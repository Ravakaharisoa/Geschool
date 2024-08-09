<?php
	use Illuminate\Support\Str;
    use Carbon\Carbon;

	function setMenuClass($route,$classe)
	{
	    $routeActuel = request()->route()->getName();
	    if (contains($routeActuel,$route)) {
	       return $classe;
	    }
	    return "";
	}

	function routeName($route,$classe)
	{
		$routeActuel = request()->route()->getName();
		if ($routeActuel === "anneeScol" || $routeActuel === "matiere" || $routeActuel === "ecole" || $routeActuel == "classe" || $routeActuel === "module" || $routeActuel == "new_ecole" || $routeActuel=="edit_ecole") {
	       return $classe;
	    }
	    return "d-none";
	}

	function setMenuActive($route)
	{
	   $routeActuel = request()->route()->getName();
	   if ($routeActuel === $route) {
	     return "active";
	   }
	   return "";
	}

	function contains($container,$contenu)
	{
	   return Str::contains($container,$contenu);
	}

	function userFullName()
	{
		return Auth()->user()->name;
	}

	function userImage()
	{
		return Auth()->user()->photo;
	}

	function getRoleName(){
		$roleName = Auth()->user()->role;
		return $roleName->role_user;
	}

    function date_formate($date,$format){
        return Carbon::parse($date)->translatedFormat($format);
    }

    function heure_format($heure,$format){
        return Carbon::createFromFormat('H:i:s',$heure)->format($format);
    }

    function nombre_format($nombre)
    {
        return number_format($nombre,0,","," ");
    }

    function long_chaine($chaine)
    {
        return strtoupper(substr($chaine,0,3));
    }

    function jours_de_la_semaine($jour)
    {
        switch ($jour) {
            case "Lundi":
                return 1;
                break;
            case "Mardi":
                return 2;
                break;
            case "Mercredi":
                return 3;
                break;
            case "Jeudi":
                return 4;
                break;
            case "Vendredi":
                return 5;
                break;
            case "Samedi":
                return 6;
                break;
            case "Dimanche":
                return 7;
                break;
        }
    }

    function day_color($jour)
    {
        switch ($jour) {
            case "Lundi":
                return 'text-danger';
                break;
            case "Mardi":
                return 'text-primary';
                break;
            case "Mercredi":
                return 'text-success';
                break;
            case "Jeudi":
                return 'text-warning';
                break;
            case "Vendredi":
                return 'text-info';
                break;
            case "Samedi":
                return 'text-secondary';
                break;
            case "Dimanche":
                return 'text-black';
                break;
        }
    }

    function convert_number($nombre){
        $fonction = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT );
        return $fonction->format($nombre);
    }

    function observation($note)
    {
        if ($note<10) {
            return "Votre moyenne est insuffisante donc vous devez faire un effort l'année scolaire prochaine!";
        } else {
            if ($note>=10 && $note<12) {
                return "Vous êtes admis en classe supérieure avec mention passable!" ;
            }elseif ($note>=12 && $note<14) {
                return "Vous êtes admis en classe supérieure avec mention assez-bien!" ;
            }elseif ($note>=14 && $note<16) {
                return "Vous êtes admis en classe supérieure avec mention bien!" ;
            } else {
                return "Vous êtes admis en classe supérieure avec mention très bien!" ;
            }
        }
    }

    function sexeEtudiant($sexe){
        if ($sexe =="garcon") {
            return "Garçon";
        }elseif ($sexe =="fille") {
            return "Fille";
        } else {
            return "Autre";
        }
    }
