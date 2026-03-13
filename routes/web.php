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
        'cars'     => \App\Models\Car::latest()->get(),
        'hero'     => \App\Models\HeroSetting::getOrDefault(),
        'stats'    => \App\Models\StatItem::getOrDefault(),
        'features' => \App\Models\FeatureItem::getOrDefault(),
        'steps'    => \App\Models\StepItem::getOrDefault(),
        'terms'    => \App\Models\TermSetting::getOrDefault(),
        'faqs'     => \App\Models\FaqItem::orderBy('order_index')->get(),
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

    // Keunggulan Section Settings
    Route::get('/features/edit', [\App\Http\Controllers\FeatureItemController::class, 'edit'])->name('features.edit');
    Route::put('/features', [\App\Http\Controllers\FeatureItemController::class, 'update'])->name('features.update');
    Route::delete('/features/reset', [\App\Http\Controllers\FeatureItemController::class, 'reset'])->name('features.reset');

    // Cara Memesan Section Settings
    Route::get('/steps/edit', [\App\Http\Controllers\StepItemController::class, 'edit'])->name('steps.edit');
    Route::put('/steps', [\App\Http\Controllers\StepItemController::class, 'update'])->name('steps.update');
    Route::delete('/steps/reset', [\App\Http\Controllers\StepItemController::class, 'reset'])->name('steps.reset');

    // Syarat Sewa Section Settings
    Route::get('/terms/edit', [\App\Http\Controllers\TermSettingController::class, 'edit'])->name('terms.edit');
    Route::put('/terms', [\App\Http\Controllers\TermSettingController::class, 'update'])->name('terms.update');
    Route::delete('/terms/reset', [\App\Http\Controllers\TermSettingController::class, 'reset'])->name('terms.reset');

    // FAQ Section Settings
    Route::get('/faqs/edit', [\App\Http\Controllers\FaqItemController::class, 'edit'])->name('faqs.edit');
    Route::put('/faqs', [\App\Http\Controllers\FaqItemController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/reset', [\App\Http\Controllers\FaqItemController::class, 'reset'])->name('faqs.reset');

});

require __DIR__.'/auth.php';
