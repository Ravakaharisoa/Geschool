<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abscence extends Model
{
    use HasFactory;
    protected $table = "abscences";
    protected $guarded = ['*'];

    public function etudiant()
    {
        return $this->belongsTo(Eleve::class,"eleve_id","id");
    }

    public function cour()
    {
        return $this->belongsTo(Cour::class,"cour_id","id");
    }

}
