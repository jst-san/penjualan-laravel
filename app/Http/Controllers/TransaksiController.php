<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the transaksis.
     */
    public function index(): View
    {
        $transaksis = Transaksi::withCount('detailTransaksis')
            ->orderByDesc('id')
            ->paginate(10);

        return view('transaksis.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new transaksi.
     */
    public function create(): View
    {
        $barangs = Barang::where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('transaksis.create', compact('barangs'));
    }

    /**
     * Store a newly created transaksi in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['nullable', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.barang_id' => ['required', 'integer', 'exists:barangs,id'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'items.required' => 'Tambahkan minimal satu barang.',
            'items.min' => 'Tambahkan minimal satu barang.',
        ]);

        $items = collect($validated['items']);

        $transaksi = DB::transaction(function () use ($items, $validated) {
            $barangs = Barang::whereIn('id', $items->pluck('barang_id')->unique())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $details = [];

            foreach ($items as $item) {
                $barang = $barangs->get($item['barang_id']);

                if (! $barang) {
                    throw ValidationException::withMessages([
                        'items' => 'Barang tidak ditemukan.',
                    ]);
                }

                if ($item['jumlah'] > $barang->stok) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$barang->nama_barang} tidak mencukupi (tersedia {$barang->stok}).",
                    ]);
                }

                $subtotal = $barang->harga * $item['jumlah'];
                $total += $subtotal;

                $details[] = [
                    'barang_id' => $barang->id,
                    'harga' => $barang->harga,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                ];
            }

            $nomorTransaksi = 'TRX-'.now()->format('Ymd').'-'.sprintf('%03d', Transaksi::whereDate('created_at', today())->count() + 1);

            $transaksi = Transaksi::create([
                'nomor_transaksi' => $nomorTransaksi,
                'tanggal' => $validated['tanggal'] ?? now()->format('Y-m-d'),
                'total' => $total,
            ]);

            $transaksi->detailTransaksis()->createMany($details);

            foreach ($details as $detail) {
                Barang::whereKey($detail['barang_id'])->decrement('stok', $detail['jumlah']);
            }

            return $transaksi;
        });

        return redirect()
            ->route('transaksis.show', $transaksi)
            ->with('success', "Transaksi {$transaksi->nomor_transaksi} berhasil dibuat.");
    }

    /**
     * Display the specified transaksi.
     */
    public function show(Transaksi $transaksi): View
    {
        $transaksi->load('detailTransaksis.barang');

        return view('transaksis.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified transaksi.
     */
    public function edit(Transaksi $transaksi): View
    {
        return view('transaksis.edit', compact('transaksi'));
    }

    /**
     * Update the specified transaksi in storage.
     */
    public function update(Request $request, Transaksi $transaksi): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_transaksi' => ['required', 'string', 'max:30', Rule::unique('transaksis', 'nomor_transaksi')->ignore($transaksi->id)],
            'tanggal' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
        ]);

        $transaksi->update($validated);

        return redirect()
            ->route('transaksis.show', $transaksi)
            ->with('success', "Transaksi {$transaksi->nomor_transaksi} berhasil diperbarui.");
    }

    /**
     * Remove the specified transaksi from storage.
     */
    public function destroy(Transaksi $transaksi): RedirectResponse
    {
        $transaksi->delete();

        return redirect()
            ->route('transaksis.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
