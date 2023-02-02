<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxClassGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'class_id'
    ];
    protected $hidden = [
       'created_at', 'updated_at'
    ];

    //relationship

    public function student()
    {
        return $this->belongsTo(MasterStudent::class, 'student_id');
    }
    public function class()
    {
        return $this->belongsTo(MasterClass::class, 'class_id');
    }
}
