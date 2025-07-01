<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::post('/test-fcm', function (Request $request) {
    // Validasi input
    $request->validate([
        'device_token' => 'required',
        'title' => 'required',
        'body' => 'required'
    ]);

    $serverKey = 'YOUR_SERVER_KEY';
    
 $data = [
        "to" => $request->device_token,
        "notification" => [
            "title" => $request->title,
            "body" => $request->body,
            "icon" => "https://example.com/icon.png", // Opsional
            "click_action" => "https://example.com" // Opsional
        ],
        "data" => [ // Data tambahan (opsional)
            "type" => "promo",
            "id" => "123"
        ]
    ];

    $response = Http::withHeaders([
        'Authorization' => 'key=' . $serverKey,
        'Content-Type' => 'application/json',
    ])->post('https://fcm.googleapis.com/fcm/send', $data);

    return response()->json([
        'status' => $response->successful() ? 'success' : 'error',
        'response' => $response->json()
    ]);
});
Route::middleware('auth:sanctum')->post('/save-fcm-token', SendTokenFcm::class);
?>