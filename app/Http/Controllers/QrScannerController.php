<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\QrScan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrScannerController extends Controller
{
    function index()
    {
        return view('qrscanner');
    }

    function checkAuthorization($code)
    {
        $response = [];
        $a = Authorization::firstWhere('code', $code);
        if (!$a) {
            $response["status"] = "2";
            $response["message"] = "Código de autorización no es válido";
            return response()->json($response);
        }

        if ($a->expires_at < Carbon::now()) {
            QrScan::create([
                'authorization_id' => $a->id,
                'authorized' => 0,
                'scanned_by' => Auth::user()->name,
            ]);
            $response["status"] = "3";
            $response["message"] = "Autorización ha expirado";
            $response["name"] = $a->user->name;
            return response()->json($response);
        }

        QrScan::create([
            'authorization_id' => $a->id,
            'authorized' => 1,
            'scanned_by' => Auth::user()->name,
        ]);
        $response["status"] = "1";
        $response["message"] = "Acceso concedido";
        $response["name"] = $a->user->name;
        return response()->json($response);
    }
}
