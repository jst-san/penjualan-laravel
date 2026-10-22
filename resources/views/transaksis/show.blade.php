@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('subtitle', $transaksi->nomor_transaksi)

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ route('transaksis.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-800">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke daftar transaksi
        </a>

        @if (auth()->user()->isSuperadmin())
            <div class="flex items-center gap-3">
                <a href="{{ route('transaksis.edit', $transaksi) }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">Edit</a>
                <form method="POST" action="{{ route('transaksis.destroy', $transaksi) }}" onsubmit="return confirm('Hapus transaksi {{ $transaksi->nomor_transaksi }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">Hapus</button>
                </form>
            </div>
        @endif
    </div>

    <div class="grid gap-5 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Nomor Transaksi</p>
            <p class="mt-1 text-lg font-semibold text-slate-900">{{ $transaksi->nomor_transaksi }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Tanggal</p>
            <p class="mt-1 text-lg font-semibold text-slate-900">{{ \Illuminate\Support\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Total</p>
            <p class="mt-1 text-lg font-semibold text-blue-600">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="text-sm font-semibold text-slate-900">Rincian Item</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Barang</th>
                        <th class="px-5 py-3 text-right">Harga</th>
                        <th class="px-5 py-3 text-center">Jumlah</th>
                        <th class="px-5 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksi->detailTransaksis as $detail)
                        <tr>
                            <td class="px-5 py-3">
                                <p class="font-medium text-slate-800">{{ $detail->barang?->nama_barang ?? 'Barang dihapus' }}</p>
                                <p class="font-mono text-xs text-slate-400">{{ $detail->barang?->kode_barang }}</p>
                            </td>
                            <td class="whitespace-nowrap px-5 py-3 text-right text-slate-600">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-center text-slate-600">{{ $detail->jumlah }}</td>
                            <td class="whitespace-nowrap px-5 py-3 text-right font-medium text-slate-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-sm text-slate-400">Tidak ada rincian item.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-50">
                    <tr>
                        <td colspan="3" class="px-5 py-3 text-right text-sm font-semibold text-slate-600">Total</td>
                        <td class="whitespace-nowrap px-5 py-3 text-right text-base font-bold text-slate-900">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
