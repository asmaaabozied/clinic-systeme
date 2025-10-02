<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [ApiController::class, 'login']);
Route::post('login-react', [\App\Http\Controllers\Api\Auth\LoginReactController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('get-projects', [ApiController::class, 'getProjects']);
    Route::post('add-tracker', [ApiController::class, 'addTracker']);
    Route::post('stop-tracker', [ApiController::class, 'stopTracker']);
    Route::post('upload-photos', [ApiController::class, 'uploadImage']);

    Route::prefix('medical')->group(function () {
        Route::apiResource('specializations', App\Http\Controllers\Api\Medical\SpecializationController::class);
        Route::get('specializations/search', [App\Http\Controllers\Api\Medical\SpecializationController::class, 'search']);
        Route::get('specializations/{id}/doctors', [App\Http\Controllers\Api\Medical\SpecializationController::class, 'doctors']);
        Route::get('specializations-datatable', [App\Http\Controllers\Api\Medical\SpecializationController::class, 'datatable']);
        
        Route::apiResource('medicine-categories', App\Http\Controllers\Api\Medical\MedicineCategoryController::class);
        Route::get('medicine-categories-datatable', [App\Http\Controllers\Api\Medical\MedicineCategoryController::class, 'datatable']);
        
        Route::apiResource('doses', App\Http\Controllers\Api\Medical\DoseController::class);
        Route::get('doses-datatable', [App\Http\Controllers\Api\Medical\DoseController::class, 'datatable']);
        
        Route::apiResource('dose-intervals', App\Http\Controllers\Api\Medical\DoseIntervalController::class);
        Route::get('dose-intervals-datatable', [App\Http\Controllers\Api\Medical\DoseIntervalController::class, 'datatable']);
    });

    Route::prefix('opd')->group(function () {
        Route::get('patients-datatable', [App\Http\Controllers\Api\OPD\PatientController::class, 'datatable']);
        Route::get('patients/next-code', [App\Http\Controllers\Api\OPD\PatientController::class, 'getNextCode']);
        Route::post('patients', [App\Http\Controllers\Api\OPD\PatientController::class, 'store']);
    });

});


