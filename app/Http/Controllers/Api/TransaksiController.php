<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::all();

        return response()->json($transaksis, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $items = $request->items;

        if (empty($items) || !is_array($items)) {
            return response()->json(['code' => 'BAD_REQUEST', 'message' => 'Daftar barang kosong'], 400);
        }

        $barangIds = array_unique(array_column($items, 'id'));

        return DB::transaction(function () use ($items, $barangIds) {
            $barangs = Barang::whereIn('id', $barangIds)->lockForUpdate()->get()->keyBy('id');

            $details = [];
            $total = 0;
            $errors = [];

            foreach ($items as $i) {
                $barang = $barangs->get($i['id']);

                if (!$barang) {
                    $errors[] = ['id' => $i['id'], 'code' => 'ITEM_NOT_FOUND', 'message' => 'Barang tidak ditemukan'];
                    continue;
                }

                if ($i['qty'] > $barang->stok) {
                    $errors[] = ['id' => $i['id'], 'code' => 'STOK_EXCEEDED', 'message' => 'Stok barang tidak cukup'];
                    continue;
                }

                $subtotal = $i['qty'] * $barang->harga;
                $total += $subtotal;

                $details[] = [
                    'barang_id' => $barang->id,
                    'harga' => $barang->harga,
                    'jumlah' => $i['qty'],
                    'subtotal' => $subtotal,
                ];
            }

            if (!empty($errors)) {
                DB::rollBack();
                return response()->json($errors, 409);
            }

            $nomor_transaksi = 'TRX-' . now()->format('Ymd') . '-' . sprintf('%03d', Transaksi::whereDate('created_at', today())->count() + 1);

            $transaksi = Transaksi::create([
                'nomor_transaksi' => $nomor_transaksi,
                'tanggal' => now()->format('Y-m-d'),
                'total' => $total,
            ]);

            $detailData = array_map(fn($d) => ['transaksi_id' => $transaksi->id, ...$d], $details);
            DetailTransaksi::insert($detailData);

            foreach ($details as $d) {
                Barang::where('id', $d['barang_id'])->decrement('stok', $d['jumlah']);
            }

            return response()->json(['message' => "Transaksi $nomor_transaksi berhasil dibuat"], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        return response()->json($transaksi, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'nomor_transaksi' => 'required|string|max:30',
            'tanggal' => 'required|string|max:20',
            'total' => 'required|numeric|min:0',
        ]);

        $transaksi->update($validated);

        return response()->json(['message' => "Transaksi $transaksi->nomor_transaksi berhasil diedit"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return response()->noContent();
    }
}
