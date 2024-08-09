<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
    use HasFactory;
    protected $table = "ecoles";
    protected $guarded = ['*'];
    public $timestamps = false;

    public function responsable()
    {
        return $this->hasMany(Responsable::class);
    }
}
