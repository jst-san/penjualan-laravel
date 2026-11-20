<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransServices {
    function __construct() {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');     
        Config::$is3ds = config('services.midtrans.is3ds');

        $app_url = env('VITE_APP_URL');
        Config::$appendNotifUrl = "https://6d98phbp-8000.asse.devtunnels.ms/transaksi/status";
    }

    function useSnap(array $params) : string {
        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}