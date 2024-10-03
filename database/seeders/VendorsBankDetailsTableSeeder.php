<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors_bank_details')->insert([
            [
                'id' => 1,
                'vendor_id' => 1,
                'account_holder_name' => 'John Doe',
                'bank_name' => 'Chase Bank',
                'account_number' => '1234567890',
                'account_ifsc_code' => 'CHASUS33XXX',
            ],
            [
                'id' => 2,
                'vendor_id' => 2,
                'account_holder_name' => 'Jane Smith',
                'bank_name' => 'Bank of America',
                'account_number' => '0987654321',
                'account_ifsc_code' => 'BOFAUS3NXXX',
            ],
            [
                'id' => 3,
                'vendor_id' => 3,
                'account_holder_name' => 'Michael Johnson',
                'bank_name' => 'Wells Fargo',
                'account_number' => '1122334455',
                'account_ifsc_code' => 'WFBIUS6SXXX',
            ],
        ]);
    }
}
