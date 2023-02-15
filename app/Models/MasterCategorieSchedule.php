<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCategorieSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'categorie_name'
    ];
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

 
}
