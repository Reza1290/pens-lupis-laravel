<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JawabanTugasController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CreditsController;
use App\Http\Controllers\API\MataKuliahController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\TugasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

    // Route::middleware()
    
});

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login'])->name('login');

Route::group(['middleware'=> ['auth:api']],function () {
    Route::get('logout',[AuthController::class, 'logout']);
    Route::get('me',[AuthController::class, 'me']);
    Route::get('refresh',[AuthController::class, 'refresh']);
    Route::resource('credits',CreditsController::class, ['store','show']);
    
    Route::resource('user',UserController::class);
    Route::resource('matakuliah', MataKuliahController::class);
    Route::resource('tugas', TugasController::class);
    Route::resource('jawaban', JawabanTugasController::class);
    Route::resource('kelas', KelasController::class);
});