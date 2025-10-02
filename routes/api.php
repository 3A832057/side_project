<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\UserController as BackUserController;
use App\Http\Controllers\Back\CategoryController as BackCategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('back')->group(function () {
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
            ->name('post.category.parentList');
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
        Route::put('{id}', [\App\Http\Controllers\Back\ProductController::class,'update'])
            ->name('put.product.update');
    });
});