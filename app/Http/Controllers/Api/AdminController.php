<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboardData()
    {
        $barangs_count = DB::table('barangs')->count();
        $transaksis_count = DB::table('transaksis')->count();
        $transaksis_total = DB::table('transaksis')->sum('total');
        $today_transaksis = DB::table('transaksis')->where('tanggal', date('Y-m-d'))->get();
        $low_stocks = DB::table('barangs')->where('stok', '<=', 10)->get(['nama_barang','kode_barang', 'stok']);
        $activity = DB::table("transaksis")->selectRaw("DATE(created_at) as tanggal, COUNT(*) as jumlah")->limit(7)->groupBy(DB::raw('DATE(created_at)'))->orderBy("tanggal")->get();

        return response()->json(['data' => [
            'barangsCount' => $barangs_count,
            'transaksisCount' => $transaksis_count,
            'transaksisTotal' => $transaksis_total,
            'todayTransaksis' => $today_transaksis,
            'lowStocks' => $low_stocks,
            'activity' => $activity
        ]], 200);
    }
}
