<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\JournalCategoryController;
use App\Http\Controllers\JournalAuthorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalPublicController;
use App\Http\Controllers\Auth\ResetPasswordController;

use PgSql\Lob;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

    // Register

// Authentication routes (jika menggunakan Laravel Breeze/Jetstream)
Route::auth();

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/users-data', [UserController::class, 'getData'])->name('users.data');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify-email');
    });
 // Email Verification


    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')->name('verification.send');



    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify-email');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Journals
    Route::resource('journals', JournalController::class);
    Route::get('journals/{journal}/download', [JournalController::class, 'download'])->name('journals.download');
    Route::patch('journals/{journal}/publish', [JournalController::class, 'publish'])->name('journals.publish');

    // Journal Categories
    Route::resource('journal-categories', JournalCategoryController::class);

    // Journal Authors (nested resource)
    Route::resource('journals.journal-authors', JournalAuthorController::class)
        ->except(['show'])
        ->names([
            'index' => 'journal-authors.index',
            'create' => 'journal-authors.create',
            'store' => 'journal-authors.store',
            'edit' => 'journal-authors.edit',
            'update' => 'journal-authors.update',
            'destroy' => 'journal-authors.destroy',
        ]);

    // Users Management
    Route::resource('users', UserController::class);

    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');

    // Profile
    Route::get('/profile-show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // API routes for AJAX requests
    Route::prefix('api')->group(function () {
        Route::get('faculties/{institution_code}', function($institution_code) {
            return \App\Models\Faculty::where('institution_code', $institution_code)
                ->where('status', 'aktif')
                ->get(['id', 'faculty_name', 'faculty_code']);
        });

        Route::get('departments/{faculty_code}', function($faculty_code) {
            return \App\Models\Department::where('faculty_code', $faculty_code)
                ->get(['id', 'name', 'department_code']);
        });
    });
});
Auth::routes();
Route::post('/submit-reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset-submit');

// Public routes (untuk akses tanpa login)
Route::get('/journals-public-dashboard', [JournalPublicController::class, 'dashboard'])->name('journals.public.dashboard');
Route::get('/journals-public', [JournalPublicController::class, 'index'])->name('journals.public');
Route::get('/journals-public/{journal}', [JournalPublicController::class, 'show'])->name('journals.public.show');
Route::get('/journals-public/{journal}/download', [JournalPublicController::class, 'download'])->name('journals.public.download');




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
