<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class MasterAcademicProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'program_name'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

   
}
