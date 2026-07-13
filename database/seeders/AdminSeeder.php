<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the t_admin table.
     */
    public function run(): void
    {
        DB::table('t_admin')->insert([
            [
                'nik_admin' => 000001,
                'nama_admin'      => 'Administrator',
                'email'     => null,
                'foto'      => null,
                'password'  => Hash::make('Admin123'),
            ],
        ]);
    }
}
