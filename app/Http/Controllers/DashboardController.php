<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(Request $request): View
    {
        $barangsCount = Barang::count();
        $transaksisCount = Transaksi::count();
        $transaksisTotal = Transaksi::sum('total');
        $todayTransaksisCount = Transaksi::whereDate('tanggal', today())->count();

        $lowStocks = Barang::where('stok', '<=', 10)
            ->orderBy('stok')
            ->limit(5)
            ->get();

        $recentTransaksis = Transaksi::withCount('detailTransaksis')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $usersCount = $request->user()->isSuperadmin() ? User::count() : null;

        return view('dashboard', compact(
            'barangsCount',
            'transaksisCount',
            'transaksisTotal',
            'todayTransaksisCount',
            'lowStocks',
            'recentTransaksis',
            'usersCount',
        ));
    }
}
