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

    public function family()
    {
        return $this->belongsTo(Family::class, 'id_family', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_responsible', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'id_student', 'id_user');
    }

    public function assigneds()
    {
        return $this->hasMany(Assigned::class, 'id_cycle');
    }
}
