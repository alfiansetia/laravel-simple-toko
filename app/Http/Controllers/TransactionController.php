<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

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
        return $transaction;
        $data = $transaction->load(['items.product']);
        return view('frontend.transaction', compact([
            'data',
        ]));
    }
}
