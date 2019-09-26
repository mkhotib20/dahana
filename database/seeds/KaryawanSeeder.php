<?php

use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('karyawan')->insert([
            'kar_nama' => str_random(20),
            'kar_email' => str_random(10).'@gmail.com',
            'kar_uk' => str_random(1),
        ]);
    }
}
