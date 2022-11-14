<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;

class ProductController extends Controller
{
    public function storeProduct()
    {
        $categories = Category::select('id', 'title')->get();
        $brands = Brand::select('id', 'title')->get();

        return view('backend.product.add', compact('categories', 'brands'));
    }


    public function fetchSubCategory($id)
    {
        $subCategories = SubCategory::where('category_id', $id)->select('id', 'category_id', 'title')->get();

        if (count($subCategories) > 0) {
            return $subCategories;
        } else {
            return "No SubCategory Available";
        }
    }


    public function store(Request $request)
    {
        // dd($request->all());

        $thumbnail = $this->thumbnailStore($request);
        $product = new Product();
        $product->title =  $request->title;
        $product->brand_id =  $request->brand;
        $product->category_id =  $request->category;
        $product->sub_category_id =  $request->subCategory;
        $product->slug =  $request->slug ? str($request->slug)->slug() : str($request->title)->slug();
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->status = $request->status ? 1 : 0;
        $product->start_date = $request->start_date;
        $product->end_date = $request->end_date;
        $product->product_code = $request->product_code;
        $product->short_detail = $request->short_description;
        $product->long_detail = $request->long_description;
        $product->thumbnail_name = $thumbnail['thumbnail_name'];
        $product->thumbnail_url = $thumbnail['thumbnail_url'];
        $product->video_url = $request->video_url;
        $product->save();
        if($request->hasFile('product_gallery_images')){
            $this->storeGalleryImages($request, $product->id);
        }

        return back();
    }


    public function thumbnailStore($request)
    {
        //*THUMBNAIL IMAGE PROCESSS
        $extension = $request->thubnail_img->extension();
        $thumbnail_img_name = str($request->title)->slug() . '-product.' . $extension;
        $img_path = $request->thubnail_img->storeAs('product', $thumbnail_img_name, 'public');
        $thumbnail_url = env('APP_URL') . '/storage/' . $img_path;
        return [
            'thumbnail_name' => $thumbnail_img_name,
            'thumbnail_url' => $thumbnail_url
        ];
    }


    public function storeGalleryImages($request, $productId)
    {
        $galleryImages = $request->product_gallery_images;
        foreach ($galleryImages as $galleryImage) {
            $extension = $galleryImage->extension();
            $gallery_img_name = str($request->title)->slug() . uniqid() . '-product.' . $extension;
            $img_path = $galleryImage->storeAs('product', $gallery_img_name, 'public');
            $gallery_url = env('APP_URL') . '/storage/' . $img_path;

            $galleryImageStore = new Image();
            $galleryImageStore->product_id = $productId;
            $galleryImageStore->product_name = $gallery_img_name;
            $galleryImageStore->product_url = $gallery_url;
            $galleryImageStore->save();
        }
    }
}
