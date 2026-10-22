@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan data inventaris & transaksi')

@section('content')
    <div @class(['grid gap-5 sm:grid-cols-2', 'xl:grid-cols-4' => auth()->user()->isSuperadmin(), 'xl:grid-cols-3' => auth()->user()->isKaryawan()])>
        <x-stat-card label="Total Barang" :value="$barangsCount" accent="blue" footer="Jenis barang terdaftar">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </x-stat-card>

        <x-stat-card label="Total Transaksi" :value="$transaksisCount" accent="violet" footer="Seluruh transaksi tercatat">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </x-stat-card>

        <x-stat-card label="Total Pendapatan" :value="'Rp '.number_format($transaksisTotal, 0, ',', '.')" accent="emerald" footer="Akumulasi nilai transaksi">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </x-stat-card>

        @if (auth()->user()->isSuperadmin())
            <x-stat-card label="Total User" :value="$usersCount" accent="amber" footer="Akun pengguna sistem">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z"/></svg>
            </x-stat-card>
        @else
            <x-stat-card label="Transaksi Hari Ini" :value="$todayTransaksisCount" accent="amber" footer="Transaksi berjalan hari ini">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </x-stat-card>
        @endif
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900">Stok Menipis</h2>
                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">Stok &le; 10</span>
            </div>

            @if ($lowStocks->isEmpty())
                <p class="px-5 py-8 text-center text-sm text-slate-400">Semua stok barang aman.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($lowStocks as $barang)
                        <li class="flex items-center justify-between gap-3 px-5 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $barang->nama_barang }}</p>
                                <p class="text-xs text-slate-400">{{ $barang->kode_barang }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-600">{{ $barang->stok }} unit</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900">Transaksi Terbaru</h2>
                <a href="{{ route('transaksis.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">Lihat semua</a>
            </div>

            @if ($recentTransaksis->isEmpty())
                <p class="px-5 py-8 text-center text-sm text-slate-400">Belum ada transaksi.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentTransaksis as $transaksi)
                        <li class="flex items-center justify-between gap-3 px-5 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $transaksi->nomor_transaksi }}</p>
                                <p class="text-xs text-slate-400">{{ \Illuminate\Support\Carbon::parse($transaksi->tanggal)->translatedFormat('d M Y') }} &middot; {{ $transaksi->detail_transaksis_count }} item</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-slate-900">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
