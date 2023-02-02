<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxReadNews extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'news_id'
    ];

    public function user()
    {
        return $this->belongsTo(MasterUsers::class, 'user_id');
    }

    public function announcement()
    {
        return $this->belongsTo(MasterNews::class, 'news_id');
    }
}
