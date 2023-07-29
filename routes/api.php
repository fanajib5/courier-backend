<?php

// ~\courier-backend\routes\api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(CourierController::class)->group(function () {
    Route::get('couriers', 'index');
    Route::post('couriers', 'store');
    Route::get('couriers/{id}', 'show');
    Route::put('couriers/{id}', 'update');
    Route::delete('couriers/{id}', 'delete');
});
