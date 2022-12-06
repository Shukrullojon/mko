<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Merchant;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
