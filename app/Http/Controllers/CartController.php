<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::query()
            ->with('product.category')
            ->where('user_id', auth()->id())
            ->get();
        return view('frontend.cart', compact('carts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id'
        ]);
        $oncart = Cart::where('product_id', $request->product_id)->first();
        if ($oncart) {
            $cart = $oncart->update([
                'user_id'       => auth()->id(),
                'product_id'    => $request->product_id,
                'qty'           => $oncart->qty + 1
            ]);
        } else {
            $cart = Cart::create([
                'user_id'       => auth()->id(),
                'product_id'    => $request->product_id,
                'qty'           => 1
            ]);
        }
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message'   => 'Berhasil Tambah ke keranjang!',
                'data'      => $cart,
            ]);
        }
        return redirect()->back()->with('success', 'Berhasil Tambah ke keranjang!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Berhasil Hapus dari keranjang!');
    }

    public function checkout()
    {
        // 
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $oncart = $user->carts;
            if ($user->carts()->count() > 0) {
                $total = 0;
                foreach ($oncart as $key => $item) {
                    $total += ($item->qty * $item->product->price);
                }
                $trx = Transaction::create([
                    'code'      => strtoupper(Str::random(8)),
                    'date'      => date('Y-m-d H:i:s'),
                    'user_id'   => $user->id,
                    'total'     => $total,
                    'status'    => TransactionStatus::PENDING,
                ]);

                foreach ($oncart as $key => $item) {
                    TransactionDetail::create([
                        'transaction_id'    => $trx->id,
                        'product_id'        => $item->product_id,
                        'price'             => $item->product->price,
                        'qty'               => $item->qty,
                    ]);
                }
                $midtrans = MidtransService::createTransaction($trx);
                $trx->update([
                    'payment_url' => $midtrans->redirect_url,
                ]);
                // $trx->sendNotifOrderToAdmin();
                $trx->sendNotifOrderToUser();
                $user->carts()->delete();
                DB::commit();
                return redirect()->route('fe.transaction.detail', $trx->code)->with('success', 'Berhasil Membuat Order!');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Keranjang Kosong!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erorr : ' . $th->getMessage());
        }
    }

    public function plus(Cart $cart)
    {
        $cart->update([
            'qty' => $cart->qty + 1
        ]);
        return redirect()->back()->with('success', 'Berhasil diubah !');
    }

    public function min(Cart $cart)
    {
        if ($cart->qty < 2) {
            return redirect()->back()->with('success', 'Keranjang hanya ada 1 !');
        }
        $cart->update([
            'qty' => $cart->qty - 1
        ]);
        return redirect()->back()->with('success', 'Berhasil diubah !');
    }
}
