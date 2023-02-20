<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class MasterTokenFcm extends Model
{
    use HasFactory;
    protected $table = 'master_token_fcm';
    protected $fillable = [
        'token', 'id_user'
    ];

    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
