<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/team', [TeamController::class, 'index'])->name('team');
Route::get('/portfolio', [App\Http\Controllers\PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{id}', [App\Http\Controllers\PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/advisory', [App\Http\Controllers\AdvisoryController::class, 'index'])->name('advisory.index');
Route::get('/advisory/{id}', [App\Http\Controllers\AdvisoryController::class, 'show'])->name('advisory.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes (must come before the catch-all route)
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.store');
    Route::get('/login/2fa', [App\Http\Controllers\Auth\LoginController::class, 'show2FAForm'])->name('login.2fa');
    Route::post('/login/2fa', [App\Http\Controllers\Auth\LoginController::class, 'verify2FA'])->name('login.verify2fa');
    // Registration disabled - admins are created by administrators only via Manage Admins page
    // Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

// Catch-all page route (must be last)
Route::get('/{page}', [PageController::class, 'show'])->name('page.show');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Team Members Management
    Route::resource('team', App\Http\Controllers\Admin\TeamMemberController::class);

    // Contacts Management
    Route::get('contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('contacts/delete-all', [App\Http\Controllers\Admin\ContactController::class, 'deleteAll'])->name('contacts.deleteAll');

    // Pages Management
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class);

    // Home Sections Management
    Route::resource('home-sections', App\Http\Controllers\Admin\HomeSectionController::class);

    // Portfolio Management
    Route::resource('portfolios', App\Http\Controllers\Admin\PortfolioAdminController::class);

    // Features Management
    Route::resource('features', App\Http\Controllers\Admin\FeatureAdminController::class);

    // About Paragraphs Management
    Route::resource('about-paragraphs', App\Http\Controllers\Admin\AboutParagraphAdminController::class);

    // Menu Management
    Route::resource('menus', App\Http\Controllers\Admin\MenuController::class);
    Route::post('menus/reorder', [App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('menus.reorder');

    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    Route::get('home-sections', [App\Http\Controllers\Admin\HomeSectionController::class, 'index'])->name('home-sections.index');

    // Admin Users Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::put('users/{user}/password', [App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('users.updatePassword');
    Route::put('users/{user}/disable-2fa', [App\Http\Controllers\Admin\UserController::class, 'disable2FA'])->name('users.disable2FA');

    // Profile & Account Settings
    Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'editPassword'])->name('profile.editPassword');
    Route::post('profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::get('profile/2fa/setup', [App\Http\Controllers\Admin\ProfileController::class, 'setup2FA'])->name('profile.setup2FA');
    Route::post('profile/2fa/enable', [App\Http\Controllers\Admin\ProfileController::class, 'enable2FA'])->name('profile.enable2FA');
    Route::post('profile/2fa/disable', [App\Http\Controllers\Admin\ProfileController::class, 'disable2FA'])->name('profile.disable2FA');

    // Image Upload for CKEditor
    Route::post('upload-image', [App\Http\Controllers\Admin\UploadController::class, 'uploadImage'])->name('upload.image');
});
