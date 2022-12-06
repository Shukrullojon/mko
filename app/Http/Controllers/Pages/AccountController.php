<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Card;
use App\Services\Luhn;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use App\Models\Pages\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(Request $request){
//        $service = TransactionService::transaction();
        try{
            $accounts = new Account();
            if($request->filled('number'))
                $accounts = $accounts->where('number','LIKE','%'.$request->number.'%');
            if($request->filled('inn')){
                $accounts = $accounts->where('inn','LIKE','%'.$request->inn.'%');
            }
            if($request->filled('name'))
                $accounts = $accounts->where('name','LIKE','%'.$request->name.'%');
            if($request->filled('percentage'))
                $accounts = $accounts->where('percentage','LIKE','%'.$request->percentage.'%');
            if($request->filled('filial'))
                $accounts = $accounts->where('filial','LIKE','%'.$request->filial.'%');
            $accounts = $accounts->latest()->paginate(2);
            return view('pages.account.index', compact('accounts'));
        }catch(\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }
    }

    public function add(){
        return view('pages.account.add');
    }

    public function store(Request $request){
        $this->validate($request,[
            'number' => 'required|unique:accounts',
            'name' => 'required',
            'inn' => 'required',
            'filial' => 'required',
            'percentage' => 'required',
        ]);

        try{
            $account = DB::transaction(function() use ($request){
                $cardnew = new Luhn();
                $card =  $cardnew->run();
                $card = Card::create([
                    'number' => $card['number'],
                    'expire' => $card['expire'],
                    'type' => 1,
                    'balance' => 0,
                    'hold_amount' => 0,
                    'owner' => substr($request->name,0,100),
                    'token' => Str::random(70),
                    'status' => 1,
                ]);
                $account = Account::create([
                    'type' => 1,
                    'number' => $request->number,
                    'inn' => $request->inn,
                    'name' => $request->name,
                    'filial' => $request->filial,
                    'card_id' => $card->id,
                    'percentage' => $request->percentage,
                ]);
                return $account;
            });
            return redirect()->route('accountShow',$account->id);
        }catch(\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }
    }

    public function show($id){
        try{
            $account = Account::find($id);
            return view('pages.account.show',[
                'account' => $account,
            ]);
        }catch(\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }
    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
