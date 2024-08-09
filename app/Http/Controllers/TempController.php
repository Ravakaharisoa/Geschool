<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\AnneeScoActuel;
use App\Models\AnneeScolaire;
use App\Models\TypeExamen;
use App\Models\Professeur;
use App\Models\Responsable;
use App\Models\Abscence;
use App\Models\Matiere;
use App\Models\Module;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\FicheProf;
use App\Models\Cour;
use App\Models\Note;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Facade\FlareClient\Http\Response;
use Mail;
use File;
use PDF;

class TempController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function emploi_du_temps()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            $title = "";
            $classes = Classe::orderBy('nom_classe', 'asc')->get();
            if (Gate::allows('isDirecteur')) {
                $cours = Cour::where('annee_scolaire_id', $anne_id)->with('matiere')->with('professeur')->get();
                $jours = Cour::select('jour')->where('annee_scolaire_id', $anne_id)->orderBy('numero_jour', 'asc')->distinct()->get();
                $classes = Classe::orderBy('nom_classe', 'desc')->get();
                $heures = Cour::select('heure_debut', 'heure_fin')->where('annee_scolaire_id', $anne_id)->orderBy('heure_debut', 'asc')->distinct()->get();
                $data = [
                    'cours' => $cours,
                    'classes' => $classes,
                    'title' => $title,
                    'jours' => $jours,
                    'heures' => $heures,
                    'anne_id' => $anne_id
                ];
                return view('Directeur.emploiDutemps.liste', $data);
            } elseif (Gate::allows('isResponsable')) {
                $cours = Cour::where('annee_scolaire_id', $anne_id)->with('matiere')->with('professeur')->get();
                $jours = Cour::select('jour')->where('annee_scolaire_id', $anne_id)->orderBy('numero_jour', 'asc')->distinct()->get();
                $classes = Classe::orderBy('nom_classe', 'desc')->get();
                $heures = Cour::select('heure_debut', 'heure_fin')->where('annee_scolaire_id', $anne_id)->orderBy('heure_debut', 'asc')->distinct()->get();
                $data = [
                    'cours' => $cours,
                    'classes' => $classes,
                    'title' => $title,
                    'jours' => $jours,
                    'heures' => $heures,
                    'anne_id' => $anne_id
                ];
                return view('responsables.cours.emploi_temps', $data);
            } elseif (Gate::allows('isProfesseur')) {
                $matieres = Matiere::orderBy('matiere', 'asc')->get();
                $data = [
                    'title' => $title,
                    'classes' => $classes,
                    'matieres' => $matieres,
                ];
                return view('professeurs.cours.nouveau_cours', $data);
            }else {
                $classe_id = Eleve::where('user_id',$user_id)->value('classe_id');
                $classe = Classe::find($classe_id);

                $cours = Cour::where('annee_scolaire_id', $anne_id)->where('classe_id',$classe_id)->with('matiere')->with('professeur')->get();
                $jours = Cour::select('jour')->where('classe_id',$classe_id)->where('annee_scolaire_id', $anne_id)->orderBy('numero_jour', 'asc')->distinct()->get();
                $heures = Cour::select('heure_debut', 'heure_fin')->where('classe_id',$classe_id)->where('annee_scolaire_id', $anne_id)->orderBy('heure_debut', 'asc')->distinct()->get();
                $data = [
                    'cours' => $cours,
                    'classe' => $classe,
                    'title' => $title,
                    'jours' => $jours,
                    'heures' => $heures,
                    'anne_id' => $anne_id
                ];
                return view('etudiants.cours.emploi_temp',$data);
            }
        } else {
            return view('auth.verify');
        }
    }

    public function save_cours(Request $req)
    {
        if (Gate::allows('isProfesseur')) {
            $user_id = Auth::id();
            $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
            $prof_id = Professeur::where('user_id', $user_id)->value('id');
            $courExist = Cour::where('jour', $req->jour)->where('classe_id', $req->classe_id)->where('matiere_id', $req->matiere_id)->where('professeur_id', $prof_id)->where('annee_scolaire_id', $anne_id)->count();
            if ($courExist > 0) {
                $message = "Ce cour est déjà disponible";
                $type = "danger";
            } else {
                $cour = new Cour();
                $cour->heure_debut = $req->heure_debut;
                $cour->heure_fin = $req->heure_fin;
                $cour->jour = $req->jour;
                $cour->numero_jour = jours_de_la_semaine($req->jour);
                $cour->classe_id = $req->classe_id;
                $cour->matiere_id = $req->matiere_id;
                $cour->professeur_id = $prof_id;
                $cour->annee_scolaire_id = $anne_id;
                $saveCour = $cour->save();
                if ($saveCour) {
                    $message = "Enregistré avec succès!";
                    $type = "success";
                } else {
                    $message = "Veuillez réessayer!";
                    $type = "danger";
                }
            }
            return response()->json(['message' => $message, 'type' => $type]);
        }
    }

    public function listeCoursDisponible()
    {
        if (Gate::allows('isProfesseur')) {
            $user_id = Auth::id();
            $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
            $prof_id = Professeur::where('user_id', $user_id)->value('id');
            $cours = Cour::where('annee_scolaire_id', $anne_id)->with('matiere')->with('professeur')->get();
            $jours = Cour::select('jour')->where('annee_scolaire_id', $anne_id)->orderBy('numero_jour', 'asc')->distinct()->get();
            $classes = Classe::orderBy('nom_classe', 'desc')->get();
            $heures = Cour::select('heure_debut', 'heure_fin')->where('annee_scolaire_id', $anne_id)->orderBy('heure_debut', 'asc')->distinct()->get();
            $data = [
                'cours' => $cours,
                'classes' => $classes,
                'jours' => $jours,
                'heures' => $heures,
                'anne_id' => $anne_id
            ];
            return view('professeurs.cours.configs.liste_cours', $data);
        }
    }

    public function enregistrer_abscence(Request $req)
    {
        if (Gate::allows('isProfesseur')) {
            $abscenceExist = Abscence::where('eleve_id', $req->etud_id)->where('date_absence', $req->date_abs)->where('cour_id', $req->cour_id)->count();
            if ($abscenceExist > 0) {
                $message = "C'est dèja notifier!";
                $type = "error";
            } else {
                $abscence = new Abscence();
                $abscence->eleve_id = $req->etud_id;
                $abscence->date_absence = $req->date_abs;
                $abscence->cour_id = $req->cour_id;
                $saveAbs = $abscence->save();
                if ($saveAbs) {
                    $message = "Abscence bien notifiée!";
                    $type = "success";
                } else {
                    $message = "Veuillez réessayer!";
                    $type = "error";
                }
            }
            return response()->json(['type' => $type, 'message' => $message]);
        }
    }

    public function form_add_note(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        if ($user->email_verified_at != null) {
            if (Gate::allows('isProfesseur')) {
                $prof_id = Professeur::where('user_id', $user_id)->value('id');
                $etudiant = Eleve::find($req->eleve_id);
                $cours = Cour::where('classe_id', $etudiant->classe_id)->where('professeur_id', $prof_id)->get();
                $matiere_id = [];
                foreach ($cours as $cour) {
                    array_push($matiere_id, $cour->matiere_id);
                }
                $matieres = Matiere::whereIn('id', $matiere_id)->orderBy('matiere', 'asc')->get();
                $modules = Module::orderBy('trimestre', 'asc')->get();
                $types = TypeExamen::orderBy('type', 'asc')->get();
                $data = [
                    "title" => "",
                    "etudiant" => $etudiant,
                    "matieres" => $matieres,
                    "modules" => $modules,
                    'types' => $types
                ];
                return view('professeurs.notes.form_note', $data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function add_note(Request $req)
    {
        if (Gate::allows('isProfesseur')) {
            $noteExist = Note::where('eleve_id', $req->etud)->where('date_evaluation', $req->date_eval)->where('note', $req->note)->where('module_id', $req->module)->where('matiere_id', $req->matiere)->where('type_examen_id', $req->type_exam)->count();
            if ($noteExist > 0) {
                $message = "Cette note dèja enregistrée!";
                $type = "error";
            } else {
                $note = new Note();
                $note->eleve_id = $req->etud;
                $note->date_evaluation = $req->date_eval;
                $note->coefficient = $req->coefficient;
                $note->note = $req->note;
                $note->module_id = $req->module;
                $note->matiere_id = $req->matiere;
                $note->type_examen_id = $req->type_exam;
                $saveNote = $note->save();
                if ($saveNote) {
                    $message = "Note bien enregistrée!";
                    $type = "success";
                } else {
                    $message = "Veuillez réessayer!";
                    $type = "error";
                }
            }
            return response()->json(['type' => $type, 'message' => $message]);
        }
    }

    public function liste_notes()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            if (Gate::allows('isProfesseur')) {
                $prof_id = Professeur::where('user_id', $user_id)->value('id');
                $cours = Cour::where('professeur_id', $prof_id)->where('annee_scolaire_id', $anne_id)->get();
                $classe_id = [];
                foreach ($cours as $cour) {
                    array_push($classe_id, $cour->classe_id);
                }
                $classes = Classe::whereIn('id', $classe_id)->orderBy('nom_classe', 'asc')->get();
                $data = [
                    "title" => "",
                    'classes' => $classes
                ];
                return view('professeurs.notes.listes_note', $data);
            }elseif (Gate::allows('isEtudiant')) {
                $modules = Module::orderBy('trimestre','asc')->get();
                $data = [
                    'title'=>"",
                    "modules"=>$modules
                ];
                return view('etudiants.classes.note_etud',$data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function detail_note_classe(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        $types = TypeExamen::orderBy('type', 'asc')->get();
        if ($user->email_verified_at != null) {
            if (Gate::allows('isProfesseur')) {
                $modules = Module::orderBy('trimestre', 'asc')->get();
                $prof_id = Professeur::where('user_id', $user_id)->value('id');
                $cours = Cour::where('professeur_id', $prof_id)->where('annee_scolaire_id', $anne_id)->get();
                $eleve = Eleve::where('id', $req->etud_id)->with('classe_annuel')->first();
                $matiere_id = [];
                foreach ($cours as $cour) {
                    array_push($matiere_id, $cour->matiere_id);
                }
                $matieres = Matiere::whereIn('id', $matiere_id)->orderBy('matiere', 'asc')->get();
                $data = [
                    "title" => "",
                    'matieres' => $matieres,
                    'modules' => $modules,
                    'types' => $types,
                    'eleve' => $eleve,
                    'coeff' => 0,
                ];
                return view('professeurs.notes.config_views_note.detail_note', $data);
            }elseif (Gate::allows('isEtudiant')) {
                $classe_id = Eleve::where('annee_scolaire_id',$anne_id)->where('user_id',$user_id)->value('classe_id');
                $cours = Cour::where('classe_id', $classe_id)->where('annee_scolaire_id', $anne_id)->get();
                $eleve = Eleve::where('user_id', $user_id)->with('classe_annuel')->first();
                $module = Module::find($req->module_id);
                $matiere_id = [];
                foreach ($cours as $cour) {
                    array_push($matiere_id, $cour->matiere_id);
                }
                $matieres = Matiere::whereIn('id', $matiere_id)->orderBy('matiere', 'asc')->get();
                $data = [
                    "title" => "",
                    'matieres' => $matieres,
                    'module' => $module,
                    'types' => $types,
                    'eleve' => $eleve,
                    'coeff' => 0,
                ];
                return view('etudiants.classes.notes.note_dispo',$data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function form_update_abscence(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        $eleve_id = Abscence::where('id', $req->abs_id)->value('eleve_id');
        $eleve = Eleve::find($eleve_id);
        if ($user->email_verified_at != null) {
            if (Gate::allows('isResponsable')) {
                $data = [
                    "title" => "",
                    "abs_id" => $req->abs_id,
                    "eleve" => $eleve
                ];
                return view('responsables.eleve_inscrits.tries_eleves.form_update_abscence', $data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function ajout_motif(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        $abscence = Abscence::find($req->abs_id);
        $eleve = Eleve::find($abscence->eleve_id);
        if (Gate::allows('isResponsable')) {
            $date = $abscence->date_absence;
            $responsable = Responsable::where('user_id', $user_id)->first();
            $classe = Classe::where('id', $eleve->classe_id)->first();
            $cour = Cour::find($abscence->cour_id);
            $prof = Professeur::find($cour->professeur_id);
            $nom_fichier = $eleve->matricule . "_" . date_formate($date, "Y-m-d") . "pdf";

            $data = [
                'resp' => $responsable,
                'eleve' => $eleve,
                'abscence' => $abscence,
                'classe' => $classe->nom_classe,
                'prof' => $prof,
                'nom_fichier' => $nom_fichier,
                'date' => $date,
                'matiere' => Matiere::where('id', $cour->matiere_id)->value('matiere')
            ];
            if ($abscence->motif == null && $abscence->billet_entrer == null) {
                $pdf = PDF::loadView('fichierpdfs.billet_entrer', $data);
                $pdfPath = public_path("assets/documents/Buillets_entree/" . $data['nom_fichier']);

                if (File::exists($pdfPath)) {
                    unlink($pdfPath);
                }
                $savePdf = $pdf->save($pdfPath);
                if ($savePdf) {
                    $updateAbs = Abscence::where('id', $req->abs_id)->update(['motif' => $req->motif, 'billet_entrer' => $data['nom_fichier']]);
                    if ($updateAbs) {
                        $message = "Billet d'entrée validée par le responsable";
                        $icon = "success";
                        $color = "success";
                    } else {
                        $message = "Veuillez réessayer!";
                        $icon = "error";
                        $color = "danger";
                    }
                } else {
                    $message = "Veuillez réessayer!";
                    $icon = "error";
                    $color = "danger";
                }
            } else {
                $message = "Billet d'entrée déjà validée";
                $icon = "error";
                $color = "danger";
            }
            return response()->json(['icon' => $icon, 'message' => $message, 'color' => $color]);
        } else {
            return route('home');
        }
    }

    public function note_classe()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if (Gate::allows('isResponsable')) {
            $classes = Classe::orderBy('nom_classe','asc')->get();
            $modules = Module::orderBy('trimestre','asc')->get();
            $data =[
                "title"=>"",
                "classes"=>$classes,
                "modules"=>$modules
            ];
            return view('responsables.notes.liste_note',$data);
        } else {
            return route('home');
        }
    }

    public function liste_note_classe(Request $req){
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if (Gate::allows('isResponsable')) {
            $classe = Classe::find($req->classe_id);
            $matiere_id = [];
            $cours = Cour::where('annee_scolaire_id',$anne_id)->where('classe_id',$req->classe_id)->get();
            foreach ($cours as $cour) {
               array_push($matiere_id,$cour->matiere_id);
            }
            $matieres = Matiere::whereIn('id',$matiere_id)->orderBy('matiere','asc')->get();
            $eleves = Eleve::where('classe_id',$req->classe_id)->where('annee_scolaire_id',$anne_id)->where('actif',1)->get();
            $typeExames = TypeExamen::orderBy('type','asc')->get();
            $data =[
                "title"=>"",
                "i"=>1,
                "classe"=>$classe,
                "types"=>$typeExames,
                "matieres"=>$matieres,
                "eleves"=>$eleves,
                "module_id"=>$req->module_id
            ];
            return view('responsables.notes.note_dispo',$data);
        } else {
            return route('home');
        }
    }

    public function bulletin_etud($id){
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if (Gate::allows('isResponsable')) {
            $eleve = Eleve::where('id',$id)->with('classe_annuel')->with('anneeScol')->first();
            $notes = Note::where('eleve_id',$id)->get();
            $cours = Cour::where('annee_scolaire_id',$anne_id)->where('classe_id',$eleve->classe_id)->get();
            $types = TypeExamen::orderBy('type','asc')->get();
            $module_id =[];
            $matiere_id = [];
            if (count($notes)) {
                foreach ($notes as $note) {
                    array_push($module_id,$note->module_id);
                }
                $modules = Module::whereIn('id',$module_id)->orderBy('trimestre','asc')->get();
            }else{
                $modules = Module::orderBy('trimestre','asc')->get();
            }

            if (count($cours)>0) {
                foreach ($cours as $cour) {
                    array_push($matiere_id,$cour->matiere_id);
                }
                $matieres = Matiere::whereIn('id',$matiere_id)->orderBy('matiere','asc')->get();
            } else {
                $matieres = [];
            }
            $data =[
                "title"=>"",
                "eleve"=>$eleve,
                "modules"=>$modules,
                "matieres"=>$matieres,
                "types"=>$types,
                "notes"=>$notes,
                "row"=>count($types)+1,
                "moyenne"=>0
            ];
            return view('responsables.eleve_inscrits.bulletin',$data);
        } else {
            return route('home');
        }
    }

    public function add_fiche_presence(Request $req){
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if (Gate::allows('isResponsable')) {
            $fiche = FicheProf::where('professeur_id',$req->prof_id)->where('date_presence',$req->date_pres)->where('debut',$req->heure_arrive)->where('annee_scolaire_id',$anne_id)->count();
            if ($fiche>0) {
               $message="C'est déjà enregistrée !";
               $color = "danger";
            } else {
                $newFiche = new FicheProf();
                $newFiche->date_presence=$req->date_pres;
                $newFiche->debut=$req->heure_arrive;
                $newFiche->professeur_id = $req->prof_id;
                $newFiche->annee_scolaire_id = $anne_id;
                $saveFiche = $newFiche->save();
                if($saveFiche){
                    $message = "Enregistrée avec succès !";
                    $color = "success";
                }else{
                    $message = "Veuiller réessayer !";
                    $color = "danger";
                }
            }
            return response()->json(['message'=>$message,'color'=>$color]);

        } else {
            return route('home');
        }
    }

    public function liste_classe(){
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            if (Gate::allows('isEtudiant')) {
                $classe_id = Eleve::where('user_id',$user_id)->where('annee_scolaire_id',$anne_id)->value('classe_id');
                $classe = Classe::where('id',$classe_id)->value('nom_classe');
                $eleves = Eleve::where('annee_scolaire_id',$anne_id)->where('classe_id',$classe_id)->orderBy('matricule','asc')->get();
                $data = [
                    'title'=>"",
                    'classe'=>$classe,
                    'eleves'=>$eleves
                ];
                return view('etudiants.classes.liste_etud',$data);
            } else {
                return route('home');
            }
        }else {
            return view('auth.verify');
        }
    }

    public function historique_abscence(){
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            if (Gate::allows('isEtudiant')) {;
                $eleve = Eleve::where('annee_scolaire_id',$anne_id)->where('user_id',$user_id)->first();
                $abscences = Abscence::where('eleve_id',$eleve->id)->get();
                $data = [
                    'title'=>"",
                    'i'=>1,
                    'abscences'=>$abscences,
                    'eleve'=>$eleve
                ];
                return view('etudiants.historique.abscence',$data);
            } else {
                return route('home');
            }
        }else {
            return view('auth.verify');
        }
    }
}
