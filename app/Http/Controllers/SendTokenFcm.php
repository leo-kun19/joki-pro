<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

   /**class SendTokenFcm extends Controller
{
 
     * Handle the incoming request.
     
public function __invoke(Request $request)
{
    $request->validate([
        'token_fcm' => 'required|string',
    ]);

    $user = $request->user(); // user terautentikasi
    $user->update([
        'fcm_token' => $request->token_fcm,
    ]);

    return response()->json([
        'message' => 'FCM token berhasil disimpan.',
    ]);
}
}*/

// app/Http/Controllers/SendTokenFcm.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendTokenFcm extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->fcm_token = $request->token_fcm;
        $user->save();

        return response()->json(['message' => 'FCM Token saved']);
    }
}
