<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id' => 1, 'name' => 'sohorab', 'address' => 'dhaka', 'city' => 'mirpur', 'state' => 'dhaka', 'country' => 'Bangladesh', 'pincode' => '1212', 'mobile' => '01761382229', 'email' => 'mdsohorab2229@gmail.com', 'status' => 0],
        ];
        Vendor::insert($vendorRecords);
    }
}
