<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hashids\Hashids;

class User extends Authenticatable
{
	use Notifiable,SoftDeletes;
	
	protected $table = 'users';
	protected $fillable = [
		'role_id',
		'nama',
		'email',
		'username',
		'password',
		'nohp',
		'jenis_kelamin',
		'alamat',
		'foto',
		'nama_rekening',
		'no_rekening',
		'ktp',
		'is_valid'
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}

	protected $hidden = [
		'password', 'remember_token','api_token'
	];

	public function Role() {
		return $this->belongsTo( Role::class, 'role_id' );
	}

	public function Bahan()
	{
		return $this->hasMany( Bahan::class, 'supplier_id' );
	}
}
