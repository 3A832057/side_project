<?php

use App\Http\Controllers\Back\ProfileController as BackProfileController;
use App\Http\Controllers\Front\ProfileController as FrontProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MemberMiddleware;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::prefix('back')->group(function () {
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/', function () {
            return Inertia::render('Back/Dashboard');
        })->name('back.dashboard');

        Route::get('/user', function () {
            return Inertia::render('Back/User/Index');
        })->name('back.user.index');
        
        Route::get('/category', function () {
            return Inertia::render('Back/Category/Index');
        })->name('back.category.index');

        Route::get('/profile', [BackProfileController::class, 'edit'])->name('back.profile.edit');
        Route::patch('/profile', [BackProfileController::class, 'update'])->name('back.profile.update');
        Route::delete('/profile', [BackProfileController::class, 'destroy'])->name('back.profile.destroy');
        
        Route::prefix('/product')->group( function(){
                Route::get('/', function () {
                    return Inertia::render('Back/Product/Index');
                })->name('back.product.index');
                
                Route::get('/material', function () {
                    return Inertia::render('Back/Product/material');
                })->name('back.product.material');

            }
        );

    });
    
    // 其他後台路由
});

Route::prefix('member')->group(function () {
    Route::middleware([MemberMiddleware::class])->group(function () {
        Route::get('/', function () {
            return Inertia::render('Front/Member/Dashboard');
        })->name('member.dashboard');

        Route::get('/profile', [FrontProfileController::class, 'edit'])->name('member.profile.edit');
        Route::patch('/profile', [FrontProfileController::class, 'update'])->name('member.profile.update');
        Route::delete('/profile', [FrontProfileController::class, 'destroy'])->name('member.profile.destroy');
    });

});


require __DIR__.'/auth.php';
