<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/', function () {
//     return Inertia::render('login');
// })->middleware(['auth', 'verified'])->name('login');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/', [ProductController::class, 'create'])->name('profile.destroy');
});

Route::middleware('auth')->group(function(){
    Route::get('/create',[ProductController::class,'create'])->name('products.create');
    Route::post('/store',[ProductController::class,'store'])->name('products.store');
    Route::get('/',[ProductController::class,'index'])->name('dashboard');
    Route::get('/show/{id}',[ProductController::class,'show'])->name('products.show');
    Route::delete('/delete/{id}',[ProductController::class,'destroy'])->name('products.destroy');
    Route::put('/update/{id}',[ProductController::class,'update'])->name('products.update');
});


require __DIR__.'/auth.php';
if (env('APP_ENV')) { URL::forceScheme('https'); }
