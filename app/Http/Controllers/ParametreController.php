<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\AnneeScoActuel;
use App\Models\AnneeScolaire;
use App\Models\Matiere;
use App\Models\Ecole;
use App\Models\Module;
use App\Models\Classe;
use App\Models\User;
use DataTables;
use File;

class ParametreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            if ($user->email_verified_at != null) {
                $title = "Ajout année scolaire";
                return view('parametres.anneeSco',compact('title'));
            } else {
                return view('auth.verify');
            }
        }elseif(Gate::allows('isProfesseur') || Gate::allows('isEtudiant')){
            if ($user->email_verified_at != null) {
                $title = "Liste années scolaires";
                $indice = 1;
                $annees = AnneeScolaire::orderBy('id','desc')->get();
                return view('configurations.liste_anne',compact('title','annees','indice'));
            } else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }

    }

    public function new_annee_scol()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
    	    return view('parametres.annee_scolaires.new_annee_scol');
        } else {
            return view('auth.verify');
        }
    }

    public function add_annee_scol(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            if ($user->email_verified_at != null) {
                $anneeSco = AnneeScolaire::where('annee_sco',$req->anneeSco)->count();
                if ($anneeSco == 0) {
                    $anneeSco = new AnneeScolaire();
                    $anneeSco->annee_sco = $req->anneeSco;
                    $saveAnneeSco = $anneeSco->save();
                    if ($saveAnneeSco) {
                        $message = "Enregistrement avec succès!";
                        $color = "success";
                    } else {
                        $message = "Veuillez réessayer s'il vous plaît!";
                        $color = "error";
                    }

                } else {
                    $message ="Cet année scolaire est déjà enregistrée!";
                    $color = "error";
                }
                return response()->json(["message"=>$message,"color"=>$color]);
            }else {
                return view('auth.verify');
            }
        } else {
            return route('login');
        }
    }

    public function annee_disponible()
    {
        $data = AnneeScolaire::orderBy('id','desc')->get();
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();

        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            if ($user->email_verified_at != null) {
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('', function($row){
                    $actionBtn = '<a class="text-danger suppr_anneeSco" title="Supprimer une année scolaire" href="#" id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns([''])
                ->make(true);
            }else {
                return view('auth.verify');
            }
        }else {
            return route('login');
        }

    }

    public function delete_annee_scol(Request $req)
    {
        $annee = AnneeScolaire::where('id',$req->id)->count();
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            if ($annee>0) {
                $delete = AnneeScolaire::where('id',$req->id)->delete();

                if ($delete) {
                $message ="Suppression avec succès";
                $icon = "success";
                } else {
                    $message = "Veuillez-réessayer svp!";
                    $icon ="error";
                }
                return response()->json(['message'=>$message,'icon'=>$icon]);
            }
            return response()->json();
        }else {
            return view('auth.verify');
        }
    }

    public function liste_anne_scolaire()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $annees = AnneeScolaire::orderBy('annee_sco','desc')->get();
            $anneeActuel = AnneeScoActuel::first();
            return view('parametres.annee_scolaires.select_annee_scol',compact('annees','anneeActuel'));
        }else {
            return view('auth.verify');
        }
    }

    public function update_current_annee(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $current_annee = AnneeScoActuel::count();
            if ($current_annee==0) {
                $annee = new AnneeScoActuel();
                $annee->annee_scolaire_id = $req->id;
                $insertAnne= $annee->save();
            }else{
                $insertAnne = AnneeScoActuel::where('id',1)->update(['annee_scolaire_id'=>$req->id]);
            }

            if ($insertAnne) {
                $message ="Les changements ont bien été pris en compte";
                $color = "success";
            } else {
                $message ="Veuillez-réessayer svp!";
                $color = "danger";
            }
            return response()->json(['message'=>$message,'color'=>$color]);
        }else {
            return view('auth.verify');
        }
    }

    public function getAnneeScoActuel()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $current_annee = AnneeScoActuel::count();
            if ($current_annee==0) {
                $annee="2000-2001";
            }else {
                $annee = AnneeScoActuel::join('annee_scolaires','annee_scolaires.id','=','annee_sco_actuels.annee_scolaire_id')->value('annee_sco');
            }
            return response()->json($annee);
        }else {
            return view('auth.verify');
        }
    }

    public function matiere()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();

        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            if ($user->email_verified_at != null) {
                $title = 'Ajout nouvelle matière';
                return view('parametres.matiere',compact('title'));
            }else {
                return view('auth.verify');
            }
        }elseif(Gate::allows('isProfesseur') || Gate::allows('isEtudiant')) {
            if ($user->email_verified_at != null) {
                $title = 'Listes matières';
                $matieres = Matiere::orderBy('matiere','asc')->get();
                $indice = 1;
                return view('configurations.liste_matiere', compact('matieres','title','indice'));
            }else {
                return view('auth.verify');
            }
        }else {
            return route('login');
        }
    }

    public function new_matiere()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            return view('parametres.matieres.new_matiere');
        }else {
            return view('auth.verify');
        }
    }

    public function add_matiere(Request $req)
    {
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $matiere = Matiere::where('matiere',$req->matiere)->count();
                if ($matiere == 0) {
                    $matiere = new Matiere();
                    $matiere->matiere = $req->matiere;
                    $matiere->abreviation =$req->abrev;
                    $savematiere = $matiere->save();
                    if ($savematiere) {
                        $message = "Enregistrement avec succès!";
                        $color = "success";
                    } else {
                        $message = "Veuillez réessayer s'il vous plaît!";
                        $color = "error";
                    }
                } else {
                    $message ="Cette matière est déjà enregistrée!";
                    $color = "error";
                }
                return response()->json(["message"=>$message,"color"=>$color]);
            }else {
                return view('auth.verify');
            }
        } else {
            return route('login');
        }
    }
    public function matiere_disponible()
    {
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $data = Matiere::orderBy('matiere','asc')->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('', function($row){
                    $actionBtn = '<a class="text-info edit_matiere" title="Modifier une matière" href="#" id="'.$row->id.'"><i class="fas fa-edit"></i></a><a class="text-danger suppr_matiere ml-2" title="Supprimer une matière" href="#" id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns([''])
                ->make(true);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function suppr_matiere(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $matiere = Matiere::where('id',$req->id)->count();
            if ($matiere>0) {
                $delete = Matiere::where('id',$req->id)->delete();
                if ($delete) {
                $message ="Suppression avec succès";
                $icon = "success";
                } else {
                    $message = "Veuillez-réessayer svp!";
                    $icon ="error";
                }
                return response()->json(['message'=>$message,'icon'=>$icon]);
            }
            return response()->json();
        }else {
            return view('auth.verify');
        }
    }

    public function edit_matiere($id)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $matiere = Matiere::find($id);
            return view('parametres.matieres.edit_matiere', compact('matiere'));
        }else {
            return view('auth.verify');
        }
    }

    public function update_matiere(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $matiere_count = Matiere::where('matiere',$req->matiere)->count();
            if ($matiere_count ==0) {
                $update_matiere = Matiere::where('id',$req->matiere_id)->update(["matiere"=>$req->matiere,'abreviation'=>$req->abrev]);
                if ($update_matiere) {
                    $message ="Modifiée avec succès";
                    $icon = "success";
                } else {
                    $message ="Veuillez réessayer s'il vous plaît!!";
                    $icon = "warning";
                }
            } else {
                $message ="Cette matière est déjà enregistrée!!";
                $icon = "error";
            }
            return response()->json(['message'=>$message,'icon'=>$icon]);
        }else {
            return view('auth.verify');
        }
    }

    public function classe()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
                $title = "Ajout nouvelle classe";
                return view('parametres.classe',compact('title'));
            }elseif (Gate::allows('isProfesseur') || Gate::allows('isEtudiant')) {
                $title = "Liste classe";
                $indice = 1;
                $classes = Classe::orderBy('nom_classe','asc')->get();
                return view('configurations.liste_classe',compact('title','classes','indice'));
            }else{
                return route('login');
            }
        }else {
            return view('auth.verify');
        }
    }

    public function new_classe()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            return view('parametres.classes.new_classe');
        }else {
            return view('auth.verify');
        }
    }

    public function add_classe(Request $req)
    {
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $classe = Classe::where('nom_classe',$req->classe)->count();
                if ($classe == 0) {
                    $classe = new classe();
                    $classe->nom_classe = $req->classe;
                    $classe->montant_total = $req->scolarite;
                    $saveclasse = $classe->save();
                    if ($saveclasse) {
                        $message = "Enregistrement avec succès!";
                        $color = "success";
                    } else {
                        $message = "Veuillez réessayer s'il vous plaît!";
                        $color = "error";
                    }
                } else {
                    $message ="Cette classe est déjà enregistrée!";
                    $color = "error";
                }
                return response()->json(["message"=>$message,"color"=>$color]);
            }else {
                return view('auth.verify');
            }
        } else {
            return route('login');
        }
    }

    public function classe_disponible()
    {
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $data = Classe::orderBy('nom_classe','asc')->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('', function($row){
                    $actionBtn = '<a class="text-info edit_classe" title="Modifier une classe" href="#" id="'.$row->id.'"><i class="fas fa-edit"></i></a><a class="text-danger suppr_classe ml-2" title="Supprimer une classe" href="#" id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns([''])
                ->make(true);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function editer_classe(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        $id = $req->classe_id;
        if ($user->email_verified_at != null) {
            $classe = Classe::find($id);
            return view('parametres.classes.edit_classe', compact('classe'));
        }else {
            return view('auth.verify');
        }
    }

    public function update_classe(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $classe_count = Classe::where('nom_classe',$req->classe)->where('montant_total',$req->scolarite)->count();
            if ($classe_count ==0) {
                $update_classe = Classe::where('id',$req->classe_id)->update(["nom_classe"=>$req->classe,'montant_total'=>$req->scolarite]);
                if ($update_classe) {
                    $message ="Modifiée avec succès";
                    $icon = "success";
                } else {
                    $message ="Veuillez réessayer s'il vous plaît!!";
                    $icon = "warning";
                }
            } else {
                $message ="Cette classe est déjà enregistrée!!";
                $icon = "error";
            }
            return response()->json(['message'=>$message,'icon'=>$icon]);
        }else {
            return view('auth.verify');
        }
    }

    public function delete_classe(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $classe = Classe::where('id',$req->classe_id)->count();
            if ($classe>0) {
                $delete = classe::where('id',$req->classe_id)->delete();
                if ($delete) {
                $message ="Suppression avec succès";
                $icon = "success";
                } else {
                    $message = "Veuillez-réessayer svp!";
                    $icon ="error";
                }
                return response()->json(['message'=>$message,'icon'=>$icon]);
            }
            return response()->json();
        }else {
            return view('auth.verify');
        }
    }

    public function ecole()
    {
        if (Gate::allows('isDirecteur')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $title = "Ecole";
                $ecoles = Ecole::orderBy('nom','asc')->get();
                $data = [
                    'title'=> $title,
                    'ecoles'=>$ecoles,
                    'index'=>1
                ];
                return view('parametres.ecole',$data);
            }else {
                return view('auth.verify');
            }
        }elseif (Gate::allows('isProfesseur') || Gate::allows('isEtudiant') || Gate::allows('isResponsable')) {
           return route('home');
        }else{
            return route('login');
        }
    }

    public function new_ecole()
    {
        if (Gate::allows('isDirecteur')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $title = "Modifier nom école";
                return view('parametres.ecoles.new_ecole',compact('title'));
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function add_ecole(Request $req)
    {
        if (Gate::allows('isDirecteur')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $validator = Validator::make($req->all(), [
                    'nom_ecole' => 'required|string|max:255',
                    'slogan' => 'required|string|max:255',
                    'email_ecole' => 'required|email|max:255',
                    'ouverture' => 'required|date',
                    'contact_1'=>'required|numeric|min:10',
                    'logo_ecole'=>'required|image|mimes:jpeg,png,jpg',
                    'heure_ouverture'=>'required',
                    'heure_fermeture'=>'required',
                ], [
                    'nom_ecole.required' => 'Veuillez saisir un nom de l\'école',
                    'slogan.required' => 'Veuillez entrer un slogan',
                    'email_ecole.required' => 'Entrer l\'adresse email de l\'école',
                    'ouverture.required'=>'Veuillez entrer la date d\'ouverture',
                    'contact_1.required' => 'Veuillez entrer un numéro de téléphone',
                    'logo_ecole.required' => 'Choisissez un logo',
                    'logo_ecole.image'=>'Veuillez choisir une correcte image',
                    'logo_ecole.image'=>'L\'image doit être soit jpg soit jpeg soit png',
                    'email_ecole.email' => 'Veuillez entrer un email correct',
                    'ouverture.date' => 'Veuillez saisir une date correcte',
                    'contact_1.numeric' => 'Le numéro de téléphone doit être des chifres',
                    'contact_1.min' => 'Le numéro de téléphone doit être minimum 10 chifres',
                    'heure_ouverture'=>'L\'heure d\'ouverture ne doit pas être vide',
                    'heure_fermeture'=>'L\'heure de ferme ture ne doit pas être vide',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $count_ecole = Ecole::where('nom',$req->nom_ecole)->where('email',$req->email_ecole)->where('logo',$req->logo_ecole)->count();
                    if ($count_ecole==0) {
                        $ecole = new Ecole();
                        if($req->hasFile('logo_ecole')){
                            $image =$req->file('logo_ecole');
                            $imageName =str_replace(" ","_",$req->nom_ecole);
                            $logo=$imageName.time().'.'.$image->getClientoriginalExtension();
                            $ecole->nom=$req->nom_ecole;
                            $ecole->slogan=$req->slogan;
                            $ecole->logo =$logo;
                            $ecole->email = $req->email_ecole;
                            $ecole->phone1= $req->contact_1;
                            $ecole->phone2=$req->contact_2;
                            $ecole->date_ouverture=$req->ouverture;
                            $ecole->heure_ouverture=$req->heure_ouverture;
                            $ecole->heure_fermeture =$req->heure_fermeture;
                            $saveEcole =$ecole->save();
                            if($saveEcole){
                                $destinationPath = public_path('/assets/img/ecoles');
                                $req->logo_ecole->move($destinationPath, $logo);
                                return redirect('/ecole')->with('success','Enregistrement avec succès');
                            }else{
                                return redirect()->back()->with('error','Veuillez réessayer!');
                            }
                        }
                        else{
                            return back();
                        }
                    } else {
                        return redirect()->back()->with('warning','Cet école est déjà enregistrée');
                    }
                }
            }else {
                return view('auth.verify');
            }
        }elseif (Gate::allows('isResponsable')) {

        }else{
            return route('login');
        }
    }

    public function edit_ecole($id)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if (Gate::allows('isDirecteur')) {
            if ($user->email_verified_at != null) {
                $ecole = Ecole::find($id);
                $data = [
                    'title'=>'Modifier information de l\'école',
                    'ecole'=>$ecole
                ];
                return view('parametres.ecoles.edit_ecole',$data);
            }else {
                return view('auth.verify');
            }
        } else {
            return route('login');
        }
    }

    public function update_ecole(Request $req,$id)
    {
        if (Gate::allows('isDirecteur')){
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $count_ecole = Ecole::where('email',$req->email_ecole)->count();
                if ($count_ecole<=1) {
                    $updateEcole = Ecole::where('id',$id)->update(['nom'=>$req->nom_ecole_update,'slogan'=>$req->slogan_update,'email'=>$req->email_ecole_update,'phone1'=>$req->contact_1_update,'phone2'=>$req->contact_2_update,'date_ouverture'=>$req->ouverture_update,'heure_ouverture'=>$req->heure_ouverture_update,'heure_fermeture'=>$req->heure_fermeture_update]);
                    if($updateEcole){
                        if($req->hasFile('logo_ecole_update')){
                            $image =$req->file('logo_ecole_update');
                            $imageName =str_replace(" ","_",$req->nom_ecole);
                            $logo=$imageName.time().'.'.$image->getClientoriginalExtension();

                            $ecole_logo = Ecole::where('id',$id)->value('logo');
                            $imagePath = public_path('/assets/img/ecoles/'.$ecole_logo);
                            if (File::exists($imagePath)){
                                unlink($imagePath);
                            }
                            $updateLogo =Ecole::where('id',$id)->update(['logo'=> $logo]);

                            if($updateLogo){
                                $destinationPath = public_path('/assets/img/ecoles');
                                $req->logo_ecole_update->move($destinationPath, $logo);

                                return redirect('/ecole')->with('success','Modification avec succès');
                            }else{
                                return redirect()->back()->with('error','Veuillez réessayer!');
                            }
                        }else{
                            return redirect('/ecole')->with('success','Modification avec succès');
                        }
                    }else{
                        return redirect()->back()->with('error','Veuillez réessayer!');
                    }
                } else {
                    return redirect()->back()->with('warning','Cet école est déjà enregistrée');
                }
            }else {
                return view('auth.verify');
            }
        }elseif (Gate::allows('isResponsable')) {

        }else{
            return route('login');
        }
    }

    public function module()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
                $title = "Ajout nouvelle module";
                return view('parametres.module',compact('title'));
            }elseif (Gate::allows('isProfesseur') || Gate::allows('isEtudiant')) {
                $data = [
                    "title"=>"Liste module",
                    "indice"=>1,
                    "modules"=>Module::orderBy('trimestre','asc')->get()
                ];
                return view('configurations.liste_module',$data);
            }else{
                return route('login');
            }
        }else {
            return view('auth.verify');
        }
    }

    public function new_module()
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            return view('parametres.modules.new_module');
        }else {
            return view('auth.verify');
        }
    }

    public function add_module(Request $req)
    {
         if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $module = Module::where('trimestre',$req->modules)->count();
                if ($module == 0) {
                    $module = new Module();
                    $module->trimestre = $req->modules;
                    $savemodule = $module->save();
                    if ($savemodule) {
                        $message = "Enregistrement avec succès!";
                        $color = "success";
                    } else {
                        $message = "Veuillez réessayer s'il vous plaît!";
                        $color = "error";
                    }
                } else {
                    $message ="Cette module est déjà enregistrée!";
                    $color = "error";
                }
                return response()->json(["message"=>$message,"color"=>$color]);
            }else {
                return view('auth.verify');
            }
        } else {
            return route('login');
        }
    }

    public function module_disponible()
    {
        if (Gate::allows('isDirecteur') || Gate::allows('isResponsable')) {
            $user_id = Auth::id();
            $user = User::where('id',$user_id)->first();
            if ($user->email_verified_at != null) {
                $data = Module::orderBy('trimestre','asc')->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('', function($row){
                    $actionBtn = '<a class="text-info edit_module" title="Modifier une module" href="#" id="'.$row->id.'"><i class="fas fa-edit"></i></a><a class="text-danger suppr_module ml-2" title="Supprimer une module" href="#" id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns([''])
                ->make(true);
            }else {
                return view('auth.verify');
            }
        }else{
            return route('login');
        }
    }

    public function editer_module(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        $id = $req->module_id;
        if ($user->email_verified_at != null) {
            $module = Module::find($id);
            return view('parametres.modules.edit_module', compact('module'));
        }else {
            return view('auth.verify');
        }
    }

    public function update_module(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $module_count = Module::where('trimestre',$req->modules)->count();
            if ($module_count ==0) {
                $update_module = Module::where('id',$req->module_id)->update(["trimestre"=>$req->modules]);
                if ($update_module) {
                    $message ="Modifiée avec succès";
                    $icon = "success";
                } else {
                    $message ="Veuillez réessayer s'il vous plaît!!";
                    $icon = "warning";
                }
            } else {
                $message ="Cette module est déjà enregistrée!!";
                $icon = "error";
            }
            return response()->json(['message'=>$message,'icon'=>$icon]);
        }else {
            return view('auth.verify');
        }
    }

    public function delete_module(Request $req)
    {
        $user_id = Auth::id();
        $user = User::where('id',$user_id)->first();
        if ($user->email_verified_at != null) {
            $module = Module::where('id',$req->module_id)->count();
            if ($module>0) {
                $delete = Module::where('id',$req->module_id)->delete();
                if ($delete) {
                $message ="Suppression avec succès";
                $icon = "success";
                } else {
                    $message = "Veuillez-réessayer svp!";
                    $icon ="error";
                }
                return response()->json(['message'=>$message,'icon'=>$icon]);
            }
            return response()->json();
        }else {
            return view('auth.verify');
        }
    }
}
