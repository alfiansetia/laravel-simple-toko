<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FeController extends Controller
{

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
}
