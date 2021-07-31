<?php

use Illuminate\Database\Seeder;

class PersediaanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persediaan')->insert([
        	[
        		'stok' => '2000',
        		'status' => 1 
        	]
        ]);
    }
}
