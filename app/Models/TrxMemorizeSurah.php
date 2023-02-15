<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxMemorizeSurah extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'class_id', 'surah', 'verse', 'score', 'user_id', 'date_assesment'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

   
}
