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
        <h1>Halaman Login</h1>
        <form wire:submit.prevent="login">
            <input type="email" wire:model="email" placeholder="Email">
            @error('email')
                <span>{{ $message }}</span>
            @enderror
            <input type="password" wire:model="password" placeholder="Password">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
            <button type="submit">Login</button>
        </form>
        <a href="/register">Belum Punya Akun ???</a>
    </div>
@endsection
