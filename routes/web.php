<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeintureController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\EmailConfigController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Peinture
Route::get('/peinture', [PeintureController::class, 'index'])->name('peinture');

// Design
Route::get('/design', [DesignController::class, 'index'])->name('design');

// Marques
Route::get('/marques/{slug?}', [MarqueController::class, 'index'])->name('marques');

// Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Orders (pour les commandes publiques)
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// API - Configuration EmailJS (publique)
Route::get('/api/email-config', [EmailConfigController::class, 'show'])->name('api.email-config');

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

// Dashboard utilisateur standard (Breeze)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // Rediriger admin vers admin dashboard, customer vers leur espace
        $user = request()->user();
        if ($user && ($user->type === 'admin' || $user->type === 'super_admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Admin & Super Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Orders
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    
    // Activities
    Route::resource('activities', AdminActivityController::class);
    
    // Users
    Route::resource('users', UserController::class);
    
    // Contacts (Messages)
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);
    
    // Profile (Change Password)
    Route::get('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/update-password', [AdminProfileController::class, 'updatePassword'])->name('profile.update-password');
});

/*
|--------------------------------------------------------------------------
| Developer Settings Routes (Super Admin Only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'super_admin'])->prefix('admin/developer')->name('admin.developer.')->group(function () {
    
    // Carousel Slides
    Route::resource('carousel', CarouselController::class)->except(['show']);
    
    // Page Contents (textes dynamiques)
    Route::get('/page-contents', [PageContentController::class, 'index'])->name('page-contents.index');
    Route::get('/page-contents/{page}', [PageContentController::class, 'edit'])->name('page-contents.edit');
    Route::put('/page-contents/{page}', [PageContentController::class, 'update'])->name('page-contents.update');
    
    // Site Settings
});
