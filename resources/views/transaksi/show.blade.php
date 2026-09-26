<x-app>
    <div class="max-w-7xl mx-auto py-8">
        <span class="text-slate-600 space-x-1 px-8">
            <a href="/transaksi" class="hover:text-blue-500 active:text-blue-500">Transaksi</a>
            <span>\</span>
            <span class="text-blue-500">Detail</span>
        </span>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-[20rem_auto]">
            <div class="p-8 space-y-4 border border-slate-200">
                <div class="border-b border-b-slate-200 text-blue-500 font-medium pb-8 text-center">
                    DETAIL TRANSAKSI
                </div>
                <div>
                    <p class="text-slate-700">Nomor Transaksi</p>
                    <p>TRX-001</p>
                </div>
                <div>
                    <p class="text-slate-700">Tanggal Transaksi</p>
                    <p>{{ $transaksi->tanggal }}</p>
                </div>
                <div>
                    <p class="text-slate-700">Jenis Barang</p>
                    <p>{{ count($transaksi->detailTransaksis) }}</p>
                </div>
                <div class="bg-slate-100 p-4 rounded-md">
                    <p class="text-slate-700">Total Pembayaran</p>
                    <p class="text-2xl text-blue-500">Rp{{ number_format($transaksi->total, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="p-8 space-y-4 border border-slate-200 border-t-0 md:border-t md:border-l-0">
                <div class="border-b border-b-slate-200 text-blue-500 font-medium pb-8 text-center">
                    RINCIAN
                </div>
                <div class="overflow-x-auto">
                    <table class="w-max min-w-full table-auto">
                        <thead class="border border-slate-300">
                            <tr class="bg-slate-100 text-center">
                                <th class="py-4 px-2 font-bold">No</th>
                                <th class="py-4 px-2 font-bold">Barang</th>
                                <th class="py-4 px-2 font-bold">Harga Satuan</th>
                                <th class="py-4 px-2 font-bold">Jumlah</th>
                                <th class="py-4 px-2 font-bold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="border border-slate-300 border-t-0 divide-y divide-slate-300">
                            @foreach ($transaksi->detailTransaksis as $idx => $dt)
                                <tr class="">
                                    <td class="py-4 px-2 text-center">{{ $idx + 1 }}</td>
                                    <td class="py-4 px-2">
                                        <span class="text-slate-600 text-xs">
                                            {{ $dt->barang->kode_barang }}
                                        </span>
                                        {{ $dt->barang->nama_barang }}
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        Rp{{number_format($dt->barang->harga, 2, ',', '.')}}
                                    </td>
                                    <td class="py-4 px-2 text-center">{{$dt->jumlah}}</td>
                                    <td class="py-4 px-2 text-right">Rp{{number_format($dt->harga, 2, ',', '.')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border border-t-0 border-slate-300">
                            <tr>
                                <td class="py-4 px-2"></td>
                                <td class="py-4 px-2 font-bold text-blue-500">Total</td>
                                <td class="py-4 px-2"></td>
                                <td class="py-4 px-2"></td>
                                <td class="py-4 px-2 text-right font-medium text-blue-500">Rp{{number_format($transaksi->total, 2, ',', '.')}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app>
