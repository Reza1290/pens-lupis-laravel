<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JawabanTugasController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CreditsController;
use App\Http\Controllers\API\DetailCreditsController;
use App\Http\Controllers\API\MataKuliahController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\TugasController;
use App\Models\Credits;
use App\Models\DetailCredit;
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

    Route::post('credits/dosen/index',[CreditsController::class, 'indexDosen'])->middleware('auth.roles:dosen');
    Route::post('credits/wali/index',[CreditsController::class,'indexWali'])->middleware('auth.roles:wali');
    Route::resource('credits',CreditsController::class);

    Route::resource('user',UserController::class);
    Route::resource('matakuliah', MataKuliahController::class);
    Route::resource('tugas', TugasController::class);
    Route::resource('jawaban', JawabanTugasController::class);
    
    Route::resource('kelas', KelasController::class);

    Route::group(['prefix' => 'sks'], function () {
        Route::get('',[DetailCreditsController::class,'index']);
        Route::post('index', [DetailCreditsController::class,'indexMahasiswa']);
        Route::post('add',[DetailCreditsController::class,'store']);
    });
    
});