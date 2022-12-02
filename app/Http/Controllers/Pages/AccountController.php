<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Card;
use App\Services\Luhn;
use Illuminate\Http\Request;
use App\Models\Pages\Account;

class AccountController extends Controller
{
    public function index(Request $request){
        $accounts = Account::all();
        return view('pages.account.index', compact('accounts'));
    }

    public function add(){
        return view('pages.account.add');
    }
    public function createAccCard($owner) {
        $cardnew = new Luhn();
        $card =  $cardnew->run();
        if (!empty($card)){
            Card::create([
                'number' => $card['number'],
                'expire' => $card['expire'],
                'type' => 3,
                'owner' => $owner,
                'status' => 0,
            ]);
        }
        return $card['number'];
    }
}
