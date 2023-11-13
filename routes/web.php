<?php

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScrumteamController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;

use Illuminate\Support\Facades\Auth;

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

// Main router
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('Dashboard');
    } else {
        return redirect()->route('login');
    }
});

// Routes for not logged in users
Route::group(['middleware' => 'guest'], function () {
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/activateAcc', [AuthController::class, 'display_activationform'])->name('Activate account');
    Route::post('/activateAcc', [AuthController::class, 'activate_account'])->name('Activate account');
});

// Routes for logged in users
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');
    Route::get('/workshops', [WorkshopController::class, 'workshops'])->name('workshops');
});

// Routes for logged in teachers
Route::group(['middleware' => AdminMiddleware::class], function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');

    Route::post('/dashboard/complete', [DashboardController::class, 'completeQuestion'])->name('completeQuestion');

    Route::get('/addWorkshop', [WorkshopController::class, 'addWorkshop'])->name('addWorkshop');
    Route::post('/addWorkshop', [WorkshopController::class, 'addWorkshopPost'])->name('addWorkshop');
    Route::get('/workshops/applications/{workshopId}', [WorkshopController::class, 'showApplications'])->name('showApplications');

    Route::get('/addScrumteam', [ScrumteamController::class, 'scrumteam'])->name('addScrumteam');

    Route::get('/gebruikers', [AuthController::class, 'users'])->name('users');

    Route::match(['post', 'get'],'/scrumteams', [ScrumteamController::class, 'index'])->name('scrumteams');


    Route::post('/addScrumteam', [ScrumteamController::class, 'addScrumteamPost'])->name('addScrumteam.post');
    Route::get('/fetch-students/{classId}', [ScrumteamController::class,'fetchStudents']);
    Route::match(['post', 'get'],'/archive-scrumteam/{id}', [ScrumteamController::class, 'archiveScrumteam'])->name('archive_scrumteam');

});

// Routes for logged in students
Route::group(['middleware' => StudentMiddleware::class], function () {
    Route::post('/workshops', [WorkshopController::class, 'signUp'])->name('workshops');
    Route::post('/dashboard/ask', [DashboardController::class, 'askQuestion'])->name('askQuestion');
    Route::post('/update-status/{memberId}/{status}', [AuthController::class, 'updateStatus']);
});