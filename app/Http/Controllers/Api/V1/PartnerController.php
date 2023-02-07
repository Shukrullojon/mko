<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Pages\Brand;
use App\Models\Pages\Merchant;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function get()
    {
        try {
            $brands = Brand::select("id", "name", "logo", "is_unired", "status")->where("status", 1)->get();
            return [
                'partners' => $brands,
            ];
        } catch (\Exception $exception) {
            return $this->errorException($exception);
        }
    }

    public function merchant($params)
    {
        try {
            $merchants = Merchant::where('brand_id', $params['params']['partner_id'])->where('status', 1)->get();
            $brand = Brand::find($params['params']['partner_id']);
            return [
                'merchants' => $merchants,
                'brand' => [
                    'name' => $brand->name,
                    'logo' => $brand->logo,
                ],
            ];
        } catch (\Exception $exception) {
            return $this->errorException($exception);
        }
    }

    public function errorException($exception)
    {
        return [
            'error' => [
                'code' => 500,
                'message' => [
                    'uz' => $exception->getMessage(),
                    'ru' => $exception->getMessage(),
                    'en' => $exception->getMessage(),
                ],
            ],
        ];
    }


}
