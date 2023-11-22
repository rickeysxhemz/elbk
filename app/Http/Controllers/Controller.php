<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
  
class Controller extends BaseController
{
    public function respondWithToken($token, $phone)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'phone' => $phone,
            'expires_in' => null
        ], 200);
    }
}