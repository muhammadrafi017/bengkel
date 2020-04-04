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
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@bernitek.com', 'address' => 'Dirumah', 'phone_number' => '082220279970', 'password' => bcrypt('password'), 'status' => 1],
        ]);

        User::find(1)->groups()->sync(1);
    }
}
