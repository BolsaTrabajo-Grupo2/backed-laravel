<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'cycle',
        'title',
        'id_family',
        'id_responsible',
        'vliteral',
        'cliteral'
    ];
}
