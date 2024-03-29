<?php

namespace App\Http\Controllers\Pages;

use App\Exports\ExportMerchant;
use App\Gateway\MerchantGateway;
use App\Http\Controllers\Controller;
use App\Models\Pages\Account;
use App\Models\Pages\Brand;
use App\Models\Pages\Card;
use App\Models\Pages\Merchant;
use App\Models\Pages\MerchantPeriod;
use App\Models\Pages\MerchantPeriodHistory;
use App\Models\Pages\MerchantTerminal;
use App\Models\Pages\Payment;
use App\Services\AbsService;
use App\Services\Luhn;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:merchant.index'])->only('index');
        $this->middleware(['auth','permission:merchant.show'])->only('show');
        $this->middleware(['auth','permission:merchant.add'])->only('add','store');
    }

    public function index(Request $request)
    {
        try {
            $merchants = new Merchant();
            $brands = Brand::all();
            if ($request->filled('status'))
                $merchants = $merchants->where('status', $request->status);
            if ($request->filled('brand_id'))
                $merchants = $merchants->where('brand_id', $request->brand_id);
            if ($request->filled('merchant_name'))
                $merchants = $merchants->where('name', 'LIKE', '%' . $request->merchant_name . '%');
            if ($request->filled('filial'))
                $merchants = $merchants->where('filial', 'LIKE', '%' . $request->filial . '%');
            if ($request->filled('merchant_address'))
                $merchants = $merchants->where('address', 'LIKE', '%' . $request->merchant_address . '%');

            $merchants = $merchants->with('brand:id,name')->orderBy('id', 'DESC')->paginate(20);

            return view('pages.merchant.index', [
                'merchants' => $merchants,
                'brands' => $brands,
            ]);
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
        $this->validate($request, [
            'brand_id' => 'required',
            //'merchant_name' => 'required',
            'filial' => 'required',
            'merchant_address' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'account_inn' => 'required',
            'account_filial' => 'required',
            /*'percentage' => 'required',
            'merchant' => 'required',
            'terminal' => 'required',*/
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
                    'owner' => substr($request->filial, 0, 100),
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
                    'brand_id' => $request->brand_id,
                    'key' => Str::uuid(),
                    'name' => "",
                    'filial' => $request->filial,
                    'address' => $request->merchant_address,
                    'account_id' => $account->id,
                    /*'uzcard_merchant_id' => $request->uzcard_merchant_id,
                    'uzcard_terminal_id' => $request->uzcard_terminal_id,
                    'humo_merchant_id' => $request->humo_merchant_id,
                    'humo_terminal_id' => $request->humo_terminal_id,
                    'is_register_humo' => 0,
                    'is_register_uzcard' => 0,*/
                    'status' => $request->status,
                ]);
                $merchantTerminal = MerchantTerminal::create([
                    'merchant_id' => $merchant->id,
                    'merchant' => str_replace(" ", "", $request->filial) . $merchant->id,
                    'terminal' => str_replace(" ", "", $request->filial) . $merchant->id,
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
                return $merchant;
            });

            MerchantGateway::send($merchant->id);
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
        return view('pages.merchant.show', [
            'merchant' => Merchant::findOrFail($id)
        ]);
        /* $merchant = Merchant::find($id);
        return view('pages.merchant.show', compact('merchant')); */
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
        Validator::make($request->all(), [
            "brand_id" => "required|string",
            //"merchant_name" => "required|string",
            "filial" => "required|number",
            "merchant_address" => "required|string",
            "account_number" => "required|number",
            "account_name" => "required|string",
            "account_inn" => "required|number",
            "account_filial" => "required|number",
            "periods" => "required|array",
        ]);

        $merchant = DB::transaction(function () use ($request, $id) {
            $merchant = Merchant::where('id', $id)->first();
            $account = Account::where('id', $merchant->account->id)->first();

            $merchant->update([
                'brand_id' => $request->brand_id,
                'filial' => $request->filial,
                'address' => $request->merchant_address,
                'status' => $request->status,
            ]);

            $account->update([
                'number' => $request->account_number,
                'inn' => $request->account_inn,
                'name' => $request->account_name,
                'filial' => $request->account_filial
            ]);

            foreach ($request->periods as $per) {

                if(isset($per['merchant_period_id']) and $per['merchant_period_id']){
                    MerchantPeriod::where('id',$per['merchant_period_id'])->update([
                        'merchant_id' => $id,
                        'period' => $per['merchant_period'],
                        'percentage' => $per['merchant_percentage'],
                        'status' => 1
                    ]);
                }else{
                    MerchantPeriod::Create([
                        'merchant_id' => $id,
                        'period' => $per['merchant_period'],
                        'percentage' => $per['merchant_percentage'],
                        'status' => 1
                    ]);
                }
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

    public function getAccountDetails(Request $request)
    {
        $abs = AbsService::getAccountDetails([
            'account' => $request->account
        ]);
        if ($abs['status'])
            return [
                'status' => true,
                'data' => $abs['data']['responseBody']
            ];
        else
            return [
                'status' => false,
            ];

    }

    public function removeMerchant(Request $request)
    {
        if ($request->period_id) {
            $period = MerchantPeriod::find($request->period_id);
            MerchantPeriodHistory::create([
                'merchant_id' => $period->merchant_id,
                'period' => $period->period,
                'percentage' => $period->percentage,
            ]);
            $period->delete();
            return back()->with('success', 'Successfully deleted');
        } else {
            return back()->with('error', 'Could not be deleted');
        }
    }

    public function download($key){
        QrCode::format('png')->size(250)->generate($key, public_path('images/'.$key.'.png') );
        return response()->download(public_path('images\\'.$key.'.png'));
    }
    public function exportMerchant() {
        return Excel::download(new ExportMerchant(), 'Мерчанты.xlsx');
    }
}
