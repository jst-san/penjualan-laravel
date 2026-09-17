<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use App\Models\Barang;

new class extends Component {
    #[Validate('required|string|max:100')]
    public $nama_barang = '';
    #[Validate('required|string|max:20')]
    public $kode_barang = '';
    #[Validate('required|numeric|min:0')]
    public $harga = '';
    #[Validate('required|numeric|min:0')]
    public $stok = '';

    function resetForm()
    {
        $this->nama_barang = '';
        $this->kode_barang = '';
        $this->harga = '';
        $this->stok = '';
    }

    function close()
    {
        $this->dispatch('creating-closed');
        $this->reset();
    }

    function createBarang()
    {
        $this->validate();
        Barang::create([
            'nama_barang' => $this->nama_barang,
            'kode_barang' => $this->kode_barang,
            'harga' => $this->harga,
            'stok' => $this->stok,
        ]);
        $this->dispatch('creating-saved');
        $this->reset();
    }
};

?>

<div class="w-full px-8 py-4">
    <div class="flex flex-col gap-4">
        <div class="row g-4">
            <div class="col-sm-6">
                <div class="form-floating">
                    <input wire:model="nama_barang" type="text" class="form-control" id="nama_barang" placeholder="">
                    <label for="nama_barang">Nama Barang</label>
                </div>
            </div>
            <div class="col-sm">
                <div class="form-floating">
                    <input wire:model="kode_barang" type="text" class="form-control" id="kode_barang" placeholder="">
                    <label for="kode_barang">Kode Barang</label>
                </div>
            </div>
            <div class="col-sm">
                <div class="form-floating">
                    <input wire:model="harga" type="number" class="form-control" id="harga" placeholder="">
                    <label for="harga">Harga</label>
                </div>
            </div>
            <div class="col-sm">
                <div class="form-floating">
                    <input wire:model="stok" type="number" class="form-control" id="stok" placeholder="">
                    <label for="stok">Stok</label>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-4">

            <button class="btn btn-outline-primary" wire:click="close()">Tutup</button>
            <button class="btn btn-primary" wire:click="createBarang()">Simpan</button>
        </div>
    </div>
</div>
</div>
