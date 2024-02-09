<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigned extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_offer',
        'id_cycle'
    ];
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'id_offer');
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class, 'id_cycle');
    }
}
