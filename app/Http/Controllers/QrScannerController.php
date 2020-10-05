<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrScannerController extends Controller
{
    function index()
    {
        return view('qrscanner');
    }
}
