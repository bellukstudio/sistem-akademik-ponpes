<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxPicketSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'room_id', 'time', 'id_category'
    ];
    protected $hidden = [
         'created_at', 'updated_at'
    ];

    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
    // relationship
    public function student()
    {
        return $this->belongsTo(MasterStudent::class, 'student_id');
    }
    public function room()
    {
        return $this->belongsTo(MasterRoom::class, 'room_id');
    }
    public function picket()
    {
        return $this->belongsTo(MasterPicket::class, 'id_category');
    }
}
