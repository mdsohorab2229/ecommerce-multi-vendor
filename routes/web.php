<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::prefix('/admin')->group(function () {

    Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('admin.login');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard']);
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Update Admin Password
        Route::match(['get', 'post'], 'update-admin-password', [AdminController::class, 'updateAdminPassword'])->name('update.admin.password');
        Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails'])->name('update.admin.details');
        // Update vendor details
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', [AdminController::class, 'updateVendorDetails']);
        //Views Admin / Subadmin / Vendors 
        Route::get('admins/{type?}', [AdminController::class, 'admins']);
        //View vendor details
        Route::get('view-vendor-details/{id}', [AdminController::class, 'viewVendorDeatils']);
        //update admin status
        Route::post('update-admin-status', [AdminController::class, 'updateAdminStatus']);
        // Check Admin Password
        Route::post('check-admin-password', [AdminController::class, 'checkCurrentPassword']);

        // Section
        Route::get('sections', [SectionController::class, 'sections']);
        Route::post('update-section-status', [SectionController::class, 'updateSectionStatus']);
        Route::get('delete-section/{id}', [SectionController::class, 'deleteSection']);
        Route::match(['get', 'post'], 'add-edit-section/{id?}', [SectionController::class, 'addEditSection']);
        
        // Brands
        Route::get('brands', [BrandController::class, 'brands']);
        Route::post('update-brand-status', [BrandController::class, 'updateBrandStatus']);
        Route::get('delete-brand/{id}', [BrandController::class, 'deleteBrand']);
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', [BrandController::class, 'addEditBrand']);

        //Categories
        Route::get('categories', [CategoryController::class, 'categories']);
        Route::post('update-category-status', [CategoryController::class, 'updateCategoryStatus']);
        Route::match(['get', 'post'], 'add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);
        Route::get('append-categories-level', [CategoryController::class, 'appendCategoriesLevel']);
        Route::get('delete-category/{id}', [CategoryController::class, 'deleteCategory']);
        Route::get('delete-category-image/{id}', [CategoryController::class, 'deleteCategoryImage']);

        // Products
        Route::get('products', [ProductsController::class, 'products']);
        Route::post('update-product-status', [ProductsController::class, 'updateProductStatus']);
        Route::get('delete-product/{id}', [ProductsController::class, 'deleteProduct']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}', [ProductsController::class, 'addEditProduct']);
        Route::get('delete-product-image/{id}', [ProductsController::class, 'deleteProductImage']);
        Route::get('delete-product-video/{id}', [ProductsController::class, 'deleteProductVideo']);
        
        //Attributes
        Route::match(['get', 'post'], 'add-edit-attributes/{id}', [ProductsController::class, 'addEditAttributes']);
        Route::post('update-attribute-status', [ProductsController::class, 'updateAttributeStatus']);
        Route::match(['get', 'post'], 'edit-attributes/{id}', [ProductsController::class, 'editAttributes']);
    });
});
