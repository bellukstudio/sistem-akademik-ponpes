<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProvince extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['province_name'];
}
