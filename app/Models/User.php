<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_room',
        'birthday',
        'phone_number',
        'address',
        'city',
        'parents_number',
        'institution',
        'number_plate',
        'vehicle',
        'id_card',
        'family_card',
        'entry_date',
        'out_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
