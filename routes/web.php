<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\RealtorListingImageController;


Route::get("/", [ListingController::class, 'index']);

Route::resource('listing', ListingController::class)
  ->only(['index', 'show']);

Route::get('login', [AuthController::class, 'create'])
  ->name('login');

Route::post('login', [AuthController::class, 'store'])
  ->name('login.store');

Route::delete('logout', [AuthController::class, 'destroy'])
  ->name('logout');

Route::resource('user-account', UserAccountController::class)
->only(['create', 'store']);


Route::name('listing.restore')
->put(
  'listing/{listing}/restore',
  [RealtorListingController::class, 'restore']
)->withTrashed();

Route::prefix('realtor')
  ->name('realtor.')
  ->middleware('auth')
  ->group(function () {
    Route::name('listing.restore')
      ->put(
        'listing/{listing}/restore',
        [RealtorListingController::class, 'restore']
      )->withTrashed();
    Route::resource('listing', RealtorListingController::class)->withTrashed();
    
    Route::name('offer.accept')->put('offer/{offer}/accept', RealtorListingAcceptOfferController::class);
    
    Route::resource('listing.image', RealtorListingImageController::class)
        ->only(['create', 'store', 'destroy']);
  });

  Route::resource('listing.offer', ListingOfferController::class)
  ->middleware('auth')->only(['store']);

