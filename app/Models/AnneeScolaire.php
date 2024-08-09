<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    use HasFactory;
    protected $table = "annee_scolaires";
    protected $guarded = ['*'];
    public $timestamps = false;

    public function etudiants()
    {
        return $this->hasMany(Eleve::class);
    }

    public function fiche()
    {
        return $this->hasMany(FicheProf::class);
    }

    public function anneeActuel()
    {
        return $this->hasOne(AnneeScoActuel::class);
    }

    public function classe()
    {
        return $this->hasMany(Classe::class);
    }
}
