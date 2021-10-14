<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    return view('home', compact('brands'));
});

Route::get('/about', function () {
    return view('about');
});

Route::get('contact', [ContactController::class, 'index']);



// Cate

Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all_category');

Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store_category');

Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']);

Route::post('/category/update/{id}', [CategoryController::class, 'Update']);

Route::get('/softdelete/category/{id}', [CategoryController::class, 'SoftDelete']);

Route::get('/category/restore/{id}', [CategoryController::class, 'Restore']);

Route::get('/pdelete/category/{id}', [CategoryController::class, 'Pdelete']);



// Brand

Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all_brand');

Route::post('/brand/add', [BrandController::class, 'StoreBrand'])->name('store_brand');

Route::get('/brand/edit/{id}', [BrandController::class, 'Edit']);

Route::post('/brand/update/{id}', [BrandController::class, 'Update']);

Route::get('/brand/delete/{id}', [BrandController::class, 'Delete']);

// multi_image

Route::get('/multi/image', [BrandController::class, 'MultiPic'])->name('multi_image');

Route::post('/multi/add', [BrandController::class, 'StoreImage'])->name('store_image');

// logout

Route::get('/user/logout', [BrandController::class, 'Logout'])->name('user_logout');

//Admin Routes

Route::get('/home/slider', [HomeController::class, 'HomeSlider'])->name('home_slider');

Route::get('/add/slider', [HomeController::class, 'AddSlider'])->name('add_slider');

Route::post('/store/slider', [HomeController::class, 'StoreSlider'])->name('store_slider');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::All();
    $users = DB::table('users')->get();
    return view('admin.index', compact('users'));
})->name('dashboard');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
