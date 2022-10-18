<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterTahunAjar extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_tahun_ajar';

    protected $fillable = [
        'kode', 'tgl_mulai', 'tgl_selesai', 'status'
    ];
}
