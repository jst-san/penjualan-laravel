<x-app>
    <div class="sticky z-100 left-0 top-20 flex justify-end bg-white border-b border-slate-200 p-2">
        <a href="/transaksi/create"
            class="px-5 py-2.5 bg-blue-500 text-white rounded hover:bg-blue-600 active:bg-blue-600 transition-colors">Buat
            Transaksi</a>
    </div>
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($transaksis as $t)
                <div class="w-full p-8 outline outline-offset-0 outline-slate-200">
                    <div class="">
                        <div class="flex-1">
                            <h5 class="text-2xl font-black">{{$t->nomor_transaksi}}</h5>
                            <h6 class="text-slate-500 mb-2">{{ $t->tanggal }}</h6>
                                <p class="text-slate-600 text-sm">Total: </p>
                                <p class="text-blue-500 text-xl">Rp{{ number_format($t->total, 2, ',', '.') }}</p>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <a href="/transaksi/{{$t->id}}" class="grid place-content-center w-full text-blue-500 border-1 border-blue-500 px-5 py-2.5 rounded hover:bg-blue-500 active:bg-blue-500 hover:text-white active:text-white transition-colors"
                                >Detail</a>
                             <form class="w-full" action="/api/transaksi/{{$t->id}}" method="POST">
                                 @method('delete')
                                 <button
                                     name="delete-barang"
                                     class="w-full text-red-500 border-1 border-red-500 px-5 py-2.5 rounded hover:bg-red-500 active:bg-red-500 hover:text-white active:text-white transition-colors">Hapus</button>
                             </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app>
