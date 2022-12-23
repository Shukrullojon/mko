<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $card = Card::where('type',3)->first();
        $accountItUnisoft = Account::where('type',3)->first();
        $accountMko = Account::where('type',4)->first();
        return view('pages.home.index',[
            'card' => $card,
            'accountItUnisoft' => $accountItUnisoft,
            'accountMko' => $accountMko,
        ]);

        $is_role_exists = DB::select("SELECT COUNT(*) as cnt FROM `model_has_roles` WHERE model_id = ".auth()->id());
        if ($is_role_exists[0]->cnt)
            return view('pages.dashboard');
        else
            return view('welcome');
	}

    public function transaction(){
        $service = TransactionService::transaction();
        dd($service);
    }
}
