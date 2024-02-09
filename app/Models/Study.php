<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id_student',
        'id_cycle',
        'date',
    ];
    public function cycle(){
        return $this->belongsTo(Cycle::class, 'id_cycle', 'id');
    }
}
