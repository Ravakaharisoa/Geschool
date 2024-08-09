<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Professeur;
use App\Models\Responsable;
use App\Models\AnneeScoActuel;
use App\Models\Matiere;
use App\Models\Abscence;
use App\Models\AnneeScolaire;
use App\Models\Cantine;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Cour;
use App\Models\Scolarite;
use App\Models\Transport;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        $anne_id = AnneeScoActuel::value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            $title = "";
            $countProf =Professeur::where('actif',1)->count();
            $countEleve =Eleve::where('actif',1)->where('annee_scolaire_id',$anne_id)->count();
            $countResp = Responsable::where('actif',1)->count();
            if (Gate::allows('isDirecteur')) {
                $classes = Classe::orderBy('nom_classe','asc')->get();
                $eleveInscrits = Eleve::where('annee_scolaire_id',$anne_id)->get();
                $eleves_id = [];
                foreach ($eleveInscrits as $inscrit) {
                    array_push($eleves_id,$inscrit->id);
                }
                $scolarite = Scolarite::whereIn('eleve_id',$eleves_id)->sum('montant_paye');
                $classe = Classe::count();
                $cantine = Cantine::whereIn('eleve_id',$eleves_id)->sum('montant');
                $transport = Transport::whereIn('eleve_id',$eleves_id)->sum('montant');
                $anneSco = [];
                $nbrEtud = [];
                $annees = AnneeScolaire::orderBy('annee_sco','asc')->get();
                foreach ($annees as $annee) {
                    $countEtud = Eleve::where('annee_scolaire_id',$annee->id)->count();
                    array_push($anneSco,$annee->annee_sco);
                    array_push($nbrEtud,$countEtud);
                }
                $data = [
                    "title"=>$title,
                    "prof"=>$countProf,
                    "etud"=>$countEleve,
                    "resp"=>$countResp,
                    "scolarite"=>$scolarite,
                    "cantine"=>$cantine,
                    "classe"=>$classe,
                    "transport"=>$transport,
                    "anneSco"=>$anneSco,
                    "nbrEtud"=>$nbrEtud
                ];
                return view('Directeur.accueil_admin',$data);

            } elseif(Gate::allows('isResponsable')) {
                $resp = Responsable::where('user_id',$user_id)->first();
                if ($resp->cin !=null && $resp->nationalite !=null && $resp->photo != null) {
                    $garcon = Eleve::where('actif',1)->where('sexe','Garcon')->where('annee_scolaire_id',$anne_id)->count();
                    $fille = Eleve::where('actif',1)->where('sexe','Fille')->where('annee_scolaire_id',$anne_id)->count();
                    $classe =Classe::count();
                    $inscrits = Eleve::take(10)->with('classe_annuel')->orderBy('id','desc')->get();
                    $abscences= Abscence::whereBetween('date_absence',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->count();
                    $data = [
                        "title"=>$title,
                        "prof"=>$countProf,
                        "etud"=>$countEleve,
                        'fille'=>$fille,
                        'garcon'=>$garcon,
                        'classe'=>$classe,
                        'inscrits'=>$inscrits,
                        'abscences'=>$abscences,
                        'indice'=>1
                    ];
                    return view('responsables.accueil_resp',$data);
                } else {
                    $data = [
                        'title'=>$title,
                        'resp'=>$resp,
                    ];
                    return view('responsables.profile.infos', $data);
                }
            }elseif(Gate::allows('isProfesseur')){
                $prof = Professeur::where('user_id',$user_id)->first();
                if ($prof->cin !=null && $prof->nationalite !=null && $prof->image != null) {
                    
                    $user_id = Auth::id();
                    $dayNow = ucfirst(Carbon::parse(Now())->locale('fr')->dayName);
                    $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
                    $prof_id = Professeur::where('user_id', $user_id)->value('id');
                    $cours = Cour::where('annee_scolaire_id', $anne_id)->where('jour',$dayNow)->with('matiere')->with('professeur')->get();
                    $jour = Cour::where('annee_scolaire_id', $anne_id)->where('jour',$dayNow)->first();
                    $classes = Classe::orderBy('nom_classe', 'desc')->get();
                    $heures = Cour::select('heure_debut', 'heure_fin')->where('annee_scolaire_id', $anne_id)->orderBy('heure_debut', 'asc')->distinct()->get();
                    $data = [
                        'title'=> $title,
                        'cours' => $cours,
                        'classes' => $classes,
                        'jour' => $jour,
                        'heures' => $heures,
                        'anne_id' => $anne_id,
                        'dayNow' => $dayNow
                    ];
                    // dd($data);
                    return view('professeurs.accueil',$data);
                } else {
                    $data = [
                        'title'=>$title,
                        'prof'=>$prof
                    ];
                    return view('professeurs.information', $data);
                }
            }else{
                $etud = Eleve::where('user_id',$user_id)->where('annee_scolaire_id',$anne_id)->first();
                if ($etud->photo !=null ) {
                    $Apayer = Classe::where('id',$etud->classe_id)->value('montant_total');
                    $payer = Scolarite::where('eleve_id',$etud->id)->sum('montant_paye');
                    $reste = $Apayer -$payer;
                    $colors = ['#f3545d','#fdaf4b','#1d7af3'];
                    $data = [
                        'title'=>$title,
                        'colors'=>$colors,
                        'Apayer'=>$Apayer,
                        'payer'=>$payer,
                        'reste'=>$reste
                    ];
                    return view('etudiants.acceuil',$data);
                } else {
                    $data = [
                        'title'=>$title,
                        'etud'=>$etud
                    ];
                    return view('etudiants.info', $data);
                }
            }
        } else {
            return view('auth.verify');
        }
    }

    public function profile()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        $anne_id = AnneeScoActuel::value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            $title = "";
            if (Gate::allows('isDirecteur')) {
                $data =[
                    'title'=>$title
                ];
                return view('Directeur.profiles.profile_directeur',$data);
            } elseif(Gate::allows('isResponsable')) {
                $data =[
                    'title'=>$title,
                    'resp'=>Responsable::where('user_id',$user_id)->first()
                ];
                return view('responsables.profile.resp_profile',$data);
            }elseif(Gate::allows('isProfesseur')){
                $prof =Professeur::where('user_id',$user_id)->first();
                $fonctions = Cour::where('professeur_id',$prof->id)->get();
                $matiere_id = [];
                foreach ($fonctions as $fonction) {
                    array_push($matiere_id,$fonction->matiere_id);
                }
                $data =[
                    'title'=>$title,
                    'prof'=> $prof,
                    'matieres'=> Matiere::whereIn('id',$matiere_id)->get()
                ];
                return view('professeurs.profiles.prof_profile',$data);
            }else{
                $etud = Eleve::where('user_id',$user_id)->with('classe_annuel')->first();
                $data =[
                    'title'=>$title,
                    'etud'=> $etud,
                ];
                return view('etudiants.profiles.profile_etud',$data);
            }
        } else {
            return view('auth.verify');
        }
    }
}
