<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRuangan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_ruangan';

}
