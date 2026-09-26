<?php

namespace App\Http\Controllers;

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
        return view('barang.index', ['barangs'=>$barangs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'=>'required|string|max:100',
            'kode_barang' => 'required|string|max:20',
            'harga'=>'required|numeric|min:0',
            'stok'=>'required|numeric|min:0'
        ]);

        Barang::create([
            'nama_barang'=>$request->nama_barang,
            'kode_barang'=>$request->kode_barang,
            'harga'=>$request->harga,
            'stok'=>$request->stok
        ]);

        session()->flash('barang-created',"Barang $request->nama_barang berhasil ditambahkan");

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang) 
    {
        return view('barang.edit', ['barang' => $barang]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'=>'required|string|max:100',
            'kode_barang' => 'required|string|max:20',
            'harga'=>'required|numeric|min:0',
            'stok'=>'required|numeric|min:0'
        ]);

        Barang::where('id', $id)->update([
            'nama_barang'=>$request->nama_barang,
            'kode_barang'=>$request->kode_barang,
            'harga'=>$request->harga,
            'stok'=>$request->stok
        ]);

        session()->flash('barang-edited',"Barang $request->nama_barang berhasil diedit");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Barang::where('id', $id)->delete();

        return redirect()->back();
    }
}
