<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class MasterCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
