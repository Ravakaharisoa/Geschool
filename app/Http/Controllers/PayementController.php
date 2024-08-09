<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AnneeScoActuel;
use App\Models\AnneeScolaire;
use App\Models\Responsable;
use App\Models\Transport;
use App\Models\Eleve;
use App\Models\Ecole;
use App\Models\Classe;
use App\Models\Cantine;
use App\Models\Scolarite;
use App\Models\User;
use Carbon\Carbon;

class PayementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function payement()
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classes =Classe::orderBy('nom_classe','asc')->get();
                $data = [
                    'title'=>"",
                    'classes'=>$classes
                ];
                return view('responsables.cantines.payement',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function select_matricule(Request $req)
    {
        if (Gate::allows('isResponsable') || Gate::allows('isProfesseur')){
            $anne_id = AnneeScoActuel::where('id',1)->value('annee_scolaire_id');
            $eleve = Eleve::where('annee_scolaire_id',$anne_id)->where('classe_id',$req->classe_id)->get();
            return response()->json($eleve);
        }
    }

    public function afficher_eleves(Request $req)
    {
        if (Gate::allows('isResponsable')){
            if ($req->etud_id==null) {
                $eleve=0;
                $paiements = [];
            } else {
                $eleve = Eleve::find($req->etud_id);
                $paiements = Cantine::where('eleve_id',$req->etud_id)->orderBy('date_cantine','asc')->get();
            }
            $data =[
                'eleve'=>$eleve,
                'paiements'=>$paiements,
                'i'=>1
            ];
            return view('responsables.cantines.view_configs.liste_etud',$data);
        }
    }

    public function form_payer(Request $req)
    {
       if (Gate::allows('isResponsable')){
            $eleve = Eleve::find($req->eleve_id);
            $data =[
                'eleve'=>$eleve,
                'i'=>1
            ];
            return view('responsables.cantines.view_configs.form_payer',$data);
        }
    }

    public function enregitrer_payement(Request $req)
    {
        if (Gate::allows('isResponsable')){
            $dateNow = date('Y-m-d');
            $cantineExist = Cantine::where('date_cantine',$req->date)->where('eleve_id',$req->etud_id)->count();
            if ($cantineExist>0) {
                $eleve =Eleve::where('id',$req->etud_id)->first();
                $message = "La cantine de ".$eleve->nom." ".$eleve->prenom." en ce date est déjà payé!";
                $icon ="error";
            } else {
                $cantine = new Cantine();
                $cantine->date_cantine=$req->date;
                $cantine->date_paye=$dateNow;
                $cantine->montant=$req->montant;
                $cantine->eleve_id=$req->etud_id;
                $saveCantine = $cantine->save();
                if($saveCantine){
                    $message = "Paiement enregistré avec succès!";
                    $icon="success";
                }else {
                    $message = "Veuillez réessayer!!";
                    $icon="error";
                }
            }
            $data =[
                'icon'=>$icon,
                'message'=>$message
            ];
            return response()->json($data);
        }
    }

    public function statistique()
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $date = date('Y-m-d');
                $totalweek = Cantine::whereBetween('date_paye', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('montant');
                $totalMonth =Cantine::whereBetween('date_paye',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('montant');
                $totalDay =Cantine::where('date_paye', $date)->sum('montant');
                $totaSem = Cantine::whereBetween('date_cantine', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('montant');
                $totalMois =Cantine::whereBetween('date_cantine',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('montant');
                $totalJour =Cantine::where('date_cantine', $date)->sum('montant');
                $classes =Classe::orderBy('nom_classe','asc')->get();
                $data = [
                    'title'=>"",
                    'totalDay'=>$totalDay,
                    'totalweek'=>$totalweek,
                    'totalMonth'=>$totalMonth,
                    'totalJour'=>$totalJour,
                    'totaSem'=>$totaSem,
                    'totalMois'=>$totalMois,
                    'classes'=>$classes
                ];
                return view('responsables.cantines.statistique',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function afficher_details_cantine(Request $req)
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $anne_id = AnneeScoActuel::where('id',1)->value('annee_scolaire_id');
                $eleves = Eleve::where('classe_id',$req->classes)->where('annee_scolaire_id',$anne_id)->get();
                $classe = Classe::where('id',$req->classes)->value('nom_classe');
                $data = [
                    'title'=>"",
                    'eleves'=>$eleves,
                    'debut'=>$req->date_debut,
                    'fin'=>$req->date_fin,
                    'classe'=>$classe,
                    'indice'=>1
                ];
                return view('responsables.cantines.view_configs.liste_cantine',$data);
            }else {
                return view('auth.verify');
            }
        }
    }

    public function transport_scolaire()
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classes =Classe::orderBy('nom_classe','asc')->get();
                $data = [
                    'title'=>"",
                    'classes'=>$classes
                ];
                return view('responsables.transports.trans_scolaire',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function afficher_transport_eleve(Request $req)
    {
        if (Gate::allows('isResponsable')){
            if ($req->etud_id==null) {
                $eleve=0;
                $paiements = [];
            } else {
                $eleve = Eleve::find($req->etud_id);
                $paiements = Transport::where('eleve_id',$req->etud_id)->orderBy('mois','asc')->get();
            }
            $data =[
                'eleve'=>$eleve,
                'paiements'=>$paiements,
                'i'=>1
            ];
            return view('responsables.transports.config_trans.liste_eleve',$data);
        }
    }
    public function form_payer_transport(Request $req)
    {
        if (Gate::allows('isResponsable')){
            $eleve = Eleve::find($req->eleve_id);
            $data =[
                'eleve'=>$eleve,
                'i'=>1
            ];
            return view('responsables.transports.config_trans.form_payer',$data);
        }
    }

    public function enregitrer_transport(Request $req)
    {
        if (Gate::allows('isResponsable')){
            $dateNow = date('Y-m-d');
            $transportExist = Transport::where('mois',$req->mois)->where('eleve_id',$req->etud_id)->count();
            if ($transportExist>0) {
                $eleve =Eleve::where('id',$req->etud_id)->first();
                $message = "Le frais de transport de ".$eleve->nom." ".$eleve->prenom." en ce mois est déjà payé!";
                $icon ="error";
            } else {
                $transport = new Transport();
                $transport->mois=$req->mois;
                $transport->date_payement=$dateNow;
                $transport->montant=$req->montant;
                $transport->eleve_id=$req->etud_id;
                $saveTransport = $transport->save();
                if($saveTransport){
                    $message = "Paiement enregistré avec succès!";
                    $icon="success";
                }else {
                    $message = "Veuillez réessayer!!";
                    $icon="error";
                }
            }
            $data =[
                'icon'=>$icon,
                'message'=>$message
            ];
            return response()->json($data);
        }
    }

    public function statistique_transport()
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $date = date('Y-m-d');
                $month = date_formate($date,"m");
                $totalweek = Transport::whereBetween('date_payement', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('montant');
                $totalMonth =Transport::whereBetween('date_payement',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->sum('montant');
                $totalMonths =Transport::where('mois', 'like', '%'.$month)->sum('montant');
                $totalDay =Transport::where('date_payement', $date)->sum('montant');
                $classes =Classe::orderBy('nom_classe','asc')->get();
                $data = [
                    'title'=>"",
                    'totalDay'=>$totalDay,
                    'totalweek'=>$totalweek,
                    'totalMonth'=>$totalMonth,
                    'totalMonths'=> $totalMonths,
                    'classes'=>$classes
                ];
                return view('responsables.transports.statistiques',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function transport_details(Request $req)
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $anne_id = AnneeScoActuel::where('id',1)->value('annee_scolaire_id');
                $eleves = Eleve::where('classe_id',$req->classes)->where('annee_scolaire_id',$anne_id)->get();
                $classe = Classe::where('id',$req->classes)->value('nom_classe');
                $data = [
                    'title'=>"",
                    'eleves'=>$eleves,
                    'debut'=>$req->mois_debut,
                    'classe'=>$classe,
                    'indice'=>1
                ];
                return view('responsables.transports.config_trans.liste_transport',$data);
            }else {
                return view('auth.verify');
            }
        }
    }

    public function paie_scolarite()
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classes =Classe::orderBy('nom_classe','asc')->get();
                $data = [
                    'title'=>"",
                    'classes'=>$classes
                ];
                return view('responsables.scolarites.scolarite',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function afficher_scolarite_etudiant(Request $req)
    {
        if (Gate::allows('isResponsable')){
            if ($req->etud_id==null) {
                $eleve=0;
                $paiements = [];
            } else {
                $eleve = Eleve::find($req->etud_id);
                $paiements = Scolarite::where('eleve_id',$req->etud_id)->get();
                $totalPaye = Scolarite::where('eleve_id',$req->etud_id)->sum('montant_paye');
                $total = Classe::where('id',$eleve->classe_id)->value('montant_total');
                $restepaye = $total - $totalPaye;
            }
            $data =[
                'eleve'=>$eleve,
                'paiements'=>$paiements,
                'totalPaye'=>$totalPaye,
                'total'=>$total,
                'restepaye'=>$restepaye,
                'i'=>1
            ];
            return view('responsables.scolarites.config_scolarite.liste_paiement',$data);
        }
    }

    public function statistique_scolarite()
    {
        if (Gate::allows('isResponsable')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $resp_id = Responsable::where('user_id',$user_id)->value('id');
            if ($user->email_verified_at != null) {
                $date = date('Y-m-d');
                $classes =Classe::orderBy('nom_classe','asc')->get();
                $anne_id = AnneeScoActuel::where('id',1)->value('annee_scolaire_id');
                $eleve_classe = Eleve::where('annee_scolaire_id',$anne_id)->where('actif',1)->get();
                $classe_id =[];
                $eleve_id = [];
                foreach ($eleve_classe as $classe) {
                    array_push($classe_id,$classe->classe_id);
                    array_push($eleve_id,$classe->id);
                }
                $total = Classe::whereIn('id',$classe_id)->sum('montant_total');
                $totalPaye = Scolarite::whereIn('eleve_id',$eleve_id)->sum('montant_paye');
                $restePaye = $total-$totalPaye;
                $totalJour = Scolarite::where('date_paie',$date)->sum('montant_paye');
                $data = [
                    'title'=>"",
                    'classes'=>$classes,
                    'total'=>$total,
                    'totalPaye'=>$totalPaye,
                    'restePaye'=>$restePaye,
                    'totalJour'=>$totalJour
                ];
                return view('responsables.scolarites.statistique_scolarite',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function cantine_etudiant()
    {
        if (Gate::allows('isEtudiant')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
            if ($user->email_verified_at != null) {
                $etud_id = Eleve::where('user_id',$user_id)->where('annee_scolaire_id',$anne_id)->value('id');
                $cantines = Cantine::where('eleve_id',$etud_id)->orderBy('date_cantine','desc')->get();
                $data = [
                    'title'=>"",
                    'i'=>1,
                    "cantines"=>$cantines
                ];
                return view('etudiants.paiements.cantine',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('home');
        }
    }

    public function scolarite_etudiant()
    {
        if (Gate::allows('isEtudiant')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
            if ($user->email_verified_at != null) {
                $etud_id = Eleve::where('user_id',$user_id)->where('annee_scolaire_id',$anne_id)->value('id');
                $scolarites = Scolarite::where('eleve_id',$etud_id)->orderBy('date_paie','desc')->get();
                $data = [
                    'title'=>"",
                    'i'=>1,
                    "scolarites"=>$scolarites
                ];
                return view('etudiants.paiements.scolarite',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('home');
        }
    }

    public function transport_etudiant(){
        if (Gate::allows('isEtudiant')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
            if ($user->email_verified_at != null) {
                $etud_id = Eleve::where('user_id',$user_id)->where('annee_scolaire_id',$anne_id)->value('id');
                $transports = Transport::where('eleve_id',$etud_id)->orderBy('mois','desc')->get();
                $data = [
                    'title'=>"",
                    'i'=>1,
                    "transports"=>$transports
                ];
                return view('etudiants.paiements.transport',$data);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('home');
        }
    }

}
