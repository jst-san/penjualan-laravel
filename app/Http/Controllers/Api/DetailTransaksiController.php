<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detailTransaksis = DetailTransaksi::all();

        return response()->json($detailTransaksis, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_id' => 'required|numeric|min:1',
            'barang_id' => 'required|numeric|min:1',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);
        $transaksi = Transaksi::findOrFail($validated['transaksi_id']);

        $validated['harga'] = $barang->harga;
        $validated['subtotal'] = $validated['jumlah'] * $barang->harga;

        $detailTransaksi = DetailTransaksi::create($validated);
        $barang->decrement('stok', $detailTransaksi->jumlah);
        $transaksi->increment('total', $detailTransaksi->subtotal);

        return response()->json(['message' => "Detail transaksi berhasil dibuat", 'item' => $detailTransaksi], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailTransaksi $detailTransaksi)
    {  
        return response()->json($detailTransaksi, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailTransaksi $detailTransaksi)
    {
        $validated = $request->validate([
            'transaksi_id' => 'required|numeric|min:1', 
            'barang_id' => 'required|numeric|min:1', 
            'harga' => 'required|numeric|min:0', 
            'jumlah' => 'required|numeric|min:0', 
            'subtotal' => 'required|numeric|min:0']);

        $detailTransaksi->update($validated);

        return response()->json(['message' => "Detail transaksi dengan id = $detailTransaksi->id berhasil diedit", 'item' => $detailTransaksi], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailTransaksi $detailTransaksi)
    {
        $detailTransaksi->delete();

        return response()->noContent();
    }
}
