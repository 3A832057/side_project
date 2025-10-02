<?php

use App\Http\Controllers\Front\Auth\AuthenticatedSessionController as FrontAuthenticatedSessionController;
use App\Http\Controllers\Front\Auth\ConfirmablePasswordController as FrontConfirmablePasswordController;
use App\Http\Controllers\Front\Auth\EmailVerificationNotificationController as FrontEmailVerificationNotificationController;
use App\Http\Controllers\Front\Auth\EmailVerificationPromptController as FrontEmailVerificationPromptController;
use App\Http\Controllers\Front\Auth\NewPasswordController as FrontNewPasswordController;
use App\Http\Controllers\Front\Auth\PasswordController as FrontPasswordController;
use App\Http\Controllers\Front\Auth\PasswordResetLinkController as FrontPasswordResetLinkController;
use App\Http\Controllers\Front\Auth\RegisteredUserController as FrontRegisteredUserController;
use App\Http\Controllers\Front\Auth\VerifyEmailController as FrontVerifyEmailController;

use App\Http\Controllers\Back\Auth\AuthenticatedSessionController as BackAuthenticatedSessionController;
use App\Http\Controllers\Back\Auth\ConfirmablePasswordController as BackConfirmablePasswordController;
use App\Http\Controllers\Back\Auth\EmailVerificationNotificationController as BackEmailVerificationNotificationController;
use App\Http\Controllers\Back\Auth\EmailVerificationPromptController as BackEmailVerificationPromptController;
use App\Http\Controllers\Back\Auth\NewPasswordController as BackNewPasswordController;
use App\Http\Controllers\Back\Auth\PasswordController as BackPasswordController;
use App\Http\Controllers\Back\Auth\PasswordResetLinkController as BackPasswordResetLinkController;
use App\Http\Controllers\Back\Auth\VerifyEmailController as BackVerifyEmailController;
use App\Http\Controllers\Back\Auth\RegisteredUserController as BackRegisteredUserController;


// 前台 Frontend Routes

Route::prefix('/')->group(function () {
    Route::get('register', [FrontRegisteredUserController::class, 'create'])
    ->name('front.register');

    Route::post('register', action: [FrontRegisteredUserController::class, 'store']);

    Route::get('login', [FrontAuthenticatedSessionController::class, 'create'])
        ->name('front.login');

    Route::post('login', [FrontAuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [FrontPasswordResetLinkController::class, 'create'])
        ->name('front.password.request');

    Route::post('forgot-password', [FrontPasswordResetLinkController::class, 'store'])
        ->name('front.password.email');

    Route::get('reset-password/{token}', [FrontNewPasswordController::class, 'create'])
        ->name('front.password.reset');

    Route::post('reset-password', [FrontNewPasswordController::class, 'store'])
        ->name('front.password.store');
});


// 後台 Admin Routes
Route::prefix('back')->group(function () {

    Route::get('login', [BackAuthenticatedSessionController::class, 'create'])
        ->name('back.login');

    Route::post('login', [BackAuthenticatedSessionController::class, 'store']);

    Route::post('register', [BackRegisteredUserController::class, 'store']);

    Route::get('forgot-password', [BackPasswordResetLinkController::class, 'create'])
        ->name('back.password.request');

    Route::post('forgot-password', [BackPasswordResetLinkController::class, 'store'])
        ->name('back.password.email');

    Route::get('reset-password/{token}', [BackNewPasswordController::class, 'create'])
        ->name('back.password.reset');

    Route::post('reset-password', [BackNewPasswordController::class, 'store'])
        ->name('back.password.store');

});
    



Route::middleware('auth')->group(function () {
    // Route::get('verify-email', FrontRegisteredUserController::class)
    //     ->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', FrontVerifyEmailController::class)
    //     ->middleware(['signed', 'throttle:6,1'])
    //     ->name('verification.verify');

    // Route::post('email/verification-notification', [FrontEmailVerificationNotificationController::class, 'store'])
    //     ->middleware('throttle:6,1')
    //     ->name('verification.send');

    Route::get('confirm-password', [FrontConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [FrontConfirmablePasswordController::class, 'store']);

    Route::put('password', [FrontPasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [FrontAuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
