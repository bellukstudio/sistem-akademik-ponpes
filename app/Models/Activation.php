<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Activation extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_name', 'activation_code', 'email'
    ];

    protected $hidden = [
        'table_name', 'activation_code', 'email'
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
