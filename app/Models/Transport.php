<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transport extends Model
{
    use HasFactory;
    protected $table = "transports";
    protected $guarded = ['*'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class,"eleve_id","id");
    }
    public function sum_transport_par_eleve($eleve_id,$mois)
    {
        return DB::table('transports')->where('eleve_id',$eleve_id)->where('mois',$mois)->value('montant');
    }
}
