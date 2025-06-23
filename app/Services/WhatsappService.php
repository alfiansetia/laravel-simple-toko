<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class WhatsappService
{
    public function __construct() {}

    public static function getToken()
    {
        return config('services.whatsapp_token');;
    }

    public static function sendMessage($target, $message)
    {
        $token = static::getToken();
        $req = Http::withHeaders([
            'Authorization' => $token,
            'accept' => 'application/json',
        ])->post('https://api.fonnte.com/send', [
            'message'   => $message,
            'target'    => $target,
        ]);
        return $req->json();
    }

    public static function sendNotifOrderToAdmin(Transaction $trx)
    {
        $admin = config('services.whatsapp_admin');
        $message = static::messageTrx($trx);
        return static::sendMessage($admin, $message);
    }

    public static function sendNotifOrderToUser(Transaction $trx)
    {
        $message = static::messageTrx($trx);
        return static::sendMessage($trx->user->whatsapp, $message);
    }

    public static function messageTrx(Transaction $trx)
    {
        $message = '';
        $message .= config('app.name') . ' \n';
        $message .= config('services.company_address') . ' \n';
        $message .= 'Data Pesanan! \n';
        $message .= 'Pemesan : ' . $trx->user->name . '/' . $trx->user->email . '/' . $trx->user->whatsapp . ' \n';
        $message .= 'Waktu : ' . $trx->date . ' \n';
        $message .= 'No Order : ' . $trx->code . ' \n';
        $message .= 'Total : ' . $trx->total . ' \n';
        $message .= 'Status : ' . $trx->status . ' \n';
        return $message;
    }
}
