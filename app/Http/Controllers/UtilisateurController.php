<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\ProfesseurInscription;
use App\Mail\ResponsableInscription;
use App\Mail\EtudiantInscription;
use Illuminate\Support\Facades\DB;
use App\Models\AnneeScoActuel;
use App\Models\AnneeScolaire;
use App\Models\Professeur;
use App\Models\Responsable;
use App\Models\Scolarite;
use App\Models\Abscence;
use App\Models\Cantine;
use App\Models\Transport;
use App\Models\Matiere;
use App\Models\FicheProf;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Ecole;
use App\Models\Cour;
use App\Models\Note;
use App\Models\User;
use DataTables;
use Mail;
use PDF;
use File;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function responsable()
    {
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable') || Gate::allows('isProfesseur') || Gate::allows('isEtudiant')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            if ($user->email_verified_at != null) {
                $responsables = Responsable::orderBy('date_embauche', 'desc')->get();
                $data = [
                    'title' => "",
                    'responsables' => $responsables
                ];
                return view('Directeur.responsables.liste_responsable', $data);
            } else {
                return view('auth.verify');
            }
        }
    }

    public function new_responsable()
    {
        if (Gate::allows('isDirecteur')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            if ($user->email_verified_at != null) {
                $data = [
                    'title' => "",
                ];
                return view('Directeur.responsables.new_responsable', $data);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function add_responsable(Request $req)
    {
        $directeur = User::find(Auth::id());
        $users = User::where('email', $req->email)->count();
        $mdp = "0000";
        $name = ucfirst($req->nom) . ' ' . ucfirst($req->prenom);
        $password = Hash::make($mdp);
        if ($users > 0) {
            $message = "Cet email est déjà utilisé !!";
            $color = "error";
        } else {
            $resp = Responsable::where('email', $req->email)->count();
            if ($resp > 0) {
                $message = "Cet email est déjà utilisé !";
                $color = "error";
            } else {
                if ($req->sexe == "Homme") {
                    $sexe = "Monsieur";
                } elseif ($req->sexe == "Femme") {
                    $sexe = "Madame";
                } else {
                    $sexe = "";
                }
                $ecole_id = Ecole::max('id');

                $data = [
                    "email" => $req->email,
                    "password" => $mdp,
                    "name" => $name,
                    'directeur' => $directeur,
                    "sexe" => $sexe
                ];
                DB::insert('insert into users (name,email,password,contact,role_id,created_at,updated_at) values (?,?,?,?,?,?,?)', [$name, $req->email, $password, $req->contact1, 2, NOW(), NOW()]);
                $user_id = User::where('email', $req->email)->value('id');

                DB::insert("insert into responsables(nom,prenom,email,fonction,matricule,sexe,adresse,contact_prim,	contact_seco,type_contrat,date_embauche,user_id,ecole_id,created_at,updated_at) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [ucfirst($req->nom), ucfirst($req->prenom), $req->email, $req->fonction, $req->matricule, $req->sexe, $req->adresse, $req->contact1, $req->contact2, $req->contrat, $req->date_embauche, $user_id, $ecole_id, NOW(), NOW()]);
                // Mail::to($req->email)->send(new ResponsableInscription($data));
                $message = "Nouveau responsable bien inscrit !";
                $color = "success";
            }
        }
        return response()->json(['color' => $color, 'message' => $message]);
    }

    public function supprimer_responsable(Request $req)
    {
        if (Gate::allows('isDirecteur')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            if ($user->email_verified_at != null) {
                $respDelete = Responsable::where('id', $req->resp_id)->update(['actif' => 0]);
                if ($respDelete) {
                    $message = "Suppression avec succès!";
                    $icon = "success";
                } else {
                    $message = "Veuillez réessayer";
                    $icon = "error";
                }
                return response()->json(['icon' => $icon, 'message' => $message]);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function update_information_resp(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $responsable = Responsable::where('user_id', $user_id)->first();
            if ($req->hasFile('uploadImg_resp')) {
                if ($req->nom_resp == null) {
                    $nom = $responsable->nom;
                } else {
                    $nom = $req->nom_resp;
                }
                if ($req->prenom_resp == null) {
                    $prenom = $responsable->prenom;
                } else {
                    $prenom = $req->prenom_resp;
                }
                if ($req->adresse_resp == null) {
                    $adresse = $responsable->adresse;
                } else {
                    $adresse = $req->adresse_resp;
                }
                if ($req->cin_resp == null) {
                    $cin = $responsable->cin;
                } else {
                    $cin = $req->cin_resp;
                }
                if ($req->nationalite_resp == null) {
                    $nationalite = $responsable->nationalite;
                } else {
                    $nationalite = $req->nationalite_resp;
                }
                if ($req->contact1 == null) {
                    $contact_prim = $responsable->contact_prim;
                } else {
                    $contact_prim = $req->contact1;
                }
                if ($req->sexe_resp == null) {
                    $sexe = $responsable->sexe;
                } else {
                    $sexe = $req->sexe_resp;
                }
                if ($req->matricule_resp == null) {
                    $matricule = $responsable->matricule;
                } else {
                    $matricule = $req->matricule_resp;
                }
                if ($req->fonct_resp == null) {
                    $fonction = $responsable->fonction;
                } else {
                    $fonction = $req->fonct_resp;
                }
                if ($req->date_emb_resp == null) {
                    $date_embauche = $responsable->date_embauche;
                } else {
                    $date_embauche = $req->date_emb_resp;
                }
                if ($req->contrat_resp == null) {
                    $type_contrat = $responsable->type_contrat;
                } else {
                    $type_contrat = $req->contrat_resp;
                }
                if ($req->email_resp == null) {
                    $email = $responsable->email;
                } else {
                    $email = $req->email_resp;
                }
                if ($req->contact2 == null) {
                    $contact_seco = $responsable->contact_seco;
                } else {
                    $contact_seco = $req->contact2;
                }

                $image = $req->file('uploadImg_resp');
                $imageName = "Resp_" . $matricule;
                $photo = $imageName . time() . '.' . $image->getClientoriginalExtension();

                if ($responsable->photo != null) {
                    $imagePath = public_path('/assets/img/users/' . $responsable->photo);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $name = ucfirst($nom) . ' ' . ucfirst($prenom);
                $updateResp = Responsable::where('id', $responsable->id)->update(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'fonction' => $fonction, 'matricule' => $matricule, 'sexe' => $sexe, 'adresse' => $adresse, 'cin' => $cin, 'nationalite' => $nationalite, 'contact_prim' => $contact_prim, 'contact_seco' => $contact_seco, 'photo' => $photo, 'type_contrat' => $type_contrat, 'date_embauche' => $date_embauche, 'updated_at' => Now()]);

                $updateUser = User::where('id', $user_id)->update(['name' => $name, 'email' => $email, 'photo' => $photo, 'contact' => $contact_prim, 'updated_at' => Now()]);
                if ($updateResp && $updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->uploadImg_resp->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Informations bien enregistrée!";
                } else {
                    $icon = "error";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['icon' => $icon, 'message' => $message]);
            } else {
                return back();
            }
        }
    }

    public function photo_profile()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        if ($user->email_verified_at != null) {
            if (Gate::allows('isResponsable')) {
                $resp_id = Responsable::where('user_id', $user_id)->value('id');
                $data = [
                    "resp_id" => $resp_id
                ];
                return view('responsables.profile.configs_views.form_photo', $data);
            } elseif (Gate::allows('isProfesseur')) {
                return view('professeurs.profiles.form_photo');
            } elseif (Gate::allows('isEtudiant')) {
               return view('etudiants.profiles.update_photo');
            } elseif (Gate::allows('isDirecteur')) {
               return view('Directeur.profiles.form_photo');
            } else {
                return route('login');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function update_profile(Request $req)
    {
        $user_id = Auth::id();
        if (Gate::allows('isResponsable')) {
            $resp = Responsable::where('user_id', $user_id)->first();
            if ($req->hasFile('img_resp')) {
                $image = $req->file('img_resp');
                $imageName = "Resp_" . $resp->matricule;
                $photo = $imageName . time() . '.' . $image->getClientoriginalExtension();

                if ($resp->photo != null) {
                    $imagePath = public_path('/assets/img/users' . $resp->photo);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $updateResp = Responsable::where('id', $resp->id)->update(['photo' => $photo]);
                $updateUser = User::where('id', $user_id)->update(['photo' => $photo]);

                if ($updateResp && $updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->img_resp->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Modification avec succès!";
                } else {
                    $icon = "error";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['color' => $icon, 'message' => $message, 'photo' => $photo]);
            } else {
                return back();
            }
        } elseif (Gate::allows('isProfesseur')) {
            $prof = Professeur::where('user_id', $user_id)->first();
            if ($req->hasFile('img_professeur')) {
                $image = $req->file('img_professeur');
                $imageName = "prof_" . $prof->matricule;
                $photo = $imageName . time() . '.' . $image->getClientoriginalExtension();

                if ($prof->image != null) {
                    $imagePath = public_path('/assets/img/users' . $prof->image);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $updateprof = Professeur::where('id', $prof->id)->update(['image' => $photo]);
                $updateUser = User::where('id', $user_id)->update(['photo' => $photo]);

                if ($updateprof && $updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->img_professeur->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Modification avec succès!";
                } else {
                    $icon = "error";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['color' => $icon, 'message' => $message]);
            } else {
                return back();
            }
        } elseif (Gate::allows('isEtudiant')) {
            $etud = Eleve::where('user_id', $user_id)->first();
            if ($req->hasFile('img_etudiant')) {
                $image = $req->file('img_etudiant');
                $imageName = "Etud_" . $etud->matricule;
                $photo = $imageName . time() . '.' . $image->getClientoriginalExtension();

                if ($etud->photo != null) {
                    $imagePath = public_path('/assets/img/users' . $etud->photo);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $updateetud = Eleve::where('id', $etud->id)->update(['photo' => $photo]);
                $updateUser = User::where('id', $user_id)->update(['photo' => $photo]);

                if ($updateetud && $updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->img_etudiant->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Modification avec succès!";
                } else {
                    $icon = "error";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['color' => $icon, 'message' => $message]);
            } else {
                return back();
            }
        } elseif (Gate::allows('isDirecteur')) {
            $user = User::find($user_id);
            if ($req->hasFile('img_directeur')) {
                $image = $req->file('img_directeur');
                $photo = "Dir_" . time() . '.' . $image->getClientoriginalExtension();

                if ($user->photo != null) {
                    $imagePath = public_path('/assets/img/users' . $user->photo);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $updateUser = User::where('id', $user_id)->update(['photo' => $photo]);
                if ($updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->img_directeur->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Modification avec succès!";
                } else {
                    $icon = "error";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['color' => $icon, 'message' => $message]);
            } else {
                return back();
            }
        } else {
            return route('login');
        }
    }

    public function update_information(Request $req){
        $user_id = Auth::id();
        $anne_id = AnneeScoActuel::where('id',1)->value('annee_scolaire_id');
        if (Gate::allows('isResponsable')) {
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            $name = ucwords($req->nom)." ".ucwords($req->prenom);

            $updateResp = Responsable::where('id',$resp_id)->update(['nom'=>$req->nom,'prenom'=>$req->prenom,'email'=>$req->email,'sexe'=>$req->sexe,'adresse'=>$req->adresse,'cin'=>$req->cin,'nationalite'=>$req->nationalite,'contact_prim'=>$req->contact1,'contact_seco'=> $req->contact2,'date_embauche' => $req->date_embauche, 'updated_at' => Now()]);
            $updateUser = User::where('id',$user_id)->update(['name'=>$name,'email'=>$req->email,'contact'=>$req->contact1]);
            if ($updateResp && $updateUser) {
                $icone = "success";
                $message ="Modification bien enregistrée !";
            } else {
                $icone = "danger";
                $message= "Veuillez réessayer svp !";
            }
            return response()->json(['icone'=>$icone,'message'=>$message]);
        }
        elseif (Gate::allows('isProfesseur')) {
            $prof_id = Professeur::where('user_id', $user_id)->value('id');
            $name = ucwords($req->nom)." ".ucwords($req->prenom);

            $updateProf = Professeur::where('id',$prof_id)->update(['nom'=>$req->nom,'prenom'=>$req->prenom,'email'=>$req->email,'sexe'=>$req->sexe,'adresse'=>$req->adresse,'cin'=>$req->cin,'nationalite'=>$req->nationalite,'contact1'=>$req->contact1,'contact2'=> $req->contact2,'date_embauche' => $req->date_embauche, 'updated_at' => Now()]);
            $updateUser = User::where('id',$user_id)->update(['name'=>$name,'email'=>$req->email,'contact'=>$req->contact1]);
            if ($updateProf && $updateUser) {
                $icone = "success";
                $message ="Modification bien enregistrée !";
            } else {
                $icone = "danger";
                $message= "Veuillez réessayer svp !";
            }
            return response()->json(['icone'=>$icone,'message'=>$message]);
        } elseif (Gate::allows('isEtudiant')) {
            $eleve_id = Eleve::where('annee_scolaire_id',$anne_id)->where('user_id',$user_id)->value('id');
            $name = ucwords($req->nom)." ".ucwords($req->prenom);
            $updateEleve = Eleve::where('id',$eleve_id)->update(['nom'=>$req->nom,'prenom'=>$req->prenom,'email'=>$req->email,'date_naissance'=>$req->dateNaiss,'lieu_naissance'=>$req->lieuNaiss,'sexe'=>$req->sexe,'adresse'=>$req->adresse,'nationalite'=>$req->nationalite,'contact_prim'=>$req->contact1,'contact_seco'=>$req->contact2,'updated_at' => Now()]);

            $updateUser = User::where('id',$user_id)->update(['name'=>$name,'email'=>$req->email,'contact'=>$req->contact1]);
            if ($updateEleve && $updateUser) {
                $icone = "success";
                $message ="Modification bien enregistrée !";
            } else {
                $icone = "danger";
                $message= "Veuillez réessayer svp !";
            }
            return response()->json(['icone'=>$icone,'message'=>$message]);
        } elseif (Gate::allows('isDirecteur')) {
            $updateUser = User::where('id',$user_id)->update(['name'=>$req->nom,'email'=>$req->email,'contact'=>$req->contact]);
            if ($updateUser) {
                $icone = "success";
                $message ="Modification bien enregistrée !";
            } else {
                $icone = "danger";
                $message= "Veuillez réessayer svp !";
            }
            return response()->json(['icone'=>$icone,'message'=>$message]);
        }
         else {
            return route('login');
        }
    }

    public function new_prof()
    {
        if (Gate::allows('isDirecteur')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            if ($user->email_verified_at != null) {
                $data = [
                    'title' => "",
                ];
                return view('Directeur.professeurs.new_prof', $data);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function professeur()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
                $professeurs = Professeur::orderBy('nom', 'asc')->get();
                $data = [
                    'title' => "",
                    'professeurs' => $professeurs
                ];
                return view('Directeur.professeurs.liste_prof', $data);

            }elseif (Gate::allows('isEtudiant')) {
                $classe_id = Eleve::where('user_id',$user_id)->where('annee_scolaire_id',$anne_id)->value('classe_id');
                $cours = Cour::where('annee_scolaire_id',$anne_id)->where('classe_id',$classe_id)->get();
                $prof_id =[];
                foreach ($cours as $cour) {
                    array_push($prof_id,$cour->professeur_id);
                }
                $professeurs = Professeur::whereIn('id',$prof_id)->get();
                $data = [
                    'title' => "",
                    'professeurs'=>$professeurs
                ];
                return view('etudiants.cours.liste_prof',$data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function fiche_prof(){
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $title = "";
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        $fiches = FicheProf::where('annee_scolaire_id',$anne_id)->with('enseignant')->get();
        if ($user->email_verified_at != null) {
            if (Gate::allows('isDirecteur')) {
                $data =[
                    'title'=>$title,
                    'fiches'=>$fiches,
                    'i'=>1
                ];
                return view('Directeur.professeurs.fiche_presence',$data);
            }elseif (Gate::allows('isResponsable')) {
                $profs = Professeur::orderBy('nom','asc')->get();
                $data = [
                    'i'=>1,
                    'title'=>$title,
                    'profs'=>$profs,
                    'fiches'=>$fiches
                ];
                return view('responsables.professeurs.fiche_presence',$data);
            } else {
                # code...
            }
        } else {
            return view('auth.verify');
        }

    }

    public function add_prof(Request $req)
    {
        $directeur = User::find(Auth::id());
        $users = User::where('email', $req->email)->count();
        $mdp = "0000";
        $name = ucfirst($req->nom) . ' ' . ucfirst($req->prenom);
        $password = Hash::make($mdp);
        if ($users > 0) {
            $message = "Cet email est déjà utilisé !!";
            $color = "error";
        } else {
            $profs = Professeur::where('email', $req->email)->count();
            if ($profs > 0) {
                $message = "Cet email est déjà utilisé !";
                $color = "error";
            } else {
                if ($req->sexe == "Homme") {
                    $sexe = "Monsieur";
                } elseif ($req->sexe == "Femme") {
                    $sexe = "Madame";
                } else {
                    $sexe = "";
                }

                $data = [
                    "email" => $req->email,
                    "password" => $mdp,
                    "name" => $name,
                    'directeur' => $directeur,
                    "sexe" => $sexe
                ];
                DB::insert('insert into users (name,email,password,contact,role_id,created_at,updated_at) values (?,?,?,?,?,?,?)', [$name, $req->email, $password, $req->contact1, 3, NOW(), NOW()]);
                $user_id = User::where('email', $req->email)->value('id');

                DB::insert("insert into professeurs(nom,prenom,matricule,email,sexe,adresse,contact1,contact2,type_contrat,date_embauche,user_id,created_at,updated_at) values(?,?,?,?,?,?,?,?,?,?,?,?,?)", [ucfirst($req->nom), ucfirst($req->prenom), $req->matricule, $req->email, $req->sexe, $req->adresse, $req->contact1, $req->contact2, $req->contrat, $req->date_embauche, $user_id, NOW(), NOW()]);
                // Mail::to($req->email)->send(new ProfesseurInscription($data));
                $message = "Nouveau professeur bien inscrit !";
                $color = "success";
            }
        }
        return response()->json(['color' => $color, 'message' => $message]);
    }

    public function supprimer_prof(Request $req)
    {
        $prof = Professeur::where('id', $req->prof_id)->update(['actif' => 0]);
        if ($prof) {
            $message = "Suppression avec succès";
            $icon = "success";
        } else {
            $message = "Veuillez réessayer s'il vous plaît";
            $icon = "error";
        }
        return response()->json(['message' => $message, 'icon' => $icon]);
    }

    public function restaurer_prof(Request $req)
    {
        $prof = Professeur::where('id', $req->prof_id)->update(['actif' => 1]);
        if ($prof) {
            $message = "Restauration avec succès";
            $icon = "success";
        } else {
            $message = "Veuillez réessayer s'il vous plaît";
            $icon = "error";
        }
        return response()->json(['message' => $message, 'icon' => $icon]);
    }

    public function inscription()
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classes = Classe::orderBy('nom_classe', 'asc')->get();
                $data = [
                    'title' => "",
                    'classes' => $classes
                ];
                return view('responsables.eleve_inscrits.inscription', $data);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function informations_inscrits(Request $req)
    {
        $data = Eleve::where('nom', 'LIKE', '%' . $req->get('search') . '%')
            ->orWhere('prenom', 'LIKE', '%' . $req->get('search') . '%')->get();
        return response()->json($data);
    }

    public function liste_etudiant()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $classes = Classe::orderBy('nom_classe', 'asc')->get();
        if ($user->email_verified_at != null) {
            if (Gate::allows('isResponsable')) {
                $data = [
                    'title' => "",
                    'classes' => $classes
                ];
                return view('responsables.eleve_inscrits.liste', $data);
            } elseif (Gate::allows('isDirecteur')) {
                $data = [
                    'title' => "",
                    'classes' => $classes
                ];
                return view('Directeur.etudiants.liste', $data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function details_etudiant($id)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $eleve = Eleve::where('id', $id)->with('classe_annuel')->first();
        $anne = AnneeScolaire::where('id', $eleve->annee_scolaire_id)->first();

        if (Gate::allows('isResponsable')) {
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $scolarite_paye = Scolarite::where('eleve_id', $id)->sum('montant_paye');
                $cantines = Cantine::take(4)->where('eleve_id', $id)->orderBy('date_cantine', 'desc')->get();
                $transports = Transport::take(4)->where('eleve_id', $id)->orderBy('mois', 'desc')->get();
                $abscence = Abscence::where('eleve_id', $id)->orderBy('id', 'desc')->first();
                $data = [
                    'title' => "",
                    'eleve' => $eleve,
                    'anne' => $anne,
                    'scolarite_paye' => $scolarite_paye,
                    'cantines' => $cantines,
                    'transports' => $transports,
                    'abscence' => $abscence
                ];
                return view('responsables.eleve_inscrits.details', $data);
            } else {
                return view('auth.verify');
            }
        } elseif (Gate::allows('isProfesseur')) {
            $prof_id = Professeur::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $abscences = Abscence::where('eleve_id', $id)->with('cour')->get();
                $notes = Note::where('eleve_id', $id)->with('module')->with('matieres')->with('typeExam')->orderBy('note', 'desc')->get();
                $data = [
                    'title' => "",
                    'eleve' => $eleve,
                    'anne' => $anne,
                    'abscences' => $abscences,
                    'notes' => $notes
                ];
                return view('professeurs.etudiants.inscrits.details', $data);
            } else {
                return view('auth.verify');
            }
        } elseif(Gate::allows('isDirecteur')) {
            if ($user->email_verified_at != null) {
                $scolarite_paye = Scolarite::where('eleve_id', $id)->sum('montant_paye');
                $cantines = Cantine::take(4)->where('eleve_id', $id)->orderBy('date_cantine', 'desc')->get();
                $transports = Transport::take(4)->where('eleve_id', $id)->orderBy('mois', 'desc')->get();
                $abscence = Abscence::where('eleve_id', $id)->orderBy('id', 'desc')->first();
                $data = [
                    'title' => "",
                    'eleve' => $eleve,
                    'anne' => $anne,
                    'scolarite_paye' => $scolarite_paye,
                    'cantines' => $cantines,
                    'transports' => $transports,
                    'abscence' => $abscence
                ];
                // dd($data);
                return view('Directeur.etudiants.details',$data);
            }else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function add_etudiant(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $user = User::where('id', Auth::id())->first();
            $resp_id = Responsable::where('user_id', Auth::id())->value('id');
            if ($user->email_verified_at != null) {
                $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
                $name = ucfirst($req->nom) . ' ' . ucfirst($req->prenom);
                $mdp = "0000";
                $password = Hash::make($mdp);
                $etud = User::where('email', $req->email)->where('name', $name)->count();
                if ($etud > 0) {
                    $id_user = User::where('email', $req->email)->value('id');
                } else {
                    DB::insert('insert into users (name,email,password,contact,role_id,created_at,updated_at) values (?,?,?,?,?,?,?)', [$name, $req->email, $password, $req->contact1, 4, NOW(), NOW()]);
                    $id_user = User::where('email', $req->email)->where('name', $name)->value('id');
                }
                $data = [
                    "email" => $req->email,
                    "password" => $mdp,
                    "name" => $name,
                    'directeur' => User::where('role_id', 1)->first(),
                ];
                $eleve = Eleve::where('nom', $req->nom)->where('prenom', $req->prenom)->where('email', $req->email)->where('annee_scolaire_id', $anne_id)->count();
                if ($eleve > 0) {
                    $color = "error";
                    $message = "Cet élève est déjà enregistré!";
                } else {
                    $date_inscription = date('Y-m-d');
                    DB::insert("insert into eleves(nom,prenom,email,matricule,date_naissance,sexe,adresse,nationalite,contact_prim,nom_pere,nom_mere,maladie,date_inscription,contact_seco,actif,user_id,classe_id,annee_scolaire_id,observation,created_at,updated_at) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [ucfirst($req->nom), ucfirst($req->prenom), $req->email, $req->matricule, $req->date_naissance, $req->sexe, $req->adresse, $req->nationalite, $req->contact1, $req->pere, $req->mere, $req->maladie, $date_inscription, $req->contact2, 1, $id_user, $req->classe, $anne_id, $req->info, NOW(), NOW()]);

                    if ($req->reduction != null) {
                        $eleve_id = Eleve::where('user_id', $id_user)->value('id');
                        $scolarite = new Scolarite();
                        $scolarite->date_paie =    $date_inscription;
                        $scolarite->montant_paye = (int)$req->reduction;
                        $scolarite->eleve_id = $eleve_id;
                        $scolarite->save();
                    }
                    // Mail::to($req->email)->send(new EtudiantInscription($data));
                    $message = "Nouveau élève bien inscrit !";
                    $color = "success";
                }
                return response()->json(["color" => $color, "message" => $message]);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function liste_par_classe(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
        $eleves = Eleve::where('classe_id', $req->classe_id)->where('annee_scolaire_id', $anne_id)->with('classe_annuel')->orderBy('matricule', 'asc')->get();
        $classe = Classe::where('id', $req->classe_id)->value('nom_classe');
        if ($user->email_verified_at != null) {
            if (Gate::allows('isResponsable')) {
                $resp_id = Responsable::where('user_id', $user_id)->value('id');
                $data = [
                    'title' => "",
                    'indice' => 1,
                    'eleves' => $eleves,
                    'classe' => $classe,
                    'classe_id' => $req->classe_id
                ];
                return view('responsables.eleve_inscrits.tries_eleves.liste_etud', $data);
            } elseif (Gate::allows('isProfesseur')) {
                $prof_id = Professeur::where('user_id', $user_id)->value('id');
                $data = [
                    'title' => "",
                    'indice' => 1,
                    'eleves' => $eleves,
                    'classe' => $classe,
                    'classe_id' => $req->classe_id
                ];
                return view('professeurs.etudiants.inscrits.afficher_par_classe', $data);
            } elseif (Gate::allows('isDirecteur')) {
                $data = [
                    'title' => "",
                    'indice' => 1,
                    'eleves' => $eleves,
                    'classe' => $classe,
                    'classe_id' => $req->classe_id
                ];
                return view('Directeur.etudiants.liste_par_classe', $data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function nouvelle_photo(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $data = [
                    'title' => "",
                    'eleve_id' => $req->eleve_id
                ];
                return view('responsables.config_etud.photo', $data);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function update_photo_etud(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            if ($req->hasFile('img_etud')) {
                $eleve = Eleve::where('id', $req->eleve_id)->first();
                $image = $req->file('img_etud');
                $imageName = "Etud_" . $eleve->matricule;
                $photo = $imageName . time() . '.' . $image->getClientOriginalExtension();

                if ($eleve->photo != null) {
                    $imagePath = public_path('/assets/img/users' . $eleve->photo);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $updateEtud = Eleve::where('id', $req->eleve_id)->update(['photo' => $photo]);
                $updateUser = User::where('id', $eleve->user_id)->update(['photo' => $photo]);

                if ($updateEtud && $updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->img_etud->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Modification avec succès!";
                } else {
                    $icon = "error";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['color' => $icon, 'message' => $message, 'photo' => $photo]);
            } else {
                return back();
            }
        }
    }

    public function editer_information(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classes = Classe::orderBy('nom_classe', 'asc')->get();
                $eleve = Eleve::find($req->eleve_id);
                $data = [
                    'title' => "",
                    'eleve_id' => $req->eleve_id,
                    'classes' => $classes,
                    'eleve' => $eleve
                ];
                return view('responsables.config_etud.infos', $data);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function update_info(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Eleve::where('id', $req->eleves_id)->value('user_id');
            $name = ucfirst($req->nom) . ' ' . ucfirst($req->prenom);
            $userUpdate = User::where('id', $user_id)->update(['name' => $name, 'email' => $req->email, 'contact' => $req->contact1, 'updated_at' => Now()]);
            $eleveUpdate = Eleve::where('id', $req->eleves_id)->update([
                'nom' => $req->nom, 'prenom' => $req->prenom, 'email' => $req->email, 'matricule' => $req->matricule, 'date_naissance' => $req->date_naiss, 'lieu_naissance' => $req->lieu_naiss, 'sexe' => $req->sexe, 'adresse' => $req->adresse, 'nationalite' => $req->nationalite, 'contact_prim' => $req->contact1, 'nom_pere' => $req->pere, 'nom_mere' => $req->mere, 'maladie' => $req->maladie, 'contact_seco' => $req->contact2, 'classe_id' => $req->classe, 'observation' => $req->information, 'updated_at' => Now()
            ]);
            if ($userUpdate && $eleveUpdate) {
                $icon = "success";
                $message = "Modification avec succès!";
            } else {
                $icon = "danger";
                $message = "Veuillez-réessayer!";
            }
            return response()->json(['icon' => $icon, 'message' => $message]);
        }
    }

    public function payer_scolarite(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classes = Classe::orderBy('nom_classe', 'asc')->get();
                $eleve = Eleve::find($req->eleve_id);
                $data = [
                    'title' => "",
                    'eleve_id' => $req->eleve_id,
                ];
                return view('responsables.config_etud.paie_scolarite', $data);
            } else {
                return view('auth.verify');
            }
        }
    }
    public function abscence_etud(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $classes = Classe::orderBy('nom_classe', 'asc')->get();
        $eleve = Eleve::find($req->eleve_id);
        $anne_id = AnneeScoActuel::value('annee_scolaire_id');
        if ($user->email_verified_at != null) {
            if (Gate::allows('isProfesseur')) {
                $prof_id = Professeur::where('user_id', $user_id)->value('id');
                $cours = Cour::where('annee_scolaire_id', $anne_id)->where('professeur_id', $prof_id)->where('classe_id', $eleve->classe_id)->with('matiere')->get();
                $data = [
                    'title' => "",
                    'eleve_id' => $req->eleve_id,
                    'cours' => $cours
                ];

                return view('professeurs.etudiants.inscrits.abscence', $data);
            } else {
                return route('home');
            }
        } else {
            return view('auth.verify');
        }
    }

    public function fiche_abscence_etudiant()
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $abscences = Abscence::with('etudiant')->with('cour')->orderBy('date_absence', 'desc')->get();
                $classe = Classe::all();
                $data = [
                    'title' => "",
                    'indice' => 1,
                    'abscences' => $abscences,
                    'classe' => $classe,
                ];
                return view('responsables.eleve_inscrits.fiche_etudiant', $data);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function liste_eleves(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classe = Classe::all();
                if ($req->date_debut == null) {
                    $abscences = Abscence::with('etudiant')->with('cour')->orderBy('date_absence', 'desc')->get();
                } elseif ($req->date_debut != null && $req->date_fin == null) {
                    $abscences = Abscence::where('date_absence', $req->date_debut)->with('etudiant')->with('cour')->orderBy('date_absence', 'desc')->get();
                } else {
                    $abscences = Abscence::whereBetween('date_absence', [$req->date_debut, $req->date_fin])->with('etudiant')->with('cour')->orderBy('date_absence', 'desc')->get();
                }

                $data = [
                    'title' => "",
                    'indice' => 1,
                    'abscences' => $abscences,
                    'classe' => $classe,
                ];
                return view('responsables.eleve_inscrits.tries_eleves.liste_abscence', $data);
            } else {
                return view('auth.verify');
            }
        }
    }

    public function liste_etudiant_prof()
    {
        if (Gate::allows('isProfesseur')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $prof_id = Professeur::where('user_id', $user_id)->value('id');
            $anne_id = AnneeScoActuel::where('id', 1)->value('annee_scolaire_id');
            if ($user->email_verified_at != null) {
                $cours = Cour::where('professeur_id', $prof_id)->where('annee_scolaire_id', $anne_id)->get();
                $classe_id = [];
                foreach ($cours as $cour) {
                    array_push($classe_id, $cour->classe_id);
                }
                $classes = Classe::whereIn('id', $classe_id)->orderBy('nom_classe', 'asc')->get();
                $data = [
                    'title' => "",
                    "classes" => $classes
                ];
                return view('professeurs.etudiants.liste_eleve', $data);
            } else {
                return view('auth.verify');
            }
        } else {
            return route('home');
        }
    }

    public function payement_scolarite(Request $req)
    {
        if (Gate::allows('isResponsable')) {
            $date = date('Y-m-d');
            $scolariteEtud = new Scolarite();
            $scolariteEtud->date_paie = $date;
            $scolariteEtud->montant_paye = $req->montant;
            $scolariteEtud->eleve_id = $req->eleve_id;
            $saveScolaire = $scolariteEtud->save();
            if ($saveScolaire) {
                $icon = "success";
                $message = "Paiement avec succès!";
            } else {
                $icon = "error";
                $message = "Veuillez réessayer!";
            }
            return response()->json(['icon' => $icon, 'message' => $message]);
        }
    }
    public function update_information_professeur(Request $req)
    {
        if (Gate::allows('isProfesseur')) {
            $user_id = Auth::id();
            $prof = Professeur::where('user_id', $user_id)->first();
            if ($req->hasFile('uploadImg_prof')) {
                if ($req->nom_prof == null) {
                    $nom = $prof->nom;
                } else {
                    $nom = $req->nom_prof;
                }
                if ($req->prenom_prof == null) {
                    $prenom = $prof->prenom;
                } else {
                    $prenom = $req->prenom_prof;
                }
                if ($req->adresse_prof == null) {
                    $adresse = $prof->adresse;
                } else {
                    $adresse = $req->adresse_prof;
                }
                if ($req->cin_prof == null) {
                    $cin = $prof->cin;
                } else {
                    $cin = $req->cin_prof;
                }
                if ($req->nationalite_prof == null) {
                    $nationalite = $prof->nationalite;
                } else {
                    $nationalite = $req->nationalite_prof;
                }
                if ($req->contact1_prof == null) {
                    $contact1 = $prof->contact1;
                } else {
                    $contact1 = $req->contact1_prof;
                }
                if ($req->sexe_prof == null) {
                    $sexe = $prof->sexe;
                } else {
                    $sexe = $req->sexe_prof;
                }
                if ($req->matricule_prof == null) {
                    $matricule = $prof->matricule;
                } else {
                    $matricule = $req->matricule_prof;
                }
                if ($req->date_emb_prof == null) {
                    $date_embauche = $prof->date_embauche;
                } else {
                    $date_embauche = $req->date_emb_prof;
                }
                if ($req->contrat_prof == null) {
                    $type_contrat = $prof->type_contrat;
                } else {
                    $type_contrat = $req->contrat_prof;
                }
                if ($req->email_prof == null) {
                    $email = $prof->email;
                } else {
                    $email = $req->email_prof;
                }
                if ($req->contact2_prof == null) {
                    $contact2 = $prof->contact2;
                } else {
                    $contact2 = $req->contact2_prof;
                }

                $image = $req->file('uploadImg_prof');
                $imageName = "prof_" . $matricule;
                $photo = $imageName . time() . '.' . $image->getClientoriginalExtension();

                if ($prof->image != null) {
                    $imagePath = public_path('/assets/img/users/' . $prof->image);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $name = ucfirst($nom) . ' ' . ucfirst($prenom);
                $updateprof = Professeur::where('id', $prof->id)->update(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'matricule' => $matricule, 'sexe' => $sexe, 'adresse' => $adresse, 'cin' => $cin, 'nationalite' => $nationalite, 'contact1' => $contact1, 'contact2' => $contact2, 'image' => $photo, 'type_contrat' => $type_contrat, 'date_embauche' => $date_embauche, 'updated_at' => Now()]);

                $updateUser = User::where('id', $user_id)->update(['name' => $name, 'email' => $email, 'photo' => $photo, 'contact' => $contact1, 'updated_at' => Now()]);
                if ($updateprof && $updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->uploadImg_prof->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Informations bien enregistrée!";
                } else {
                    $icon = "danger";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['icon' => $icon, 'message' => $message]);
            } else {
                return back();
            }
        }
    }

    public function liste_abscence()
    {
        if (Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id', $user_id)->first();
            $resp_id = Responsable::where('user_id', $user_id)->value('id');
            if ($user->email_verified_at != null) {
                $classe = Classe::all();
                $abscences = Abscence::with('etudiant')->with('cour')->orderBy('date_absence', 'desc')->get();
                $data = [
                    'title' => "",
                    'indice' => 1,
                    'abscences' => $abscences,
                    'classe' => $classe,
                ];
                return view('responsables.eleve_inscrits.tries_eleves.liste_abscence', $data);
            } else {
                return view('auth.verify');
            }
        }
    }

    public function update_information_etudiant(Request $req){
        if (Gate::allows('isEtudiant')) {
            $user_id = Auth::id();
            $etudiant = Eleve::where('user_id', $user_id)->first();
            if ($req->hasFile('uploadImg_etud')) {

                $image = $req->file('uploadImg_etud');
                $imageName = "Etud_" . $etudiant->matricule;
                $photo = $imageName . time() . '.' . $image->getClientoriginalExtension();

                if ($etudiant->photo != null) {
                    $imagePath = public_path('/assets/img/users/' . $etudiant->photo);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $updateEtudiant = Eleve::where('id', $etudiant->id)->update(['lieu_naissance' => $req->lieu_naiss, 'photo' => $photo, 'updated_at' => Now()]);

                $updateUser = User::where('id', $user_id)->update(['photo' => $photo,'updated_at' => Now()]);
                if ($updateEtudiant && $updateUser) {
                    $destinationPath = public_path('/assets/img/users');
                    $req->uploadImg_etud->move($destinationPath, $photo);
                    $icon = "success";
                    $message = "Informations bien enregistrée!";
                } else {
                    $icon = "danger";
                    $message = "Veuillez réesaayer svp!";
                }
                return response()->json(['icon' => $icon, 'message' => $message]);
            } else {
                return back();
            }
        }
    }

    public function updatePassword(Request $req) {
        $user_id = Auth::id();
        $newPassword = Hash::make($req->pwd);
        $updateUserPwd = User::where('id',$user_id)->update(['password'=>$newPassword]);
        if ($updateUserPwd) {
           $icon = "success";
           $message = "Modification de mot de passe avec succès!";
        }else{
            $icon = "danger";
           $message = "Veuillez réessayer svp!";
        }

        return response()->json([
            'icon'=> $icon,
            'message'=> $message
        ]);
    }
}
