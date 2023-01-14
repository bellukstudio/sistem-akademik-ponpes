<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\MasterProvince;

class MasterTeacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'noId', 'email', 'name', 'photo', 'gender', 'address',
        'province_id', 'city_id', 'date_birth', 'no_tlp', 'is_activate'
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

    protected $hidden = [
        'email', 'address', 'no_tlp', 'province_id', 'city_id', 'no_id', 'photo'
    ];

    // public function toArray()
    // {
    //     $toArray = parent::toArray();
    //     $toArray['photo'] = $this->photo;
    //     return $toArray;
    // }

    // public function getPhotoAttribute()
    // {
    //     return url('') . Storage::url($this->attributes['photo']);
    // }

    // relationship
    public function province()
    {
        return $this->belongsTo(MasterProvince::class, 'province_id');
    }
    public function city()
    {
        return $this->belongsTo(MasterCity::class, 'city_id');
    }
}
