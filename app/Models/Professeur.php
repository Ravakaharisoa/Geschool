<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;
    protected $table = "professeurs";
    protected $guarded = ['*'];


    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function fiche_presence()
    {
        return $this->hasMany(FicheProf::class);
    }

    public function cours_classe()
    {
        return $this->hasMany(Cour::class);
    }
}
