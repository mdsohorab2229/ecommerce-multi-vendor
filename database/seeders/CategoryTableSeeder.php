<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryRecords  = [
            [
                'id' => 1,
                'parent_id' => 0,
                'section_id' => 1,
                'category_name' => 'Clothing',
                'category_image' => 'Clothing.jpg',
                'category_discount' => 10.5,
                'description' => 'Category for all kinds of Clothing products',
                'url' => 'Clothing',
                'meta_title' => 'Clothing Meta Title',
                'meta_description' => 'Meta description for Clothing category',
                'meta_keywords' => 'Clothing, gadgets, tech',
                'status' => 1,
            ],
            [
                'id' => 2,
                'parent_id' => 0,
                'section_id' => 2,
                'category_name' => 'Electronices',
                'category_image' => 'Electronices.jpg',
                'category_discount' => 15.0,
                'description' => 'Electronices for Electronices and clothing',
                'url' => 'Electronices',
                'meta_title' => 'Electronices Meta Title',
                'meta_description' => 'Meta description for Electronices Electronices',
                'meta_keywords' => 'Electronices, clothing, style',
                'status' => 1,
            ],
            [
                'id' => 3,
                'parent_id' => 0,
                'section_id' => 3,
                'category_name' => 'Appliances',
                'category_image' => 'appliances.jpg',
                'category_discount' => 12.0,
                'description' => 'Various appliances including kitchen and cleaning items',
                'url' => 'appliances',
                'meta_title' => 'Appliances Meta Title',
                'meta_description' => 'Meta description for  appliances category',
                'meta_keywords' => 'appliances, kitchen, cleaning',
                'status' => 1,
            ],
            [
                'id' => 4,
                'parent_id' => 0,
                'section_id' => 4,
                'category_name' => 'fashion',
                'category_image' => 'fashion.jpg',
                'category_discount' => 8.0,
                'description' => 'fashion across various genres and authors',
                'url' => 'fashion',
                'meta_title' => 'fashion Meta Title',
                'meta_description' => 'Meta description for fashion category',
                'meta_keywords' => 'fashion, reading, literature',
                'status' => 1,
            ]
        ];

        Category::insert($categoryRecords);
    }
}
