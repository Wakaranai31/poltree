<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Seed the t_pengguna table.
     */
    public function run(): void
    {
        $password = Hash::make('123456#');

        DB::table('t_pengguna')->insert([
            [
                'nik'       => 113103,
                'nama_pengguna' => 'Ir. Maria, S.ST., M.Sn., IPP',
                'password'  => $password,
                'email'     => 'maria.ipp@polibatam.ac.id',
                'jabatan'   => 'Dosen',
                'foto'      => null,
            ],
            [
                'nik'       => 115143,
                'nama_pengguna' => 'Ahmad Hamim Thohari, S.S.T., M.T.',
                'password'  => $password,
                'email'     => 'ahmad.thohari@polibatam.ac.id',
                'jabatan'   => 'Dosen',
                'foto'      => null,
            ],
            [
                'nik'       => 122288,
                'nama_pengguna' => 'Festy Winda Sari, S.Tr. Kom., M.Sc',
                'password'  => $password,
                'email'     => 'festy.winda@polibatam.ac.id',
                'jabatan'   => 'Dosen',
                'foto'      => null,
            ],
            [
                'nik'       => 218292,
                'nama_pengguna' => 'Dede Nurdiansyah, S.Sos',
                'password'  => $password,
                'email'     => 'dede.nurdiansyah@polibatam.ac.id',
                'jabatan'   => 'Tata Usaha',
                'foto'      => null,
            ],
            [
                'nik'       => 224345,
                'nama_pengguna' => 'Rhanna Mawira, S.E',
                'password'  => $password,
                'email'     => 'rhanna.mawira@polibatam.ac.id',
                'jabatan'   => 'Tata Usaha',
                'foto'      => null,
            ],
            [
                'nik'       => 225359,
                'nama_pengguna' => 'Miftahul Husna Ghawa, S.Tr.Kom',
                'password'  => $password,
                'email'     => 'miftahul.husna@polibatam.ac.id',
                'jabatan'   => 'Laboran',
                'foto'      => null,
            ],
            [
                'nik'       => 225361,
                'nama_pengguna' => 'Yogi Ilhami, S.Tr.T',
                'password'  => $password,
                'email'     => 'yogi.ilhami@polibatam.ac.id',
                'jabatan'   => 'Laboran',
                'foto'      => null,
            ],
        ]);
    }
}
