<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScoActuel extends Model
{
    use HasFactory;
    protected $table = "annee_sco_actuels";
    public $timestamps = false;

    public function anneeSco()
    {
        return $this->belongsTo(AnneeScolaire::class,"annee_scolaire_id","id");
    }
}
