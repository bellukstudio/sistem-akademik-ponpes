<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_name', 'id_province'
    ];

    protected $hidden = [
        'id_province'
    ];

    public function province()
    {
        return $this->belongsTo(MasterProvince::class, 'id_province');
    }
}
