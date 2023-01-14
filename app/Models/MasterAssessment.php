<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'program_id'
    ];

    public function program()
    {
        return $this->belongsTo(MasterAcademicProgram::class, 'program_id');
    }
}
