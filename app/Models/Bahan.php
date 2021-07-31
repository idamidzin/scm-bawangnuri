<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Bahan extends Model
{
	use SoftDeletes;
	
	protected $table = 'bahan';
	protected $fillable = [
		'nama',
		'jumlah',
		'harga',
		'satuan',
		'supplier_id'
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}

	public function Supplier()
	{
		return $this->belongsTo( User::class, 'supplier_id' );
	}
}
