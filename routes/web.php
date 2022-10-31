<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewJob;
use App\Http\Controllers\Fulfillment;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('home');
});

// Redirect register to /
Route::get('/register', function () {
    return redirect('/');
});

// Upload Page for a New Job
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role'
])->group(function () {
    Route::get('/new-job', function () {
        return Inertia::render('NewJob');
    })->name('new-job');
});

// Fulfillment Job List
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/job-list', [Fulfillment::class, 'listJobs'])->name('job-list');

// Delete the Job
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role'
])->get('/delete-job/{id}', [Fulfillment::class, 'deleteJob'])->name('delete-job');

// Fulfillment Work Page
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/fulfillment/{id}', [Fulfillment::class, 'fulfillJob'])->name('fulfillment');

// Allocation end point
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->post('/allocate', [Fulfillment::class, 'allocate'])->name('allocate');

// Deallocation end point
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->post('/deallocate', [Fulfillment::class, 'deallocate'])->name('deallocate');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role'
])->post('/new-job', [NewJob::class, 'newUpload'])->name('new-upload');
