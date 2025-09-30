<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OSController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;


// Tela de login
Route::get('/os/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/os/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/os/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard protegido
Route::get('/os/dashboard', [OSController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/os/dashboard/{codord}/{codire}', [OSController::class, 'details'])->middleware('auth')->name('site.details');

Route::post('/os/atribuir-servicos', [OSController::class, 'assignSelectedServices'])->name('site.assignSelectedServices');

// Redireciona / para login ou dashboard
Route::get('/os', function() {
    return redirect()->route('login');
});

//ADM ATRIBUIR OS
Route::post('/os/assign/{codord}/{codire}', [OSController::class, 'assign'])->name('os.assign');

Route::post('/os/action/{codord}/{codire}', [OSController::class, 'updateStatus'])->name('os.action');


//FUNCIONAMENTO DOS BOTÕES
Route::post('/os/{codord}/{codire}/start', [OSController::class, 'start'])->name('os.start');
Route::post('/os/{codord}/{codire}/pause', [OSController::class, 'pause'])->name('os.pause');
Route::post('/os/{codord}/{codire}/resume', [OSController::class, 'resume'])->name('os.resume');
Route::post('/os/{codord}/{codire}/finish', [OSController::class, 'finish'])->name('os.finish');





Route::get('/os/admin/create', [AdminController::class, 'showCreateAdminForm'])
    ->middleware('auth')
    ->name('admin.create.form');

Route::post('/os/admin/create', [AdminController::class, 'createAdmin'])
    ->middleware('auth')
    ->name('admin.create');
