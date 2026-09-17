<?php

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;

new class extends Component {
    public $transaksi;
    
    public function mount($id) {
        $this->transaksi = Transaksi::with("detailTransaksis.barang")->find($id);
    }
};
?>

<div class="container p-8">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-bold mb-1">Detail Transaksi</h3>
        </div>
        <div>
            <a href="/transaksi" class="btn btn-outline-primary me-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="">
        <div class="">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title font-bold mb-0 text-primary">Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 flex flex-col">
                        <label class="text-muted">Nomor Transaksi</label>
                        <span class="font-bold text-2xl">{{ $transaksi->nomor_transaksi }}</span>
                    </div>

                    <div class="mb-3 flex flex-col">
                        <label class="text-muted">Tanggal Transaksi</label>
                        <span class="font-semibold">
                            {{$transaksi->tanggal}}
                        </span>
                    </div>

                    <div class="mb-3 flex flex-col">
                        <label class="text-muted">Jumlah Jenis Barang</label>
                        <span class="font-semibold">
                            {{ count($transaksi->detailTransaksis) }} Item
                        </span>
                    </div>

                    <hr class="my-3 border-light">

                    <div class="p-3 bg-light rounded-3">
                        <label class="text-muted small d-block mb-1">Total Pembayaran</label>
                        <h4 class="font-bold text-blue-500! mb-0">
                            Rp {{ number_format($transaksi->total, 2, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-bold mb-0">Daftar Item Barang</h5>
                    <span class="">
                        Jumlah total: {{ $transaksi->detailTransaksis->sum('jumlah') }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 w-[50px]">No</th>
                                    <th>Kode & Nama Barang</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi->detailTransaksis as $index => $detail)
                                    <tr>
                                        <td class="ps-3 font-semibold text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <span class="text-sm text-muted">
                                                {{ $detail->barang->kode_barang }}
                                            </span>
                                            <div class="font-bold text-dark">
                                                {{ $detail->barang->nama_barang }}
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-outline-primary text-dark border px-2 py-1">
                                                {{ $detail->jumlah }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3 font-bold text-dark">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Tidak ada item barang dalam transaksi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light border-top">
                                <tr>
                                    <td colspan="4" class="text-end font-bold py-3">Total:</td>
                                    <td class="text-end pe-3 font-bold text-blue-500! text-2xl py-3">
                                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>