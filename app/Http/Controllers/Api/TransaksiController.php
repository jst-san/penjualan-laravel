<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transaksis = Transaksi::all();

        return response()->json(['success' => true, 'data' => $transaksis], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $items = $request->items;

        if (!$items) return response()->json(['success' => false, 'message' => 'Daftar barang kosong'], 400 );

        $barangs = Barang::select('id', 'stok', 'harga')->whereIn('id', array_map(fn($i) => $i['id'], $items))->get();
        
        $details = [];
        $total = 0;

        $errors = [];

        foreach($items as $item) {
            $match = $barangs->find($item['id']);
            if (!$match) {
                $errors = [...$errors, (object) ['id' => $item['id'], 'code' => 'ITEM_NOT_FOUND', 'message' => 'Barang ini tidak ditemukan']];
                continue;
            } else if ($item['qty'] > $match->stok) {
                $errors = [...$errors, (object) ['id' => $item['id'], 'code' => 'STOK_EXCEEDED', 'message' => 'Stok barang ini tidak cukup']];
                continue;
            }

            $subtotal = $item['qty'] * $match->harga;

            $details = [...$details, ['barang_id' => $item['id'],'harga' => $match->harga, 'jumlah' => $item['qty'], 'subtotal' => $subtotal]];
            $total += $subtotal;
        }

        if (!empty($errors)) return response()->json(['errors' => $errors]);

        $nomor_transaksi = 'TRX-'.now()->format('Ymd').'-'.sprintf('%03d',Transaksi::whereDate('created_at', now()->today())->count() + 1);
        $tanggal = date('Y-m-d');

        $transaksi = Transaksi::create(['nomor_transaksi' => $nomor_transaksi, 'tanggal' => $tanggal, 'total' => $total]);

        if (!$transaksi->id) return response()->json(['success' => false,'errors' => [['code' => 'INTERNAL_SERVER_ERROR', 'message' => 'Terjadi kesalahan, silahkan coba lagi']]], 500);

        DetailTransaksi::insert(array_map(fn($d) => ['transaksi_id' => $transaksi->id, ...$d], $details));

        foreach($details as $d) {
            Barang::where('id', $d['barang_id'])->decrement('stok', $d['jumlah']);
        }

        return response()->json(['success' => true,'message' => "Transaksi $nomor_transaksi berhasil dibuat"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Transaksi::where('id', $id)->delete();
        
        return redirect()->back();
    }
}
