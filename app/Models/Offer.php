<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $table='offers';
    protected $primaryKey='id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'duration',
        'responsible_name',
        'inscription_method',
        'status',
        'verified',
        'CIF',
    ];
    public function assigneds()
    {
        return $this->hasMany(Assigned::class, 'id_offer');
    }
}
