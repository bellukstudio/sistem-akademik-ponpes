<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'class_id', 'course_id', 'user_id', 'score', 'date_assesment', 'assessment_id'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

   
}
