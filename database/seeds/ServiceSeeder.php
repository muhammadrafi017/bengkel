<?php

use Illuminate\Database\Seeder;

use App\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            ['nama' => 'Servis ringan < 150cc', 'harga_minimal' => 80000, 'harga_maksimal' => 120000],
            ['nama' => 'Servis ringan < 250cc', 'harga_minimal' => 100000, 'harga_maksimal' => 150000],
            ['nama' => 'Ganti Oli', 'harga_minimal' => 60000, 'harga_maksimal' => 150000]
        ]);
    }
}
