<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ], [
            'username' => 'pimpinan',
            'password' => Hash::make('pimpinan'),
            'role' => 'pimpinan'
        ]];
        foreach ($data as $datum) {
            User::create($datum);
        }

    }
}
