<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Note extends Model
{
    use HasFactory;
    protected $table = "notes";
    protected $guarded = ['*'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class,"eleve_id","id");
    }

    public function module()
    {
        return $this->belongsTo(Module::class,"module_id","id");
    }

    public function matieres()
    {
        return $this->belongsTo(Matiere::class,"matiere_id","id");
    }

    public function typeExam()
    {
        return $this->belongsTo(TypeExamen::class,'type_examen_id',"id");
    }

    public function note_eleve($matiere_id,$type_id,$module_id,$eleve_id)
    {
        return DB::table('notes')->where('matiere_id',$matiere_id)->where('type_examen_id',$type_id)->where('module_id',$module_id)->where('eleve_id',$eleve_id)->value('note');
    }

    public function coefficient_note($matiere_id,$module_id,$eleve_id)
    {
        return DB::table('notes')->where('matiere_id',$matiere_id)->where('module_id',$module_id)->where('eleve_id',$eleve_id)->value('coefficient');
    }

    public function somme_note($eleve_id,$module_id,$type_id)
    {
        return DB::table('notes')->where('type_examen_id',$type_id)->where('module_id',$module_id)->where('eleve_id',$eleve_id)->sum('note');
    }

    public function somme_coeff($eleve_id,$module_id)
    {
        return DB::table('notes')->where('module_id',$module_id)->where('eleve_id',$eleve_id)->sum('coefficient');
    }

    public function total_note($eleve_id,$module_id)
    {
        return DB::table('notes')->where('module_id',$module_id)->where('eleve_id',$eleve_id)->sum('note');
    }

    public function total_note_matiere($eleve_id,$module_id,$matiere_id)
    {
        $total_note =DB::table('notes')->where('module_id',$module_id)->where('matiere_id',$matiere_id)->where('eleve_id',$eleve_id)->sum('note');
        $type = DB::table('notes')->where('module_id',$module_id)->where('matiere_id',$matiere_id)->where('eleve_id',$eleve_id)->distinct('type_examen_id')->count();
        if ($total_note!=0) {
            $note =$total_note/$type;
        } else {
            $note =0;
        }

        return $note;
    }
}


