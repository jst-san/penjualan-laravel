@php($barang = $barang ?? null)

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

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="kode_barang" class="mb-1.5 block text-sm font-medium text-slate-700">Kode Barang</label>
                <input id="kode_barang" name="kode_barang" type="text" value="{{ old('kode_barang', $barang?->kode_barang) }}" maxlength="20" required
                    placeholder="BRG001"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>

            <div>
                <label for="nama_barang" class="mb-1.5 block text-sm font-medium text-slate-700">Nama Barang</label>
                <input id="nama_barang" name="nama_barang" type="text" value="{{ old('nama_barang', $barang?->nama_barang) }}" maxlength="100" required
                    placeholder="Mouse Wireless"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>

            <div>
                <label for="harga" class="mb-1.5 block text-sm font-medium text-slate-700">Harga (Rp)</label>
                <input id="harga" name="harga" type="number" min="0" step="1" value="{{ old('harga', $barang?->harga) }}" required
                    placeholder="75000"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>

            <div>
                <label for="stok" class="mb-1.5 block text-sm font-medium text-slate-700">Stok</label>
                <input id="stok" name="stok" type="number" min="0" step="1" value="{{ old('stok', $barang?->stok) }}" required
                    placeholder="20"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('barangs.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
        <button type="submit" class="rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600">{{ $submitLabel }}</button>
    </div>
</form>
