<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class User extends Authenticatable
{

    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'username',
        'password',
        'email',
        'sentra_id',
        'api_token',
        'role'
    ];

    protected $appends = ['hashid'];

    public function getHashIdAttribute()
    {
        return \Hashids::encode( $this->attributes['id'] );
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function SentraBatik() {
        return $this->belongsTo( SentraBatik::class, 'sentra_id' );
    }

}
