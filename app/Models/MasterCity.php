<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class MasterCity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_name', 'id_province'
    ];

    protected $hidden = [
        'id_province'
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
    public function province()
    {
        return $this->belongsTo(MasterProvince::class, 'id_province');
    }
}
