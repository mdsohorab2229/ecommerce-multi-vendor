<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords  = [
            [
                'id' => 2,
                'name' => 'sohorab',
                'type' => 'vendor',
                'vendor_id' => 1,
                'mobile' => '01791805952',
                'email' => 'mdsohorab2229@gmail.com',
                'password' => '$2a$12$Pgz.SXxoj73CO/SHSEz1j.QPEaSOGoKvGVWU5o302tSp34f3ByzRi',
                'image' => '',
                'status' => 0
            ]
        ];

        Admin::insert($adminRecords);
    }
}
