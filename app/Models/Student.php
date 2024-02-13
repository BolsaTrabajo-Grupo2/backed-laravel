<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'address',
        'cv_link',
        'accept',
        'observations'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function studies()
    {
        return $this->hasMany(Study::class, 'id_student', 'id');
    }

    public function cycles()
    {
        return $this->hasMany(Cycle::class, 'id_student', 'user_id');
    }

    public function applies()
    {
        return $this->hasMany(Apply::class, 'id_student', 'user_id');
    }
}
