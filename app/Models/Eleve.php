<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;
    protected $table = "eleves";
    protected $guarded = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function classe_annuel()
    {
        return $this->belongsTo(Classe::class,"classe_id","id");
    }

    public function anneeScol()
    {
        return $this->belongsTo(AnneeScolaire::class,"annee_scolaire_id","id");
    }

    public function transports_mensuel()
    {
        return $this->hasMany(Transport::class);
    }

    public function cantine_journaliere()
    {
        return $this->hasMany(Cantine::class);
    }

    public function scolarites_mensuel()
    {
        return $this->hasMany(Scolarite::class);
    }

    public function notes_evaluation()
    {
        return $this->hasMany(Note::class);
    }

    public function fiche_absence()
    {
        return $this->hasMany(Abscence::class);
    }

}


