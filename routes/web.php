<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;

Route::redirect('/', '/login');

Route::get('/landing', fn () => view('landing'))->name('landing');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/features', fn () => view('features'))->name('features');

Route::get('/games', [GameController::class, 'collection'])->name('games.collection');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/debug-avatar', function () {
    $user = Auth::user()->fresh();
    $path = 'uploads/' . $user->avatar;

    return response()->json([
        'avatar_field'        => $user->avatar,
        'avatar_url'          => $user->avatar_url,
        'path_checked'        => $path,
        'storage_exists'      => \Storage::disk('public')->exists($path),
        'full_storage_path'   => storage_path('app/public/' . $path),
        'file_exists_on_disk' => file_exists(storage_path('app/public/' . $path)),
        'public_storage_link' => public_path('storage'),
        'symlink_exists'      => is_link(public_path('storage')),
        'asset_url'           => asset('storage/' . $path),
        'app_url'             => config('app.url'),
    ]);
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::put('/dashboard/{user}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/{user}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo/update', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo/remove', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    Route::get('/gamecollection', fn () => view('gamecollection'))->name('gamecollection');

    Route::post('/api/user/heartbeat', function () {
        auth()->user()->update(['last_seen_at' => now()]);
        return response()->json(['ok' => true]);
    });

    Route::get('/api/user/status', function () {
        return response()->json([
            'is_online' => auth()->user()->isOnline()
        ]);
    });
});