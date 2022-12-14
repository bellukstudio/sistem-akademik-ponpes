<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrxCaretakers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_induk', 'id_room', 'categories', 'name'
    ];
    protected $hidden = [
        'no_induk'
    ];
    protected $dates = ['deleted_at'];
    public function room()
    {
        return $this->belongsTo(MasterRoom::class, 'id_room');
    }
}
