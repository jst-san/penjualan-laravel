<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $routes;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->routes = [new Route('Beranda', '/'), new Route('Barang', '/barang'), new Route('Transaksi', '/transaksi')];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}


class Route {
    public $label;
    public $href;

    public function __construct($label, $href) {
        $this->label = $label;
        $this->href = $href;
    }
}