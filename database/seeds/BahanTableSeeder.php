<?php

use Illuminate\Database\Seeder;

class BahanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('bahan')->insert([
    		[
    			'nama' => 'Bawang Merah Mentah',
    			'jumlah' => '20000',
    			'harga' => '12000',
    			'satuan' => 'kg',
    			'supplier_id' => 2,
    		],
    		[
    			'nama' => 'Bawang Merah Mentah',
    			'jumlah' => '50000',
    			'harga' => '12500',
    			'satuan' => 'kg',
    			'supplier_id' => 3,
    		],
            [
                'nama' => 'Bawang Merah Mentah',
                'jumlah' => '1000',
                'harga' => '11000',
                'satuan' => 'kg',
                'supplier_id' => 4,
            ],
            [
                'nama' => 'Bawang Merah Mentah',
                'jumlah' => '500',
                'harga' => '11500',
                'satuan' => 'kg',
                'supplier_id' => 5,
            ]
    	]);
    }
}
