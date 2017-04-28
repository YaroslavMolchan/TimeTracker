<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function index()
    {
        if (\Auth::check() && request()->ip() == '91.224.97.5') {
            dd(1);
        }
        else {
            return view('main.index');
        }
    }
}
