<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', 'course_id', 'class_id', 'day', 'time'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    // relationship
    public function teacher()
    {
        return $this->belongsTo(MasterTeacher::class, 'teacher_id');
    }
    public function course()
    {
        return $this->belongsTo(MasterCourse::class, 'course_id');
    }
    public function class()
    {
        return $this->belongsTo(MasterClass::class, 'class_id');
    }

    //
    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

 
}
