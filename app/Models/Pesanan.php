<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Pesanan extends Model
{
	use SoftDeletes;
	
	protected $table = 'pesanan';
	protected $fillable = [
		'user_id',
		'produk_id',
		'bahan_id',
		'tanggal',
		'keterangan',
		'jumlah',
		'harga',
		'status',
		'bukti_pembayaran',
		'bukti_pembayaran_retur',
		'alasan_cancel',
		'alasan_retur'
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}

	public function User()
	{
		return $this->belongsTo( User::class, 'user_id' );
	}

	public function Bahan()
	{
		return $this->belongsTo( Bahan::class, 'bahan_id' );
	}

	public function Produk()
	{
		return $this->belongsTo( Produk::class, 'produk_id' );
	}
}
