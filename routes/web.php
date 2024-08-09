<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\TempController;
use App\Http\Controllers\DownloadPdfController;
use App\Http\Controllers\PayementController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);
Route::fallback(function () {
    return view('errors.404');
});
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get("/annee/scolaire", [ParametreController::class, 'index'])->name('anneeScol');
    Route::get("/nouveau/annee/scolaire", [ParametreController::class, 'new_annee_scol'])->name('new_annee_scol');
    Route::get("/liste/annee/scolaire", [ParametreController::class, 'liste_anne_scolaire']);
    Route::get("/anneescolaire/disponible", [ParametreController::class, "annee_disponible"]);
    Route::get('/get/AnneeScoActuel', [ParametreController::class, "getAnneeScoActuel"]);
    Route::post('/add/new/anneescolaire', [ParametreController::class, 'add_annee_scol']);
    Route::post("/supprimer/anneescolaire", [ParametreController::class, "delete_annee_scol"]);
    Route::post("/update/current/anneescolaire", [ParametreController::class, "update_current_annee"]);

    Route::get("/matiere", [ParametreController::class, 'matiere'])->name('matiere');
    Route::get("/nouvelle/matiere", [ParametreController::class, "new_matiere"]);
    Route::post("/add/new/matiere", [ParametreController::class, "add_matiere"]);
    Route::get("/matiere/disponible", [ParametreController::class, "matiere_disponible"]);
    Route::post("/supprimer/matiere", [ParametreController::class, "suppr_matiere"]);
    Route::get("/edit/matiere/{id}", [ParametreController::class, "edit_matiere"]);
    Route::post('/update/matiere', [ParametreController::class, "update_matiere"]);

    Route::get('/classe', [ParametreController::class, "classe"])->name('classe');
    Route::get('/nouvelle/classe', [ParametreController::class, "new_classe"])->name('new_classe');
    Route::post('/add/new/classe', [ParametreController::class, "add_classe"]);
    Route::get('/classe/disponible', [ParametreController::class, "classe_disponible"]);
    Route::post('/editer/classe', [ParametreController::class, "editer_classe"]);
    Route::post('/update/classe', [ParametreController::class, 'update_classe']);
    Route::post('/delete/classe', [ParametreController::class, 'delete_classe']);

    Route::get('/module', [ParametreController::class, 'module'])->name('module');
    Route::get('/nouvelle/module', [ParametreController::class, 'new_module'])->name('new_module');
    Route::post('/add/module', [ParametreController::class, 'add_module']);
    Route::get('/module/disponible', [ParametreController::class, 'module_disponible']);
    Route::post('/editer/module', [ParametreController::class, 'editer_module']);
    Route::post('/update/module', [ParametreController::class, 'update_module']);
    Route::post('/delete/module', [ParametreController::class, 'delete_module']);

    Route::get('/ecole', [ParametreController::class, "ecole"])->name('ecole');
    Route::get('/nouveau/ecole', [ParametreController::class, 'new_ecole'])->name('new_ecole');
    Route::post('/ajouter/ecole', [ParametreController::class, 'add_ecole'])->name('add_ecole');
    Route::get('/editer/ecole/{id}', [ParametreController::class, 'edit_ecole'])->name('edit_ecole');
    Route::post('/modifier/ecole/{id}', [ParametreController::class, 'update_ecole'])->name('update_ecole');
});

