<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BarangController extends Controller
{
    /**
     * Display a listing of the barangs.
     */
    public function index(Request $request): View
    {
        $barangs = Barang::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');

                $query->where(function ($query) use ($search) {
                    $query->where('nama_barang', 'like', "%{$search}%")
                        ->orWhere('kode_barang', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('barangs.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new barang.
     */
    public function create(): View
    {
        return view('barangs.create');
    }

    /**
     * Store a newly created barang in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:20', 'unique:barangs,kode_barang'],
            'nama_barang' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $barang = Barang::create($validated);

        return redirect()
            ->route('barangs.index')
            ->with('success', "Barang {$barang->nama_barang} berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified barang.
     */
    public function edit(Barang $barang): View
    {
        return view('barangs.edit', compact('barang'));
    }

    /**
     * Update the specified barang in storage.
     */
    public function update(Request $request, Barang $barang): RedirectResponse
    {
        $validated = $request->validate([
            'kode_barang' => ['required', 'string', 'max:20', Rule::unique('barangs', 'kode_barang')->ignore($barang->id)],
            'nama_barang' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $barang->update($validated);

        return redirect()
            ->route('barangs.index')
            ->with('success', "Barang {$barang->nama_barang} berhasil diperbarui.");
    }

    /**
     * Remove the specified barang from storage.
     */
    public function destroy(Barang $barang): RedirectResponse
    {
        $barang->delete();

        return redirect()
            ->route('barangs.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
