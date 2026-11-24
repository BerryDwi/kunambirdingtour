<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CustomTourController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\Admin\PageSettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TermsSectionController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Loaded from bootstrap/app.php with the "web" middleware group and an
| "admin" prefix/name. Everything except the login screens requires an
| authenticated administrator.
|
*/

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('profile', ProfileController::class)->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('tours', TourController::class);
    // The full hero slide listing was retired in favour of per-page settings under "Pages".
    // Restore by removing "index" from the except list below.
    Route::resource('hero-slides', HeroSlideController::class)->except(['show', 'index']);
    Route::resource('leaders', LeaderController::class)->except(['show']);
    Route::resource('tour-reports', TourReportController::class)->except(['show']);
    Route::resource('custom-tours', CustomTourController::class)->except(['show']);
    Route::resource('terms-sections', TermsSectionController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);

    Route::get('pages/{page}', [PageSettingController::class, 'show'])->name('pages.show');
    Route::put('pages/{page}', [PageSettingController::class, 'update'])->name('pages.update');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/logo', [SettingController::class, 'updateLogo'])->name('settings.update-logo');
    Route::get('settings/create', [SettingController::class, 'create'])->name('settings.create');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
    Route::put('settings/group/{group}', [SettingController::class, 'updateGroup'])
        ->where('group', '[A-Za-z0-9_-]+')
        ->name('settings.update-group');
    Route::delete('settings/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy');

    Route::get('bookings/export', [BookingController::class, 'export'])->name('bookings.export');
    Route::resource('bookings', BookingController::class)->only(['index', 'show', 'update', 'destroy']);

    Route::get('contact-messages/export', [ContactMessageController::class, 'export'])->name('contact-messages.export');
    Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);

    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});
