<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->except('callback');
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

    public function callback(Request $request)
    {
        DB::beginTransaction();
        try {
            $serverKey = config('midtrans.server_key');

            $signatureKey = hash(
                'sha512',
                $request->order_id .
                    $request->status_code .
                    $request->gross_amount .
                    $serverKey
            );

            if ($signatureKey !== $request->signature_key) {
                DB::rollBack();
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Cari transaksi berdasarkan order_id
            $transaction = Transaction::where('code', $request->order_id)->first();

            if (!$transaction) {
                DB::rollBack();
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Status dari Midtrans
            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status;

            // Update berdasarkan status midtrans
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $transaction->status = TransactionStatus::PENDING->value;
                } elseif ($fraudStatus == 'accept') {
                    $transaction->status = TransactionStatus::DONE->value;
                }
            } elseif ($transactionStatus == 'settlement') {
                $transaction->status = TransactionStatus::DONE->value;
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $transaction->status = TransactionStatus::CANCEL->value;
            } elseif ($transactionStatus == 'pending') {
                $transaction->status = TransactionStatus::PENDING->value;
            }

            $transaction->save();
            $transaction->sendNotifOrderDoneToUSer();

            DB::commit();

            return response()->json(['message' => 'Callback processed']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Server Error : ' . $th->getMessage()]);
        }
    }
}
