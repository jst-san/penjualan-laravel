<x-app>
    <div class="sticky z-100 left-0 top-20 flex justify-end bg-white border-b border-slate-200 p-2">
        <a href="/barang/create" class="px-5 py-2.5 bg-blue-500 text-white rounded hover:bg-blue-600 active:bg-blue-600 transition-colors">Tambah Barang</a>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($barangs as $b)
                <div class="w-full p-8 outline outline-offset-0 outline-slate-200/50">
                    <div>
                        <h5 class="text-2xl font-medium">{{ $b->nama_barang }}</h5>
                        <div class="text-slate-400 text-sm">{{ $b->kode_barang }}</div>
                        <div class="text-xl text-blue-500 font-medium">Rp{{ number_format($b->harga, 2, ',', '.') }}
                        </div>
                    </div>
                    <ul class="divide-y divide-slate-200">
                        <li class="text-sm text-slate-600 py-1">Stok: {{ $b->stok }}</li>
                        <li class="text-sm text-slate-600 py-1">Ditambahkan: {{ $b->created_at }}</li>
                        <li class="text-sm text-slate-600 py-1">Diperbarui: {{ $b->updated_at }}</li>
                    </ul>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <a href="/barang/{{$b->id}}/edit" class="grid place-content-center w-full text-blue-500 border-1 border-blue-500 px-5 py-2.5 rounded hover:bg-blue-500 active:bg-blue-500 hover:text-white active:text-white transition-colors"
                           >Edit</a>
                        <form class="w-full" action="/barang/{{$b->id}}" method="POST">
                            @method('delete')
                            <button
                                name="delete-barang"
                                class="w-full text-red-500 border-1 border-red-500 px-5 py-2.5 rounded hover:bg-red-500 active:bg-red-500 hover:text-white active:text-white transition-colors">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app>
