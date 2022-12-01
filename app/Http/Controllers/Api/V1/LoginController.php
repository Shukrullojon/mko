<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login($params){
        $user = User::where('email', $params['params']['email'])->first();
        if($user and Hash::check($params['params']['password'], $user->password)){
            $user->token = Str::random(80);
            $user->save();
            return [
                'token' => $user->token
            ];
        }
        return [
            'error' => [
                'code'=>404,
                'message' => [
                    'uz' => "Foydalanuvchi topilmadi",
                    'ru' => "Пользователь не найден",
                    'en' => "User not found"
                ],
            ],
        ];

    }

}
