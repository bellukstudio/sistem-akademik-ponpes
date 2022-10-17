<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterFileShare extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_file_share';

}
