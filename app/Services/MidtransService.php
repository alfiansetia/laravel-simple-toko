<?php

namespace App\Services;

use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public static function createTransaction(Transaction $transaction)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        $orderId =  $transaction->code;
        $items = [];
        foreach ($transaction->items as $item) {
            $items[] = [
                'id'        => $item->product_id,
                'price'     => (int) $item->price,
                'quantity'  => (int) $item->qty,
                'name'      => substr($item->product->name, 0, 50),
            ];
        }
        $params = [
            'transaction_details' => [
                'order_id'      => $orderId,
                'gross_amount'  => $transaction->total,
            ],
            'customer_details'  => [
                'first_name'    => $transaction->user->name,
                'phone'         => $transaction->user->whatsapp,
                "notes"         => "Terima kasih sudah berbelanja, Silahkan ikuti panduan untuk melakukan pembayaran pesananan anda!."
            ],
            'item_details' => $items,
            'expiry' => [
                'unit'       => 'minute',
                'duration'   => 10,
            ],

        ];
        $midtrans = Snap::createTransaction($params);
        return $midtrans;
    }
}
