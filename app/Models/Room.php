<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'size',
        'description',
        'price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}