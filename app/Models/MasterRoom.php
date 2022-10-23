<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_name', 'photo', 'capasity', 'type'
    ];

    protected $hidden = [
        'photo', 'type'
    ];
}
