<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrxStudentPermits extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'student_id', 'description', 'permit_date', 'permit_type', 'id_program', 'status'
    ];
    protected $dates = ['deleted_at'];
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
}
