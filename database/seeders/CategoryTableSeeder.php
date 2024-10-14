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
                'category_name' => 'Electronics',
                'category_image' => 'electronics.jpg',
                'category_discount' => 10.5,
                'description' => 'Category for all kinds of electronics products',
                'url' => 'electronics',
                'meta_title' => 'Electronics Meta Title',
                'meta_description' => 'Meta description for electronics category',
                'meta_keywords' => 'electronics, gadgets, tech',
                'status' => 1,
            ],
            [
                'id' => 2,
                'parent_id' => 0,
                'section_id' => 2,
                'category_name' => 'Fashion',
                'category_image' => 'fashion.jpg',
                'category_discount' => 15.0,
                'description' => 'Category for fashion and clothing',
                'url' => 'fashion',
                'meta_title' => 'Fashion Meta Title',
                'meta_description' => 'Meta description for fashion category',
                'meta_keywords' => 'fashion, clothing, style',
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
                'category_name' => 'Books',
                'category_image' => 'books.jpg',
                'category_discount' => 8.0,
                'description' => 'Books across various genres and authors',
                'url' => 'books',
                'meta_title' => 'Books Meta Title',
                'meta_description' => 'Meta description for books category',
                'meta_keywords' => 'books, reading, literature',
                'status' => 1,
            ]
        ];

        Category::insert($categoryRecords);
    }
}
