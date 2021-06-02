<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentConfirmationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('product.index');

Route::patch('/cart-items/{id}', [CartItemController::class, 'update'])->name('cart_item.update');
Route::post('/cart-items', [CartItemController::class, 'create'])->name('cart_item.create');
Route::get('/cart-items', [CartItemController::class, 'index'])->name('cart_item.index');

Route::post('/transactions/{uuid}/payment_confirmation', [PaymentConfirmationController::class, 'create'])->name('transaction.payment_confirmation.create');

Route::get('/transactions/{uuid}', [TransactionController::class, 'show'])->name('transaction.show');
Route::post('/transactions', [TransactionController::class, 'create'])->name('transaction.create');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');

Route::get('/oauth/google', function () {
    return Socialite::driver('google')->setScopes(['openid', 'profile', 'email'])
                                       ->stateless()
                                       ->redirect();
});

Route::get('/oauth/google/callback', function () {
    $userData = Socialite::driver('google')->setScopes(['openid', 'profile', 'email'])
                                       ->stateless()
                                       ->user();

    $existingUser = User::firstWhere('email', $userData->getEmail());
    if ($existingUser) {
        Auth::loginUsingId($existingUser->id, true);
    } else {
        $newUser = User::create([
            'name' => $userData->getName(),
            'email' => $userData->getEmail(),
            'password' => Hash::make(Str::uuid())
        ]);
        Auth::loginUsingId($newUser->id, true);
    }

    return redirect(route('home'));
});
