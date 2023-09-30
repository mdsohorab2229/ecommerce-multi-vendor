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
                'id' => 1,
                'name' => 'Super Admin',
                'type' => 'superadmin',
                'vendor_id' => 0,
                'mobile' => '01791805952',
                'email' => 'superadmin@admin.com',
                'password' => '$2a$12$Pgz.SXxoj73CO/SHSEz1j.QPEaSOGoKvGVWU5o302tSp34f3ByzRi',
                'image' => '',
                'status' => 1
            ]
        ];

        Admin::insert($adminRecords);
    }
}
