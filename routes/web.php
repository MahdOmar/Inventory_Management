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
    return view('layouts.layout');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('products',ProductController::class);
Route::get('/products/{id}/details', [ProductdetailsController::class, 'index'])->name('product.historique');



Route::resource('purchases',PurchaseController::class);

Route::get('/purchase/{id}', [PurchasedetailsController::class, 'index'])->name('purchase.details');
Route::Post('/purchase/{id}', [PurchasedetailsController::class, 'store'])->name('details.store');

Route::get('/purchase/purchasedetails/{id}', [PurchasedetailsController::class, 'show'])->name('details.show');
Route::post('/purchase/purchasedetails/destroy/{id}', [PurchasedetailsController::class, 'destroy'])->name('details.destroy');

// Order Routes

Route::get('/orders', action: [OrderController::class, 'index'])->name('order.index');
Route::post('/orders/create', action: [OrderController::class, 'store'])->name('order.store');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');
Route::post('/orders/{id}', [OrderController::class, 'destroy'])->name('order.destroy');



// Quote Routes
Route::resource('quotes',QuoteController::class);
Route::get('/quote/{id}/print', [QuoteController::class, 'view'])->name('quote.print');



//Quote details Routes

Route::get('/quote/{id}', [QuotedetailsController::class, 'index'])->name('quotedetails.index');
Route::post('/quote/{id}', [QuotedetailsController::class, 'store'])->name('quotedetails.store');

Route::get('/quote/{id}/show', [QuotedetailsController::class, 'show'])->name('quotedetails.show');
Route::post('/quote/{id}/destroy', [QuotedetailsController::class, 'destroy'])->name('quotedetails.destroy');

Route::get('/quote/qoutedtails/{id}/price', [QuotedetailsController::class, 'getPrice'])->name('quotedetails.price');


// Sales

Route::resource('sales',SaleController::class);
Route::get('/sale/{id}/facture', [SaleController::class, 'show'])->name('sale.print');
Route::get('/sale/{id}/quote', [SaleController::class, 'getTotal'])->name('sale.price');



//Sales Payment

Route::post('/sale/{id}/payment/destroy', [PaymentController::class, 'destroy'])->name('payment.destroy');
Route::get('/sales/payment/{id}/receipt', [PaymentController::class, 'view'])->name('payment.print');


//Dashboard
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/calculer', [HomeController::class, 'calculate'])->name('dashboard.calculate');


