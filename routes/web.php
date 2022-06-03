<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Models\User;



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
    return view('welcome');
});

Route::get('/home', function () {
    //return view('welcome');
    echo "This is homepage";
});

// Route::get('about', function () {
Route::get('/about', function () {
    return view('about');
})->middleware('check');

Route::get('/contact-test-test', [ContactController::class, 'index'])->name('con');

// Category 
Route::get('category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::get('category/edit/{id}', [CategoryController::class, 'Edit']);
Route::get('softdelete/category/{id}', [CategoryController::class, 'SoftDelete']);
Route::get('category/restore/{id}', [CategoryController::class, 'Restore']);
Route::get('forcedelete/category/{id}', [CategoryController::class, 'ForceDelete']);
Route::post('category/add', [CategoryController::class, 'AddCat'])->name('store.category');
Route::post('category/update/{id}', [CategoryController::class, 'Update']);

// Brand
Route::get('brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('brand/add', [BrandController::class, 'AddBrand'])->name('store.brand');
Route::get('brand/edit/{id}', [BrandController::class, 'Edit']);
Route::get('softdelete/brand/{id}', [BrandController::class, 'SoftDelete']);
Route::get('brand/restore/{id}', [BrandController::class, 'Restore']);
Route::get('forcedelete/brand/{id}', [BrandController::class, 'ForceDelete']);
Route::post('brand/update/{id}', [BrandController::class, 'Update']);

// Multi Image 
Route::get('multi/all', [BrandController::class, 'Multipic'])->name('multi.image');
Route::post('multi/add', [BrandController::class, 'AddImage'])->name('store.image');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        //$users = User::all();

        $users = DB::table('users')->get();
        return view('admin.index', compact('users'));
    })->name('dashboard');
});
Route::get('user/logout', [BrandController::class, 'Logout'])->name('user.logout');