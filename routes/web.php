<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductdetailsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchasedetailsController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuotedetailsController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::resource('products',ProductController::class)->middleware('auth');
Route::get('/products/{id}/details', [ProductdetailsController::class, 'index'])->name('product.historique')->middleware('auth');



Route::resource('purchases',PurchaseController::class)->middleware('auth');

Route::get('/purchase/{id}', [PurchasedetailsController::class, 'index'])->name('purchase.details')->middleware('auth');
Route::Post('/purchase/{id}', [PurchasedetailsController::class, 'store'])->name('details.store')->middleware('auth');

Route::get('/purchase/purchasedetails/{id}', [PurchasedetailsController::class, 'show'])->name('details.show')->middleware('auth');
Route::post('/purchase/purchasedetails/destroy/{id}', [PurchasedetailsController::class, 'destroy'])->name('details.destroy')->middleware('auth');

// Order Routes

Route::get('/orders', action: [OrderController::class, 'index'])->name('order.index')->middleware('auth');
Route::post('/orders/create', action: [OrderController::class, 'store'])->name('order.store')->middleware('auth');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show')->middleware('auth');
Route::post('/orders/{id}', [OrderController::class, 'destroy'])->name('order.destroy')->middleware('auth');



// Quote Routes
Route::resource('quotes',QuoteController::class)->middleware('auth');
Route::get('/quote/{id}/print', [QuoteController::class, 'view'])->name('quote.print')->middleware('auth');
Route::get('/quote/passingCustomer', [QuoteController::class, 'passingCustomer'])->name('quote.customer')->middleware('auth');




//Quote details Routes

Route::get('/quote/{id}', [QuotedetailsController::class, 'index'])->name('quotedetails.index')->middleware('auth');
Route::post('/quote/{id}', [QuotedetailsController::class, 'store'])->name('quotedetails.store')->middleware('auth');

Route::get('/quote/{id}/show', [QuotedetailsController::class, 'show'])->name('quotedetails.show')->middleware('auth');
Route::post('/quote/{id}/destroy', [QuotedetailsController::class, 'destroy'])->name('quotedetails.destroy')->middleware('auth');

Route::get('/quote/qoutedtails/{id}/price', [QuotedetailsController::class, 'getPrice'])->name('quotedetails.price')->middleware('auth');



// Sales

Route::resource('sales',SaleController::class)->middleware('auth');
Route::get('/sale/{id}/facture', [SaleController::class, 'show'])->name('sale.print')->middleware('auth');
Route::get('/sale/{id}/quote', [SaleController::class, 'getTotal'])->name('sale.price')->middleware('auth');


//Sales Payment

Route::post('/sale/{id}/payment/destroy', [PaymentController::class, 'destroy'])->name('payment.destroy')->middleware('auth');
Route::get('/sales/payment/{id}/receipt', [PaymentController::class, 'view'])->name('payment.print')->middleware('auth');


//Dashboard
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.index')->middleware('auth');
Route::get('/dashboard/calculer', [HomeController::class, 'calculate'])->name('dashboard.calculate')->middleware('auth');


