<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ['nama' => 'Owner', 'email' => 'owner@bengkel.com', 'no_handphone' => '-', 'alamat' => '-', 'password' => bcrypt('password'), 'is_owner' => 1, 'is_admin' => 0, 'is_member' => 0, 'kode' => null],
            ['nama' => 'Admin', 'email' => 'admin@bengkel.com', 'no_handphone' => '-', 'alamat' => '-', 'password' => bcrypt('password'), 'is_owner' => 0, 'is_admin' => 1, 'is_member' => 0, 'kode' => null],
            ['nama' => 'Member', 'email' => 'member@bengkel.com', 'no_handphone' => '-', 'alamat' => '-', 'password' => bcrypt('password'), 'is_owner' => 0, 'is_admin' => 0, 'is_member' => 1, 'kode' => 'MBER99'],
        ]);
    }
}
