<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = auth()->user();
        $transactions = $user->transactions()->simplePaginate(5);
        return view('frontend.profile', compact([
            'user',
            'transactions'
        ]));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      => ['required', 'string', 'max:255'],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
            'whatsapp'  => ['required'],
        ]);
        $user = auth()->user();
        $param = [
            'name'      => $request->name,
            'whatsapp'  =>  $request->whatsapp,
        ];
        if ($request->filled('password')) {
            $param['password'] = Hash::make($request->password);
        }
        $user->update($param);
        return redirect()->back()->with('success', 'Profile updated!');
    }
}
