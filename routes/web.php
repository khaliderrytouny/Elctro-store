<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/auth.php';

Auth::routes();

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Activation Routes
Route::get('activate/{code}', [ActivationController::class, 'activationUserAccount'])->name('user.activate');
Route::get('resend/{email}', [ActivationController::class, 'resendActivationCode'])->name('code.resend');

// Product Routes
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // Route to create a new product
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/category/{category}', [HomeController::class, 'getProductByCategory'])->name('category.product');

// Cart Routes
Route::post('/add/cart/{product}', [CartController::class, 'addProductToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::put('/update/{product}/cart', [CartController::class, 'updateProductInCart'])->name('update.cart');
Route::delete('/remove/{product}/cart', [CartController::class, 'removeProductFromCart'])->name('remove.cart');

// PayPal Routes
Route::get('paypal/payment', [PaypalPaymentController::class, 'handlePayment'])->name('make.payment');
Route::get('paypal/cancel', [PaypalPaymentController::class, 'paymentCancel'])->name('cancel.payment');
Route::get('paypal/success', [PaypalPaymentController::class, 'paymentSuccess'])->name('success.payment');

// Admin routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/login', [AdminController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
Route::get('/admin/products', [AdminController::class, 'getProducts'])->name('admin.products');
Route::get('/admin/orders', [AdminController::class, 'getOrders'])->name('admin.orders');

// Resource Routes for Orders and Products
Route::resource('orders', OrderController::class);
Route::resource('products', ProductController::class);

