<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
        	[
        		'nama' => 'Admin' 
        	],
        	[
        		'nama' => 'Supplier' 
        	],
        	[
        		'nama' => 'Distributor' 
        	],
        	[
        		'nama' => 'Pimpinan' 
        	]
        ]);
    }
}
