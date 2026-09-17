<?php

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use Livewire\Attributes\On;
use Livewire\Atrributes\Computed;

new class extends Component {
    public $transaksiNumber;
    public $transaksiDate;
    public $barangs;

    public $isSelectingBarang = false;
    public $selectedBarangs = [];

    public $totalHarga = 0;
    public $totalAmount = 0;

    #[On('selected-changed')]
    #[Computed]
    public function calculate()
    {
        $this->totalHarga = array_reduce($this->selectedBarangs, fn($a, $c) => $a + $c['subtotal'], 0);
        $this->totalAmount = array_reduce($this->selectedBarangs, fn($a, $c) => $a + $c['amount'], 0);
    }

    public function mount()
    {
        $this->transaksiNumber = Transaksi::count() + 1;
        $this->transaksiDate = date('Y-m-d');
        $this->barangs = Barang::all();
    }

    public function increase($id)
    {
        $barang = $this->barangs->find($id);
        $isExist = isset($this->selectedBarangs[$id]);

        if ($barang->stok - ($isExist ? $this->selectedBarangs[$id]['amount'] : 0) <= 0) {
            return;
        }

        if ($isExist) {
            $this->selectedBarangs[$id]['amount'] += 1;
            $this->selectedBarangs[$id]['subtotal'] += $barang->harga;
        } else {
            $this->selectedBarangs[$id] = ['amount' => 1, 'subtotal' => $barang->harga];
        }
        $this->totalHarga += $barang->harga;
        $this->dispatch('selected-changed');
    }

    public function decrease($id)
    {
        $barang = $this->barangs->find($id);
        $isExist = isset($this->selectedBarangs[$id]);

        if (!$isExist) {
            return;
        }

        if ($this->selectedBarangs[$id]['amount'] - 1 > 0) {
            $this->selectedBarangs[$id]['amount'] -= 1;
            $this->selectedBarangs[$id]['subtotal'] -= $barang->harga;
        } else {
            unset($this->selectedBarangs[$id]);
        }

        $this->totalHarga -= $barang->harga;
        $this->dispatch('selected-changed');
    }

    public function saveTransaction()
    {
        $isError = false;
        $sbs = $this->selectedBarangs;

        if (empty($sbs)) {
            $this->addError('selectedBarangs', 'Keranjang belanja masih kosong.');
            return;
        }

        foreach ($sbs as $id => $value) {
            $barang = Barang::find($id);

            if (!$barang || $barang->stok < $value['amount']) {
                $this->addError($id, 'Stok ini telah diperbarui, mohon periksa kembali.');
                $isError = true;
            }
        }

        if ($isError) {
            $this->barangs = Barang::all();
            return;
        }

        DB::transaction(function () use ($sbs) {
            $transaksi = Transaksi::create([
                'nomor_transaksi' => $this->transaksiNumber,
                'tanggal' => $this->transaksiDate,
                'total' => $this->totalHarga,
            ]);

            foreach ($sbs as $id => $value) {
                $barang = Barang::find($id);

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $id,
                    'harga' => $barang->harga,
                    'jumlah' => $value['amount'],
                    'subtotal' => $value['subtotal'],
                ]);

                $barang->decrement('stok', $value['amount']);
            }
        });

        session()->flash('transaction-saved', 'Transaksi berhasil dibuat');

        $this->selectedBarangs = [];
        $this->totalHarga = 0;
        $this->totalAmount = 0;
        $this->transaksiNumber = Transaksi::count() + 1;
        $this->barangs = Barang::all();
    }
};
?>

