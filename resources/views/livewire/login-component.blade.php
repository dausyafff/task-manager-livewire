<div>
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
