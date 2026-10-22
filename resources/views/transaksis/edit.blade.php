@extends('layouts.app')

@section('title', 'Edit Transaksi')
@section('subtitle', $transaksi->nomor_transaksi)

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <p class="font-semibold">Periksa kembali data yang diisi:</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('transaksis.update', $transaksi) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 sm:grid-cols-3">
                <div class="sm:col-span-1">
                    <label for="nomor_transaksi" class="mb-1.5 block text-sm font-medium text-slate-700">Nomor Transaksi</label>
                    <input id="nomor_transaksi" name="nomor_transaksi" type="text" value="{{ old('nomor_transaksi', $transaksi->nomor_transaksi) }}" maxlength="30" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                </div>

                <div>
                    <label for="tanggal" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal</label>
                    <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', \Illuminate\Support\Carbon::parse($transaksi->tanggal)->format('Y-m-d')) }}" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                </div>

                <div>
                    <label for="total" class="mb-1.5 block text-sm font-medium text-slate-700">Total (Rp)</label>
                    <input id="total" name="total" type="number" min="0" step="1" value="{{ old('total', $transaksi->total) }}" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                </div>
            </div>

            <p class="mt-4 text-xs text-slate-400">Perubahan pada rincian item barang tidak dilakukan dari halaman ini.</p>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('transaksis.show', $transaksi) }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
            <button type="submit" class="rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600">Perbarui Transaksi</button>
        </div>
    </form>
@endsection
