<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorBusinessDetails = [
            [
                'vendor_id' => 1,
                'shop_name' => 'ABC Mart',
                'shop_address' => '123 Main St',
                'shop_city' => 'New York',
                'shop_state' => 'NY',
                'shop_country' => 'USA',
                'shop_pincode' => '10001',
                'shop_mobile' => '1234567890',
                'shop_website' => 'https://www.abcmart.com',
                'shop_email' => 'info@abcmart.com',
                'shop_proof' => 'License',
                'shop_proof_image' => 'license.jpg',
                'shop_license_number' => 'LIC12345',
                'gst_number' => 'GSTIN123456789',
                'pan_number' => 'ABCDE1234F',
            ],
            [
                'vendor_id' => 2,
                'shop_name' => 'XYZ Store',
                'shop_address' => '456 Market St',
                'shop_city' => 'Los Angeles',
                'shop_state' => 'CA',
                'shop_country' => 'USA',
                'shop_pincode' => '90001',
                'shop_mobile' => '0987654321',
                'shop_website' => 'https://www.xyzstore.com',
                'shop_email' => 'contact@xyzstore.com',
                'shop_proof' => 'Certificate',
                'shop_proof_image' => 'certificate.jpg',
                'shop_license_number' => 'LIC67890',
                'gst_number' => 'GSTIN987654321',
                'pan_number' => 'XYZDE6789P',
            ],
        ];

        VendorsBusinessDetail::insert($vendorBusinessDetails);
    }
}
