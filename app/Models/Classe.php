<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classe extends Model
{
    use HasFactory;
    protected $table = "classes";
    protected $guarded = ['*'];

    public function cours()
    {
        return $this->hasMany(Cour::class);
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function AnneeSco()
    {
        return $this->belongsTo(AnneeScolaire::class,"annee_scolaire_id","id");
    }
    public function classe_name($id)
    {
        return DB::table('classes')->where('id',$id)->value('nom_classe');
    }
    public function matiere_name($id)
    {
        return DB::table('matieres')->where('id',$id)->value('matiere');
    }
}
