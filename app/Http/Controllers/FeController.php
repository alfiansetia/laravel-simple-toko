<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['profile']);
    }


    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::query()
            ->with('category')
            ->where('is_available', 1)
            ->where('name', 'like', '%' . $request->search . '%')
            ->orderBy('category_id')
            ->get()
            ->groupBy('category_id');
        return view('frontend.index', compact([
            'categories',
            'products',
        ]));
    }

    public function profile()
    {
        $user = auth()->user();
        $transactions = $user->transactions;
        return view('frontend.profile', compact([
            'user',
            'transactions'
        ]));
    }


    public function transaction(Transaction $transaction)
    {
        $data = $transaction->load(['product', 'items']);
        return view('frontend.transaction', compact([
            'data',
        ]));
    }



    public function login()
    {
        return view('frontend.login');
    }
}
