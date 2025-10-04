@extends('layouts.app')
@section('content')
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h1>Register</h1>
        <form wire:submit.prevent="register">
            <div>
                <label>Name</label>
                <input type="text" wire:model="name" placeholder="Name">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label>Email</label>
                <input type="email" wire:model="email" placeholder="Email">
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label>Password</label>
                <input type="password" wire:model="password" placeholder="Password">
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" wire:model="password_confirmation" placeholder="Confirm Password">
                @error('password_confirmation')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit">Register</button>
            <p>Already have an account? <a href="/login">Login</a></p>
        </form>
    </div>
@endsection
