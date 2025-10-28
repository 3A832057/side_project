<?php

use App\Http\Middleware\AdminApiMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\UserController as BackUserController;
use App\Http\Controllers\Back\CategoryController as BackCategoryController;
use App\Http\Controllers\Back\MaterialControlle as BackMaterialController;
use App\Http\Controllers\Back\ComponentController as BackComponentController;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('back')->middleware([
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    ShareErrorsFromSession::class,
    'auth:sanctum',
    AdminApiMiddleware::class,
])->group(function () {
    Route::post('uploadImg',[BackComponentController::class ,'uploadImg']);
    Route::prefix('user')->group(function () {
        Route::get('/datatable', [BackUserController::class, 'getDatatable'])
            ->name('get.user.datatable');
        Route::get('find/{id}', [BackUserController::class,'find'])
            ->name('get.user.find');
        Route::put('{id}', [BackUserController::class,'update'])
            ->name('get.user.update');
    });
    Route::prefix('category')->group(function () {
        Route::get('/datatable/{level}', [BackCategoryController::class, 'getDatatableWithLevel'])
            ->name('get.category.datatable');
        Route::get('/childDatatable', [BackCategoryController::class, 'getChildDatatable'])
            ->name('get.category.childDatatable');
        Route::get('find/{id}', [BackCategoryController::class,'find'])
            ->name('get.category.find');
        Route::put('/sortOrder',[BackCategoryController::class,'setSort_order'])
            ->name('put.category.sort_order');
        Route::put('{id}', [BackCategoryController::class,'update'])
            ->name('put.category.update');
        Route::get('/parentList/{level}', [BackCategoryController::class,'getParentList'])
            ->name('get.category.parentList');
        Route::get('/getAllWithEnabled', [BackCategoryController::class,'getAllWithEnabled'])
            ->name('get.category.getAllWithEnabled');
        Route::get('/', [BackCategoryController::class,'get'])
            ->name('get.category.all');
            
        Route::post('/', [BackCategoryController::class,'store'])
            ->name('post.category.store');
    });
    Route::prefix('product')->group(function () {
        Route::get('/datatable', [\App\Http\Controllers\Back\ProductController::class, 'getDatatable'])
            ->name('get.product.datatable');
        Route::get('find/{id}', [\App\Http\Controllers\Back\ProductController::class,'find'])
            ->name('get.product.find');
        Route::post('/', [\App\Http\Controllers\Back\ProductController::class,'store'])
            ->name('post.product.store');
        Route::put('/{id}', [\App\Http\Controllers\Back\ProductController::class,'update'])
            ->name('put.product.update');
        Route::put('/edit/{id}', [\App\Http\Controllers\Back\ProductController::class,'updateAll'])
            ->name('put.product.updateAll');
        Route::put('{id}', [\App\Http\Controllers\Back\ProductController::class,'update'])
            ->name('put.product.update');
    });
    Route::prefix('material')->group(function () {
        Route::get('/datatable', [BackMaterialController::class, 'getDatatable'])
            ->name('get.material.datatable');
        Route::put('quantity',[BackMaterialController::class,'quantityUpdate'])
            ->name('put.material.quantityUpdate');
        Route::put('{id}', [BackMaterialController::class,'update'])
            ->name('put.material.update');
        Route::get('/getAllWithEnabled', [BackMaterialController::class,'getAllWithEnabled'])
            ->name('get.material.getAllWithEnabled');
        Route::get('find/{id}', [BackMaterialController::class,'find'])
            ->name('get.material.find');
        Route::get('/', [BackMaterialController::class,'get'])
            ->name('get.material.all');
        Route::post('/', [BackMaterialController::class,'store'])
            ->name('post.material.store');
    });
})->middleware('auth:sanctum');

require __DIR__.'/auth.php';

Route::get('/debug-cookies', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'cookies' => $request->cookies->all(),
        'headers' => $request->headers->all(),
        'user' => $request->user(),
    ]);
});
