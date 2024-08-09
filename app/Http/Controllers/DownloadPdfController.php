<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\AnneeScoActuel;
use App\Models\AnneeScolaire;
use App\Models\TypeExamen;
use App\Models\Scolarite;
use App\Models\Transport;
use App\Models\Abscence;
use App\Models\Matiere;
use App\Models\Cantine;
use App\Models\Module;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Ecole;
use App\Models\Cour;
use App\Models\Note;
use App\Models\User;
use PDF;

class DownloadPdfController extends Controller
{
    public function imprimer_details_etudiant($id)
    {
        $eleve =Eleve::where('id',$id)->with('classe_annuel')->first();
        $anne= AnneeScolaire::where('id',$eleve->annee_scolaire_id)->first();
        $scolarite_paye = Scolarite::where('eleve_id',$id)->sum('montant_paye');
        $cantines = Cantine::take(4)->where('eleve_id',$id)->orderBy('date_cantine','desc')->get();
        $transports = Transport::take(4)->where('eleve_id',$id)->orderBy('mois','desc')->get();
        $abscence = Abscence::where('eleve_id',$id)->orderBy('id','desc')->first();
        $data = [
            'eleve'=>$eleve,
            'anne'=>$anne,
            'scolarite_paye'=>$scolarite_paye,
            'cantines'=>$cantines,
            'transports'=>$transports,
            'abscence'=>$abscence
        ];
        return PDF::loadView('fichierpdfs.detail_etud_pdf',$data)
            ->save(public_path("/assets/documents/informations/eleve.pdf"))
            ->stream();
    }
    public function imprimer_liste($id)
    {
        $anne_id= AnneeScoActuel::where('id',1)->value('annee_scolaire_id');
        $anne_scol = AnneeScolaire::where('id',$anne_id)->first();
        $classe = Classe::where('id',$id)->first();
        if(Gate::allows('isResponsable') || Gate::allows('isDirecteur')) {
            $eleves =Eleve::where('classe_id',$id)->where('annee_scolaire_id',$anne_id)->get();
            $data =[
                'anne'=>$anne_scol,
                'classe'=>$classe,
                'eleves'=>$eleves,
                'i'=>1
            ];
            return PDF::loadView('fichierpdfs.liste_classe',$data)
                ->setPaper('a4', 'landscape')
                ->setWarnings(false)
                ->save(public_path("/assets/documents/informations/classe.pdf"))
                ->stream();
        } else {
            return route('home');
        }
    }

    public function imprimer_bulletin($eleve_id,$module_id){
        $anne_id= AnneeScoActuel::where('id',1)->value('annee_scolaire_id');
        if (Gate::allows('isResponsable') || Gate::allows('isEtudiant')) {
            $eleve = Eleve::where('id',$eleve_id)->with('classe_annuel')->with('anneeScol')->first();
            $notes = Note::where('eleve_id',$eleve_id)->get();
            $cours = Cour::where('annee_scolaire_id',$anne_id)->where('classe_id',$eleve->classe_id)->get();
            $types = TypeExamen::orderBy('type','asc')->get();
            $matiere_id = [];
            if (count($cours)>0) {
                foreach ($cours as $cour) {
                    array_push($matiere_id,$cour->matiere_id);
                }
                $matieres = Matiere::whereIn('id',$matiere_id)->orderBy('matiere','asc')->get();
            } else {
                $matieres = [];
            }
            $pdfpath =public_path("/assets/documents/Bulletin/bulletin.pdf");
            $data =[
                "title"=>"",
                "eleve"=>$eleve,
                "module"=>Module::find($module_id),
                "matieres"=>$matieres,
                "types"=>$types,
                "ecole"=>Ecole::first(),
                "notes"=>$notes,
                "row"=>count($types)+1,
                "moyenne"=>0
            ];
            return PDF::loadView('fichierpdfs.note',$data)
                ->save($pdfpath)
                ->stream();

            // return response()->json($routeName);
        } else {
            return route('home');
        }
    }
}
