<?php

use Livewire\Component;

new class extends Component {
    
};
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-white! sticky! top-0 z-999">
    <div class="container-fluid">
        <a class="navbar-brand bg-gradient-to-tr from-blue-500 to-sky-500 bg-clip-text text-transparent! font-bold" href="/">RPL JAYA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse justify-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/barang">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/transaksi">Transaksi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
