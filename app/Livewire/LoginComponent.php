<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class LoginComponent extends Component
{
    public $email, $password;

    public function login()
    {
        $response = Http::post(config('app.url') . '/api/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            session(['token' => $response['token']]);
            return redirect()->route('dashboard');
        } else {
            session()->flash('error', 'Invalid credentials');
        }
    }

    public function render()
    {
        return view('livewire.login-component')
            ->layout('layouts.app');
    }
}
