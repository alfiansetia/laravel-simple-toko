<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function show(Transaction $transaction)
    {
        $data = $transaction->load(['items.product']);
        return view('frontend.transaction', compact([
            'data',
        ]));
    }

    public function download(Transaction $transaction)
    {
        if (!$transaction->isDone()) {
            return redirect()->route('fe.transaction.detail', $transaction->code)->with('error', 'Transaksi Belum Selesai!');
        }
        $data = $transaction->load(['items.product', 'user']);
        $file_name = $data->code . '_' . Str::random(8) . '.pdf';
        return Pdf::loadView('frontend.transaction_export', [
            'data' => $data,
        ])->download($file_name);
    }
}
