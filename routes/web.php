<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommandeController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
require __DIR__.'/adminauth.php';

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    
});



Route::middleware('auth:admin')->group(function () {
   Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
   Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
   Route::get('/products', [ProductController::class, 'index'])->name('products.index');
   Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');   
   Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
   Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
   Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    
        Route::middleware('auth:admin')->group(function () {
            Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });
    });

    Route::prefix('cart')->group(function () {
        Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
        Route::get('/', [CartController::class, 'showCart'])->name('cart.show');
    });

    Route::middleware(['auth'])->group(function () {
        Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
        Route::get('/checkout', [CommandeController::class, 'index'])->name('commandes.index');
        Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commandes.show');
        Route::get('/mescommandes', [CommandeController::class, 'showUserCommandes'])->name('user.commandes');
        Route::get('/commandes/{id}/pdf', [CommandeController::class, 'generatePdf'])->name('generate-pdf');
    });
    