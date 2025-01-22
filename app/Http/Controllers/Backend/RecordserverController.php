<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Websocket;
use Illuminate\Http\Request;

class RecordserverController extends Controller
{
    public function websocketerror(Request $request){
        $type = $request->input('type');
        $message = $request->input('message');
        $timestamp = $request->input('timestamp');

        Websocket::create([
            'type' => $type ?? null,
            'message' => $message ?? null,
            'timestamp' => $timestamp ?? null
        ]);

    }
}
