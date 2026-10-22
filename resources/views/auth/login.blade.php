@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500 text-lg font-bold text-white shadow-lg shadow-blue-500/30">SP</span>
            <h1 class="mt-4 text-2xl font-bold text-slate-900">Selamat Datang</h1>
            <p class="mt-1 text-sm text-slate-500">Masuk untuk mengelola inventaris &amp; transaksi</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            @if ($errors->any())
                <div class="mb-5 flex items-start gap-3 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="nama@example.com"
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-500 focus:ring-blue-500">
                    Ingat saya
                </label>

                <button type="submit" class="w-full rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/40">
                    Masuk
                </button>
            </form>
        </div>

        <div class="mt-6 rounded-xl border border-slate-200 bg-white/70 p-4 text-xs text-slate-500">
            <p class="font-semibold text-slate-600">Akun demo</p>
            <p class="mt-1">Superadmin &mdash; superadmin@example.com / password</p>
            <p>Karyawan &mdash; karyawan@example.com / password</p>
        </div>
    </div>
@endsection
