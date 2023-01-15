<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrxCaretakers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'program_id', 'categories', 'name', 'email'
    ];
    protected $hidden = [
        'user_id', 'email'
    ];
    protected $dates = ['deleted_at',];
    public function program()
    {
        return $this->belongsTo(MasterAcademicProgram::class, 'program_id');
    }

    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
