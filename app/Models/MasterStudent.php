<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\MasterProvince;
use App\Models\MasterCity;

class MasterStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'noId', 'email', 'name', 'photo', 'gender', 'address', 'province_id',
        'city_id', 'date_birth', 'student_parent', 'no_tlp', 'program_id', 'period_id', 'is_activate'
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
        'email', 'photo', 'province_id', 'city_id', 'address', 'no_id', 'student_parent', 'no_tlp'
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
    public function period()
    {
        return $this->belongsTo(MasterPeriod::class, 'period_id');
    }
    public function program()
    {
        return $this->belongsTo(MasterAcademicProgram::class, 'program_id');
    }
}
