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
        return $this->belongsTo(User::class, 'id_user');
    }
}
