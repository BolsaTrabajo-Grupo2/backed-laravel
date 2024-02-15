<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_offer',
        'id_student'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'id_user');
    }

}
