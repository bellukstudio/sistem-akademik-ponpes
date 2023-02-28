<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'presence_type', 'category_attendance', 'status',
        'date_presence', 'program_id', 'id_operator', 'other_category', 'id_period'
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
