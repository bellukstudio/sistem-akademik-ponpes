<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxRoomGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'student_id',
    ];

    //relationship

    public function student()
    {
        return $this->belongsTo(MasterStudent::class, 'student_id');
    }
    public function room()
    {
        return $this->belongsTo(MasterRoom::class, 'room_id');
    }
}
