<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Brand;
use App\Models\Pages\Merchant;
use App\Services\MobileService;
use App\Services\TransactionService;
use Database\Seeders\BrandSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:brand.index'])->only('index');
        $this->middleware(['auth','permission:brand.add'])->only('add','store');
        $this->middleware(['auth','permission:brand.show'])->only('show');
        $this->middleware(['auth','permission:brand.edit'])->only('edit','update');
    }

    public function index(Request $request)
    {
        try {
            $brands = new Brand();
            if ($request->filled('brand_name'))
                $brands = $brands->where('name', 'LIKE', '%' . $request->brand_name . '%');
            if ($request->filled('status'))
                $brands = $brands->where('status', 'LIKE', '%' . $request->status . '%');
            $brands = $brands->orderBy('id', 'DESC')->paginate(20);
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
            'brand_name' => 'required',
            'status' => 'required',
            'is_unired' => 'required',
            'logo' => 'required|mimes:jpeg,png,jpg,svg',
        ]);
        if($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = $file->hashName();
            $destinationPath = public_path().'/images';
            $file->move($destinationPath, $file->hashName());
        }
        try {
            $brand = Brand::create([
                'name' => $request->brand_name,
                'logo' => asset('/').'/images/'.$fileName,
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
    public function show($id){
        $brand = Brand::find($id);
        return view('pages.brand.show', [
            'brand' => $brand,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id){
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
            'brand_name' => 'required',
            'status' => 'required',
            'is_unired' => 'required',
        ]);
        $brand = Brand::find($id);
        if($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = $file->hashName();
            $destinationPath = public_path() . '/images';
            $name = self::logo($brand->logo);
            if (file_exists(public_path('images/'.$name)))
                unlink(public_path('images/'.$name));
            $file->move($destinationPath, $fileName);
            $brand->logo = asset('/').'/images/'.$fileName;
        }

        $brand->name = $request->brand_name;
        $brand->status = $request->status;
        $brand->is_unired = $request->is_unired;
        $brand->update();
        return redirect()->route('brandShow', $brand->id);
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

    public static function logo($brand) {
        $e = explode('/', $brand);
        return end($e);
    }

}
