<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxStudentPermits extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'description', 'permit_date', 'permit_type', 'id_program', 'status', 'id_period'
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
    public function program()
    {
        return $this->belongsTo(MasterAcademicProgram::class, 'id_program');
    }
    public function student()
    {
        return $this->belongsTo(MasterStudent::class, 'student_id');
    }
    public function period()
    {
        return $this->belongsTo(MasterPeriod::class, 'id_period');
    }
}
