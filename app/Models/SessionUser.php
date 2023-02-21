<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionUser extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'last_activity', 'status'];
    public function user()
    {
        return $this->belongsTo(MasterUsers::class, 'user_id');
    }
    protected $hidden = [
        'created_at', 'updated_at', 'ip_address', 'user_id'
    ];
}
