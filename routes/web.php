<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InstructionsController;
use App\Http\Controllers\InstructionСomplaintsController;

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
    return view('welcome');
});

// доступно только для авторизированных пользователей, что-то вроде dashboard для авторизированных пользователей
//Route::get('/home', [HomeController::class, 'index'])->name('home');


//Route::get('refresh-captcha', '___Controller@refreshCaptcha')->name('refreshCaptcha');
Route::get('/register/captcha-refresh', [RegisterController::class, 'refreshCaptcha'])->name('refreshCaptcha');
Auth::routes();






Route::get('/instructions/{instructionId}/complaints/create', [InstructionСomplaintsController::class, 'create'])->name('instructions.complaints.createForInstructionId');
Route::get('/instructions/{instructionId}/complaints', [InstructionСomplaintsController::class, 'complaintsByInstructionId'])->name('instructions.complaints');
Route::resource('/instructions/complaints', InstructionСomplaintsController::class);
//TODO выяснить как переименовать роутинг с "complaints.index" в "instructions.complaints.index"

Route::post('/instructions/search_ajax', [InstructionsController::class, 'searchAjax'])->name('instructions.search.ajax');
Route::resource('/instructions', InstructionsController::class); // ->only([ 'index', 'show' ]




