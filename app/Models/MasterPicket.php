<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPicket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];
    
}
