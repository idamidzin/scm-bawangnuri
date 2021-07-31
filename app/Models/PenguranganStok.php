<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenguranganStok extends Model
{
	protected $table = 'pengurangan_stok';
	protected $fillable = [
		'nama_bahan',
		'nama_produk',
		'user_id',
		'jumlah',
		'tanggal',
	];

	public function User()
	{
		return $this->belongsTo( User::class, 'user_id' );
	}	
}
