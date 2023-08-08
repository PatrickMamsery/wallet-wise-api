<?php

use App\Http\Controllers\API\BudgetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\API\ExpenseController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('api-test', function() {
    return response()->json(['message' => 'Up and okay!'], 200);
});

Route::post('/register', [PassportAuthController::class, 'register']);
Route::post('/login', [PassportAuthController::class, 'login'])->name('login.api');


Route::middleware('auth:api')->group(function() {

    Route::group(['middleware' => 'withoutlink'], function() {
        Route::apiResource('budgets', BudgetController::class);

        Route::apiResource('expenses', ExpenseController::class);

        // Route::apiResource('expenses', ExpenseController::class);
    });

    // Password manipulation routes
    Route::post('change-password', [UserController::class, 'changePassword']);

    Route::post('/logout', [PassportAuthController::class, 'logout']);

    Route::get('/test', function() {
        return response()->json(['message' => 'Hello World!'], 200);
    });
});

