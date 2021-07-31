<?php

use Illuminate\Database\Seeder;

class ProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('produk')->insert([
    		[
    			'nama' => 'Bawang Goreng Murni',
    			'stok' => '1000',
    			'harga' => '30000',
    			'satuan' => 'kg',
    			'foto' => NULL,
    			'keterangan' => 'Bawang goreng murni tanpa campuran tepung',
    		],
    		[
    			'nama' => 'Bawang Goreng Bercampur Tepung',
    			'stok' => '2000',
    			'harga' => '25000',
    			'satuan' => 'kg',
    			'foto' => NULL,
    			'keterangan' => 'Bawang goreng murni dengan campuran tepung',
    		]
    	]);
    }
}
