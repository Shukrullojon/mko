<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Brand;
use App\Models\Pages\Card;
use App\Models\Pages\Merchant;
use App\Models\Pages\MerchantPeriod;
use App\Models\Pages\MerchantPeriodHistory;
use App\Models\Pages\MerchantTerminal;
use App\Models\Pages\Payment;
use App\Services\Luhn;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        try {
            $merchants = new Merchant();
            if ($request->filled('merchant_name'))
                $merchants = $merchants->where('name', 'LIKE', '%' . $request->merchant_name . '%');
            if ($request->filled('filial'))
                $merchants = $merchants->where('filial', 'LIKE', '%' . $request->filial . '%');
            if ($request->filled('merchant_address'))
                $merchants = $merchants->where('address', 'LIKE', '%' . $request->merchant_address . '%');

            if (!(auth()->user()->hasRole('Super Admin')) and auth()->user()->merchant_id == null)
                $merchants = $merchants->where('brand_id', auth()->user()->brand_id);
            if (!(auth()->user()->hasRole('Super Admin')) and auth()->user()->merchant_id != null)
                $merchants = $merchants->where('brand_id', auth()->user()->brand_id)
                    ->where('id', auth()->user()->merchant_id);
            $merchants = $merchants->orderBy('id', 'DESC')->paginate(5);
            return view('pages.merchant.index', compact('merchants'));
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function add()
    {
        $brands = Brand::get();
        return view('pages.merchant.add', [
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'brand_name' => 'required',
            'merchant_name' => 'required',
            'filial' => 'required',
            'merchant_address' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'account_inn' => 'required',
            'account_filial' => 'required',
            'percentage' => 'required',
            'merchant' => 'required',
            'terminal' => 'required',
        ]);
        try {
            $merchant = DB::transaction(function () use ($request) {

                $cardnew = new Luhn();
                $card = $cardnew->run();
                $card = Card::create([
                    'number' => $card['number'],
                    'expire' => $card['expire'],
                    'type' => 1,
                    'balance' => 0,
                    'hold_amount' => 0,
                    'owner' => substr($request->name, 0, 100),
                    'token' => Str::random(70),
                    'status' => 1,
                ]);
                $account = Account::create([
                    'type' => 1,
                    'number' => $request->account_number,
                    'inn' => $request->account_inn,
                    'name' => $request->account_name,
                    'filial' => $request->account_filial,
                    'card_id' => $card->id,
                    'percentage' => $request->percentage,
                ]);

                $merchant = Merchant::create([
                    'brand_id' => $request->brand_name,
                    'name' => $request->merchant_name,
                    'key' => Str::uuid(),
                    'filial' => $request->filial,
                    'address' => $request->merchant_address,
                    'account_id' => $account->id,
                    'uzcard_merchant_id' => $request->uzcard_merchant_id,
                    'uzcard_terminal_id' => $request->uzcard_terminal_id,
                    'humo_merchant_id' => $request->humo_merchant_id,
                    'humo_terminal_id' => $request->humo_terminal_id,
                    'is_register_humo' => 0,
                    'is_register_uzcard' => 0,
                ]);

                $merchantTerminal = MerchantTerminal::create([
                    'merchant_id' => $merchant->id,
                    'merchant' => $request->merchant,
                    'terminal' => $request->terminal,
                    'balance' => 0,
                    'status' => 1,
                ]);

                foreach ($request->periods as $row) {
                    if ($row['merchant_period'] and $row['merchant_percentage']) {
                        MerchantPeriod::create([
                            'merchant_id' => $merchant->id,
                            'period' => $row['merchant_period'],
                            'percentage' => $row['merchant_percentage'],
                            'status' => 1,
                        ]);
                    }
                }
                foreach ($request->periods as $row) {
                    if ($row['merchant_period'] and $row['merchant_percentage']) {
                        MerchantPeriodHistory::create([
                            'merchant_id' => $merchant->id,
                            'period' => $row['merchant_period'],
                            'percentage' => $row['merchant_percentage']
                        ]);
                    }
                }

                return $merchant;
            });
            return redirect()->route('merchantShow', $merchant->id);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('merchantShow', $merchant->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merchant = Merchant::find($id);
        $brands = Brand::all();
        $terminal = MerchantTerminal::where('merchant_id', $id)->first();
        $periods = MerchantPeriod::where('merchant_id', $id)->get();
        return view('pages.merchant.edit', [
            'merchant' => $merchant,
            'brands' => $brands,
            'terminal' => $terminal,
            'periods' => $periods
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        Validator::make($request->all(), [
            "merchant" => "required|string",
            "terminal" => "required|string",
            "brand_name" => "required|string",
            "merchant_name" => "required|string",
            "filial" => "required|number",
            "merchant_address" => "required|string",
            "account_number" => "required|number",
            "account_name" => "required|string",
            "account_inn" => "required|number",
            "account_filial" => "required|number",
            "percentage" => "required|number",
            "uzcard_merchant_id" => "required|string",
            "uzcard_terminal_id" => "required|string",
            "humo_merchant_id" => "required|string",
            "humo_terminal_id" => "required|string",
            "periods" => "required|array",
        ]);
//        dd($request->all(), $id);
        $merchant = DB::transaction(function () use ($request, $id) {
            $merchant = Merchant::where('id', $id)->first();
            $account = Account::where('number', $request->account_number)->where('inn', $request->account_inn)->first();

            $merchant->update([
                'brand_id' => $request->brand_name,
                'name' => $request->merchant_name,
                'filial' => $request->filial,
                'address' => $request->merchant_address,
//                'account_id' => $account->id??null,
                'uzcard_merchant_id' => $request->uzcard_merchant_id,
                'uzcard_terminal_id' => $request->uzcard_terminal_id,
                'humo_merchant_id' => $request->humo_merchant_id,
                'humo_terminal_id' => $request->humo_terminal_id,
                'is_register_humo' => 1,
                'is_register_uzcard' => 1,
            ]);
            $account->update([
                'number' => $request->account_number,
                'inn' => $request->account_inn,
                'name' => $request->account_name,
                'filial' => $request->account_filial
            ]);
            $merchantTerminal = MerchantTerminal::where('merchant_id', $id)->first();
            $merchantTerminal->update([
                'merchant' => $request->merchant,
                'terminal' => $request->terminal,
            ]);
            $period1 = MerchantPeriod::where('merchant_id', $id)->get();
            foreach ($request->periods as $per) {
                MerchantPeriod::create([
                    'period' => $per['merchant_period'],
                    'percentage' => $per['merchant_percentage'],
                    'merchant_id' => $id,
                    'status' => 1
                ]);
            }
        });
        return redirect()->route('merchantShow', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $merchant = Merchant::find($id);
        $payments = Payment::where('merchant_id', $id)->get();
        foreach ($payments as $payment) {
            $payment->delete();
        }
        $merchant->delete();
        return back();
    }
}
