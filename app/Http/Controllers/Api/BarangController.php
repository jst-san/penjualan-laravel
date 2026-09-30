<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::all();

        return response()->json($barangs, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0'
        ]);

        $barang = Barang::create($validated);

        return response()->json(['message' => "Barang $barang->nama_barang berhasil ditambahkan", 'item' => $barang], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return response()->json($barang, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kode_barang' => 'required|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0'
        ]);

        $barang->update($validated);

        return response()->json(['message' => "Barang $barang->nama_barang berhasil diedit"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return response()->noContent();
    }
}
