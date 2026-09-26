@props([
    'title',
    'action',
    'method' => 'POST',
    'session_name',
    'button_name',
    'nama_barang' => '',
    'kode_barang' => '',
    'harga' => '',
    'stok' => '',
])

<div>
    <form action="{{ $action }}" method="POST" class="py-12 max-w-md mx-auto grid grid-cols-2 gap-8">
        @csrf
        @method($method)
        @if (session()->has($session_name))
            <div class="col-span-2 w-full p-4 bg-blue-200 text-slate-600">{{ session($session_name) }}</div>
        @endif
        <div class="w-max col-span-2">
            <h2 class="text-xl font-medium text-blue-500">{{ $title }}</h2>
        </div>
        <div class="relative col-span-2">
            <label for="nama_barang" class="">Nama</label>
            <input id="nama_barang" name="nama_barang" value="{{ $nama_barang }}"
                class="peer w-full py-3 mt-2 focus-within:outline-none focus-within:bg-slate-100/70 duration-300"
                placeholder="Nama barang" />
            <hr class="absolute w-full bottom-0 border-slate-300" />
            <hr class="absolute bottom-0 w-0 border-blue-500 peer-focus-within:w-full duration-300" />
            @error('nama_barang')
                <span class="absolute top-full left-0 translate-y-1 text-slate-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="relative col-span-2">
            <label for="kode_barang" class="">Kode</label>
            <input id="kode_barang" name="kode_barang" value="{{ $kode_barang }}"
                class="peer w-full py-3 mt-2 focus-within:outline-none focus-within:bg-slate-100/70 duration-300"
                placeholder="BRGXXX" />
            <hr class="absolute w-full bottom-0 border-slate-300" />
            <hr class="absolute bottom-0 w-0 border-blue-500 peer-focus-within:w-full duration-300" />
            @error('kode_barang')
                <span class="absolute top-full left-0 translate-y-1 text-slate-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="relative">
            <label for="harga" class="">Harga</label>
            <input id="harga" name="harga" value="{{ $harga }}"
                class="peer w-full py-3 mt-2 focus-within:outline-none focus-within:bg-slate-100/70 duration-300"
                placeholder="Harga barang" />
            <hr class="absolute w-full bottom-0 border-slate-300" />
            <hr class="absolute bottom-0 w-0 border-blue-500 peer-focus-within:w-full duration-300" />
            @error('harga')
                <span class="absolute top-full left-0 translate-y-1 text-slate-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="relative">
            <label for="stok" class="">Stok</label>
            <input id="stok" name="stok" value="{{ $stok }}"
                class="peer w-full py-3 mt-2 focus-within:outline-none focus-within:bg-slate-100/70 duration-300"
                placeholder="Stok barang" />
            <hr class="absolute w-full bottom-0 border-slate-300" />
            <hr class="absolute bottom-0 w-0 border-blue-500 peer-focus-within:w-full duration-300" />
            @error('stok')
                <span class="absolute top-full left-0 translate-y-1 text-slate-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" name="{{ $button_name }}"
            class="mt-6 col-span-2 w-full px-5 py-2.5 bg-blue-500 text-white rounded hover:bg-blue-600 active:bg-blue-600">Simpan</button>
    </form>

    <iframe id="hidden_iframe" name="hidden_iframe" class="hidden"></iframe>
</div>
