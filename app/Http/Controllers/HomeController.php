<?php

namespace App\Http\Controllers;

use App\Periodo;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $lstPeriodo = Periodo::where('estado', 'A')->get();
        return view('home', compact('lstPeriodo'));
    }
}
