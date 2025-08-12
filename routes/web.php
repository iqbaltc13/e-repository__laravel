<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\JournalCategoryController;
use App\Http\Controllers\JournalAuthorController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

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


// Authentication routes (jika menggunakan Laravel Breeze/Jetstream)
Route::auth();

Route::middleware(['auth', 'verified'])->group(function () {

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

    // Profile
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

// Public routes (untuk akses tanpa login)
Route::get('/journals/public', [JournalController::class, 'publicIndex'])->name('journals.public');
Route::get('/journals/public/{journal}', [JournalController::class, 'publicShow'])->name('journals.public.show');
Route::get('/journals/public/{journal}/download', [JournalController::class, 'publicDownload'])->name('journals.public.download');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
