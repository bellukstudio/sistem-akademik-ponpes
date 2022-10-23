<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterNews extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title','description','id_user'
    ];

    protected $hidden = ['id_user'];
}
