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
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function program()
    {
        return $this->belongsTo(MasterAcademicProgram::class, 'program_id');
    }

}
