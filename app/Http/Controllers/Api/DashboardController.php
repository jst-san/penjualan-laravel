<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        $barangs_count = DB::table('barangs')->count();
        $transaksis_count = DB::table('transaksis')->count();
        $transaksis_total = DB::table('transaksis')->sum('total');

        return response()->json(['data' => [
            'barangsCount' => $barangs_count,
            'transaksisCount' => $transaksis_count,
            'transaksisTotal' => $transaksis_total,
        ]]);
    }

    public function low_stocks()
    {
        $low_stocks = DB::table('barangs')->where('stok', '<=', 10)->get(['nama_barang', 'kode_barang', 'stok']);

        return response()->json(['data' => $low_stocks]);
    }

    public function today_transaksis()
    {
        $today_transaksis = DB::table("transaksis")->where('tanggal', date("Y-m-d"))->get();

        return response()->json(['data' => $today_transaksis]);
    }

    public function activity()
    {
        $activity = DB::table("transaksis")->selectRaw("DATE(created_at) as tanggal, COUNT(*) as jumlah")->limit(7)->groupBy(DB::raw('DATE(created_at)'))->orderBy("tanggal")->get();

        return response()->json(['data' => $activity]);
    }

    public function best_seller()
    {
        $best_seller = DB::table('detail_transaksis')
            ->join('barangs', 'detail_transaksis.barang_id', '=', 'barangs.id')
            ->select('barangs.nama_barang', DB::raw('SUM(detail_transaksis.jumlah) as total_jumlah'))
            ->groupBy('detail_transaksis.barang_id', 'barangs.nama_barang')
            ->orderByDesc('total_jumlah')
            ->limit(5)
            ->get();

        $grand_total = DB::table('detail_transaksis')->sum('jumlah');

        $data = $best_seller->map(fn($item) => [
            'name'  => $item->nama_barang,
            'value' => (int) $item->total_jumlah,
        ])->toArray();

        $total_best_seller = $best_seller->sum('total_jumlah');

        $data[] = [
            'name'  => 'Lainnya',
            'value' => (int) ($grand_total - $total_best_seller),
        ];

        return response()->json(['data' => $data]);}
}
