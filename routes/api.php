<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\Pages\BrandController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('/v1/gw','\App\Http\Controllers\Api\V1\MainController@index');

# Api Clients
Route::post('/login',[ApiAuthController::class,'login']);

Route::group(['middleware' => 'api-auth'],function (){
    Route::post('/me',[ApiAuthController::class,'me']);
    Route::post('/tokens',[ApiAuthController::class,'getAllTokens']);
    Route::post('/logout',[ApiAuthController::class,'logout']);
});

Route::group(['middleware' => 'ajax.check'],function (){
    Route::post('/api-user/toggle-status/{user_id}',[ApiUserController::class,'toggleUserActivation']);
    Route::post('/api-token/toggle-status/{token_id}',[ApiUserController::class,'toggleTokenActivation']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/account/createAccCard', 'AccountController@createAccCard')->name('createAccCard');
Route::post('/getBrand', [BrandController::class, 'getBrand'])->name('getBrand');

Route::any('graphic',function (\Illuminate\Http\Request $request){
    $resp = new \App\Http\Controllers\Api\ResponseController();
    $v = $resp->validate($request->all(),[
        'card' => 'required|size:16'
    ]);

    if ($v !== true) return $v;

    $card = \App\Models\Pages\Card::where('number',$request->card)
        ->with(['client' => function($query){
            return $query->with(['transactions' => function($q){
                return $q->with('merchant');
            }]);
        }])
        ->first();

    if (is_null($card))
        return $resp::errorResponse("Card not found");
    $graphic = [];
    if (isset($card->client->transactions)){
        foreach ($card->client->transactions as $payment) {
            $amount = ceil(($payment->percentage * $payment->amount)/100) + $payment->amount;
            $list = get_graphic($payment->period,$payment->percentage,$payment->amount);
            foreach ($list as $item) {
                if (!isset($graphic[$item['month']])){
                    $graphic[$item['month']]['month'] = $item['month'];
                    $graphic[$item['month']]['amount'] = 0;
                    $graphic[$item['month']]['paid_amount'] = 0;
                    $graphic[$item['month']]['debit_amount'] = 0;
                    $graphic[$item['month']]['details'] = [];
                }

                $graphic[$item['month']]['amount'] += intval($item['amount']);
                $graphic[$item['month']]['details'][] = [
                    'transaction_id' => $payment->tr_id,
                    'transaction_amount' => $amount,
                    'transaction_date' => $payment->date,
                    'transaction_period' => $payment->period,
                    'merchant' => [
                        'name' => $payment->merchant->name,
                        'address' => $payment->merchant->address,
                        'key' => $payment->merchant->key,
                    ],
                    'amount' => $item['amount'],
                    'debit_amount' => 0,
                    'paid_amount' => 0
                ];
            }
        }
    }
    return $resp::successResponse($graphic);

});
