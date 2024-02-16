<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'address',
        'cv_link',
        'accept',
        'observations'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function studies()
    {
        return $this->hasMany(Study::class, 'id_student', 'id');
    }

    public function cycles()
    {
        return $this->hasMany(Cycle::class, 'id_student', 'id_user');
    }

    public function applies()
    {
        return $this->hasMany(Apply::class, 'id_student');
    }
}

