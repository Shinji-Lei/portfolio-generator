<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', HomeController::class)->name('home');
Route::get('/templates', [TemplateController::class, 'gallery'])->name('templates.index');
Route::get('/templates/{template}/demo', [TemplateController::class, 'demo'])->name('templates.demo');

// Pages that require a logged-in user
Route::middleware('auth')->group(function () {
    // Breeze redirects here after login; send users to the Manage page
    Route::redirect('/dashboard', '/portfolios')->name('dashboard');

    // Portfolio CRUD: index, create, store, show, edit, update, destroy
    Route::resource('portfolios', PortfolioController::class);

    // Template selection and preview for a specific portfolio
    Route::get('portfolios/{portfolio}/template', [TemplateController::class, 'edit'])->name('portfolios.template.edit');
    Route::patch('portfolios/{portfolio}/template', [TemplateController::class, 'update'])->name('portfolios.template.update');
    Route::get('portfolios/{portfolio}/preview/{template}', [TemplateController::class, 'preview'])->name('portfolios.preview');

    // Breeze account settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze login, register, and password routes
require __DIR__ . '/auth.php';
