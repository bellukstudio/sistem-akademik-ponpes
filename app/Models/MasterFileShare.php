<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MasterFileShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name', 'type', 'id_user', 'link', 'id_file'
    ];
    protected $dates = ['created_at', 'updated_at'];

    protected $hidden = [
        'created_at', 'updated_at'
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