Route::group([
    "middleware" => ["auth", "auth.directeur"],
    'as' => 'admin.'
], function () {
    Route::group([
        "prefix" => "directeur",
        'as' => 'directeur.'
    ], function () {
        Route::get('/profile', [HomeController::class, 'profile'])->name('directeur.profile');
        Route::get('/photo_profile', [UtilisateurController::class, 'photo_profile']);
        Route::post('/update/profile', [UtilisateurController::class, 'update_profile']);
        Route::post('/update/information', [UtilisateurController::class, 'update_information']);
        Route::post('/update_password',[UtilisateurController::class,'updatePassword']);
    });
    Route::group([
        "prefix" => "responsable",
        'as' => 'responsable.'
    ], function () {
        Route::get('/nouveau', [UtilisateurController::class, 'new_responsable'])->name('new_responsable');
        Route::get('/liste', [UtilisateurController::class, 'responsable'])->name('responsable');
        Route::post('/ajouter', [UtilisateurController::class, 'add_responsable'])->name('add_responsable');
        Route::post('/supprimer', [UtilisateurController::class, 'supprimer_responsable'])->name('supprimer_responsable');
    });
    Route::group([
        "prefix" => "emploi_temp",
        'as' => 'emploi_temp.'
    ], function () {
        Route::get('/liste/emploidutemps', [TempController::class, 'emploi_du_temps'])->name('emploi_temps');
    });
    Route::group([
        "prefix" => "eleves",
        'as' => 'eleves.'
    ], function () {
        Route::get('/liste/classe', [UtilisateurController::class, 'liste_etudiant'])->name('liste_classe');
        Route::get('/detaille/{id}', [UtilisateurController::class, 'details_etudiant'])->name('admin.detail');
        Route::post('/listes/par_classes', [UtilisateurController::class, 'liste_par_classe']);
        Route::get('/imprimer_listes/{id}', [DownloadPdfController::class, 'imprimer_liste'])->name('imprimer_listes');
    });
    Route::group([
        "prefix" => "professeur",
        'as' => 'professeur.'
    ], function () {
        Route::get('/nouveau', [UtilisateurController::class, 'new_prof'])->name('new_prof');
        Route::post('/ajouter/professeurs', [UtilisateurController::class, 'add_prof']);
        Route::post('/supprimer', [UtilisateurController::class, 'supprimer_prof'])->name('supprimer_prof');
        Route::post('/restaurer', [UtilisateurController::class, 'restaurer_prof'])->name('restaurer_prof');
        Route::get('/listes', [UtilisateurController::class, 'professeur'])->name('professeurs');
        Route::get('/fiche/presence', [UtilisateurController::class, 'fiche_prof'])->name('fiche_prof');
    });
});

