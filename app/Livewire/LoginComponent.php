<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            $this->addError('email', 'Email atau password salah.');
            return;
        }

        session()->regenerate();

        session()->flash('success', 'Login berhasil!');

        return redirect()->route('task-manager');
    }

    public function render()
    {
        return view('livewire.login-component');
    }
}
