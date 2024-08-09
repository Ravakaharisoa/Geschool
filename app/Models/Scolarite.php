<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Scolarite extends Model
{
    use HasFactory;
    protected $table = "scolarites";
    protected $guarded = ['*'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class,"eleve_id","id");
    }

    public function total_scolarite($eleve_id)
    {
        $scolarite = DB::table('scolarites')->where('eleve_id',$eleve_id)->sum('montant_paye');
        if (!$scolarite) {
            return 0;
        }
        return $scolarite;
    }
}
