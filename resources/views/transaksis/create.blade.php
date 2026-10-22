@extends('layouts.app')

@section('title', 'Buat Transaksi')
@section('subtitle', 'Pilih barang dan jumlah untuk membuat transaksi baru')

@section('content')
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

    @if ($barangs->isEmpty())
        <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
            Tidak ada barang dengan stok tersedia. Silakan tambahkan stok barang terlebih dahulu.
        </div>
    @endif

    <form id="transaksi-form" method="POST" action="{{ route('transaksis.store') }}" class="space-y-6">
        @csrf

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="max-w-xs">
                <label for="tanggal" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Transaksi</label>
                <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900">Rincian Barang</h2>
                <button type="button" id="add-item"
                    class="inline-flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition hover:bg-blue-100"
                    @disabled($barangs->isEmpty())>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Item
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Barang</th>
                            <th class="px-5 py-3 text-right">Harga</th>
                            <th class="px-5 py-3 text-center">Jumlah</th>
                            <th class="px-5 py-3 text-right">Subtotal</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body"></tbody>
                </table>
            </div>

            <div class="flex items-center justify-end border-t border-slate-200 px-5 py-4">
                <div class="text-right">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Grand Total</p>
                    <p id="grand-total" class="text-xl font-bold text-slate-900">Rp 0</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('transaksis.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
            <button type="submit" @disabled($barangs->isEmpty())
                class="rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600 disabled:cursor-not-allowed disabled:opacity-50">
                Simpan Transaksi
            </button>
        </div>
    </form>

    <template id="item-row-template">
        <tr class="border-t border-slate-100">
            <td class="px-5 py-3">
                <select name="items[__INDEX__][barang_id]" class="item-select w-full min-w-[14rem] rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30" required>
                    <option value="">-- Pilih barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}" data-stok="{{ $barang->stok }}">{{ $barang->nama_barang }} ({{ $barang->kode_barang }}) &middot; sisa {{ $barang->stok }}</option>
                    @endforeach
                </select>
            </td>
            <td class="whitespace-nowrap px-5 py-3 text-right text-slate-600 price-cell">Rp 0</td>
            <td class="px-5 py-3 text-center">
                <input type="number" name="items[__INDEX__][jumlah]" value="1" min="1" required
                    class="qty-input mx-auto w-20 rounded-lg border border-slate-300 px-3 py-2 text-center text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
            </td>
            <td class="whitespace-nowrap px-5 py-3 text-right font-medium text-slate-900 subtotal-cell">Rp 0</td>
            <td class="px-5 py-3 text-right">
                <button type="button" class="remove-item inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-400 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600" aria-label="Hapus item">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </td>
        </tr>
    </template>
@endsection

@push('scripts')
    <script>
        (function () {
            const body = document.getElementById('items-body');
            const template = document.getElementById('item-row-template');
            const addButton = document.getElementById('add-item');
            const grandTotal = document.getElementById('grand-total');
            const oldItems = @json(old('items', []));
            let rowIndex = 0;

            const formatRupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value || 0);

            const updateGrandTotal = () => {
                let total = 0;

                body.querySelectorAll('tr').forEach((row) => {
                    const harga = Number(row.querySelector('.item-select').selectedOptions[0]?.dataset.harga || 0);
                    const jumlah = Number(row.querySelector('.qty-input').value || 0);
                    total += harga * jumlah;
                });

                grandTotal.textContent = formatRupiah(total);
            };

            const updateRow = (row) => {
                const harga = Number(row.querySelector('.item-select').selectedOptions[0]?.dataset.harga || 0);
                const jumlah = Number(row.querySelector('.qty-input').value || 0);

                row.querySelector('.price-cell').textContent = formatRupiah(harga);
                row.querySelector('.subtotal-cell').textContent = formatRupiah(harga * jumlah);

                updateGrandTotal();
            };

            const addRow = () => {
                const row = template.content.firstElementChild.cloneNode(true);
                row.innerHTML = row.innerHTML.replaceAll('__INDEX__', rowIndex++);
                body.appendChild(row);

                return row;
            };

            addButton?.addEventListener('click', () => {
                updateRow(addRow());
            });

            body.addEventListener('input', (event) => {
                const row = event.target.closest('tr');
                if (row) {
                    updateRow(row);
                }
            });

            body.addEventListener('change', (event) => {
                const row = event.target.closest('tr');
                if (row) {
                    updateRow(row);
                }
            });

            body.addEventListener('click', (event) => {
                if (event.target.closest('.remove-item')) {
                    event.target.closest('tr').remove();
                    updateGrandTotal();
                }
            });

            if (oldItems.length > 0) {
                oldItems.forEach((item) => {
                    const row = addRow();
                    row.querySelector('.item-select').value = item.barang_id ?? '';
                    row.querySelector('.qty-input').value = item.jumlah ?? 1;
                    updateRow(row);
                });
            } else {
                updateRow(addRow());
            }
        })();
    </script>
@endpush
