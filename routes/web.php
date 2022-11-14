<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomepageController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\SocialLoginController;
use App\Http\Controllers\frontend\UserAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





    Route::get('/', [HomepageController::class, 'index'])->name('homepage');
    Route::get('/products/{slug}', [HomepageController::class, 'productView'])->name('product.view');
    Route::get('/shop/{filterCategory?}', [HomepageController::class, 'shopFilter'])->name('shop.product');
    Route::POST('/search', [HomepageController::class, 'searchable'])->name('search.product');
    Route::get('/user/login', [UserAuthController::class, 'userLogin'])->name('user.login');
    Route::get('/user/register', [UserAuthController::class, 'userRegister'])->name('user.register');

    Route::get('/google/login', [SocialLoginController::class, 'googleGetData'])->name('google.get');
    Route::get('/google/redirect', [SocialLoginController::class, 'googleRedirectUserData'])->name('google.redirect');

    Route::get('/facebook/login', [SocialLoginController::class, 'facebookGetData'])->name('facebook.get');
    Route::get('/facebook/redirect', [SocialLoginController::class, 'facebookRedirectUserData'])->name('facebook.redirect');

    Route::GET('/cart-add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::GET('/cart-list', [CartController::class, 'cartLists'])->name('cart.list');
    Route::GET('/checkout', [OrderController::class, 'checkout'])->name('auth.checkout');




    //*USER DASHBOARD
    Route::get('/user/dashboard', [UserAuthController::class, 'dashboard'])->name('user.dashboard');




Auth::routes();

Route::middleware(['auth', 'role:admin|product-manager'])->group(function () {




    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::middleware('role:admin')->group(function () {
        Route::get('/brands', [BrandController::class, 'index'])->name('brand');
        Route::post('/brands-store', [BrandController::class, 'store'])->name('brand.store');
        Route::get('/brand-edit/{editedBrand:slug}', [BrandController::class, 'editBrand'])->name('brand.edit');
        Route::put('/brand-update/{brand:slug}', [BrandController::class, 'updateBrand'])->name('brand.update');
        Route::delete('/brand-delete/{brand:slug}', [BrandController::class, 'deleteBrand'])->name('brand.delete');
    });



    Route::prefix('/category')->name('category.')->group(function () {
        Route::get('/add', [CategoryController::class, 'categoryAdd'])->name('add');
        Route::post('/store', [CategoryController::class, 'categoryStore'])->name('store');
        Route::get('/edit/{editedCategory:slug}', [CategoryController::class, 'categoryEdit'])->name('edit');
        Route::put('/update/{editedCategory:slug}', [CategoryController::class, 'categoryUpdate'])->name('update');
    });


    Route::prefix('/sub-category')->name('subcategory.')->group(function () {
        Route::get('/add', [CategoryController::class, 'subcategoryAdd'])->name('add');
        Route::post('/store', [CategoryController::class, 'subcategoryStore'])->name('store');
        Route::get('/edit/{editedSubCategory:slug}', [CategoryController::class, 'subCategoryEdit'])->name('edit');
    });



    Route::prefix('/product')->name('product.')->group(function () {
        Route::get('/add', [ProductController::class, 'storeProduct'])->name('add');
        Route::get('/fetch-sub-category/{id}', [ProductController::class, 'fetchSubCategory'])->name('fetch.subcategory');
        Route::POST('/store', [ProductController::class, 'store'])->name('store');
    });
});
