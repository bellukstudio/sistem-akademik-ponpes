<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TrxPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user', 'id_payment', 'date_payment', 'status', 'total', 'id_student', 'photo', 'id_period'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function getPhotoAttribute()
    {
        return url('') . Storage::url($this->attributes['photo']);
    }
    // relation
    public function payment()
    {
        return $this->belongsTo(MasterPayment::class, 'id_payment');
    }
    public function user()
    {
        return $this->belongsTo(MasterUsers::class, 'id_user');
    }
    public function student()
    {
        return $this->belongsTo(MasterStudent::class, 'id_student');
    }
}
