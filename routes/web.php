<?php

use App\Http\Controllers\API\AuthController;
use App\Livewire\LoginComponent;
use App\Livewire\RegisterComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get("/login", LoginComponent::class)->name("login");
Route::get('/regist1er', [RegisterComponent::class, 'register']);

// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
// Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());