Route::group([
    "middleware" => ["auth", "auth.responsable"],
    'as' => 'resp.'
], function () {
    Route::group([
        "prefix" => "config",
        'as' => "config."
    ], function () {
        Route::post('/information', [UtilisateurController::class, 'update_information_resp']);
    });
    Route::group([
        "prefix" => "professeur",
        'as' => "professeur."
    ], function () {
        Route::get('/liste', [UtilisateurController::class, 'professeur'])->name('liste_prof');
        Route::post('/add_fiche_presence', [TempController::class, "add_fiche_presence"]);
        Route::get('/liste/presence', [UtilisateurController::class, 'fiche_prof'])->name('resp.fiche_prof');
    });
    Route::group([
        "prefix" => "etudiant",
        'as' => "etudiant."
    ], function () {
        Route::get('/inscription', [UtilisateurController::class, 'inscription'])->name('inscription');
        Route::get('/liste', [UtilisateurController::class, 'liste_etudiant'])->name('liste_etudiant');
        Route::get('/details/{id}', [UtilisateurController::class, 'details_etudiant'])->name('details_etudiant');
        Route::get('/informations', [UtilisateurController::class, 'informations_inscrits']);
        Route::post('/add_etudiant', [UtilisateurController::class, 'add_etudiant']);
        Route::post('/liste/par_classe', [UtilisateurController::class, 'liste_par_classe']);
        Route::post('/photo', [UtilisateurController::class, 'nouvelle_photo']);
        Route::post('/update/photo', [UtilisateurController::class, 'update_photo_etud']);
        Route::post('/editer_information', [UtilisateurController::class, 'editer_information']);
        Route::post('/update_info', [UtilisateurController::class, 'update_info']);
        Route::post('/payement/scolarite', [UtilisateurController::class, 'payer_scolarite']);
        Route::post('/payement_scolarite', [UtilisateurController::class, 'payement_scolarite']);
        Route::get('/bulletin/{id}', [TempController::class, 'bulletin_etud'])->name('bulletin_etud');


        Route::get('/imprimer/{id}', [DownloadPdfController::class, 'imprimer_details_etudiant'])->name('imprimer_details_etudiant');
        Route::get('/imprimer_liste/{id}', [DownloadPdfController::class, 'imprimer_liste'])->name('imprimer_liste');
        Route::get('/imprimer_bulletin/{eleve_id}/{module_id}', [DownloadPdfController::class, 'imprimer_bulletin'])->name('imprimer_bulletin');
    });
    Route::group([
        "prefix" => "notes",
        "as" => "notes."
    ], function () {
        Route::get('/classe', [TempController::class, 'note_classe'])->name('note_classe');
        Route::post('/liste_note_classe', [TempController::class, 'liste_note_classe']);
    });
    Route::group([
        "prefix" => "fiche",
        "as" => "fiche."
    ], function () {
        Route::get('/abscence', [UtilisateurController::class, 'fiche_abscence_etudiant'])->name('fiche_abscence');
        Route::post('/liste_eleve', [UtilisateurController::class, 'liste_eleves']);
        Route::post('/form-update-abscence', [TempController::class, 'form_update_abscence']);
        Route::post('/ajout-motif', [TempController::class, 'ajout_motif']);
        Route::get('/liste-abscence', [UtilisateurController::class, 'liste_abscence']);
    });
    Route::group([
        "prefix" => "responsable",
        'as' => "responsable."
    ], function () {
        Route::get('/listes', [UtilisateurController::class, 'responsable'])->name('resp.liste');
        Route::get('/profile', [HomeController::class, 'profile'])->name('resp.profile');
        Route::get('/photo_profile', [UtilisateurController::class, 'photo_profile']);
        Route::post('/update/profile', [UtilisateurController::class, 'update_profile']);
        Route::post('/update/information', [UtilisateurController::class, 'update_information']);
    });
    Route::group([
        "prefix" => "cours",
        'as' => "cours."
    ], function () {
        Route::get('/emploi/du/temps', [TempController::class, 'emploi_du_temps'])->name('emploi_du_temps');
    });
    Route::group([
        "prefix" => "cantines",
        'as' => "cantines."
    ], function () {
        Route::get('/payement', [PayementController::class, 'payement'])->name('payement');
        Route::get('/statistique', [PayementController::class, 'statistique'])->name('statistique');
        Route::post('/select_matricule', [PayementController::class, 'select_matricule']);
        Route::post('/afficher_eleves', [PayementController::class, 'afficher_eleves']);
        Route::post('/form-payer', [PayementController::class, 'form_payer']);
        Route::post('/enregitrer_payement', [PayementController::class, 'enregitrer_payement']);
        Route::post('/details', [PayementController::class, 'afficher_details_cantine']);
    });
    Route::group([
        "prefix" => "transport",
        'as' => "transport."
    ], function () {
        Route::get('/scolaire', [PayementController::class, 'transport_scolaire'])->name('transport_scolaire');
        Route::post('/select_matricule', [PayementController::class, 'select_matricule']);
        Route::post('/afficher_eleves', [PayementController::class, 'afficher_transport_eleve']);
        Route::post('/form-payer', [PayementController::class, 'form_payer_transport']);
        Route::post('/enregitrer_transport', [PayementController::class, 'enregitrer_transport']);
        Route::get('/statistique_transports', [PayementController::class, 'statistique_transport'])->name('statistique_transport');
        Route::post('/details', [PayementController::class, 'transport_details']);
    });
    Route::group([
        "prefix" => "scolarite",
        'as' => "scolarite."
    ], function () {
        Route::get('/paiements', [PayementController::class, 'paie_scolarite'])->name('scolarite');
        Route::post('/select_matricule', [PayementController::class, 'select_matricule']);
        Route::post('/afficher_eleves', [PayementController::class, 'afficher_scolarite_etudiant']);
        Route::post('/form-payer', [UtilisateurController::class, 'payer_scolarite']);
        Route::post('/payement_scolarite', [UtilisateurController::class, 'payement_scolarite']);
        Route::get('/statistiques', [PayementController::class, 'statistique_scolarite'])->name('statistique_scolarite');
    });
});

