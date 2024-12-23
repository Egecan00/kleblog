<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ProductResource;

// Route::get('/product' , function() {
//     dd('hi');
// })->withoutMiddleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function (){ //bu grubun içindeki tüm rotalar, yalnızca kimlik doğrulaması yapılmış kullanıcılar tarafından erişilebilir.
    Route::resource('product', ProductController::class);
    Route::post('/product', [ProductController::class, 'store']);
    Route::apiResource('product',ProductController::class);
    Route::get('/product', [ProductController::class, 'index']);
    
    Route::get('/product/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/product/{product}', [ProductController::class, 'update']);
    // Route::delete('/product/{product}', [ProductController::class, 'destroy']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
    Route::get('/product/{id}', [ProductController::class, 'show']);
    
 });






Route::get('/', function () {
    return response()->json('E');
});


// Kayıt sayfası için rota
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Giriş sayfası için rota
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');





