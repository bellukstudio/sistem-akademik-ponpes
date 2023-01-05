<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class MasterPayment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['payment_name', 'total', 'method', 'payment_number', 'media_payment'];
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['payment_number', 'method'];

    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