Route::group([
    "middleware" => ["auth", "auth.professeur"],
    'as' => 'prof.'
], function () {
    Route::group([
        "prefix" => "configuration",
        'as' => 'configuration.'
    ], function () {
        Route::post('/information', [UtilisateurController::class, 'update_information_professeur'])->name('info.prof');
        Route::post('/update_password',[UtilisateurController::class,'updatePassword']);
    });
    Route::group([
        "prefix" => "responsable",
        'as' => 'responsable.'
    ], function () {
        Route::get('/etats', [UtilisateurController::class, 'responsable'])->name('liste.resp');
    });
    Route::group([
        "prefix" => "cour",
        'as' => 'cour.'
    ], function () {
        Route::get('/page_cours', [TempController::class, 'emploi_du_temps'])->name('prof.cours');
        Route::post('/enregistrer', [TempController::class, 'save_cours']);
        Route::get('/liste/disponible', [TempController::class, 'listeCoursDisponible']);
    });
    Route::group([
        "prefix" => "eleves",
        'as' => 'eleves.'
    ], function () {
        Route::get('/listes', [UtilisateurController::class, 'liste_etudiant_prof'])->name('liste.eleve');
        Route::post('/liste/par_classe', [UtilisateurController::class, 'liste_par_classe']);
        Route::get('/details/{id}', [UtilisateurController::class, 'details_etudiant'])->name('details_etudiant');
        Route::post('/abscence', [UtilisateurController::class, 'abscence_etud']);
        Route::post('/enregistrer_abscence', [TempController::class, 'enregistrer_abscence']);
        Route::post('/form_add_note', [TempController::class, 'form_add_note']);
        Route::post('/add_note', [TempController::class, 'add_note']);
    });
    Route::group([
        "prefix" => "notes",
        'as' => 'notes.'
    ], function () {
        Route::get('/listes', [TempController::class, 'liste_notes'])->name('liste_notes');
        Route::post('/select_matricule', [PayementController::class, 'select_matricule']);
        Route::post('/details', [TempController::class, 'detail_note_classe']);
    });
    Route::group([
        "prefix" => "profile",
        'as' => 'profile.'
    ], function () {
        Route::get('/utilisateur', [HomeController::class, 'profile'])->name('prof_profil');
        Route::get('/photo_profile', [UtilisateurController::class, 'photo_profile']);
        Route::post('/update', [UtilisateurController::class, 'update_profile']);
        Route::post('/update/information', [UtilisateurController::class, 'update_information']);
    });
});


Route::group([
    "middleware" => ["auth", "auth.etudiant"],
    'as' => 'etudiant.'
], function () {
    Route::group([
        "prefix" => "responsable",
        'as' => 'responsable.'
    ], function () {
        Route::get('/disponible', [UtilisateurController::class, 'responsable'])->name('liste.dispo');
    });
    Route::group([
        "prefix" => "professeur",
        'as' => "professeur."
    ], function () {
        Route::get('/disponible', [UtilisateurController::class, 'professeur'])->name('liste_prof_dispo');
    });
    Route::group([
        "prefix" => "notes",
        'as' => "notes."
    ], function () {
        Route::get('/download/{eleve_id}/{module_id}', [DownloadPdfController::class, 'imprimer_bulletin'])->name('download');
    });
    Route::group([
        "prefix" => "hitsorique",
        'as' => "hitsorique."
    ], function () {
        Route::get('/abscence', [TempController::class,'historique_abscence'])->name('historique_abscence');
    });
    Route::group([
        "prefix" => "paiements",
        'as' => "paiements."
    ], function () {
        Route::get('/cantine', [PayementController::class, 'cantine_etudiant'])->name('paye_cantine');
        Route::get('/scolarite', [PayementController::class, 'scolarite_etudiant'])->name('paye_scolarite');
        Route::get('/transport', [PayementController::class, 'transport_etudiant'])->name('paye_transport');
    });
    Route::group([
        "prefix" => "classes",
        'as' => 'classes.'
    ], function () {
        Route::get('/cours', [TempController::class, 'emploi_du_temps'])->name('liste_cours');
        Route::get('/camarades',[TempController::class,'liste_classe'])->name('camarade_classe');
        Route::get('/notes',[TempController::class,'liste_notes'])->name('note.etud');
        Route::post('/detils/note',[TempController::class,"detail_note_classe"]);
    });
    Route::group([
        "prefix" => "profile",
        'as' => 'profile.'
    ], function () {
        Route::post('/configuration',[UtilisateurController::class,'update_information_etudiant']);
        Route::get('/etudiant', [HomeController::class, 'profile'])->name('etud_profil');
        Route::get('/photo', [UtilisateurController::class, 'photo_profile']);
        Route::post('/updated', [UtilisateurController::class, 'update_profile']);
        Route::post('/modifier/information', [UtilisateurController::class, 'update_information']);
    });
});
