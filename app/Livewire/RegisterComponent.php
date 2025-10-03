<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class RegisterComponent extends Component
{
    public $name, $email, $password, $password_confirmation;
    public function render()
    {
        return view('livewire.register-component');
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $response = Http::post(config('app.url') . '/api/register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        if ($response->successful()) {
            session()->flash('message', 'Registration successful! Please log in.');
            return redirect()->route('login');
        } else {
            session()->flash('error', 'Registration failed. Please try again.');
        }
    }
}
