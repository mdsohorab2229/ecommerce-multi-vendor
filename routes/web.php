<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
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

        //Categories
        Route::get('categories', [CategoryController::class, 'categories']);
        Route::post('update-category-status', [CategoryController::class, 'updateCategoryStatus']);

    });
});
