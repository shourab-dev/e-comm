<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        $categories = Category::with('subCategory', 'products')->get();
        $products = Product::latest()->simplePaginate(2);

        return view('frontend/index', compact('categories', 'products'));
    }

    public function productView($slug)
    {

        $product =  Product::with('images')->where('slug', $slug)->first();
        // dd($product);
        return view('frontend.productView', compact('product'));
    }



    public function shopFilter(Request $request, $filterCategory = null)
    {
        // dd($filterCategory);
        $selectedCategory = $filterCategory;
        $categories = Category::with('subCategory')->get();

        $sortingValues = str($request->sorting)->explode(',');
        //*PRODUCTS
        $query = Product::query();

        if ($request->startPrice && $request->endPrice) {
            $query->where('price', '>=', $request->startPrice)->where('price', '<=', $request->endPrice);
        }


        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory)->orWhere('sub_category_id', $selectedCategory);
        }
        if ($request->sorting) {
            $query->orderBy($sortingValues[0], $sortingValues[1]);
        }
        $products =  $query->get();
        return view('frontend.shop', compact('categories', 'products'));
    }



    public function searchable(Request $request)
    {
        $searchValue  = $request->search;
        if ($searchValue) {

            $products = Product::select('id', 'slug', 'title')->where('title', 'LIKE', '%' . $searchValue . '%')->get();
            return json_encode($products);
        } else {
            return response('No Product found', 404);
        }
    }
}
