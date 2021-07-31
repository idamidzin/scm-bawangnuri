<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    		[
    			'role_id' => 1,
                'nama' => 'Sultan Crypto',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => bcrypt('1234'),
                'nohp' => '0895686756',
                'jenis_kelamin' => 'L',
                'alamat' => 'Ds. Taraju No 34 Jalur Tonggoh',
                'foto' => NULL,
                'nama_rekening' => 'BCA',
                'no_rekening' => '2996928172'
            ],
            [
                'role_id' => 2,
                'nama' => 'Saepul Ambari',
                'email' => 'saepul@gmail.com',
                'username' => 'supplier1',
                'password' => bcrypt('1234'),
                'nohp' => '08225686756',
                'jenis_kelamin' => 'L',
                'alamat' => 'Ds. Bayuning No 37 Jalur Kertawangi',
                'foto' => NULL,
                'nama_rekening' => 'BCA',
                'no_rekening' => '2793328199'
            ],
            [
                'role_id' => 2,
                'nama' => 'Ahmad Burhanudin',
                'email' => 'ahmad@gmail.com',
                'username' => 'supplier2',
                'password' => bcrypt('1234'),
                'nohp' => '08225686756',
                'jenis_kelamin' => 'L',
                'alamat' => 'Ds. Pasawahan No 94 Jalur Pinggir Hawangan',
                'foto' => NULL,
                'nama_rekening' => 'BCA',
                'no_rekening' => '1996928111'
            ],
            [
                'role_id' => 2,
                'nama' => 'Jamilah',
                'email' => 'jamil@gmail.com',
                'username' => 'supplier3',
                'password' => bcrypt('1234'),
                'nohp' => '08125686756',
                'jenis_kelamin' => 'P',
                'alamat' => 'Ds. Mandirancan No 94 Jalur Pinggir Kali',
                'foto' => NULL,
                'nama_rekening' => 'BCA',
                'no_rekening' => '3236928111'
            ],
            [
                'role_id' => 2,
                'nama' => 'Cahyadi Bawang',
                'email' => 'cahyadi@gmail.com',
                'username' => 'supplier4',
                'password' => bcrypt('1234'),
                'nohp' => '08125686756',
                'jenis_kelamin' => 'L',
                'alamat' => 'Ds. Manis Kidul No 94 Jalur Rumahlega',
                'foto' => NULL,
                'nama_rekening' => 'BCA',
                'no_rekening' => '6233428111'
            ],
            [
                'role_id' => 3,
                'nama' => 'Kasin Kozi',
                'email' => 'kasin@gmail.com',
                'username' => 'distributor',
                'password' => bcrypt('1234'),
                'nohp' => '08725686756',
                'jenis_kelamin' => 'L',
                'alamat' => 'Ds. Taraju No 32 Jalur Kulon',
                'foto' => NULL,
                'nama_rekening' => 'BCA',
                'no_rekening' => '2996928172'
            ],
            [
                'role_id' => 4,
                'nama' => 'Tonia Hartanto',
                'email' => 'tonia@gmail.com',
                'username' => 'pimpinan',
                'password' => bcrypt('1234'),
                'nohp' => '08825686756',
                'jenis_kelamin' => 'L',
                'alamat' => 'Ds. Taraju No 30 Jalur Kidul',
                'foto' => NULL,
                'nama_rekening' => 'BCA',
                'no_rekening' => '2996928172'
            ]
        ]);
    }
}
