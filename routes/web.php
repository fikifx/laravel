<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('landingpage/index', [
        'cars'  => \App\Models\Car::latest()->get(),
        'hero'  => \App\Models\HeroSetting::getOrDefault(),
        'stats' => \App\Models\StatItem::getOrDefault(),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'stats' => [
            'totalArmada' => \App\Models\Car::count(),
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('armada', \App\Http\Controllers\CarController::class);

    // Hero Section Settings
    Route::get('/hero/edit', [\App\Http\Controllers\HeroSettingController::class, 'edit'])->name('hero.edit');
    Route::put('/hero', [\App\Http\Controllers\HeroSettingController::class, 'update'])->name('hero.update');
    Route::delete('/hero/reset', [\App\Http\Controllers\HeroSettingController::class, 'reset'])->name('hero.reset');

    // Stats Section Settings
    Route::get('/stats/edit', [\App\Http\Controllers\StatItemController::class, 'edit'])->name('stats.edit');
    Route::put('/stats', [\App\Http\Controllers\StatItemController::class, 'update'])->name('stats.update');
    Route::delete('/stats/reset', [\App\Http\Controllers\StatItemController::class, 'reset'])->name('stats.reset');
});

require __DIR__.'/auth.php';
