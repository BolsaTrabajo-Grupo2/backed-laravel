<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'CIF',
        'company_name',
        'CP',
        'address',
        'phone',
        'web',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }
}
