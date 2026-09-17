<?php

use Livewire\Component;
use App\Models\Transaksi;

new class extends Component {
    public $transaksis;

    public function mount() {
        $this->transaksis = Transaksi::all();
    }
};
?>

<div class="container p-8">
    <div class="flex justify-end">
        <a class="btn btn-primary" href="/transaksi/create">Buat Transaksi</a>
    </div>
    <div class="grid grid-cols-4 gap-8">
        @foreach ($transaksis as $t)
            <div class="card w-full">
                <div class="card-body">
                    <h5 class="card-title">Transaksi #{{$t->nomor_transaksi}}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">{{$t->tanggal}}</h6>
                    <p class="card-text">Rp{{number_format($t->total, 2, ',', '.')}}</p>
                    <a href="/transaksi/{{$t->id}}" class="card-link">Detail Transaksi</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
