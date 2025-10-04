<?php

use App\Http\Controllers\API\AuthController;
use App\Livewire\LoginComponent;
use App\Livewire\RegisterComponent;
use App\Livewire\TaskManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get("/login", LoginComponent::class)->name("login");
Route::get('/register', RegisterComponent::class)->name('register');
Route::get("/task-manager", TaskManager::class)->name("task-manager")->middleware('auth');