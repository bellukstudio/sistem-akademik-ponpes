<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBerita extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_berita';


    protected $fillable = [
        'id_user', 'judul', 'keterangan'
    ];

    protected $hidden = [
        'id_user', 'created_at', 'updated_at', 'deleted_at'
    ];
}
