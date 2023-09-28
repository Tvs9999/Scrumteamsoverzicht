<?php

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScrumteamController;

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


// Routes for displaying the login form and handling the login request
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');

Route::get('/workshops', [WorkshopController::class, 'workshops'])->name('workshops');
Route::post('/workshops', [WorkshopController::class, 'signUp'])->name('workshops');
Route::get('/addWorkshop', [WorkshopController::class, 'addWorkshop'])->name('addWorkshop');
Route::post('/addWorkshop', [WorkshopController::class, 'addWorkshopPost'])->name('addWorkshop');

Route::get('/activateAcc', [AuthController::class, 'display_activationform'])->name('Activate account');
Route::post('/activateAcc', [AuthController::class, 'activate_account'])->name('Activate account');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');

Route::get('/addScrumteam', [ScrumteamController::class, 'addScrumteam'])->name('scrumteam');



