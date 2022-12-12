<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Brand;
use App\Models\Pages\Merchant;
use App\Services\MobileService;
use Database\Seeders\BrandSeeder;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            $brands = new Brand();
            if ($request->filled('name'))
                $brands = $brands->where('name', 'LIKE', '%' . $request->name . '%');
            if ($request->filled('logo'))
                $brands = $brands->where('logo', 'LIKE', '%' . $request->logo . '%');
            if ($request->filled('status'))
                $brands = $brands->where('status', 'LIKE', '%' . $request->status . '%');
            if (!(auth()->user()->hasRole('Super Admin')))
                $brands = $brands->where('id', auth()->user()->brand_id);
            $brands = $brands->latest()->paginate(10);

            return view('pages.brand.index', compact('brands'));
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
        return view('pages.brand.add');
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
            'name' => 'required',
            'logo' => 'required',
            'status' => 'required',
            'is_unired' => 'required',
        ]);


        // Get reference to uploaded image
        $request->validate([
            'logo.*' => 'mimes:pdf,jpeg,png,jpg,svg',
        ]);
//        dd($request->file('logo'));
        if($request->hasFile('logo')) {

            $file = $request->file('logo');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images';
            $file->move($destinationPath, $fileName);
//            return redirect('/uploadfile');
        }
        try {
            $brand = Brand::create([
                'name' => $request->name,
                'logo' => $fileName,
                'status' => $request->status,
                'is_unired' => $request->is_unired,
            ]);
            return redirect()->route('brandShow', $brand->id);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);
        return view('pages.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('pages.brand.edit', compact('brand'));
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
        $this->validate($request, [
            'name' => 'required',
            'logo' => 'required',
            'status' => 'required',
            'is_unired' => 'required',
        ]);

        // Get reference to uploaded image
        $request->validate([
            'logo.*' => 'mimes:pdf,jpeg,png,jpg,svg',
        ]);
//        dd($request->file('logo'));
        if($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images';
            $file->move($destinationPath, $fileName);
//            return redirect('/uploadfile');
        }

        $brand = Brand::where('id', $id)->first();
        $brand->update([
            'name' => $request->name,
            'logo' => $request->logo,
            'status' => $request->status,
            'is_unired' => $request->is_unired,
        ]);
        return redirect()->route('brandShow', $brand->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
    }

    public function getBrand(Request $request)
    {
        $brandId =  $request->brandId;
        $merchants = Merchant::where('brand_id', $brandId)->get();
        $options = ["<option value='0'>null</option>"];
        foreach ($merchants as $merchant){
            $option = "<option value='$merchant->id'>".$merchant->name."</option>";
            $options[] = $option;
        }
        return $options;
    }
}
