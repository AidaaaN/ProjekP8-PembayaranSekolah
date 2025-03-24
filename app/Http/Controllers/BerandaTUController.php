<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaTUController extends Controller
{
    public function index()
    {
        return view('tu.beranda_index');
    }
}
