<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthPassportController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Sanctum 

Route::prefix("v1/auth")->group(function() {

    Route::post("login", [AuthController::class, "funIngresar"]);
    Route::post("register", [AuthController::class, "funRegistro"]);

    Route::middleware('auth:sanctum')->group(function(){

        Route::get("profile", [AuthController::class, "funPerfil"]);
        Route::post("logout", [AuthController::class, "funSalir"]);

    });

});

// Passport
Route::post("/passport/login", [AuthPassportController::class, "funIngresar"]);
Route::post("/passport/register", [AuthPassportController::class, "funRegistro"]);
Route::get("/passport/profile", [AuthController::class, "funPerfil"])->middleware('auth:api');

Route::middleware('auth:sanctum')->group(function(){

    //Permiso 
    Route::get("permiso/paginacion", [PermisoController::class, "indexPaginacion"]);
    
    Route::apiResource("users", UserController::class);
    Route::apiResource("permiso", PermisoController::class);
    Route::apiResource("role", RoleController::class);

});

Route::post("reset-password", [ResetPasswordController::class, "recuperarPassword"]);
Route::post("cambio-password", [ResetPasswordController::class, "resetPassword"]);

Route::get("/no-autorizado", function(){
    return response()->json(["message" => "Accion no autorizada"]);
})->name("login");