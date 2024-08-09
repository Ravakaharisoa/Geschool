<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cantine extends Model
{
    use HasFactory;
    protected $table = "cantines";
    protected $guarded = ['*'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class,"eleve_id","id");
    }
    public function cantine_periode_eleve($eleve_id,$debut,$fin)
    {
        return DB::table('cantines')->where('eleve_id',$eleve_id)->whereBetween('date_cantine',[$debut,$fin])->get();
    }
    public function sum_cantine_par_eleve($eleve_id,$debut,$fin)
    {
        return DB::table('cantines')->where('eleve_id',$eleve_id)->whereBetween('date_cantine',[$debut,$fin])->sum('montant');
    }
}
