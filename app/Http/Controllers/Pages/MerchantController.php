<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Card;
use App\Models\Pages\Merchant;
use App\Services\Luhn;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $merchants = new Merchant();
            if($request->filled('number'))
                $merchants = $merchants->where('number','LIKE','%'.$request->number.'%');
            if($request->filled('inn')){
                $merchants = $merchants->where('inn','LIKE','%'.$request->inn.'%');
            }
            if($request->filled('name'))
                $merchants = $merchants->where('name','LIKE','%'.$request->name.'%');
            if($request->filled('percentage'))
                $merchants = $merchants->where('percentage','LIKE','%'.$request->percentage.'%');
            if($request->filled('filial'))
                $merchants = $merchants->where('filial','LIKE','%'.$request->filial.'%');
            $merchants = $merchants->latest()->paginate(2);
            return view('pages.merchant.index', compact('merchants'));
        }catch(\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function add()
    {
        return view('pages.merchant.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'name' => 'required',
            'filial' => 'required',
            'address' => 'required',
            'number' => 'required',
            'account_name' => 'required',
            'account_inn' => 'required',
            'account_filial' => 'required',
            'percentage' => 'required',
        ]);
        try{
            $merchant = DB::transaction(function() use ($request){
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
                    'inn' => $request->account_inn,
                    'name' => $request->account_name,
                    'filial' => $request->account_filial,
                    'card_id' => $card->id,
                    'percentage' => $request->percentage,
                ]);

                $merchant = Merchant::create([
                    'brand_id' => $request->brand_id,
                    'name' => $request->name,
                    'key' => Str::uuid(),
                    'filial' => $request->filial,
                    'address' => $request->address,
                    'account_id' => $account->id,
                    'uzcard_merchant_id' => $request->uzcard_merchant_id,
                    'uzcard_terminal_id' => $request->uzcard_terminal_id,
                    'humo_merchant_id' => $request->humo_merchant_id,
                    'humo_terminal_id' => $request->humo_terminal_id,
                    'is_register_humo' => 0,
                    'is_register_uzcard' => 0,
                ]);
                return $merchant;
            });
            return redirect()->route('merchantShow',$merchant->id);
        }catch(\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }

        return redirect()->route('merchantShow', $merchant->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $merchant = Merchant::find($id);
        return view('pages.merchant.show', compact('merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
