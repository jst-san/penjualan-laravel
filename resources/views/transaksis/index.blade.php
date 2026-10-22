@extends('layouts.app')

@section('title', 'Transaksi')
@section('subtitle', 'Daftar seluruh transaksi penjualan')

@section('content')
    @if (auth()->user()->isSuperadmin())
        <div class="mb-6 flex justify-end">
            <a href="{{ route('transaksis.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Buat Transaksi
            </a>
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Nomor Transaksi</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3 text-center">Item</th>
                        <th class="px-5 py-3 text-right">Total</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksis as $transaksi)
                        <tr class="transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-5 py-3 font-medium text-slate-800">{{ $transaksi->nomor_transaksi }}</td>
                            <td class="whitespace-nowrap px-5 py-3 text-slate-600">{{ \Illuminate\Support\Carbon::parse($transaksi->tanggal)->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3 text-center text-slate-600">{{ $transaksi->detail_transaksis_count }}</td>
                            <td class="whitespace-nowrap px-5 py-3 text-right font-semibold text-slate-900">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('transaksis.show', $transaksi) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">Detail</a>
                                    @if (auth()->user()->isSuperadmin())
                                        <a href="{{ route('transaksis.edit', $transaksi) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">Edit</a>
                                        <form method="POST" action="{{ route('transaksis.destroy', $transaksi) }}" onsubmit="return confirm('Hapus transaksi {{ $transaksi->nomor_transaksi }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $transaksis->links() }}
    </div>
@endsection
