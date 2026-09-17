<?php

use Livewire\Component;
use App\Models\Barang;
use Livewire\Attributes\On;

new class extends Component {
    public $action = null;
    public $barangs;
    public $editing = null;

    function mount()
    {
        $this->barangs = Barang::all();
    }

    function setEditing(Barang $arg)
    {
        $this->editing = $arg;
        if ($arg) {
            $this->action = 'edit';
        }
        $this->dispatch('editing-changed');
    }

    #[On('editing-closed')]
    function cancelEditing()
    {
        $this->action = null;
        $this->editing = null;
    }

    #[On('creating-closed')]
    function cancelCreating()
    {
        $this->action = null;
    }

    #[On('creating-saved')]
    #[On('editing-saved')]
    function refreshBarang()
    {
        $this->barangs = Barang::all();
    }

    function deleteBarang(Barang $arg)
    {
        $arg->delete();
        $this->barangs = Barang::all();
    }
};
?>

<div class="container p-8">
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
    @if ($action == 'create')
        <livewire:barang.create />
    @elseif($action == 'edit' && $editing)
        <livewire:barang.edit :data="$editing" />
    @else
        <div class="flex justify-end mb-8">
            <button class="btn btn-primary" wire:click="$set('action', 'create')">Tambah Barang</button>
        </div>
    @endif
    <div class="grid grid-cols-3 gap-8">
        @foreach ($barangs as $b)
            <div class="card w-full">
                <img src="" class="card-img-top w-full aspect-4/3 bg-slate-200" alt="">
                <div class="card-body">
                    <h5 class="card-title">{{ $b->nama_barang }}</h5>
                    <p class="card-text text-slate-400 text-sm">{{ $b->kode_barang }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Harga: Rp{{ number_format($b->harga, 2, ',', '.') }}</li>
                    <li class="list-group-item">Stok: {{ $b->stok }}</li>
                    <li class="list-group-item">Ditambahkan: {{ $b->created_at }}</li>
                    <li class="list-group-item">Diperbarui: {{ $b->updated_at }}</li>
                </ul>
                <div class="card-body flex gap-4">
                    <button wire:click="setEditing({{ $b }})" class="btn btn-outline-primary flex-1"
                        onclick="scrollToTop()">Edit</button>
                    <button wire:click="deleteBarang({{ $b }})"
                        class="btn btn-outline-danger flex-1">Hapus</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
