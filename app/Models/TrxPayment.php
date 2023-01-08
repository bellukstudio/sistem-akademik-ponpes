<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user', 'id_payment', 'date_payment', 'status', 'total', 'id_student'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

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
