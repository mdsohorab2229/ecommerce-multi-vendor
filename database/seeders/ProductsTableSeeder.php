<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productRecords = [
            [
                'id'=> 1,
                'admin_id' => 1,
                'vendor_id' => 1,
                'admin_type' => "vendor",
                'section_id' => 2,
                'category_id' => 1,
                'brand_id' => 1,
                'product_name' => 'Sample Product 1',
                'product_code' => 'SP001',
                'product_color' => 'Red',
                'product_price' => '100',
                'product_discount' => '10',
                'product_weight' => '500g',
                'product_image' => 'sample1.jpg',
                'product_video' => 'video1.mp4',
                'description' => 'This is a description for Sample Product 1',
                'meta_title' => 'Sample Product 1 Meta Title',
                'meta_description' => 'Sample Product 1 Meta Description',
                'meta_keywords' => 'sample,product1',
                'is_featured' => 'Yes',
                'status' => 1,
            ],
            [
                'id'=> 2,
                'admin_id' => 2,
                'vendor_id' => 2,
                'admin_type' => "admin",
                'section_id' => 2,
                'category_id' => 2,
                'brand_id' => 2,
                'product_name' => 'Sample Product 2',
                'product_code' => 'SP002',
                'product_color' => 'Blue',
                'product_price' => '150',
                'product_discount' => '15',
                'product_weight' => '600g',
                'product_image' => 'sample2.jpg',
                'product_video' => 'video2.mp4',
                'description' => 'This is a description for Sample Product 2',
                'meta_title' => 'Sample Product 2 Meta Title',
                'meta_description' => 'Sample Product 2 Meta Description',
                'meta_keywords' => 'sample,product2',
                'is_featured' => 'No',
                'status' => 1,
            ],
            [
                'id'=> 3,
                'admin_id' => 3,
                'vendor_id' => 3,
                'admin_type' => "superadmin",
                'section_id' => 1,
                'category_id' => 3,
                'brand_id' => 1,
                'product_name' => 'Sample Product 3',
                'product_code' => 'SP003',
                'product_color' => 'Green',
                'product_price' => '200',
                'product_discount' => '20',
                'product_weight' => '700g',
                'product_image' => 'sample3.jpg',
                'product_video' => 'video3.mp4',
                'description' => 'This is a description for Sample Product 3',
                'meta_title' => 'Sample Product 3 Meta Title',
                'meta_description' => 'Sample Product 3 Meta Description',
                'meta_keywords' => 'sample,product3',
                'is_featured' => 'Yes',
                'status' => 1,
            ],
            [
                'id' => 4,
                'admin_id' => 4,
                'vendor_id' => 4,
                'admin_type' => "admin",
                'section_id' => 2,
                'category_id' => 4,
                'brand_id' => 2,
                'product_name' => 'Sample Product 4',
                'product_code' => 'SP004',
                'product_color' => 'Yellow',
                'product_price' => '250',
                'product_discount' => '25',
                'product_weight' => '800g',
                'product_image' => 'sample4.jpg',
                'product_video' => 'video4.mp4',
                'description' => 'This is a description for Sample Product 4',
                'meta_title' => 'Sample Product 4 Meta Title',
                'meta_description' => 'Sample Product 4 Meta Description',
                'meta_keywords' => 'sample,product4',
                'is_featured' => 'No',
                'status' => 1,
            ],
        ];

        Product::insert($productRecords);
    }
}
