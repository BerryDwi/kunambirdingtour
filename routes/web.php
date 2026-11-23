<?php

use App\Http\Controllers\LandingPage\BookingController;
use App\Http\Controllers\LandingPage\ContactController;
use App\Http\Controllers\LandingPage\CustomTourController;
use App\Http\Controllers\LandingPage\LeaderController;
use App\Http\Controllers\LandingPage\ReportController;
use App\Http\Controllers\LandingPage\TermsController;
use App\Http\Controllers\LandingPage\TourController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TourController::class, 'home'])->name('home');
Route::get('/tours', [TourController::class, 'tours'])->name('tours');
Route::get('/tours/{tour:slug}', [TourController::class, 'show'])->name('tours.show');
Route::get('/custom-tours', [CustomTourController::class, 'index'])->name('custom-tours');
Route::permanentRedirect('/customtours', '/custom-tours');
Route::get('/tour-reports', [ReportController::class, 'index'])->name('tour-reports');
Route::permanentRedirect('/tourreports', '/tour-reports');
Route::get('/leaders', [LeaderController::class, 'index'])->name('leaders');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::permanentRedirect('/bookingform', '/booking');
Route::permanentRedirect('/confirm', '/booking');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/contactus', fn () => redirect('/contact', 301));
Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:5,1')->name('contact.send');
Route::post('/contactus', [ContactController::class, 'send'])->middleware('throttle:5,1');
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::permanentRedirect('/terms-and-conditions', '/terms');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots']);
