<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeExamen extends Model
{
    use HasFactory;
    protected $table = "type_examens";
    protected $guarded = ['*'];

    public function note_etudiant()
    {
        return $this->hasMany(Note::class);
    }
}
