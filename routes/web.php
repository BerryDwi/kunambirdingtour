<?php

use App\Http\Controllers\LandingPage\BookingController;
use App\Http\Controllers\LandingPage\ContactController;
use App\Http\Controllers\LandingPage\CustomTourController;
use App\Http\Controllers\LandingPage\LeaderController;
use App\Http\Controllers\LandingPage\ReportController;
use App\Http\Controllers\LandingPage\TermsController;
use App\Http\Controllers\LandingPage\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TourController::class, 'home'])->name('home');
Route::get('/tours', [TourController::class, 'tours'])->name('tours');
Route::get('/custom-tours', [CustomTourController::class, 'index'])->name('custom-tours');
Route::get('/customtours', [CustomTourController::class, 'index']);
Route::get('/tour-reports', [ReportController::class, 'index'])->name('tour-reports');
Route::get('/tourreports', [ReportController::class, 'index']);
Route::get('/leaders', [LeaderController::class, 'index'])->name('leaders');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/bookingform', [BookingController::class, 'index'])->name('booking.form');
Route::get('/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/contactus', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::post('/contactus', [ContactController::class, 'send']);
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::get('/terms-and-conditions', [TermsController::class, 'index']);
