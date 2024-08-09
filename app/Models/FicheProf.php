<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheProf extends Model
{
    use HasFactory;
    protected $table = "fiche_profs";
    protected $guarded = ['*'];

    public function enseignant()
    {
        return $this->belongsTo(Professeur::class,"professeur_id","id");
    }

    public function anneSco()
    {
        return $this->belongsTo(AnneeScolaire::class,"annee_scolaire_id","id");
    }
}
