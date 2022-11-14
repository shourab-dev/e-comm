<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['desktop', 'laptop'];
        foreach ($categories as $cat) {

            $category = new Category();
            $category->title = $cat;
            $category->slug = str($cat)->slug();
            $category->save();
        }



        $subcategories = ['gaming', 'normal', 'asus'];
        foreach ($subcategories as $cat) {

            $subcategory = new SubCategory();
            $subcategory->category_id = 1;
            $subcategory->title = $cat;
            $subcategory->slug = str($cat)->slug();
            $subcategory->save();
        }
    }
}
