<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_room',
        'total',
        'month',
        'year',
        'status',
        'pay_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
