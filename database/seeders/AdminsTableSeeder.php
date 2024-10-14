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
                'name' => 'Sohorab',
                'type' => 'supperadmin',
                'vendor_id' => 0,
                'mobile' => '01791805951',
                'email' => 'supperadmin@gmail.com',
                'password' => '$2a$12$ZBLJp5svtlU0wVkGkcB0rObP7Uo624dDdfGvZmzsZ7IquokUCs9Mq',
                'image' => '',
                'status' => 0
            ],
            [
                'id' => 2,
                'name' => 'Hossain',
                'type' => 'admin',
                'vendor_id' => 0,
                'mobile' => '01791805952',
                'email' => 'admin@gmail.com',
                'password' => '$2a$12$ZBLJp5svtlU0wVkGkcB0rObP7Uo624dDdfGvZmzsZ7IquokUCs9Mq',
                'image' => '',
                'status' => 0
            ],
            [
                'id' => 3,
                'name' => 'Sagor',
                'type' => 'vendor',
                'vendor_id' => 3,
                'mobile' => '01791805953',
                'email' => 'vendor@gmail.com',
                'password' => '$2a$12$ZBLJp5svtlU0wVkGkcB0rObP7Uo624dDdfGvZmzsZ7IquokUCs9Mq',
                'image' => '',
                'status' => 0
            ]
        ];

        Admin::insert($adminRecords);
    }
}
