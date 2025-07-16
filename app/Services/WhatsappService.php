<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

    public static function sendNotifOrderDoneToUser(Transaction $trx)
    {
        $message = static::messageTrxSuccess($trx);
        return static::sendMessage($trx->user->whatsapp, $message);
    }

    public static function messageTrx(Transaction $trx)
    {
        $trx->refresh();
        $trx->load('items');
        $message = '';
        $message .= config('app.name') . "\n";
        $message .= config('services.company_address') . "\n";
        $message .= config('services.whatsapp_admin') . "\n";
        $message .= "===================\n";
        $message .= "Data Pesanan!\n";
        $message .= 'Pemesan : ' . $trx->user->name . '/' . $trx->user->whatsapp . "\n";
        $message .= 'Waktu : ' . $trx->date . "\n";
        $message .= 'No Order : ' . $trx->code . "\n";
        $message .= 'Total : ' . hrg($trx->total) . "\n";
        $message .= 'Status : ' . $trx->status->value . "\n";
        $message .= "===================\n";
        $message .= "Item (" . $trx->items->count() . ") : \n";
        foreach ($trx->items as $key => $item) {
            $message .= "(" . $item->qty . "x) " . ($item->product->name ?? '-') . "\n";
        }
        $message .= "===================\n";
        if ($trx->isPending()) {
            $message .= "Link Pembayaran : " . $trx->payment_url . " \n";
        }
        $message .= "\n\n___Terima Kasih___\n";
        return $message;
    }

    public static function messageTrxSuccess(Transaction $trx)
    {
        $trx->refresh();
        $trx->load('items');
        $message = '';
        $message .= config('app.name') . "\n";
        $message .= config('services.company_address') . "\n";
        $message .= config('services.whatsapp_admin') . "\n";
        $message .= "===================\n";
        $message .= "Data Pesanan!\n";
        $message .= 'Pemesan : ' . $trx->user->name . '/' . $trx->user->whatsapp . "\n";
        $message .= 'Waktu : ' . $trx->date . "\n";
        $message .= 'No Order : ' . $trx->code . "\n";
        $message .= 'Total : ' . hrg($trx->total) . "\n";
        $message .= 'Status : ' . $trx->status->value . "\n";
        $message .= "===================\n";
        if ($trx->isDone()) {
            $message .= "Pembayaran telah kami terima, silahkan konfirmasi ke admin untuk mengambil pesanan!\n";
        } else {
            $message .= "Pesanan telah dibatalkan otomatis oleh sistem!, silahkan buat pesanan baru!\n";
        }
        $message .= "===================\n";
        $message .= "\n\n___Terima Kasih___\n";
        return $message;
    }
}
