<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        //*All Brands
        $brands = Brand::all();

        return view('backend.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'slug' => 'unique:brands,slug',
            'brandImage' => 'required|mimes:png,jpg,webp',
        ]);


        // IMAGE PROCESSING

        $brandImageData = $this->imageUpload($request);
        // END OF IMAGE PROCESSING

        // BRAND STORE
        $brand = new Brand();
        $this->storeBrandData($request, $brand, $brandImageData);


        notify()->success('Your Brand Added successfully!');
        return back();
    }


    public function editBrand(Brand $editedBrand)
    {
        $brands = Brand::all();
        return view('backend.brand.index', compact('editedBrand', 'brands'));
    }


    public function updateBrand(Request $request, Brand $brand)
    {
        //*Validation Ends

        if ($request->hasFile('brandImage')) {
            //*File Exists
            $this->deleteImage($brand);
            $brandImageData = $this->imageUpload($request);
            $this->storeBrandData($request, $brand, $brandImageData);
        } else {
            $this->storeBrandData($request, $brand);
        }
        notify()->success('Your Brand Edited successfully!');
        return redirect()->route('brand');
    }


    public function imageUpload($request)
    {
        $extension = $request->brandImage->extension();
        $imageName = 'Brand-' . $request->slug . '.' .  $extension;
        $storePath =  $request->brandImage->storeAs('brand/', $imageName, 'public');
        $imageUrl = env('APP_URL') . '/storage/' . $storePath;

        return ['imageName' => $imageName, 'imageUrl' => $imageUrl];
    }


    public function storeBrandData($request, $brand, $brandImageData = [])
    {
        $brand->title = $request->title;
        $brand->slug = $request->slug;

        if ($request->hasFile('brandImage')) {
            $brand->brand_img = $brandImageData['imageName'];
            $brand->image_uri =  $brandImageData['imageUrl'];
        }
        $brand->save();
    }
    public function deleteImage($brand)
    {
        $path = 'brand/' . $brand->brand_img;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        return true;
    }

    public function deleteBrand(Brand $brand)
    {
        $isDelete = $this->deleteImage($brand);
        if ($isDelete) {
            $brand->delete();
        }
        notify()->success('Your Brand Deleted successfully!');
        return back();
    }
}