<div class="container p-8">
    @if ($isSelectingBarang)
        <div class="flex justify-end">
            <button class="btn btn-outline-primary"
                wire:click="$set('isSelectingBarang', false)">Kembali</button>
        </div>
        <div class="flex flex-col gap-8 mt-8">
            @foreach ($barangs as $b)
                <div
                    class="{{ $selectedBarangs[$b->id] ?? 0 ? 'outline-2 outline-blue-500' : '' }} card w-full flex flex-row!">
                    <img src="" class="card-img-top w-32! aspect-square bg-slate-200" alt="">
                    <div class="card-body">
                        <h5 class="card-title">{{ $b->nama_barang }}</h5>
                        <p class="card-text text-slate-400 text-sm">{{ $b->kode_barang }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="">Harga satuan: Rp{{ number_format($b->harga, 2, ',', '.') }}</li>
                        </ul>
                    </div>
                    <div class="p-2 flex flex-col items-end">
                        <p class="mb-2 text-sm">Stok: {{ $b->stok - ($selectedBarangs[$b->id]['amount'] ?? 0) }}</p>
                        <div class="flex p-1 rounded bg-white border border-slate-100">
                            <button class="btn btn-primary rounded!" wire:loading.attr="disabled"
                                wire:target="selectedBarangs" wire:click="decrease({{ $b->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                    class="bi bi-dash" viewBox="0 0 `6 16">
                                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                </svg>
                            </button>
                            <div class="pt-1 h-full w-8 grid place-content-center">
                                {{ $selectedBarangs[$b->id]['amount'] ?? 0 }}
                            </div>
                            <button class="btn btn-primary rounded!" wire:loading.attr="disabled"
                                wire:target="selectedBarangs" wire:click="increase({{ $b->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                    class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                            </button>
                        </div>
                        @if ($selectedBarangs[$b->id] ?? 0 > 0)
                            <p class="mt-2">Subtotal:
                                Rp{{ number_format($selectedBarangs[$b->id]['subtotal'], 2, ',', '.') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="sticky bottom-8 mt-4 w-full h-32 bg-white rounded-xl shadow border border-slate-100">
            @if (count($selectedBarangs) > 0)
                <div class="flex justify-between items-center gap-16 h-full px-8">
                    <div>
                        <h2 class="text-lg font-bold">{{ $totalAmount }} Total Barang Terpilih</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($barangs as $b)
                                @if ($selectedBarangs[$b->id] ?? 0 > 0)
                                    <div
                                        class="text-sm w-max px-2 bg-blue-100 border-1 border-blue-500 text-blue-500 rounded-full">
                                        {{ $b->nama_barang }} x {{ $selectedBarangs[$b->id]['amount'] }}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-max flex flex-col items-end">
                        <p class="text-xl">Total: Rp{{ number_format($totalHarga, 2, ',', '.') }}</p>
                        <button class="btn btn-primary" wire:click="$set('isSelectingBarang', false)">Selesai</button>
                    </div>
                </div>
            @else
                <div class="flex justify-center items-center h-full px-8">
                    <p>Belum ada barang yang dipilih</p>
                </div>
            @endif
        </div>
    @else
        @error('selectedBarangs')
            <div class="alert alert-warning">{{ $message }}</div>
        @enderror
        @if (session()->has('transaction-saved'))
            <div class="alert alert-primary">{{ session('transaction-saved') }}</div>
        @endif
        <div class="flex justify-between">
            <div>
                <h2>Transaksi #{{ $transaksiNumber }}</h2>
                <p>{{ $transaksiDate }}</p>
            </div>
            <div class="">
                <a href="/transaksi" class="btn btn-outline-primary">
                    Kembali
                </a>
            </div>
        </div>
        <div class="mt-4">
            <h3>Barang yang dipilih:</h3>
            @if (count($selectedBarangs) > 0)
                <ul class="list-group list-group-flush gap-4">
                    @foreach ($selectedBarangs as $id => $value)
                        <?php
                        $b = $barangs->find($id);
                        ?>
                        <li class="list-group-item">
                            @error($b->id)
                                <p class="alert alert-warning">{{ $message }}</p>
                            @enderror
                            <div class="flex! justify-between items-center">
                                <div>
                                    <div class="text-lg">
                                        {{ $b->nama_barang }} - {{ $b->kode_barang }}
                                    </div>
                                    <div class="">Jumlah: {{ $value['amount'] }}</div>
                                </div>
                                <div class="text-xl">
                                    Rp{{ number_format($value['subtotal'], 2, ',', '.') }}</div>
                            </div>
                        </li>
                    @endforeach
                    <li class="list-group-item flex! justify-between items-center">
                        <div class="text-xl">Total: </div>
                        <div class="text-xl text-blue-500">
                            Rp{{ number_format($totalHarga, 2, ',', '.') }}
                        </div>
                    </li>
                </ul>
            @else
                <p>Belum ada barang yang dipilih.</p>
            @endif
        </div>
        <div class="mt-4 flex justify-between">
            <button class="btn btn-primary" wire:click="$set('isSelectingBarang', true)">Pilih Barang</button>
            <button class="btn btn-primary" wire:click="saveTransaction">Simpan Transaksi</button>
        </div>
    @endif
</div>
