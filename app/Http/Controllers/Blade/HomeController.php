<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Pages\Card;
use App\Models\Pages\Client;
use App\Models\Pages\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $mko = Card::where('type', 3)->first();
            $histories = new History();
            $info = History::select(
                DB::raw("sum(debit) as debit"),
                DB::raw("sum(credit) as credit")
            )->first();
            if ($request->dtAcc)
                $histories = $histories->where('dtAcc', 'LIKE', "%$request->dtAcc%");
            if ($request->ctAcc)
                $histories = $histories->where('ctAcc', 'LIKE', "%$request->ctAcc%");
            if ($request->date)
                $histories = $histories->where('date', date("d.m.Y",strtotime($request->date)));
            $limit = Client::select(DB::raw("sum(`limit`) as `limit`"))->where('status',1)->first();
            $histories = $histories->orderBy('id', 'DESC')->paginate(20);
            return view('pages.home.index', [
                'mko' => $mko,
                'histories' => $histories,
                'info' => $info,
                'limit' => $limit,
            ]);
        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
	}

    public function show($id){
        $history = History::find($id);
        return view('pages.home.show', compact('history'));
    }

}
