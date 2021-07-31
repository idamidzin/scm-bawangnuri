<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Produk extends Model
{
	use SoftDeletes;
	
	protected $table = 'produk';
	protected $fillable = [
		'nama',
		'stok',
		'harga',
		'satuan',
		'foto',
		'keterangan',
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}
}