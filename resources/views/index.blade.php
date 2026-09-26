<x-app>
    <div class="px-8">
    <div class="max-w-7xl mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            <div class="w-full h-48 p-8 bg-blue-400 shadow-md rounded-md border border-blue-200 flex flex-col justify-between relative overflow-hidden">
                <p class="text-white text-shadow-slate-200 text-5xl font-black">{{$barang_count}}</p>
                <p class="text-lg font-semibold text-slate-100">Barang tersimpan</p>
                <div class="absolute w-48 h-48 bg-white/50 rounded-full bottom-0 right-0 translate-1/2"></div>
                <div class="absolute w-48 h-48 bg-white/50 rounded-full bottom-0 right-0 translate-y-2/3"></div>
            </div>
            <div class="w-full h-48 p-8 bg-blue-400 shadow-md rounded-md border border-blue-200 flex flex-col justify-between relative overflow-hidden">
                <p class="text-white text-shadow-slate-200 text-5xl font-black">{{$transaksi_count}}</p>
                <p class="text-lg font-semibold text-slate-100">Jumlah Transaksi</p>
                <div class="absolute w-48 h-48 bg-white/50 rounded-full bottom-0 right-0 translate-1/2"></div>
                <div class="absolute w-48 h-48 bg-white/50 rounded-full bottom-0 right-0 translate-y-2/3"></div>
            </div>
            <div class="w-full h-48 p-8 bg-blue-400 shadow-md rounded-md border border-blue-200 flex flex-col justify-between relative overflow-hidden">
                <p class="text-white text-shadow-slate-200 text-3xl font-black">Rp{{number_format($transaksi_total, 2, ',', '.')}}</p>
                <p class="text-lg font-semibold text-slate-100">Total Nominal</p>
                <div class="absolute w-48 h-48 bg-white/50 rounded-full bottom-0 right-0 translate-1/2"></div>
                <div class="absolute w-48 h-48 bg-white/50 rounded-full bottom-0 right-0 translate-y-2/3"></div>
            </div>
        </div>
    </div>
    </div>
</x-app>