<?php

use App\Livewire\LoginComponent;
use App\Livewire\RegisterComponent;
use App\Livewire\TaskManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', LoginComponent::class)
    ->name('login');

Route::get('/register', RegisterComponent::class)
    ->name('register');

Route::get('/task-manager', TaskManager::class)
    ->middleware('auth')
    ->name('task-manager');
