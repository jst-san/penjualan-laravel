<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboardData() {
        $barangs_count = DB::table('barangs')->count();
        $transaksis_count = DB::table('transaksis')->count();
        $transaksis_total = DB::table('transaksis')->sum('total');
        $today_transaksis = DB::table('transaksis')->where('tanggal', date('Y-m-d'))->get();


        return response()->json(['success' => true, 'data' => ['barangsCount' => $barangs_count, 'transaksisCount' => $transaksis_count, 'transaksisTotal' => $transaksis_total, 'todayTransaksis' => $today_transaksis]], 200);
    }
}
