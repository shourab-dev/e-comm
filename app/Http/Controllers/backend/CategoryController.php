<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function categoryAdd()
    {
        $categories = Category::all();

        return view('backend.category.add', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('categoryImage')) {
            $extension = $request->categoryImage->extension();
            $imageName = 'category-' .  $request->slug . '.' . $extension;
            $imagePath = $request->categoryImage->storeAs('category/', $imageName, 'public');
            $imageUrl = env('APP_URL') . '/storage/' . $imagePath;
        }



        $category = new Category();
        $category->title = $request->title;
        $category->slug = $request->slug;
        if ($request->hasFile('categoryImage')) {
            $category->image = $imageName;
            $category->image_url = $imageUrl;
        }
        $category->save();
        return back();
    }

    public function categoryEdit(Category $editedCategory)
    {
        $categories = Category::all();

        return view('backend.category.add', compact('categories', 'editedCategory'));
    }


    public function categoryUpdate(Request $request, Category $editedCategory)
    {
        $editedCategory->title = $request->title;
        $editedCategory->slug = $request->slug;
        $editedCategory->save();
        return redirect()->route('category.add');
    }


    /**
     * *Sub category Starts here
     */
    public function subcategoryAdd()
    {
        $categories = Category::select('id', 'title')->get();
        $subCategories = SubCategory::with('category')->get();
        // dd($subCategories[0]->category->title);

        return view('backend.category.subcategory.add', compact('categories', 'subCategories'));
    }

    public function subcategoryStore(Request $request)
    {
        //Image Process
        if ($request->hasFile('subCategoryImage')) {
            $extension = $request->subCategoryImage->extension();
            $imageName = 'category-' .  $request->slug . '.' . $extension;
            $imagePath = $request->categoryImage->storeAs('category/', $imageName, 'public');
            $imageUrl = env('APP_URL') . '/storage/' . $imagePath;
        }


        $subCategory  = new SubCategory();
        $subCategory->title = $request->title;
        $subCategory->slug = $request->slug;
        $subCategory->category_id = $request->parent_category;
        if ($request->hasFile('subCategoryImage')) {
            $subCategory->image = $imageName;
            $subCategory->image_url = $imageUrl;
        }

        $subCategory->save();
        return back();
    }


    public function subCategoryEdit(SubCategory $editedSubCategory)
    {
        $categories = Category::select('id', 'title')->get();
        $subCategories = SubCategory::with('category')->get();
        // dd($subCategories[0]->category->title);

        return view('backend.category.subcategory.add', compact('categories', 'subCategories', 'editedSubCategory'));
    }

    /**
     * *Sub Category Ends here
     */
}
