<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $table = "matieres";
    protected $guarded = ['*'];
    public $timestamps = false;

    public function cours_journaliere()
    {
        return $this->hasMany(Cour::class);
    }

    public function note_eleve()
    {
        return $this->hasMany(Note::class);
    }
}
