<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;
    protected $table = "responsables";
    protected $guarded = ['*'];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class,"ecole_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
