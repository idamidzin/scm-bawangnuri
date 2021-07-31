<?php

use Illuminate\Database\Seeder;

class PesananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('pesanan')->insert([
    		[
    			'user_id' => 1,
    			'produk_id' => NULL,
    			'bahan_id' => 1,
    			'tanggal' => '2021-06-26',
    			'keterangan' => 'Oke mas',
    			'jumlah' => '1000',
    			'harga' => '12000',
    			'status' => '0',
    			'bukti_pembayaran' => NULL
    		]
    	]);
    }
}
