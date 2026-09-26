<x-app>
    <div class="p-8">
        <span class="text-slate-600 space-x-1">
            <a href="/barang" class="hover:text-blue-500 active:text-blue-500">Barang</a>
            <span>\</span>
            <span class="text-blue-500">Tambah</span>
        </span>
        <x-barang-form
            title="TAMBAH"
            action="/barang"
            session_name="barang-created" 
            button_name="create-barang" 
        />
    </div>
</x-app>
