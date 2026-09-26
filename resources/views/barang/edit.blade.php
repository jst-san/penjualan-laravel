<x-app>
    <div class="p-8">
        <span class="text-slate-600 space-x-1">
            <a href="/barang" class="hover:text-blue-500 active:text-blue-500">Barang</a>
            <span>\</span>
            <span class="text-blue-500">Edit</span>
        </span>
        <x-barang-form 
            title="EDIT" 
            action="/barang/{{$barang->id}}"
            method="PUT" 
            session_name="barang-edited" 
            button_name="edit-barang" 
            nama_barang="{{$barang->nama_barang}}" 
            kode_barang="{{$barang->kode_barang}}" 
            harga="{{$barang->harga}}" 
            stok="{{$barang->stok}}" 
        />
    </div>
</x-app>