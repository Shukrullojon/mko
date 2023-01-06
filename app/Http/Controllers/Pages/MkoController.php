<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Card;
use Illuminate\Http\Request;

class MkoController extends Controller
{
    public function index(){
        $mko = Card::where('type', 3)->first();
        return view('pages.mko.index', compact('mko'));
    }
}
