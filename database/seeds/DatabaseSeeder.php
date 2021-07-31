<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BahanTableSeeder::class);
        $this->call(PesananTableSeeder::class);
        $this->call(PersediaanTableSeeder::class);
        $this->call(ProdukTableSeeder::class);
    }
}

