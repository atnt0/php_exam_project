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
Route::get('/register/captcha-refresh', [RegisterController::class, 'refreshCaptcha'])
    ->name('refreshCaptcha');
Auth::routes();





// {instructionId] в роутах не везде стоит в правильном порядке в сгенерированных ресурсах
Route::get('/instruction/{instructionId}/complaints/create', [InstructionСomplaintsController::class, 'createForInstructionId'])
    ->name('instructions.complaints.createForInstructionId');
Route::get('/instruction/{instructionId}/complaints', [InstructionСomplaintsController::class, 'complaintsByInstructionId'])
    ->name('instructions.complaints.indexComplaintsforInstruction'); // complaints for one instruction


Route::post('/instructions/complaints/{instructionComplaintId}/set_accepted', [InstructionСomplaintsController::class, 'setAccepted'])
    ->name('instructions.complaints.setAccepted');
Route::post('/instructions/complaints/{instructionComplaintId}/set_rejected', [InstructionСomplaintsController::class, 'setRejected'])
    ->name('instructions.complaints.setRejected');

Route::resource('/instructions/complaints', InstructionСomplaintsController::class)
    ->except([ 'create', 'edit', 'update' ]) // исключить
    ->names([
        // get-pages
        'index' => 'instructions.complaints.index', // all complaints
        'show' => 'instructions.complaints.show',
        //'create' => 'instructions.complaints.create', // стандартный отключим, он нам не нужен
        //'edit' => 'instructions.complaints.edit',
        // post-events
        'store' => 'instructions.complaints.store',
        //'update' => 'instructions.complaints.update',
        'destroy' => 'instructions.complaints.destroy',
    ]);
//TODO выяснить как переименовать роутинг с "complaints.index" в "instructions.complaints.index"


Route::post('/instructions/search_ajax', [InstructionsController::class, 'searchAjax'])
    ->name('instructions.search.ajax');
Route::post('/instructions/{instructionId}/set_approved', [InstructionsController::class, 'setApproved'])
    ->name('instructions.setApproved');
Route::resource('/instructions', InstructionsController::class); // ->only([ 'index', 'show' ])




