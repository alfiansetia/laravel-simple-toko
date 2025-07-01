<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role != Role::ADMIN->value) {
            return redirect()->route('fe.profile.index');
        } else {
            return redirect()->route('filament.admin.pages.dashboard');
        }
    }
}
