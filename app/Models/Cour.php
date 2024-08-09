<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cour extends Model
{
    use HasFactory;
    protected $table = "cours";
    protected $guarded = ['*'];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class,"professeur_id","id");
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class,"classe_id","id");
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class,"matiere_id","id");
    }
    public function cours_matiere($classe_id,$jours,$debut,$fin,$anne_id)
    {
        return DB::table('cours')
            ->join('matieres','matieres.id','=','cours.matiere_id')
            ->where('cours.classe_id',$classe_id)->where('cours.jour',$jours)
            ->where('cours.heure_debut',$debut)->where('cours.heure_fin',$fin)
            ->where('cours.annee_scolaire_id',$anne_id)->value('matieres.abreviation');
    }
    public function cours_professeur($classe_id,$jours,$debut,$fin,$anne_id)
    {
        return DB::table('cours')
            ->join('professeurs','professeurs.id','=','cours.professeur_id')
            ->where('cours.classe_id',$classe_id)->where('cours.jour',$jours)
            ->where('cours.heure_debut',$debut)->where('cours.heure_fin',$fin)
            ->where('cours.annee_scolaire_id',$anne_id)->value('professeurs.nom');
    }
    public function nom_matiere($matiere_id)
    {
        return DB::table('matieres')->where('id',$matiere_id)->value('matiere');
    }
}

