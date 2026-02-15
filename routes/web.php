<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Home and main pages
Route::get('/', [HomeController::class, 'index'])->name('home');

// Store and products
Route::get('/store', function () {
    return view('store');
})->name('store');

Route::get('/products/{category?}', function ($category = null) {
    return view('store');
})->name('products.category');

// Product details
Route::get('/product/{id}', function ($id) {
    return view('product');
})->name('product.show');

// Shopping cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

// Account/Profile
Route::get('/account', function () {
    return view('account');
})->name('account');

// Wishlist
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist', [WishlistController::class, 'add'])->name('wishlist.store');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin authentication
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin area (protected by auth + EnsureUserIsAdmin middleware)
Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Basic product/user management pages
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
});

// Development helpers (only available when APP_DEBUG=true and from localhost)
if (env('APP_DEBUG')) {
    $allowedIps = ['127.0.0.1', '::1'];

    // create admin via POST {name,email,password}
    Route::post('/dev/create-admin', function () use ($allowedIps) {
        if (! in_array(request()->ip(), $allowedIps)) abort(404);
        request()->validate([ 'email' => 'required|email', 'password' => 'required|min:6', 'name' => 'nullable|string' ]);
        $name = request('name') ?: 'Dev Admin';
        $email = request('email');
        $password = request('password');

        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'role' => 'admin']);
        } else {
            $user->password = Hash::make($password);
            $user->role = 'admin';
            $user->save();
        }

        return response()->json(['success' => true, 'email' => $user->email]);
    });

    // Impersonate a user by email (GET /dev/impersonate?email=)
    Route::get('/dev/impersonate', function () use ($allowedIps) {
        if (! in_array(request()->ip(), $allowedIps)) abort(404);
        $email = request('email');
        if (! $email) return redirect('/');
        $user = User::where('email', $email)->first();
        if (! $user) return redirect('/');
        Auth::login($user);
        return redirect('/');
    });

    // create a regular test user via POST {name,email,password}
    Route::post('/dev/create-user', function () use ($allowedIps) {
        if (! in_array(request()->ip(), $allowedIps)) abort(404);
        request()->validate([ 'email' => 'required|email', 'password' => 'required|min:6', 'name' => 'nullable|string' ]);
        $name = request('name') ?: 'Dev User';
        $email = request('email');
        $password = request('password');

        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'role' => 'user']);
        } else {
            $user->password = Hash::make($password);
            $user->role = 'user';
            $user->save();
        }

        return response()->json(['success' => true, 'email' => $user->email]);
    });
}

// Compare products
Route::get('/compare', function () {
    return view('compare');
})->name('compare');

// Hot deals
Route::get('/hot-deals', function () {
    return view('blank');
})->name('hot-deals');

// Category pages
Route::get('/laptops', function () {
    return view('store');
})->name('laptops');

Route::get('/smartphones', function () {
    return view('store');
})->name('smartphones');

Route::get('/cameras', function () {
    return view('store');
})->name('cameras');

Route::get('/accessories', function () {
    return view('store');
})->name('accessories');

// Additional pages
Route::get('/about', function () {
    return view('blank');
})->name('about');

Route::get('/contact', function () {
    return view('blank');
})->name('contact');

Route::get('/privacy', function () {
    return view('blank');
})->name('privacy');

Route::get('/returns', function () {
    return view('blank');
})->name('returns');

Route::get('/terms', function () {
    return view('blank');
})->name('terms');

Route::get('/track-order', function () {
    return view('blank');
})->name('track-order');

Route::get('/help', function () {
    return view('blank');
})->name('help');
