<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class MasterRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_name', 'photo', 'capasity', 'type'
    ];

    protected $hidden = [
        'photo', 'type'
    ];

    protected $dates = ['deleted_at'];

    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function toArray()
    {
        $toArray = parent::toArray();
        $toArray['photo'] = $this->photo;
        return $toArray;
    }

    public function getPhotoAttribute()
    {
        return url('') . Storage::url($this->attributes['photo']);
    }
}
