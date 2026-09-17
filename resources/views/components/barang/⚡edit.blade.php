<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Computed;
use App\Models\Barang;

new class extends Component {
    #[Reactive]
    public $data;

    public $nama_barang = '';
    public $kode_barang = '';
    public $harga = '';
    public $stok = '';

    function setData($arg)
    {
        $this->data = $arg;
        $this->refresh();
    }

    #[On('editing-changed')]
    function refresh()
    {
        if ($this->data) {
            $this->nama_barang = $this->data['nama_barang'];
            $this->kode_barang = $this->data['kode_barang'];
            $this->harga = $this->data['harga'];
            $this->stok = $this->data['stok'];
        }
    }

    function close()
    {
        $this->dispatch('editing-closed');
        $this->nama_barang = '';
        $this->kode_barang = '';
        $this->harga = '';
        $this->stok = '';
    }

    function save()
    {
        Barang::where('id', $this->data['id'])->update([
            'nama_barang' => $this->nama_barang,
            'kode_barang' => $this->kode_barang,
            'harga' => $this->harga,
            'stok' => $this->stok,
        ]);
        $this->dispatch('editing-saved');
        $this->close();
    }
};

?>

<div>

    @if ($data)
        <div class="w-full px-8 py-4">
            <div class="flex flex-col gap-4">

                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="form-floating">
                            <input wire:model="nama_barang" type="text" class="form-control" id="nama_barang"
                                placeholder="{{ $data['nama_barang'] }}">
                            <label for="nama_barang">Nama Barang</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-floating">
                            <input wire:model="kode_barang" type="text" class="form-control" id="kode_barang"
                                placeholder="{{ $data['kode_barang'] }}">
                            <label for="kode_barang">Kode Barang</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-floating">
                            <input wire:model="harga" type="number" class="form-control" id="harga"
                                placeholder="{{ $data['harga'] }}">
                            <label for="harga">Harga</label>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-floating">
                            <input wire:model="stok" type="number" class="form-control" id="stok"
                                placeholder="{{ $data['stok'] }}">
                            <label for="stok">Stok</label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-4">

                    <button class="btn btn-outline-primary" wire:click="close()">Batal</button>
                    <button class="btn btn-primary" wire:click="save()">Simpan</button>
                </div>
            </div>
        </div>
</div>
@endif
</div>
