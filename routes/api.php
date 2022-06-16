<?php

use App\Http\Controllers\Api\FiliereController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('filieres',[FiliereController::class,'index_filieres']);
Route::get('filieres/{id}',[FiliereController::class,'getgroupes']);
Route::get('groupes/{id}',[FiliereController::class,'getstagiaires']);
Route::get('profs/{id}',[FiliereController::class,'getprofs']);
Route::get('etats/{id}/{period}/{selected_period_debut}/{selected_period_fin}',[FiliereController::class,'getetats']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
